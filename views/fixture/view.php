<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $tournament      app\models\Tournament */
/* @var $tournament_date app\models\TournamentDate */
/* @var $fixture         app\models\Fixture */

$this->title = $fixture->teamA->name . ' vs ' . $fixture->teamB->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Tournaments',
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
        'label' => 'Tournament Dates',
        'url'   => ['tournament/index'],
        'data'  => [
            'method' => 'post',
            'params' => ['tournament_id' => $tournament->id]
        ]
    ];
} else {
    $this->params['breadcrumbs'][] = [
        'label' => 'Tournament Dates',
        'url'   => ['tournament-date/index'],
        'data'  => ['method' => 'post']
    ];
}
if ($tournament_date !== null) {
    $this->params['breadcrumbs'][] = [
        'label' => $tournament_date->name,
        'url'   => ['tournament-date/view'],
        'data'  => [
            'method' => 'post',
            'params' => ['id' => $tournament_date->id]
        ]
    ]; 
    $this->params['breadcrumbs'][] = [
        'label' => 'Fixtures',
        'url'   => ['index'],
        'data'  => [
            'method' => 'post',
            'params' => ['tournament_date_id' => $tournament_date->id]
        ]
    ];
} else {
    $this->params['breadcrumbs'][] = [
        'label' => 'Fixtures',
        'url'   => ['index'],
        'data'  => ['method' => 'post']
    ];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="fixture-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update'], ['class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
                'params' => ['id' => $fixture->id]
            ]
        ]) ?>
        <?= Html::a('Delete', ['delete'], ['class' => 'btn btn-danger',
            'data' => [
                'method'  => 'post',
                'confirm' => 'Are you sure you want to delete this item?',
                'params'  => ['id' => $fixture->id]
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $fixture,
        'attributes' => [
            'id',
            [
                'attribute' => 'tournament_date_id',
                'value'     => $fixture->tournamentDate->name
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
