<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this         yii\web\View */
/* @var $tournament   app\models\Tournament */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tournament Dates';
if ($tournament !== null) {
    $this->params['breadcrumbs'][] = [
        'label' => 'Tournaments',
        'url'   => ['tournament/index']
    ];
    $this->params['breadcrumbs'][] = [
        'label' => $tournament->name,
        'url'   => ['tournament/view', 'id' => $tournament->id]
    ];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-date-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Tournament Date',
        ($tournament !== null)
            ? ['create', 'tournament_id' => $tournament->id]
            : ['create'],
        ['class' => 'btn btn-success']
    ) ?></p>

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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {dates}',
                'buttons' => [
                    'dates' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-list-alt"></span>',
                            ['fixture/index',
                                'tournament_id'      => $model->tournament_id,
                                'tournament_date_id' => $model->id
                            ],
                            ['title' => 'Fixtures', 'data-pjax' => '0']
                        );
                    },
                ],
            ]
        ],
    ]); ?>

</div>
