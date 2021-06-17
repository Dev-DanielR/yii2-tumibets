<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Tournament;

/* @var $this   yii\web\View */
/* @var $action String */
/* @var $model  app\models\Tournament */
/* @var $form   yii\widgets\ActiveForm */

//Tournament Index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournaments'),
    'url'   => ['index']
];

//Tournament View
if ($action === 'update') $this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url'   => ['view', 'id' => $model->id]
];

//Tournament Form
$this->title = Yii::t('app', ($action === 'create') ? 'Create Tournament' : 'Update Tournament');
$this->params['breadcrumbs'][] = ucfirst($action);
?>

<div class="tournament-<?= $action ?>">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="tournament-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= Html::img(Tournament::IMAGE_FOLDER . $model->image_path, ['width' => '360px']) ?>
        <?= $form->field($model, 'image')->fileInput() ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>