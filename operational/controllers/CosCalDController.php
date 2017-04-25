<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\CosCalD;
use app\operational\models\CosCalDSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

class CosCalDController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex(){
        $searchModel = new CosCalDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionChangeAmountCoscald(){        
        if (Yii::$app->request->post('hasEditable')) {
            $coscald = Yii::$app->request->post('editableKey');
            $model = CosCalD::findOne($coscald);

            $out = Json::encode(['output'=>'', 'message'=>'']);
            $post = [];
            $posted = current(Yii::$app->request->post('CosCalD'));
            $post['CosCalD'] = $posted;
            
            if ($model->load($post)) {
                $model->save();
                $output = '';
                if (isset($posted['Amount'])) {
                   $output =  Yii::$app->formatter->asDecimal($model->Amount, 2);
                } 
                $out = Json::encode(['output'=>$output, 'message'=>'']);
            } 
            echo $out;
            return;
        }
        
    }
    
    public function actionCreate(){
        $model = new CosCalD();
        
        $idCoscalH = Yii::$app->request->get('CostcalIDH','xxx');

        if ($model->load(Yii::$app->request->post()) ) {
            echo var_dump(Yii::$app->request->post());
//            die();
            $dataPost = Yii::$app->request->post('CosCalD');
            
            // validasi tipe Biaya yang menggunakan persen
            if($dataPost['BiayaID'] == 'BPJS0001' || //BPJS
                    $dataPost['BiayaID'] == 'M1000001' ||  // Mfee
                    $dataPost['BiayaID'] == 'M5000001'){  //Mfee OT
                if((int)$dataPost['Amount'] > 99 ){
                    Yii::$app->session->setFlash('error', 'Amount dalam bentuk persen (value maks 100)');
                    return $this->render('_form', ['model' => $model,]);
                }                
            }
            try{
                $getid = Yii::$app->db->createCommand("
                    select 'CCD'+left(convert(varchar,GETDATE(),112),6) + RIGHT('0000' + 
                        convert(varchar,isnull(max(right(CostcalDID,4)),0)+1),4)
                        from CosCalD where SUBSTRING(CostcalDID,4,6)=left(convert(varchar,getdate(),112),6)
                    ")->queryScalar();
                $model->CostcalDID = $getid;
                $model->CostcalIDH = $idCoscalH;
                $model->Time = Yii::$app->request->post('masuk');
                
                if($model->validate()){                   
                    $model->save();
                    Yii::$app->session->setFlash('success', 'Data Berhasil Disimpan');
                    return $this->redirect(['cos-cal-d/create','CostcalIDH' => $idCoscalH,'flag' => Yii::$app->request->get('flag','xxx')]);
                }else{
                    Yii::$app->session->setFlash('error', 'Pastikan data sudah diisi dengan lengkap !!'); 
                    return $this->render('_form', ['model' => $model,]);
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', $ex->errorInfo[2]);
                return $this->render('_form', ['model' => $model]);
            }            
        } else {
            return $this->render('_form', ['model' => $model,]);
        }
    }

    public function actionLists($idtype,$idcch){
        if($idtype == '1FX'){
            $where = "('$idtype','MGM1')";
        } else if ($idtype == '2TMB'){
            $where = "('$idtype','MGM1')";
        } else if($idtype == '3NFIX'){
            $where = "('$idtype','LMB','MGM2')";
        }
        $job = Yii::$app->db->createCommand("select mb.BiayaID,mb.Description from MasterBiaya mb
                    left join CosCalD cd on cd.BiayaID=mb.BiayaID and CostcalIDH = '".$idcch."'
                    where cd.CostcalDID is null
                            and mb.Tipe IN".$where)->queryAll();
        
        echo "<option selected='true' value=''>Pilih Biaya</option>";
        if(count($job) >0){            
            foreach($job as $post){
                echo "<option value='".$post['BiayaID']."'>".$post['Description']."</option>";
            }
        }
    }
    
    public function actionManagementFee($idarr,$idcch)
    {
        $newarr = json_decode($idarr);
//        $getmfee = CosCalD::find()->where(['CostcalIDH' => $idcch,'BiayaID' => 'M1000001'])->one();
        
//        $amtpercntage = $getmfee['Amount'];
//         print_r($newarr);
//         die();
//        $calculatemfee = Yii::$app->db->createCommand("exec CalculateMfee @mfee = :mfee ,@ccidh = :ccidh ,@pic = :pic ");
//        $calculatemfee->bindParam(':mfee', $amtpercntage);
//        $calculatemfee->bindParam(':ccidh', $idcch);
//        $calculatemfee->bindParam(':pic', Yii::$app->user->getId());
        if(count($newarr) == 0)
        {
            $cch = Yii::$app->db->createCommand("update CosCalD set IsManagementFee = 0 where CostcalIDH = '".$idcch."'")->execute();
            
//            return 'a';
        } else {
            
            $cch = Yii::$app->db->createCommand("update CosCalD set IsManagementFee = 0 where CostcalIDH = '".$idcch."'")->execute();

            foreach($newarr as $value)
            {
                Yii::$app->db->createCommand("update CosCalD set IsManagementFee = 1 where CostcalDID ='".$value."' and CostcalIDH = '".$idcch."'")->execute();
            }
//            return 'b';
//            $calculatemfee->execute();
        }
        
        
        
    }
    
    public function actionManagementFeeSocostcalc($idarr,$idsod)
    {
        $newarr = json_decode($idarr);
//         print_r($newarr);
//         die();
        if(count($newarr) == 0)
        {
            $cch = Yii::$app->db->createCommand("update SOCostCalOutstanding set IsManagementFee = 0 where SODID = '".$idsod."'")->execute();
            
//            return 'a';
        } else {
            
            $cch = Yii::$app->db->createCommand("update SOCostCalOutstanding set IsManagementFee = 0 where SODID = '".$idsod."'")->execute();

            foreach($newarr as $value)
            {
                Yii::$app->db->createCommand("update SOCostCalOutstanding set IsManagementFee = 1 where BiayaID ='".$value."' and SODID = '".$idsod."'")->execute();
            }
//            return 'b';
        }
        
        
               
    }
    protected function findModel($did){
        if (($model = CosCalD::findOne(['CostcalDID' => $did])) !== null) {
            return $model;
        } else {
            Yii::$app->getSession()->setFlash('error', ' Data tidak ditemukan');
        }
    }
    
    public function actionDelcon($did, $idh){
        $this->findModel($did)->delete();
        Yii::$app->getSession()->setFlash('success', ' Data sukses dihapus');
        return $this->redirect(['cos-cal-d/create', 'CostcalIDH' => $idh,'flag' => Yii::$app->request->get('flag','C')]);
    }
}
