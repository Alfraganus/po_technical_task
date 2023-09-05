<?php
namespace backend\controllers;

use common\models\Apple;
use yii\web\Controller;

class AppleController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionCreateApples($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $apple = new Apple();
            $apple->save();
        }

        return $this->redirect(['index']);
    }

    public function actionIndex()
    {
        $apples = Apple::find()->all();
        return $this->render('index', ['apples' => $apples]);
    }

    public function actionFall($id)
    {
        $apple = Apple::findOne($id);
        $apple->fallToGround();
        $apple->save();

        return $this->redirect(['index']);
    }

    public function actionEat($id, $percent)
    {
        $apple = Apple::findOne($id);
        $apple->eat($percent);

        return $this->redirect(['index']);
    }
}