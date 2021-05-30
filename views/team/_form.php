<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this       yii\web\View */
/* @var $formTitle  String */
/* @var $actionName String */
/* @var $model      app\models\Team */
/* @var $form       yii\widgets\ActiveForm */

$this->params['breadcrumbs'][] = [
    'label' => 'Teams',
    'url'   => ['index'],
    'data'  => ['method' => 'post']
];
$this->params['breadcrumbs'][] = $formTitle;
$this->title = $formTitle;
?>

<div class="team-<?= $actionName ?>">

    <h1><?= Html::encode($formTitle) ?></h1>
    <div class="team-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'image')->fileInput() ?>
            <?= $form->field($model, 'is_active')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>