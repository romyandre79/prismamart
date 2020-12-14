if ("undefined" === typeof jQuery)
	throw new Error("Sloc's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'sloc/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='slocid']").val(data.slocid);
				$("input[name='actiontype']").val(0);
				$("input[name='plantid']").val('');
				$("input[name='sloccode']").val('');
				$("input[name='description']").val('');
				$("input[name='recordstatus']").prop('checked', true);
				$("input[name='plantcode']").val('');
				$.fn.yiiGridView.update('storagebinList', {data: {'slocid': data.slocid}});
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function newdatastoragebin() {
	jQuery.ajax({'url': 'sloc/createstoragebin', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='storagebinid']").val('');
				$("input[name='descsbin']").val('');
				$("input[name='ismultiproduct']").prop('checked', true);
				$("input[name='qtymax']").val(data.qtymax);
				$("input[name='recordstatus']").prop('checked', true);
				$('#InputDialogstoragebin').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedata($id) {
	jQuery.ajax({'url': 'sloc/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='slocid']").val(data.slocid);
				$("input[name='actiontype']").val(1);
				$("input[name='plantid']").val(data.plantid);
				$("input[name='sloccode']").val(data.sloccode);
				$("input[name='description']").val(data.description);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false);
				}
				$("input[name='plantcode']").val(data.plantcode);
				$.fn.yiiGridView.update('storagebinList', {data: {'slocid': data.slocid}});

				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedatastoragebin($id) {
	jQuery.ajax({'url': 'sloc/updatestoragebin', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='storagebinid']").val(data.storagebinid);
				$("input[name='descsbin']").val(data.description);
				if (data.ismultiproduct === "1") {
					$("input[name='ismultiproduct']").prop('checked', true);
				} else {
					$("input[name='ismultiproduct']").prop('checked', false);
				}
				$("input[name='qtymax']").val(data.qtymax);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false);
				}
				$('#InputDialogstoragebin').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}

function savedata() {
	var recordstatus = 0;
	if ($("input[name='recordstatus']").prop('checked')) {
		recordstatus = 1;
	} else {
		recordstatus = 0;
	}
	jQuery.ajax({'url': 'sloc/save',
		'data': {
			'actiontype': $("input[name='actiontype']").val(),
			'slocid': $("input[name='slocid']").val(),
			'plantid': $("input[name='plantid']").val(),
			'sloccode': $("input[name='sloccode']").val(),
			'description': $("input[name='description']").val(),
			'recordstatus': recordstatus
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
function savedatastoragebin() {
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
	jQuery.ajax({'url': 'sloc/savestoragebin',
		'data': {
			'slocid': $("input[name='slocid']").val(),
			'storagebinid': $("input[name='storagebinid']").val(),
			'description': $("input[name='descsbin']").val(),
			'ismultiproduct': ismultiproduct,
			'qtymax': $("input[name='qtymax']").val(),
			'recordstatus': recordstatus
		},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$('#InputDialogstoragebin').modal('hide');
				toastr.info(data.msg);
				$.fn.yiiGridView.update("storagebinList");
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
}
function deletedata($id) {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'sloc/delete',
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
		jQuery.ajax({'url': 'sloc/purge', 'data': {'id': $id},
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
function purgedatastoragebin() {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'sloc/purgestoragebin', 'data': {'id': $.fn.yiiGridView.getSelection("storagebinList")},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status === "success") {
					toastr.info(data.msg);
					$.fn.yiiGridView.update("storagebinList");
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
	var array = 'slocid=' + $id
		+ '&plantcode=' + $("input[name='dlg_search_plantcode']").val()
		+ '&sloccode=' + $("input[name='dlg_search_sloccode']").val()
		+ '&description=' + $("input[name='dlg_search_description']").val();
	$.fn.yiiGridView.update("GridList", {data: array});
	return false;
}
function downpdf($id = 0) {
	var array = 'slocid=' + $id
		+ '&plantcode=' + $("input[name='dlg_search_plantcode']").val()
		+ '&sloccode=' + $("input[name='dlg_search_sloccode']").val()
		+ '&description=' + $("input[name='dlg_search_description']").val();
	window.open('sloc/downpdf?' + array);
}
function GetDetail($id) {
	$('#ShowDetailDialog').modal('show');
	var array = 'slocid=' + $id;
	$.fn.yiiGridView.update("DetailstoragebinList", {data: array});
}