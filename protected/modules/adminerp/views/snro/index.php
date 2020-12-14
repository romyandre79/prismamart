<script src="<?php echo Yii::app()->baseUrl; ?>/js/adminerp/snro.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('snro') ?></h3>
			</div>
	<div class="card-body">
    <?php $this->widget('Button',	array('menuname'=>'snro')); ?>
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
							'visible' => booltostr(CheckAccess('snro', 'iswrite')),
							'url' => '"#"',
							'click' => "function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('snro', 'ispurge')),
							'url' => '"#"',
							'click' => "function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('snro', 'isdownload')),
							'url' => '"#"',
							'click' => "function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('snroid'),
					'name' => 'snroid',
					'value' => '$data["snroid"]'
				),
				array(
					'header' => getCatalog('description'),
					'name' => 'description',
					'value' => '$data["description"]'
				),
				array(
					'header' => getCatalog('formatdoc'),
					'name' => 'formatdoc',
					'value' => '$data["formatdoc"]'
				),
				array(
					'header' => getCatalog('formatno'),
					'name' => 'formatno',
					'value' => '$data["formatno"]'
				),
				array(
					'header' => getCatalog('repeatby'),
					'name' => 'repeatby',
					'value' => '$data["repeatby"]'
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
    <?php $this->widget('Button',	array('menuname'=>'snro')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'description'),
  array('searchtype'=>'text','searchname'=>'formatdoc'),
  array('searchtype'=>'text','searchname'=>'formatno'),
  array('searchtype'=>'text','searchname'=>'repeatby')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/o7QSpuAJjmw')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('snro') ?></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="snroid">
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
						<label for="formatdoc"><?php echo getCatalog('formatdoc') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="formatdoc">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label for="formatno"><?php echo getCatalog('formatno') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="formatno">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label for="repeatby"><?php echo getCatalog('repeatby') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="repeatby">
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
					<li class="nav-item"><a data-toggle="tab" href="#snrodet" class="nav-link"><?php echo getCatalog("snrodet") ?></a></li>
				</ul>
				<div class="tab-content">
					<div id="snrodet" class="tab-pane">
						<?php if (CheckAccess('snro', 'iswrite')) { ?>
							<button name="CreateButtonsnrodet" type="button" class="btn btn-primary" onclick="newdatasnrodet()"><?php echo getCatalog('new') ?></button>
						<?php } ?>
						<?php if (CheckAccess('snro', 'ispurge')) { ?>
							<button name="PurgeButtonsnrodet" type="button" class="btn btn-danger" onclick="purgedatasnrodet()"><?php echo getCatalog('purge') ?></button>
						<?php } ?>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProvidersnrodet,
							'id' => 'snrodetList',
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
											'visible' => booltostr(CheckAccess('snro', 'iswrite')),
											'url' => '"#"',
											'click' => "function() { 
								updatedatasnrodet($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => booltostr(CheckAccess('snro', 'ispurge')),
											'url' => '"#"',
											'click' => "function() { 
								purgedatasnrodet($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('snrodid'),
									'name' => 'snrodid',
									'value' => '$data["snrodid"]'
								),
								array(
									'header' => getCatalog('company'),
									'name' => 'companyid',
									'value' => '$data["companyname"]'
								),
								array(
									'header' => getCatalog('curdd'),
									'name' => 'curdd',
									'value' => '$data["curdd"]'
								),
								array(
									'header' => getCatalog('curmm'),
									'name' => 'curmm',
									'value' => '$data["curmm"]'
								),
								array(
									'header' => getCatalog('curyy'),
									'name' => 'curyy',
									'value' => '$data["curyy"]'
								),
								array(
									'header' => getCatalog('curvalue'),
									'name' => 'curvalue',
									'value' => '$data["curvalue"]'
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
						<h3 class="card-title"><?php echo getCatalog('snrodet') ?></h3>
					</div><!-- /.box-header -->		
					<div class="card-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProvidersnrodet,
							'id' => 'DetailsnrodetList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('snrodid'),
									'name' => 'snrodid',
									'value' => '$data["snrodid"]'
								),
								array(
									'header' => getCatalog('company'),
									'name' => 'companyid',
									'value' => '$data["companyname"]'
								),
								array(
									'header' => getCatalog('curdd'),
									'name' => 'curdd',
									'value' => '$data["curdd"]'
								),
								array(
									'header' => getCatalog('curmm'),
									'name' => 'curmm',
									'value' => '$data["curmm"]'
								),
								array(
									'header' => getCatalog('curyy'),
									'name' => 'curyy',
									'value' => '$data["curyy"]'
								),
								array(
									'header' => getCatalog('curvalue'),
									'name' => 'curvalue',
									'value' => '$data["curvalue"]'
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

<div id="InputDialogsnrodet" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('snrodet') ?></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="snrodid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'companyid', 'ColField' => 'companyname',
					'IDDialog' => 'companyid_dialog', 'titledialog' => getCatalog('company'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'admin.components.views.CompanyPopUp', 'PopGrid' => 'companyidgrid'));
				?>

				<div class="row">
					<div class="col-md-4">
						<label for="curdd"><?php echo getCatalog('curdd') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="curdd">
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="curmm"><?php echo getCatalog('curmm') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="curmm">
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="curyy"><?php echo getCatalog('curyy') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="curyy">
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="curvalue"><?php echo getCatalog('curvalue') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="curvalue">
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatasnrodet()"><?php echo getCatalog('save') ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/adminlte.min.css">