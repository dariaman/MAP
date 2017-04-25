<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BackupProductSearch represents the model behind the search form about `app\operational\models\BackupProduct`.
 */
class BackupProductSearch extends BackupProduct {

    /**
     * @inheritdoc
     */
    public $AreaDetailDesc;
    public $Tgl;
    public $SODID;
    public $SOIDH;
    public $CustomerName;
    public $ProductID;
    public $Nama;
    public $Description;
    public $CustomerID;
    public $NamaGs;

    public function rules() {
        return [
            [['ProductIDGS', 'SODID', 'ProductIDFix', 'TglTugas', 'PeriodTo', 'StatusAbsen', 'Reason', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['SeqProduct', 'IsExpired'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {

        $query = BackupProduct::find()
                ->select('bp.ProductIDGS,mp.Nama as NamaGs ,bp.SODID,bp.SeqProduct,bp.ProductIDFix,(select mpp.Nama from MasterProduct mpp where mpp.ProductID=bp.ProductIDFix ) as NamaFix,bp.TglTugas,bp.PeriodTo,bp.StatusAbsen,bp.Reason,bp.IsExpired')
                ->from('BackupProduct bp')
                ->leftJoin('MasterProduct mp', 'mp.ProductID=bp.ProductIDGS')
                ->orderBy(['SeqProduct' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $cariData = $params;

        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            $cariData = ['BackupProductSearch' => [
                    'r' => $params['r'],
                    $params['typeSearch'] => $params['textsearch'],
            ]];
        }

        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ProductIDGS' => $this->ProductIDGS,
            'SODID' => $this->SODID,
            'ProductIDFix' => $this->ProductIDFix,
        ]);

        return $dataProvider;
    }

}
