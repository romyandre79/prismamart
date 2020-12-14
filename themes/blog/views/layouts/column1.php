<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<section class="main-body">
  <div class="container">
  <div class="row">
	
    <div class="col-md-8">
        <!-- Include content pages -->
        <?php echo $content; ?>
	</div><!--/span-->
    
    <div class="col-md-4">
		<?php include_once('sidebar.php');?>
		
    </div><!--/span-->
  </div><!--/row-->
</div>
</section>


<?php $this->endContent(); ?>