<script src="<?php echo Yii::app()->baseUrl; ?>/js/common/materialtype.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('materialtype') ?></h3>
	</div>
	<div class="card-body">
    <?php $this->widget('Button',	array('menuname'=>'materialtype')); ?>
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
				array
					(
					'class' => 'CButtonColumn',
					'template' => '{edit} {delete} {purge} {pdf}',
					'htmlOptions' => array('style' => 'width:160px'),
					'buttons' => array
						(
						'edit' => array
							(
							'label' => getCatalog('edit'),
							'imageUrl' => Yii::app()->baseUrl.'/images/edit.png',
							'visible' => booltostr(CheckAccess('materialtype', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
							updatedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'delete' => array
							(
							'label' => getCatalog('delete'),
							'imageUrl' => Yii::app()->baseUrl.'/images/active.png',
							'visible' => booltostr(CheckAccess('materialtype', 'isreject')),
							'url' => '"#"',
							'click' => "function() {
							deletedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('materialtype', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
							purgedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('materialtype', 'isdownload')),
							'url' => '"#"',
							'click' => "function() {
							downpdf($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
					),
				),
				array(
					'header' => getCatalog('materialtypeid'),
					'name' => 'materialtypeid',
					'value' => '$data["materialtypeid"]'
				),
				array(
					'header' => getCatalog('materialtypecode'),
					'name' => 'materialtypecode',
					'value' => '$data["materialtypecode"]'
				),
				array(
					'header' => getCatalog('description'),
					'name' => 'description',
					'value' => '$data["description"]'
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
    <?php $this->widget('Button',	array('menuname'=>'materialtype')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'materialtypecode'),
  array('searchtype'=>'text','searchname'=>'description')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/nYQlumwhu1Y')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('materialtype') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="materialtypeid">
        <div class="row">
					<div class="col-md-4">
						<label for="materialtypecode"><?php echo getCatalog('materialtypecode') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="materialtypecode">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="description"><?php echo getCatalog('description') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="description">
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