<script src="<?php echo Yii::app()->baseUrl; ?>/js/common/storagebin.js"></script>
<h3><?php echo getCatalog('storagebin') ?></h3>
<?php if (CheckAccess('storagebin', 'iswrite')) { ?>
	<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo getCatalog('new') ?></button>
<?php } ?>
<?php if (CheckAccess('storagebin', 'isreject')) { ?>
	<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo getCatalog('delete') ?></button>
<?php } ?>
<?php if (CheckAccess('storagebin', 'ispurge')) { ?>
	<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo getCatalog('purge') ?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo getCatalog('search') ?></button>
<?php if (CheckAccess('storagebin', 'isdownload')) { ?>
	<div class="btn-group">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
			<?php echo getCatalog('download') ?> <span class="caret"></span></button>
		<ul class="dropdown-menu" role="menu">
			<li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo getCatalog('downpdf') ?></a></li>

		</ul>
	</div>
<?php } ?>
		<button name="HelpButton" type="button" class="btn btn-warning" data-toggle="modal" data-target="#HelpDialog"><?php echo getCatalog('help') ?></button>

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
					'visible' => booltostr(CheckAccess('storagebin', 'iswrite')),
					'url' => '"#"',
					'click' => "function() {
							updatedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
				),
				'delete' => array
					(
					'label' => getCatalog('delete'),
					'imageUrl' => Yii::app()->baseUrl.'/images/active.png',
					'visible' => booltostr(CheckAccess('storagebin', 'isreject')),
					'url' => '"#"',
					'click' => "function() {
							deletedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
				),
				'purge' => array
					(
					'label' => getCatalog('purge'),
					'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
					'visible' => booltostr(CheckAccess('storagebin', 'ispurge')),
					'url' => '"#"',
					'click' => "function() {
							purgedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
				),
				'pdf' => array
					(
					'label' => getCatalog('downpdf'),
					'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
					'visible' => booltostr(CheckAccess('storagebin', 'isdownload')),
					'url' => '"#"',
					'click' => "function() {
							downpdf($(this).parent().parent().children(':nth-child(3)').text());
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
			'header' => getCatalog('sloccode'),
			'name' => 'slocid',
			'value' => '$data["sloccode"]'
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
<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('search') ?></h4>
      </div>
			<div class="modal-body">
				<div class="form-group">
					<label for="dlg_search_sloccode"><?php echo getCatalog('sloccode') ?></label>
					<input type="text" class="form-control" name="dlg_search_sloccode">
				</div>
				<div class="form-group">
					<label for="dlg_search_description"><?php echo getCatalog('description') ?></label>
					<input type="text" class="form-control" name="dlg_search_description">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo getCatalog('search') ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
			</div>
		</div>
	</div>
</div>
<div id="HelpDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<iframe width="100%" height="480px" src="https://www.youtube.com/embed/6TurcJw-QDI" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
			</div>
		</div>
	</div>
</div>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('storagebin') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="storagebinid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'slocid', 'ColField' => 'sloccode',
					'IDDialog' => 'slocid_dialog', 'titledialog' => getCatalog('sloccode'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.SlocPopUp', 'PopGrid' => 'slocidgrid'));
				?>
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
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
    </div>
  </div>
</div>
