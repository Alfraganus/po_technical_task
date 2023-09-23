<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Apple;
use backend\service\AppleService;
use backend\service\appleService\AppleEatService;
use backend\service\appleService\AppleFallService;
use backend\service\appleService\GenerateAppleService;

class AppleController extends SiteController
{
    private $generateDumpService;
    private $appleFallService;
    private $appleEatService;

    public function __construct(
        $id,
        $module,
        GenerateAppleService $generateAppleService,
        AppleFallService $appleFallService,
        AppleEatService $appleEatService,
        $config = []
    )
    {
        $this->generateDumpService = $generateAppleService;
        $this->appleEatService = $appleEatService;
        $this->appleFallService = $appleFallService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $apples = Apple::find()->all();
        return $this->render('index', ['apples' => $apples]);
    }

    public function actionGenerateApples($count)
    {
        $this->generateDumpService->generateApples($count,true);
    }

    public function actionFall($id)
    {
        $this->appleFallService->fall($id);
    }

    public function actionEat($id, $percent)
    {
        $this->appleEatService->eat($id, $percent);
    }
}