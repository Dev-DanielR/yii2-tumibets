<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BetView */

//Bet index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Bets'),
    'url' => ['index']
];

//Bet View
$this->title = $model->id;
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="bet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tournament',
            'tournament_date',
            'fixture',
            'user',
            'teamA',
            'teamA_score',
            'teamA_predicted_score',
            'teamB',
            'teamB_score',
            'teamB_predicted_score',
            'bet_score',
            'is_active:boolean',
            'user_created',
            'time_created:datetime',
            'user_updated',
            'time_updated:datetime',
        ],
    ]) ?>

</div>
