<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Team;

/* @var $this yii\web\View */
/* @var $model app\models\TeamView */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="team-view-view">

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
            'name',
            [
                'label'  => Yii::t('app', 'Image'),
                'format' => ['image', ['width' => '120px']],
                'value'  => Team::IMAGE_FOLDER . $model->image_path
            ],
            'is_active:boolean',
            'user_created',
            'time_created:datetime',
            'user_updated',
            'time_updated:datetime',
        ],
    ]) ?>

</div>
