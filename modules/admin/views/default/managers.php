<h3>Менеджеры</h3>
<?php foreach($manages as $manager):?>
    <?php echo $manager->user->name . " " . $manager->user->surname;?>
<?php endforeach; ?>
