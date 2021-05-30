<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teams';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="team-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Team', ['create'], [
        'class' => 'btn btn-success',
        'data'  => ['method' => 'post']
    ]) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            [
                'label'  => 'Image',
                'format' => 'html',
                'value'  => function ($model) {
                    return Html::img(Yii::$app->request->BaseUrl.'/uploads/teamImages/' . $model->image_path,
                    ['width' => '40px']);
                }
            ],
            'is_active:boolean',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
