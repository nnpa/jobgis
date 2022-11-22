<h5>Уволить сотрдуника <?php echo $user->name. " " . $user->surname;?></h5>

Переназначить вакансии на:<br>
<form method="POST">
    <select name="worker">
        <?php foreach($workers as $worker):?>
        <option value="<?php echo $worker->id?>"><?php echo $worker->name. " " . $worker->surname;?></option>
        <?php endforeach;?>
    </select>
    <input type="submit" class="btn btn-success" value="Назначить">
</form>