<script src="<?php echo Yii::app()->baseUrl; ?>/js/warehouse/prheader.js"></script>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo getCatalog('prheader') ?></h3>
		<?php if (CheckAccess('prheader', 'iswrite')) { ?>
			<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo getCatalog('new') ?></button>
		<?php } ?>
		<?php if (CheckAccess('prheader', 'ispost')) { ?>
			<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo getCatalog('approve') ?></button>
		<?php } ?>
		<?php if (CheckAccess('prheader', 'isreject')) { ?>
			<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo getCatalog('reject') ?></button>
		<?php } ?>
		<?php if (CheckAccess('prheader', 'ispurge')) { ?>
			<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo getCatalog('purge') ?></button>
		<?php } ?>
		<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo getCatalog('search') ?></button>
		<?php if (CheckAccess('prheader', 'isdownload')) { ?>
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
							'visible' => booltostr(CheckAccess('prheader', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('prheader', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('prheader', 'isdownload')),
							'url' => '"#"',
							'click' => "function() {
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('prheaderid'),
					'name' => 'prheaderid',
					'value' => '$data["prheaderid"]'
				),
				array(
					'header' => getCatalog('prdate'),
					'name' => 'prdate',
					'value' => 'Yii::app()->format->formatDate($data["prdate"])'
				),
				array(
					'header' => getCatalog('companyname'),
					'name' => 'companyid',
					'value' => '$data["companyname"]'
				),
				array(
					'header' => getCatalog('prno'),
					'name' => 'prno',
					'value' => '$data["prno"]'
				),
				array(
					'header' => getCatalog('frno'),
					'name' => 'formrequestid',
					'value' => '$data["frno"]'
				), array(
					'header' => getCatalog('customer'),
					'name' => 'fullname',
					'value' => '$data["fullname"]'
				),
				array(
					'header' => getCatalog('sono'),
					'name' => 'sono',
					'value' => '$data["sono"]'
				), array(
					'header' => getCatalog('productplanno'),
					'name' => 'productplanno',
					'value' => '$data["productplanno"]'
				), array(
					'header' => getCatalog('pocustno'),
					'name' => 'pocustno',
					'value' => '$data["pocustno"]'
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
					<label for="dlg_search_prno"><?php echo getCatalog('prno') ?></label>
					<input type="text" class="form-control" name="dlg_search_prno">
				</div>
				<div class="form-group">
					<label for="dlg_search_frno"><?php echo getCatalog('frno') ?></label>
					<input type="text" class="form-control" name="dlg_search_frno">
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
        <h4 class="modal-title"><?php echo getCatalog('prheader') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="prheaderid">
        <div class="row">
					<div class="col-md-4">
						<label for="prdate"><?php echo getCatalog('prdate') ?></label>
					</div>
					<div class="col-md-8">
						<input type="date" class="form-control" name="prdate">
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
					array('id' => 'Widget', 'IDField' => 'formrequestid', 'ColField' => 'frno',
					'IDDialog' => 'formrequestid_dialog', 'titledialog' => getCatalog('frno'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => 'companyid',
					'PopUpName' => 'warehouse.components.views.FormrequestppPopUp', 'PopGrid' => 'formrequestidgrid',
					'onaftersign' => 'generatefr();'));
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
					<li><a data-toggle="tab" href="#prmaterial"><?php echo getCatalog("prmaterial") ?></a></li>

				</ul>
				<div class="tab-content">

					<div id="prmaterial" class="tab-pane">
						<button name="CreateButton" type="button" class="btn btn-danger" onclick="purgedataprmaterial($.fn.yiiGridView.getSelection('prmaterialList'))"><?php echo getCatalog('purge') ?></button>
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderprmaterial,
							'id' => 'prmaterialList',
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
								updatedataprmaterial($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
										'purge' => array
											(
											'label' => getCatalog('purge'),
											'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
											'visible' => 'true',
											'url' => '"#"',
											'click' => "function() {
								purgedataprmaterial($(this).parent().parent().children(':nth-child(3)').text());
							}",
										),
									),
								),
								array(
									'header' => getCatalog('prmaterialid'),
									'name' => 'prmaterialid',
									'value' => '$data["prmaterialid"]'
								),
								array(
									'header' => getCatalog('product'),
									'name' => 'productid',
									'value' => '$data["productname"]'
								),
								array(
									'header' => getCatalog('qty'),
									'name' => 'qty',
									'type' => 'raw',
									'value' => 'CHtml::image(Yii::app()->baseUrl.(($data["qty"] >= $data["qtystock"])?"/images/empty.png":"/images/full.png"),"",
					array("width"=>"30")) . Yii::app()->format->formatNumber($data["qty"])'
								),
								array(
									'header' => getCatalog('poqty'),
									'name' => 'poqty',
									'type' => 'raw',
									'value' => 'CHtml::image(Yii::app()->baseUrl.(($data["qty"] > $data["poqty"])?"/images/basket-remove.png":"/images/basket-accept.png"),"",
					array("width"=>"30")) .Yii::app()->format->formatNumber($data["poqty"])'
								),
								array(
									'header' => getCatalog('grqty'),
									'name' => 'grqty',
									'type' => 'raw',
									'value' => 'CHtml::image(Yii::app()->baseUrl.(($data["qty"] > $data["grqty"])?"/images/basket-remove.png":"/images/basket-accept.png"),"",
					array("width"=>"30")) .Yii::app()->format->formatNumber($data["grqty"])'
								),
								array(
									'header' => getCatalog('giqty'),
									'name' => 'giqty',
									'type' => 'raw',
									'value' => 'CHtml::image(Yii::app()->baseUrl.(($data["qty"] > $data["giqty"])?"/images/basket-remove.png":"/images/basket-accept.png"),"",
					array("width"=>"30")) .Yii::app()->format->formatNumber($data["giqty"])'
								),
								array(
									'header' => getCatalog('qtystock'),
									'name' => 'qtystock',
									'type' => 'raw',
									'value' => 'CHtml::image(Yii::app()->baseUrl.(($data["qtystock"] <= 0)?"/images/empty.png":"/images/full.png"),"",
					array("width"=>"30")) . Yii::app()->format->formatNumber($data["qtystock"])'
								),
								array(
									'header' => getCatalog('unitofmeasure'),
									'name' => 'unitofmeasureid',
									'value' => '$data["uomcode"]'
								),
								array(
									'header' => getCatalog('reqdate'),
									'name' => 'reqdate',
									'value' => 'Yii::app()->format->formatDate($data["reqdate"])'
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
						<h3 class="box-title"><?php echo getCatalog('prmaterial') ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderprmaterial,
							'id' => 'DetailprmaterialList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('prmaterialid'),
									'name' => 'prmaterialid',
									'value' => '$data["prmaterialid"]'
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
									'type' => 'raw',
									'value' => 'CHtml::image(Yii::app()->baseUrl.(($data["qty"] > $data["poqty"])?"/images/basket-remove.png":"/images/basket-accept.png"),"",
					array("width"=>"30")) .Yii::app()->format->formatNumber($data["poqty"])'
								),
								array(
									'header' => getCatalog('grqty'),
									'name' => 'grqty',
									'type' => 'raw',
									'value' => 'CHtml::image(Yii::app()->baseUrl.(($data["qty"] > $data["grqty"])?"/images/basket-remove.png":"/images/basket-accept.png"),"",
					array("width"=>"30")) .Yii::app()->format->formatNumber($data["grqty"])'
								),
								array(
									'header' => getCatalog('giqty'),
									'name' => 'giqty',
									'type' => 'raw',
									'value' => 'CHtml::image(Yii::app()->baseUrl.(($data["qty"] > $data["giqty"])?"/images/basket-remove.png":"/images/basket-accept.png"),"",
					array("width"=>"30")) .Yii::app()->format->formatNumber($data["giqty"])'
								),
								array(
									'header' => getCatalog('qtystock'),
									'name' => 'qtystock',
									'type' => 'raw',
									'value' => 'CHtml::image(Yii::app()->baseUrl.(($data["qtystock"] <= 0)?"/images/empty.png":"/images/full.png"),"",
					array("width"=>"30")) . Yii::app()->format->formatNumber($data["qtystock"])'
								),
								array(
									'header' => getCatalog('unitofmeasure'),
									'name' => 'unitofmeasureid',
									'value' => '$data["uomcode"]'
								),
								array(
									'header' => getCatalog('reqdate'),
									'name' => 'reqdate',
									'value' => 'Yii::app()->format->formatDate($data["reqdate"])'
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

<div id="InputDialogprmaterial" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('prmaterial') ?></h4>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="prmaterialid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'productid', 'ColField' => 'productname',
					'IDDialog' => 'productid_dialog', 'titledialog' => getCatalog('product'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.ProductPopUp', 'PopGrid' => 'productidgrid'));
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

        <div class="row">
					<div class="col-md-4">
						<label for="reqdate"><?php echo getCatalog('reqdate') ?></label>
					</div>
					<div class="col-md-8">
						<input type="date" class="form-control" name="reqdate">
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="itemtext"><?php echo getCatalog('itemtext') ?></label>
					</div>
					<div class="col-md-8">
						<textarea type="text" class="form-control" rows="5" name="itemtext"></textarea>
					</div>
				</div>

        <div class="row">
					<div class="col-md-4">
						<label for="formrequestdetid"><?php echo getCatalog('formrequestdetid') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="formrequestdetid">
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
				<button type="submit" class="btn btn-success" onclick="savedataprmaterial()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
		</div>
	</div>
</div>

