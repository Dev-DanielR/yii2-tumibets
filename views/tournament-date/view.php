<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TournamentDateView */

//Tournament Index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournaments'),
    'url'   => ['tournament/index']
];

//Tournament View
$this->params['breadcrumbs'][] = [
    'label' => $model->tournament,
    'url'   => ['tournament/view', 'id' => $model->tournament_id]
];

//Tournament Date Index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tournament Dates'),
    'url'   => ['index', 'tournament_id' => $model->tournament_id]
];

//Tournament Date View
$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="tournament-date-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Update'),
            ['update',
                'id'            => $model->id,
                'tournament_id' => $model->tournament_id],
            ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'),
            ['delete', 'id' => $model->id],
            ['class' => 'btn btn-danger', 'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post'
            ]]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'is_active:boolean',
            'fixture_count',
            'user_created',
            'time_created:datetime',
            'user_updated',
            'time_updated:datetime',
        ],
    ]) ?>
    <?= Html::a('View Fixtures',
        ['fixture/index', 'tournament_date_id' => $model->id],
        ['class' => 'btn btn-success'])
    ?>

</div>
