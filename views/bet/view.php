<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bet */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Bets'),
    'url'   => ['index'],
    'data'  => ['method'  => 'post']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bet-view">

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
            'fixture_id',
            'user_id',
            'teamA_score',
            'teamB_score',
            'bet_score',
            'is_active:boolean',
            'created:datetime',
            'updated:datetime',
        ],
    ]) ?>

</div>
