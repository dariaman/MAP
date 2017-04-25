<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Product GS';
?>
<div class="data-pjax">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_searchproductgs', ['model' => $searchModel]); ?>
                <div class="box-body">
                    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'pjax' => false,
            'tableOptions' => ['id' => 'idgridproductgs', 'class' => 'table table-striped table-bordered'],
            'columns' => [
                [
                    'label' => 'select',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::radio('idproductgs', false, '');
                    },
                ],
                [
                    'label' => 'Product',
                    'value' => 'ProductID',
                ],
                [
                    'label' => 'Product Name',
                    'value' => 'Nama',
                ],
                [
                    'label' => 'Job Description',
                    'value' => 'Description',
                ],
                [
                    'label' => 'Gender',
                    'value' => function($data) {
                        if ($data['Gender'] == 'L') {
                            return 'Male';
                        } else {
                            return 'Female';
                        }
                    },
                ],
                [
                    'label' => 'City',
                    'value' => 'City',
                ],
            ],
        ]);
                        ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Select', NULL, [ 'class' => 'btn btn-success', 'id' => 'select']);?>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<<SKRIPT
    function setvalue(){
       var row = $("#idgridproductgs input[name=idproductgs]:checked").closest('tr');
       var  inp = document.querySelector("input"); 

        if (window.opener != null && !window.opener.closed){
            $('input[name=prod-id-gs]',opener.document).val(row.find("td:nth-child(2)").text());
            $('input[name=product-id-gs]',opener.document).val(row.find("td:nth-child(2)").text());
            $('input[name=prod-name-gs]',opener.document).val(row.find("td:nth-child(3)").text());
        }
        window.close();
    }

    $('#select').click( setvalue );

SKRIPT;

$this->registerJs($script);
?> 