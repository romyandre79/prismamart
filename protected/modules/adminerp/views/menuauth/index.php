<script src="<?php echo Yii::app()->baseUrl; ?>/js/adminerp/menuauth.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('menuauth') ?></h3>
	</div><!-- /.box-header -->
	<div class="card-body">
    <?php $this->widget('Button',	array('menuname'=>'menuauth')); ?>
		<?php
		$this->widget('zii.widgets.grid.CGridView',
			array(
			'dataProvider' => $dataProvider,
			'id' => 'GridList',
			'selectableRows' => 2,
			'ajaxUpdate' => true,
			'filter' => null,
			'enableSorting' => true,
			'rowCssClassExpression' => '(($data["jumsub"]==0)?"warning":"primary")',
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
							'visible' => booltostr(CheckAccess('menuauth', 'iswrite')),
							'url' => '"#"',
							'click' => "function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('menuauth', 'ispurge')),
							'url' => '"#"',
							'click' => "function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('menuauth', 'isdownload')),
							'url' => '"#"',
							'click' => "function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('menuauthid'),
					'name' => 'menuauthid',
					'value' => '$data["menuauthid"]'
				),
				array(
					'header' => getCatalog('menuobject'),
					'name' => 'menuobject',
					'value' => '$data["menuobject"]'
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
    <?php $this->widget('Button',	array('menuname'=>'menuauth')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'menuobject'),
  array('searchtype'=>'text','searchname'=>'groupname'),
  array('searchtype'=>'text','searchname'=>'menuvalueid')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/r37QFIGUyPA')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('menuauth') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="menuauthid">
        <div class="row">
					<div class="col-md-4">
						<label for="menuobject"><?php echo getCatalog('menuobject') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="menuobject">
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
					<li class="nav-item"><a data-toggle="tab" class="nav-link" href="#groupmenuauth"><?php echo getCatalog("groupmenuauth") ?></a></li>
				</ul>
				<div class="tab-content">
					<div id="groupmenuauth" class="tab-pane">
						<?php if (CheckAccess('menuauth', 'iswrite')) { ?>
							<button name="CreateButtongroupmenuauth" type="button" class="btn btn-primary" onclick="newdatagroupmenuauth()"><?php echo getCatalog('new') ?></button>
						<?php } ?>
						<?php if (CheckAccess('menuauth', 'ispurge')) { ?>
							<button name="PurgeButtongroupmenuauth" type="button" class="btn btn-danger" onclick="purgedatagroupmenuauth()"><?php echo getCatalog('purge') ?></button>
						<?php } ?>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProvidergroupmenuauth,
							'id' => 'groupmenuauthList',
							'selectableRows' => 2,
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'class' => 'CCheckBoxColumn',
									'id' => 'ids',
								),
								array (
									'class' => 'CButtonColumn',
									'template' => '{edit} {purge}',
									'htmlOptions' => array('style' => 'width:160px'),
									'buttons' => array (
										'edit' => array (
											'label' => getCatalog('edit'),
											'imageUrl' => Yii::app()->baseUrl.'/images/edit.png',
											'visible' => booltostr(CheckAccess('menuauth', 'iswrite')),
											'url' => '"#"',
											'click' => "function() { 
                        updatedatagroupmenuauth($(this).parent().parent().children(':nth-child(3)').text());
                      }",
										),
										'purge' => array (
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => booltostr(CheckAccess('menuauth', 'ispurge')),
											'url' => '"#"',
											'click' => "function() { 
                        purgedatagroupmenuauth($(this).parent().parent().children(':nth-child(3)').text());
                      }",
										),
									),
								),
								array(
									'header' => getCatalog('groupmenuauthid'),
									'name' => 'groupmenuauthid',
									'value' => '$data["groupmenuauthid"]'
								),
								array(
									'header' => getCatalog('groupaccess'),
									'name' => 'groupaccessid',
									'value' => '$data["groupname"]'
								),
								array(
									'header' => getCatalog('menuvalueid'),
									'name' => 'menuvalueid',
									'value' => '$data["menuvalueid"]'
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
						<h3 class="card-title"><?php echo getCatalog('groupmenuauth') ?></h3>
					</div><!-- /.box-header -->		
					<div class="card-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProvidergroupmenuauth,
							'id' => 'DetailgroupmenuauthList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('groupmenuauthid'),
									'name' => 'groupmenuauthid',
									'value' => '$data["groupmenuauthid"]'
								),
								array(
									'header' => getCatalog('groupaccess'),
									'name' => 'groupaccessid',
									'value' => '$data["groupname"]'
								),
								array(
									'header' => getCatalog('menuvalueid'),
									'name' => 'menuvalueid',
									'value' => '$data["menuvalueid"]'
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
<div id="InputDialoggroupmenuauth" class="modal fade" role="dialog">
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('groupmenuauth') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="groupmenuauthid">
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
						<label for="menuvalueid"><?php echo getCatalog('menuvalueid') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="menuvalueid">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatagroupmenuauth()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/adminlte.min.css">