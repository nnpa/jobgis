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
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    
    $role = "guest";
    $roleArr = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
    if(!empty($roleArr)){
        
        foreach($roleArr as $roleObj){
            if($roleObj->name == "employer"){
                $role = "employer";
            }
            if($roleObj->name == "candidate"){
                $role = "candidate";
            }
            if($roleObj->name == "admin"){
                $this->context->redirect("/admin/");
            }
            if($roleObj->name == "manager"){
                $this->context->redirect("/manager/");
            }
        }

    }
    
    NavBar::begin([
        'brandLabel' => "Jobgis",
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    
    $items = [];
    
    if($role == "guest"){
        $items = [
            ['label' => 'Работодателю', 'url' => ['/site/registeremployer']],
            ['label' => 'Соискателю', 'url' => ['/site/registercandidate']],
            ['label' => 'Войти', 'url' => ['/site/login']]
        ];
        
    }else{
        if($role=="employer"){
            $items = [
                 ['label' => 'Вакансии', 'url' => ['/site/index'], 'items' => [
                     ['label' => 'Разместить вакансию', 'url' => ['/vacancy/add']],
                     ['label' => 'Мои вакансии', 'url' => ['/vacancy/list']]
                     
                ]],
                ['label' => 'Отклики', 'url' => ['/response/employer']],
                ['label' => 'Настройки', 'url' => ['/site/useredit']],

                ['label' => 'Сотрудники', 'url' => ['/site/workers']],
                ['label' => 'Поиск', 'url' => ['/search/resume']],

                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->email . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ]; 
        }else{
            $items = [
                 ['label' => 'Резюме', 'url' => ['/site/index'], 'items' => [
                     ['label' => 'Мои резюме', 'url' => ['/resume/list']],
                     ['label' => 'Отклики и приглашения', 'url' => ['/response/candidate']]

                     
                ]],
                ['label' => 'Настройки', 'url' => ['/site/useredit']],

                ['label' => 'Поиск', 'url' => ['/search/vacancy']],

                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->email . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ]; 
        }
    }
    
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
        <a href="/search/company">Каталог компаний</a>
        <?php if(Yii::$app->user->isGuest):?>
            Контактный телефон: 8-917-462-66-90
        <?php else:?>
            <?php if(Yii::$app->user->identity->firm->id == 0):?>
                 Контактный телефон: 8-917-462-66-90
            <?php else:?>
                <?php if(Yii::$app->user->identity->firm->manage_id == 0):?>
                    Контактный телефон: 8-917-462-66-90
                <?php else:?>
                    <?php if(is_object(Yii::$app->user->identity->firm->manager)):?>
                        <?php echo "Ваш менеджер: " . Yii::$app->user->identity->firm->manager->name . " " . Yii::$app->user->identity->firm->manager->phone;?>
                    <?php endif;?>

                <?php endif;?>

            <?php endif;?>
        <?php endif;?>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
