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
                <?= $this->render('_searchproductfix', ['model' => $searchModel]); ?>
                <div class="box-body">
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
                            'SODID',
                            'SeqProduct',
                            'ProductID',
                            [
                                'label' => 'Product Name',
                                'value' => 'Nama',
                            ],
                            'CustomerID',
                            'CustomerName',
                            'IDJobDesc',
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Select', NULL, [ 'class' => 'btn btn-success', 'id' => 'select']); ?>
            </div>
        </div>
    </div>   
</div>
<?php
$script = <<<SKRIPT
        
    function setvalue(){

       var row = $("#idgridproductfix input[name=idproductfix]:checked").closest('tr');

        if (window.opener != null && !window.opener.closed){
            $('input[name=prod-id-fix]',opener.document).val(row.find("td:nth-child(4)").text());
            $('input[name=prod-name-fix]',opener.document).val(row.find("td:nth-child(5)").text());
            $('input[name=prod-sodid-fix]',opener.document).val(row.find("td:nth-child(2)").text());
            $('input[name=prod-cusid-fix]',opener.document).val(row.find("td:nth-child(6)").text());                   
            $('input[name=prod-seqprod-fix]',opener.document).val(row.find("td:nth-child(3)").text());
            $("#buttongs",opener.document).attr('href','../web/index.php?r=lookup/lookupproductgs&idjob='+row.find("td:nth-child(8)").text())
        }
        window.close();
    }

    $('#select').click( setvalue );
    


SKRIPT;

$this->registerJs($script);
?> 