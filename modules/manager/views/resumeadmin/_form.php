<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Resume */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resume-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'relocation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_trips')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vacancy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spec')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'specsub')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'cash_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employment_full')->textInput() ?>

    <?= $form->field($model, 'employment_partial')->textInput() ?>

    <?= $form->field($model, 'employment_project')->textInput() ?>

    <?= $form->field($model, 'employment_volunteering')->textInput() ?>

    <?= $form->field($model, 'employment_internship')->textInput() ?>

    <?= $form->field($model, 'schedule_full')->textInput() ?>

    <?= $form->field($model, 'schedule_removable')->textInput() ?>

    <?= $form->field($model, 'schedule_flexible')->textInput() ?>

    <?= $form->field($model, 'schedule_tomote')->textInput() ?>

    <?= $form->field($model, 'schedule_tour')->textInput() ?>

    <?= $form->field($model, 'skills')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language_add')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'car')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
