<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use common\models\Apple;

foreach ($apples as $apple): ?>
    <div class="apple-item">
        <p>
            Яблоко цвета <?= Html::encode($apple->color) ?>, размер <?= $apple->size ?>%
        </p>
        <?php if ($apple->status === Apple::STATUS_ON_TREE): ?>
            <button class="btn btn-primary" onclick="fall(<?= $apple->id ?>)">Упасть</button>
        <?php elseif ($apple->status === Apple::STATUS_ON_GROUND): ?>
            <?php $form = ActiveForm::begin([
                'action' => ['apple/eat', 'id' => $apple->id],
                'method' => 'post',
            ]); ?>
            <?= $form->field($apple, 'size')->textInput(['type' => 'number', 'min' => 1, 'max' => 100])->label('Съесть (в %):') ?>
            <button class="btn btn-success" onclick="eat(<?= $apple->id ?>, 25)">Съесть</button>
            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<script>
    function fall(id) {
        $.ajax({
            type: 'POST',
            url: '<?= Yii::$app->urlManager->createUrl(['apple/fall']) ?>?id=' + id,
            success: function () {
                location.reload();
            }
        });
    }
    function eat(id, percent) {
        $.ajax({
            type: 'POST',
            url: '<?= Yii::$app->urlManager->createUrl(['apple/eat']) ?>?id=' + id + '&percent=' + percent,
            success: function () {
                location.reload();
            }
        });
    }
</script>
