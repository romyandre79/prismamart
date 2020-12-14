<script src="<?php echo Yii::app()->baseUrl; ?>/js/admin/country.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('country') ?></h3>
		</div>
	<div class="card-body">
    <?php $this->widget('Button',	array('menuname'=>'country')); ?>
		<?php
		$this->widget('zii.widgets.grid.CGridView',
			array(
			'dataProvider' => $dataProvider,
			'id' => 'GridList',
			'selectableRows' => 2,
			'ajaxUpdate' => true,
			'filter' => null,
			'enableSorting' => true,
			'columns' => array(
				array(
					'class' => 'CCheckBoxColumn',
					'id' => 'ids',
					'htmlOptions' => array('style' => 'width:10px'),
				),
				array (
					'class' => 'CButtonColumn',
					'template' => '{edit} {delete} {purge} {pdf}',
					'htmlOptions' => array('style' => 'width:160px'),
					'buttons' => array (
						'edit' => array (
							'label' => getCatalog('edit'),
							'imageUrl' => Yii::app()->baseUrl.'/images/edit.png',
							'visible' => booltostr(CheckAccess('country', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
                updatedata($(this).parent().parent().children(':nth-child(3)').text());
              }",
						),
						'delete' => array (
							'label' => getCatalog('delete'),
							'imageUrl' => Yii::app()->baseUrl.'/images/active.png',
							'visible' => booltostr(CheckAccess('country', 'isreject')),
							'url' => '"#"',
							'click' => "function() {
                deletedata($(this).parent().parent().children(':nth-child(3)').text());
              }",
						),
						'purge' => array (
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('country', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
                purgedata($(this).parent().parent().children(':nth-child(3)').text());
              }",
						),
						'pdf' => array (
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('country', 'isdownload')),
							'url' => '"#"',
							'click' => "function() {
                downpdf($(this).parent().parent().children(':nth-child(3)').text());
              }",
						),
					),
				),
				array(
					'header' => getCatalog('countryid'),
					'name' => 'countryid',
					'value' => '$data["countryid"]'
				),
				array(
					'header' => getCatalog('countrycode'),
					'name' => 'countrycode',
					'value' => '$data["countrycode"]'
				),
				array(
					'header' => getCatalog('countryname'),
					'name' => 'countryname',
					'value' => '$data["countryname"]'
				),
				array(
					'class' => 'CCheckBoxColumn',
					'name' => 'recordstatus',
					'header' => getCatalog('recordstatus'),
					'selectableRows' => '0',
					'checked' => '$data["recordstatus"]',
				),
			)
		));
		?>
    <?php $this->widget('Button',	array('menuname'=>'country')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'countrycode'),
  array('searchtype'=>'text','searchname'=>'countryname')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/HP2jzBgmorE')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('country') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="countryid">
        <div class="row">
					<div class="col-md-4">
						<label for="countrycode"><?php echo getCatalog('countrycode') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="countrycode">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="countryname"><?php echo getCatalog('countryname') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="countryname">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="recordstatus"><?php echo getCatalog('recordstatus') ?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="recordstatus">
					</div>
				</div>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/adminlte.min.css">