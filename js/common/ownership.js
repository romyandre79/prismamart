if ("undefined" === typeof jQuery)
	throw new Error("Ownership's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'ownership/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
      if (data.status === "success") {
			$("input[name='ownershipid']").val('');
			$("input[name='ownershipname']").val('');
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
	jQuery.ajax({'url': 'ownership/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
      if (data.status === "success") {
			$("input[name='ownershipid']").val(data.ownershipid);
			$("input[name='ownershipname']").val(data.ownershipname);
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
	jQuery.ajax({'url': 'ownership/save',
		'data': {
			'ownershipid': $("input[name='ownershipid']").val(),
			'ownershipname': $("input[name='ownershipname']").val(),
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
function deletedata() {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'ownership/delete',
			'data': {'id': $.fn.yiiGridView.getSelection("GridList")},
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
function purgedata() {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'ownership/purge', 'data': {'id': $.fn.yiiGridView.getSelection("GridList")},
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
			'ownershipid': $id,
			'ownershipname': $("input[name='dlg_search_ownershipname']").val()
		}});
	return false;
}
function downpdf() {
	var array = 'ownershipname=' + $("input[name='dlg_search_ownershipname']").val();
	window.open('ownership/downpdf?' + array);
}