<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ResumeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resume-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'photo') ?>

    <?= $form->field($model, 'surname') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'patronymic') ?>

    <?php // echo $form->field($model, 'birth_date') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'relocation') ?>

    <?php // echo $form->field($model, 'business_trips') ?>

    <?php // echo $form->field($model, 'vacancy') ?>

    <?php // echo $form->field($model, 'spec') ?>

    <?php // echo $form->field($model, 'specsub') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'cash_type') ?>

    <?php // echo $form->field($model, 'employment_full') ?>

    <?php // echo $form->field($model, 'employment_partial') ?>

    <?php // echo $form->field($model, 'employment_project') ?>

    <?php // echo $form->field($model, 'employment_volunteering') ?>

    <?php // echo $form->field($model, 'employment_internship') ?>

    <?php // echo $form->field($model, 'schedule_full') ?>

    <?php // echo $form->field($model, 'schedule_removable') ?>

    <?php // echo $form->field($model, 'schedule_flexible') ?>

    <?php // echo $form->field($model, 'schedule_tomote') ?>

    <?php // echo $form->field($model, 'schedule_tour') ?>

    <?php // echo $form->field($model, 'skills') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'language_add') ?>

    <?php // echo $form->field($model, 'car') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'exp') ?>

    <?php // echo $form->field($model, 'verify') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
