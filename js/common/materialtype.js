if ("undefined" === typeof jQuery)
	throw new Error("Material Type's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'materialtype/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='materialtypeid']").val(data.materialtypeid);
				$("input[name='materialtypecode']").val('');
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
	jQuery.ajax({'url': 'materialtype/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='materialtypeid']").val(data.materialtypeid);
				$("input[name='materialtypecode']").val(data.materialtypecode);
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
	jQuery.ajax({'url': 'materialtype/save',
		'data': {
			'materialtypeid': $("input[name='materialtypeid']").val(),
			'materialtypecode': $("input[name='materialtypecode']").val(),
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
		jQuery.ajax({'url': 'materialtype/delete',
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
		jQuery.ajax({'url': 'materialtype/purge', 'data': {'id': $id},
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
			'materialtypeid': $id,
			'materialtypecode': $("input[name='dlg_search_materialtypecode']").val(),
			'description': $("input[name='dlg_search_description']").val()
		}});
	return false;
}
function downpdf($id = 0) {
	var array = 'materialtypeid=' + $id
		+ '&materialtypecode=' + $("input[name='dlg_search_materialtypecode']").val()
		+ '&description=' + $("input[name='dlg_search_description']").val();
	window.open('materialtype/downpdf?' + array);
}