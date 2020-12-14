if ("undefined" === typeof jQuery)
	throw new Error("Plant's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'plant/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='plantid']").val(data.plantid);
				$("input[name='companyid']").val('');
				$("input[name='plantcode']").val('');
				$("input[name='description']").val('');
				$("textarea[name='plantaddress']").val('');
				$("input[name='lat']").val('');
				$("input[name='lng']").val('');
				$("input[name='recordstatus']").prop('checked', true);
				$("input[name='companyname']").val('');
				$('#InputDialog').modal();
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
	return false;
}

function updatedata($id) {
	jQuery.ajax({'url': 'plant/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$("input[name='plantid']").val(data.plantid);
				$("input[name='companyid']").val(data.companyid);
				$("input[name='plantcode']").val(data.plantcode);
				$("input[name='description']").val(data.description);
				$("textarea[name='plantaddress']").val(data.plantaddress);
				$("input[name='lat']").val(data.lat);
				$("input[name='lng']").val(data.lng);
				if (data.recordstatus === "1") {
					$("input[name='recordstatus']").prop('checked', true);
				} else {
					$("input[name='recordstatus']").prop('checked', false)
				}
				$("input[name='companyname']").val(data.companyname);
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
	jQuery.ajax({'url': 'plant/save',
		'data': {
			'plantid': $("input[name='plantid']").val(),
			'companyid': $("input[name='companyid']").val(),
			'plantcode': $("input[name='plantcode']").val(),
			'description': $("input[name='description']").val(),
			'plantaddress': $("textarea[name='plantaddress']").val(),
			'lat': $("input[name='lat']").val(),
			'lng': $("input[name='lng']").val(),
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
		jQuery.ajax({'url': 'plant/delete',
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
		jQuery.ajax({'url': 'plant/purge', 'data': {'id': $id},
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
			'plantid': $id,
			'companyname': $("input[name='dlg_search_companyname']").val(),
			'plantcode': $("input[name='dlg_search_plantcode']").val(),
			'description': $("input[name='dlg_search_description']").val()
		}});
	return false;
}

function downpdf($id = 0) {
	var array = 'plantid=' + $id
		+ '&companyname=' + $("input[name='dlg_search_companyname']").val()
		+ '&plantcode=' + $("input[name='dlg_search_plantcode']").val()
		+ '&description=' + $("input[name='dlg_search_description']").val();
	window.open('plant/downpdf?' + array);
}
