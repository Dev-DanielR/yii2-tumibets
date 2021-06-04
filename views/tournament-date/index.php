<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this         yii\web\View */
/* @var $tournament   app\models\Tournament */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tournament Dates');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournaments'),
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
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tournament-date-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a(Yii::t('app', 'Create Tournament Date'), ['create'], [
        'class' => 'btn btn-success',
        'data'  => [
            'method' => 'post',
            'params' => ($tournament !== null) ? ['tournament_id' => $tournament->id] : []
        ]
    ]) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'tournament_id',
                'visible'   => !isset($tournament),
                'value'     => function ($model) {
                    return isset($tournament) ? $tournament->name : $model->tournament->name;
                }
            ],
            'name',
            'is_active:boolean',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {fixtures}',
                'buttons'  => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view'], ['title' => Yii::t('app', 'View'), 'data' => [ 
                                'method' => 'post',
                                'params' => ['id' => $model->id]
                            ]]
                        );
                    },
                    'fixtures' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>',
                            ['fixture/index'], ['title' => Yii::t('app', 'Fixtures'), 'data' => [
                                'method' => 'post',
                                'params' => [
                                    'tournament_id'      => $model->tournament_id,
                                    'tournament_date_id' => $model->id
                                ]
                            ]]
                        );
                    },
                ],
            ]
        ],
    ]); ?>

</div>
