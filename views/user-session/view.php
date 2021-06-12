<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserSessionView */

$this->title = Yii::t('app', 'User Session') . ': ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Session Views'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
\yii\web\YiiAsset::register($this);
?>
<div class="user-session-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'is_admin:boolean',
            'login_timestamp',
            'logout_timestamp',
        ],
    ]) ?>

</div>
