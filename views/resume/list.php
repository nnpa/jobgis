<style>
    td{
        border:1px solid black;
        padding:5px;
    }
</style>
<h3>Мои резюме</h3>
<a href="/resume/new" onClick="return confirm('Создать резюме?')" class="btn btn-success">Новое резюме</a><br>

<table>
    <tr>
        <td>Резюме</td>
        <td>Ссылка</td>
    </tr>
<?php foreach($resumes as $resume):?>
    <tr>
        <td>    
            <a href="/resume/edit?id=<?php echo $resume->id;?>"><?php echo $resume->vacancy;?></a>
        </td>
        <td>   
            <a target="_blank" href="/resume/show?id=<?php echo $resume->id;?>">Посмотреть</a>
        </td>
    </tr>

    <br>
<?php endforeach; ?>
</table>
