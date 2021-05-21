<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>
    <?= $form->field($model, 'fixture_id')->textInput() ?>
    <?= $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'teamA_score')->textInput() ?>
    <?= $form->field($model, 'teamB_score')->textInput() ?>
    <?= $form->field($model, 'bet_score')->textInput() ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>
    <?= $form->field($model, 'created')->textInput() ?>
    <?= $form->field($model, 'updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
