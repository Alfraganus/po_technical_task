<?php

namespace backend\service\appleService;

use common\models\Apple;
use Yii;

class AppleEatService
{
    public function eat($id, $percent)
    {
        $apple = Apple::findOne($id);

        if ($apple === null) {
            throw new \yii\web\NotFoundHttpException('The requested apple does not exist.');
        }
        if ($apple->status === Apple::STATUS_ON_TREE) {
            Yii::$app->session->setFlash('warning', 'You cannot eat this apple while it is on the tree.');
        } elseif ($apple->status === Apple::STATUS_ROTTEN) {
            Yii::$app->session->setFlash('warning', 'This apple is already rotten and cannot be eaten.');
        } else {
            $currentTimestamp = time();
            $fallenTimestamp = $apple->fallen_at;
            $hoursSinceFallen = ($currentTimestamp - $fallenTimestamp) / 3600;

            if ($hoursSinceFallen >= 5) {
                $apple->status = Apple::STATUS_ROTTEN;
                $apple->save(false);
                Yii::$app->session->setFlash('warning', 'Apple is already rotten!');
                return Yii::$app->controller->redirect(['index']);
            } else {
                try {
                    $apple->size -= $percent;
                    if ($apple->size <= 0) {
                        $apple->delete();
                        Yii::$app->session->setFlash('warning', 'You have eaten all of the apple.');
                        return Yii::$app->controller->redirect(['index']);
                    } else {
                        Yii::$app->session->setFlash('success', 'You have eaten ' . $percent . '% of the apple.');
                    }
                    $apple->save(false);
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return Yii::$app->controller->redirect(['index']);
    }
}