<script src="<?php echo Yii::app()->baseUrl; ?>/js/common/sloc.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('sloc') ?></h3>
			</div>
	<div class="card-body">
    <?php $this->widget('Button',	array('menuname'=>'sloc')); ?>
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
					'htmlOptions' => array('style' => 'width:120px'),
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
							'visible' => booltostr(CheckAccess('sloc', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('sloc', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('sloc', 'isdownload')),
							'url' => '"#"',
							'click' => "function() {
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('slocid'),
					'name' => 'slocid',
					'value' => '$data["slocid"]'
				),
				array(
					'header' => getCatalog('plantcode'),
					'name' => 'plantid',
					'value' => '$data["plantcode"]'
				),
				array(
					'header' => getCatalog('sloccode'),
					'name' => 'sloccode',
					'value' => '$data["sloccode"]'
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
    <?php $this->widget('Button',	array('menuname'=>'sloc')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'plantcode'),
  array('searchtype'=>'text','searchname'=>'sloccode'),
  array('searchtype'=>'text','searchname'=>'description')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/iKJNwkulGw8')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('sloc') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="slocid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'plantid', 'ColField' => 'plantcode',
					'IDDialog' => 'plantid_dialog', 'titledialog' => getCatalog('plant'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.PlantPopUp', 'PopGrid' => 'plantidgrid'));
				?>
        <div class="row">
					<div class="col-md-4">
						<label for="sloccode"><?php echo getCatalog('sloccode') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="sloccode">
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
				<ul class="nav nav-tabs">
					<li><a data-toggle="tab" href="#storagebin"><?php echo getCatalog("storagebin") ?></a></li>
				</ul>
				<div class="tab-content">
					<div id="storagebin" class="tab-pane">
						<?php if (CheckAccess('sloc', 'iswrite')) { ?>
							<button name="CreateButtonstoragebin" type="button" class="btn btn-primary" onclick="newdatastoragebin()"><?php echo getCatalog('new') ?></button>
						<?php } ?>
						<?php if (CheckAccess('sloc', 'ispurge')) { ?>
							<button name="PurgeButtonstoragebin" type="button" class="btn btn-danger" onclick="purgedatastoragebin()"><?php echo getCatalog('purge') ?></button>
						<?php } ?>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderstoragebin,
							'id' => 'storagebinList',
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
											'visible' => booltostr(CheckAccess('sloc', 'iswrite')),
											'url' => '"#"',
											'click' => "function() {
								updatedatastoragebin($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => booltostr(CheckAccess('sloc', 'ispurge')),
											'url' => '"#"',
											'click' => "function() {
								purgedatastoragebin($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('storagebinid'),
									'name' => 'storagebinid',
									'value' => '$data["storagebinid"]'
								),
								array(
									'header' => getCatalog('description'),
									'name' => 'description',
									'value' => '$data["description"]'
								),
								array(
									'class' => 'CCheckBoxColumn',
									'name' => 'ismultiproduct',
									'header' => getCatalog('ismultiproduct'),
									'selectableRows' => '0',
									'checked' => '$data["ismultiproduct"]',
								), array(
									'header' => getCatalog('qtymax'),
									'name' => 'qtymax',
									'value' => 'Yii::app()->format->formatNumber($data["qtymax"])'
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
				<div class="card box-primary">
					<div class="card-header with-border">
						<h3 class="card-title"><?php echo getCatalog('storagebin') ?></h3>
						<div class="card-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderstoragebin,
							'id' => 'DetailstoragebinList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('storagebinid'),
									'name' => 'storagebinid',
									'value' => '$data["storagebinid"]'
								),
								array(
									'header' => getCatalog('description'),
									'name' => 'description',
									'value' => '$data["description"]'
								),
								array(
									'class' => 'CCheckBoxColumn',
									'name' => 'ismultiproduct',
									'header' => getCatalog('ismultiproduct'),
									'selectableRows' => '0',
									'checked' => '$data["ismultiproduct"]',
								), array(
									'header' => getCatalog('qtymax'),
									'name' => 'qtymax',
									'value' => 'Yii::app()->format->formatNumber($data["qtymax"])'
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
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<div id="InputDialogstoragebin" class="modal fade" role="dialog">
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('storagebin') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="storagebinid">
        <div class="row">
					<div class="col-md-4">
						<label for="descsbin"><?php echo getCatalog('description') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="descsbin">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="ismultiproduct"><?php echo getCatalog('ismultiproduct') ?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="ismultiproduct">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="qtymax"><?php echo getCatalog('qtymax') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="qtymax">
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
				<button type="submit" class="btn btn-success" onclick="savedatastoragebin()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/adminlte.min.css">