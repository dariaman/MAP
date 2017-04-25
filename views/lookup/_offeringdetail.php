<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Offering Detail';
?>
<div class="data-pjax">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_searchofferingdlookup', ['model' => $searchModel]); ?>
                <div class="box-body">
                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'pjax' => false,
                            'tableOptions' => ['id' => 'idgridofferingdetail', 'class' => 'table table-striped table-bordered'],
                            'columns' => [
                                [
                                    'label' => '',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::radio('offeringd-id', false, '');
                                    },
                                ],
                                'OfferingDID',
                                'AreaID',
                                [
                                    'label' => 'Area Name',
                                    'value' => 'Description',
                                ],
                                'Class',
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
       var row = $("#idgridofferingdetail input[name=offeringd-id]:checked").closest('tr');
        var  inp = document.querySelector("input"); 

        if (window.opener != null && !window.opener.closed){
               $('input[name=off-id]',opener.document).val(row.find("td:nth-child(2)").text());
                $('input[name=off-areaname]',opener.document).val(row.find("td:nth-child(4)").text());
                $('input[name=off-class]',opener.document).val(row.find("td:nth-child(5)").text());
        }
        window.close();
    }

    $('#select').click( setvalue );
    
SKRIPT;
$this->registerJs($script);
?> 