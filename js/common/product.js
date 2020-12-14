if ("undefined" === typeof jQuery)
	throw new Error("Product's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'product/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='productid']").val(data.productid);
				$("input[name='actiontype']").val(0);
				$("input[name='productcode']").val('');
				$("input[name='productname']").val('');
				$("input[name='productpic']").val(data.productpic);
				$("input[name='isstock']").prop('checked', true);
        $("input[name='barcode']").val('');
				$("input[name='unitofissue']").val('');
        $("input[name='uomcode']").val('');
				$("input[name='materialgroupid']").val('');
				$("input[name='materialgroupcode']").val('');
				$("input[name='sled']").val('30');
				$("input[name='isautolot']").prop('checked', true);
				$("input[name='recordstatus']").prop('checked', true);
				$.fn.yiiGridView.update('productplantList', {data: {'productid': data.productid}});
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function newdataproductplant() {
	jQuery.ajax({'url': 'product/createproductplant', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='productplantid']").val('');
				$("input[name='slocid']").val('');
				$("input[name='snroid']").val('');
				$("input[name='issource']").prop('checked', true);
				$("input[name='recordstatus']").prop('checked', true);
				$("input[name='sloccode']").val('');
				$("input[name='snrodesc']").val('');
				$('#InputDialogproductplant').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedata($id) {
	jQuery.ajax({'url': 'product/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='productid']").val(data.productid);
				$("input[name='actiontype']").val(1);
				$("input[name='productcode']").val(data.productcode);
				$("input[name='productname']").val(data.productname);
				$("input[name='productpic']").val(data.productpic);
				if (data.isstock === "1") {
					$("input[name='isstock']").prop('checked', true);
				} else {
					$("input[name='isstock']").prop('checked', false);
				}
				$("input[name='barcode']").val(data.barcode);
				$("input[name='sled']").val(data.sled);
				$("input[name='unitofissue']").val(data.unitofissue);
				$("input[name='uomcode']").val(data.uomcode);
				$("input[name='materialgroupid']").val(data.materialgroupid);
				$("input[name='materialgroupcode']").val(data.materialgroupcode);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false);
				}
				if (data.isautolot === "1") {
					$("input[name='isautolot']").prop('checked', true);
				} else {
					$("input[name='isautolot']").prop('checked', false);
				}
				$.fn.yiiGridView.update('productplantList', {data: {'productid': data.productid}});
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedataproductplant($id) {
	jQuery.ajax({'url': 'product/updateproductplant', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='productplantid']").val(data.productplantid);
				$("input[name='slocid']").val(data.slocid);
				if (data.issource === "1") {
					$("input[name='issource']").prop('checked', true);
				} else {
					$("input[name='issource']").prop('checked', false);
				}
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false);
				}
				$("input[name='sloccode']").val(data.sloccode);
				$("input[name='snrodesc']").val(data.snrodesc);
				$('#InputDialogproductplant').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function savedata() {
	var isstock = 0;
	if ($("input[name='isstock']").prop('checked')) {
		isstock = 1;
	} else {
		isstock = 0;
	}
	var recordstatus = 0;
	if ($("input[name='recordstatus']").prop('checked')) {
		recordstatus = 1;
	} else {
		recordstatus = 0;
	}
	var isautolot = 0;
	if ($("input[name='isautolot']").prop('checked')) {
		isautolot = 1;
	} else {
		isautolot = 0;
	}
	jQuery.ajax({'url': 'product/save',
		'data': {
			'actiontype': $("input[name='actiontype']").val(),
			'productid': $("input[name='productid']").val(),
			'productcode': $("input[name='productcode']").val(),
			'productname': $("input[name='productname']").val(),
			'productpic': $("input[name='productpic']").val(),
			'isstock': isstock,
			'barcode': $("input[name='barcode']").val(),
			'unitofissue': $("input[name='unitofissue']").val(),
			'sled': $("input[name='sled']").val(),
			'materialgroupid': $("input[name='materialgroupid']").val(),
			'recordstatus': recordstatus,
			'isautolot': isautolot
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
function savedataproductplant() {
	var issource = 0;
	if ($("input[name='issource']").prop('checked')) {
		issource = 1;
	} else {
		issource = 0;
	}
	var recordstatus = 0;
	if ($("input[name='recordstatus']").prop('checked')) {
		recordstatus = 1;
	} else {
		recordstatus = 0;
	}
	jQuery.ajax({'url': 'product/saveproductplant',
		'data': {
			'productid': $("input[name='productid']").val(),
			'productplantid': $("input[name='productplantid']").val(),
			'slocid': $("input[name='slocid']").val(),
			'snroid': $("input[name='snroid']").val(),
			'issource': issource,
			'recordstatus': recordstatus
		},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$('#InputDialogproductplant').modal('hide');
				toastr.info(data.msg);
				$.fn.yiiGridView.update("productplantList");
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
}
function deletedata($id) {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'product/delete',
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
		jQuery.ajax({'url': 'product/purge', 'data': {'id': $id},
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
function purgedataproductplant() {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'product/purgeproductplant', 'data': {'id': $.fn.yiiGridView.getSelection("productplantList")},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status === "success") {
					toastr.info(data.msg);
					$.fn.yiiGridView.update("productplantList");
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
			'productid': $id,
			'productname': $("input[name='dlg_search_productname']").val(),
			'productcode': $("input[name='dlg_search_productcode']").val(),
			'barcode': $("input[name='dlg_search_barcode']").val()
		}});
	return false;
}
function downpdf($id = 0) {
	var array = 'productid=' + $id
		+ '&productname=' + $("input[name='dlg_search_productname']").val()
		+ '&productcode=' + $("input[name='dlg_search_productcode']").val()
		+ '&barcode=' + $("input[name='dlg_search_barcode']").val();
	window.open('product/downpdf?' + array);
}
function GetDetail($id) {
	$('#ShowDetailDialog').modal('show');
	var array = 'productid=' + $id;
	$.fn.yiiGridView.update("DetailproductplantList", {data: array});
}