<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Team;

/* @var $this  yii\web\View */
/* @var $model app\models\FixtureView */

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
    'url'   => ['tournament/index', 'tournament_id' => $model->tournament_id]
];

//Tournament Date View
$this->params['breadcrumbs'][] = [
    'label' => $model->tournament_date,
    'url'   => ['tournament-date/view', 'id' => $model->tournament_date_id]
];

//Fixture Index
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Fixtures'),
    'url' => ['index', 'tournament_date_id' => $model->tournament_date_id]
];

//Fixture View
$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="fixture-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Update'),
            ['update',
                'id'                 => $model->id,
                'tournament_date_id' => $model->tournament_date_id],
            ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'),
            ['delete', 'id' => $model->id],
            ['class' => 'btn btn-danger', 'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ]]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tournament',
            'tournament_date',
            'id',
            [
                'attribute' => 'teamA',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::img(Team::IMAGE_FOLDER . $model->teamA_image_path, ['width' => '30px']) . ' ' . $model->teamA;
                }
            ],
            'teamA_score',
            [
                'attribute' => 'teamB',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::img(Team::IMAGE_FOLDER . $model->teamB_image_path, ['width' => '30px']) . ' ' . $model->teamB;
                }
            ],
            'teamB_score',
            'start:datetime',
            'end:datetime',
            'is_active:boolean',
            'bet_count',
            'user_created',
            'time_created:datetime',
            'user_updated',
            'time_updated:datetime',
        ],
    ]) ?>

</div>
