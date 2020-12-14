<script type="text/javascript">
	function searchdata($id = 0) {
		$('#SearchDialog').modal('hide');
		$.fn.yiiGridView.update("GridList", {data: {
				'productstockid': $id,
				'productname': $("input[name='dlg_search_productname']").val(),
				'sloccode': $("input[name='dlg_search_sloccode']").val(),
				'uomcode': $("input[name='dlg_search_uomcode']").val()
			}});
		return false;
	}

	function downpdf($id = 0) {
		var array = 'productstockid=' + $id
			+ '&productname=' + $("input[name='dlg_search_productname']").val()
			+ '&sloccode=' + $("input[name='dlg_search_sloccode']").val()
			+ '&uomcode=' + $("input[name='dlg_search_uomcode']").val();
		window.open('<?php echo Yii::app()->createUrl('Stock/productstock/downpdf') ?>?' + array);
	}
</script>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><a href="<?php echo Yii::app()->createUrl('stock/productstock/') ?>">Material Stock Overview</a></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<?php
		$this->widget('zii.widgets.grid.CGridView',
			array(
			'dataProvider' => $dataProvider,
			'id' => 'ProductStockList',
			'selectableRows' => 2,
			'ajaxUpdate' => true,
			'filter' => null,
			'enableSorting' => true,
			'columns' => array(
				array(
					'header' => getCatalog('productstockid'),
					'name' => 'productstockid',
					'value' => '$data["productstockid"]'
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
					'header' => getCatalog('storagedesc'),
					'name' => 'storagebinid',
					'value' => '$data["storagedesc"]'
				),
				array(
					'header' => getCatalog('qty'),
					'name' => 'qty',
					'value' => 'Yii::app()->format->formatNumber($data["qty"])'
				),
				array(
					'header' => getCatalog('qtyinprogress'),
					'name' => 'qtyinprogress',
					'value' => 'Yii::app()->format->formatNumber($data["qtyinprogress"])'
				),
				array(
					'header' => getCatalog('uomcode'),
					'name' => 'unitofmeasureid',
					'value' => '$data["uomcode"]'
				),
			)
		));
		?>	</div><!-- /.box-body -->
</div><!-- /.box -->