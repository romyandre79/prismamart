<script src="<?php echo Yii::app()->baseUrl; ?>/js/common/romawi.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('romawi') ?></h3>
  </div>
	<div class="card-body">
  <?php $this->widget('Button',	array('menuname'=>'romawi')); ?>
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
							'visible' => booltostr(CheckAccess('romawi', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
							updatedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'delete' => array
							(
							'label' => getCatalog('delete'),
							'imageUrl' => Yii::app()->baseUrl.'/images/active.png',
							'visible' => booltostr(CheckAccess('romawi', 'isreject')),
							'url' => '"#"',
							'click' => "function() {
							deletedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('romawi', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
							purgedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('romawi', 'isdownload')),
							'url' => '"#"',
							'click' => "function() {
							downpdf($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
					),
				),
				array(
					'header' => getCatalog('romawiid'),
					'name' => 'romawiid',
					'value' => '$data["romawiid"]'
				),
				array(
					'header' => getCatalog('monthcal'),
					'name' => 'monthcal',
					'value' => '$data["monthcal"]'
				),
				array(
					'header' => getCatalog('monthrm'),
					'name' => 'monthrm',
					'value' => '$data["monthrm"]'
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
<div id="HelpDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<iframe width="100%" height="480px" src="https://www.youtube.com/embed/o6bHKl6k5i8" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
			</div>
		</div>
	</div>
</div>
<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('search') ?></h4>
      </div>
			<div class="modal-body">
				<div class="form-group">
					<label for="dlg_search_monthrm"><?php echo getCatalog('monthrm') ?></label>
					<input type="text" class="form-control" name="dlg_search_monthrm">
				</div>
				<div class="form-group">
					<label for="dlg_search_monthcal"><?php echo getCatalog('monthcal') ?></label>
					<input type="text" class="form-control" name="dlg_search_monthcal">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo getCatalog('search') ?></button>
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
        <h4 class="modal-title"><?php echo getCatalog('romawi') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="romawiid">
        <div class="row">
					<div class="col-md-4">
						<label for="monthcal"><?php echo getCatalog('monthcal') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="monthcal">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="monthrm"><?php echo getCatalog('monthrm') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="monthrm">
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