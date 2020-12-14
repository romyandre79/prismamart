if ("undefined" === typeof jQuery)
	throw new Error("Language's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'storagebin/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='storagebinid']").val(data.storagebinid);
				$("input[name='slocid']").val('');
				$("input[name='description']").val('');
				$("input[name='ismultiproduct']").prop('checked', true);
				$("input[name='qtymax']").val(data.qtymax);
				$("input[name='recordstatus']").prop('checked', true);
				$("input[name='sloccode']").val('');
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}

function updatedata($id) {
	jQuery.ajax({'url': 'storagebin/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='storagebinid']").val(data.storagebinid);
				$("input[name='slocid']").val(data.slocid);
				$("input[name='description']").val(data.description);
				if (data.ismultiproduct == 1) {
					$("input[name='ismultiproduct']").prop('checked', true);
				} else {
					$("input[name='ismultiproduct']").prop('checked', false)
				}
				$("input[name='qtymax']").val(data.qtymax);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false)
				}
				$("input[name='sloccode']").val(data.sloccode);
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}

function savedata() {
	var ismultiproduct = 0;
	if ($("input[name='ismultiproduct']").prop('checked')) {
		ismultiproduct = 1;
	} else {
		ismultiproduct = 0;
	}
	var recordstatus = 0;
	if ($("input[name='recordstatus']").prop('checked')) {
		recordstatus = 1;
	} else {
		recordstatus = 0;
	}
	jQuery.ajax({'url': 'storagebin/save',
		'data': {
			'storagebinid': $("input[name='storagebinid']").val(),
			'slocid': $("input[name='slocid']").val(),
			'description': $("input[name='description']").val(),
			'ismultiproduct': ismultiproduct,
			'qtymax': $("input[name='qtymax']").val(),
			'recordstatus': recordstatus,
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
		jQuery.ajax({'url': 'storagebin/delete',
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
		jQuery.ajax({'url': 'storagebin/purge', 'data': {'id': $id},
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
			'storagebinid': $id,
			'sloccode': $("input[name='dlg_search_sloccode']").val(),
			'description': $("input[name='dlg_search_description']").val()
		}});
	return false;
}

function downpdf($id = 0) {
	var array = 'storagebinid=' + $id
		+ '&sloccode=' + $("input[name='dlg_search_sloccode']").val()
		+ '&description=' + $("input[name='dlg_search_description']").val();
	window.open('storagebin/downpdf?' + array);
}
