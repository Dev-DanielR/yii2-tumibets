<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;

/* @var $this             yii\web\View */
/* @var $formTitle        String */
/* @var $actionName       String */
/* @var $tournament       app\models\Tournament */
/* @var $tournament_date  app\models\TournamentDate */
/* @var $form             yii\widgets\ActiveForm */

if ($tournament !== null) {
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
        'url'   => ['index', 'tournament_id' => $tournament->id]
    ];
} else {
    $this->params['breadcrumbs'][] = [
        'label' => 'Tournament Dates',
        'url'   => ['index']
    ];
}
$this->params['breadcrumbs'][] = $formTitle;
?>

<div class="tournament-date-<?= $actionName ?>">

    <h1><?= Html::encode($formTitle) ?></h1>
    <div class="tournament-date-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($tournament_date, 'tournament_id')->dropDownList(ArrayHelper::map($tournaments, "id", "name"), ['prompt' => 'Select Tournament']) ?>
        <?= $form->field($tournament_date, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($tournament_date, 'is_active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>