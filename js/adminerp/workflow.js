if ("undefined" === typeof jQuery)
	throw new Error("Workflow's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'workflow/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='workflowid']").val(data.workflowid);
				$("input[name='actiontype']").val(0);
				$("input[name='wfname']").val('');
				$("input[name='wfdesc']").val('');
				$("input[name='wfminstat']").val('');
				$("input[name='wfmaxstat']").val('');
				$("input[name='recordstatus']").prop('checked', true);
				$.fn.yiiGridView.update('wfgroupList', {data: {'workflowid': data.workflowid}});
				$.fn.yiiGridView.update('wfstatusList', {data: {'workflowid': data.workflowid}});
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function newdatawfgroup() {
	jQuery.ajax({'url': 'workflow/createwfgroup', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='wfgroupid']").val('');
				$("input[name='groupaccessid']").val('');
				$("input[name='wfbefstat']").val('');
				$("input[name='wfrecstat']").val('');
				$("input[name='groupname']").val('');
				$('#InputDialogwfgroup').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function newdatawfstatus() {
	jQuery.ajax({'url': 'workflow/createwfstatus', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='wfstatusid']").val('');
				$("input[name='wfstat']").val('');
				$("input[name='wfstatusname']").val('');
				$('#InputDialogwfstatus').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedata($id) {
	jQuery.ajax({'url': 'workflow/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='workflowid']").val(data.workflowid);
				$("input[name='actiontype']").val(1);
				$("input[name='wfname']").val(data.wfname);
				$("input[name='wfdesc']").val(data.wfdesc);
				$("input[name='wfminstat']").val(data.wfminstat);
				$("input[name='wfmaxstat']").val(data.wfmaxstat);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false);
				}
				$.fn.yiiGridView.update('wfgroupList', {data: {'workflowid': data.workflowid}});
				$.fn.yiiGridView.update('wfstatusList', {data: {'workflowid': data.workflowid}});
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedatawfgroup($id) {
	jQuery.ajax({'url': 'workflow/updatewfgroup', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='wfgroupid']").val(data.wfgroupid);
				$("input[name='groupaccessid']").val(data.groupaccessid);
				$("input[name='wfbefstat']").val(data.wfbefstat);
				$("input[name='wfrecstat']").val(data.wfrecstat);
				$("input[name='groupname']").val(data.groupname);
				$('#InputDialogwfgroup').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedatawfstatus($id) {
	jQuery.ajax({'url': 'workflow/updatewfstatus', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='wfstatusid']").val(data.wfstatusid);
				$("input[name='wfstat']").val(data.wfstat);
				$("input[name='wfstatusname']").val(data.wfstatusname);
				$('#InputDialogwfstatus').modal();
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
	jQuery.ajax({'url': 'workflow/save',
		'data': {
			'actiontype': $("input[name='actiontype']").val(),
			'workflowid': $("input[name='workflowid']").val(),
			'wfname': $("input[name='wfname']").val(),
			'wfdesc': $("input[name='wfdesc']").val(),
			'wfminstat': $("input[name='wfminstat']").val(),
			'wfmaxstat': $("input[name='wfmaxstat']").val(),
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
function savedatawfgroup() {
	jQuery.ajax({'url': 'workflow/savewfgroup',
		'data': {
			'workflowid': $("input[name='workflowid']").val(),
			'wfgroupid': $("input[name='wfgroupid']").val(),
			'groupaccessid': $("input[name='groupaccessid']").val(),
			'wfbefstat': $("input[name='wfbefstat']").val(),
			'wfrecstat': $("input[name='wfrecstat']").val()
		},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$('#InputDialogwfgroup').modal('hide');
				toastr.info(data.msg);
				$.fn.yiiGridView.update("wfgroupList");
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
}
function savedatawfstatus() {
	jQuery.ajax({'url': 'workflow/savewfstatus',
		'data': {
			'workflowid': $("input[name='workflowid']").val(),
			'wfstatusid': $("input[name='wfstatusid']").val(),
			'wfstat': $("input[name='wfstat']").val(),
			'wfstatusname': $("input[name='wfstatusname']").val()
		},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$('#InputDialogwfstatus').modal('hide');
				toastr.info(data.msg);
				$.fn.yiiGridView.update("wfstatusList");
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
}
function deletedata($id) {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'workflow/delete',
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
		jQuery.ajax({'url': 'workflow/purge', 'data': {'id': $id},
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
function purgedatawfgroup() {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'workflow/purgewfgroup', 'data': {'id': $.fn.yiiGridView.getSelection("wfgroupList")},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status === "success") {
					toastr.info(data.msg);
					$.fn.yiiGridView.update("wfgroupList");
				} else {
					toastr.error(data.msg);
				}
			},
			'cache': false});
	};
	return false;
}
function purgedatawfstatus() {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'workflow/purgewfstatus', 'data': {'id': $.fn.yiiGridView.getSelection("wfstatusList")},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status === "success") {
					toastr.info(data.msg);
					$.fn.yiiGridView.update("wfstatusList");
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
			'workflowid': $id,
			'wfname': $("input[name='dlg_search_wfname']").val(),
			'wfdesc': $("input[name='dlg_search_wfdesc']").val()
		}});
	return false;
}
function downpdf($id = 0) {
	var array = 'workflowid=' + $id
		+ '&wfname=' + $("input[name='dlg_search_wfname']").val()
		+ '&wfdesc=' + $("input[name='dlg_search_wfdesc']").val();
	window.open('workflow/downpdf?' + array);
}
function GetDetail($id) {
	$('#ShowDetailDialog').modal('show');
	var array = 'workflowid=' + $id;
	$.fn.yiiGridView.update("DetailwfgroupList", {data: array});
	$.fn.yiiGridView.update("DetailwfstatusList", {data: array});
}