<?php
class CustomerController extends AdminController {
	protected $menuname								 = 'customer';
	public $module										 = 'Common';
	protected $pageTitle							 = 'Customer';
	public $sqldata								 = 'select a0.addressbookid,a0.fullname,a0.iscustomer,a0.isemployee,a0.isvendor,a0.ishospital,a0.currentlimit,a0.currentdebt,a0.taxno,a0.creditlimit,a0.isstrictlimit,a0.bankname,a0.bankaccountno,a0.accountowner,a0.salesareaid,a0.pricecategoryid,a0.overdue,a0.invoicedate,a0.logo,a0.url,a0.recordstatus,a1.areaname,a2.categoryname
    from addressbook a0 
    left join salesarea a1 on a1.salesareaid = a0.salesareaid
    left join pricecategory a2 on a2.pricecategoryid = a0.pricecategoryid 
		where a0.iscustomer = 1 
  ';
	public $sqldataaddress					 = 'select a0.addressid,a0.addressbookid,a0.addresstypeid,a0.addressname,a0.rt,a0.rw,a0.cityid,a0.phoneno,a0.faxno,a0.lat,a0.lng,a1.addresstypename,a2.cityname
    from address a0 
    left join addresstype a1 on a1.addresstypeid = a0.addresstypeid
    left join city a2 on a2.cityid = a0.cityid 
  ';
	public $sqldataaddresscontact	 = 'select a0.addresscontactid,a0.contacttypeid,a0.addressbookid,a0.addresscontactname,a0.phoneno,a0.mobilephone,a0.emailaddress,a1.contacttypename
    from addresscontact a0 
    left join contacttype a1 on a1.contacttypeid = a0.contacttypeid
  ';
	public $sqlcount								 = 'select count(1)
    from addressbook a0 
    left join salesarea a1 on a1.salesareaid = a0.salesareaid
    left join pricecategory a2 on a2.pricecategoryid = a0.pricecategoryid
		where a0.iscustomer = 1 
  ';
	public $sqlcountaddress				 = 'select count(1)
    from address a0 
    left join addresstype a1 on a1.addresstypeid = a0.addresstypeid
    left join city a2 on a2.cityid = a0.cityid
  ';
	public $sqlcountaddresscontact	 = 'select count(1)
    from addresscontact a0 
    left join contacttype a1 on a1.contacttypeid = a0.contacttypeid
  ';
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
    $addressbookid = filterinput(2, 'addressbookid');
    $fullname = filterinput(2, 'fullname');
    $taxno = filterinput(2, 'taxno');
    $bankname = filterinput(2, 'bankname');
    $bankaccountno = filterinput(2, 'bankaccountno');
    $accountowner = filterinput(2, 'accountowner');
    $overdue = filterinput(2, 'overdue');
    $areaname = filterinput(2, 'areaname');
    $categoryname = filterinput(2, 'categoryname');
    $where				 = " and coalesce(a0.fullname,'') like '%".$fullname."%'
      and coalesce(a0.taxno,'') like '%".$taxno."%' 
      and coalesce(a0.bankname,'') like '%".$bankname."%' 
      and coalesce(a0.bankaccountno,'') like '%".$bankaccountno."%' 
      and coalesce(a0.accountowner,'') like '%".$accountowner."%' 
      and coalesce(a0.overdue,'') like '%".$overdue."%' 
      and coalesce(a1.areaname,'') like '%".$areaname."%' 
      and coalesce(a2.categoryname,'') like '%".$categoryname."%'";
    if (($addressbookid !== '0') && ($addressbookid !== '')) {
      $where .= " and a0.addressbookid in (".$addressbookid.")";
    }
    $this->sqldata = $this->sqldata.$where;
    $this->count	 = Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	public function actionIndex() {
		parent::actionIndex();
		$this->getSQL();
		$dataProvider = new CSqlDataProvider($this->sqldata,
			array(
			'totalItemCount' => $this->count,
			'keyField' => 'addressbookid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'addressbookid', 'fullname', 'iscustomer', 'isemployee', 'isvendor', 'ishospital',
					'currentlimit', 'currentdebt', 'taxno', 'creditlimit', 'isstrictlimit', 'bankname',
					'bankaccountno', 'accountowner', 'salesareaid', 'pricecategoryid', 'overdue',
					'invoicedate', 'logo', 'url', 'recordstatus'
				),
				'defaultOrder' => array(
					'addressbookid' => CSort::SORT_DESC
				),
			),
		));
    $addressbookid = filterinput(2,'addressbookid',FILTER_SANITIZE_NUMBER_INT);
		if (($addressbookid !== '') && ($addressbookid !== '0')) {
			$this->sqlcountaddress .= ' where addressbookid = '.$addressbookid;
			$this->sqldataaddress	 .= ' where addressbookid = '.$addressbookid;
		}
		$countaddress				 = Yii::app()->db->createCommand($this->sqlcountaddress)->queryScalar();
		$dataProvideraddress = new CSqlDataProvider($this->sqldataaddress,
			array(
			'totalItemCount' => $countaddress,
			'keyField' => 'addressid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'addressid' => CSort::SORT_DESC
				),
			),
		));
		if (($addressbookid !== '') && ($addressbookid !== '0')) {
			$this->sqlcountaddresscontact	 .= ' where addressbookid = '.$addressbookid;
			$this->sqldataaddresscontact	 .= ' where addressbookid = '.$addressbookid;
		}
		$countaddresscontact				 = Yii::app()->db->createCommand($this->sqlcountaddresscontact)->queryScalar();
		$dataProvideraddresscontact	 = new CSqlDataProvider($this->sqldataaddresscontact,
			array(
			'totalItemCount' => $countaddresscontact,
			'keyField' => 'addresscontactid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'addresscontactid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProvideraddress' => $dataProvideraddress,
			'dataProvideraddresscontact' => $dataProvideraddresscontact));
	}
	public function actionGetData() {
    $id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if (($id !== '') && ($id !== '0')) {
			$sql		 = "select t.addressid,t.addressname
									from address t
									where addressbookid = ".$id."
									limit 1";
			$address = Yii::app()->db->createCommand($sql)->queryRow();
			echo CJSON::encode(array(
				'status' => 'success',
				'shiptoid' => $address['addressid'],
				'shiptoname' => $address['addressname'],
				'billtoid' => $address['addressid'],
				'billtoname' => $address['addressname']));
			Yii::app()->end();
		}
	}
	public function actionUpload() {
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/addressbook/')) {
			mkdir(Yii::getPathOfAlias('webroot').'/images/addressbook/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/addressbook/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
	public function actionCreate() {
		parent::actionCreate();
		$addressbookid = rand(-1, -1000000000);
		echo CJSON::encode(array(
			'status' => 'success',
			'addressbookid' => $addressbookid,
			"creditlimit" => 0,
			"overdue" => 0
		));
	}
	public function actionCreateaddress() {
		parent::actionCreate();
		echo CJSON::encode(array(
			'status' => 'success',
		));
	}
	public function actionCreateaddresscontact() {
		parent::actionCreate();
		echo CJSON::encode(array(
			'status' => 'success',
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
    $id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldata.' and addressbookid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'addressbookid' => $model['addressbookid'],
        'fullname' => $model['fullname'],
        'taxno' => $model['taxno'],
        'creditlimit' => $model['creditlimit'],
        'isstrictlimit' => $model['isstrictlimit'],
        'bankname' => $model['bankname'],
        'bankaccountno' => $model['bankaccountno'],
        'accountowner' => $model['accountowner'],
        'salesareaid' => $model['salesareaid'],
        'pricecategoryid' => $model['pricecategoryid'],
        'overdue' => $model['overdue'],
        'logo' => $model['logo'],
        'url' => $model['url'],
        'recordstatus' => $model['recordstatus'],
        'areaname' => $model['areaname'],
        'categoryname' => $model['categoryname'],
      ));
      Yii::app()->end();
		}
	}
	public function actionUpdateaddress() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldataaddress.' where addressid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'addressid' => $model['addressid'],
        'addressbookid' => $model['addressbookid'],
        'addresstypeid' => $model['addresstypeid'],
        'addressname' => $model['addressname'],
        'rt' => $model['rt'],
        'rw' => $model['rw'],
        'cityid' => $model['cityid'],
        'phoneno' => $model['phoneno'],
        'faxno' => $model['faxno'],
        'lat' => $model['lat'],
        'lng' => $model['lng'],
        'addresstypename' => $model['addresstypename'],
        'cityname' => $model['cityname'],
      ));
      Yii::app()->end();
    }
	}
	public function actionUpdateaddresscontact() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldataaddresscontact.' where addresscontactid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'addresscontactid' => $model['addresscontactid'],
        'contacttypeid' => $model['contacttypeid'],
        'addressbookid' => $model['addressbookid'],
        'addresscontactname' => $model['addresscontactname'],
        'phoneno' => $model['phoneno'],
        'mobilephone' => $model['mobilephone'],
        'emailaddress' => $model['emailaddress'],
        'contacttypename' => $model['contacttypename'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('fullname', 'string', 'emptyfullname'),
			array('creditlimit', 'string', 'emptycreditlimit'),
			array('salesareaid', 'string', 'emptysalesareaid'),
			array('pricecategoryid', 'string', 'emptypricecategoryid'),
			array('overdue', 'string', 'emptyoverdue'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'addressbookid',
				array(
				array(':addressbookid', 'addressbookid', PDO::PARAM_STR),
				array(':actiontype', 'actiontype', PDO::PARAM_STR),
				array(':fullname', 'fullname', PDO::PARAM_STR),
				array(':taxno', 'taxno', PDO::PARAM_STR),
				array(':creditlimit', 'creditlimit', PDO::PARAM_STR),
				array(':isstrictlimit', 'isstrictlimit', PDO::PARAM_STR),
				array(':currentlimit', 'currentlimit', PDO::PARAM_STR),
				array(':bankname', 'bankname', PDO::PARAM_STR),
				array(':bankaccountno', 'bankaccountno', PDO::PARAM_STR),
				array(':accountowner', 'accountowner', PDO::PARAM_STR),
				array(':salesareaid', 'salesareaid', PDO::PARAM_STR),
				array(':pricecategoryid', 'pricecategoryid', PDO::PARAM_STR),
				array(':overdue', 'overdue', PDO::PARAM_STR),
				array(':logo', 'logo', PDO::PARAM_STR),
				array(':url', 'url', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'call Insertcustomer (:actiontype
          ,:addressbookid
          ,:fullname
          ,:taxno
          ,:creditlimit
          ,:isstrictlimit
          ,:bankname
          ,:bankaccountno
          ,:accountowner
          ,:salesareaid
          ,:pricecategoryid
          ,:overdue
          ,:logo
          ,:url
          ,:recordstatus)',
				'call Insertcustomer (:actiontype
          ,:addressbookid
          ,:fullname
          ,:taxno
          ,:creditlimit
          ,:isstrictlimit
          ,:bankname
          ,:bankaccountno
          ,:accountowner
          ,:salesareaid
          ,:pricecategoryid
          ,:overdue
          ,:logo
          ,:url
          ,:recordstatus)');
		}
	}
	public function actionSaveaddress() {
		parent::actionSave();
		$error = ValidateData(array(
			array('addresstypeid', 'string', 'emptyaddresstypeid'),
			array('addressname', 'string', 'emptyaddressname'),
			array('cityid', 'string', 'emptycityid'),
			array('lat', 'string', 'emptylat'),
			array('lng', 'string', 'emptylng'),
		));
		if ($error == false) {
			ModifyCommand(1, $this->menuname, 'addressid',
				array(
				array(':addressid', 'addressid', PDO::PARAM_STR),
				array(':addressbookid', 'addressbookid', PDO::PARAM_STR),
				array(':addresstypeid', 'addresstypeid', PDO::PARAM_STR),
				array(':addressname', 'addressname', PDO::PARAM_STR),
				array(':rt', 'rt', PDO::PARAM_STR),
				array(':rw', 'rw', PDO::PARAM_STR),
				array(':cityid', 'cityid', PDO::PARAM_STR),
				array(':phoneno', 'phoneno', PDO::PARAM_STR),
				array(':faxno', 'faxno', PDO::PARAM_STR),
				array(':lat', 'lat', PDO::PARAM_STR),
				array(':lng', 'lng', PDO::PARAM_STR),
				array(':bankaccountno', 'bankaccountno', PDO::PARAM_STR),
				array(':accountowner', 'accountowner', PDO::PARAM_STR),
				array(':salesareaid', 'salesareaid', PDO::PARAM_STR),
				array(':pricecategoryid', 'pricecategoryid', PDO::PARAM_STR),
				array(':overdue', 'overdue', PDO::PARAM_STR),
				array(':invoicedate', 'invoicedate', PDO::PARAM_STR),
				array(':logo', 'logo', PDO::PARAM_STR),
				array(':url', 'url', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'insert into address (addressbookid,addresstypeid,addressname,rt,rw,cityid,phoneno,faxno,lat,lng) 
			      values (:addressbookid,:addresstypeid,:addressname,:rt,:rw,:cityid,:phoneno,:faxno,:lat,:lng)',
				'update address 
			      set addressbookid = :addressbookid,addresstypeid = :addresstypeid,addressname = :addressname,rt = :rt,rw = :rw,cityid = :cityid,phoneno = :phoneno,faxno = :faxno,lat = :lat,lng = :lng 
			      where addressid = :addressid');
		}
	}
	public function actionSaveaddresscontact() {
		parent::actionSave();
		$error = ValidateData(array(
			array('contacttypeid', 'string', 'emptycontacttypeid'),
			array('addresscontactname', 'string', 'emptyaddresscontactname'),
		));
		if ($error == false) {
			ModifyCommand(1, $this->menuname, 'addresscontactid',
				array(
				array(':addresscontactid', 'addresscontactid', PDO::PARAM_STR),
				array(':contacttypeid', 'contacttypeid', PDO::PARAM_STR),
				array(':addresscontactname', 'addresscontactname', PDO::PARAM_STR),
				array(':phoneno', 'phoneno', PDO::PARAM_STR),
				array(':mobilephone', 'mobilephone', PDO::PARAM_STR),
				array(':emailaddress', 'emailaddress', PDO::PARAM_STR)
				),
				'insert into addresscontact (contacttypeid,addressbookid,addresscontactname,phoneno,mobilephone,emailaddress) 
			      values (:contacttypeid,:addressbookid,:addresscontactname,:phoneno,:mobilephone,:emailaddress)',
				'update addresscontact 
			      set contacttypeid = :contacttypeid,addressbookid = :addressbookid,addresscontactname = :addresscontactname,phoneno = :phoneno,mobilephone = :mobilephone,emailaddress = :emailaddress 
			      where addresscontactid = :addresscontactid');
		}
	}
	public function actionDelete() {
		parent::actionDelete();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			$ids = filterinput(4,'id');
      if ($ids == '') {
        GetMessage('error', 'chooseone');
      }
      foreach ($ids as $id) {
				$sql		 = "select recordstatus from addressbook where addressbookid = ".$id;
				$status	 = Yii::app()->db->createCommand($sql)->queryRow();
				if ($status['recordstatus'] == 1) {
					$sql = "update addressbook set recordstatus = 0 where addressbookid = ".$id;
				} else
				if ($status['recordstatus'] == 0) {
					$sql = "update addressbook set recordstatus = 1 where addressbookid = ".$id;
				}
				$connection->createCommand($sql)->execute();
      }
      $transaction->commit();
      getMessage('success', 'alreadysaved');
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionPurge() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			$ids = filterinput(4,'id');
      if ($ids == '') {
        GetMessage('error', 'chooseone');
      }
      foreach ($ids as $id) {
				$sql = "delete from addressbook where addressbookid = ".$id;
				Yii::app()->db->createCommand($sql)->execute();
      }
				$transaction->commit();
				getMessage('success', 'alreadysaved');
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionPurgeaddress() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			$ids = filterinput(4,'id');
      if ($ids == '') {
        GetMessage('error', 'chooseone');
      }
      foreach ($ids as $id) {
				$sql = "delete from address where addressid = ".$id;
				Yii::app()->db->createCommand($sql)->execute();
      }
				$transaction->commit();
				getMessage('success', 'alreadysaved');
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionPurgeaddresscontact() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			$ids = filterinput(4,'id');
      if ($ids == '') {
        GetMessage('error', 'chooseone');
      }
      foreach ($ids as $id) {
				$sql = "delete from addresscontact where addresscontactid = ".$id;
				Yii::app()->db->createCommand($sql)->execute();
      }
				$transaction->commit();
				getMessage('success', 'alreadysaved');
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionDownPDF() {
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader = Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title					 = getCatalog('customer');
		$this->pdf->AddPage('L');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C',
			'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('addressbookid'), getCatalog('fullname'),
			getCatalog('currentlimit'), getCatalog('currentdebt'), getCatalog('taxno'), getCatalog('creditlimit'),
			getCatalog('isstrictlimit'), getCatalog('bankname'), getCatalog('bankaccountno'),
			getCatalog('accountowner'), getCatalog('salesarea'), getCatalog('pricecategory'),
			getCatalog('overdue'), getCatalog('invoicedate'), getCatalog('logo'), getCatalog('url'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15,
			15, 15, 15, 15, 15, 15, 15, 15, 15, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L',
			'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['addressbookid'], $row1['fullname'], $row1['currentlimit'],
				$row1['currentdebt'], $row1['taxno'], $row1['creditlimit'], $row1['isstrictlimit'],
				$row1['bankname'], $row1['bankaccountno'], $row1['accountowner'], $row1['areaname'],
				$row1['categoryname'], $row1['overdue'], $row1['invoicedate'], $row1['logo'],
				$row1['url'], (($row1['recordstatus'] == 1) ? 'Active' : 'NotActive')));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}