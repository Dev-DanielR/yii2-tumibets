<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tournament */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Tournaments',
    'url'   => ['index'],
    'data'  => ['method' => 'post']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tournament-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update'], ['class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
                'params' => ['id' => $model->id]
            ]
        ]) ?>
        <?= Html::a('Delete', ['delete'], ['class' => 'btn btn-danger',
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
            'is_active:boolean',
        ],
    ]) ?>
    <?= Html::a('View Dates', ['tournament-date/index'], ['class' => 'btn btn-success',
        'data' => [
            'method' => 'post',
            'params' => ['tournament_id' => $model->id]
        ]
    ]) ?>

</div>
