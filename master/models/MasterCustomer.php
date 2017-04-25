<?php

namespace app\master\models;

use Yii;


class MasterCustomer extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'MasterCustomer';
    }

    public $StartAbsen;
    public $EndAbsen;
    public $MCIA;
    public $listformulaamount;
    public $FormulaFunction;
    
    public function rules() {
        return [
            [['CustomerID', 'CustomerName', 'Inisial', 'Address', 'City', 'IDAbsenType','TermOfPayment', 'VirtualAccount'], 'string'],
            [[ 'CustomerName'], 'required','message' => '{attribute} tidak boleh kosong'],
            [['DateCrt', 'DateUpdate', 'ApprovedDate','UserCrt', 'UserUpdate', 'ApprovedBy','IsCompany','ContactName', 'ContactPhone', 'ContactEmail','IsActive'], 'safe'],
            [['Zip', 'Phone', 'Fax', 'ContactPhone','NPWP'],'integer','message' => '{attribute} hanya boleh angka.'],
            [['ContactEmail'],'email','message' => 'Format yang dimasukan salah']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'CustomerID' => 'Customer ID',
            'CustomerName' => 'Customer Name',
            'IsCompany' => 'Is Company',
            'Inisial' => 'Inisial',
            'Address' => 'Address',
            'City' => 'City',
            'Zip' => 'Zip',
            'Phone' => 'Phone',
            'Fax' => 'Fax',
            'ContactName' => 'Contact Name',
            'ContactPhone' => 'Contact Phone',
            'ContactEmail' => 'Contact Email',
            'IDAbsenType' => 'Idabsen Type',
            'TermOfPayment' => 'Term Of Payment',
            'VirtualAccount' => 'Virtual Account',
            'NPWP' => 'Npwp',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
            'ApprovedBy' => 'Approved By',
            'ApprovedDate' => 'Approved Date',
        ];
    }

}
