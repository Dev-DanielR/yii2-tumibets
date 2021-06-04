<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'User') . ': ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update'], ['class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
                'params' => ['id' => $model->id]
            ]
        ]) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete'], ['class' => 'btn btn-danger',
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
            'is_admin:boolean',
            'username',
            'main_email:email',
            'backup_email:email',
            'cellphone',
            'is_validated:boolean',
            'is_active:boolean',
            'created:datetime',
        ],
    ]) ?>

</div>
