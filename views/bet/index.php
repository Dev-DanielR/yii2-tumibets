<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bets');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bet-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a(Yii::t('app', 'Create Bet'), ['create'], [
        'class' => 'btn btn-success',
        'data'  => ['method' => 'post']
    ]) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'fixture_id',
            'user_id',
            'teamA_score',
            'teamB_score',
            'bet_score',
            'is_active:boolean',
            'created:datetime',
            'updated:datetime',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons'  => [
                    'view'  => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view'], ['title' => Yii::t('app', 'View'), 'data' => [ 
                                'method' => 'post',
                                'params' => ['id' => $model->id]
                            ]]
                        );
                    }
                ],
            ]
        ],
    ]); ?>

</div>
