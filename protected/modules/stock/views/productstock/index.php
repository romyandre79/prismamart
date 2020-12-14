<script src="<?php echo Yii::app()->baseUrl; ?>/js/stock/productstock.js"></script>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo getCatalog('productstock') ?></h3>
	</div>
	<div class="box-body">
    <?php $this->widget('Button',	array('menuname'=>'addressbook','iswrite'=>false,'isreject'=>false,'ispurge'=>false)); ?>
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
					'template' => '{select} {edit} {approve} {delete} {purge}',
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
							'visible' => 'false',
							'url' => '"#"',
							'click' => "function() {
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'approve' => array
							(
							'label' => getCatalog('approve'),
							'imageUrl' => Yii::app()->baseUrl.'/images/approved.png',
							'visible' => 'false',
							'url' => '"#"',
							'click' => "function() {
								approvedata($(this).parent().parent().children(':nth-child(3)').text());
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
							'visible' => 'false',
							'url' => '"#"',
							'click' => "function() {
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('productstock',
									'isdownload')),
							'url' => '"#"',
							'click' => "function() {
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('productstockid'),
					'name' => 'productstockid',
					'value' => '$data["productstockid"]'
				),
				array(
					'header' => getCatalog('materialgroupcode'),
					'name' => 'materialgroupcode',
					'value' => '$data["materialgroupcode"]'
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
					'header' => getCatalog('storagebindesc'),
					'name' => 'storagebinid',
					'value' => '$data["storagebindesc"]'
				),
				array(
					'header' => getCatalog('qty'),
					'name' => 'qty',
					'value' => 'Yii::app()->format->formatNumber($data["qty"])'
				),
				array(
					'header' => getCatalog('uomcode'),
					'name' => 'unitofmeasureid',
					'value' => '$data["uomcode"]'
				),
				array(
					'header' => getCatalog('qtyinprogress'),
					'name' => 'qtyinprogress',
					'value' => 'Yii::app()->format->formatNumber($data["qtyinprogress"])'
				),
			)
		));
		?>
        <?php $this->widget('Button',	array('menuname'=>'addressbook','iswrite'=>false,'isreject'=>false,'ispurge'=>false)); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'materialgroupcode'),
  array('searchtype'=>'text','searchname'=>'materialgroupname'),
  array('searchtype'=>'text','searchname'=>'productname'),
  array('searchtype'=>'text','searchname'=>'uomcode'),
  array('searchtype'=>'text','searchname'=>'sloccode'),
  array('searchtype'=>'text','searchname'=>'storagebindesc'),
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/n0ddOZjaFo4')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('productstock') ?></h4>
      </div>
      <div class="modal-body">
				<ul class="nav nav-tabs">
					<li><a data-toggle="tab" href="#productstockdet"><?php echo getCatalog("productstockdet") ?></a></li>

				</ul>
				<div class="tab-content">
					<div id="productstockdet" class="tab-pane">
						<?php if (CheckAccess('productstock', 'iswrite')) { ?>
							<button name="CreateButtonproductstockdet" type="button" class="btn btn-primary" onclick="newdataproductstockdet()"><?php echo getCatalog('new') ?></button>
						<?php } ?>
						<?php if (CheckAccess('productstock', 'ispurge')) { ?>
							<button name="PurgeButtonproductstockdet" type="button" class="btn btn-danger" onclick="purgedataproductstockdet()"><?php echo getCatalog('purge') ?></button>
						<?php } ?>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderproductstockdet,
							'id' => 'productstockdetList',
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
											'visible' => 'false',
											'url' => '"#"',
											'click' => "function() {
								updatedataproductstockdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => 'false',
											'url' => '"#"',
											'click' => "function() {
								purgedataproductstockdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('productstockdetid'),
									'name' => 'productstockdetid',
									'value' => '$data["productstockdetid"]'
								),
								array(
									'header' => getCatalog('productdet'),
									'name' => 'productdetid',
									'value' => '$data["productdetname"]'
								),
								array(
									'header' => getCatalog('qtydet'),
									'name' => 'qtydet',
									'value' => 'Yii::app()->format->formatNumber($data["qtydet"])'
								),
								array(
									'header' => getCatalog('uomdet'),
									'name' => 'uomdetid',
									'value' => '$data["uomdetcode"]'
								),
								array(
									'header' => getCatalog('slocdet'),
									'name' => 'slocdetid',
									'value' => '$data["sloccodedet"]'
								),
								array(
									'header' => getCatalog('referenceno'),
									'name' => 'referenceno',
									'value' => '$data["referenceno"]'
								),
								array(
									'header' => getCatalog('storagebindet'),
									'name' => 'storagebindetid',
									'value' => '$data["storagebindesc"]'
								),
								array(
									'header' => getCatalog('transdate'),
									'name' => 'transdate',
									'value' => 'Yii::app()->format->formatDate($data["transdate"])'
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
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo getCatalog('productstockdet') ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderproductstockdet,
							'id' => 'DetailproductstockdetList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('productstockdetid'),
									'name' => 'productstockdetid',
									'value' => '$data["productstockdetid"]'
								),
								array(
									'header' => getCatalog('productdet'),
									'name' => 'productdetid',
									'value' => '$data["productdetname"]'
								),
								array(
									'header' => getCatalog('qtydet'),
									'name' => 'qtydet',
									'value' => 'Yii::app()->format->formatNumber($data["qtydet"])'
								),
								array(
									'header' => getCatalog('uomdet'),
									'name' => 'uomdetid',
									'value' => '$data["uomdetcode"]'
								),
								array(
									'header' => getCatalog('slocdet'),
									'name' => 'slocdetid',
									'value' => '$data["sloccodedet"]'
								),
								array(
									'header' => getCatalog('referenceno'),
									'name' => 'referenceno',
									'value' => '$data["referenceno"]'
								),
								array(
									'header' => getCatalog('storagebindet'),
									'name' => 'storagebindetid',
									'value' => '$data["storagebindesc"]'
								),
								array(
									'header' => getCatalog('transdate'),
									'name' => 'transdate',
									'value' => 'Yii::app()->format->formatDate($data["transdate"])'
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
<div id="InputDialogproductstockdet" class="modal fade" role="dialog">
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('productstockdet') ?></h4>
      </div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataproductstockdet()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>