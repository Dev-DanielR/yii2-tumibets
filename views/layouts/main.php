<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

AppAsset::register($this);

//Assign navlinks for guest user
$navLinks = [
    ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
    ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
    ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
    ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']]
];

//Assign navlinks for non-guest user based on role
if (!Yii::$app->user->isGuest) {
    $role = Yii::$app->user->identity->role;
    switch ($role) {

        //Assign navlinks for admin user
        case User::ROLE_ADMIN: $navLinks = [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
            ['label' => Yii::t('app', 'Users'), 'items' =>[
                ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']],
                ['label' => Yii::t('app', 'User Sessions'), 'url' => ['/user-session/index']],
            ]],
            ['label' => Yii::t('app', 'Teams'), 'url' => ['/team/index']],
            ['label' => Yii::t('app', 'Tournaments'), 'url' => ['/tournament/index']],
            ['label' => Yii::t('app', 'Bets'), 'url' => ['/bet/index']],
            ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
            ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
        ]; break;

        //Assign navlinks for basic user
        case User::ROLE_USER: $navLinks = [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
            ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
            ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
        ]; break;
    }

    //Add logout button
    $navLinks[] = '<li>'
    . Html::beginForm(['/site/logout'], 'post')
    . Html::submitButton(
        Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
        ['class' => 'btn btn-link logout'])
    . Html::endForm() . '</li>';
}

$breadcrumbLinks = (isset($this->params['breadcrumbs'])) ? $this->params['breadcrumbs'] : [];
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', 'TumiBets'),
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => ['class' => 'navbar-inverse navbar-fixed-top'],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => $navLinks,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget(['links' => $breadcrumbLinks]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
