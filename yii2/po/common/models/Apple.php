<?php
namespace common\models;

use yii\db\ActiveRecord;

class Apple extends ActiveRecord
{
    const STATUS_ON_TREE = 0;
    const STATUS_ON_GROUND = 1;
    const STATUS_ROTTEN = 2;

    private string $color;
    private int $created_at;
    private int $status;
    private int $size;
    private int $fallen_at;

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

    public function init()
    {
        parent::init();
        $this->color = self::generateRandomColor();
        $this->created_at = time();
        $this->status = self::STATUS_ON_TREE;
        $this->size = 100;
    }

    public static function generateRandomColor()
    {
        $colors = ['red', 'green', 'yellow'];
        return $colors[array_rand($colors)];
    }

    public function fallToGround()
    {
        if ($this->status === self::STATUS_ON_TREE) {
            $this->status = self::STATUS_ON_GROUND;
            $this->fallen_at = time();
        }
    }

    public function eat($percent)
    {
        if ($this->status === self::STATUS_ON_TREE) {
            throw new \Exception('Съесть нельзя, яблоко на дереве');
        }

        $this->size -= $percent;
        if ($this->size <= 0) {
            $this->status = self::STATUS_ROTTEN;
            $this->delete();
        } else {
            $this->save();
        }
    }
}