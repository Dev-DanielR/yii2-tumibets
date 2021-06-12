<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this   yii\web\View */
/* @var $action String */
/* @var $model  app\models\Tournament */
/* @var $form   yii\widgets\ActiveForm */

$this->title = Yii::t('app', ($action === 'create') ? 'Create Tournament' : 'Update Tournament');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournaments'),
    'url'   => ['index'],
    'data'  => ['method' => 'post']
];
if ($action === 'update') $this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => ['view', 'id' => $model->id]
];
$this->params['breadcrumbs'][] = ucfirst($action);
?>

<div class="tournament-<?= $action ?>">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="tournament-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'image')->fileInput() ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>