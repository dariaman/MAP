<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterAbsenType;

/**
 * MasterAbsenTypeSearch represents the model behind the search form about `app\master\models\MasterAbsenType`.
 */
class MasterAbsenTypeSearch extends MasterAbsenType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'StartAbsen', 'EndAbsen', 'IsActive'], 'integer'],
            [['UserCrt', 'DateCrt'], 'safe'],
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
        $query = MasterAbsenType::find()->select('StartAbsen,EndAbsen')->orderBy(['StartAbsen'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
        
        $cariData = $params;
        
           if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
            $cariData = ['MasterAbsenTypeSearch'=> [
                'r'  => $params['r'],
                $params['typeSearch'] => $params['textsearch'],
            ]];
        }
        
        
        $this->load($cariData);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
//            'ID' => $this->ID,
            'StartAbsen' => $this->StartAbsen,
            'EndAbsen' => $this->EndAbsen,
//            'IsActive' => $this->IsActive,
//            'datecrt' => $this->datecrt,
        ]);

//        $query->andFilterWhere(['like', 'usercrt', $this->usercrt]);

        return $dataProvider;
    }
}
