if ("undefined" === typeof jQuery)
	throw new Error("Payment Method's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'paymentmethod/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='paymentmethodid']").val(data.paymentmethodid);
				$("input[name='paycode']").val('');
				$("input[name='paydays']").val('');
				$("input[name='paymentname']").val('');
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
	jQuery.ajax({'url': 'paymentmethod/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='paymentmethodid']").val(data.paymentmethodid);
				$("input[name='paycode']").val(data.paycode);
				$("input[name='paydays']").val(data.paydays);
				$("input[name='paymentname']").val(data.paymentname);
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
	jQuery.ajax({'url': 'paymentmethod/save',
		'data': {
			'paymentmethodid': $("input[name='paymentmethodid']").val(),
			'paycode': $("input[name='paycode']").val(),
			'paydays': $("input[name='paydays']").val(),
			'paymentname': $("input[name='paymentname']").val(),
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
		jQuery.ajax({'url': 'paymentmethod/delete',
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
		jQuery.ajax({'url': 'paymentmethod/purge', 'data': {'id': $id},
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
			'paymentmethodid': $id,
			'paycode': $("input[name='dlg_search_paycode']").val(),
			'paymentname': $("input[name='dlg_search_paymentname']").val()
		}});
	return false;
}
function downpdf($id = 0) {
	var array = 'paymentmethodid=' + $id
		+ '&paycode=' + $("input[name='dlg_search_paycode']").val()
		+ '&paymentname=' + $("input[name='dlg_search_paymentname']").val();
	window.open('paymentmethod/downpdf?' + array);
}