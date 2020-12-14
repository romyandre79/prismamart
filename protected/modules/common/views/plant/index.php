<script src="<?php echo Yii::app()->baseUrl; ?>/js/common/plant.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('plant') ?></h3>
			</div>
	<div class="card-body">
    <?php $this->widget('Button',	array('menuname'=>'plant')); ?>
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
							'visible' => booltostr(CheckAccess('plant', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
							updatedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'delete' => array
							(
							'label' => getCatalog('delete'),
							'imageUrl' => Yii::app()->baseUrl.'/images/active.png',
							'visible' => booltostr(CheckAccess('plant', 'isreject')),
							'url' => '"#"',
							'click' => "function() {
							deletedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('plant', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
							purgedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('plant', 'isdownload')),
							'url' => '"#"',
							'click' => "function() {
							downpdf($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
					),
				),
				array(
					'header' => getCatalog('plantid'),
					'name' => 'plantid',
					'value' => '$data["plantid"]'
				),
				array(
					'header' => getCatalog('companyname'),
					'name' => 'companyid',
					'value' => '$data["companyname"]'
				),
				array(
					'header' => getCatalog('plantcode'),
					'name' => 'plantcode',
					'value' => '$data["plantcode"]'
				),
				array(
					'header' => getCatalog('description'),
					'name' => 'description',
					'value' => '$data["description"]'
				),
				array(
					'header' => getCatalog('plantaddress'),
					'name' => 'plantaddress',
					'value' => '$data["plantaddress"]'
				),
				array(
					'header' => getCatalog('lat'),
					'name' => 'lat',
					'value' => '$data["lat"]'
				),
				array(
					'header' => getCatalog('lng'),
					'name' => 'lng',
					'value' => '$data["lng"]'
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
    <?php $this->widget('Button',	array('menuname'=>'plant')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'companyname'),
  array('searchtype'=>'text','searchname'=>'plantcode'),
  array('searchtype'=>'text','searchname'=>'description')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/xRfs0xuT8FY')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('plant') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="plantid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'companyid', 'ColField' => 'companyname',
					'IDDialog' => 'companyid_dialog', 'titledialog' => getCatalog('companyname'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'admin.components.views.CompanyPopUp', 'PopGrid' => 'companyidgrid'));
				?>
        <div class="row">
					<div class="col-md-4">
						<label for="plantcode"><?php echo getCatalog('plantcode') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="plantcode">
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
						<label for="plantaddress"><?php echo getCatalog('plantaddress') ?></label>
					</div>
					<div class="col-md-8">
						<textarea type="text" class="form-control" rows="5" name="plantaddress"></textarea>
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="lat"><?php echo getCatalog('lat') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="lat">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="lng"><?php echo getCatalog('lng') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="lng">
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