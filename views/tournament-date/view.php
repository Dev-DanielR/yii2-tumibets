<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this            yii\web\View */
/* @var $tournament      app\models\Tournament */
/* @var $tournament_date app\models\TournamentDate */

$this->title = $tournament_date->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Tournaments',
    'url'   => ['tournament/index'],
    'data'  => ['method' => 'post']
];
if  ($tournament !== null) {
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
        'url'   => ['index'],
        'data'  => [
            'method' => 'post',
            'params' => ['tournament_id' => $tournament->id]
        ]
    ];
} else {
    $this->params['breadcrumbs'][] = [
        'label' => 'Tournament Dates',
        'url'   => ['index'],
        'data'  => ['method' => 'post']
    ];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tournament-date-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $tournament_date->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $tournament_date->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $tournament_date,
        'attributes' => [
            'id',
            [
                'attribute' => 'tournament_id',
                'value'     => $tournament->name
            ],
            'name',
            'is_active:boolean',
        ],
    ]) ?>
    <?= Html::a('View Fixtures', ['fixture/index', 'tournament_date_id' => $tournament_date->id], ['class' => 'btn btn-success']) ?>

</div>
