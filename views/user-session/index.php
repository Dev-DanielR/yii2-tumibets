<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Session Views');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-session-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            'is_admin:boolean',
            'login_timestamp:datetime',
            'logout_timestamp:datetime',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons'  => [
                    'view'  => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view', 'id' => $model->id],
                            ['title' => Yii::t('app', 'View')]
                        );
                    }
                ],
            ]
        ],
    ]); ?>

</div>
