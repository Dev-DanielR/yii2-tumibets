<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;

/* @var $this       yii\web\View */
/* @var $formTitle  String */
/* @var $actionName String */
/* @var $bet        app\models\Bet */
/* @var $fixtures   app\models\Fixture[] */
/* @var $form       yii\widgets\ActiveForm */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Bets'),
    'url'   => ['index'],
    'data'  => ['method' => 'post']
];
$this->params['breadcrumbs'][] = $formTitle;
$this->title = $formTitle;
?>

<div class="bet-<?= $actionName ?>">

    <h1><?= Html::encode($formTitle) ?></h1>
    <div class="bet-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($bet, 'fixture_id')->dropDownList(
            ArrayHelper::map($fixtures, "id", "name"), ['prompt' => 'Select Fixture']) ?>
        <?= $form->field($bet, 'user_id')->textInput() ?>
        <?= $form->field($bet, 'teamA_score')->textInput() ?>
        <?= $form->field($bet, 'teamB_score')->textInput() ?>
        <?= $form->field($bet, 'bet_score')->textInput() ?>
        <?= $form->field($bet, 'is_active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>