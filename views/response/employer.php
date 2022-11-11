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
<?php foreach($response as $r):?>
  <?php if(!is_null($r->resume)):?>
    <tr>
        <td>
        На <b><?php echo $r->vacancy->name;?></b> откликнулся <a target="_blank" href="/resume/show?id=<?php echo $r->resume->id;?>"><?php echo $r->resume->vacancy;?></a>
        </td>
        <td>
        <?php if($r->result == 0):?>
        <a href="/response/accept?id=<?php echo $r->id;?>">пригласить</a>
        <a href="/response/refuse?id=<?php echo $r->id;?>">отказать</a>

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