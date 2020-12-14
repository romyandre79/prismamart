<script src="<?php echo Yii::app()->baseUrl; ?>/js/common/materialgroup.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('materialgroup') ?></h3>
	</div>
	<div class="card-body">
    <?php $this->widget('Button',	array('menuname'=>'materialgroup')); ?>
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
							'visible' => booltostr(CheckAccess('materialgroup', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
							updatedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'delete' => array
							(
							'label' => getCatalog('delete'),
							'imageUrl' => Yii::app()->baseUrl.'/images/active.png',
							'visible' => booltostr(CheckAccess('materialgroup', 'isreject')),
							'url' => '"#"',
							'click' => "function() {
							deletedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('materialgroup', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
							purgedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('materialgroup', 'isdownload')),
							'url' => '"#"',
							'click' => "function() {
							downpdf($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
					),
				),
				array(
					'header' => getCatalog('materialgroupid'),
					'name' => 'materialgroupid',
					'value' => '$data["materialgroupid"]'
				),
				array(
					'header' => getCatalog('materialgroupcode'),
					'name' => 'materialgroupcode',
					'value' => '$data["materialgroupcode"]'
				),
				array(
					'header' => getCatalog('materialgrouppic'),
					'name' => 'materialgrouppic',
					'type' => 'raw',
					'value' => 'CHtml::image(Yii::app()->baseUrl."/images/materialgroup/".$data["materialgrouppic"],$data["materialgroupcode"],
					array("width"=>"100"))'
				),
				array(
					'header' => getCatalog('description'),
					'name' => 'description',
					'value' => '$data["description"]'
				),
				array(
					'header' => getCatalog('materialtypecode'),
					'name' => 'materialtypeid',
					'value' => '$data["materialtypecode"]'
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
    <?php $this->widget('Button',	array('menuname'=>'materialgroup')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'materialgroupcode'),
  array('searchtype'=>'text','searchname'=>'description'),
  array('searchtype'=>'text','searchname'=>'materialtypecode')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/yX5MbX1xKYA')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('materialgroup') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="materialgroupid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'materialtypeid', 'ColField' => 'materialtypecode',
					'IDDialog' => 'materialtypeid_dialog', 'titledialog' => getCatalog('materialtypecode'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.MaterialtypePopUp', 'PopGrid' => 'materialtypeidgrid'));
				?>	        <div class="row">
					<div class="col-md-4">
						<label for="materialgroupcode"><?php echo getCatalog('materialgroupcode') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="materialgroupcode">
					</div>
				</div>
        <script>
					function successUp(param, param2, param3) {
						$('input[name="materialgrouppic"]').val(param2);
						$('div.dz-success').remove();
					}
					function addedfile(param, param2, param3) {
						$('div.dz-success').remove();
					}
				</script>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-8">
						<?php
						$events = array(
							'success' => 'successUp(param,param2,param3)',
							'addedfile' => 'addedfile(param,param2,param3)'
						);
						$this->widget('ext.dropzone.EDropzone',
							array(
							'name' => 'upload',
							'url' => Yii::app()->createUrl('common/materialgroup/upload'),
							'mimeTypes' => array('.jpg', '.png', '.jpeg'),
							'events' => $events,
							'options' => CMap::mergeArray($this->options, $this->dict),
							'htmlOptions' => array('style' => 'height:95%; overflow: hidden;'),
						));
						?></div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label for="materialgrouppic"><?php echo getCatalog('materialgrouppic') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="materialgrouppic" readonly>
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
						<label for="slug"><?php echo getCatalog('slug') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="slug">
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