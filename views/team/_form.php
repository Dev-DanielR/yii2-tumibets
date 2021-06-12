<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this   yii\web\View */
/* @var $action String */
/* @var $model  app\models\Team */
/* @var $form   yii\widgets\ActiveForm */

$this->title = Yii::t('app', ($action === 'create') ? 'Create Team' : 'Update Team');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Teams'),
    'url'   => ['index']
];
if ($action === 'update') $this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => ['view', 'id' => $model->id]
];
$this->params['breadcrumbs'][] = ucfirst($action);
?>

<div class="team-<?= $action ?>">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="team-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'image')->fileInput() ?>
            <?= $form->field($model, 'is_active')->checkbox() ?>
            <?= $form->field($model, 'user_created')->textInput() ?>
            <?= $form->field($model, 'time_created')->textInput() ?>
            <?= $form->field($model, 'user_updated')->textInput() ?>
            <?= $form->field($model, 'time_updated')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>