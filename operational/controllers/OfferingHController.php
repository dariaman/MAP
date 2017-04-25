<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\OfferingH;
use app\operational\models\OfferingHSearch;
use app\operational\models\CosCalHSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
/**
 * OfferingHController implements the CRUD actions for OfferingH model.
 */
class OfferingHController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * Lists all OfferingH models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OfferingHSearch();
        $dataProvider = $searchModel->search(array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionDeleteOff($OIDH)
    {
        $this->findModel($OIDH)->delete();
        Yii::$app->getSession()->setFlash('success', ' Data sukses dihapus');       
        return $this->redirect(['offering-h/index']);
    }
    
    public function actionLookupCostcal()
    {
        $searchModel = new CosCalHSearch();
        $dataProvider = $searchModel->searchCC(array_merge(Yii::$app->request->post(),
                                                                Yii::$app->request->queryParams));

        return $this->render('_coscallookup', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionLookupOfferingh()
    {
        $searchModel = new OfferingHSearch();
        $dataProvider = $searchModel->search(array_merge(Yii::$app->request->post(),
                                                        Yii::$app->request->queryParams));

        return $this->render('_offeringlookup', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new OfferingH();

         if ($model->load(Yii::$app->request->post())) {
            
            $getid = Yii::$app->db->createCommand("
                select 'OFH' + LEFT(convert(varchar,GETDATE(),112),6) + 
                RIGHT('0000' + convert(varchar,isnull(max(RIGHT(OfferingIDH,4)),0)+1),4)
                from OfferingH where SUBSTRING(OfferingIDH,4,6)=LEFT(convert(varchar,GETDATE(),112),6) ")
                    ->queryScalar();
            $model->OfferingIDH = $getid;
            $monthforroman = date('n');
            $getnooff = Yii::$app->db->createCommand("select
            RIGHT('0000'+ convert(varchar,isnull(max(SUBSTRING(NoSurat,1,4)),0)+1),4)+
            RIGHT('/OPS-OFFD/',10)+
            RIGHT  (dbo.ToRomanNumerals($monthforroman),4)+
            RIGHT ('/' ,1) + 
            RIGHT (substring(convert(varchar,getdate(),112),1,4) ,4)
            from offeringh where month(getdate()) = '$monthforroman' and year(getdate()) = RIGHT(NoSurat,4)")->queryScalar();
            $model->NoSurat = $getnooff;
            $model->save();
            Yii::$app->getSession()->setFlash('success', 'Create Offering Successfully');
            return $this->redirect(['offering-d/create','OIDH' => $getid]);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }
    
    protected function findModel($id)
    {
        if (($model = OfferingH::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionGetGapok($idarea,$jobid)
    {     
        $sqlGapok = "
                select mg.GapokID,mg.SeqID,mg.UMP from MasterGajiPokok mg
                inner join (
                        select GapokID,max(SeqID) SeqID	from MasterGajiPokok 
                        where AreaID='$idarea' and IDJobDesc='$jobid' group by GapokID	
                )mgg on mgg.GapokID=mg.GapokID and mgg.SeqID=mg.SeqID
                where mg.AreaID='$idarea' and mg.IDJobDesc='$jobid'
                ";
        $Gapok = \app\master\models\MasterGajiPokok::findBySql($sqlGapok)->one();
        echo Json::encode($Gapok);       
    }
    
    public function actionGetTotal($gapokid,$gapokseqid,$coscalidh){     
        $sql =  $sql =  Yii::$app->db->createCommand('EXEC GetSumCostCal \''.$coscalidh.'\', \''.$gapokid.'\', \''.$gapokseqid.'\'')
                ->queryAll();
        echo Json::encode($sql);       
    }
    
    public function actionExportoff($ofidh){
        
        $cusid = $sql =  Yii::$app->db->createCommand("select CustomerID from OfferingH where OfferingIDH = '$ofidh'")
                ->queryScalar();
        
        if($cusid[0] == 'CUS1603054')
        {
            ob_end_clean();
            return $this->render('exportoffmbi',['ofidh' => $ofidh]);
        } else {
            ob_end_clean();
            return $this->render('exportoff',['ofidh' => $ofidh]);
        }
    }
    
    public function actionRfa($ofidh){
        try{
//            $sqlstring ="if exists (select '' from OfferingH where OfferingIDH='".$ofidh."' and Status<>'D')
//                            select 'Offering tersebut tidak dalam status Draft, tidak dapat diajukan RFA'
//                        else if not exists( select '' from OfferingH where OfferingIDH='".$ofidh."')
//                            select 'Offering yang diajukan tidak memiliki item Offering detail' 
//                        else if exists( select '' from TransactionMaster where TransID='".$ofidh."')
//                            select 'Offering sudah dalam proses RFA'
//                        else select 'OK' ";
            $sqlstring = "exec ValidasiRFAOffering '$ofidh'";
            
            $cmd = Yii::$app->db->createCommand($sqlstring)->queryScalar();
            $user = Yii::$app->user->identity->username;
            if($cmd=='OK'){
                $sqlstring ='exec RequestApprovalOffering @transid=:idTrans, @pic=:user';
                $cmd = Yii::$app->db->createCommand($sqlstring);
                $cmd->bindParam(':idTrans', $ofidh);
                $cmd->bindParam(':user', $user);
                $cmd->execute();
                
                Yii::$app->getSession()->setFlash('success', ' Berhasil RFA');
                return $this->redirect(Yii::$app->request->referrer);
            }else{
                Yii::$app->getSession()->setFlash('error', $cmd);
                return $this->redirect(Yii::$app->request->referrer);
//                return $this->redirect(['offering-d/create','OIDH'=>$ofidh]);
            }            

        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            return $this->redirect(Yii::$app->request->referrer);
//            return $this->redirect(['offering-d/create','OIDH'=>$ofidh]);
        } 
        
    }
}
