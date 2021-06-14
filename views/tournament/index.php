<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

//Tournment Index
$this->title = Yii::t('app', 'Tournaments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a(
        Yii::t('app', 'Create Tournament'),
        ['create'], ['class' => 'btn btn-success'])
    ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            [
                'label'  => Yii::t('app', 'Image'),
                'format' => 'html',
                'value'  => function ($model) {
                    return Html::img(Yii::$app->request->BaseUrl . '/uploads/tournamentImages/' . $model->image_path,
                    ['width' => '40px']);
                }
            ],
            'is_active:boolean',
            'tournament_date_count',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {dates}',
                'buttons'  => [
                    'view'  => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view', 'id' => $model->id],
                            ['title' => Yii::t('app', 'View')]
                        );
                    },
                    'dates' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-list-alt"></span>',
                            ['tournament-date/index', 'tournament_id' => $model->id],
                            ['title' => Yii::t('app', 'Dates')]
                        );
                    },
                ],
            ]
        ],
    ]); ?>

</div>
