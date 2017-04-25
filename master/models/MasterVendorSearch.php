<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterVendor;
use yii\db\Query;

/**
 * MasterVendorSearch represents the model behind the search form about `app\master\models\MasterVendor`.
 */
class MasterVendorSearch extends MasterVendor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VendorID', 'VendorName', 'Address', 'City', 'Zip', 'Phone', 'Fax', 'ContactName', 'ContactPhone', 'ContactEmail', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
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
        $query = MasterVendor::find()->select('*')
                            ->from('MasterVendor');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//             'pagination'=> ['defaultPageSize' => 5]
        ]);
        
     $cariData = $params;

      if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
            $cariData = ['MasterVendorSearch'=> [
                'r'  => $params['r'],
                $params['typeSearch'] => $params['textsearch'],
            ]];
        }
        
        
        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'VendorID' => $this->VendorID,
            'VendorName' => $this->VendorName,
            ]);

//        $query->andFilterWhere(['like', 'VendorID', $this->VendorID])
//            ->andFilterWhere(['like', 'VendorName', $this->VendorName])
//            ->andFilterWhere(['like', 'Address', $this->Address])
//            ->andFilterWhere(['like', 'City', $this->City])
//            ->andFilterWhere(['like', 'Zip', $this->Zip])
//            ->andFilterWhere(['like', 'Phone', $this->Phone])
//            ->andFilterWhere(['like', 'Fax', $this->Fax])
//            ->andFilterWhere(['like', 'ContactName', $this->ContactName])
//            ->andFilterWhere(['like', 'ContactPhone', $this->ContactPhone])
//            ->andFilterWhere(['like', 'ContactEmail', $this->ContactEmail])
//            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
//            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);

        return $dataProvider;
    }
}
