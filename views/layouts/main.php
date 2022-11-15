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
      <link rel="icon" type="image/x-icon" href="favicon.ico">
    <script type="text/javascript" src="https://vk.com/js/api/share.js?93" charset="windows-1251"></script>
<script
  src="https://code.jquery.com/jquery-3.6.1.js"
  integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
  crossorigin="anonymous"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  




    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <meta property="og:title" content="Jobgis.ru"/>
<meta property="og:description" content="Сервис для поиска резюме и вакансий"/>
 <meta property="og:image" content="https://jobgis.ru/img/logo3.jpg"/>
<meta property="og:type" content="profile"/>
<meta property="og:url" content= "https://jobgis.ru" />


    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>


<header>
    <?php
    
    $actions = ["show","addinfo","addinn","verify","company","city","vacancy","changesort"];
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
            if($roleObj->name == "admin" AND !in_array($this->context->action->id,$actions)){
                $this->context->redirect("/admin/");
            }
            if($roleObj->name == "manager" AND !in_array($this->context->action->id,$actions)){
                $this->context->redirect("/manager/");
            }
            if($roleObj->name == "recruiter" AND !in_array($this->context->action->id,$actions)){
                $this->context->redirect("/recruiter/");
            }
        }

    }

    
    NavBar::begin([
        'brandLabel' => '<img src="/img/logo2.jpg" width="35px" height="35px">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);

    $items = [];

    if($role == "guest"){
        
        $items = [
            ['label' => 'Разместить вакансию', 'url' => ['/site/registeremployer']],
            ['label' => 'Создать резюме', 'url' => ['/site/registercandidate']],
            ['label' => 'Войти', 'url' => ['/site/login']]
        ];
        
    }else{
        if($role=="employer"){
            $items = [
                ['label' => 'Поиск', 'url' => ['/search/resume']],

                ['label' => 'Мои вакансии', 'url' => ['/vacancy/list']],
                ['label' => 'Отклики', 'url' => ['/response/employer']],
                ['label' => 'Настройки', 'url' => ['/site/useredit']],

                ['label' => 'Сотрудники', 'url' => ['/site/workers']],
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
                ['label' => 'Мои резюме', 'url' => ['/resume/list']],
                ['label' => 'Отклики и приглашения', 'url' => ['/response/candidate']],

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
        
        
        
        <a href="https://t.me/jobgis/"><img src="/img/t.png" ></a>
        <a target="_blank" href="https://vk.com/jobgis"><img src="/img/vk.png" ></a>
        <a target="_blank" href="https://dzen.ru/jobgis/"><img width="30px" height="30px" src="/img/d.jpg" ></a>
        <a target="_blank" href="https://yarus.ru/user/jobgis"><img width="30px" height="30px" src="/img/ya.jpeg" ></a>

        <a href="/search/company">Каталог компаний</a>
        <?php if(Yii::$app->user->isGuest):?>
            Техподдержка: +79174626690
        <?php else:?>
            <?php if(Yii::$app->user->identity->firm->id == 0):?>
                 Техподдержка: +79174626690
            <?php else:?>
                <?php if(Yii::$app->user->identity->firm->manage_id == 0):?>
                    Техподдержка: +79174626690
                <?php else:?>
                    <?php if(is_object(Yii::$app->user->identity->firm->manager)):?>
                        <?php echo "Ваш менеджер: " . Yii::$app->user->identity->firm->manager->name . " " . Yii::$app->user->identity->firm->manager->phone;?>
                    <?php endif;?>

                <?php endif;?>

            <?php endif;?>
        <?php endif;?>
        <?php if(!Yii::$app->user->isGuest):?>           
            <a href="/support/support">Тех поддержка</a>
        <?php endif;?>
    </div>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
       (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();
       for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
       k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

       ym(89670875, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
       });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/89670875" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?168"></script>

<!-- Put this div tag to the place, where the Community messages block will be -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
  VK.Widgets.CommunityMessages("vk_community_messages", 203009362, {tooltipButtonText: "Есть вопрос?", expanded:0});
</script>

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
