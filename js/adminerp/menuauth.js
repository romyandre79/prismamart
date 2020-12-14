if ("undefined" === typeof jQuery)
	throw new Error("Menu Auth's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'menuauth/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='menuauthid']").val(data.menuauthid);
				$("input[name='actiontype']").val(0);
				$("input[name='menuobject']").val('');
				$("input[name='recordstatus']").prop('checked', true);
				$.fn.yiiGridView.update('groupmenuauthList', {data: {'menuauthid': data.menuauthid}});
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function newdatagroupmenuauth() {
	jQuery.ajax({'url': 'menuauth/creategroupmenuauth', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='groupmenuauthid']").val('');
				$("input[name='groupaccessid']").val('');
				$("input[name='menuvalueid']").val('');
				$("input[name='groupname']").val('');
				$('#InputDialoggroupmenuauth').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedata($id) {
	jQuery.ajax({'url': 'menuauth/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='menuauthid']").val(data.menuauthid);
				$("input[name='actiontype']").val(1);
				$("input[name='menuobject']").val(data.menuobject);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false)
				}
				$.fn.yiiGridView.update('groupmenuauthList', {data: {'menuauthid': data.menuauthid}});

				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedatagroupmenuauth($id) {
	jQuery.ajax({'url': 'menuauth/updategroupmenuauth', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='groupmenuauthid']").val(data.groupmenuauthid);
				$("input[name='groupaccessid']").val(data.groupaccessid);
				$("input[name='menuvalueid']").val(data.menuvalueid);
				$("input[name='groupname']").val(data.groupname);
				$('#InputDialoggroupmenuauth').modal();
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
	jQuery.ajax({'url': 'menuauth/save',
		'data': {
			'actiontype': $("input[name='actiontype']").val(),
			'menuauthid': $("input[name='menuauthid']").val(),
			'menuobject': $("input[name='menuobject']").val(),
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
function savedatagroupmenuauth() {
	jQuery.ajax({'url': 'menuauth/savegroupmenuauth',
		'data': {
			'menuauthid': $("input[name='menuauthid']").val(),
			'groupmenuauthid': $("input[name='groupmenuauthid']").val(),
			'groupaccessid': $("input[name='groupaccessid']").val(),
			'menuvalueid': $("input[name='menuvalueid']").val()
		},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$('#InputDialoggroupmenuauth').modal('hide');
				toastr.info(data.msg);
				$.fn.yiiGridView.update("groupmenuauthList");
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
}
function deletedata($id) {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'menuauth/delete',
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
		jQuery.ajax({'url': 'menuauth/purge', 'data': {'id': $id},
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
function purgedatagroupmenuauth() {
	$.msg.confirmation('Confirm', 'Apakah Anda Yakin ?', function () {
		jQuery.ajax({'url': 'menuauth/purgegroupmenuauth', 'data': {'id': $.fn.yiiGridView.getSelection("groupmenuauthList")},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status === "success") {
					toastr.info(data.msg);
					$.fn.yiiGridView.update("groupmenuauthList");
				} else {
					toastr.error(data.msg);
				}
			},
			'cache': false});
	});
	return false;
}
function searchdata($id = 0) {
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList", {data: {
			'menuauthid': $id,
			'menuobject': $("input[name='dlg_search_menuobject']").val()
		}});
	return false;
}
function downpdf($id = 0) {
	var array = 'menuauthid=' + $id
		+ '&menuobject=' + $("input[name='dlg_search_menuobject']").val();
	window.open('menuauth/downpdf?' + array);
}
function GetDetail($id) {
	$('#ShowDetailDialog').modal('show');
	var array = 'menuauthid=' + $id
	$.fn.yiiGridView.update("DetailgroupmenuauthList", {data: array});
}