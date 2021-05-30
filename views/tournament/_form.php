<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this       yii\web\View */
/* @var $formTitle  String */
/* @var $actionName String */
/* @var $model      app\models\Tournament */
/* @var $form       yii\widgets\ActiveForm */

$this->params['breadcrumbs'][] = [
    'label' => 'Tournaments',
    'url'   => ['index'],
    'data'  => ['method' => 'post']
];
$this->params['breadcrumbs'][] = $formTitle;
$this->title = $formTitle;
?>

<div class="tournament-<?= $actionName ?>">

    <h1><?= Html::encode($formTitle) ?></h1>
    <div class="tournament-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>