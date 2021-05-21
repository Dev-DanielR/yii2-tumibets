<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>
    <?= $form->field($model, 'is_admin')->checkbox() ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'main_email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'backup_email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cellphone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_validated')->checkbox() ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
