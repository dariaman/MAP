<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\TransactionMaster;
use app\operational\models\TransactionMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class TransactionMasterController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'approve-so' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $searchModel = new TransactionMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($Transtype,$TransID)
    {
        if($Transtype == 'SO000001'){ // tipe transaksi  SO
            $view = 'viewSO';
            $model = $this->findModel($TransID);
        } else if($Transtype == 'SO000002'){ // tipe transaksi  SOCoscal
            $view = 'viewSOCoscal';
            $model = $this->findModel($TransID);
        } else if($Transtype == 'SO000003'){ // tipe transaksi  SOCoscal
            $view = 'viewSOQty';
            $model = $this->findModel($TransID);
        } else if($Transtype == 'SO000004'){ // tipe transaksi  SOCoscal
            $view = 'viewSOEC';
            $model = $this->findModel($TransID);
        } else if($Transtype == 'SO000005'){ // tipe transaksi  SOCoscal
            $view = 'viewSODEC';
            $model = $this->findModel($TransID);
        } else if ($Transtype == 'AP000001')
        {
            $view = 'viewAP';
            $model = $this->findModel($TransID);
        } else if ($Transtype == 'OF000001')
        {
            $view = 'viewOF';
            $model = $this->findModel($TransID);
        } else if ($Transtype == 'ET000001')
        {
            $view = 'viewET';
            $model = $this->findModel($TransID);
        } else if ($Transtype == 'AP000002')
        {
            $view = 'viewAddProduct';
            $model = $this->findModel($TransID);
        }
        return $this->render($view, [
            'model' => $model,
            'edit' => '0'
        ]);
    }
    
    public function actionCreate()
    {
        $model = new TransactionMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->TransID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->TransID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionOf()
    {
        $searchModel = new TransactionMasterSearch();
        $dataProvider = $searchModel->searchOf(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);  
    }
    
    public function actionPr()
    {
        $searchModel = new TransactionMasterSearch();
        $dataProvider = $searchModel->searchPr(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);  
    }
    
    public function actionSl()
    {
        $searchModel = new TransactionMasterSearch();
        $dataProvider = $searchModel->searchSl(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);  
    }
    
    public function actionSo()
    {
        $searchModel = new TransactionMasterSearch();
        $dataProvider = $searchModel->searchSo(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);  
    }
    
    public function actionEc()
    {
        $searchModel = new TransactionMasterSearch();
        $dataProvider = $searchModel->searchEc(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);  
    }
    
    public function actionEcsod()
    {
        $searchModel = new TransactionMasterSearch();
        $dataProvider = $searchModel->searchEcsod(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);  
    }
    
    public function actionCc()
    {
        $searchModel = new TransactionMasterSearch();
        $dataProvider = $searchModel->searchSo2(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);  
    }
    
    protected function findModel($id)
    {
        if (($model = TransactionMaster::find()->where(['TransID' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Transaksi tidak Ditemukan');
        }
    }
    public function actionApproveSod($transid,$action) {
        $pic = Yii::$app->user->identity->username;
        $reason = Yii::$app->request->post('Reason');        
        try{
            Yii::$app->db->createCommand(" exec ApproveEndContractSOD '$transid','$pic','$reason' ")->execute();
            Yii::$app->getSession()->setFlash('success', ' Berhasil Approve');
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
        } 
        
        return $this->redirect(['index']);
    }
    
    public function actionApproveSo($transid,$action) {
        $user = Yii::$app->user->identity->username;
        $reason = Yii::$app->request->post('Reason');        
        try{
            Yii::$app->db->createCommand(" exec ApproveSO '$transid','$user','$reason' ")->execute();
            
            $getSODbySOH = Yii::$app->db->createCommand("select SODID from SOD where SOIDH = '".$transid."'")->queryall();
            
            foreach($getSODbySOH as $val)
            {
                
                Yii::$app->db->createCommand(" exec ApproveAllocationProduct '$val[SODID]','$user' ")->execute();    
            }
            Yii::$app->getSession()->setFlash('success', ' Berhasil Approve');
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
        } 
        
        return $this->redirect(['index']);
    }
    
    public function actionApproveSoh($transid,$action) {
        $pic = Yii::$app->user->identity->username;
        $reason = Yii::$app->request->post('Reason');        
        try{
            Yii::$app->db->createCommand(" exec ApproveEndContractSOH '$transid','$pic','$reason' ")->execute();
            Yii::$app->getSession()->setFlash('success', ' Berhasil Approve');
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        } 
        
        return $this->redirect(['index']);
    }
    
    public function actionApproveChangeCc($transid,$action) {        
        
        try{
            Yii::$app->db->createCommand(' exec ApproveChangeCostCalc \''.$transid.'\',\''.Yii::$app->user->identity->username.'\' ')->execute();
            Yii::$app->getSession()->setFlash('success', 'Sukses Approve');
            
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        } catch(\yii\db\IntegrityException $ex ){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect('./index.php?r=operational/transaction-master');
    }
    
    public function actionCorrectionSo($transid) {
        $user = Yii::$app->user->identity->username;
        $reason = Yii::$app->request->post('Reason');
        try {
            Yii::$app->db->createCommand("exec CorrectionApprovalSO '$transid', '$user' ,'$reason'")->execute();
            Yii::$app->getSession()->setFlash('success', 'SO perlu review kembali.');
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
        }
        return $this->redirect(['transaction-master/index']);
    }
    public function actionCorrectionOf($transid) {
        $user = Yii::$app->user->identity->username;
        $reason = Yii::$app->request->post('Reason');
        try {
            Yii::$app->db->createCommand("exec CorecttionApproveOf '$transid', '$user' ,'$reason'")->execute();
            Yii::$app->getSession()->setFlash('success', 'SO perlu review kembali.');
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
        }
        return $this->redirect(['transaction-master/index']);
    }
    
    public function actionCorrectionSod($transid) {
        $pic = Yii::$app->user->identity->username;
        $reason = Yii::$app->request->post('Reason');
        try {
            Yii::$app->db->createCommand("exec CorrectionECApprovalSOD @transid='$transid', @pic='$pic', @reason='$reason'")->execute();
            Yii::$app->getSession()->setFlash('success', 'SOD perlu review kembali.');
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect(['transaction-master/index']);
    }
    
    public function actionCorrectionSoh($transid) {
        $pic = Yii::$app->user->identity->username;
        $reason = Yii::$app->request->post('Reason');
        try {
            Yii::$app->db->createCommand("exec CorrectionECApprovalSOH @transid='$transid', @pic='$pic', @reason='$reason'")->execute();
            Yii::$app->getSession()->setFlash('success', 'SOH perlu review kembali.');
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
        }
        return $this->redirect(['transaction-master/index']);
    }
    
    public function actionCorrectionChangeSod($transid) {
        $pic = Yii::$app->user->identity->username;
        $reason = Yii::$app->request->post('Reason');
        try {
            Yii::$app->db->createCommand("exec CorrectionChangeSO @transid='$transid', @pic='$pic'")->execute();
            Yii::$app->getSession()->setFlash('success', 'Change Cost Calc perlu review kembali.');
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect(['transaction-master/index']);
    }
    
    public function actionCorrectionET($transid) {
        $pic = Yii::$app->user->identity->username;
        try {
            Yii::$app->db->createCommand("exec CorrectionRequestET @goliveid='$transid', @pic='$pic'")->execute();
            Yii::$app->getSession()->setFlash('success', 'Request Early Terminated perlu review kembali.');
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect(['transaction-master/index']);
    }
    
    public function actionCorrectionSlotProduct($transid,$action) {
        $arr = explode('|',$transid);
        
        $pic = Yii::$app->user->identity->username;
        $reason = Yii::$app->request->post('Reason');
        try{
            Yii::$app->db->createCommand(' exec CorrectionDeletSlot \''.$arr[1].'\',\''.Yii::$app->user->identity->username.'\','.$arr[0].' ')->execute();
            Yii::$app->getSession()->setFlash('success', 'Cancel Request Delete Slot berhasil');
            
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        } catch(\yii\db\IntegrityException $ex ){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect('./index.php?r=operational/transaction-master');
    }
    
    
    public function actionApproveAp($transid,$action)
    {
        try{
            Yii::$app->db->createCommand(' exec ApproveAllocationProduct \''.$transid.'\',\''.Yii::$app->user->identity->username.'\' ')->execute();
            Yii::$app->getSession()->setFlash('success', 'Sukses Approve');
            
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        } catch(\yii\db\IntegrityException $ex ){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect('./index.php?r=operational/transaction-master');
    }
    
    public function actionApproveOf($transid,$action)
    {
        try{
            Yii::$app->db->createCommand(' exec ApproveOffering \''.$transid.'\',\''.Yii::$app->user->identity->username.'\' ')->execute();
            Yii::$app->getSession()->setFlash('success', 'Sukses Approve');
            
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        } catch(\yii\db\IntegrityException $ex ){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect('./index.php?r=operational/transaction-master');
    }
    
    public function actionApproveEt($transid,$action)
    {
        try{
            Yii::$app->db->createCommand(' exec ApproveET \''.$transid.'\',\''.Yii::$app->user->identity->username.'\' ')->execute();
            Yii::$app->getSession()->setFlash('success', 'Sukses Approve');
            
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        } catch(\yii\db\IntegrityException $ex ){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect('./index.php?r=operational/transaction-master');
    }
    
    public function actionApproveAddProduct($transid,$action)
    {
        try{
            Yii::$app->db->createCommand(' exec ApproveAddProduct \''.$transid.'\',\''.Yii::$app->user->identity->username.'\' ')->execute();
            Yii::$app->getSession()->setFlash('success', 'Sukses Approve');
            
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        } catch(\yii\db\IntegrityException $ex ){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect('./index.php?r=operational/transaction-master');
    }
    
    public function actionApproveDelQty($transid,$action) {
        $arr = explode('|',$transid);
        
        try{
            Yii::$app->db->createCommand(' exec ApproveDelQty \''.$arr[1].'\',\''.Yii::$app->user->identity->username.'\','.$arr[0].' ')->execute();
            Yii::$app->getSession()->setFlash('success', 'Sukses Approve');
            
        }catch(\yii\db\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        } catch(\yii\db\IntegrityException $ex ){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect('./index.php?r=operational/transaction-master');
    }
}