<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\Book;

/**
 * BookSearch represents the model behind the search form about `app\master\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
            [['buy_amount'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()    {
        return Model::scenarios();
    }
    
    public function search($params)    {
        $query = Book::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'buy_amount' => $this->buy_amount,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
