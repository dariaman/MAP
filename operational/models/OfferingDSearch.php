<?php

namespace app\operational\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\OfferingD;

/**
 * OfferingDSearch represents the model behind the search form about `app\operational\models\OfferingD`.
 */
class OfferingDSearch extends OfferingD {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['OfferingDID', 'OfferingIDH', 'AreaID', 'Class', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = OfferingD::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'GPSeqID' => $this->GPSeqID,
            'DateCrt' => $this->DateCrt,
        ]);

        return $dataProvider;
    }

    public function searchOfferingD($params) {
        $query = (new \yii\db\Query)
                ->select('od.OfferingDID,
                    ma.AreaID,
                    ma.Description,
                    od.Class')
                ->from(['od' => OfferingD::tableName()])
                ->leftJoin('MasterArea ma', 'ma.AreaID=od.AreaID')
                ->leftJoin('SOD sd', 'sd.OfferingDID=od.OfferingDID AND sd.SOIDH=\'' . $params['soh'] . '\'')
                ->where('od.OfferingIDH=\'' . $params['offeringH'] . '\' and sd.SODID is null')
                ->orderBy(['od.Class' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                $query->andFilterWhere([
                    $params['typeSearch'] => $params['textsearch']
                ]);
            }
        }
        return $dataProvider;
    }

}
