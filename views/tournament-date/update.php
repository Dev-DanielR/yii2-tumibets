<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TournamentDate */

$this->title = 'Update Tournament Date: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tournament Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tournament-date-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>

</div>
