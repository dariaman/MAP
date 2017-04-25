<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;


class ViewDetailController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

}
