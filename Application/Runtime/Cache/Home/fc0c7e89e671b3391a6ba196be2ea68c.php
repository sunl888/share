<?php if (!defined('THINK_PATH')) exit();?><li>相关内容</li>
<?php if(empty($searchResult)): ?><p>没有找到<strong style="color:#f30">"<?php echo ($keyWords); ?>"</strong></p>
<?php else: ?> 
   <?php if(is_array($searchResult)): foreach($searchResult as $key=>$item): ?><li><a href="<?php echo U('Play/index',['vid'=>$item['id']]);?>">
            <?php echo str_ireplace($keyWords,"<strong style='color:#f30'>$keyWords</strong>",$item['name']); ?>
        </a></li><?php endforeach; endif; endif; ?>