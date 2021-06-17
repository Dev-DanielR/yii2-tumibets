<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this   yii\web\View */
/* @var $action String */
/* @var $model  app\models\User */
/* @var $form   yii\widgets\ActiveForm */

$this->title = Yii::t('app', ($action === 'create') ? 'Create User' : 'Update User');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Users'),
    'url' => ['index']
];
if ($action === 'update') $this->params['breadcrumbs'][] = [
    'label' => $model->username,
    'url' => ['view', 'id' => $model->id]
];
$this->params['breadcrumbs'][] = ucfirst($action);

$roles = [
    1   => Yii::t('app', 'User'),
    100 => Yii::t('app', 'Admin')
]
?>
<div class="user-<?= $action ?>">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'role')->dropDownList($roles) ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'main_email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'backup_email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'cellphone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'is_validated')->checkbox() ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
