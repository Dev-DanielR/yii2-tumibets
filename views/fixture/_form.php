<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this             yii\web\View */
/* @var $action           String */
/* @var $tournament       app\models\Tournament */
/* @var $tournament_date  app\models\TournamentDate */
/* @var $fixture          app\models\Fixture */
/* @var $teams            app\models\Team[] */
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
    'url'   => ['tournament-date/index', 'tournament_id' => $tournament->id]
];

//Tournament Date View
$this->params['breadcrumbs'][] = [
    'label' => $tournament_date->name,
    'url'   => ['tournament-date/view', 'id' => $tournament_date->id]
];

//Fixture Index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournament Dates'),
    'url'   => ['index', 'tournament_id' => $tournament->id]
];

//Fixture View
if ($action === 'update') $this->params['breadcrumbs'][] = [
    'label' => $fixture->name,
    'url'   => ['view', 'id' => $fixture->id]
];

//Fixture Form
$this->title = Yii::t('app', ($action === 'create') ? 'Create Fixture' : 'Update Fixture');
$this->params['breadcrumbs'][] = ucfirst($action);
?>

<div class="fixture-<?= $action ?>">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="fixture-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($fixture, 'teamA_id')->dropDownList(ArrayHelper::map($teams, "id", "name"), ['prompt' => 'Select Team']) ?>
        <?= $form->field($fixture, 'teamB_id')->dropDownList(ArrayHelper::map($teams, "id", "name"), ['prompt' => 'Select Team']) ?>
        <?php if($action != 'create') echo $form->field($fixture, 'teamA_score')->textInput() ?>
        <?php if($action != 'create') echo $form->field($fixture, 'teamB_score')->textInput() ?>
        <?= $form->field($fixture, 'start')->widget(DateTimePicker::className(), [
            'size'           => 'ms',
            'template'       => '{addon}{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'clientOptions'  => [
                'startView'  => 1,
                'minView'    => 0,
                'maxView'    => 3,
                'autoclose'  => true,
                'format'     => 'dd/mm/yy HH:ii P',
                'todayBtn'   => true
            ]
        ]) ?>
        <?= $form->field($fixture, 'end')->widget(DateTimePicker::className(), [
            'size'           => 'ms',
            'template'       => '{addon}{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'clientOptions'  => [
                'startView'  => 1,
                'minView'    => 0,
                'maxView'    => 3,
                'autoclose'  => true,
                'format'     => 'dd/mm/yy HH:ii P',
                'todayBtn'   => true
            ]
        ]) ?>
        <?= $form->field($fixture, 'is_active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>