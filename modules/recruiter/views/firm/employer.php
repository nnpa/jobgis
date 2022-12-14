<style>
    ul.pagination li a {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
    
    ul.pagination li.active a {
            z-index: 1;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    
    
    ul.pagination li span {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
    td{
        border:1px solid black;
        padding:5px;
    }
</style>

<?php 
use yii\widgets\LinkPager;
?>
<h3>Отклики</h3>

<table>
    <tr>
        <td><b>Вакансия</b></td>
        <td><b>Соискатель</b></td>

        <td><b>Действие</b></td>
    </tr>
<?php foreach($response as $r):?>
  <?php if(!is_null($r->resume)):?>
    <tr>
        <td>
            <a href="/vacancy/show?id=<?php echo $r->vacancy->id;?>" target="_blank"><?php echo $r->vacancy->name;?></a> 
        </td>
        <td>
            <a target="_blank" href="/resume/show?id=<?php echo $r->resume->id;?>"><?php echo $r->resume->user->surname;?> <?php echo $r->resume->user->name;?> <?php echo $r->resume->user->patronymic;?></a>
        </td>
        <td>
            <?php if($r->result == 0):?>
            <a class="btn btn-success" href="/response/accept?id=<?php echo $r->id;?>">пригласить</a>
            <a class="btn btn-danger" href="/response/refuse?id=<?php echo $r->id;?>">отказать</a>

            <?php elseif($r->result == 1):?>
                Приглашен
            <?php else:?>
                Отказано
            <?php endif;?>
        </td>
    </tr>
  <?php endif;?>
<?php endforeach; ?>
</table>

<?php echo LinkPager::widget([
    'pagination' => $pages,
]); ?>