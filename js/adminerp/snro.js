if ("undefined" === typeof jQuery)
	throw new Error("SNRO's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'snro/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='snroid']").val(data.snroid);
				$("input[name='actiontype']").val(0);
				$("input[name='description']").val('');
				$("input[name='formatdoc']").val('');
				$("input[name='formatno']").val('');
				$("input[name='repeatby']").val('');
				$("input[name='recordstatus']").prop('checked', true);
				$.fn.yiiGridView.update('snrodetList', {data: {'snroid': data.snroid}});
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function newdatasnrodet() {
	jQuery.ajax({'url': 'snro/createsnrodet', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='snrodid']").val('');
				$("input[name='companyid']").val(data.companyid);
				$("input[name='curdd']").val('');
				$("input[name='curmm']").val('');
				$("input[name='curyy']").val('');
				$("input[name='curvalue']").val('');
				$("input[name='companyname']").val(data.companyname);
				$('#InputDialogsnrodet').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedata($id) {
	jQuery.ajax({'url': 'snro/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='snroid']").val(data.snroid);
				$("input[name='actiontype']").val(1);
				$("input[name='description']").val(data.description);
				$("input[name='formatdoc']").val(data.formatdoc);
				$("input[name='formatno']").val(data.formatno);
				$("input[name='repeatby']").val(data.repeatby);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false);
				}
				$.fn.yiiGridView.update('snrodetList', {data: {'snroid': data.snroid}});
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}
function updatedatasnrodet($id) {
	jQuery.ajax({'url': 'snro/updatesnrodet', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='snrodid']").val(data.snrodid);
				$("input[name='companyid']").val(data.companyid);
				$("input[name='curdd']").val(data.curdd);
				$("input[name='curmm']").val(data.curmm);
				$("input[name='curyy']").val(data.curyy);
				$("input[name='curvalue']").val(data.curvalue);
				$("input[name='companyname']").val(data.companyname);
				$('#InputDialogsnrodet').modal();
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
	jQuery.ajax({'url': 'snro/save',
		'data': {
			'actiontype': $("input[name='actiontype']").val(),
			'snroid': $("input[name='snroid']").val(),
			'description': $("input[name='description']").val(),
			'formatdoc': $("input[name='formatdoc']").val(),
			'formatno': $("input[name='formatno']").val(),
			'repeatby': $("input[name='repeatby']").val(),
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
function savedatasnrodet() {

	jQuery.ajax({'url': 'snro/savesnrodet',
		'data': {
			'snroid': $("input[name='snroid']").val(),
			'snrodid': $("input[name='snrodid']").val(),
			'companyid': $("input[name='companyid']").val(),
			'curdd': $("input[name='curdd']").val(),
			'curmm': $("input[name='curmm']").val(),
			'curyy': $("input[name='curyy']").val(),
			'curvalue': $("input[name='curvalue']").val()
		},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$('#InputDialogsnrodet').modal('hide');
				toastr.info(data.msg);
				$.fn.yiiGridView.update("snrodetList");
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
}
function deletedata($id) {
  if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'snro/delete',
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
		jQuery.ajax({'url': 'snro/purge', 'data': {'id': $id},
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
function purgedatasnrodet() {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'snro/purgesnrodet', 'data': {'id': $.fn.yiiGridView.getSelection("snrodetList")},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status === "success") {
					toastr.info(data.msg);
					$.fn.yiiGridView.update("snrodetList");
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
			'snroid': $id,
			'description': $("input[name='dlg_search_description']").val(),
			'formatdoc': $("input[name='dlg_search_formatdoc']").val(),
			'formatno': $("input[name='dlg_search_formatno']").val(),
			'repeatby': $("input[name='dlg_search_repeatby']").val()
		}});
	return false;
}
function downpdf($id = 0) {
	var array = 'snroid=' + $id
		+ '&description=' + $("input[name='dlg_search_description']").val()
		+ '&formatdoc=' + $("input[name='dlg_search_formatdoc']").val()
		+ '&formatno=' + $("input[name='dlg_search_formatno']").val()
		+ '&repeatby=' + $("input[name='dlg_search_repeatby']").val();
	window.open('snro/downpdf?' + array);
}
function GetDetail($id) {
	$('#ShowDetailDialog').modal('show');
	var array = 'snroid=' + $id;
	$.fn.yiiGridView.update("DetailsnrodetList", {data: array});
}