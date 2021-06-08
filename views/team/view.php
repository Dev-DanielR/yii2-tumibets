<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Team */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Teams'),
    'url'   => ['index'],
    'data'  => ['method'  => 'post']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="team-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
                'params' => ['id' => $model->id]
            ]
        ]) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete'], [
            'class' => 'btn btn-danger',
            'data' => [
                'method'  => 'post',
                'confirm' => 'Are you sure you want to delete this item?',
                'params'  => ['id' => $model->id]
            ]
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label'  => Yii::t('app', 'Image'),
                'format' => ['image', ['width' => '80px']],
                'value'  => Yii::$app->request->BaseUrl.'/uploads/teamImages/' . $model->image_path
            ],
            'is_active:boolean',
        ],
    ]) ?>

</div>
