<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FixtureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fixtures';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixture-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Fixture', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'tournament_date_id',
            'teamA_id',
            'teamB_id',
            'teamA_score',
            'teamB_score',
            'start:datetime',
            'end:datetime',
            'is_active:boolean',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
