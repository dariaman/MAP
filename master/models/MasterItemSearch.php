<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterItem;
use yii\db\Query;


/**
 * MasterItemSearch represents the model behind the search form about `app\master\models\MasterItem`.
 */
class MasterItemSearch extends MasterItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemDescription', 'UserCrt', 'DateCrt'], 'safe'],
            [['IsActive'], 'integer'],
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
       
        $query =  MasterItem::find()->select('ItemID,ItemDescription')
                            -> from('MasterItem');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//               'pagination'=> ['defaultPageSize' => 5]
        ]);
          $cariData = $params;
        
        
        if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
            
            if($params['typeSearch'] == 1)
            {
                $cariData = ['MasterItemSearch'=> [
                        'r'  => $params['r'],
                        'ItemID'  => $params['textsearch'],
                ]];
            } else if($params['typeSearch'] == 2)
            {
                $cariData = ['MasterItemSearch'=> [
                        'r'  => $params['r'],
                        'ItemDescription'  => $params['textsearch'],
                ]];
            }
            
        }
        
        $this->load($cariData);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ItemID' => $this->ItemID,
            'ItemDescription' => $this->ItemDescription,
        ]);

//        $query->andFilterWhere(['like', 'ItemID', $this->ItemID])
//            ->andFilterWhere(['like', 'ItemDescription', $this->ItemDescription])
//            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt]);

        return $dataProvider;
    }
}
