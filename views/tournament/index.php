<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TournamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tournaments';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tournament-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Tournament', ['create'], [
        'class' => 'btn btn-success',
        'data'  => ['method' => 'post']
    ]) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'is_active:boolean',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {dates}',
                'buttons'  => [
                    'view'  => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view'], ['title' => 'View', 'data' => [ 
                                'method' => 'post',
                                'params' => ['id' => $model->id]
                            ]]
                        );
                    },
                    'dates' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>',
                            ['tournament-date/index'], ['title' => 'Dates', 'data' => [ 
                                'method' => 'post',
                                'params' => ['tournament_id' => $model->id]
                            ]]
                        );
                    },
                ],
            ]
        ],
    ]); ?>

</div>
