<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'fixture_id') ?>
    <?= $form->field($model, 'user_id') ?>
    <?= $form->field($model, 'teamA_score') ?>
    <?= $form->field($model, 'teamB_score') ?>
    <?= $form->field($model, 'bet_score') ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>
    <?= $form->field($model, 'created') ?>
    <?= $form->field($model, 'updated') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
