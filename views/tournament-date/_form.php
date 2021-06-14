<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;

/* @var $this             yii\web\View */
/* @var $action           String */
/* @var $tournament       app\models\Tournament */
/* @var $tournament_date  app\models\TournamentDate */
/* @var $form             yii\widgets\ActiveForm */

//Tournament Index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournaments'),
    'url'   => ['tournament/index']
];

//Tournament View
$this->params['breadcrumbs'][] = [
    'label' => $tournament->name,
    'url'   => ['tournament/view', 'id' => $tournament->id]
];

//Tournament Date Index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournament Dates'),
    'url'   => ['index', 'tournament_id' => $tournament->id]
];

//Tournament Date View
if ($action === 'update') $this->params['breadcrumbs'][] = [
    'label' => $tournament_date->name,
    'url'   => ['view', 'id' => $tournament_date->id]
];

//Tournament Date Form
$this->title = Yii::t('app', ($action === 'create') ? 'Create Tournament Date' : 'Update Tournament Date');
$this->params['breadcrumbs'][] = ucfirst($action);
?>

<div class="tournament-date-<?= $action ?>">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="tournament-date-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($tournament_date, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($tournament_date, 'is_active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>