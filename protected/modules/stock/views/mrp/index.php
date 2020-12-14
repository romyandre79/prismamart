<script src="<?php echo Yii::app()->baseUrl; ?>/js/stock/mrp.js"></script>
<div class="box">
	<div class="box-header with-border">
    <h3 class="box-title"><?php echo getCatalog($this->menuname) ?></h3>
  </div>
  <div class="box-body">
    <?php $this->widget('Button',	array('menuname'=>'mrp')); ?>
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
					'visible' => booltostr(CheckAccess('mrp', 'iswrite')),
					'url' => '"#"',
					'click' => "function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
				),
				'delete' => array
					(
					'label' => getCatalog('delete'),
					'imageUrl' => Yii::app()->baseUrl.'/images/active.png',
					'visible' => 'false',
					'url' => '"#"',
					'click' => "function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
				),
				'purge' => array
					(
					'label' => getCatalog('purge'),
					'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
					'visible' => booltostr(CheckAccess('mrp', 'ispurge')),
					'url' => '"#"',
					'click' => "function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
				),
				'pdf' => array
					(
					'label' => getCatalog('downpdf'),
					'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
					'visible' => booltostr(CheckAccess('mrp', 'isdownload')),
					'url' => '"#"',
					'click' => "function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
				),
			),
		),
		array(
			'header' => getCatalog('mrpid'),
			'name' => 'mrpid',
			'value' => '$data["mrpid"]'
		),
		array(
			'header' => getCatalog('companyname'),
			'name' => 'companyid',
			'value' => '$data["companyname"]'
		),
		array(
			'header' => getCatalog('productname'),
			'name' => 'productid',
			'value' => '$data["productname"]'
		),
		array(
			'header' => getCatalog('sloccode'),
			'name' => 'slocid',
			'value' => '$data["sloccode"]'
		),
		array(
			'header' => getCatalog('uomcode'),
			'name' => 'uomid',
			'value' => '$data["uomcode"]'
		),
		array(
			'header' => getCatalog('minstock'),
			'name' => 'minstock',
			'value' => 'Yii::app()->format->formatNumber($data["minstock"])'
		),
		array(
			'header' => getCatalog('reordervalue'),
			'name' => 'reordervalue',
			'value' => 'Yii::app()->format->formatNumber($data["reordervalue"])'
		),
		array(
			'header' => getCatalog('maxvalue'),
			'name' => 'maxvalue',
			'value' => 'Yii::app()->format->formatNumber($data["maxvalue"])'
		),
		array(
			'header' => getCatalog('leadtime'),
			'name' => 'leadtime',
			'value' => '$data["leadtime"]'
		),
	)
));
?>
    <?php $this->widget('Button',	array('menuname'=>'mrp')); ?>
  </div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'companyname'),
  array('searchtype'=>'text','searchname'=>'productname'),
  array('searchtype'=>'text','searchname'=>'sloccode'),
  array('searchtype'=>'text','searchname'=>'uomcode'),
  array('searchtype'=>'text','searchname'=>'accountowner'),
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/p080vBrY3Uk')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('mrp') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="mrpid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'companyid', 'ColField' => 'companyname',
					'IDDialog' => 'companyid_dialog', 'titledialog' => getCatalog('companyname'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'admin.components.views.CompanyPopUp', 'PopGrid' => 'companyidgrid'));
				?>
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'productid', 'ColField' => 'productname',
					'IDDialog' => 'productid_dialog', 'titledialog' => getCatalog('productname'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.ProductPopUp', 'PopGrid' => 'productidgrid'));
				?>
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'slocid', 'ColField' => 'sloccode',
					'IDDialog' => 'slocid_dialog', 'titledialog' => getCatalog('sloccode'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.SlocPopUp', 'PopGrid' => 'slocidgrid'));
				?>
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'uomid', 'ColField' => 'uomcode',
					'IDDialog' => 'uomid_dialog', 'titledialog' => getCatalog('uomcode'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => 'productid',
					'PopUpName' => 'common.components.views.UomPlantPopUp', 'PopGrid' => 'uomidgrid'));
				?>
        <div class="row">
					<div class="col-md-4">
						<label for="minstock"><?php echo getCatalog('minstock') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="minstock">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="reordervalue"><?php echo getCatalog('reordervalue') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="reordervalue">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="maxvalue"><?php echo getCatalog('maxvalue') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="maxvalue">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="leadtime"><?php echo getCatalog('leadtime') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="leadtime">
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