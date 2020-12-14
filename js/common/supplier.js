if ("undefined" === typeof jQuery)
	throw new Error("Supplier's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({'url': 'supplier/create', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
      if (data.status === "success") {
			$("input[name='actiontype']").val(0);
			$("input[name='addressbookid']").val(data.addressbookid);
			$("input[name='fullname']").val('');
			$("input[name='taxno']").val('');
			$("input[name='bankname']").val('');
			$("input[name='bankaccountno']").val('');
			$("input[name='accountowner']").val('');
			$("input[name='logo']").val('');
			$("input[name='url']").val('');
			$("input[name='recordstatus']").prop('checked', true);
			$.fn.yiiGridView.update('addressList', {data: {'addressbookid': data.addressbookid}});
			$.fn.yiiGridView.update('addresscontactList', {data: {'addressbookid': data.addressbookid}});
			$('#InputDialog').modal();
    } else {
      toastr.error(data.msg);
    }
		},
		'cache': false});
	return false;
}
function newdataaddress() {
	jQuery.ajax({'url': 'supplier/createaddress', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
      if (data.status === "success") {
			$("input[name='addressid']").val('');
			$("input[name='addresstypeid']").val('');
			$("textarea[name='addressname']").val('');
			$("input[name='rt']").val('');
			$("input[name='rw']").val('');
			$("input[name='cityid']").val('');
			$("input[name='phoneno']").val('');
			$("input[name='faxno']").val('');
			$("input[name='lat']").val('0');
			$("input[name='lng']").val('0');
			$("input[name='addresstypename']").val('');
			$("input[name='cityname']").val('');
			$('#InputDialogaddress').modal();
    } else {
      toastr.error(data.msg);
    }
		},
		'cache': false});
	return false;
}
function newdataaddresscontact() {
	jQuery.ajax({'url': 'supplier/createaddresscontact', 'data': {},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
      if (data.status === "success") {
			$("input[name='addresscontactid']").val('');
			$("input[name='contacttypeid']").val('');
			$("input[name='addresscontactname']").val('');
			$("input[name='contactphoneno']").val('');
			$("input[name='mobilephone']").val('');
			$("input[name='emailaddress']").val('');
			$("input[name='contacttypename']").val('');
			$('#InputDialogaddresscontact').modal();
    } else {
      toastr.error(data.msg);
    }
		},
		'cache': false});
	return false;
}
function updatedata($id) {
	jQuery.ajax({'url': 'supplier/update', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
      if (data.status === "success") {
			$("input[name='actiontype']").val(1);
			$("input[name='addressbookid']").val(data.addressbookid);
			$("input[name='fullname']").val(data.fullname);
			$("input[name='taxno']").val(data.taxno);
			$("input[name='bankname']").val(data.bankname);
			$("input[name='bankaccountno']").val(data.bankaccountno);
			$("input[name='accountowner']").val(data.accountowner);
			$("input[name='logo']").val(data.logo);
			$("input[name='url']").val(data.url);
			if (data.recordstatus === "1") {
				$("input[name='recordstatus']").prop('checked', true);
			} else {
				$("input[name='recordstatus']").prop('checked', false)
			}
			$.fn.yiiGridView.update('addressList', {data: {'addressbookid': data.addressbookid}});
			$.fn.yiiGridView.update('addresscontactList', {data: {'addressbookid': data.addressbookid}});

			$('#InputDialog').modal();
    } else {
      
    }
		},
		'cache': false});
	return false;
}
function updatedataaddress($id) {
	jQuery.ajax({'url': 'supplier/updateaddress', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
      if (data.status === "success") {
			$("input[name='addressid']").val(data.addressid);
			$("input[name='addresstypeid']").val(data.addresstypeid);
			$("textarea[name='addressname']").val(data.addressname);
			$("input[name='rt']").val(data.rt);
			$("input[name='rw']").val(data.rw);
			$("input[name='cityid']").val(data.cityid);
			$("input[name='phoneno']").val(data.phoneno);
			$("input[name='faxno']").val(data.faxno);
			$("input[name='lat']").val(data.lat);
			$("input[name='lng']").val(data.lng);
			$("input[name='addresstypename']").val(data.addresstypename);
			$("input[name='cityname']").val(data.cityname);
			$('#InputDialogaddress').modal();
    } else {
 toastr.error(data.msg);     
    }
		},
		'cache': false});
	return false;
}
function updatedataaddresscontact($id) {
	jQuery.ajax({'url': 'supplier/updateaddresscontact', 'data': {'id': $id},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
      if (data.status === "success") {
			$("input[name='addresscontactid']").val(data.addresscontactid);
			$("input[name='contacttypeid']").val(data.contacttypeid);
			$("input[name='addresscontactname']").val(data.addresscontactname);
			$("input[name='contactphoneno']").val(data.phoneno);
			$("input[name='mobilephone']").val(data.mobilephone);
			$("input[name='emailaddress']").val(data.emailaddress);
			$("input[name='contacttypename']").val(data.contacttypename);
			$('#InputDialogaddresscontact').modal();
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
	jQuery.ajax({'url': 'supplier/save',
		'data': {
			'actiontype': $("input[name='actiontype']").val(),
			'addressbookid': $("input[name='addressbookid']").val(),
			'fullname': $("input[name='fullname']").val(),
			'taxno': $("input[name='taxno']").val(),
			'bankname': $("input[name='bankname']").val(),
			'bankaccountno': $("input[name='bankaccountno']").val(),
			'accountowner': $("input[name='accountowner']").val(),
			'logo': $("input[name='logo']").val(),
			'url': $("input[name='url']").val(),
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
function savedataaddress() {
	jQuery.ajax({'url': 'supplier/saveaddress',
		'data': {
			'addressbookid': $("input[name='addressbookid']").val(),
			'addressid': $("input[name='addressid']").val(),
			'addresstypeid': $("input[name='addresstypeid']").val(),
			'addressname': $("textarea[name='addressname']").val(),
			'rt': $("input[name='rt']").val(),
			'rw': $("input[name='rw']").val(),
			'cityid': $("input[name='cityid']").val(),
			'phoneno': $("input[name='phoneno']").val(),
			'faxno': $("input[name='faxno']").val(),
			'lat': $("input[name='lat']").val(),
			'lng': $("input[name='lng']").val(),
		},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$('#InputDialogaddress').modal('hide');
				toastr.info(data.msg);
				$.fn.yiiGridView.update("addressList");
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
}
function savedataaddresscontact() {
	jQuery.ajax({'url': 'supplier/saveaddresscontact',
		'data': {
			'addressbookid': $("input[name='addressbookid']").val(),
			'addresscontactid': $("input[name='addresscontactid']").val(),
			'contacttypeid': $("input[name='contacttypeid']").val(),
			'addresscontactname': $("input[name='addresscontactname']").val(),
			'phoneno': $("input[name='contactphoneno']").val(),
			'mobilephone': $("input[name='mobilephone']").val(),
			'emailaddress': $("input[name='emailaddress']").val(),
		},
		'type': 'post', 'dataType': 'json',
		'success': function (data) {
			if (data.status === "success") {
				$('#InputDialogaddresscontact').modal('hide');
				toastr.info(data.msg);
				$.fn.yiiGridView.update("addresscontactList");
			} else {
				toastr.error(data.msg);
			}
		},
		'cache': false});
}
function deletedata($id) {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'supplier/delete',
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
		jQuery.ajax({'url': 'supplier/purge', 'data': {'id': $id},
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
function purgedataaddress($id) {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'supplier/purgeaddress', 'data': {'id': $id},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status === "success") {
					toastr.info(data.msg);
					$.fn.yiiGridView.update("addressList");
				} else {
					toastr.error(data.msg);
				}
			},
			'cache': false});
	};
	return false;
}
function purgedataaddresscontact($id) {
	if (confirm('Apakah anda yakin ?')) {
		jQuery.ajax({'url': 'supplier/purgeaddresscontact', 'data': {'id': $id},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status === "success") {
					toastr.info(data.msg);
					$.fn.yiiGridView.update("addresscontactList");
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
			'addressbookid': $id,
			'fullname': $("input[name='dlg_search_fullname']").val(),
			'taxno': $("input[name='dlg_search_npwpno']").val(),
			'bankname': $("input[name='dlg_search_bankname']").val(),
			'bankaccountno': $("input[name='dlg_search_bankaccountno']").val(),
			'accountowner': $("input[name='dlg_search_accountowner']").val()
		}});
	return false;
}
function downpdf($id = 0) {
	var array = 'addressbookid' + $id
		+ '&fullname=' + $("input[name='dlg_search_fullname']").val()
		+ '&taxno=' + $("input[name='dlg_search_npwpno']").val()
		+ '&bankname=' + $("input[name='dlg_search_bankname']").val()
		+ '&bankaccountno=' + $("input[name='dlg_search_bankaccountno']").val()
		+ '&accountowner=' + $("input[name='dlg_search_accountowner']").val();
	window.open('supplier/downpdf?' + array);
}
function GetDetail($id = 0) {
	$('#ShowDetailDialog').modal('show');
	var array = 'addressbookid=' + $id;
	$.fn.yiiGridView.update("DetailaddressList", {data: array});
	$.fn.yiiGridView.update("DetailaddresscontactList", {data: array});
}