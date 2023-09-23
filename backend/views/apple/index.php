<?php

use common\models\Apple;
use yii\helpers\Html;
?>

<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
    <div class="alert alert-<?= $key ?>"><?= $message ?></div>
    <?php Yii::$app->session->removeFlash($key); ?>
<?php endforeach; ?>

<?= Html::a('Generate 5 more apples', ['generate-apples', 'count' => 5], ['class' => 'btn btn-success']) ?>


<table class="table table-striped">
    <thead>
    <tr>
        <th>Color</th>
        <th>Status</th>
        <th>Size</th>
        <th>Fallen datetime</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($apples as $apple): ?>
        <tr>
            <td><?= Html::encode($apple->color) ?></td>
            <td><?= $apple->status == Apple::STATUS_ON_TREE ? "on tree" : "on ground" ?></td>
            <td><?= Html::encode($apple->size) ?></td>
            <td><?= date('d-m-Y H:i:s', $apple->fallen_at) ?></td>
            <td>
                <?php if ($apple->status === Apple::STATUS_ON_GROUND || $apple->status == Apple::STATUS_ROTTEN): ?>
                    <?= Html::a('Eat 25%', ['eat', 'id' => $apple->id, 'percent' => 25], ['class' => 'btn btn-primary']) ?>
                <?php else: ?>
                    <?= Html::a('Fall', ['fall', 'id' => $apple->id], ['class' => 'btn btn-success']) ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>