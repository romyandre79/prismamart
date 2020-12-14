<?php
class SlocController extends AdminController {
	protected $menuname						 = 'sloc';
	public $module								 = 'Common';
	protected $pageTitle					 = 'Gudang / Dept';
	public $wfname								 = '';
	public $sqldata						 = "select a0.slocid,a0.plantid,a0.sloccode,a0.description,a0.recordstatus,a1.plantcode as plantcode
    from sloc a0 
    left join plant a1 on a1.plantid = a0.plantid
  ";
	public $sqldatastoragebin	 = "select a0.storagebinid,a0.slocid,a0.description,a0.ismultiproduct,a0.qtymax,a0.recordstatus
    from storagebin a0 
  ";
	public $sqlcount						 = "select count(1)
    from sloc a0 
    left join plant a1 on a1.plantid = a0.plantid
  ";
	public $sqlcountstoragebin	 = "select count(1)
    from storagebin a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $slocid = filterinput(2, 'slocid');
    $sloccode = filterinput(2, 'sloccode');
    $plantcode = filterinput(2, 'plantcode');
    $description = filterinput(2, 'description');
    $where .= " where coalesce(a0.sloccode,'') like '%".$sloccode."%'
      and coalesce(a0.description,'') like '%".$description."%' 
      and coalesce(a1.plantcode,'') like '%".$plantcode."%'";
    if (($slocid !== '0') && ($slocid !== '')) {
			$where .= " and a0.slocid in (".$slocid.")";
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
			'keyField' => 'slocid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'slocid', 'plantid', 'sloccode', 'description', 'recordstatus'
				),
				'defaultOrder' => array(
					'slocid' => CSort::SORT_DESC
				),
			),
		));
    $slocid = filterinput(2,'slocid', FILTER_SANITIZE_NUMBER_INT);
		if (($slocid !== '0') && ($slocid !== '')) {
			$this->sqlcountstoragebin	 .= ' where a0.slocid = '.$slocid;
			$this->sqldatastoragebin	 .= ' where a0.slocid = '.$slocid;
		}
		$countstoragebin				 = Yii::app()->db->createCommand($this->sqlcountstoragebin)->queryScalar();
		$dataProviderstoragebin	 = new CSqlDataProvider($this->sqldatastoragebin,
			array(
			'totalItemCount' => $countstoragebin,
			'keyField' => 'storagebinid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'storagebinid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProviderstoragebin' => $dataProviderstoragebin));
	}
	public function actionCreate() {
		parent::actionCreate();
		$slocid = rand(-1, -1000000000);
		echo CJSON::encode(array(
			'status' => 'success',
			'slocid' => $slocid,
		));
	}
	public function actionCreatestoragebin() {
		parent::actionCreate();
		echo CJSON::encode(array(
			'status' => 'success',
			"qtymax" => 0
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.slocid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'slocid' => $model['slocid'],
        'plantid' => $model['plantid'],
        'sloccode' => $model['sloccode'],
        'description' => $model['description'],
        'recordstatus' => $model['recordstatus'],
        'plantcode' => $model['plantcode'],
      ));
      Yii::app()->end();
		}
	}
	public function actionUpdatestoragebin() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldatastoragebin.' where storagebinid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'storagebinid' => $model['storagebinid'],
        'slocid' => $model['slocid'],
        'description' => $model['description'],
        'ismultiproduct' => $model['ismultiproduct'],
        'qtymax' => $model['qtymax'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('plantid', 'string', 'emptyplantid'),
			array('sloccode', 'string', 'emptysloccode'),
			array('description', 'string', 'emptydescription')
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'slocid',
				array(
				array(':slocid', 'slocid', PDO::PARAM_STR),
				array(':actiontype', 'actiontype', PDO::PARAM_STR),
				array(':plantid', 'plantid', PDO::PARAM_STR),
				array(':sloccode', 'sloccode', PDO::PARAM_STR),
				array(':description', 'description', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				array(':vcreatedby', 'vcreatedby', PDO::PARAM_STR),
				),
				'call Insertsloc (:actiontype
          ,:slocid
          ,:plantid
          ,:sloccode
          ,:description
          ,:recordstatus,:vcreatedby)',
				'call Insertsloc (:actiontype
          ,:slocid
          ,:plantid
          ,:sloccode
          ,:description
          ,:recordstatus,:vcreatedby)');
		}
	}
	public function actionSavestoragebin() {
		parent::actionSave();
		$error = ValidateData(array(
			array('description', 'string', 'emptydescription'),
		));
		if ($error == false) {
			$id					 = $_POST['storagebinid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				if ($id !== '') {
					$sql = 'update storagebin 
			      set slocid = :slocid,description = :description,ismultiproduct = :ismultiproduct,qtymax = :qtymax,recordstatus = :recordstatus 
			      where storagebinid = :storagebinid';
				} else {
					$sql = 'insert into storagebin (slocid,description,ismultiproduct,qtymax,recordstatus) 
			      values (:slocid,:description,:ismultiproduct,:qtymax,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '') {
					$command->bindvalue(':storagebinid', $_POST['storagebinid'], PDO::PARAM_STR);
				}
				$command->bindvalue(':slocid',
					(($_POST['slocid'] !== '') ? $_POST['slocid'] : null), PDO::PARAM_STR);
				$command->bindvalue(':description',
					(($_POST['description'] !== '') ? $_POST['description'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':ismultiproduct',
					(($_POST['ismultiproduct'] !== '') ? $_POST['ismultiproduct'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':qtymax',
					(($_POST['qtymax'] !== '') ? $_POST['qtymax'] : null), PDO::PARAM_STR);
				$command->bindvalue(':recordstatus',
					(($_POST['recordstatus'] !== '') ? $_POST['recordstatus'] : null),
					PDO::PARAM_STR);
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
	public function actionDelete() {
		parent::actionDelete();
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
					$sql		 = "select recordstatus from sloc where slocid = ".$id[$i];
					$status	 = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1) {
						$sql = "update sloc set recordstatus = 0 where slocid = ".$id[$i];
					} else
					if ($status['recordstatus'] == 0) {
						$sql = "update sloc set recordstatus = 1 where slocid = ".$id[$i];
					}
					$connection->createCommand($sql)->execute();
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
					$sql = "delete from sloc where slocid = ".$id[$i];
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
	public function actionPurgestoragebin() {
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
					$sql = "delete from storagebin where storagebinid = ".$id[$i];
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
		$this->getSQL();
		$dataReader = Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title					 = getCatalog('sloc');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('slocid'), getCatalog('plant'),
			getCatalog('sloccode'),
			getCatalog('description'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 40, 40, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['slocid'], $row1['plantcode'], $row1['sloccode'],
				$row1['description'], $row1['recordstatus']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}