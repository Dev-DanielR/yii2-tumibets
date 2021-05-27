<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $tournament       app\models\Tournament */
/* @var $tournament_date  app\models\TournamentDate */
/* @var $fixture          app\models\Fixture */

$this->title = $fixture->id;
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
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fixture-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $fixture->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $fixture->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $fixture,
        'attributes' => [
            'id',
            [
                'attribute' => 'tournament_date_id',
                'value'     => function ($fixture) { return $fixture->tournamentDate->name; }
            ],
            [
                'attribute' => 'teamA_id',
                'format'    => 'html',
                'value'     => function ($fixture) {
                    return Html::img(
                        Yii::$app->request->BaseUrl.'/uploads/teamImages/' 
                        . $fixture->teamA->image_path, ['width' => '40px'])
                    . ' ' . $fixture->teamA->name;
                }
            ],
            [
                'attribute' => 'teamB_id',
                'format'    => 'html',
                'value'     => function ($fixture) {
                    return Html::img(
                        Yii::$app->request->BaseUrl.'/uploads/teamImages/' 
                        . $fixture->teamB->image_path, ['width' => '40px'])
                    . ' ' . $fixture->teamB->name;
                }
            ],
            'teamA_score',
            'teamB_score',
            'start:datetime',
            'end:datetime',
            'is_active:boolean',
        ],
    ]) ?>

</div>
