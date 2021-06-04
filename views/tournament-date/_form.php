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

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournaments'),
    'url'   => ['tournament/index'],
    'data'  => ['method' => 'post']
];
if ($tournament !== null) {
    $this->params['breadcrumbs'][] = [
        'label' => $tournament->name,
        'url'   => ['tournament/view'],
        'data'  => [
            'method' => 'post',
            'params' => ['id' => $tournament->id]
        ]
    ];
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('app', 'Tournament Dates'),
        'url'   => ['index'],
        'data'  => [
            'method' => 'post',
            'params' => ['tournament_id' => $tournament->id]
        ]
    ];
} else {
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('app', 'Tournament Dates'),
        'url'   => ['index'],
        'data'  => ['method' => 'post']
    ];
}
$this->params['breadcrumbs'][] = $formTitle;
$this->title = $formTitle;
?>

<div class="tournament-date-<?= $actionName ?>">

    <h1><?= Html::encode($formTitle) ?></h1>
    <div class="tournament-date-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($tournament_date, 'tournament_id')->dropDownList(ArrayHelper::map($tournaments, "id", "name"), ['prompt' => 'Select Tournament']) ?>
        <?= $form->field($tournament_date, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($tournament_date, 'is_active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>