<?php
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}
?>
<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
<script
  src="https://code.jquery.com/jquery-3.6.1.js"
  integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
  crossorigin="anonymous"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  




    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link type="text/css" rel="stylesheet" href="/css/jquery-te-1.4.0.css">
<script type="text/javascript" src="/js/jquery-te-1.4.0.min.js" charset="utf-8"></script>

</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    

    
    NavBar::begin([
        'brandLabel' => Html::img('@web/img/logo.jpg', ['alt'=>Yii::$app->name]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    
    $items = [];

        $items = [
            ['label' => 'Пользователи', 'url' => ['#'], 'items' => [
                ['label' => 'Работодатель', 'url' => ['/admin/users/em']],
                ['label' => 'Соискатель', 'url' => ['/admin/users/can']],
                ['label' => 'Менеджеры', 'url' => ['/admin/users/man']],
                ['label' => 'Рекрутеры', 'url' => ['/admin/users/rec']],

            ]],
  
            ['label' => 'Инструменты', 'url' => ['#'], 'items' => [
                ['label' => 'Пригласить', 'url' => ['/admin/firm/add']],
                ['label' => 'Навыки', 'url' => ['/admin/skills/index']],
                ['label' => 'Новости', 'url' => ['/admin/news/index']],
                ['label' => 'Тех поддержка', 'url' => ['/admin/support/index']],
                ['label' => 'Rss', 'url' => ['/admin/default/rss']],
                ['label' => 'Подписки', 'url' => ['/admin/default/notify']],

            ]],

            ['label' => 'Фирмы', 'url' => ['/admin/firm/index']],
            ['label' => 'Резюме', 'url' => ['/admin/resumeadmin/index']],
            ['label' => 'Онлайн', 'url' => ['/admin/users/on']],
            ['label' => 'Партнеры', 'url' => ['/admin/partner/index']],

            ['label' => 'Выход', 'url' => ['/admin/default/logout']],
        ];
        
    
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $items
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
