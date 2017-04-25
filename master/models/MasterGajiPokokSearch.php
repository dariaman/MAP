<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterGajiPokok;
use yii\db\Query;
use yii\db\Expression;

/**
 * MasterGajiPokokSearch represents the model behind the search form about `app\master\models\MasterGajiPokok`.
 */
class MasterGajiPokokSearch extends MasterGajiPokok
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GapokID', 'SeqID', 'IDJobDesc', 'AreaID', 'UMP', 'UserCrt', 'DateCrt',],'safe'],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {        
        $model = new MasterGajiPokok();
        
        $subQuery = (new Query)->select('GapokID,max(SeqID) SeqID')->from('MasterGajiPokok')->groupBy('GapokID');
        
        $query = (new Query)->select('mg.GapokID,mg.SeqID,mj.Description JobDesc,ma.Description AreaName, mg.UMP, mg.GSFee')
                ->from(['mg' => MasterGajiPokok::tableName()])
                ->join('INNER JOIN',['mgp'=>$subQuery] ,'mgp.GapokID=mg.GapokID and mgp.SeqID=mg.SeqID')
                ->join('LEFT JOIN','MasterArea ma','ma.AreaID=mg.AreaID')
                ->join('LEFT JOIN','MasterJobDesc mj','mj.IDJobDesc=mg.IDJobDesc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
        ]);     
        $cariData = $params;
        
        if(isset($params['typeSearch']) && isset($params['textsearch'])) {
            $cariData = ['MasterGajiPokokSearch'=> [
                'r'  => $params['r'],
                $params['typeSearch'] => $params['textsearch'],
            ]];
        }

        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'mj.Description' => $this->IDJobDesc,
            'ma.Description' => $this->AreaID,
        ]);

        return $dataProvider;
    }
}
