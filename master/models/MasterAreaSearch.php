<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterArea;

/**
 * MasterAreaSearch represents the model behind the search form about `app\master\models\MasterArea`.
 */
class MasterAreaSearch extends MasterArea
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AreaID', 'Description', 'UserCrt', 'DateCrt'], 'safe'],
            [['IsActive'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()   {
        return Model::scenarios();
    }
    
    public function search($params)   {
        $query = MasterArea::find()
                ->select('AreaID,Description,IsActive')
                ->orderBy(['Description'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> false
        ]);
           
        $cariData = $params;
        
        if(isset($params['typeSearch']) && isset($params['textsearch'])) {
             $cariData = ['MasterAreaSearch'=> [
                 'r'  => $params['r'],
                 $params['typeSearch'] => $params['textsearch'],
             ]];
         }
        
        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'AreaID' => $this->AreaID,
//            'Description' => $this->Description,
        ])
        ->andFilterWhere(['like', 'Description', $this->Description]);
        
//        $query->andFilterWhere(['like', 'Description', $this->Description]);

        return $dataProvider;
    }
}
