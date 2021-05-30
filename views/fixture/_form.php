<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this             yii\web\View */
/* @var $formTitle        String */
/* @var $actionName       String */
/* @var $tournament       app\models\Tournament */
/* @var $tournament_date  app\models\TournamentDate */
/* @var $fixture          app\models\Fixture */
/* @var $tournament_dates app\models\TournamentDate[] */
/* @var $teams            app\models\Team[] */
/* @var $form             yii\widgets\ActiveForm */

if ($tournament !== null && $tournament_date !== null) {
    $this->params['breadcrumbs'][] = [
        'label' => 'Tournaments',
        'url'   => ['tournament/index']
    ];
    $this->params['breadcrumbs'][] = [
        'label' => $tournament->name,
        'url'   => ['tournament/view', 'id' => $tournament->id]
    ];
    $this->params['breadcrumbs'][] = [
        'label' => 'Tournament Dates',
        'url'   => ['tournament-date/index', 'tournament_id' => $tournament->id]
    ];
    $this->params['breadcrumbs'][] = [
        'label' => $tournament_date->name,
        'url'   => ['tournament-date/view', 'id' => $tournament_date->id]
    ]; 
    $this->params['breadcrumbs'][] = [
        'label' => 'Fixtures',
        'url'   => ['index', 'tournament_date_id' => $tournament_date->id]
    ];
} else {
    $this->params['breadcrumbs'][] = [
        'label' => 'Tournament Dates',
        'url'   => ['index']
    ];
}
$this->params['breadcrumbs'][] = $formTitle;
$this->title = $formTitle;
?>

<div class="fixture-<?= $actionName ?>">

    <h1><?= Html::encode($formTitle) ?></h1>
    <div class="fixture-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($fixture, 'tournament_date_id')->dropDownList(ArrayHelper::map($tournament_dates, "id", "name"), ['prompt' => 'Select Tournament Date']) ?>
        <?= $form->field($fixture, 'teamA_id')->dropDownList(ArrayHelper::map($teams, "id", "name"), ['prompt' => 'Select Team']) ?>
        <?= $form->field($fixture, 'teamB_id')->dropDownList(ArrayHelper::map($teams, "id", "name"), ['prompt' => 'Select Team']) ?>
        <?php if($actionName != 'create') echo $form->field($fixture, 'teamA_score')->textInput() ?>
        <?php if($actionName != 'create') echo $form->field($fixture, 'teamB_score')->textInput() ?>
        <?= $form->field($fixture, 'start')->widget(DateTimePicker::className(), [
            'size'           => 'ms',
            'template'       => '{addon}{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'clientOptions'  => [
                'startView'  => 1,
                'minView'    => 0,
                'maxView'    => 3,
                'autoclose'  => true,
                'format'     => 'dd\mm\yy HH:ii P',
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
                'format'     => 'dd\mm\yy HH:ii P',
                'todayBtn'   => true
            ]
        ]) ?>
        <?= $form->field($fixture, 'is_active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>