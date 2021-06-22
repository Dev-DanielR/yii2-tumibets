<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Team;
use app\models\Tournament;

/* @var $this             yii\web\View */
/* @var $tournament       app\models\Tournament */
/* @var $tournament_dates app\models\TournamentDate[] */

$this->title = Yii::t('app', 'Tournament dates for') . ' ' . $tournament->name;
$this->params['breadcrumbs'][] = $tournament->name;
?>

<div class="site-check-dates row">

    <!--Side Content-->
    <div class="side-content col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h2><?= $tournament->name; ?></h2></div>
            <?= Html::img(Tournament::IMAGE_FOLDER . $tournament->image_path, ['width' => '100%']) ?>
            <ul class="list-group">
                <?php if (count($tournament_dates) > 0): ?>
                    <?php foreach($tournament_dates as $tournament_date): ?>
                        <li class="list-group-item">
                            <a href="#tournament-date-<?= $tournament_date->id ?>"><?= $tournament_date->name ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item"><?= Yii::t('app', 'No Tournament Dates yet.') ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!--Main content-->
    <div class="body-content col-lg-9">
        <?php foreach($tournament_dates as $tournament_date): ?>
            <div id="tournament-date-<?= $tournament_date->id ?>" class="panel panel-default">
                <div class="panel-heading"><h2><?= $tournament_date->name ?></h2></div>
                <ul class="list-group">
                    <?php if (count($tournament_date->fixtures) > 0): ?>
                        <?php foreach($tournament_date->fixtures as $fixture): ?>
                            <?php $fixture->datesToReadFormat() ?>
                            <li class="list-group-item" style="display: flex; flex-direction: column; gap: 10px;">
                                <h4 style="margin: 0px;"><?= $fixture->name ?></h4>
                                <div>
                                    <?= Html::img(Team::IMAGE_FOLDER . $fixture->teamA->image_path, ['width' => '80px']) ?>
                                    <h4 style="display: inline; padding: 15px;"><?= $fixture->teamA_score . ' : ' . $fixture->teamB_score ?></h4>
                                    <?= Html::img(Team::IMAGE_FOLDER . $fixture->teamB->image_path, ['width' => '80px']) ?>
                                </div>
                                <div><?= Yii::t('app', 'Betting period') . ': ' . $fixture->start . ' - ' . $fixture->end ?></div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item"><?= Yii::t('app', 'No Fixtures yet.') ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>

</div>