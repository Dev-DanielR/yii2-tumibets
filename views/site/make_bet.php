<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Team;
use app\models\Tournament;

/* @var $this            yii\web\View */
/* @var $tournament      app\models\Tournament */
/* @var $tournament_date app\models\TournamentDate */
/* @var $bets            app\models\Bets */

$this->title = Yii::t('app', 'Register bet for') . ' ' . $tournament_date->name;
$this->params['breadcrumbs'][] = $tournament->name . ': ' . $tournament_date->name;
?>
<style>
    .help-block {margin-top: 1px; margin-bottom: 0px}
    .form-group { margin-bottom: 0px; }
</style>

<div class="site-make-bet row">

    <!--Main content-->
    <?php $form = ActiveForm::begin(); ?>

    <div class="body-content">
        <div id="tournament-date-<?= $tournament_date->id ?>" class="panel panel-default">
            <div class="panel-heading"><h2><?= $tournament_date->name ?></h2></div>
            <ul class="list-group">
                <?php if (count($tournament_date->fixtures) > 0): ?>
                    <?php for ($index = 0; $index < count($tournament_date->fixtures); $index++): ?>
                        <?php
                            $fixture = $tournament_date->fixtures[$index];
                            $bet     = $bets[$index];
                        ?>
                        <li class="list-group-item" style="display: flex; flex-direction: column; gap: 10px;">
                            <h4 style="margin: 0px;"><?= $fixture->name ?></h4>
                            <?= $form->field($bet, "[$index]fixture_id")->hiddenInput(['value'=> $fixture->id])->label(false) ?>
                            <div class="row" style="display: flex; gap: 10px;">
                                <?= Html::img(Team::IMAGE_FOLDER . $fixture->teamA->image_path, ['width' => '120px', 'height' => '80px']) ?>
                                <?= $form->field($bet, "[$index]teamA_score")->textInput() ?>
                                <?= $form->field($bet, "[$index]teamB_score")->textInput() ?>
                                <?= Html::img(Team::IMAGE_FOLDER . $fixture->teamB->image_path, ['width' => '120px', 'height' => '80px']) ?>
                            </div>
                            <div><?= Yii::t('app', 'Betting period') . ': ' . $fixture->start . ' - ' . $fixture->end ?></div>
                        </li>
                    <?php endfor; ?>
                <?php else: ?>
                    <li class="list-group-item"><?= Yii::t('app', 'No Fixtures to bet on.') ?></li>
                <?php endif; ?>
            </ul>
            <?php if (count($tournament_date->fixtures) > 0): ?>
                <div class="panel-footer">
                    <?= Html::submitButton(Yii::t('app', 'Make bet'), ['class' => 'btn btn-success']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>


</div>