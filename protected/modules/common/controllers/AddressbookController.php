<?php
class AddressbookController extends AdminController {
	protected $menuname	 = 'addressbook';
	public $module			 = 'Admin';
	protected $pageTitle = 'Buku Alamat';
	public $wfname			 = '';
	public $sqldata			 = "select a0.addressbookid,a0.fullname,a0.iscustomer,a0.isemployee,a0.isvendor,a0.currentlimit,a0.currentdebt,a0.taxno,a0.creditlimit,a0.isstrictlimit,a0.bankname,a0.bankaccountno,a0.accountowner,a0.salesareaid,a0.pricecategoryid,a0.overdue,a0.invoicedate,a0.logo,a0.url,a0.recordstatus,a1.areaname as areaname,a2.categoryname as categoryname 
    from addressbook a0 
    left join salesarea a1 on a1.salesareaid = a0.salesareaid
    left join pricecategory a2 on a2.pricecategoryid = a0.pricecategoryid
  ";
	public $sqlcount		 = "select count(1) 
    from addressbook a0 
    left join salesarea a1 on a1.salesareaid = a0.salesareaid
    left join pricecategory a2 on a2.pricecategoryid = a0.pricecategoryid
  ";
	public function getSQL() {
		$this->count	 = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where				 = "";
		$addressbookid = filterinput(2, 'addressbookid');
		$fullname			 = filterinput(2, 'fullname');
		$taxno				 = filterinput(2, 'taxno');
		$bankname			 = filterinput(2, 'bankname');
		$bankaccountno = filterinput(2, 'bankaccountno');
		$accountowner	 = filterinput(2, 'accountowner');
		$where				 .= " where coalesce(a0.fullname,'') like '%".$fullname."%'
			and coalesce(a0.taxno,'') like '%".$taxno."%'
			and coalesce(a0.bankname,'') like '%".$bankname."%'
			and coalesce(a0.bankaccountno,'') like '%".$bankaccountno."%'
			and coalesce(a0.accountowner,'') like '%".$accountowner."%'";
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
					'addressbookid', 'fullname', 'iscustomer', 'isemployee', 'isvendor', 'currentlimit',
					'currentdebt', 'taxno', 'creditlimit', 'isstrictlimit', 'bankname', 'bankaccountno',
					'accountowner', 'salesareaid', 'pricecategoryid', 'overdue', 'invoicedate',
					'logo', 'url', 'recordstatus'
				),
				'defaultOrder' => array(
					'addressbookid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index', array('dataProvider' => $dataProvider));
	}
	public function actionCreate() {
		parent::actionCreate();
		echo CJSON::encode(array(
			'status' => 'success',
			"currentlimit" => 0,
			"currentdebt" => 0,
			"creditlimit" => 0,
			"invoicedate" => date("Y-m-d")
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
		$model = Yii::app()->db->createCommand($this->sqldata.' where a0.addressbookid = '.$id)->queryRow();
		if ($model !== null) {
			echo CJSON::encode(array(
				'status' => 'success',
				'addressbookid' => $model['addressbookid'],
				'fullname' => $model['fullname'],
				'iscustomer' => $model['iscustomer'],
				'isemployee' => $model['isemployee'],
				'isvendor' => $model['isvendor'],
				'currentlimit' => $model['currentlimit'],
				'currentdebt' => $model['currentdebt'],
				'taxno' => $model['taxno'],
				'creditlimit' => $model['creditlimit'],
				'isstrictlimit' => $model['isstrictlimit'],
				'bankname' => $model['bankname'],
				'bankaccountno' => $model['bankaccountno'],
				'accountowner' => $model['accountowner'],
				'salesareaid' => $model['salesareaid'],
				'pricecategoryid' => $model['pricecategoryid'],
				'overdue' => $model['overdue'],
				'invoicedate' => $model['invoicedate'],
				'logo' => $model['logo'],
				'url' => $model['url'],
				'recordstatus' => $model['recordstatus'],
				'areaname' => $model['areaname'],
				'categoryname' => $model['categoryname'],
			));
			Yii::app()->end();
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('fullname', 'string', 'emptyfullname'),
		));
		if ($error == false) {
			ModifyCommand(1, $this->menuname, 'addressbookid',
				array(
				array(':addressbookid', 'addressbookid', PDO::PARAM_STR),
				array(':fullname', 'fullname', PDO::PARAM_STR),
				array(':iscustomer', 'iscustomer', PDO::PARAM_STR),
				array(':isemployee', 'isemployee', PDO::PARAM_STR),
				array(':isvendor', 'isvendor', PDO::PARAM_STR),
				array(':currentlimit', 'currentlimit', PDO::PARAM_STR),
				array(':currentdebt', 'currentdebt', PDO::PARAM_STR),
				array(':taxno', 'taxno', PDO::PARAM_STR),
				array(':creditlimit', 'creditlimit', PDO::PARAM_STR),
				array(':isstrictlimit', 'isstrictlimit', PDO::PARAM_STR),
				array(':bankname', 'bankname', PDO::PARAM_STR),
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
				'insert into addressbook (fullname,iscustomer,isemployee,isvendor,currentlimit,currentdebt,taxno,creditlimit,isstrictlimit,bankname,bankaccountno,accountowner,salesareaid,pricecategoryid,overdue,invoicedate,logo,url,recordstatus)
			      values (:fullname,:iscustomer,:isemployee,:isvendor,:currentlimit,:currentdebt,:taxno,:creditlimit,:isstrictlimit,:bankname,:bankaccountno,:accountowner,:salesareaid,:pricecategoryid,:overdue,:invoicedate,:logo,:url,:recordstatus)',
				'update addressbook 
			      set fullname = :fullname,iscustomer = :iscustomer,isemployee = :isemployee,isvendor = :isvendor,currentlimit = :currentlimit,currentdebt = :currentdebt,taxno = :taxno,creditlimit = :creditlimit,isstrictlimit = :isstrictlimit,bankname = :bankname,bankaccountno = :bankaccountno,accountowner = :accountowner,salesareaid = :salesareaid,pricecategoryid = :pricecategoryid,overdue = :overdue,invoicedate = :invoicedate,logo = :logo,url = :url,recordstatus = :recordstatus 
			      where addressbookid = :addressbookid');
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
        $sql = "delete from address where addressbookid = ".$id;
        Yii::app()->db->createCommand($sql)->execute();
        $sql = "delete from addressacc where addressbookid = ".$id;
        Yii::app()->db->createCommand($sql)->execute();
        $sql = "delete from addresscontact where addressbookid = ".$id;
        Yii::app()->db->createCommand($sql)->execute();
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
	public function actionDownPDF() {
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader = Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title					 = getCatalog('addressbook');
		$this->pdf->AddPage('L', array(200, 450));
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C',
			'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('addressbookid'), getCatalog('fullname'),
			getCatalog('iscustomer'), getCatalog('isemployee'), getCatalog('isvendor'),
			getCatalog('currentlimit'), getCatalog('currentdebt'), getCatalog('taxno'),
			getCatalog('creditlimit'), getCatalog('isstrictlimit'), getCatalog('bankname'),
			getCatalog('bankaccountno'), getCatalog('accountowner'), getCatalog('salesarea'),
			getCatalog('pricecategory'), getCatalog('overdue'), getCatalog('invoicedate'),
			getCatalog('logo'), getCatalog('url'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 50, 20, 20, 20, 25, 25, 20, 25, 20, 20, 20, 20,
			20, 20, 20, 20, 20, 20, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'C', 'C', 'C', 'R', 'R', 'L', 'R',
			'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['addressbookid'], $row1['fullname'], $row1['iscustomer'],
				$row1['isemployee'], $row1['isvendor'], Yii::app()->format->formatNumber($row1['currentlimit']),
				Yii::app()->format->formatNumber($row1['currentdebt']), $row1['taxno'], Yii::app()->format->formatNumber($row1['creditlimit']),
				$row1['isstrictlimit'], $row1['bankname'], $row1['bankaccountno'], $row1['accountowner'],
				$row1['areaname'], $row1['categoryname'], $row1['overdue'], $row1['invoicedate'],
				$row1['logo'], $row1['url'], $row1['recordstatus']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}