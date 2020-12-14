<script type="text/javascript">
	function downpdfrepsales() {
		var array = 'lro=' + $("select[name='listrepsales']").val()
			+ '&company=' + $("input[name='companyid']").val()
			+ '&sloc=' + $("input[name='slocid']").val()
			+ '&product=' + $("input[name='productid']").val()
			+ '&startdate=' + $("input[name='startdate']").val()
			+ '&qty=' + $("input[name='qty']").val()
			+ '&enddate=' + $("input[name='enddate']").val();
		window.open('<?php echo Yii::app()->createUrl('stock/reportstock/downpdf') ?>?' + array);
	}
	;
	$(function () {
		$("input[name='startdate']").val('<?php echo date('Y-m') ?>-01');
		$("input[name='enddate']").val('<?php echo date('Y-m-d') ?>');
	});
</script>
<?php if (CheckAccess($this->menuname, 'isdownload')) { ?>
	<div class="btn-group">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
			<?php echo getCatalog('download') ?> <span class="caret"></span></button>
		<ul class="dropdown-menu" role="menu">
			<li><a onclick="downpdfrepsales()"><?php echo getCatalog('downpdf') ?></a></li>
		</ul>
	</div>
<?php } ?>

<h3><?php echo getCatalog('reportwrh') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listrepsales"><?php echo getCatalog('reporttype') ?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listrepsales" >
			<option value="0">Rincian Histori Barang</option>
			<option value="1">Rekap Histori Barang</option>
			<option value="2">Kartu Stok Barang</option>
			<option value="3">Rekap Stok Barang</option>
			<option value="4">Pendingan FPB</option>
			<option value="5">Pendingan FPP</option>
			<option value="6">Dokumen Stock Opname Belum Status Max</option>
			<option value="7">Dokumen FPB Belum Status Max</option>
			<option value="8">Laporan Ketersediaan Barang</option>
			<option value="9">Laporan Material Not Moving</option>
			<option value="10">Laporan Material Slow Moving</option>
			<option value="11">Laporan Material Fast Moving</option>
		</select>
	</div>
</div>
<?php
$this->widget('DataPopUp',
	array('id' => 'Widget', 'IDField' => 'companyid', 'ColField' => 'companyname',
	'IDDialog' => 'company_dialog', 'titledialog' => getCatalog('company'), 'classtype' => 'col-md-4',
	'classtypebox' => 'col-md-8',
	'PopUpName' => 'admin.components.views.CompanyPopUp', 'PopGrid' => 'companyidgrid'));
?>
<?php
$this->widget('DataPopUp',
	array('id' => 'Widget', 'IDField' => 'slocid', 'ColField' => 'sloccode',
	'IDDialog' => 'slocid_dialog', 'titledialog' => getCatalog('sloc'), 'classtype' => 'col-md-4',
	'classtypebox' => 'col-md-8',
	'PopUpName' => 'common.components.views.SlocPopUp', 'PopGrid' => 'slocidgrid'));
?>
<?php
$this->widget('DataPopUp',
	array('id' => 'Widget', 'IDField' => 'productid', 'ColField' => 'productname',
	'IDDialog' => 'product_dialog', 'titledialog' => getCatalog('product'), 'classtype' => 'col-md-4',
	'classtypebox' => 'col-md-8',
	'PopUpName' => 'common.components.views.ProductPopUp', 'PopGrid' => 'productgrid'));
?>
<div class="row">
	<div class="col-md-4">
		<label for="qty"><?php echo getCatalog('qty') ?></label>
	</div>
	<div class="col-md-8">
		<input name="qty" class="form-control" type="number">
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<label for="startdate"><?php echo getCatalog('date') ?></label>
	</div>
	<div class="col-md-8">
		<input name="startdate" class="form-control" type="date">-<input name="enddate" class="form-control" type="date" >
	</div>
</div>