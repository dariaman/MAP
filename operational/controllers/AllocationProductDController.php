<?php

namespace app\operational\controllers;

use Yii;
//use app\operational\models\JadwalGolive;
use app\operational\models\AllocationProductD;
use app\master\models\MasterProduct;
use app\operational\models\AllocationProductDSearch;
//use app\operational\models\AllocationProductDOutstanding;
use app\operational\models\TransactionMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\date\DatePicker;

/**
 * AllocationProductDController implements the CRUD actions for AllocationProductD model.
 */
class AllocationProductDController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'del' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AllocationProductD models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AllocationProductDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllocationProductD model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionChangeProduct($id)
    {
        return $this->render('changeproduct', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionChangeGoLive()
    {
        $model = new AllocationProductD();
        
        if($model->load(Yii::$app->request->post()))
        {
            $aph = Yii::$app->request->post('idaph');
            $apd = Yii::$app->request->post('idapd');
            $prid = $model->ProductID;
          
                        
            $sql = Yii::$app->db->createCommand("exec [ChangeGoLive]  @productid = :productid, @aph=:aph, @apd_get=:apd");
            $sql->bindValue(':productid',$prid);
            $sql->bindValue(':aph',$aph);
            $sql->bindValue(':apd',$apd);
            
            //$sql = Yii::$app->db->createCommand("delete from AllocationProductDOutstanding where AllocationProductIDH ='".$id."'");
            $sql->execute();
            
            return $this->redirect(['allocation-product-h/view','id'=>$aph]);
        } else {
            return $this->redirect(['allocation-product-d/change-product','id'=>$apd,'idaph' => $aph]);
        }
//        Yii::$app->session->setFlash('Sukses', 'Data Berhasil Di Approve');
        //return $this->redirect(['allocation-product-d/create','id'=>$id]);
    }
    
    /**
     * Creates a new AllocationProductD model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionChangeapprove($id)
    {   
         $sp = \Yii::$app->db->createCommand("exec ApproveChangeAllocationProduct @getid = :getid,@pic = :pic");
         $sp->bindValue(':getid', $id);
         $sp->bindValue(':pic',  \Yii::$app->user->getId());
         $sp->execute();
         
        return $this->redirect('.?r=operational/allocation-product-h');
    }
    
    public function actionCorrectionchange($transid)
    {   
//          $id = Yii::$app->request->post('idapd');
//          $model->Reason = \Yii::$app->request->post('reason');
//            print_r($model->Reason);
//             die();
          $sql = Yii::$app->db->createCommand("exec [CorrectionChangeAllocationProduct]  @getid = :getid, @pic = :pic, @lastupdate = :lastupdateby");
//          $sql->bindValue(':reason',$model->Reason);
          $sql->bindValue(':lastupdateby',Yii::$app->user->getId());
          $sql->bindValue(':getid',$transid);
          $sql->bindValue(':pic',Yii::$app->user->getId());
          $sql->execute();
          
        Yii::$app->session->setFlash('information', 'Data Need Correction');
        return $this->redirect(['transaction-master/index']);
        
    }
    
       public function actionRfa()
    {        
        try{
            $model = new AllocationProductD();
         if ($model->load(Yii::$app->request->post())) {
            $prodid = $model->ProductID;
            $reason = Yii::$app->request->post('reason');
            $id = Yii::$app->request->post('idapd');
            $query ='exec RequestApprovalChangeAllocationProduct @apdid = :apdid,@prodid = :prodid,@pic = :user,@reason = :reason';
            $sp = Yii::$app->db->createCommand($query);
            $sp->bindValue(':apdid',$id );
            $sp->bindValue(':user', Yii::$app->user->getId());
            $sp->bindValue(':prodid',$prodid);
            $sp->bindValue(':reason',$reason); 
            $pesan = $sp->execute();       
            if($pesan == 'OK'){
                Yii::$app->getSession()->setFlash('success', ' Berhasil melakukan Request');
            }else{
                Yii::$app->getSession()->setFlash('error', $pesan);
            }
         }
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
        } 
        return $this->redirect('.?r=operational/allocation-product-h');
    }
     
    
    public function actionCreate()
    {
        $model = new AllocationProductD();
        $modelGoLive = new \app\operational\models\JadwalGolive();
        $pic = Yii::$app->user->identity->username;
        
        if ($model->load(Yii::$app->request->post()) AND $modelGoLive->load(Yii::$app->request->post())) {

            $model->AllocationProductIDH = Yii::$app->request->post('idsohdr');
            $idapd = Yii::$app->db->createCommand(
                    "SELECT AllocationProductDID = 'APD'
                    +RIGHT(CONVERT(varchar(6),getdate(),112),6)
                    +RIGHT('0000'+CONVERT(varchar,isnull(max(right(apd.AllocationProductDID,4)),0)+1),4)
                    FROM AllocationProductD apd where SUBSTRING(AllocationProductDID,4,6)=left(convert(varchar,getdate(),112),6)")->queryScalar();
            
            $model->AllocationProductDID = $idapd;
            $modelGoLive->AllocationProductDID = $idapd;
            $model->Status = 'D';
            
            
            $modelProduct =  MasterProduct::find()->where(['ProductID' => $model->ProductID])->one();
            
            $modelProduct->Status = 'FIX';
            $modelProduct->UserUpdate = $pic;
            $modelProduct->DateUpdate = new \yii\db\Expression('getdate()');
            
            if(Yii::$app->request->post('H1') == 0)
            {
                $modelGoLive->Monday1=null;
                $modelGoLive->Monday2=null;
            }
            
            if(Yii::$app->request->post('H2') == 0)
            {
                $modelGoLive->Tuesday1=null;
                $modelGoLive->Tuesday2=null;
            }
            
            if(Yii::$app->request->post('H3') == 0) {
                $modelGoLive->Wednesday1 = null;
                $modelGoLive->Wednesday2 = null;
            }
            
            if(Yii::$app->request->post('H4') == 0) {
                $modelGoLive->Thursday1=null;
                $modelGoLive->Thursday2=null;
            }
            
            if(Yii::$app->request->post('H5') == 0) {
                $modelGoLive->Friday1=null;
                $modelGoLive->Friday2=null;
            }
            
            if(Yii::$app->request->post('H6') == 0)
            {
               $modelGoLive->Saturday1=null;
               $modelGoLive->Saturday2=null;
            }
            
            if(Yii::$app->request->post('H7') == 0)
            {
                $modelGoLive->Sunday1=null;
                $modelGoLive->Sunday2=null;
            }
//            else {
//                $senin1 = new \yii\db\Expression('NULL');
//                $senin2 = new \yii\db\Expression('NULL');
//            }
            try{
                if($modelGoLive->validate() && $model->validate() && $modelProduct->validate())
                {
                    $model->save();
                    $modelGoLive->save();
                    $modelProduct->save();
                    return $this->redirect('./index.php?r=operational/allocation-product-d/create&id='.Yii::$app->request->post('idsohdr'));
                } 
            } catch (Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }
            
            return $this->redirect('./index.php?r=operational/allocation-product-d/create&id='.Yii::$app->request->post('idsohdr'));
//                    print_r(true);
//                    print_r('<br><br>');
//                    print_r($modelGoLive);
                
            
//            
//            else {
//                $selasa1 = '';
//                $selasa2 = '';
//            }
//            
//             else {
//                $rabu1 = '';
//                $rabu2 = '';
//            }
//            
//            else {
//                $kamis1 = '';
//                $kamis2 = '';
//            }
//            
//            else {
//                $jumat1 = '';
//                $jumat2 = '';
//            }
//            
//             else {
//                $sabtu1 = '';
//                $sabtu2 = '';
//            }
//           
//             else {
//                $minggu1 = '';
//                $minggu2 = '';
//            }

//            if($isshift == 1)
//            {
//                $harikerja = '';
//                $isshift = 1;
//            } else {
//                $harikerja = Yii::$app->request->post('chk');
//                $isshift = 0;
//            }
           
//            print_r($harikerja);
//            die();
//            $sql = Yii::$app->db->createCommand('EXEC InsertAllocationAndUpdateStatus @idaph=:idaph, '
//                                            . '@sodid=:idsodid,@productid=:productid, @areadetail=:areadetail,'
//                                            . '@nopol=:nopol,@tgltgs=:tgltgs,@isshift=:isshift,'
//                                            . '@usercrt=:usercrt,@productidold=:productidold,@senin1=:senin1,'
//                                            . '@senin2=:senin2,@selasa1=:selasa1,@selasa2=:selasa2,'
//                                            . '@rabu1=:rabu1,@rabu2=:rabu2,@kamis1=:kamis1,@kamis2=:kamis2,'
//                                            . '@jumat1=:jumat1,@jumat2=:jumat2,@sabtu1=:sabtu1,@sabtu2=:sabtu2,'
//                                            . '@minggu1=:minggu1,@minggu2=:minggu2');
//            $sql->bindValue(':idaph',$idaph);
//            $sql->bindValue(':idsodid',$idsodid);
//            $sql->bindValue(':productid',$productid);
//            $sql->bindValue(':productidold',$productid);
//            $sql->bindValue(':areadetail',$areadetail);
//            $sql->bindValue(':nopol',$nopol);
//            $sql->bindValue(':tgltgs',$tgltgs);
//            $sql->bindValue(':isshift',$isshift);
//            //$sql->bindValue(':harikerja',$harikerja);
//            $sql->bindValue(':usercrt',$usercrt);
//            $sql->bindValue(':senin1',$senin1);
//            $sql->bindValue(':senin2',$senin2);
//            $sql->bindValue(':selasa1',$selasa1);
//            $sql->bindValue(':selasa2',$selasa2);
//            $sql->bindValue(':rabu1',$rabu1);
//            $sql->bindValue(':rabu2',$rabu2);
//            $sql->bindValue(':kamis1',$kamis1);
//            $sql->bindValue(':kamis2',$kamis2);
//            $sql->bindValue(':jumat1',$jumat1);
//            $sql->bindValue(':jumat2',$jumat2);
//            $sql->bindValue(':sabtu1',$sabtu1);
//            $sql->bindValue(':sabtu2',$sabtu2);
//            $sql->bindValue(':minggu1',$minggu1);
//            $sql->bindValue(':minggu2',$minggu2);
//            
//            $sql->execute();

            //return $this->redirect('./index.php?r=operational/allocation-product-d/create&id='.$idaph);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates an existing AllocationProductD model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModelChangeProd($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->AllocationProductDID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionApprove($id,$soidh)
    {
        $sql = Yii::$app->db->createCommand("exec [ApproveAllocationProduct]  @getid = :getid, @soidh=:soidh, @pic = :pic");
        $sql->bindValue(':getid',$id);
        $sql->bindValue(':pic',Yii::$app->user->getId());
        $sql->bindValue(':soidh',$soidh);
        //$sql = Yii::$app->db->createCommand("delete from AllocationProductDOutstanding where AllocationProductIDH ='".$id."'");
        $sql->execute();
        //Yii::$app->session->setFlash('Sukses', 'Data Berhasil Di Approve');
        //return $this->redirect(['allocation-product-d/create','id'=>$id]);
    }
    
    public function actionCorrection($id)
    {
        $sql = Yii::$app->db->createCommand("exec [CorrectionAllocationProduct]  @getid = :getid, @pic = :pic");;
        $sql->bindValue(':getid',$id);
        $sql->bindValue(':pic',Yii::$app->user->getId());
        $sql->execute();
        //Yii::$app->session->setFlash('Sukses', 'Data Perlu Pembetulan');
        return $this->redirect(['allocation-product-d/create','id'=>$id]);
    }
    
    public function actionRequest($id)
    {
        $sql = Yii::$app->db->createCommand("exec [RequestAllocationProduct] @getid = :getid , @pic = :pic ");
        $sql->bindValue(':getid',$id);
        $sql->bindValue(':pic',Yii::$app->user->getId());
        $sql->execute();
        //Yii::$app->session->setFlash('Sukses', 'Data Telah Direquest');
        return $this->redirect(['allocation-product-d/create','id'=>$id]);
    }
    
    public function actionCancelRequest($id)
    {
        $sql = Yii::$app->db->createCommand("exec [CancelAllocationProduct]  @getid = :getid");
        $sql->bindValue(':getid',$id);
        $sql->execute();
        //Yii::$app->session->setFlash('Sukses', 'Request di Batalkan');
        return $this->redirect(['allocation-product-d/create','id'=>$id]);
    }
    
    public function actionGetPeriod($sod)
    {
        $job = Yii::$app->db->createCommand("
            select * from SOD where SODID ='".$sod."'
            ")->queryAll();
//        print_r($job[0]['PeriodFrom']);
//        die();
        echo '<td>Tanggal Tugas</td>';
        echo  "<td>";
        echo DatePicker::widget([
                    'id' => 'TglTugas',
                    'options' => ['placeholder' => 'Enter Date ...'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                        'startDate' => $job[0]['PeriodFrom'],
                        'endDate' => $job[0]['PeriodTo'],
                        'todayHighlight' => true]
                ]); 
        
             echo    "</td> ";
    }
    
    public function actionDel($idh,$prid)
    {
        $this->findModelDt($idh,$prid)->delete();
                
        return $this->redirect('./index.php?r=operational/allocation-product-d/create&id='.$idh);
    }
    
    protected function findModel($id)
    {
        if (($model = AllocationProductD::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
        
    protected function findModelDt($idh,$prid)
    {
        if (($model = AllocationProductD::find()->where("AllocationProductIDH = '".$idh."' and ProductID = '".$prid."'")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelChangeProd($id)
    {
        if (($model = AllocationProductD::find()->where("AllocationProductDID = '".$id."'")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
