<?php
class WorkflowController extends AdminController {
	protected $menuname			 = 'workflow';
	public $module					 = 'Adminerp';
	protected $pageTitle		 = 'Alur Dokumen';
	public $wfname					 = '';
	public $sqldata					 = "select a0.workflowid,a0.wfname,a0.wfdesc,a0.wfminstat,a0.wfmaxstat,a0.recordstatus 
    from workflow a0 
  ";
	public $sqldatawfgroup	 = "select a0.wfgroupid,a0.workflowid,a0.groupaccessid,a0.wfbefstat,a0.wfrecstat,a1.groupname as groupname 
    from wfgroup a0 
    left join groupaccess a1 on a1.groupaccessid = a0.groupaccessid
  ";
	public $sqldatawfstatus	 = "select a0.wfstatusid,a0.workflowid,a0.wfstat,a0.wfstatusname 
    from wfstatus a0 
  ";
	public $sqlcount				 = "select count(1) 
    from workflow a0 
  ";
	public $sqlcountwfgroup	 = "select count(1) 
    from wfgroup a0 
    left join groupaccess a1 on a1.groupaccessid = a0.groupaccessid
  ";
	public $sqlcountwfstatus = "select count(1) 
    from wfstatus a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
		$workflowid	 = filterinput(2, 'workflowid');
		$wfname			 = filterinput(2, 'wfname');
		$wfdesc			 = filterinput(2, 'wfdesc');
		$where			 .= " where coalesce(a0.wfname,'') like '%".$wfname."%'
			and coalesce(a0.wfdesc,'') like '%".$wfdesc."%'";
		if (($workflowid !== '0') && ($workflowid !== '')) {
			$where .= " and a0.workflowid in (".$workflowid.")";
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
			'keyField' => 'workflowid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'workflowid', 'wfname', 'wfdesc', 'wfminstat', 'wfmaxstat', 'recordstatus'
				),
				'defaultOrder' => array(
					'workflowid' => CSort::SORT_DESC
				),
			),
		));
    $workflowid = filterinput(1,'workflowid',FILTER_SANITIZE_NUMBER_INT);
		if ($workflowid > 0) {
			$this->sqlcountwfgroup .= ' where a0.workflowid = '.$workflowid;
			$this->sqldatawfgroup	 .= ' where a0.workflowid = '.$workflowid;
		}
		$countwfgroup				 = Yii::app()->db->createCommand($this->sqlcountwfgroup)->queryScalar();
		$dataProviderwfgroup = new CSqlDataProvider($this->sqldatawfgroup,
			array(
			'totalItemCount' => $countwfgroup,
			'keyField' => 'wfgroupid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'wfgroupid' => CSort::SORT_DESC
				),
			),
		));
		if ($workflowid > 0) {
			$this->sqlcountwfstatus	 .= ' where a0.workflowid = '.$workflowid;
			$this->sqldatawfstatus	 .= ' where a0.workflowid = '.$workflowid;
		}
		$countwfstatus				 = Yii::app()->db->createCommand($this->sqlcountwfstatus)->queryScalar();
		$dataProviderwfstatus	 = new CSqlDataProvider($this->sqldatawfstatus,
			array(
			'totalItemCount' => $countwfstatus,
			'keyField' => 'wfstatusid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'wfstatusid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProviderwfgroup' => $dataProviderwfgroup,
			'dataProviderwfstatus' => $dataProviderwfstatus));
	}
	public function actionCreate() {
		parent::actionCreate();
		$workflowid = rand(-1, -1000000000);
		echo CJSON::encode(array(
			'status' => 'success',
			'workflowid' => $workflowid,
		));
	}
	public function actionCreatewfgroup() {
		parent::actionCreate();
		echo CJSON::encode(array(
			'status' => 'success',
		));
	}
	public function actionCreatewfstatus() {
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
		$model = Yii::app()->db->createCommand($this->sqldata.' where a0.workflowid = '.$id)->queryRow();
		if ($model !== null) {
			echo CJSON::encode(array(
				'status' => 'success',
				'workflowid' => $model['workflowid'],
				'wfname' => $model['wfname'],
				'wfdesc' => $model['wfdesc'],
				'wfminstat' => $model['wfminstat'],
				'wfmaxstat' => $model['wfmaxstat'],
				'recordstatus' => $model['recordstatus'],
			));
			Yii::app()->end();
		}
	}
	public function actionUpdatewfgroup() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
		$model = Yii::app()->db->createCommand($this->sqldatawfgroup.' where wfgroupid = '.$id)->queryRow();
		if ($model !== null) {
			echo CJSON::encode(array(
				'status' => 'success',
				'wfgroupid' => $model['wfgroupid'],
				'workflowid' => $model['workflowid'],
				'groupaccessid' => $model['groupaccessid'],
				'wfbefstat' => $model['wfbefstat'],
				'wfrecstat' => $model['wfrecstat'],
				'groupname' => $model['groupname'],
			));
			Yii::app()->end();
		}
	}
	public function actionUpdatewfstatus() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
		$model = Yii::app()->db->createCommand($this->sqldatawfstatus.' where wfstatusid = '.$id)->queryRow();
		if ($model !== null) {
			echo CJSON::encode(array(
				'status' => 'success',
				'wfstatusid' => $model['wfstatusid'],
				'workflowid' => $model['workflowid'],
				'wfstat' => $model['wfstat'],
				'wfstatusname' => $model['wfstatusname'],
			));
			Yii::app()->end();
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = validatedata(array(
			array('wfname', 'string', 'emptywfname'),
			array('wfdesc', 'string', 'emptywfdesc'),
			array('wfminstat', 'string', 'emptywfminstat'),
			array('wfmaxstat', 'string', 'emptywfmaxstat'),
		));
		if ($error == false) {
			ModifyCommand(1, $this->menuname, 'workflowid',
				array(
				array(':workflowid', 'workflowid', PDO::PARAM_STR),
				array(':actiontype', 'actiontype', PDO::PARAM_STR),
				array(':wfname', 'wfname', PDO::PARAM_STR),
				array(':wfdesc', 'wfdesc', PDO::PARAM_STR),
				array(':wfminstat', 'wfminstat', PDO::PARAM_STR),
				array(':wfmaxstat', 'wfmaxstat', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				array(':vcreatedby', 'vcreatedby', PDO::PARAM_STR),
				),
				'call Insertworkflow (:actiontype
					,:workflowid
					,:wfname
					,:wfdesc
					,:wfminstat
					,:wfmaxstat
					,:recordstatus,:vcreatedby)',
				'call Insertworkflow (:actiontype
					,:workflowid
					,:wfname
					,:wfdesc
					,:wfminstat
					,:wfmaxstat
					,:recordstatus,:vcreatedby)');
		}
	}
	public function actionSavewfgroup() {
		parent::actionSave();
		$error = validatedata(array(
			array('workflowid', 'string', 'emptyworkflowid'),
			array('groupaccessid', 'string', 'emptygroupaccessid'),
			array('wfbefstat', 'string', 'emptywfbefstat'),
			array('wfrecstat', 'string', 'emptywfrecstat'),
		));
		if ($error == false) {
			ModifyCommand(1, $this->menuname, 'wfgroupid',
				array(
				array(':wfgroupid', 'wfgroupid', PDO::PARAM_STR),
				array(':workflowid', 'workflowid', PDO::PARAM_STR),
				array(':groupaccessid', 'groupaccessid', PDO::PARAM_STR),
				array(':wfbefstat', 'wfbefstat', PDO::PARAM_STR),
				array(':wfrecstat', 'wfrecstat', PDO::PARAM_STR),
				),
				'insert into wfgroup (workflowid,groupaccessid,wfbefstat,wfrecstat)
			      values (:workflowid,:groupaccessid,:wfbefstat,:wfrecstat)',
				'update wfgroup
			      set workflowid = :workflowid,groupaccessid = :groupaccessid,wfbefstat = :wfbefstat,wfrecstat = :wfrecstat
			      where wfgroupid = :wfgroupid');
		}
	}
	public function actionSavewfstatus() {
		parent::actionSave();
		$error = validatedata(array(
			array('workflowid', 'string', 'emptyworkflowid'),
			array('wfstat', 'string', 'emptywfstat'),
			array('wfstatusname', 'string', 'emptywfstatusname'),
		));
		if ($error == false) {
			ModifyCommand(1, $this->menuname, 'wfstatusid',
				array(
				array(':wfstatusid', 'wfstatusid', PDO::PARAM_STR),
				array(':workflowid', 'workflowid', PDO::PARAM_STR),
				array(':wfstat', 'wfstat', PDO::PARAM_STR),
				array(':wfstatusname', 'wfstatusname', PDO::PARAM_STR)
				),
				'insert into wfstatus (workflowid,wfstat,wfstatusname)
			      values (:workflowid,:wfstat,:wfstatusname)',
				'update wfstatus
			      set workflowid = :workflowid,wfstat = :wfstat,wfstatusname = :wfstatusname
			      where wfstatusid = :wfstatusid');
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
        $sql		 = "select recordstatus from workflow where workflowid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update workflow set recordstatus = 0 where workflowid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update workflow set recordstatus = 1 where workflowid = ".$id;
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
        $sql = "delete from workflow where workflowid = ".$id;
        Yii::app()->db->createCommand($sql)->execute();
      }
      $transaction->commit();
      getMessage('success', 'alreadysaved');
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionPurgewfgroup() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			$ids = filterinput(4,'id');
      if ($ids == '') {
        GetMessage('error', 'chooseone');
      }
      foreach ($ids as $id) {
        $sql = "delete from wfgroup where wfgroupid = ".$id;
        Yii::app()->db->createCommand($sql)->execute();
      }
      $transaction->commit();
      getMessage('success', 'alreadysaved');
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionPurgewfstatus() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			$ids = filterinput(4,'id');
      if ($ids == '') {
        GetMessage('error', 'chooseone');
      }
      foreach ($ids as $id) {
        $sql = "delete from wfstatus where wfstatusid = ".$id;
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
		$this->pdf->title					 = getCatalog('workflow');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('workflowid'), getCatalog('wfname'),
			getCatalog('wfdesc'), getCatalog('wfminstat'), getCatalog('wfmaxstat'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 50, 30, 30, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['workflowid'], $row1['wfname'], $row1['wfdesc'], $row1['wfminstat'],
				$row1['wfmaxstat'], $row1['recordstatus']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}