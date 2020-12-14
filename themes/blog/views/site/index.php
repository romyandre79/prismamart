<div class="slick_slider">
  <?php $sliders = getlatestslideshow();
  foreach ($sliders as $slider) { ?>
  <div class="single_iteam"> <a href="<?php echo $slider['slideurl']?>"> 
  <?php echo getpicture(Yii::app()->request->baseUrl.'/images/blog/'.$slider['slidepic'])?>
    </a>
    <div class="slider_article">
      <h2><a class="slider_tittle" href="<?php echo $slider['slideurl']?>"><?php echo $slider['slidetitle']?></a></h2>
      <p><?php echo truncateword($slider['slidedesc'],700)?></p>
    </div>
  </div>
  <?php } ?>
</div>
  <?php $category = getcategoryparent(); foreach($category as $cat) {?>
    <div class="col-lg-6 col-md-6 col-sm-6">
    <div class="single_post_content">
      <h2><span><?php echo $cat['title']?></span></h2>
      <ul class="spost_nav">
        <?php $postcats = getpostbycategory($cat['categoryid']); 
        foreach ($postcats as $postcat) { ?>
        <li>
          <div class="media wow fadeInDown"> <a href="<?php echo Yii::app()->createUrl('blog/post/read/'.$postcat['slug'])?>" class="media-left"> <img alt="" src="<?php echo Yii::app()->request->baseUrl.'/images/blog/'.$postcat['postpic']?>"> </a>
            <div class="media-body"> <a href="<?php echo Yii::app()->createUrl('blog/post/read/'.$postcat['slug'])?>" class="catg_title"><?php echo $postcat['title']?></a> </div>
          </div>
        </li>
        <?php }?>
      </ul>
  </div>
</div>  
<?php }?>
