<?php

namespace backend\service\appleService;

use common\models\Apple;
use Yii;

class AppleFallService
{
    public function fall($id)
    {
        $apple = Apple::findOne($id);

        if ($apple === null) {
            throw new \yii\web\NotFoundHttpException('The requested apple does not exist.');
        }
        if ($apple->status == Apple::STATUS_ON_TREE) {
            $apple->status = Apple::STATUS_ON_GROUND;
            $apple->fallen_at = time();
            $apple->save(false);
            Yii::$app->session->setFlash('success', 'The apple has fallen to the ground.');
        } else {
            Yii::$app->session->setFlash('warning', 'The apple is already on the ground.');
        }
        return Yii::$app->controller->redirect(['index']);
    }

}