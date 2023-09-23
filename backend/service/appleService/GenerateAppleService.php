<?php

namespace backend\service\appleService;

use common\models\Apple;
use Yii;

class GenerateAppleService
{
    public function generateApples($count, $redirect = false)
    {
        for ($i = 0; $i < $count; $i++) {
            $apple = new Apple();
            $apple->color = self::generateRandomColor();
            $apple->created_at = time();
            $apple->status = Apple::STATUS_ON_TREE;
            $apple->size = 100;
            $apple->save(false);
        }
        if ($redirect) {
            return Yii::$app->controller->redirect(['index']);
        }
    }

    public static function generateRandomColor()
    {
        $colors = ['red', 'green', 'yellow', 'blue', 'brown', 'black'];
        return $colors[array_rand($colors)];
    }

}