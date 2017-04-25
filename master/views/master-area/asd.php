<?php

use app\payroll\models\AbsensiCustomer;

\moonland\phpexcel\Excel::export([
    'models' => AbsensiCustomer::find()->all(),
        // 'columns' => [
        //     'author.name:text:Author Name',
        //     [
        //             'attribute' => 'content',
        //             'header' => 'Content Post',
        //             'format' => 'text',
        //             'value' => function($model) {
        //                 return ExampleClass::removeText('example', $model->content);
        //             },
        //     ],
        //     'like_it:text:Reader like this content',
        //     'created_at:datetime',
        //     [
        //             'attribute' => 'updated_at',
        //             'format' => 'date',
        //     ],
        // ],
        // 'headers' => [
        //     'created_at' => 'Date Created Content',
        // ],
]);


// $file->send('user.xlsx');