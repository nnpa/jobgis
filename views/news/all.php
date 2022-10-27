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

<?php foreach($news as $new):?>
    <a href="/news/view?id=<?php echo $new->id;?>" ><?php echo $new->title;?></a><br>
<?php endforeach; ?>
        
<?php echo LinkPager::widget([
    'pagination' => $pages,
]); ?>