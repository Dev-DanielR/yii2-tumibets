<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Team;

/* @var $this            yii\web\View */
/* @var $tournament      app\models\Tournament */
/* @var $tournament_date app\models\TournamentDate */
/* @var $dataProvider    yii\data\ActiveDataProvider */

//Tournament Index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournaments'),
    'url'   => ['tournament/index']
];

//Tournament View
$this->params['breadcrumbs'][] = [
    'label' => $tournament->name,
    'url'   => ['tournament/view', 'id' => $tournament->id]
];

//Tournament Date Index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournament Dates'),
    'url'   => ['tournament-date/index', 'tournament_id' => $tournament->id]
];

//Tournament Date View
$this->params['breadcrumbs'][] = [
    'label' => $tournament_date->name,
    'url'   => ['tournament-date/view', 'id' => $tournament_date->id]
];

//Fixture Index
$this->title = Yii::t('app', 'Fixtures');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixture-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a(
        Yii::t('app', 'Create Fixture'),
        ['create', 'tournament_date_id' => $tournament_date->id],
        ['class' => 'btn btn-success'])
    ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['attribute' => 'tournament', 'visible' => !isset($tournament)],
            ['attribute' => 'tournament_date', 'visible' => !isset($tournament_date)],
            'id',
            [
                'attribute' => 'teamA',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::img(Team::IMAGE_FOLDER . $model->teamA_image_path, ['width' => '30px']) . ' ' . $model->teamA;
                }
            ],
            'teamA_score',
            [
                'attribute' => 'teamB',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::img(Team::IMAGE_FOLDER . $model->teamB_image_path, ['width' => '30px']) . ' ' . $model->teamB;
                }
            ],
            'teamB_score',
            'start:datetime',
            'end:datetime',
            'is_active:boolean',
            'bet_count',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons'  => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view', 'id' => $model->id],
                            ['title' => Yii::t('app', 'View')]
                        );
                    }
                ],
            ]
        ],
    ]); ?>


</div>
