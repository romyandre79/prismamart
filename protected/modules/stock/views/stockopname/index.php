<script src="<?php echo Yii::app()->baseUrl; ?>/js/stock/stockopname.js"></script>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo getCatalog('stockopname') ?></h3>
	</div>
	<div class="box-body">
    <?php $this->widget('Button',	array('menuname'=>'stockopname','ispost'=>true)); ?>
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
							'visible' => booltostr(CheckAccess('stockopname', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('stockopname', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('stockopname',
									'isdownload')),
							'url' => '"#"',
							'click' => "function() {
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('stockopnameid'),
					'name' => 'stockopnameid',
					'value' => '$data["stockopnameid"]'
				),
				array(
					'header' => getCatalog('transdate'),
					'name' => 'transdate',
					'value' => 'Yii::app()->format->formatDate($data["transdate"])'
				),
				array(
					'header' => getCatalog('sloccode'),
					'name' => 'slocid',
					'value' => '$data["sloccode"]'
				),
				array(
					'header' => getCatalog('stockopnameno'),
					'name' => 'stockopnameno',
					'value' => '$data["stockopnameno"]'
				),
				array(
					'header' => getCatalog('headernote'),
					'name' => 'headernote',
					'value' => '$data["headernote"]'
				),
				array(
					'header' => getCatalog('recordstatus'),
					'name' => 'statusname',
					'value' => '$data["statusname"]'
				),
			)
		));
		?>
    <?php $this->widget('Button',	array('menuname'=>'stockopname','ispost'=>true)); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'sloccode'),
  array('searchtype'=>'text','searchname'=>'stockopnameno')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/7QC6mjiqEwE')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('stockopname') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="stockopnameid">
        <div class="row">
					<div class="col-md-4">
						<label for="transdate"><?php echo getCatalog('transdate') ?></label>
					</div>
					<div class="col-md-8">
						<input type="date" class="form-control" name="transdate">
					</div>
				</div>
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'slocid', 'ColField' => 'sloccode',
					'IDDialog' => 'slocid_dialog', 'titledialog' => getCatalog('sloccode'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.SlocUserPopUp', 'PopGrid' => 'slocidgrid'));
				?>
        <div class="row">
					<div class="col-md-4">
						<label for="headernote"><?php echo getCatalog('headernote') ?></label>
					</div>
					<div class="col-md-8">
						<textarea type="text" class="form-control" rows="5" name="headernote"></textarea>
					</div>
				</div>
				<input type="hidden" class="form-control" name="recordstatus">
				<ul class="nav nav-tabs">
					<li><a data-toggle="tab" href="#stockopnamedet"><?php echo getCatalog("stockopnamedet") ?></a></li>
				</ul>
				<div class="tab-content">
					<div id="stockopnamedet" class="tab-pane">
						<button name="CreateButtonstockopnamedet" type="button" class="btn btn-primary" onclick="newdatastockopnamedet()"><?php echo getCatalog('new') ?></button>
						<button name="PurgeButtonstockopnamedet" type="button" class="btn btn-danger" onclick="purgedatastockopnamedet()"><?php echo getCatalog('purge') ?></button>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderstockopnamedet,
							'id' => 'stockopnamedetList',
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
											'visible' => booltostr(CheckAccess('stockopname',
													'iswrite')),
											'url' => '"#"',
											'click' => "function() {
								updatedatastockopnamedet($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => booltostr(CheckAccess('stockopname',
													'ispurge')),
											'url' => '"#"',
											'click' => "function() {
								purgedatastockopnamedet($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('stockopnamedetid'),
									'name' => 'stockopnamedetid',
									'value' => '$data["stockopnamedetid"]'
								),
								array(
									'header' => getCatalog('product'),
									'name' => 'productid',
									'value' => '$data["productname"]'
								),
								array(
									'header' => getCatalog('unitofmeasure'),
									'name' => 'unitofmeasureid',
									'value' => '$data["uomcode"]'
								),
								array(
									'header' => getCatalog('storagebin'),
									'name' => 'storagebinid',
									'value' => '$data["storagebindesc"]'
								),
								array(
									'header' => getCatalog('qty'),
									'name' => 'qty',
									'value' => 'Yii::app()->format->formatNumber($data["qty"])'
								),
								array(
									'header' => getCatalog('buyprice'),
									'name' => 'buyprice',
									'value' => 'Yii::app()->format->formatCurrency($data["buyprice"])'
								),
								array(
									'header' => getCatalog('buydate'),
									'name' => 'buydate',
									'value' => 'Yii::app()->format->formatDate($data["buydate"])'
								),
								array(
									'header' => getCatalog('currency'),
									'name' => 'currencyid',
									'value' => '$data["currencyname"]'
								),
								array(
									'header' => getCatalog('expiredate'),
									'name' => 'expiredate',
									'value' => 'Yii::app()->format->formatDate($data["expiredate"])'
								),
								array(
									'header' => getCatalog('materialstatus'),
									'name' => 'materialstatusid',
									'value' => '$data["materialstatusname"]'
								),
								array(
									'header' => getCatalog('ownership'),
									'name' => 'ownershipid',
									'value' => '$data["ownershipname"]'
								),
								array(
									'header' => getCatalog('serialno'),
									'name' => 'serialno',
									'value' => '$data["serialno"]'
								),
								array(
									'header' => getCatalog('location'),
									'name' => 'location',
									'value' => '$data["location"]'
								),
								array(
									'header' => getCatalog('itemnote'),
									'name' => 'itemnote',
									'value' => '$data["itemnote"]'
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
						<h3 class="box-title"><?php echo getCatalog('stockopnamedet') ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderstockopnamedet,
							'id' => 'DetailstockopnamedetList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('stockopnamedetid'),
									'name' => 'stockopnamedetid',
									'value' => '$data["stockopnamedetid"]'
								),
								array(
									'header' => getCatalog('product'),
									'name' => 'productid',
									'value' => '$data["productname"]'
								),
								array(
									'header' => getCatalog('unitofmeasure'),
									'name' => 'unitofmeasureid',
									'value' => '$data["uomcode"]'
								),
								array(
									'header' => getCatalog('storagebin'),
									'name' => 'storagebinid',
									'value' => '$data["storagebindesc"]'
								),
								array(
									'header' => getCatalog('qty'),
									'name' => 'qty',
									'value' => 'Yii::app()->format->formatNumber($data["qty"])'
								),
								array(
									'header' => getCatalog('buyprice'),
									'name' => 'buyprice',
									'value' => 'Yii::app()->format->formatCurrency($data["buyprice"])'
								),
								array(
									'header' => getCatalog('buydate'),
									'name' => 'buydate',
									'value' => 'Yii::app()->format->formatDate($data["buydate"])'
								),
								array(
									'header' => getCatalog('currency'),
									'name' => 'currencyid',
									'value' => '$data["currencyname"]'
								),
								array(
									'header' => getCatalog('expiredate'),
									'name' => 'expiredate',
									'value' => 'Yii::app()->format->formatDate($data["expiredate"])'
								),
								array(
									'header' => getCatalog('materialstatus'),
									'name' => 'materialstatusid',
									'value' => '$data["materialstatusname"]'
								),
								array(
									'header' => getCatalog('ownership'),
									'name' => 'ownershipid',
									'value' => '$data["ownershipname"]'
								),
								array(
									'header' => getCatalog('serialno'),
									'name' => 'serialno',
									'value' => '$data["serialno"]'
								),
								array(
									'header' => getCatalog('location'),
									'name' => 'location',
									'value' => '$data["location"]'
								),
								array(
									'header' => getCatalog('itemnote'),
									'name' => 'itemnote',
									'value' => '$data["itemnote"]'
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

<div id="InputDialogstockopnamedet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('stockopnamedet') ?></h4>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="stockopnamedetid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'productid', 'ColField' => 'productname',
					'IDDialog' => 'productid_dialog', 'titledialog' => getCatalog('product'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => 'slocid',
					'PopUpName' => 'common.components.views.ProductplantslocPopUp', 'PopGrid' => 'productidgrid',
					'onaftersign' => 'getproductplant();'));
				?>

				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'unitofmeasureid', 'ColField' => 'uomcode',
					'IDDialog' => 'unitofmeasureid_dialog', 'titledialog' => getCatalog('unitofmeasure'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => 'productid',
					'PopUpName' => 'common.components.views.UomPlantPopUp', 'PopGrid' => 'unitofmeasureidgrid'));
				?>

				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'storagebinid', 'ColField' => 'storagebindesc',
					'IDDialog' => 'storagebinid_dialog', 'titledialog' => getCatalog('storagebin'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => 'slocid',
					'PopUpName' => 'common.components.views.StoragebinPopUp', 'PopGrid' => 'storagebinidgrid'));
				?>

        <div class="row">
					<div class="col-md-4">
						<label for="qty"><?php echo getCatalog('qty') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="qty">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="buyprice"><?php echo getCatalog('buyprice') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="buyprice">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="buydate"><?php echo getCatalog('buydate') ?></label>
					</div>
					<div class="col-md-8">
						<input type="date" class="form-control" name="buydate">
					</div>
				</div>

				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'currencyid', 'ColField' => 'currencyname',
					'IDDialog' => 'currencyid_dialog', 'titledialog' => getCatalog('currency'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'admin.components.views.CurrencyPopUp', 'PopGrid' => 'currencyidgrid'));
				?>

        <div class="row">
					<div class="col-md-4">
						<label for="expiredate"><?php echo getCatalog('expiredate') ?></label>
					</div>
					<div class="col-md-8">
						<input type="date" class="form-control" name="expiredate">
					</div>
				</div>

				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'materialstatusid', 'ColField' => 'materialstatusname',
					'IDDialog' => 'materialstatusid_dialog', 'titledialog' => getCatalog('materialstatus'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.MaterialstatusPopUp', 'PopGrid' => 'materialstatusidgrid'));
				?>

				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'ownershipid', 'ColField' => 'ownershipname',
					'IDDialog' => 'ownershipid_dialog', 'titledialog' => getCatalog('ownership'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.OwnershipPopUp', 'PopGrid' => 'ownershipidgrid'));
				?>

        <div class="row">
					<div class="col-md-4">
						<label for="serialno"><?php echo getCatalog('serialno') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="serialno">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="location"><?php echo getCatalog('location') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="location">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="itemnote"><?php echo getCatalog('itemnote') ?></label>
					</div>
					<div class="col-md-8">
						<textarea type="text" class="form-control" rows="5" name="itemnote"></textarea>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatastockopnamedet()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>
