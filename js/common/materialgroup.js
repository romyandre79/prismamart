if ("undefined" === typeof jQuery)
	throw new Error("Material Group's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'materialgroup/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='materialgroupid']").val(data.materialgroupid);
				$("input[name='materialgroupcode']").val('');
				$("input[name='description']").val('');
				$("input[name='materialtypeid']").val('');
				$("input[name='recordstatus']").prop('checked', true);
				$("input[name='materialtypecode']").val('');
				$("input[name='slug']").val('');
				$("input[name='materialgrouppic']").val('');
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedata($id) {
	jQuery.ajax({'url': 'materialgroup/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='materialgroupid']").val(data.materialgroupid);
				$("input[name='materialgroupcode']").val(data.materialgroupcode);
				$("input[name='description']").val(data.description);
				$("input[name='materialtypeid']").val(data.materialtypeid);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false);
				}
				$("input[name='materialtypecode']").val(data.materialtypecode);
				$("input[name='slug']").val(data.slug);
				$("input[name='materialgrouppic']").val(data.materialgrouppic);
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
	jQuery.ajax({'url': 'materialgroup/save',
		'data': {
			'materialgroupid': $("input[name='materialgroupid']").val(),
			'materialgroupcode': $("input[name='materialgroupcode']").val(),
			'description': $("input[name='description']").val(),
			'materialtypeid': $("input[name='materialtypeid']").val(),
			'slug': $("input[name='slug']").val(),
			'materialgrouppic': $("input[name='materialgrouppic']").val(),
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
		jQuery.ajax({'url': 'materialgroup/delete',
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
		jQuery.ajax({'url': 'materialgroup/purge', 'data': {'id': $id},
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
			'materialgroupid': $id,
			'materialgroupcode': $("input[name='dlg_search_materialgroupcode']").val(),
			'description': $("input[name='dlg_search_description']").val(),
			'materialtypecode': $("input[name='dlg_search_materialtypecode']").val()
		}});
	return false;
}
function downpdf($id = 0) {
	var array = 'materialgroupid=' + $id
		+ '&materialgroupcode=' + $("input[name='dlg_search_materialgroupcode']").val()
		+ '&description=' + $("input[name='dlg_search_description']").val()
		+ '&materialtypecode=' + $("input[name='dlg_search_materialtypecode']").val();
	window.open('materialgroup/downpdf?' + array);
}