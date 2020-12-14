<?php
class PrheaderController extends AdminController {
	protected $menuname						 = 'prheader';
	public $module								 = 'Warehouse';
	protected $pageTitle					 = 'Permohonan Pembelian (FPP)';
	public $wfname								 = 'apppr';
	public $sqldata						 = "select a0.prheaderid,a0.prdate,a0.companyid,a0.prno,a0.formrequestid,a0.headernote,a0.recordstatus,a1.companyname as companyname,a2.frno as frno,getwfstatusbywfname(a0.recordstatus,'apppr') as statusname,
			a4.sono,a4.pocustno,a5.fullname,a3.productplanno
    from prheader a0 
    left join company a1 on a1.companyid = a0.companyid
    left join formrequest a2 on a2.formrequestid = a0.formrequestid 
		left join productplan a3 on a3.productplanid = a2.productplanid 
		left join soheader a4 on a4.soheaderid = a3.soheaderid 
		left join addressbook a5 on a5.addressbookid = a4.addressbookid
  ";
	public $sqldataprmaterial	 = "select a0.prmaterialid,a0.prheaderid,a0.productid,a0.qty,a0.unitofmeasureid,a0.reqdate,a0.itemtext,a0.poqty,a0.formrequestdetid,a0.grqty,a0.giqty,a1.productname as productname,a2.uomcode as uomcode,
			a3.prno,(a0.qty-a0.giqty) as selisihqty,
			(
			select ifnull(sum(a.qty),0)
			from productstock a 
			where a.productid = a0.productid and a.unitofmeasureid = a0.unitofmeasureid and a.slocid = a4.slocid 
			) as qtystock
    from prmaterial a0 
    join product a1 on a1.productid = a0.productid
    join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
		left join prheader a3 on a3.prheaderid = a0.prheaderid  
		left join formrequestdet a4 on a4.formrequestdetid = a0.formrequestdetid
  ";
	public $sqlcount						 = "select count(1)
    from prheader a0 
    left join company a1 on a1.companyid = a0.companyid
    left join formrequest a2 on a2.formrequestid = a0.formrequestid
		left join productplan a3 on a3.productplanid = a2.productplanid 
		left join soheader a4 on a4.soheaderid = a3.soheaderid 
		left join addressbook a5 on a5.addressbookid = a4.addressbookid
  ";
	public $sqlcountprmaterial	 = "select count(1)
    from prmaterial a0 
    join product a1 on a1.productid = a0.productid
    join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
		left join prheader a3 on a3.prheaderid = a0.prheaderid  
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
		if ((isset($_REQUEST['prno'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['frno']))) {
			$where .= " where a0.prno like '%".$_REQUEST['prno']."%'
and a1.companyname like '%".$_REQUEST['companyname']."%' 
and a2.frno like '%".$_REQUEST['frno']."%'";
		}
		if (isset($_REQUEST['prheaderid'])) {
			if (($_REQUEST['prheaderid'] !== '0') && ($_REQUEST['prheaderid'] !== '')) {
				$where .= " and a0.prheaderid in (".$_REQUEST['prheaderid'].")";
			}
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
			'keyField' => 'prheaderid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'prheaderid', 'prdate', 'companyid', 'prno', 'formrequestid', 'headernote',
					'recordstatus',
					'productplanno', 'sono', 'fullname', 'pocustno'
				),
				'defaultOrder' => array(
					'prheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['prheaderid'])) {
			$this->sqlcountprmaterial	 .= ' where a0.prheaderid = '.$_REQUEST['prheaderid'];
			$this->sqldataprmaterial	 .= ' where a0.prheaderid = '.$_REQUEST['prheaderid'];
		}
		$countprmaterial				 = Yii::app()->db->createCommand($this->sqlcountprmaterial)->queryScalar();
		$dataProviderprmaterial	 = new CSqlDataProvider($this->sqldataprmaterial,
			array(
			'totalItemCount' => $countprmaterial,
			'keyField' => 'prmaterialid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'prmaterialid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProviderprmaterial' => $dataProviderprmaterial));
	}
	public function actionCreate() {
		parent::actionCreate();
		$prheaderid	 = rand(-1, -1000000000);
		$company		 = getCompany();
		echo CJSON::encode(array(
			'status' => 'success',
			'prheaderid' => $prheaderid,
			'prdate' => date("Y-m-d"),
			'companyid' => $company['companyid'],
			'companyname' => $company['companyname'],
			'recordstatus' => $this->findstatusbyuser("inspr")
		));
	}
	public function actionCreateprmaterial() {
		parent::actionCreate();
		echo CJSON::encode(array(
			'status' => 'success',
			"qty" => 0,
			"reqdate" => date("Y-m-d"),
			"poqty" => 0,
			"grqty" => 0,
			"giqty" => 0,
			"recordstatus" => $this->findstatusbyuser("inspr")
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			if (is_array($id)) {
				$id = $id[0];
			}
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.prheaderid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '') {
				if ($model !== null) {
					echo CJSON::encode(array(
						'status' => 'success',
						'prheaderid' => $model['prheaderid'],
						'prdate' => $model['prdate'],
						'companyid' => $model['companyid'],
						'formrequestid' => $model['formrequestid'],
						'headernote' => $model['headernote'],
						'recordstatus' => $model['recordstatus'],
						'companyname' => $model['companyname'],
						'frno' => $model['frno'],
					));
					Yii::app()->end();
				}
			} else {
				getMessage('error', getCatalog("docreachmaxstatus"));
			}
		}
	}
	public function actionGetData() {
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			if (is_array($id)) {
				$id = $id[0];
			}
			$model = Yii::app()->db->createCommand($this->sqldataprmaterial.' 
				where a0.prmaterialid = '.$id)->queryRow();
			if ($model !== null) {
				echo CJSON::encode(array(
					'status' => 'success',
					'prmaterialid' => $model['prmaterialid'],
					'productid' => $model['productid'],
					'productname' => $model['productname'],
					'selisihqty' => $model['selisihqty'],
					'prno' => $model['prno'],
				));
				Yii::app()->end();
			}
		}
	}
	public function actionUpdateprmaterial() {
		parent::actionUpdate();
		if (isset($_POST['id'])) {
			$id		 = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataprmaterial.' where prmaterialid = '.$id)->queryRow();
			if ($model !== null) {
				echo CJSON::encode(array(
					'status' => 'success',
					'prmaterialid' => $model['prmaterialid'],
					'prheaderid' => $model['prheaderid'],
					'productid' => $model['productid'],
					'qty' => $model['qty'],
					'unitofmeasureid' => $model['unitofmeasureid'],
					'reqdate' => $model['reqdate'],
					'itemtext' => $model['itemtext'],
					'formrequestdetid' => $model['formrequestdetid'],
					'recordstatus' => $model['recordstatus'],
					'productname' => $model['productname'],
					'uomcode' => $model['uomcode'],
				));
				Yii::app()->end();
			}
		}
	}
	public function actionGeneratefr() {
		if (isset($_POST['id'])) {
			if ($_POST['id'] !== '') {
				$connection	 = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				try {
					$sql		 = 'call GeneratePRDA(:vid,:vhid)';
					$command = $connection->createCommand($sql);
					$command->bindvalue(':vid', $_POST['id'], PDO::PARAM_INT);
					$command->bindvalue(':vhid', $_POST['hid'], PDO::PARAM_INT);
					$command->execute();
					$transaction->commit();
					getMessage('success', getCatalog('datagenerated'));
				} catch (Exception $e) { // an exception is raised if a query fails
					$transaction->rollBack();
					getMessage('failure', $e->getMessage());
				}
			}
		}
		Yii::app()->end();
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('prheaderid', 'string', 'emptyprheaderid'),
			array('prdate', 'string', 'emptyprdate'),
			array('companyid', 'string', 'emptycompanyid'),
			array('formrequestid', 'string', 'emptyformrequestid'),
		));
		if ($error == false) {
			$id					 = $_POST['prheaderid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				$sql		 = 'call Insertprheader (:actiontype
,:prheaderid
,:prdate
,:companyid
,:formrequestid
,:headernote
,:recordstatus,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':actiontype', $_POST['actiontype'], PDO::PARAM_STR);
				$command->bindvalue(':prheaderid', $_POST['prheaderid'], PDO::PARAM_STR);
				$command->bindvalue(':prdate',
					(($_POST['prdate'] !== '') ? $_POST['prdate'] : null), PDO::PARAM_STR);
				$command->bindvalue(':companyid',
					(($_POST['companyid'] !== '') ? $_POST['companyid'] : null), PDO::PARAM_STR);
				$command->bindvalue(':formrequestid',
					(($_POST['formrequestid'] !== '') ? $_POST['formrequestid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':headernote',
					(($_POST['headernote'] !== '') ? $_POST['headernote'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':recordstatus',
					(($_POST['recordstatus'] !== '') ? $_POST['recordstatus'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':vcreatedby', Yii::app()->user->id, PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				getMessage('success', 'alreadysaved');
			} catch (CDbException $e) {
				$transaction->rollBack();
				getMessage('error', $e->getMessage());
			}
		}
	}
	public function actionSaveprmaterial() {
		parent::actionSave();
		$error = ValidateData(array(
			array('prmaterialid', 'string', 'emptyprmaterialid'),
			array('prheaderid', 'string', 'emptyprheaderid'),
			array('productid', 'string', 'emptyproductid'),
			array('qty', 'string', 'emptyqty'),
			array('unitofmeasureid', 'string', 'emptyuomid'),
		));
		if ($error == false) {
			$id					 = $_POST['prmaterialid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				if ($id !== '') {
					$sql = 'update prmaterial 
			      set prheaderid = :prheaderid,productid = :productid,qty = :qty,unitofmeasureid = :unitofmeasureid,reqdate = :reqdate,itemtext = :itemtext
			      where prmaterialid = :prmaterialid';
				} else {
					$sql = 'insert into prmaterial (prheaderid,productid,qty,unitofmeasureid,reqdate,itemtext) 
			      values (:prheaderid,:productid,:qty,:unitofmeasureid,:reqdate,:itemtext)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '') {
					$command->bindvalue(':prmaterialid', $_POST['prmaterialid'], PDO::PARAM_STR);
				}
				$command->bindvalue(':prheaderid',
					(($_POST['prheaderid'] !== '') ? $_POST['prheaderid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':productid',
					(($_POST['productid'] !== '') ? $_POST['productid'] : null), PDO::PARAM_STR);
				$command->bindvalue(':qty', (($_POST['qty'] !== '') ? $_POST['qty'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':unitofmeasureid',
					(($_POST['unitofmeasureid'] !== '') ? $_POST['unitofmeasureid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':reqdate',
					(($_POST['reqdate'] !== '') ? $_POST['reqdate'] : null), PDO::PARAM_STR);
				$command->bindvalue(':itemtext',
					(($_POST['itemtext'] !== '') ? $_POST['itemtext'] : null), PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				Inserttranslog($command, $id, $this->menuname);
				getMessage('success', 'alreadysaved');
			} catch (CDbException $e) {
				$transaction->rollBack();
				getMessage('error', $e->getMessage());
			}
		}
	}
	public function actionApprove() {
		parent::actionPost();
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			if (!is_array($id)) {
				$ids[] = $id;
				$id		 = $ids;
			}
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				$sql		 = 'call Approvepr(:vid,:vcreatedby)';
				$command = $connection->createCommand($sql);
				foreach ($id as $ids) {
					$command->bindvalue(':vid', $ids, PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				getMessage('success', 'alreadysaved', 1);
			} catch (Exception $e) {
				$transaction->rollback();
				getMessage('error', $e->getMessage(), 1);
			}
		} else {
			getMessage('error', 'chooseone', 1);
		}
	}
	public function actionDelete() {
		parent::actionDelete();
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			if (!is_array($id)) {
				$ids[] = $id;
				$id		 = $ids;
			}
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				$sql		 = 'call Deletepr(:vid,:vcreatedby)';
				$command = $connection->createCommand($sql);
				foreach ($id as $ids) {
					$command->bindvalue(':vid', $ids, PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				getMessage('success', 'alreadysaved', 1);
			} catch (Exception $e) {
				$transaction->rollback();
				getMessage('error', $e->getMessage(), 1);
			}
		} else {
			getMessage('error', 'chooseone', 1);
		}
	}
	public function actionPurge() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			if (isset($_POST['id'])) {
				$id = $_POST['id'];
				if (!is_array($id)) {
					$ids[] = $id;
					$id		 = $ids;
				}
				for ($i = 0; $i < count($_POST['id']); $i++) {
					$sql = "delete from prheader where prheaderid = ".$id[$i];
					Yii::app()->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				getMessage('success', 'alreadysaved');
			} else {
				getMessage('success', 'chooseone');
			}
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionPurgeprmaterial() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			if (isset($_POST['id'])) {
				$id = $_POST['id'];
				if (!is_array($id)) {
					$ids[] = $id;
					$id		 = $ids;
				}
				for ($i = 0; $i < count($_POST['id']); $i++) {
					$sql = "delete from prmaterial where prmaterialid = ".$id[$i];
					Yii::app()->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				getMessage('success', 'alreadysaved');
			}
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionDownPDF() {
		parent::actionDownPDF();
		$sql = "select b.slocid,e.companyid,a.prno,a.prdate,a.headernote,a.prheaderid,b.description,c.frno,a.recordstatus
      from prheader a 
	  inner join formrequest c on c.formrequestid = a.formrequestid
	  inner join sloc b on b.slocid = c.slocid     
		inner join plant d on d.plantid = b.plantid
    inner join company e on e.companyid = d.companyid ";
		if ($_GET['prheaderid'] !== '') {
			$sql = $sql."where a.prheaderid in (".$_GET['prheaderid'].")";
		}
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($dataReader as $row) {
			$this->pdf->companyid = $row['companyid'];
		}
		$this->pdf->title = getCatalog('prheader');
		$this->pdf->AddPage('P');
		$this->pdf->AliasNbPages();
		$this->pdf->SetFont('Arial');

		foreach ($dataReader as $row) {
			$this->pdf->SetFontSize(8);
			$this->pdf->text(10, $this->pdf->gety() + 2, 'No ');
			$this->pdf->text(30, $this->pdf->gety() + 2, ': '.$row['prno']);
			$this->pdf->text(10, $this->pdf->gety() + 6, 'Tgl ');
			$this->pdf->text(30, $this->pdf->gety() + 6,
				': '.Yii::app()->format->formatDate($row['prdate']));
			$this->pdf->text(120, $this->pdf->gety() + 2, 'Gudang ');
			$this->pdf->text(150, $this->pdf->gety() + 2, ': '.$row['description']);
			$this->pdf->text(120, $this->pdf->gety() + 6, 'No Permintaan Barang ');
			$this->pdf->text(150, $this->pdf->gety() + 6, ': '.$row['frno']);

			$sql1				 = "select b.productname, a.qty, c.uomcode, a.itemtext
        from prmaterial a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        where prheaderid = ".$row['prheaderid'];
			$dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety() + 10);
			$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C');
			$this->pdf->setwidths(array(10, 90, 20, 15, 55));
			$this->pdf->colheader			 = array('No', 'Items', 'Qty', 'Unit', 'Remark');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L', 'L', 'R', 'C', 'L');
			$i												 = 0;
			foreach ($dataReader1 as $row1) {
				$i = $i + 1;
				$this->pdf->row(array($i, $row1['productname'],
					Yii::app()->format->formatNumber($row1['qty']),
					$row1['uomcode'],
					$row1['itemtext']));
			}
			$this->pdf->sety($this->pdf->gety());
			$this->pdf->colalign			 = array('C', 'C');
			$this->pdf->setwidths(array(50, 140));
			$this->pdf->iscustomborder = false;
			$this->pdf->setbordercell(array('none', 'none'));
			$this->pdf->coldetailalign = array('L', 'L');
			$this->pdf->row(array(
				'Note:',
				$row['headernote']
			));
			$this->pdf->checkNewPage(40);
			//$this->pdf->Image('images/ttdpr.jpg',5,$this->pdf->gety()+5,200);
			$this->pdf->sety($this->pdf->gety() + 10);
			$this->pdf->text(10, $this->pdf->gety(), 'Penerima');
			$this->pdf->text(50, $this->pdf->gety(), 'Mengetahui');
			$this->pdf->text(120, $this->pdf->gety(), 'Mengetahui Pembuat');
			$this->pdf->text(170, $this->pdf->gety(), 'Pembuat');
			$this->pdf->text(10, $this->pdf->gety() + 15, '........................');
			$this->pdf->text(50, $this->pdf->gety() + 15, '........................');
			$this->pdf->text(120, $this->pdf->gety() + 15, '........................');
			$this->pdf->text(170, $this->pdf->gety() + 15, '........................');
		}
		$this->pdf->Output();
	}
}