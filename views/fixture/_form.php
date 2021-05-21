<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Fixture */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fixture-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>
    <?= $form->field($model, 'tournament_date_id')->textInput() ?>
    <?= $form->field($model, 'teamA_id')->textInput() ?>
    <?= $form->field($model, 'teamB_id')->textInput() ?>
    <?= $form->field($model, 'teamA_score')->textInput() ?>
    <?= $form->field($model, 'teamB_score')->textInput() ?>
    <?= $form->field($model, 'start')->textInput() ?>
    <?= $form->field($model, 'end')->textInput() ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
