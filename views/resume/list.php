<h3>Мои резюме</h3>
<a href="/resume/new" class="btn btn-success">Новое резюме</a><br>
<?php foreach($resumes as $resume):?>
    <a href="/resume/edit?id=<?php echo $resume->id;?>"><?php echo $resume->vacancy;?></a>
    <small><a target="_blank" href="/resume/show?id=<?php echo $resume->id;?>">Ссылка</a></small>
    <br>
<?php endforeach; ?>
