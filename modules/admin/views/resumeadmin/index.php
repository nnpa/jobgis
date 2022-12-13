<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resumes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Resume', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'city',
            'specsub',
            'verify',
            //'birth_date',
            //'gender',
            //'city',
            //'relocation',
            //'business_trips',
            'vacancy',
            //'spec',
            //'specsub',
            //'cost',
            //'cash_type',
            //'employment_full',
            //'employment_partial',
            //'employment_project',
            //'employment_volunteering',
            //'employment_internship',
            //'schedule_full',
            //'schedule_removable',
            //'schedule_flexible',
            //'schedule_tomote',
            //'schedule_tour',
            //'skills',
            //'description:ntext',
            //'language',
            //'language_add',
            //'car',
            'update_time:datetime',
            //'user_id',
            //'exp',
            //'verify',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model["id"]]);
                 }
            ],
        ],
    ]); ?>


</div>
