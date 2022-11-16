<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Firm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Firms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<p>
    Если удалить фирму удаляться все ее пользователи и их вакансии и резюме
</p>
<div class="firm-view">

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
            'verify',
            'manage_id',
            'inn',
            'site',
            'about:html'
        ],
    ]) ?>

</div>
<?php 
use app\models\AuthAssignment;

$managers = AuthAssignment::find()->where(["item_name" => "manager"])->all();
?>

<h3>Назначить менеджера</h3>
<form method="POST" action="/admin/firm/setmanager?id=<?php echo $model->id?>">
        <select name="manager">

<?php foreach($managers as $manager):?>
        <?php if(is_object($manager->user)):?>
        <option value="<?php echo $manager->user_id?>"><?php echo $manager->user->name . " " . $manager->user->surname;?></option>
        <?php endif;?>
<?php endforeach; ?>
            </select>

    <input type="submit" value="Назначить" class="btn btn-success">
</form>

<?php 
use app\models\Users;

$recruiters = Users::find()->where(["type" => 4])->all();
?>

<form method="POST" action="/admin/firm/setrec?id=<?php echo $model->id?>">
        <select name="manager">

<?php foreach($recruiters as $manager):?>
        <?php if(is_object($manager->user)):?>
        <option value="<?php echo $manager->user_id?>"><?php echo $manager->user->name . " " . $manager->user->surname;?></option>
        <?php endif;?>
<?php endforeach; ?>
            </select>

    <input type="submit" value="Назначить" class="btn btn-success">
</form>

<a href="/admin/partner/setpartner?id=<?php echo $model->id;?>">Сделать партнером<a/><br>
    <a href="/admin/firm/verify?id=<?php echo $model->id;?>">Верифицировать</a>