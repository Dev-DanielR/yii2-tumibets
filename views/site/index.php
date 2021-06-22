<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Tournament;

/* @var $this             yii\web\View */
/* @var $model            app\models\LanguageForm */
/* @var $tournament       app\models\Tournament */
/* @var $tournament_dates app\models\TournamentDate[] */

$this->title = Yii::t('app', 'TumiBets');
?>
<div class="site-index row">

    <?php $form = ActiveForm::begin(['id' => 'language-form', ])?>
        <?= $form->field($model, 'selected')->dropDownList(
            $model->locales,
            ['onchange' => 'this.form.submit()']
        ); ?>
    <?php ActiveForm::end() ?>

    <!--Main content-->
    <div class="body-content col-lg-8">

        <!--Active Tournament-->
        <div class="panel panel-default">
            <div class="panel-heading"><h1><?= $tournament->name ?></h1></div>
            <?= Html::img(Tournament::IMAGE_FOLDER . $tournament->image_path, ['width' => '100%']) ?>
            <div class="panel-body">
                <h3><?= Yii::t('app', 'How to play') ?></h3>
                <ul>
                    <li><?= Yii::t('app', 'You must be registered to play.') ?></li>
                    <li><?= Yii::t('app', 'You get to make a bet for each Fixture in the active Tournament Date.') ?></li>
                    <li><?= Yii::t('app', 'Each Fixture has a deadline to make or change bets. Make sure to check.') ?></li>
                    <li><?= Yii::t('app', 'You get rewarded 3 points for correctly predicting the exact score of each Team.') ?></li>
                    <li><?= Yii::t('app', 'You get rewarded 1 points if you only correctly predict the result of the match.') ?></li>
                    <li><?= Yii::t('app', 'The participant with most points wins.') ?></li>
                </ul>
                <?= Html::a(Yii::t('app', 'Check dates'),
                    ['check-dates', 'id' => $tournament->id],
                    ['class' => 'btn btn-primary'])
                ?>
            </div>
        </div>

        <!--Past Tournament Dates for Active Tournament-->
        <div class="panel panel-default">
            <div class="panel-heading"><?= Yii::t('app', 'Past Tournament Dates') ?></div>
            <ul class="list-group">
            <?php if (count($tournament_dates) > 0): ?>
                <?php foreach ($tournament_dates as $past_date): ?>
                    <li class="list-group-item">
                        <h2><?= $past_date->name ?></h2>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                            ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                            fugiat nulla pariatur.</p>

                        <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item"><?= Yii::t('app', 'No Tournament Dates yet.') ?></li>
            <?php endif; ?>
            </ul>
        </div>
    </div>

    <!--Side Content-->
    <div class="side-content col-lg-4">

        <!--Participant Ranking List for Active Tournament Date-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><?= $tournament_date->name ?></h3>
                <?= Html::a(Yii::t('app', 'Participate here!'),
                    ['make-bet'],
                    ['class' => 'btn btn-primary'])
                ?>
            </div>
            <table class="table">
                <tr>
                    <th>#</th>
                    <th><?= Yii::t('app', 'Participant') ?></th>
                    <th><?= Yii::t('app', 'Score') ?></th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Person 1</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Person 2</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Person 3</td>
                    <td>8</td>
                </tr>
            </table>
        </div>
    </div>

</div>
