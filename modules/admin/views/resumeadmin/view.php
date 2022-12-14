<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Resume */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Resumes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="resume-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <a href="/resume/show?id=<?php echo $model->id?>" target="_blank">Резюме на сайте </a>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'photo',
            'surname',
            'name',
            'patronymic',
            'birth_date',
            'gender',
            'city',
            'relocation',
            'business_trips',
            'vacancy',
            'spec',
            'specsub',
            'cost',
            'cash_type',
            'employment_full',
            'employment_partial',
            'employment_project',
            'employment_volunteering',
            'employment_internship',
            'schedule_full',
            'schedule_removable',
            'schedule_flexible',
            'schedule_tomote',
            'schedule_tour',
            'skills',
            'description:ntext',
            'language',
            'language_add',
            'car',
            'update_time:datetime',
            'user_id',
            'exp',
            'verify',
        ],
    ]) ?>

</div>
