<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\CosCalH;

class CosCalHSearch extends CosCalH {

    public function rules() {
        return [
            [['CostcalIDH', 'CostcalDate', 'JobDescID', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['IsActive', 'IsImplement'], 'integer'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $sql = new \yii\db\Query;
        $sql->select('ch.CostcalIDH,
                ch.OfferingDID,
                ch.SODID,
                ch.CostcalDate,
                ch.JobDescID,
                mj.Description JobDescription,
                ch.DateCrt')
                ->from('CosCalH ch')
                ->leftJoin('MasterJobDesc mj', 'mj.IDJobDesc=ch.JobDescID')
                ->orderBy('ch.DateCrt Desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $sql
        ]);

        $cariData = $params;

        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] == '1') {
                $cariData = ['CosCalHSearch' => [
                        'r' => $params['r'],
                        'CostcalIDH' => $params['textsearch'],
                ]];
            } else if ($params['typeSearch'] == '2') {
                $cariData = ['CosCalHSearch' => [
                        'r' => $params['r'],
                        'JobDescID' => $params['textsearch'],
                ]];
            }
        }

        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $sql->andFilterWhere([
            'ch.CostcalIDH' => $this->CostcalIDH,
            //'ch.JobDescID' => $this->JobDescID,
            'mj.Description' => $this->JobDescID,
        ]);
        return $dataProvider;
    }

    public function searchCC($params) {
        $sql = new \yii\db\Query;

        if (Yii::$app->request->get('jobID', 'xxx') != 'xxx') {
            $sql->select('ch.CostcalIDH,'
                            . ' ch.CostcalDate,'
                            . ' ch.JobDescID,'
                            . ' mj.Description JobDescription,'
                            . ' ch.DateCrt')
                    ->from('CosCalH ch')
                    ->leftJoin('OfferingD od', 'od.CostcalIDH = ch.CostcalIDH')
                    ->leftJoin('MasterJobDesc mj', 'mj.IDJobDesc=ch.JobDescID')
                    ->where('ch.JobDescID=\'' . Yii::$app->request->get('jobID') . '\'')
                    ->andwhere(['ch.OfferingDID' => NULL])
                    ->orderBy('ch.DateCrt Desc');
        } else {
            $sql->select('ch.CostcalIDH,'
                            . ' ch.CostcalDate,'
                            . 'ch.JobDescID,'
                            . 'mj.Description JobDescription,'
                            . 'ch.DateCrt')
                    ->from('CosCalH ch')
                    ->leftJoin('OfferingD od', 'od.CostcalIDH = ch.CostcalIDH')
                    ->leftJoin('MasterJobDesc mj', 'mj.IDJobDesc=ch.JobDescID')
                    ->andwhere(['ch.OfferingDID' => NULL])
                    ->orderBy('ch.DateCrt Desc');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $sql
        ]);

        $cariData = $params;

        if (isset($params['typeSearch']) && isset($params['textsearch'])) {

            if ($params['typeSearch'] == '1') {
                $cariData = ['CosCalHSearch' => [
                        'r' => $params['r'],
                        'CostcalIDH' => $params['textsearch'],
                ]];
            } else if ($params['typeSearch'] == '2') {
                $cariData = ['CosCalHSearch' => [
                        'r' => $params['r'],
                        'JobDescID' => $params['textsearch'],
                ]];
            }
//            else if($params['typeSearch'] == '3')
//            {
//                $cariData = ['CosCalHSearch'=> [
//                        'r'  => $params['r'],
//                        'AreaID'  => $params['textsearch'],
//                    ]];
//            }
        }

        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $sql->andFilterWhere([
            'ch.CostcalIDH' => $this->CostcalIDH,
            //'ch.JobDescID' => $this->JobDescID,
            'mj.Description' => $this->JobDescID,
        ]);
        return $dataProvider;
    }

}
