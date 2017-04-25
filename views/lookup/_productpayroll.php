<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Product';
?>
<div class="data-pjax">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_searchproductpayroll', ['model' => $searchModel]); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['id' => 'idgridproductfix', 'class' => 'table table-striped table-bordered'],
        'columns' => [
            [
                'label' => 'select',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::radio('idproductfix', false, '');
                },
            ],
            [
                'label' => 'Product Id',
                'value' => 'ProductID',
            ],
            [
                'header' => 'Nama Product',
                'value' => 'Nama',
                'contentOptions' => ['style' => 'max-width: 1000px;']
            ],
                                    [
                'label' => 'Job Description',
                'value' => 'JobDesk',
            ],
        ],
    ]);
    ?>
</div>
<?php
echo Html::a('Select', NULL, [ 'class' => 'btn btn-success', 'id' => 'select']);

$script = <<<SKRIPT
        
    function setvalue(){

       var row = $("#idgridproductfix input[name=idproductfix]:checked").closest('tr');

        if (window.opener != null && !window.opener.closed){
            $('input[name=prod-id-payroll]',opener.document).val(row.find("td:nth-child(2)").text());
            $('#prod-name-payroll',opener.document).text(row.find("td:nth-child(3)").text());
            $('#prod-jobdesk-payroll',opener.document).text(row.find("td:nth-child(4)").text());
        }
        window.close();
    }

    $('#select').click( setvalue );


SKRIPT;

$this->registerJs($script);
?> 