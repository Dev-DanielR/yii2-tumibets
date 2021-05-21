<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TournamentDate */

$this->title = 'Create Tournament Date';
$this->params['breadcrumbs'][] = ['label' => 'Tournament Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-date-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>

</div>
