<style>
    td {
        border:1px solid black;
        padding:5px;
    }
</style>
<h5>Топ рекрутеров за <?php echo $top;?></h5>

<table>
    <tr>
        <td><b>Рекрутер</b></td>
        <td><b>Город</b></td>

    </tr>
<?php foreach($result as $row):?>
    <tr>
        <td><a href="/site/recruiterview?id=<?php echo $row["id"];?>"><?php echo $row["name"]. " " . $row["surname"]?></a></td>
        <td><?php echo $row["city"];?></td>

    </tr>
<?php endforeach; ?>
</table>