if ("undefined" === typeof jQuery)
	throw new Error("Tax's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'tax/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='taxid']").val(data.taxid);
				$("input[name='taxcode']").val('');
				$("input[name='taxvalue']").val(data.taxvalue);
				$("input[name='description']").val('');
				$("input[name='recordstatus']").prop('checked', true);
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedata($id) {
	jQuery.ajax({'url': 'tax/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='taxid']").val(data.taxid);
				$("input[name='taxcode']").val(data.taxcode);
				$("input[name='taxvalue']").val(data.taxvalue);
				$("input[name='description']").val(data.description);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false);
				}
				$('#InputDialog').modal();
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
	jQuery.ajax({'url': 'tax/save',
		'data': {
			'taxid': $("input[name='taxid']").val(),
			'taxcode': $("input[name='taxcode']").val(),
			'taxvalue': $("input[name='taxvalue']").val(),
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
function deletedata($id) {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'tax/delete',
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
		jQuery.ajax({'url': 'tax/purge', 'data': {'id': $id},
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
			'taxid': $id,
			'taxcode': $("input[name='dlg_search_taxcode']").val(),
			'description': $("input[name='dlg_search_description']").val()
		}});
	return false;
}
function downpdf($id = 0) {
	var array = 'taxid=' + $id
		+ '&taxcode=' + $("input[name='dlg_search_taxcode']").val()
		+ '&description=' + $("input[name='dlg_search_description']").val();
	window.open('tax/downpdf?' + array);
}