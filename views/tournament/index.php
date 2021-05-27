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
    <p><?= Html::a('Create Tournament', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'is_active:boolean',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {dates}',
                'buttons' => [
                    'dates' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-list-alt"></span>',
                            ['tournament-date/index', 'tournament_id' => $model->id],
                            [
                                'title' => 'Dates',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ]
        ],
    ]); ?>

</div>
