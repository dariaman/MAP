<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\helpers\Enum;
?>

<div>

    <?php
    $form = ActiveForm::begin([
                'action' => ['absen-gs'],
                'method' => 'post',
    ]);
    ?>

    <?php
    $yearnw = Yii::$app->request->post('tahun', date('o'));
    $monthnw = Yii::$app->request->post('bulan', date('m'));
    ?>

    <table style="width:100%;" class="kv-grid-table table table-bordered table-striped">
        <tr>
            <td style="width:150px;"><b>Bulan</b></td>
            <td><?= Html::dropDownList('bulan', $monthnw, Enum::monthList(), ['class' => 'form-control', 'id' => 'month', 'style' => 'display:block;']) ?></td>
        </tr>
        <tr>
            <td><b>Tahun</b></td>
            <td><?= Html::dropDownList('tahun', $yearnw, Enum::yearList(date('o') - 1, date('o'), true, false), ['class' => 'form-control', 'id' => 'year']) ?></td>
        </tr>
        <tr>
            <td><?php echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']); ?></td>
        </tr>
    </table>
<?php ActiveForm::end(); ?>

</div>
