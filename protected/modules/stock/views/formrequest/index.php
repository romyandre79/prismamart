<script src="<?php echo Yii::app()->baseUrl; ?>/js/stock/formrequest.js"></script>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo getCatalog('formrequest') ?></h3>
		<?php if (CheckAccess('formrequest', 'iswrite')) { ?>
			<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo getCatalog('new') ?></button>
		<?php } ?>
		<?php if (CheckAccess('formrequest', 'ispost')) { ?>
			<button name="ApproveButton" type="button" class="btn btn-primary" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo getCatalog('approve') ?></button>
		<?php } ?>
		<?php if (CheckAccess('formrequest', 'isreject')) { ?>
			<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo getCatalog('reject') ?></button>
		<?php } ?>
		<?php if (CheckAccess('formrequest', 'ispurge')) { ?>
			<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo getCatalog('purge') ?></button>
		<?php } ?>
		<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo getCatalog('search') ?></button>
		<?php if (CheckAccess('formrequest', 'isdownload')) { ?>
			<div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<?php echo getCatalog('download') ?> <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu">
					<li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo getCatalog('downpdf') ?></a></li>
				</ul>
			</div>
		<?php } ?>
		<button name="HelpButton" type="button" class="btn btn-warning" data-toggle="modal" data-target="#HelpDialog"><?php echo getCatalog('help') ?></button>
	</div>
	<div class="box-body">
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
							'visible' => booltostr(CheckAccess('formrequest', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('formrequest', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('formrequest',
									'isdownload')),
							'url' => '"#"',
							'click' => "function() {
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('formrequestid'),
					'name' => 'formrequestid',
					'value' => '$data["formrequestid"]'
				),
				array(
					'header' => getCatalog('frdate'),
					'name' => 'frdate',
					'value' => 'Yii::app()->format->formatDate($data["frdate"])'
				),
				array(
					'header' => getCatalog('companyname'),
					'name' => 'companyid',
					'value' => '$data["companyname"]'
				),
				array(
					'header' => getCatalog('frno'),
					'name' => 'frno',
					'value' => '$data["frno"]'
				),
				array(
					'header' => getCatalog('sloccode'),
					'name' => 'slocid',
					'value' => '$data["sloccode"]'
				),
				array(
					'header' => getCatalog('useraccess'),
					'name' => 'useraccessid',
					'value' => '$data["username"]'
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
	</div>
</div>
<div id="HelpDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<iframe width="100%" height="480px" src="https://www.youtube.com/embed/htBesRYHuSw" frameborder="0" allowfullscreen></iframe>
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
					<label for="dlg_search_companyname"><?php echo getCatalog('companyname') ?></label>
					<input type="text" class="form-control" name="dlg_search_companyname">
				</div>
				<div class="form-group">
					<label for="dlg_search_frno"><?php echo getCatalog('frno') ?></label>
					<input type="text" class="form-control" name="dlg_search_frno">
				</div>
				<div class="form-group">
					<label for="dlg_search_productplanno"><?php echo getCatalog('productplanno') ?></label>
					<input type="text" class="form-control" name="dlg_search_productplanno">
				</div>
				<div class="form-group">
					<label for="dlg_search_sloccode"><?php echo getCatalog('sloccode') ?></label>
					<input type="text" class="form-control" name="dlg_search_sloccode">
				</div>
				<div class="form-group">
					<label for="dlg_search_productname"><?php echo getCatalog('productname') ?></label>
					<input type="text" class="form-control" name="dlg_search_productname">
				</div>
				<div class="form-group">
					<label for="dlg_search_uomcode"><?php echo getCatalog('uomcode') ?></label>
					<input type="text" class="form-control" name="dlg_search_uomcode">
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
        <h4 class="modal-title"><?php echo getCatalog('formrequest') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="formrequestid">
        <div class="row">
					<div class="col-md-4">
						<label for="frdate"><?php echo getCatalog('frdate') ?></label>
					</div>
					<div class="col-md-8">
						<input type="date" class="form-control" name="frdate">
					</div>
				</div>

				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'companyid', 'ColField' => 'companyname',
					'IDDialog' => 'companyid_dialog', 'titledialog' => getCatalog('companyname'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'admin.components.views.CompanyPopUp', 'PopGrid' => 'companyidgrid'));
				?>

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
					<li><a data-toggle="tab" href="#formrequestdet"><?php echo getCatalog("formrequestdet") ?></a></li>

				</ul>
				<div class="tab-content">

					<div id="formrequestdet" class="tab-pane">
						<button name="CreateButtonbomdetail" type="button" class="btn btn-primary" onclick="newdataformrequestdet()"><?php echo getCatalog('new') ?></button>
						<button name="PurgeButtonbomdetail" type="button" class="btn btn-danger" onclick="purgedataformrequestdet()"><?php echo getCatalog('purge') ?></button>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderformrequestdet,
							'id' => 'formrequestdetList',
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
									'template' => '{edit}',
									'htmlOptions' => array('style' => 'width:80px'),
									'buttons' => array
										(
										'edit' => array
											(
											'label' => getCatalog('edit'),
											'imageUrl' => Yii::app()->baseUrl.'/images/edit.png',
											'visible' => 'true',
											'url' => '"#"',
											'click' => "function() {
								updatedataformrequestdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => 'true',
											'url' => '"#"',
											'click' => "function() {
								purgedataformrequestdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('formrequestdetid'),
									'name' => 'formrequestdetid',
									'value' => '$data["formrequestdetid"]'
								),
								array(
									'header' => getCatalog('product'),
									'name' => 'productid',
									'value' => '$data["productname"]'
								),
								array(
									'header' => getCatalog('qty'),
									'name' => 'qty',
									'value' => 'Yii::app()->format->formatNumber($data["qty"])'
								),
								array(
									'header' => getCatalog('poqty'),
									'name' => 'poqty',
									'value' => 'Yii::app()->format->formatNumber($data["poqty"])'
								),
								array(
									'header' => getCatalog('grqty'),
									'name' => 'grqty',
									'value' => 'Yii::app()->format->formatNumber($data["grqty"])'
								),
								array(
									'header' => getCatalog('tsqty'),
									'name' => 'tsqty',
									'value' => 'Yii::app()->format->formatNumber($data["tsqty"])'
								),
								array(
									'header' => getCatalog('unitofmeasure'),
									'name' => 'unitofmeasureid',
									'value' => '$data["uomcode"]'
								),
								array(
									'header' => getCatalog('itemtext'),
									'name' => 'itemtext',
									'value' => '$data["itemtext"]'
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
						<h3 class="box-title"><?php echo getCatalog('formrequestdet') ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderformrequestdet,
							'id' => 'DetailformrequestdetList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('formrequestdetid'),
									'name' => 'formrequestdetid',
									'value' => '$data["formrequestdetid"]'
								),
								array(
									'header' => getCatalog('product'),
									'name' => 'productid',
									'value' => '$data["productname"]'
								),
								array(
									'header' => getCatalog('qty'),
									'name' => 'qty',
									'value' => 'Yii::app()->format->formatNumber($data["qty"])'
								),
								array(
									'header' => getCatalog('poqty'),
									'name' => 'poqty',
									'value' => 'Yii::app()->format->formatNumber($data["poqty"])'
								),
								array(
									'header' => getCatalog('grqty'),
									'name' => 'grqty',
									'value' => 'Yii::app()->format->formatNumber($data["grqty"])'
								),
								array(
									'header' => getCatalog('tsqty'),
									'name' => 'tsqty',
									'value' => 'Yii::app()->format->formatNumber($data["tsqty"])'
								),
								array(
									'header' => getCatalog('unitofmeasure'),
									'name' => 'unitofmeasureid',
									'value' => '$data["uomcode"]'
								),
								array(
									'header' => getCatalog('itemtext'),
									'name' => 'itemtext',
									'value' => '$data["itemtext"]'
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

<div id="InputDialogformrequestdet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('formrequestdet') ?></h4>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="formrequestdetid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'productid', 'ColField' => 'productname',
					'IDDialog' => 'productid_dialog', 'titledialog' => getCatalog('product'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.ProductPopUp', 'PopGrid' => 'productidgrid',
					'onaftersign' => 'getproductplant();'));
				?>

        <div class="row">
					<div class="col-md-4">
						<label for="qty"><?php echo getCatalog('qty') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="qty">
					</div>
				</div>

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
					array('id' => 'Widget', 'IDField' => 'slocdetid', 'ColField' => 'sloccodedet',
					'IDDialog' => 'slocdetid_dialog', 'titledialog' => getCatalog('sloc'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.SlocUserPopUp', 'PopGrid' => 'slocdetidgrid'));
				?>

        <div class="row">
					<div class="col-md-4">
						<label for="itemtext"><?php echo getCatalog('itemtext') ?></label>
					</div>
					<div class="col-md-8">
						<textarea type="text" class="form-control" rows="5" name="itemtext"></textarea>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataformrequestdet()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>

