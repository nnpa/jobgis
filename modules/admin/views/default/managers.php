<h3>Менеджеры</h3>
<?php foreach($managers as $manager):?>
    <?php if(is_object($manager->user)):?>
        <?php echo $manager->user->name . " " . $manager->user->surname;?>
    <?php endif;?>
<?php endforeach; ?>
