<h3>Пригласить работодателя</h3>
<form method="POST">
    Email <input type="text" name="email"><br>
    Название компании <input type="text" name="company"><br>
    <input type="submit" class="btn btn-success" value="Отправить приглашение">
    
</form>

<h5>Реферальная ссылка для регистрации кандидата</h5>
<?php echo "https://jobgis.ru/site/registercandidate?ref={$id}";?>