<script src="<?php echo Yii::app()->baseUrl; ?>/js/common/customer.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
		<h3 class="card-title"><?php echo getCatalog('customer') ?></h3>
	</div>
	<div class="card-body">
    <?php $this->widget('Button',	array('menuname'=>'customer')); ?>
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
					'template' => '{select} {edit} {delete} {purge} {pdf}',
					'buttons' => array
						(
						'select' => array
							(
							'label' => getCatalog('select'),
							'imageUrl' => Yii::app()->baseUrl.'/images/detail.png',
							'click' => "function() {
							GetDetail($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'edit' => array
							(
							'label' => getCatalog('edit'),
							'imageUrl' => Yii::app()->baseUrl.'/images/edit.png',
							'visible' => booltostr(CheckAccess('customer', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
							updatedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'delete' => array
							(
							'label' => getCatalog('delete'),
							'imageUrl' => Yii::app()->baseUrl.'/images/active.png',
							'visible' => booltostr(CheckAccess('customer', 'isreject')),
							'url' => '"#"',
							'click' => "function() {
							deletedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('customer', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
							purgedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('customer', 'isdownload')),
							'url' => '"#"',
							'click' => "function() {
							downpdf($(this).parent().parent().children(':nth-child(3)').text());
						}",
						),
					),
				),
				array(
					'header' => getCatalog('addressbookid'),
					'name' => 'addressbookid',
					'value' => '$data["addressbookid"]'
				),
				array(
					'header' => getCatalog('fullname'),
					'name' => 'fullname',
					'value' => '$data["fullname"]'
				),
				array(
					'header' => getCatalog('currentlimit'),
					'name' => 'currentlimit',
					'value' => 'Yii::app()->format->formatCurrency($data["currentlimit"])'
				),
				array(
					'header' => getCatalog('npwpno'),
					'name' => 'taxno',
					'value' => '$data["taxno"]'
				),
				array(
					'header' => getCatalog('creditlimit'),
					'name' => 'creditlimit',
					'value' => 'Yii::app()->format->formatCurrency($data["creditlimit"])'
				),
				array(
					'class' => 'CCheckBoxColumn',
					'name' => 'isstrictlimit',
					'header' => getCatalog('isstrictlimit'),
					'selectableRows' => '0',
					'checked' => '$data["isstrictlimit"]',
				), array(
					'header' => getCatalog('bankname'),
					'name' => 'bankname',
					'value' => '$data["bankname"]'
				),
				array(
					'header' => getCatalog('bankaccountno'),
					'name' => 'bankaccountno',
					'value' => '$data["bankaccountno"]'
				),
				array(
					'header' => getCatalog('accountowner'),
					'name' => 'accountowner',
					'value' => '$data["accountowner"]'
				),
				array(
					'header' => getCatalog('salesarea'),
					'name' => 'salesareaid',
					'value' => '$data["areaname"]'
				),
				array(
					'header' => getCatalog('pricecategory'),
					'name' => 'pricecategoryid',
					'value' => '$data["categoryname"]'
				),
				array(
					'header' => getCatalog('overdue'),
					'name' => 'overdue',
					'value' => '$data["overdue"]'
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
    <?php $this->widget('Button',	array('menuname'=>'customer')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'fullname'),
  array('searchtype'=>'text','searchname'=>'taxno'),
  array('searchtype'=>'text','searchname'=>'bankname'),
  array('searchtype'=>'text','searchname'=>'bankaccountno'),
  array('searchtype'=>'text','searchname'=>'accountowner'),
  array('searchtype'=>'text','searchname'=>'areaname'),
  array('searchtype'=>'text','searchname'=>'categoryname')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/aIPx_OeMJts')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('customer') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="addressbookid">
        <div class="row">
					<div class="col-md-4">
						<label for="fullname"><?php echo getCatalog('fullname') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="fullname">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="taxno"><?php echo getCatalog('npwpno') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="taxno">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="creditlimit"><?php echo getCatalog('creditlimit') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="creditlimit">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="isstrictlimit"><?php echo getCatalog('isstrictlimit') ?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="isstrictlimit">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="bankname"><?php echo getCatalog('bankname') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="bankname">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="bankaccountno"><?php echo getCatalog('bankaccountno') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="bankaccountno">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="accountowner"><?php echo getCatalog('accountowner') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="accountowner">
					</div>
				</div>
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'salesareaid', 'ColField' => 'areaname',
					'IDDialog' => 'salesareaid_dialog', 'titledialog' => getCatalog('salesarea'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => '',
					'PopUpName' => 'common.components.views.SalesareaPopUp', 'PopGrid' => 'salesareaidgrid'));
				?>
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'pricecategoryid', 'ColField' => 'categoryname',
					'IDDialog' => 'pricecategoryid_dialog', 'titledialog' => getCatalog('pricecategory'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => '',
					'PopUpName' => 'common.components.views.PricecategoryPopUp', 'PopGrid' => 'pricecategoryidgrid'));
				?>
        <div class="row">
					<div class="col-md-4">
						<label for="overdue"><?php echo getCatalog('overdue') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="overdue">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="logo"><?php echo getCatalog('logo') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="logo">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-8">
						<script>
							function successUp(param, param2, param3) {
								$('input[name="logo"]').val(param2);
							}
						</script>
						<?php
						$events = array(
							'success' => 'successUp(param,param2,param3)',
						);
						$this->widget('ext.dropzone.EDropzone',
							array(
							'name' => 'upload',
							'url' => Yii::app()->createUrl('common/customer/upload'),
							'mimeTypes' => array('.jpg', '.png', '.jpeg'),
							'events' => $events,
							'options' => CMap::mergeArray($this->options, $this->dict),
							'htmlOptions' => array('style' => 'height:95%; overflow: hidden;'),
						));
						?>
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="url"><?php echo getCatalog('url') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="url">
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
					<li><a data-toggle="tab" href="#address"><?php echo getCatalog("address") ?></a></li>
					<li><a data-toggle="tab" href="#addresscontact"><?php echo getCatalog("addresscontact") ?></a></li>
				</ul>
				<div class="tab-content">
					<div id="address" class="tab-pane">
						<?php if (CheckAccess('customer', 'iswrite')) { ?>
							<button name="CreateButtonaddress" type="button" class="btn btn-primary" onclick="newdataaddress()"><?php echo getCatalog('new') ?></button>
						<?php } ?>
						<?php if (CheckAccess('customer', 'iswrite')) { ?>
							<button name="PurgeButtonaddress" type="button" class="btn btn-danger" onclick="purgedataaddress()"><?php echo getCatalog('purge') ?></button>
						<?php } ?>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProvideraddress,
							'id' => 'addressList',
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
											'visible' => booltostr(CheckAccess('customer', 'iswrite')),
											'url' => '"#"',
											'click' => "function() {
								updatedataaddress($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => booltostr(CheckAccess('customer', 'iswrite')),
											'url' => '"#"',
											'click' => "function() {
								purgedataaddress($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('addressid'),
									'name' => 'addressid',
									'value' => '$data["addressid"]'
								),
								array(
									'header' => getCatalog('addresstype'),
									'name' => 'addresstypeid',
									'value' => '$data["addresstypename"]'
								),
								array(
									'header' => getCatalog('addressname'),
									'name' => 'addressname',
									'value' => '$data["addressname"]'
								),
								array(
									'header' => getCatalog('rt'),
									'name' => 'rt',
									'value' => '$data["rt"]'
								),
								array(
									'header' => getCatalog('rw'),
									'name' => 'rw',
									'value' => '$data["rw"]'
								),
								array(
									'header' => getCatalog('city'),
									'name' => 'cityid',
									'value' => '$data["cityname"]'
								),
								array(
									'header' => getCatalog('phoneno'),
									'name' => 'phoneno',
									'value' => '$data["phoneno"]'
								),
								array(
									'header' => getCatalog('faxno'),
									'name' => 'faxno',
									'value' => '$data["faxno"]'
								),
								array(
									'header' => getCatalog('lat'),
									'name' => 'lat',
									'value' => '$data["lat"]'
								),
								array(
									'header' => getCatalog('lng'),
									'name' => 'lng',
									'value' => '$data["lng"]'
								),
							)
						));
						?>
					</div>
					<div id="addresscontact" class="tab-pane">
						<?php if (CheckAccess('customer', 'iswrite')) { ?>
							<button name="CreateButtonaddresscontact" type="button" class="btn btn-primary" onclick="newdataaddresscontact()"><?php echo getCatalog('new') ?></button>
						<?php } ?>
						<?php if (CheckAccess('customer', 'ispurge')) { ?>
							<button name="PurgeButtonaddresscontact" type="button" class="btn btn-danger" onclick="purgedataaddresscontact()"><?php echo getCatalog('purge') ?></button>
						<?php } ?>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProvideraddresscontact,
							'id' => 'addresscontactList',
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
											'visible' => booltostr(CheckAccess('supplier', 'iswrite')),
											'url' => '"#"',
											'click' => "function() {
								updatedataaddresscontact($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => booltostr(CheckAccess('supplier', 'ispurge')),
											'url' => '"#"',
											'click' => "function() {
								purgedataaddresscontact($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('addresscontactid'),
									'name' => 'addresscontactid',
									'value' => '$data["addresscontactid"]'
								),
								array(
									'header' => getCatalog('contacttype'),
									'name' => 'contacttypeid',
									'value' => '$data["contacttypename"]'
								),
								array(
									'header' => getCatalog('addresscontactname'),
									'name' => 'addresscontactname',
									'value' => '$data["addresscontactname"]'
								),
								array(
									'header' => getCatalog('phoneno'),
									'name' => 'phoneno',
									'value' => '$data["phoneno"]'
								),
								array(
									'header' => getCatalog('mobilephone'),
									'name' => 'mobilephone',
									'value' => '$data["mobilephone"]'
								),
								array(
									'header' => getCatalog('emailaddress'),
									'name' => 'emailaddress',
									'value' => '$data["emailaddress"]'
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
						<h3 class="box-title"><?php echo getCatalog('address') ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProvideraddress,
							'id' => 'DetailaddressList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('addressid'),
									'name' => 'addressid',
									'value' => '$data["addressid"]'
								),
								array(
									'header' => getCatalog('addresstype'),
									'name' => 'addresstypeid',
									'value' => '$data["addresstypename"]'
								),
								array(
									'header' => getCatalog('addressname'),
									'name' => 'addressname',
									'value' => '$data["addressname"]'
								),
								array(
									'header' => getCatalog('rt'),
									'name' => 'rt',
									'value' => '$data["rt"]'
								),
								array(
									'header' => getCatalog('rw'),
									'name' => 'rw',
									'value' => '$data["rw"]'
								),
								array(
									'header' => getCatalog('city'),
									'name' => 'cityid',
									'value' => '$data["cityname"]'
								),
								array(
									'header' => getCatalog('phoneno'),
									'name' => 'phoneno',
									'value' => '$data["phoneno"]'
								),
								array(
									'header' => getCatalog('faxno'),
									'name' => 'faxno',
									'value' => '$data["faxno"]'
								),
								array(
									'header' => getCatalog('lat'),
									'name' => 'lat',
									'value' => '$data["lat"]'
								),
								array(
									'header' => getCatalog('lng'),
									'name' => 'lng',
									'value' => '$data["lng"]'
								),
							)
						));
						?>
					</div>
				</div>
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo getCatalog('addresscontact') ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProvideraddresscontact,
							'id' => 'DetailaddresscontactList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('addresscontactid'),
									'name' => 'addresscontactid',
									'value' => '$data["addresscontactid"]'
								),
								array(
									'header' => getCatalog('contacttype'),
									'name' => 'contacttypeid',
									'value' => '$data["contacttypename"]'
								),
								array(
									'header' => getCatalog('addresscontactname'),
									'name' => 'addresscontactname',
									'value' => '$data["addresscontactname"]'
								),
								array(
									'header' => getCatalog('phoneno'),
									'name' => 'phoneno',
									'value' => '$data["phoneno"]'
								),
								array(
									'header' => getCatalog('mobilephone'),
									'name' => 'mobilephone',
									'value' => '$data["mobilephone"]'
								),
								array(
									'header' => getCatalog('emailaddress'),
									'name' => 'emailaddress',
									'value' => '$data["emailaddress"]'
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

<div id="InputDialogaddress" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('address') ?></h4>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="addressid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'addresstypeid', 'ColField' => 'addresstypename',
					'IDDialog' => 'addresstypeid_dialog', 'titledialog' => getCatalog('addresstype'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => '',
					'PopUpName' => 'common.components.views.AddresstypePopUp', 'PopGrid' => 'addresstypeidgrid'));
				?>

        <div class="row">
					<div class="col-md-4">
						<label for="addressname"><?php echo getCatalog('addressname') ?></label>
					</div>
					<div class="col-md-8">
						<textarea type="text" class="form-control" rows="5" name="addressname"></textarea>
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="rt"><?php echo getCatalog('rt') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="rt">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="rw"><?php echo getCatalog('rw') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="rw">
					</div>
				</div>

				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'cityid', 'ColField' => 'cityname',
					'IDDialog' => 'cityid_dialog', 'titledialog' => getCatalog('city'), 'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => '',
					'PopUpName' => 'admin.components.views.CityPopUp', 'PopGrid' => 'cityidgrid'));
				?>

        <div class="row">
					<div class="col-md-4">
						<label for="phoneno"><?php echo getCatalog('phoneno') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="phoneno">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="faxno"><?php echo getCatalog('faxno') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="faxno">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="lat"><?php echo getCatalog('lat') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="lat">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="lng"><?php echo getCatalog('lng') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="lng">
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataaddress()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>
<div id="InputDialogaddresscontact" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('addresscontact') ?></h4>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="addresscontactid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'contacttypeid', 'ColField' => 'contacttypename',
					'IDDialog' => 'contacttypeid_dialog', 'titledialog' => getCatalog('contacttype'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => '',
					'PopUpName' => 'common.components.views.ContacttypePopUp', 'PopGrid' => 'contacttypeidgrid'));
				?>

        <div class="row">
					<div class="col-md-4">
						<label for="addresscontactname"><?php echo getCatalog('addresscontactname') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="addresscontactname">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="phoneno"><?php echo getCatalog('phoneno') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="phoneno">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="mobilephone"><?php echo getCatalog('mobilephone') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="mobilephone">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="emailaddress"><?php echo getCatalog('emailaddress') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="emailaddress">
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataaddresscontact()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/adminlte.min.css">