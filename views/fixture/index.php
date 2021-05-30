<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this             yii\web\View */
/* @var $tournament       app\models\Tournament */
/* @var $tournament_date  app\models\TournamentDate */
/* @var $dataProvider     yii\data\ActiveDataProvider */

$this->title = 'Fixtures';
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
        'url'   => ['tournament-date/index', 'tournament_id' => $tournament_date->tournament_id]
    ];
    $this->params['breadcrumbs'][] = [
        'label' => $tournament_date->name,
        'url'   => ['tournament-date/view', 'id' => $tournament_date->id]
    ];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixture-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Fixture',
        ($tournament_date !== null)
            ? ['create', 'tournament_date_id' => $tournament_date->id]
            : ['create'],
        ['class' => 'btn btn-success']
    ) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'tournament_date_id',
                'visible'   => !isset($tournament_date),
                'value'     => function($model) {
                    return isset($tournament_date) ? $tournament_date->name : $model->tournamentDate->name;
                }
            ],
            [
                'attribute' => 'teamA_id',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::img(
                        Yii::$app->request->BaseUrl.'/uploads/teamImages/' 
                        . $model->teamA->image_path, ['width' => '30px'])
                    . ' ' . $model->teamA->name;
                }
            ],
            [
                'attribute' => 'teamB_id',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::img(
                        Yii::$app->request->BaseUrl.'/uploads/teamImages/' 
                        . $model->teamB->image_path, ['width' => '30px'])
                    . ' ' . $model->teamB->name;
                }
            ],
            'teamA_score',
            'teamB_score',
            'start:datetime',
            'end:datetime',
            'is_active:boolean',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ]
        ],
    ]); ?>

</div>
