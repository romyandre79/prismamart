<script src="<?php echo Yii::app()->baseUrl; ?>/js/common/product.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('product') ?></h3>
	</div>
	<div class="card-body">
    <?php $this->widget('Button',	array('menuname'=>'product')); ?>
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
					'template' => '{select} {edit} {purge} {pdf}',
					'htmlOptions' => array('style' => 'width:100px'),
					'buttons' => array
						(
						'select' => array
							(
							'label' => getCatalog('detail'),
							'imageUrl' => Yii::app()->baseUrl.'/images/detail.png',
							'url' => '"#"',
							'click' => "function() {
								GetDetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'edit' => array
							(
							'label' => getCatalog('edit'),
							'imageUrl' => Yii::app()->baseUrl.'/images/edit.png',
							'visible' => booltostr(CheckAccess('product', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('product', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('product', 'isdownload')),
							'url' => '"#"',
							'click' => "function() {
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('productid'),
					'name' => 'productid',
					'value' => '$data["productid"]'
				),
				array(
					'header' => getCatalog('productcode'),
					'name' => 'productcode',
					'value' => '$data["productcode"]'
				),
				array(
					'header' => getCatalog('productname'),
					'name' => 'productname',
					'value' => '$data["productname"]'
				),
				array(
					'header' => getCatalog('productpic'),
					'name' => 'productpic',
					'type' => 'raw',
					'value' => 'CHtml::image(Yii::app()->baseUrl."/images/product/".$data["productpic"],$data["productname"],
					array("height"=>"50"))'
				),
				array(
					'class' => 'CCheckBoxColumn',
					'name' => 'isstock',
					'header' => getCatalog('isstock'),
					'selectableRows' => '0',
					'checked' => '$data["isstock"]',
        ), 
        array(
					'header' => getCatalog('barcode'),
					'name' => 'barcode',
					'value' => '$data["barcode"]'
        ),
        array(
					'header' => getCatalog('uomcode'),
					'name' => 'uomcode',
					'value' => '$data["uomcode"]'
				),
        array(
					'header' => getCatalog('materialgroup'),
					'name' => 'materialgroupdesc',
					'value' => '$data["materialgroupdesc"]'
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
    <?php $this->widget('Button',	array('menuname'=>'product')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'productcode'),
  array('searchtype'=>'text','searchname'=>'productname'),
  array('searchtype'=>'text','searchname'=>'barcode'),
  array('searchtype'=>'text','searchname'=>'bankaccountno'),
  array('searchtype'=>'text','searchname'=>'accountowner'),
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/hOiqXsc2yDc')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('product') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="productid">
				<div class="row">
					<div class="col-md-4">
						<label for="productcode"><?php echo getCatalog('productcode') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="productcode">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="productname"><?php echo getCatalog('productname') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="productname">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="productpic"><?php echo getCatalog('productpic') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" readonly name="productpic">
					</div>
				</div>
				<script>
					function successUp(param, param2, param3) {
						$('input[name="productpic"]').val(param2);
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
							'url' => Yii::app()->createUrl('common/product/upload'),
							'mimeTypes' => array('.jpg', '.png', '.jpeg'),
							'events' => $events,
							'options' => CMap::mergeArray($this->options, $this->dict),
							'htmlOptions' => array('style' => 'height:95%; overflow: hidden;'),
						));
						?></div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="isstock"><?php echo getCatalog('isstock') ?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="isstock">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="isautolot"><?php echo getCatalog('isautolot') ?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="isautolot">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="sled"><?php echo getCatalog('sled') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="sled">
					</div>
				</div>
        <?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'unitofissue', 'ColField' => 'uomcode',
					'IDDialog' => 'unitofissue_dialog', 'titledialog' => getCatalog('unitofiss'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.UomPopUp', 'PopGrid' => 'unitofissuegrid'));
				?>
        <?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'materialgroupid', 'ColField' => 'materialgroupcode',
					'IDDialog' => 'materialgroup_dialog', 'titledialog' => getCatalog('materialgroup'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.MaterialgroupPopUp', 'PopGrid' => 'materialgroupgrid'));
				?>
        <div class="row">
					<div class="col-md-4">
						<label for="barcode"><?php echo getCatalog('barcode') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="barcode">
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
				<ul class="nav nav-tabs">
					<li><a data-toggle="tab" href="#productplant"><?php echo getCatalog("productplant") ?></a></li>
				</ul>
				<div class="tab-content">
					<div id="productplant" class="tab-pane">
						<?php if (CheckAccess('product', 'iswrite')) { ?>
							<button name="CreateButtonproductplant" type="button" class="btn btn-primary" onclick="newdataproductplant()"><?php echo getCatalog('new') ?></button>
						<?php } ?>
						<?php if (CheckAccess('product', 'ispurge')) { ?>
							<button name="PurgeButtonproductplant" type="button" class="btn btn-danger" onclick="purgedataproductplant()"><?php echo getCatalog('purge') ?></button>
						<?php } ?>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderproductplant,
							'id' => 'productplantList',
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
									'template' => '{edit} {purge}',
									'htmlOptions' => array('style' => 'width:160px'),
									'buttons' => array
										(
										'edit' => array
											(
											'label' => getCatalog('edit'),
											'imageUrl' => Yii::app()->baseUrl.'/images/edit.png',
											'visible' => booltostr(CheckAccess('product', 'iswrite')),
											'url' => '"#"',
											'click' => "function() {
								updatedataproductplant($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => booltostr(CheckAccess('product', 'ispurge')),
											'url' => '"#"',
											'click' => "function() {
								purgedataproductplant($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('productplantid'),
									'name' => 'productplantid',
									'value' => '$data["productplantid"]'
								),
								array(
									'header' => getCatalog('sloc'),
									'name' => 'slocid',
									'value' => '$data["sloccode"]'
								),
								array(
									'header' => getCatalog('snro'),
									'name' => 'snroid',
									'value' => '$data["snrodesc"]'
								),
								array(
									'class' => 'CCheckBoxColumn',
									'name' => 'issource',
									'header' => getCatalog('issource'),
									'selectableRows' => '0',
									'checked' => '$data["issource"]',
								)
							)
						));
						?>
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
<div id="ShowDetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo getCatalog('productplant') ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderproductplant,
							'id' => 'DetailproductplantList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('productplantid'),
									'name' => 'productplantid',
									'value' => '$data["productplantid"]'
								),
								array(
									'header' => getCatalog('sloc'),
									'name' => 'slocid',
									'value' => '$data["sloccode"]'
								),
								array(
									'class' => 'CCheckBoxColumn',
									'name' => 'isautolot',
									'header' => getCatalog('isautolot'),
									'selectableRows' => '0',
									'checked' => '$data["isautolot"]',
								),
								array(
									'header' => getCatalog('snro'),
									'name' => 'snroid',
									'value' => '$data["snrodesc"]'
								),
								array(
									'class' => 'CCheckBoxColumn',
									'name' => 'issource',
									'header' => getCatalog('issource'),
									'selectableRows' => '0',
									'checked' => '$data["issource"]',
								)
							)
						));
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="InputDialogproductplant" class="modal fade" role="dialog">
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('productplant') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="productplantid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'slocid', 'ColField' => 'sloccode',
					'IDDialog' => 'slocid_dialog', 'titledialog' => getCatalog('sloc'), 'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.SlocPopUp', 'PopGrid' => 'slocidgrid'));
				?>
        <div class="row">
					<div class="col-md-4">
						<label for="issource"><?php echo getCatalog('issource') ?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="issource">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataproductplant()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/adminlte.min.css">