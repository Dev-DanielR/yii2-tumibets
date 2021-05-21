<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FixtureSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fixture-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'tournament_date_id') ?>
    <?= $form->field($model, 'teamA_id') ?>
    <?= $form->field($model, 'teamB_id') ?>
    <?= $form->field($model, 'teamA_score') ?>
    <?= $form->field($model, 'teamB_score') ?>
    <?= $form->field($model, 'start') ?>
    <?= $form->field($model, 'end') ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
