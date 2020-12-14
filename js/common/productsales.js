if ("undefined" === typeof jQuery)
	throw new Error("Product Sales's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'productsales/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='productsalesid']").val(data.productsalesid);
				$("input[name='productid']").val('');
				$("input[name='currencyid']").val(data.currencyid);
				$("input[name='currencyvalue']").val(data.currencyvalue);
				$("input[name='pricecategoryid']").val('');
				$("input[name='uomid']").val('');
				$("input[name='productname']").val('');
				$("input[name='currencyname']").val(data.currencyname);
				$("input[name='categoryname']").val('');
				$("input[name='uomcode']").val('');
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}

function updatedata($id) {
	jQuery.ajax({'url': 'productsales/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='productsalesid']").val(data.productsalesid);
				$("input[name='productid']").val(data.productid);
				$("input[name='currencyid']").val(data.currencyid);
				$("input[name='currencyvalue']").val(data.currencyvalue);
				$("input[name='pricecategoryid']").val(data.pricecategoryid);
				$("input[name='uomid']").val(data.uomid);
				$("input[name='productname']").val(data.productname);
				$("input[name='currencyname']").val(data.currencyname);
				$("input[name='categoryname']").val(data.categoryname);
				$("input[name='uomcode']").val(data.uomcode);
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}

function savedata() {
	jQuery.ajax({'url': 'productsales/save',
		'data': {
			'productsalesid': $("input[name='productsalesid']").val(),
			'productid': $("input[name='productid']").val(),
			'currencyid': $("input[name='currencyid']").val(),
			'currencyvalue': $("input[name='currencyvalue']").val(),
			'pricecategoryid': $("input[name='pricecategoryid']").val(),
			'uomid': $("input[name='uomid']").val(),
		},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$('#InputDialog').modal('hide');
				toastr.info(data.msg);
				$.fn.yiiGridView.update("GridList");
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
}

function deletedata($id) {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'productsales/delete',
			'data': {'id': $id},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status === "success") {
					toastr.info(data.msg);
					$.fn.yiiGridView.update("GridList");
				} else {
					toastr.error(data.msg);
				}
			},
			'cache': false});
	};
	return false;
}

function purgedata($id) {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'productsales/purge', 'data': {'id': $id},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status === "success") {
					toastr.info(data.msg);
					$.fn.yiiGridView.update("GridList");
				} else {
					toastr.error(data.msg);
				}
			},
			'cache': false});
	};
	return false;
}

function searchdata($id = 0) {
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList", {data: {
			'productsalesid': $id,
			'productname': $("input[name='dlg_search_productname']").val(),
			'currencyname': $("input[name='dlg_search_currencyname']").val(),
			'categoryname': $("input[name='dlg_search_categoryname']").val(),
			'uomcode': $("input[name='dlg_search_uomcode']").val()
		}});
	return false;
}

function downpdf($id = 0) {
	var array = 'productsalesid=' + $id
		+ '&productname=' + $("input[name='dlg_search_productname']").val()
		+ '&currencyname=' + $("input[name='dlg_search_currencyname']").val()
		+ '&categoryname=' + $("input[name='dlg_search_categoryname']").val()
		+ '&uomcode=' + $("input[name='dlg_search_uomcode']").val();
	window.open('productsales/downpdf?' + array);
}
