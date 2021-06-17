<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Team;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Teams');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a(Yii::t('app', 'Create Team'), ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'name',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::img(Team::IMAGE_FOLDER . $model->image_path,
                    ['width' => '30px']) . ' ' . $model->name;
                }
            ],
            'is_active:boolean',
            'user_created',
            'time_created:datetime',
            'user_updated',
            'time_updated:datetime',
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
