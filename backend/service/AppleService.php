<?php

namespace backend\service;

use common\models\Apple;
use Yii;

class AppleService
{
    public static function generateRandomColor()
    {
        $colors = ['red', 'green', 'yellow', 'blue', 'brown', 'black'];
        return $colors[array_rand($colors)];
    }

    public function generateApples($count,$redirect = false)
    {
        for ($i = 0; $i < $count; $i++) {
            $apple = new Apple();
            $apple->color = self::generateRandomColor();
            $apple->created_at = time();
            $apple->status = Apple::STATUS_ON_TREE;
            $apple->size = 100;
            $apple->save(false);
        }
        if($redirect) {
            return Yii::$app->controller->redirect(['index']);
        }
    }

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
