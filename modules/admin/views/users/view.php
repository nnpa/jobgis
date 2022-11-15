<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<p>
    Если удалить пользователя то удалятся резюме и вакансии, но останется фирма
</p>
<?php if($model->type== 2 OR $model->type == 1):?>
<a href="/admin/users/addmanager?id=<?php echo $model->id;?>">Сделать менеджером</a><br>
<a href="/admin/users/addrecruiter?id=<?php echo $model->id;?>">Сделать рекрутером</a>
<?php endif;?>
<?php if($model->type== 3):?>
<a href="/admin/default/managerdelete?id=<?php echo $model->id;?>">Уволить менеджера</a>
<?php endif;?>

<?php if($model->type== 4):?>
<a href="/admin/default/recruiter?id=<?php echo $model->id;?>">Просмотр</a><br>

<a href="/admin/default/recruiterdelete?id=<?php echo $model->id;?>">Уволить рекрутера</a>
<?php endif;?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            'name',
            'surname',
            'company',
            'phone',
            'city',
            'email:email',
            'password',
            'recover_code',
            'create_time:datetime',
            'auth_key',
            'access_token',
            'patronymic',
            'firm_id',
        ],
    ]) ?>

</div>
