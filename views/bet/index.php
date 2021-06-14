<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BetViewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//Bet Index
$this->title = Yii::t('app', 'Bets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bet-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a(
        Yii::t('app', 'Create Bet View'),
        ['create'], ['class' => 'btn btn-success'])
    ?> </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'tournament',
            'tournament_date',
            'fixture',
            'user',
            'teamA',
            'teamA_predicted_score',
            'teamB',
            'teamB_predicted_score',
            'bet_score',
            'is_active:boolean',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons'  => [
                    'view'  => function ($url, $model) {
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
