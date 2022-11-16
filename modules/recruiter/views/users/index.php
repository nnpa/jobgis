<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    Если удалить пользователя то удалятся резюме и вакансии, но останется фирма
</p>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'surname',
            'phone',
            'email',
            'company',
            //'city',
            //'email:email',
            //'password',
            //'recover_code',
            [
                'attribute' => 'create_time',
                'format' => ['datetime', 'php:d.m.Y H:i:s']
            ],            //'auth_key',
            //'access_token',
            //'patronymic',
            //'firm_id',
            [
                'contentOptions' => ['style' => 'width:100px;'],
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model["id"]]);
                 }
            ],
        ],
    ]); ?>


</div>
