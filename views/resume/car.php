<h3>Водительские права</h3>
<?php 
    $carArr = [
        "A","B","C","D","E","BE","CE","DE","Tm","Tb"
    ];
?>

<form method="POST">
    <select name="car">
        <?php foreach ($carArr as $car):?>
            <option value="<?php echo $car;?>" <?php echo ($car == $resume->car)?'selected':''?>><?php echo $car;?>
        <?php endforeach;?>
    </select><br>
    <input type="submit" value="Сохранить" class="btn btn-success">
</form>