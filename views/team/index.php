<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Teams');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="team-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a(Yii::t('app', 'Create Team'), ['create'], [
        'class' => 'btn btn-success',
        'data'  => ['method' => 'post']
    ]) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            [
                'label'  => Yii::t('app', 'Image'),
                'format' => 'html',
                'value'  => function ($model) {
                    return Html::img(Yii::$app->request->BaseUrl.'/uploads/teamImages/' . $model->image_path,
                    ['width' => '40px']);
                }
            ],
            'is_active:boolean',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons'  => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view'], ['title' => Yii::t('app', 'View'), 'data' => [ 
                                'method' => 'post',
                                'params' => ['id' => $model->id]
                            ]]
                        );
                    }
                ]
            ]
        ],
    ]); ?>

</div>
