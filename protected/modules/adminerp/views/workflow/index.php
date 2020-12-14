<script src="<?php echo Yii::app()->baseUrl; ?>/js/adminerp/workflow.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('workflow') ?></h3>
			</div>
	<div class="card-body">
    <?php $this->widget('Button',	array('menuname'=>'workflow')); ?>
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
					'htmlOptions' => array('style' => 'width:150px'),
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
							'visible' => booltostr(CheckAccess('workflow', 'iswrite')),
							'url' => '"#"',
							'click' => "function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('workflow', 'ispurge')),
							'url' => '"#"',
							'click' => "function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('workflow', 'isdownload')),
							'url' => '"#"',
							'click' => "function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('workflowid'),
					'name' => 'workflowid',
					'value' => '$data["workflowid"]'
				),
				array(
					'header' => getCatalog('wfname'),
					'name' => 'wfname',
					'value' => '$data["wfname"]'
				),
				array(
					'header' => getCatalog('wfdesc'),
					'name' => 'wfdesc',
					'value' => '$data["wfdesc"]'
				),
				array(
					'header' => getCatalog('wfminstat'),
					'name' => 'wfminstat',
					'value' => '$data["wfminstat"]'
				),
				array(
					'header' => getCatalog('wfmaxstat'),
					'name' => 'wfmaxstat',
					'value' => '$data["wfmaxstat"]'
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
    <?php $this->widget('Button',	array('menuname'=>'addressbook')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'wfname'),
  array('searchtype'=>'text','searchname'=>'wfdesc'),
  array('searchtype'=>'text','searchname'=>'groupname'),
  array('searchtype'=>'text','searchname'=>'wfstatusname')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/7BKgLUFq610')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('workflow') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="workflowid">
        <div class="row">
					<div class="col-md-4">
						<label for="wfname"><?php echo getCatalog('wfname') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="wfname">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="wfdesc"><?php echo getCatalog('wfdesc') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="wfdesc">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="wfminstat"><?php echo getCatalog('wfminstat') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="wfminstat">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="wfmaxstat"><?php echo getCatalog('wfmaxstat') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="wfmaxstat">
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
				<ul class="nav nav-pills nav-fill">
					<li class="nav-item"><a data-toggle="tab" href="#wfgroup" class="nav-link"><?php echo getCatalog("wfgroup") ?></a></li>
					<li class="nav-item"><a data-toggle="tab" href="#wfstatus" class="nav-link"><?php echo getCatalog("wfstatus") ?></a></li>
				</ul>
				<div class="tab-content">
					<div id="wfgroup" class="tab-pane">
						<?php if (CheckAccess('workflow', 'iswrite')) { ?>
							<button name="CreateButtonwfgroup" type="button" class="btn btn-primary" onclick="newdatawfgroup()"><?php echo getCatalog('new') ?></button>
						<?php } ?>
						<?php if (CheckAccess('workflow', 'ispurge')) { ?>
							<button name="PurgeButtonwfgroup" type="button" class="btn btn-danger" onclick="purgedatawfgroup()"><?php echo getCatalog('purge') ?></button>
						<?php } ?>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderwfgroup,
							'id' => 'wfgroupList',
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
											'visible' => booltostr(CheckAccess('workflow', 'iswrite')),
											'url' => '"#"',
											'click' => "function() { 
								updatedatawfgroup($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => booltostr(CheckAccess('workflow', 'ispurge')),
											'url' => '"#"',
											'click' => "function() { 
								purgedatawfgroup($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('wfgroupid'),
									'name' => 'wfgroupid',
									'value' => '$data["wfgroupid"]'
								),
								array(
									'header' => getCatalog('groupaccess'),
									'name' => 'groupaccessid',
									'value' => '$data["groupname"]'
								),
								array(
									'header' => getCatalog('wfbefstat'),
									'name' => 'wfbefstat',
									'value' => '$data["wfbefstat"]'
								),
								array(
									'header' => getCatalog('wfrecstat'),
									'name' => 'wfrecstat',
									'value' => '$data["wfrecstat"]'
								),
							)
						));
						?>
					</div>
					<div id="wfstatus" class="tab-pane">
						<?php if (CheckAccess('workflow', 'iswrite')) { ?>
							<button name="CreateButtonwfstatus" type="button" class="btn btn-primary" onclick="newdatawfstatus()"><?php echo getCatalog('new') ?></button>
						<?php } ?>
						<?php if (CheckAccess('workflow', 'ispurge')) { ?>
							<button name="PurgeButtonwfstatus" type="button" class="btn btn-danger" onclick="purgedatawfstatus()"><?php echo getCatalog('purge') ?></button>
						<?php } ?>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderwfstatus,
							'id' => 'wfstatusList',
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
											'visible' => booltostr(CheckAccess('workflow', 'iswrite')),
											'url' => '"#"',
											'click' => "function() { 
								updatedatawfstatus($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => booltostr(CheckAccess('workflow', 'ispurge')),
											'url' => '"#"',
											'click' => "function() { 
								purgedatawfstatus($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('wfstatusid'),
									'name' => 'wfstatusid',
									'value' => '$data["wfstatusid"]'
								),
								array(
									'header' => getCatalog('wfstat'),
									'name' => 'wfstat',
									'value' => '$data["wfstat"]'
								),
								array(
									'header' => getCatalog('wfstatusname'),
									'name' => 'wfstatusname',
									'value' => '$data["wfstatusname"]'
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
				<div class="card card-primary">
					<div class="card-header with-border">
						<h3 class="card-title"><?php echo getCatalog('wfgroup') ?></h3>
					</div><!-- /.box-header -->		
					<div class="card-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderwfgroup,
							'id' => 'DetailwfgroupList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('wfgroupid'),
									'name' => 'wfgroupid',
									'value' => '$data["wfgroupid"]'
								),
								array(
									'header' => getCatalog('groupaccess'),
									'name' => 'groupaccessid',
									'value' => '$data["groupname"]'
								),
								array(
									'header' => getCatalog('wfbefstat'),
									'name' => 'wfbefstat',
									'value' => '$data["wfbefstat"]'
								),
								array(
									'header' => getCatalog('wfrecstat'),
									'name' => 'wfrecstat',
									'value' => '$data["wfrecstat"]'
								),
							)
						));
						?>
					</div>		
				</div>		
				<div class="card card-primary">
					<div class="card-header with-border">
						<h3 class="card-title"><?php echo getCatalog('wfstatus') ?></h3>
					</div><!-- /.box-header -->		
					<div class="box-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderwfstatus,
							'id' => 'DetailwfstatusList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('wfstatusid'),
									'name' => 'wfstatusid',
									'value' => '$data["wfstatusid"]'
								),
								array(
									'header' => getCatalog('wfstat'),
									'name' => 'wfstat',
									'value' => '$data["wfstat"]'
								),
								array(
									'header' => getCatalog('wfstatusname'),
									'name' => 'wfstatusname',
									'value' => '$data["wfstatusname"]'
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
<div id="InputDialogwfgroup" class="modal fade" role="dialog">
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('wfgroup') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="wfgroupid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'groupaccessid', 'ColField' => 'groupname',
					'IDDialog' => 'groupaccessid_dialog', 'titledialog' => getCatalog('groupaccess'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'admin.components.views.GroupaccessPopUp', 'PopGrid' => 'groupaccessidgrid'));
				?>
        <div class="row">
					<div class="col-md-4">
						<label for="wfbefstat"><?php echo getCatalog('wfbefstat') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="wfbefstat">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="wfrecstat"><?php echo getCatalog('wfrecstat') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="wfrecstat">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatawfgroup()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>
<div id="InputDialogwfstatus" class="modal fade" role="dialog">
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('wfstatus') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="wfstatusid">
        <div class="row">
					<div class="col-md-4">
						<label for="wfstat"><?php echo getCatalog('wfstat') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="wfstat">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="wfstatusname"><?php echo getCatalog('wfstatusname') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="wfstatusname">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatawfstatus()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/adminlte.min.css">