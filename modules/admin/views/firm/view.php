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
<div class="firm-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
        <option value="<?php echo $manager->user_id?>"><?php echo $manager->user->name . " " . $manager->user->surname;?></option>
<?php endforeach; ?>
            </select>

    <input type="submit" value="Назначить" class="btn btn-success">
</form>
