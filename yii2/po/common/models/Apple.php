<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property int $created_at
 * @property int|null $fallen_at
 * @property int $status
 * @property float $size
 */

class Apple extends ActiveRecord
{
    const STATUS_ON_TREE = 0;
    const STATUS_ON_GROUND = 1;
    const STATUS_ROTTEN = 2;

    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'created_at', 'status', 'size'], 'required'],
            [['created_at', 'fallen_at', 'status'], 'integer'],
            [['size'], 'number'],
            [['color'], 'string', 'max' => 255],
        ];
    }
}