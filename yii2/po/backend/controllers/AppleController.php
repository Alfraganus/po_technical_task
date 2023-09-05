<?php

namespace backend\controllers;

use backend\service\AppleService;
use Yii;
use yii\web\Controller;
use common\models\Apple;

class AppleController extends Controller
{
    private $appleService;

    public function __construct($id, $module, AppleService $appleService, $config = [])
    {
        $this->appleService = $appleService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $apples = Apple::find()->all();
        return $this->render('index', ['apples' => $apples]);
    }

    public function actionGenerateApples($count)
    {
        $this->appleService->generateApples($count,true);
    }

    public function actionFall($id)
    {
        $this->appleService->fall($id);
    }

    public function actionEat($id, $percent)
    {
        $this->appleService->eat($id, $percent);
    }

}