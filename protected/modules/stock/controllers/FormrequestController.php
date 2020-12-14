<?php
class FormrequestController extends AdminController {
	protected $menuname								 = 'formrequest';
	public $module										 = 'Warehouse';
	protected $pageTitle							 = 'Form Permintaan Barang (FPB)';
	public $wfname										 = 'appda';
	public $sqldata								 = "select a0.formrequestid,a0.useraccessid,a0.frdate,a0.companyid,a0.frno,a0.slocid,a0.headernote,a0.recordstatus,a1.companyname as companyname,a3.sloccode as sloccode,getwfstatusbywfname(a0.recordstatus,'appda') as statusname,a4.realname as username
    from formrequest a0 
    left join company a1 on a1.companyid = a0.companyid
    left join sloc a3 on a3.slocid = a0.slocid 
		left join useraccess a4 on a4.useraccessid = a0.useraccessid 
  ";
	public $sqldataformrequestdet	 = "select a0.formrequestdetid,a0.reqdate,a0.slocid,a0.formrequestid,a0.productid,a0.qty,a0.poqty,a0.grqty,a0.tsqty,a0.unitofmeasureid,a0.productplandetailid,a0.itemtext,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,
			(
			select ifnull(sum(a.qty),0)
			from productstock a 
			where a.productid = a0.productid and a.unitofmeasureid = a2.unitofmeasureid and a.slocid = a3.slocid 
			) as qtystock
    from formrequestdet a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
		left join sloc a3 on a3.slocid = a0.slocid 
  ";
	public $sqlcount								 = "select count(1)
    from formrequest a0 
    left join company a1 on a1.companyid = a0.companyid
    left join sloc a3 on a3.slocid = a0.slocid
  ";
	public $sqlcountformrequestdet	 = "select count(1)
    from formrequestdet a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "where a0.productplanid is null and a0.recordstatus in (select b.wfbefstat
				from workflow a
				inner join wfgroup b on b.workflowid = a.workflowid
				inner join groupaccess c on c.groupaccessid = b.groupaccessid
				inner join usergroup d on d.groupaccessid = c.groupaccessid
				inner join useraccess e on e.useraccessid = d.useraccessid
				where upper(a.wfname) = upper('listda') and upper(e.username)=upper('".Yii::app()->user->name."')
				and
				a0.companyid in (select gm.menuvalueid from groupmenuauth gm
				inner join menuauth ma on ma.menuauthid = gm.menuauthid
				where upper(ma.menuobject) = upper('company') and gm.groupaccessid = c.groupaccessid)
				and 
				a0.useraccessid in (select gm.menuvalueid from groupmenuauth gm
				inner join menuauth ma on ma.menuauthid = gm.menuauthid
				where upper(ma.menuobject) = upper('useraccess') and gm.groupaccessid = c.groupaccessid)
				)";
		if ((isset($_REQUEST['frno'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['productplanno']))
			&& (isset($_REQUEST['sloccode']))) {
			$where .= " and a0.frno like '%".$_REQUEST['frno']."%'
and a1.companyname like '%".$_REQUEST['companyname']."%' 
and a2.productplanno like '%".$_REQUEST['productplanno']."%' 
and a3.sloccode like '%".$_REQUEST['sloccode']."%'";
		}
		if (isset($_REQUEST['formrequestid'])) {
			if (($_REQUEST['formrequestid'] !== '0') && ($_REQUEST['formrequestid'] !== '')) {
				$where .= " and a0.formrequestid in (".$_REQUEST['formrequestid'].")";
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
			'keyField' => 'formrequestid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'formrequestid', 'frdate', 'companyid', 'frno', 'productplanid', 'slocid', 'headernote',
					'recordstatus', 'useraccessid'
				),
				'defaultOrder' => array(
					'formrequestid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['formrequestid'])) {
			$this->sqlcountformrequestdet	 .= ' where a0.formrequestid = '.$_REQUEST['formrequestid'];
			$this->sqldataformrequestdet	 .= ' where a0.formrequestid = '.$_REQUEST['formrequestid'];
		}
		$countformrequestdet				 = Yii::app()->db->createCommand($this->sqlcountformrequestdet)->queryScalar();
		$dataProviderformrequestdet	 = new CSqlDataProvider($this->sqldataformrequestdet,
			array(
			'totalItemCount' => $countformrequestdet,
			'keyField' => 'formrequestdetid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'formrequestdetid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProviderformrequestdet' => $dataProviderformrequestdet));
	}
	public function actionGeneratefr() {
		if (isset($_POST['id'])) {
			if ($_POST['id'] !== '') {
				$connection	 = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				try {
					$sql		 = 'call GenerateSPP(:vid, :vslocid,:vhid)';
					$command = $connection->createCommand($sql);
					$command->bindvalue(':vid', $_POST['id'], PDO::PARAM_INT);
					$command->bindvalue(':vhid', $_POST['hid'], PDO::PARAM_INT);
					$command->bindvalue(':vslocid', $_POST['slocid'], PDO::PARAM_INT);
					$command->execute();
					$transaction->commit();
					getmessage('success', getCatalog('datagenerated'));
				} catch (Exception $e) { // an exception is raised if a query fails
					$transaction->rollBack();
					getMessage('failure', $e->getMessage());
				}
			}
		}
		Yii::app()->end();
	}
	public function actionCreate() {
		parent::actionCreate();
		$formrequestid = rand(-1, -1000000000);
		$company			 = getCompany();
		echo CJSON::encode(array(
			'status' => 'success',
			'formrequestid' => $formrequestid,
			'frdate' => date("Y-m-d"),
			'companyid' => $company['companyid'],
			'companyname' => $company['companyname'],
			'recordstatus' => $this->findstatusbyuser("insda")
		));
	}
	public function actionCreateformrequestdet() {
		parent::actionCreate();
		echo CJSON::encode(array(
			'status' => 'success',
			"qty" => 0,
			"poqty" => 0,
			"grqty" => 0,
			"tsqty" => 0
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			if (is_array($id)) {
				$id = $id[0];
			}
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.formrequestid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '') {
				if ($model !== null) {
					echo CJSON::encode(array(
						'status' => 'success',
						'formrequestid' => $model['formrequestid'],
						'frdate' => $model['frdate'],
						'companyid' => $model['companyid'],
						'productplanid' => $model['productplanid'],
						'slocid' => $model['slocid'],
						'headernote' => $model['headernote'],
						'recordstatus' => $model['recordstatus'],
						'companyname' => $model['companyname'],
						'productplanno' => $model['productplanno'],
						'sloccode' => $model['sloccode'],
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.formrequestid = '.$id)->queryRow();
			if ($model !== null) {
				echo CJSON::encode(array(
					'status' => 'success',
					'formrequestid' => $model['formrequestid'],
					'frno' => $model['frno'],
					'frdate' => $model['frdate'],
					'companyid' => $model['companyid'],
					'productplanid' => $model['productplanid'],
					'slocid' => $model['slocid'],
					'headernote' => $model['headernote'],
					'recordstatus' => $model['recordstatus'],
					'companyname' => $model['companyname'],
					'productplanno' => $model['productplanno'],
					'sloccode' => $model['sloccode'],
				));
				Yii::app()->end();
			}
		}
	}
	public function actionUpdateformrequestdet() {
		parent::actionUpdate();
		if (isset($_POST['id'])) {
			$id		 = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataformrequestdet.' where formrequestdetid = '.$id)->queryRow();
			if ($model !== null) {
				echo CJSON::encode(array(
					'status' => 'success',
					'formrequestdetid' => $model['formrequestdetid'],
					'formrequestid' => $model['formrequestid'],
					'productid' => $model['productid'],
					'qty' => $model['qty'],
					'unitofmeasureid' => $model['unitofmeasureid'],
					'itemtext' => $model['itemtext'],
					'productname' => $model['productname'],
					'uomcode' => $model['uomcode'],
					'slocid' => $model['slocid'],
					'sloccode' => $model['sloccode'],
					'reqdate' => $model['reqdate'],
				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('companyid', 'string', 'emptycompanyid'),
			array('slocid', 'string', 'emptyslocid'),
		));
		if ($error == false) {
			$id					 = $_POST['formrequestid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				$sql		 = 'call Insertformrequest (:actiontype
,:formrequestid
,:frdate
,:companyid
,:slocid
,:headernote
,:recordstatus,:vuseraccessid,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':actiontype', $_POST['actiontype'], PDO::PARAM_STR);
				$command->bindvalue(':formrequestid', $_POST['formrequestid'],
					PDO::PARAM_STR);
				$command->bindvalue(':frdate',
					(($_POST['frdate'] !== '') ? $_POST['frdate'] : null), PDO::PARAM_STR);
				$command->bindvalue(':companyid',
					(($_POST['companyid'] !== '') ? $_POST['companyid'] : null), PDO::PARAM_STR);
				$command->bindvalue(':slocid',
					(($_POST['slocid'] !== '') ? $_POST['slocid'] : null), PDO::PARAM_STR);
				$command->bindvalue(':headernote',
					(($_POST['headernote'] !== '') ? $_POST['headernote'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':recordstatus',
					(($_POST['recordstatus'] !== '') ? $_POST['recordstatus'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':vcreatedby', Yii::app()->user->id, PDO::PARAM_STR);
				$command->bindvalue(':vuseraccessid', getMyID(), PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				getMessage('success', 'alreadysaved');
			} catch (CDbException $e) {
				$transaction->rollBack();
				getMessage('error', $e->getMessage());
			}
		}
	}
	public function actionSaveformrequestdet() {
		parent::actionSave();
		$error = ValidateData(array(
			array('productid', 'string', 'emptyproductid'),
			array('unitofmeasureid', 'string', 'emptyuomid'),
		));
		if ($error == false) {
			$id					 = $_POST['formrequestdetid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				if ($id !== '') {
					$sql = 'update formrequestdet 
			      set formrequestid = :formrequestid,productid = :productid,qty = :qty,unitofmeasureid = :unitofmeasureid,itemtext = :itemtext,slocid=:slocid
			      where formrequestdetid = :formrequestdetid';
				} else {
					$sql = 'insert into formrequestdet (formrequestid,productid,qty,unitofmeasureid,itemtext,slocid) 
			      values (:formrequestid,:productid,:qty,:unitofmeasureid,:itemtext,:slocid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '') {
					$command->bindvalue(':formrequestdetid', $_POST['formrequestdetid'],
						PDO::PARAM_STR);
				}
				$command->bindvalue(':formrequestid',
					(($_POST['formrequestid'] !== '') ? $_POST['formrequestid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':productid',
					(($_POST['productid'] !== '') ? $_POST['productid'] : null), PDO::PARAM_STR);
				$command->bindvalue(':qty', (($_POST['qty'] !== '') ? $_POST['qty'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':unitofmeasureid',
					(($_POST['unitofmeasureid'] !== '') ? $_POST['unitofmeasureid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':itemtext',
					(($_POST['itemtext'] !== '') ? $_POST['itemtext'] : null), PDO::PARAM_STR);
				$command->bindvalue(':slocid',
					(($_POST['slocid'] !== '') ? $_POST['slocid'] : null), PDO::PARAM_STR);
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
				$sql		 = 'call Approveformreqpp(:vid,:vcreatedby)';
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
				$sql		 = 'call Deleteformreqpp(:vid,:vcreatedby)';
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
					$sql = "delete from formrequest where formrequestid = ".$id[$i];
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
	public function actionPurgeformrequestdet() {
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
					$sql = "delete from formrequestdet where formrequestdetid = ".$id[$i];
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
		$sql = "select a.companyid,a.frno,a.frdate,a.headernote,
				a.formrequestid,b.sloccode,b.description,a.recordstatus,c.productplanno,d.sono,e.productoutputno
      from formrequest a 
			left join productplan c on c.productplanid = a.productplanid 
			left join soheader d on d.soheaderid = c.soheaderid 
			left join productoutput e on e.productplanid = a.productplanid
			left join sloc b on b.slocid = a.slocid ";
		if ($_GET['formrequestid'] !== '') {
			$sql = $sql."where a.formrequestid in (".$_GET['formrequestid'].")";
		}
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($dataReader as $row) {
			$this->pdf->companyid = $row['companyid'];
		}
		$this->pdf->title = getCatalog('formrequest');
		$this->pdf->AddPage('P');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
		// definisi font

		foreach ($dataReader as $row) {
			$this->pdf->SetFontSize(8);
			$this->pdf->text(10, $this->pdf->gety() + 2, 'No ');
			$this->pdf->text(30, $this->pdf->gety() + 2, ': '.$row['frno']);
			$this->pdf->text(10, $this->pdf->gety() + 6, 'Tgl ');
			$this->pdf->text(30, $this->pdf->gety() + 6,
				': '.Yii::app()->format->formatDate($row['frdate']));
			$this->pdf->text(120, $this->pdf->gety() + 2, 'Gudang ');
			$this->pdf->text(150, $this->pdf->gety() + 2,
				': '.$row['sloccode'].' - '.$row['description']);

			$sql1				 = "select b.productname, sum(a.qty) as qty, c.uomcode, a.itemtext,concat(e.sloccode,' - ',e.description) as sloccode
        from formrequestdet a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
				left join sloc e on e.slocid = a.slocid
        where formrequestid = ".$row['formrequestid'].
				" group by b.productname,c.uomcode,e.sloccode ";
			$dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety() + 10);

			$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C');
			$this->pdf->setwidths(array(10, 60, 20, 15, 60, 25));
			$this->pdf->colheader			 = array('No', 'Items', 'Qty', 'Unit', 'Gd Tujuan', 'Remark');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L', 'L', 'R', 'C', 'L', 'L');
			$i												 = 0;
			foreach ($dataReader1 as $row1) {
				$i = $i + 1;
				$this->pdf->row(array($i, $row1['productname'],
					Yii::app()->format->formatNumber($row1['qty']),
					$row1['uomcode'],
					$row1['sloccode'],
					$row1['itemtext']));
			}

			$this->pdf->sety($this->pdf->gety());
			$this->pdf->colalign			 = array('C', 'C');
			$this->pdf->setwidths(array(30, 160));
			$this->pdf->iscustomborder = false;
			$this->pdf->setbordercell(array('none', 'none'));
			$this->pdf->coldetailalign = array('L', 'L');
			$this->pdf->row(array(
				'Note:',
				$row['headernote']
			));
			$this->pdf->checkNewPage(40);
//      $this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
			$this->pdf->sety($this->pdf->gety() + 10);
			$this->pdf->text(10, $this->pdf->gety(), 'Penerima');
			$this->pdf->text(50, $this->pdf->gety(), 'Mengetahui');
			$this->pdf->text(120, $this->pdf->gety(), 'Mengetahui Peminta');
			$this->pdf->text(170, $this->pdf->gety(), 'Peminta Barang');
			$this->pdf->text(10, $this->pdf->gety() + 15, '........................');
			$this->pdf->text(50, $this->pdf->gety() + 15, '........................');
			$this->pdf->text(120, $this->pdf->gety() + 15, '........................');
			$this->pdf->text(170, $this->pdf->gety() + 15, '........................');
		}
		$this->pdf->Output();
	}
}