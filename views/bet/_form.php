<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;

/* @var $this       yii\web\View */
/* @var $action     String */
/* @var $bet        app\models\Bet */
/* @var $fixtures   app\models\Fixture[] */
/* @var $form       yii\widgets\ActiveForm */

//Bet Index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Bets'),
    'url'   => ['index'],
];

//Bet View
if ($action === 'update') $this->params['breadcrumbs'][] = [
    'label' => $bet->id,
    'url'   => ['view', 'id' => $bet->id],
];

//Bet Form
$this->title = Yii::t('app', ($action === 'create') ? 'Create Bet' : 'Update Bet');
$this->params['breadcrumbs'][] = ucfirst($action);
?>

<div class="bet-<?= $action ?>">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="bet-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($bet, 'fixture_id')->dropDownList(ArrayHelper::map($fixtures, "id", "name"), ['prompt' => 'Select Fixture']) ?>
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