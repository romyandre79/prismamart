<!DOCTYPE html>
<html>
<head>
<?php display_seo($this->metatag, $this->description, $this->pageTitle); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/li-scroller.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/slick.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.fancybox.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/theme.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css">
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.min.js"></script> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lazysizes.min.js"></script> 
<!--[if lt IE 9]>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/html5shiv.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div id="preloader">
  <div id="status">&nbsp;</div>
</div>
<a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
<div class="container">
  <section id="navArea">
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav main_nav">
          <li class="active"><a href="<?php echo Yii::app()->createUrl('site/index')?>"><span class="fa fa-home desktop-home"></span><span class="mobile-show">Home</span></a></li>
          <?php 
            $category = getcategoryparent(); 
            foreach($category as $cat)
					{
            $hascategory = hascategorychild($cat['categoryid']);
            ?>
            <?php if ($hascategory > 0) { ?>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $cat['title']?></a>
              <?php $subcategory = getcategorychild($cat['categoryid'])?>
              <ul class="dropdown-menu" role="menu">
<?php foreach($subcategory as $subcat) {?>
  <li><a href='<?php echo Yii::app()->createUrl('/blog/category/read/'.$subcat['slug'])?>'><?php echo $subcat['title']?></a></li>
<?php }?>
            </ul>
</li>
            <?php } else {?>
              <li><a href='<?php echo Yii::app()->createUrl('/blog/category/read/'.$cat['slug'])?>'><?php echo $cat['title']?></a></li>
              <?php }?>
          <?php } ?>
        </ul>
      </div>
    </nav>
  </section>
  <section id="newsSection">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="latest_newsarea"> <span>Latest News</span>
          <ul id="ticker01" class="news_sticker">
          <?php $latests = getlatestpost();
        foreach ($latests as $post) { ?>
            <li><a href="<?php echo Yii::app()->createUrl('blog/post/'.$post['slug'])?>"><?php echo $post['title'] ?></a></li>
        <?php }?>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section id="contentSection">
    <?php echo $content?>
          </section>
  <footer id="footer">
    <div class="footer_top">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="footer_widget wow fadeInDown">
            <h2>Tag</h2>
            <ul class="tag_nav">
              <?php $tags = getalltag(); 
              foreach ($tags as $tag) {?>
              <li><a href="#"><?php echo $tag['slug']?></a></li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="footer_widget wow fadeInRightBig">
            <h2>Contact</h2>
            <p>Prisma Data Abadi</p>
            <address>
            Perumahan Taman Harapan Baru Blok S20 No 15
            Bekasi Indonesia 17131
            </address>
            <p> Romy Andre<br/>
                    Perumahan Taman Harapan Baru Blok S20 No 15<br/>
                    Bekasi, 17131<br/>
                    P: 081932701147<br/>
                    E: romy.andre@prismagrup.com<br/>               
                </p>
								<p> Kusnaedi Modiho<br/>
                    P: 085773685687<br/>
                    E: marketing@prismagrup.com<br/>               
                </p>
                <p>
                <h5>Follow us</h5>
                <div id="fb-root"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.5&appId=880703468685582";  fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><div class="fb-page" data-href="https://fb.me/CapellaERPIndonesia/" data-tabs="timeline" data-small-header="true" data-adapt-container-width="false" data-hide-cover="true" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/capellaerp/"><a href="https://www.facebook.com/capellaerp/">Capella ERP Indonesia</a></blockquote></div></div>
                </p>
          </div>
        </div>
      </div>
    </div>
    <div class="footer_bottom">
      <p class="copyright">Copyright &copy; 2045 <a href="<?php echo Yii::app()->createUrl('site/index')?>">NewsFeed</a></p>
      <p class="developer">Developed By Wpfreeware</p>
    </div>
  </footer>
</div>
<script>
$( document ).ready(function() {
  if ('ontouchstart' in document.documentElement) {
    document.addEventListener('touchstart', ontouchstart, {passive: true});
}
});
</script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/wow.min.js"></script> 
<script defer src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min.js"></script> 
<script defer src="<?php echo Yii::app()->theme->baseUrl; ?>/js/slick.min.js"></script> 
<script defer src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.li-scroller.1.0.js"></script> 
<script defer src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.newsTicker.min.js"></script> 
<script defer src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.fancybox.pack.js"></script> 
<script defer src="<?php echo Yii::app()->theme->baseUrl; ?>/js/custom.js"></script>

</body>
</html>