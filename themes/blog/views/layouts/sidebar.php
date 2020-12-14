<div class="col-lg-10 col-md-10 col-sm-10">
  <div class="latest_post">
    <h2><span>Latest post</span></h2>
    <div class="latest_post_container">
      <div id="prev-button"><i class="fa fa-chevron-up"></i></div>
      <ul class="latest_postnav">
        <?php $latests = getlatestpost();
        foreach ($latests as $post) { ?>
          <li>
            <div class="media"> <a href="<?php echo Yii::app()->createUrl('blog/post/read/'.$post['slug'])?>" class="media-left">
             <img alt="" src="<?php echo Yii::app()->request->baseUrl.'/images/blog/'.$post['postpic']?>"> </img> 
             </a>
              <div class="media-body"> <a href="<?php echo Yii::app()->createUrl('blog/post/read/'.$post['slug'])?>" class="catg_title"> <?php echo $post['title']?></a> </div>
            </div>
          </li>
        <?php }?>
      </ul>
      <div id="next-button"><i class="fa  fa-chevron-down"></i></div>
      </div>
  </div>
</div>
<br/>
<div class="col-lg-10 col-md-10 col-sm-10">
<div class="latest_post">
    <h2><span>Category</span></h2>
      <ul>
        <?php $categorys = getallcategory();
        foreach ($categorys as $cat) {?>
        <li class="cat-item"><a href="<?php echo Yii::app()->createUrl('blog/category/read/'.$cat['slug']) ?>"><?php echo $cat['title']?></a></li>
        <?php }?>
      </ul>
    </div>
</div>
