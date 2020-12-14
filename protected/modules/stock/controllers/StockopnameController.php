<?php
class StockopnameController extends AdminController {
	protected $menuname								 = 'stockopname';
	public $module										 = 'Stock';
	protected $pageTitle							 = 'Stok Opname';
	public $wfname										 = 'appbs';
	public $sqldata								 = "select a0.stockopnameid,a0.transdate,a0.slocid,a0.stockopnameno,a0.headernote,a0.recordstatus,a1.sloccode as sloccode,getwfstatusbywfname(a0.recordstatus,'appbs') as statusname
    from stockopname a0 
    left join sloc a1 on a1.slocid = a0.slocid
  ";
	public $sqldatastockopnamedet	 = "select a0.stockopnamedetid,a0.stockopnameid,a0.productid,a0.unitofmeasureid,a0.storagebinid,a0.qty,a0.buyprice,a0.buydate,a0.currencyid,a0.expiredate,a0.materialstatusid,a0.ownershipid,a0.serialno,a0.location,a0.itemnote,a1.productname as productname,a2.uomcode as uomcode,a3.description as storagebindesc,a4.currencyname as currencyname,a5.materialstatusname as materialstatusname,a6.ownershipname as ownershipname
    from stockopnamedet a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join storagebin a3 on a3.storagebinid = a0.storagebinid
    left join currency a4 on a4.currencyid = a0.currencyid
    left join materialstatus a5 on a5.materialstatusid = a0.materialstatusid
    left join ownership a6 on a6.ownershipid = a0.ownershipid
  ";
	public $sqlcount								 = "select count(1)
    from stockopname a0 
    left join sloc a1 on a1.slocid = a0.slocid
  ";
	public $sqlcountstockopnamedet	 = "select count(1)
    from stockopnamedet a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join storagebin a3 on a3.storagebinid = a0.storagebinid
    left join currency a4 on a4.currencyid = a0.currencyid
    left join materialstatus a5 on a5.materialstatusid = a0.materialstatusid
    left join ownership a6 on a6.ownershipid = a0.ownershipid
  ";
	public function actionGetProductPlant() {
		$uomid		 = '';
		$uomcode	 = '';
		$sloccode	 = '';
    $productid = filterinput(1,'productid',FILTER_SANITIZE_NUMBER_INT);
    $slocid = filterinput(1,'slocid',FILTER_SANITIZE_NUMBER_INT);
		if (($productid !== '') && ($slocid !== '')) {
			$prodplan	 = "select t.unitofissue,t.slocid,a.sloccode,b.uomcode
									from productplant t
									join sloc a on a.slocid = t.slocid
									join unitofmeasure b on b.unitofmeasureid = t.unitofissue
									where productid = ".$productid." and t.slocid = ".$slocid." 
									limit 1";
			$plant		 = Yii::app()->db->createCommand($prodplan)->queryRow();
		} else
		if ($productid !== '') {
			$prodplan	 = "select t.unitofissue,t.slocid,a.sloccode,b.uomcode
									from productplant t
									join sloc a on a.slocid = t.slocid
									join unitofmeasure b on b.unitofmeasureid = t.unitofissue
									where productid = ".$productid." and t.issource = 1
									limit 1";
			$plant		 = Yii::app()->db->createCommand($prodplan)->queryRow();
		}
    if ($plant !== null) {
      $uomid		 = $plant['unitofissue'];
      $uomcode	 = $plant['uomcode'];
      $slocid		 = $plant['slocid'];
      $sloccode	 = $plant['sloccode'];
    }
		echo CJSON::encode(array(
			'status' => 'success',
			'uomid' => $uomid,
			'uomcode' => $uomcode,
			'slocid' => $slocid,
			'sloccode' => $sloccode));
		Yii::app()->end();
	}
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "where a0.recordstatus in (select b.wfbefstat
				from workflow a
				inner join wfgroup b on b.workflowid = a.workflowid
				inner join groupaccess c on c.groupaccessid = b.groupaccessid
				inner join usergroup d on d.groupaccessid = c.groupaccessid
				inner join useraccess e on e.useraccessid = d.useraccessid
				where upper(a.wfname) = upper('listbs') and upper(e.username)=upper('".Yii::app()->user->name."')
				and
				a0.slocid in (select gm.menuvalueid from groupmenuauth gm
				inner join menuauth ma on ma.menuauthid = gm.menuauthid
				where upper(ma.menuobject) = upper('sloc') and gm.groupaccessid = c.groupaccessid))";
    $stockopnameid = filterinput(2,'stockopnameid',FILTER_SANITIZE_NUMBER_INT);
    $stockopnameno = filterinput(2,'stockopnameno');
    $sloccode = filterinput(2,'sloccode');
		$where .= " and coalesce(a0.stockopnameno,'') like '%".$stockopnameno."%'
      and coalesce(a1.sloccode,'') like '%".$sloccode."%'";
    if (($stockopnameid !== '0') && ($stockopnameid !== '')) {
      $where .= " and a0.stockopnameid in (".$stockopnameid.")";
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
			'keyField' => 'stockopnameid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'stockopnameid', 'transdate', 'slocid', 'stockopnameno', 'headernote', 'recordstatus'
				),
				'defaultOrder' => array(
					'stockopnameid' => CSort::SORT_DESC
				),
			),
		));
    $stockopnameid = filterinput(2, 'stockopnameid', FILTER_SANITIZE_NUMBER_INT);
		if (($stockopnameid !== '') && ($stockopnameid !== '0')) {
			$this->sqlcountstockopnamedet	 .= ' where a0.stockopnameid = '.$stockopnameid;
			$this->sqldatastockopnamedet	 .= ' where a0.stockopnameid = '.$stockopnameid;
		}
		$countstockopnamedet				 = Yii::app()->db->createCommand($this->sqlcountstockopnamedet)->queryScalar();
		$dataProviderstockopnamedet	 = new CSqlDataProvider($this->sqldatastockopnamedet,
			array(
			'totalItemCount' => $countstockopnamedet,
			'keyField' => 'stockopnamedetid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'stockopnamedetid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProviderstockopnamedet' => $dataProviderstockopnamedet));
	}
	public function actionCreate() {
		parent::actionCreate();
		$stockopnameid = rand(-1, -1000000000);
		echo CJSON::encode(array(
			'status' => 'success',
			'stockopnameid' => $stockopnameid,
			"transdate" => date("Y-m-d"),
			"recordstatus" => $this->findstatusbyuser("insbs")
		));
	}
	public function actionCreatestockopnamedet() {
		parent::actionCreate();
		echo CJSON::encode(array(
			'status' => 'success',
			"qty" => 0,
			"buyprice" => 0,
			"buydate" => date("Y-m-d"),
			"currencyid" => getparameter("basecurrencyid"),
			"currencyname" => getparameter("basecurrency"),
			"expiredate" => date("Y-m-d")
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldata.' where stockopnameid = '.$id)->queryRow();
    $s		 = $this->CheckDoc($model['recordstatus']);
    if ($s == '') {
      if ($model !== null) {
        echo CJSON::encode(array(
          'aa' => $this->CheckDoc($model['recordstatus']),
          'status' => 'success',
          'stockopnameid' => $model['stockopnameid'],
          'transdate' => $model['transdate'],
          'slocid' => $model['slocid'],
          'headernote' => $model['headernote'],
          'recordstatus' => $model['recordstatus'],
          'sloccode' => $model['sloccode'],
        ));
        Yii::app()->end();
      }
    } else {
      getMessage('error', getCatalog($s));
    }
	}
	public function actionUpdatestockopnamedet() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldatastockopnamedet.' where stockopnamedetid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'stockopnamedetid' => $model['stockopnamedetid'],
        'stockopnameid' => $model['stockopnameid'],
        'productid' => $model['productid'],
        'unitofmeasureid' => $model['unitofmeasureid'],
        'storagebinid' => $model['storagebinid'],
        'qty' => $model['qty'],
        'buyprice' => $model['buyprice'],
        'buydate' => $model['buydate'],
        'currencyid' => $model['currencyid'],
        'expiredate' => $model['expiredate'],
        'materialstatusid' => $model['materialstatusid'],
        'ownershipid' => $model['ownershipid'],
        'serialno' => $model['serialno'],
        'location' => $model['location'],
        'itemnote' => $model['itemnote'],
        'productname' => $model['productname'],
        'uomcode' => $model['uomcode'],
        'storagebindesc' => $model['storagebindesc'],
        'currencyname' => $model['currencyname'],
        'materialstatusname' => $model['materialstatusname'],
        'ownershipname' => $model['ownershipname'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('slocid', 'string', 'emptyslocid'),
			array('headernote', 'string', 'emptyheadernote')
		));
		if ($error == false) {
			$id					 = $_POST['stockopnameid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				$sql		 = 'call Insertstockopname (:actiontype
,:stockopnameid
,:transdate
,:slocid
,:headernote
,:recordstatus,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':actiontype', $_POST['actiontype'], PDO::PARAM_STR);
				$command->bindvalue(':stockopnameid', $_POST['stockopnameid'],
					PDO::PARAM_STR);
				$command->bindvalue(':transdate',
					(($_POST['transdate'] !== '') ? $_POST['transdate'] : null), PDO::PARAM_STR);
				$command->bindvalue(':slocid',
					(($_POST['slocid'] !== '') ? $_POST['slocid'] : null), PDO::PARAM_STR);
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
	public function actionSavestockopnamedet() {
		parent::actionSave();
		$error = ValidateData(array(
			array('productid', 'string', 'emptyproductid'),
			array('unitofmeasureid', 'string', 'emptyunitofmeasureid'),
			array('currencyid', 'string', 'emptycurrencyid'),
			array('materialstatusid', 'string', 'emptymaterialstatusid'),
			array('ownershipid', 'string', 'emptyownershipid'),
			array('location', 'string', 'emptylocation'),
		));
		if ($error == false) {
			$id					 = $_POST['stockopnamedetid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				if ($id !== '') {
					$sql = 'update stockopnamedet 
			      set stockopnameid = :stockopnameid,productid = :productid,unitofmeasureid = :unitofmeasureid,storagebinid = :storagebinid,qty = :qty,buyprice = :buyprice,buydate = :buydate,currencyid = :currencyid,expiredate = :expiredate,materialstatusid = :materialstatusid,ownershipid = :ownershipid,serialno = :serialno,location = :location,itemnote = :itemnote 
			      where stockopnamedetid = :stockopnamedetid';
				} else {
					$sql = 'insert into stockopnamedet (stockopnameid,productid,unitofmeasureid,storagebinid,qty,buyprice,buydate,currencyid,expiredate,materialstatusid,ownershipid,serialno,location,itemnote) 
			      values (:stockopnameid,:productid,:unitofmeasureid,:storagebinid,:qty,:buyprice,:buydate,:currencyid,:expiredate,:materialstatusid,:ownershipid,:serialno,:location,:itemnote)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '') {
					$command->bindvalue(':stockopnamedetid', $_POST['stockopnamedetid'],
						PDO::PARAM_STR);
				}
				$command->bindvalue(':stockopnameid',
					(($_POST['stockopnameid'] !== '') ? $_POST['stockopnameid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':productid',
					(($_POST['productid'] !== '') ? $_POST['productid'] : null), PDO::PARAM_STR);
				$command->bindvalue(':unitofmeasureid',
					(($_POST['unitofmeasureid'] !== '') ? $_POST['unitofmeasureid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':storagebinid',
					(($_POST['storagebinid'] !== '') ? $_POST['storagebinid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':qty', (($_POST['qty'] !== '') ? $_POST['qty'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':buyprice',
					(($_POST['buyprice'] !== '') ? $_POST['buyprice'] : null), PDO::PARAM_STR);
				$command->bindvalue(':buydate',
					(($_POST['buydate'] !== '') ? $_POST['buydate'] : null), PDO::PARAM_STR);
				$command->bindvalue(':currencyid',
					(($_POST['currencyid'] !== '') ? $_POST['currencyid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':expiredate',
					(($_POST['expiredate'] !== '') ? $_POST['expiredate'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':materialstatusid',
					(($_POST['materialstatusid'] !== '') ? $_POST['materialstatusid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':ownershipid',
					(($_POST['ownershipid'] !== '') ? $_POST['ownershipid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':serialno',
					(($_POST['serialno'] !== '') ? $_POST['serialno'] : null), PDO::PARAM_STR);
				$command->bindvalue(':location',
					(($_POST['location'] !== '') ? $_POST['location'] : null), PDO::PARAM_STR);
				$command->bindvalue(':itemnote',
					(($_POST['itemnote'] !== '') ? $_POST['itemnote'] : null), PDO::PARAM_STR);
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
				$sql		 = 'call Approvestockopname(:vid,:vcreatedby)';
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
				$sql		 = 'call Deletestockopname(:vid,:vcreatedby)';
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
					$sql = "delete from stockopname where stockopnameid = ".$id[$i];
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
	public function actionPurgestockopnamedet() {
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
				$sql = "delete from stockopnamedet where stockopnamedetid = ".$id[0];
				Yii::app()->db->createCommand($sql)->execute();
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
	public function actionDownPDF() {
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader = Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title					 = getCatalog('stockopname');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('stockopnameid'), getCatalog('transdate'),
			getCatalog('sloc'), getCatalog('stockopnameno'), getCatalog('headernote'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 40, 40, 40, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['stockopnameid'], $row1['transdate'], $row1['sloccode'],
				$row1['stockopnameno'], $row1['headernote'], $row1['recordstatus']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}