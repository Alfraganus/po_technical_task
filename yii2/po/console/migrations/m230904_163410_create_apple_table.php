<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m230904_163410_create_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'fallen_at' => $this->integer(),
            'status' => $this->smallInteger()->notNull(),
            'size' => $this->decimal(5, 2)->notNull(),
        ]);

        $this->batchInsert('{{%apple}}', ['color', 'created_at', 'fallen_at', 'status', 'size'], [
            ['green', strtotime('2023-09-01 10:00:00'), null, 0, 100.00],
            ['red', strtotime('2023-09-02 12:30:00'), strtotime('2023-09-02 15:45:00'), 1, 75.50],
            ['yellow', strtotime('2023-09-03 08:15:00'), strtotime('2023-09-03 16:30:00'), 1, 85.00],
            ['green', strtotime('2023-09-04 14:45:00'), null, 0, 98.00],
            ['red', strtotime('2023-09-05 09:30:00'), strtotime('2023-09-05 14:15:00'), 1, 70.25],
            ['yellow', strtotime('2023-09-06 12:00:00'), null, 0, 92.75],
            ['green', strtotime('2023-09-07 18:20:00'), null, 0, 99.50],
            ['red', strtotime('2023-09-08 10:45:00'), null, 0, 97.80],
            ['yellow', strtotime('2023-09-09 07:30:00'), null, 0, 94.30],
            ['green', strtotime('2023-09-10 11:15:00'), null, 0, 96.60],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
    }
}
