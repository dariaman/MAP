<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Product Fix';
?>
<div class="data-pjax">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_searchoffering', ['model' => $searchModel]); ?>
                <div class="box-body">
                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => ['id' => 'idgridoffering', 'class' => 'table table-striped table-bordered'],
                            'columns' => [
                                [
                                    'label' => '',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::radio('offeringid', false, '');
                                    },
                                ],
                                'OfferingIDH',
                                [
                                    'label' => 'Offering Date',
                                    'value' => function($data) {
                                        return date('Y-m-d', strtotime($data['OfferingDate']));
                                    }
                                ],
                                [
                                    'label' => 'Job Description',
                                    'value' => 'Description'
                                ],
                                                    [
                                    'label' => 'Customer Id',
                                    'value' => 'CustomerID'
                                ],
                                [
                                    'header' => 'CustomerName',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'value' => 'CustomerName'
                                ],
                                [
                                    'header' => 'Nomor Surat',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'value' => 'NoSurat'
                                ],
                                [
                                    'header' => 'Status',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data) {
                                if ($data['Status'] == 'D') {
                                    return 'Draft';
                                } else if ($data['Status'] == 'RFA') {
                                    return 'Request For Approval';
                                } else if ($data['Status'] == 'A') {
                                    return 'Approved';
                                }
                            }
                                ],
                            ],
                        ]);
                        ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <?= Html::a('Select', NULL, [ 'class' => 'btn btn-success', 'id' => 'select']);?>
        </div>
    </div>
</div>

<?php
$script = <<<SKRIPT

 function setvalue(){

       var row = $("#idgridoffering input[name=offeringid]:checked").closest('tr');

        if (window.opener != null && !window.opener.closed){
            $('input[name=of-id]',opener.document).val(row.find("td:nth-child(2)").text());
            $('input[name=of-jobdes]',opener.document).val(row.find("td:nth-child(4)").text());
            $('input[name=of-ofdate]',opener.document).val(row.find("td:nth-child(3)").text());
            $('input[name=of-custname]',opener.document).val(row.find("td:nth-child(6)").text());                   
        }
        window.close();
    }

    $('#select').click( setvalue );            

SKRIPT;

$this->registerJs($script);
?> 