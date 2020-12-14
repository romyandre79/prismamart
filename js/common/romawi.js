if ("undefined" === typeof jQuery)
	throw new Error("Romawi's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'romawi/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='romawiid']").val(data.romawiid);

				$("input[name='monthcal']").val('');
				$("input[name='monthrm']").val('');
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
	jQuery.ajax({'url': 'romawi/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='romawiid']").val(data.romawiid);

				$("input[name='monthcal']").val(data.monthcal);
				$("input[name='monthrm']").val(data.monthrm);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false)
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
	jQuery.ajax({'url': 'romawi/save',
		'data': {
			'romawiid': $("input[name='romawiid']").val(),
			'monthcal': $("input[name='monthcal']").val(),
			'monthrm': $("input[name='monthrm']").val(),
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
		jQuery.ajax({'url': 'romawi/delete',
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
		jQuery.ajax({'url': 'romawi/purge', 'data': {'id': $id},
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
			'romawiid': $id,
			'monthrm': $("input[name='dlg_search_monthrm']").val(),
			'monthcal': $("input[name='dlg_search_monthcal']").val()
		}});
	return false;
}

function downpdf($id = 0) {
	var array = 'romawiid=' + $id
		+ '&monthrm=' + $("input[name='dlg_search_monthrm']").val();
	window.open('romawi/downpdf?' + array);
}