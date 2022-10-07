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
</style>

<?php 
use yii\widgets\LinkPager;
?>
<h3>Отклики</h3>

<?php foreach($response as $r):?>
    <?php if(!is_null($r->vacancy)):?>
        Ваш отклик на вакансию  <a target="_blank" href="/vacancy/show?id=<?php echo $r->vacancy->id;?>"><?php echo $r->vacancy->name;?></a> 
        <?php if($r->result == 0):?>
        Без ответа

        <?php elseif($r->result == 1):?>
            Вы приглашены
        <?php else:?>
            Отказано
        <?php endif;?>
        <br>
    <?php endif;?>
<?php endforeach; ?>


<?php echo LinkPager::widget([
    'pagination' => $pages,
]); ?>