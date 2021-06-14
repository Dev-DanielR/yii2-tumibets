<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this          yii\web\View */
/* @var $tournament    app\models\Tournament */
/* @var $dataProvider  yii\data\ActiveDataProvider */

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
$this->title = Yii::t('app', 'Tournament Dates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-date-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p> <?= Html::a(
        Yii::t('app', 'Create Tournament Date'), 
        ['create', 'tournament_id' => $tournament->id],
        ['class' => 'btn btn-success'])
    ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['attribute' => 'tournament', 'visible' => !isset($tournament)],
            'id',
            'name',
            'is_active:boolean',
            'fixture_count',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {fixtures}',
                'buttons'  => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view', 'id' => $model->id],
                            ['title' => Yii::t('app', 'View')]
                        );
                    },
                    'fixtures' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-list-alt"></span>',
                            ['fixture/index', 'tournament_date_id' => $model->id], 
                            ['title' => Yii::t('app', 'Fixtures')]
                        );
                    },
                ],
            ]
        ],
    ]); ?>


</div>
