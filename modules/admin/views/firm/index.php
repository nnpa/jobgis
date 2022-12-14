<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FirmSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Firms';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    Если удалить фирму удаляться все ее пользователи и их вакансии и резюме
</p>
<div class="firm-index">

    <h1>Фирмы</h1>

    <p>
        <?= Html::a('Создать фирму', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\Column'],

            'id',
            'name',
            'verify',
          
            'inn',
            'city',
            [
                'label' => 'Manager',
                'value' => function ($model) {
                     return $model->managerName();
                }
            ],  
            [
                'contentOptions' => ['style' => 'width:100px;'],
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model["id"]]);
                 }
            ],
            [
                'attribute' => 'create_time',
                'format' => ['datetime', 'php:d.m.Y H:i:s']
            ],
        ],
    ]); ?>
</div>
