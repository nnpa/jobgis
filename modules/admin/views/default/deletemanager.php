<h3>Увольнение менеджера <?php echo $manager->user->name . " " . $manager->user->surname;?></h3>
Переназначить фирмы на:

<form method="POST" >
    
    <select name="manager">

<?php 
use app\models\AuthAssignment;

$managers = AuthAssignment::find()->where(["item_name" => "manager"])->all();
?>
<?php foreach($managers as $m):?>
        <?php if(is_object($m->user)):?>
        
            <?php if($m->user_id != $manager->user->id):?>
                <option value="<?php echo $m->user_id?>"><?php echo $m->user->name . " " . $m->user->surname;?></option>
            <?php endif;?>
        <?php endif;?>
<?php endforeach; ?>
</select>
    
<input type="submit" value="Уволить" class="btn btn-success">

</form>