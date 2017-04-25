<?php

namespace app\finance\controllers;

use Yii;
use app\finance\models\BillingOutstanding;
use app\finance\models\BillingOutstandingSearch;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class BillingOutstandingController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'delete' => ['test'],
//                    CreateInvoice
                ],
            ],
        ];
    }
    
    public function actionIndex() {
        $searchModel = new BillingOutstandingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionOutstandingDetailByCustomer($cusid) {
        
        $dataProvider = $this->findModelBillDetailByCustomer($cusid);
        $modelBillingH = new \app\finance\models\BillingH();
        
        return $this->render('outstandingdetailcustomer', [
            'dataProvider' => $dataProvider,
//            'modelBillingH'=> $modelBillingH
        ]);
    }
    
    public function actionOutstandingDetailByArea($cusid,$area,$period,$tipe)    {
        $dataProvider = $this->findModelBillDetailByArea($cusid,$area,$period,$tipe);
        
        return $this->render('outstandingdetailarea', [
            'dataProvider' => $dataProvider,
        ]);
    }
        
    public function actionCreate() {
        $model = new BillingOutstanding();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->BillingNo]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    protected function findModel($id) {
        if (($model = BillingOutstanding::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelBillDetailByCustomer($cusid)    {
        $query = new \yii\db\Query();        
        $query->select('bo.TipeBilling,
                        bo.SODID,
                        bo.CustomerID,
                        mc.CustomerName,
                        bo.AreaID,
                        ma.Description AreaName,
                        bo.Periode')
                ->from('BillingOutstanding bo')
                ->distinct(true)
                ->leftJoin('MasterCustomer mc','mc.CustomerID=bo.CustomerID')
                ->leftJoin('MasterArea ma','ma.AreaID=bo.AreaID')
                ->where(['bo.IsBilling' => 0,'bo.CustomerID'=>$cusid])
                ->orderBy('bo.TipeBilling','bo.CustomerID');

        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $dataProvider;
    }
    
    protected function findModelBillDetailByArea($cusid,$area,$period,$tipe) {
        $query = new \yii\db\Query();        
        $query->select('bo.BillingNo,
                        bo.SeqProduct,
                        DPP,
                        MgmFee,
                        PPN,
                        PPH23,
                        TotalInvoice,
                        gl.ProductID,
                        mp.Nama
                        ')
                ->from('BillingOutstanding bo')
                ->leftJoin('SOD sd','sd.SODID = bo.SODID')
                ->leftJoin('GoLiveProduct gl','gl.SODID = sd.SODID and bo.SeqProduct = gl.SeqProduct')
                ->leftJoin('MasterProduct mp','mp.ProductID = gl.ProductID')
                ->where(['bo.IsBilling' => 0,
                        'bo.CustomerID'=>$cusid,
                        'bo.AreaID' => $area,
                        'bo.Periode'=>$period,
                        'bo.TipeBilling'=>$tipe]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $dataProvider;
    }
    public function actionCreateInvoice(){
//        echo var_dump(Yii::$app->request->post());
//        die();
        $customerID = Yii::$app->request->post('customerID','xxx');
        $userid = Yii::$app->user->identity->username;
        $tglcrt=date('Y-m-d H:i:s');
        
        if(Yii::$app->request->post('selection_all') != null){
            Yii::$app->db->createCommand('exec CreateBillingPerCustomer \''.$customerID.'\',\''.$userid.'\'')->execute();
            Yii::$app->getSession()->setFlash('success', 'Create invoice sukses');
        }else if(Yii::$app->request->post('selection') != null){
            $period=date('Ym');
            $invoiceID=Yii::$app->db->createCommand("select 'INV' + '".$period."' + right('0000000000' + CAST(CAST(ISNULL(MAX(RIGHT(InvoiceNo,11)),'0') as bigint) + 1  as varchar(11)),11)
                    from Invoice where SUBSTRING(InvoiceNo,4,6)='".$period."'")->queryScalar();
            $nofak = Yii::$app->db->Createcommand("SELECT min(NoFakturPajak) FROM FakturPajakD where InvoiceNo is null")->queryScalar();
            $transaction = Yii::$app->db->beginTransaction();
            // create BillingH
            Yii::$app->db->createCommand("exec sys.sp_executesql 
                    N'insert into Invoice(InvoiceNo,InvoiceDate,CustomerID,TotalDPP,TotalMFee,TotalPPN,TotalPPH23,TotalInvoice,KodeFaktur,NoFakturPajak,Status,UserCrt,DateCrt)
			values(@InvoiceNo,@InvoiceDate,@CustomerID,@TotalDPP,@TotalMFee,@TotalPPN,@TotalPPH23,@TotalInvoice,@KodeFaktur,@NoFakturPajak,@Status,@UserCrt,@DateCrt)',
                    N'@InvoiceNo varchar(20),
                    @InvoiceDate date,
                    @CustomerID varchar(20),
                    @TotalDPP decimal(21,2),
                    @TotalMFee decimal(21,2),
                    @TotalPPN decimal(21,2),
                    @TotalPPH23 decimal(21,2),
                    @TotalInvoice decimal(21,2),
                    @KodeFaktur varchar(3),
                    @NoFakturPajak varchar(50),
                    @Status varchar(3),
                    @UserCrt varchar(50),
                    @DateCrt datetime',
                    '$invoiceID','".date('Y-m-d')."','$customerID',0,0,0,0,0,'040','$nofak','N','$userid','$tglcrt'
                ")->execute();
            try{
                foreach(Yii::$app->request->post('selection') as $valdata) {
                    $newdata = explode('|',$valdata);
                    // Create billingD
                    Yii::$app->db->createCommand("exec sys.sp_executesql 
                        N' exec CreateBillingDetail @invoiceNo,@CustomerID,@areaid,@TipeBilling,@Periode,@userid',
                            N'@invoiceNo varchar(20),
                            @CustomerID varchar(20),
                            @areaid varchar(8),
                            @TipeBilling varchar(3),
                            @Periode varchar(6),
                            @userid varchar(50)', 
                            '$invoiceID','$customerID','$newdata[1]','$newdata[0]','$newdata[2]','$userid'
                    ")->execute();
                }
                // setelah selesai insert masing2 billingD, melakukan Total amount di BillingH sekaligus memasukkan faktur pajak jika dikenai MGMFee
                Yii::$app->db->createCommand("exec sys.sp_executesql 
                        N'exec UpdateBillingHSummary @invoiceNo,@userid',
                            N'@invoiceNo varchar(20),
                            @userid varchar(50)', 
                            '$invoiceID','$userid'
                    ")->execute();
                
                $transaction->commit();
                Yii::$app->getSession()->setFlash('success', 'Create invoice sukses');
            }catch (Exception $ex) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }catch(\yii\db\Exception $ex){
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }
        }else{
            Yii::$app->getSession()->setFlash('info', 'Tidak Ada data yang diproses');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionCreateInvoiceProduct(){
        $customerID = Yii::$app->request->get('cust','xxx');
        $area = Yii::$app->request->get('area','xxx');
        $period = Yii::$app->request->get('periode','xxx');
        $tipe = Yii::$app->request->get('tipe','xxx');
        $userid = Yii::$app->user->identity->username;
        $tglcrt=date('Y-m-d H:i:s');

        if(Yii::$app->request->post('selection_all') != null){
            Yii::$app->db->createCommand('exec CreateBillingPerTipePeriod \''.$customerID.'\',\''.$tipe.'\',\''.$period.'\',\''.$userid.'\'')->execute();
            Yii::$app->getSession()->setFlash('success', 'Create invoice sukses');
        }else if(Yii::$app->request->post('selection') != null){
            $invoiceID=Yii::$app->db->createCommand("select 'INV' + '".$period."' + right('0000000000' + CAST(CAST(ISNULL(MAX(RIGHT(InvoiceNo,11)),'0') as bigint) + 1  as varchar(11)),11)
                    from BillingH where SUBSTRING(InvoiceNo,4,6)='".$period."'")->queryScalar();
            $nofak = Yii::$app->db->Createcommand("SELECT min(NoFakturPajak) FROM FakturPajakD where InvoiceNo is null")->queryScalar();
            $transaction = Yii::$app->db->beginTransaction();
            // create BillingH
            Yii::$app->db->createCommand("exec sys.sp_executesql 
                    N'insert into BillingH(InvoiceNo,InvoiceDate,CustomerID,TotalDPP,TotalMFee,TotalPPN,TotalPPH23,TotalInvoice,KodeFaktur,NoFakturPajak,Status,UserCrt,DateCrt)
			values(@InvoiceNo,@InvoiceDate,@CustomerID,@TotalDPP,@TotalMFee,@TotalPPN,@TotalPPH23,@TotalInvoice,@KodeFaktur,@NoFakturPajak,@Status,@UserCrt,@DateCrt)',
                    N'@InvoiceNo varchar(20),
                    @InvoiceDate date,
                    @CustomerID varchar(20),
                    @TotalDPP decimal(21,2),
                    @TotalMFee decimal(21,2),
                    @TotalPPN decimal(21,2),
                    @TotalPPH23 decimal(21,2),
                    @TotalInvoice decimal(21,2),
                    @KodeFaktur varchar(3),
                    @NoFakturPajak varchar(50),
                    @Status varchar(3),
                    @UserCrt varchar(50),
                    @DateCrt datetime',
                    '$invoiceID','".date('Y-m-d')."','$customerID',0,0,0,0,0,'040','$nofak','N','$userid','$tglcrt'
                ")->execute();
            try{
                foreach(Yii::$app->request->post('selection') as $valdata) {
//                    $newdata = explode('|',$valdata);
                    // Create billingD
                    Yii::$app->db->createCommand("exec sys.sp_executesql 
                        N' exec CreateBillingDetailProduct @invoiceNo,@CustomerID,@billno,@userid',
                            N'@invoiceNo varchar(20),
                            @CustomerID varchar(20),
                            @billno varchar(20),
                            @userid varchar(50)', 
                            '$invoiceID','$customerID','$valdata','$userid'
                    ")->execute();
                }
                // setelah selesai insert masing2 billingD, melakukan Total amount di BillingH sekaligus memasukkan faktur pajak jika dikenai MGMFee
                Yii::$app->db->createCommand("exec sys.sp_executesql 
                        N'exec UpdateBillingHSummary @invoiceNo,@userid',
                            N'@invoiceNo varchar(20),
                            @userid varchar(50)', 
                            '$invoiceID','$userid'
                    ")->execute();
                
                $transaction->commit();
                Yii::$app->getSession()->setFlash('success', 'Create invoice sukses');
            }catch (Exception $ex) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }catch(\yii\db\Exception $ex){
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }
        }else{
            Yii::$app->getSession()->setFlash('info', 'Tidak Ada data yang diproses');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    }
