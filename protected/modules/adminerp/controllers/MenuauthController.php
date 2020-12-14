<?php
class MenuauthController extends AdminController {
	protected $menuname						 = 'menuauth';
	public $module								 = 'Adminerp';
	protected $pageTitle					 = 'Obyek Menu';
	public $wfname								 = '';
	public $sqldata								 = "select a0.menuauthid,a0.menuobject,a0.recordstatus,
		(select ifnull(count(1),0) from groupmenuauth z where z.menuauthid = a0.menuauthid ) as jumsub
    from menuauth a0 
  ";
	public $sqldatagroupmenuauth	 = "select a0.groupmenuauthid,a0.groupaccessid,a0.menuauthid,a0.menuvalueid,a1.groupname as groupname 
    from groupmenuauth a0 
    left join groupaccess a1 on a1.groupaccessid = a0.groupaccessid
  ";
	public $sqlcount							 = "select count(1) 
    from menuauth a0 
  ";
	public $sqlcountgroupmenuauth	 = "select count(1) 
    from groupmenuauth a0 
    left join groupaccess a1 on a1.groupaccessid = a0.groupaccessid
  ";
	public function getSQL() {
		$this->count		 = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where					 = "";
		$groupmenuauthid = filterinput(2, 'groupmenuauthid');
		$menuobject			 = filterinput(2, 'menuobject');
		$where					 .= " where coalesce(a0.menuobject,'') like '%".$menuobject."%'";
		if (($groupmenuauthid !== '0') && ($groupmenuauthid !== '')) {
			$where .= " and a0.groupmenuauthid in (".$groupmenuauthid.")";
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
			'keyField' => 'menuauthid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'menuauthid', 'menuobject', 'recordstatus'
				),
				'defaultOrder' => array(
					'menuauthid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['menuauthid'])) {
			$this->sqlcountgroupmenuauth .= ' where a0.menuauthid = '.$_REQUEST['menuauthid'];
			$this->sqldatagroupmenuauth	 .= ' where a0.menuauthid = '.$_REQUEST['menuauthid'];
		}
		$countgroupmenuauth				 = Yii::app()->db->createCommand($this->sqlcountgroupmenuauth)->queryScalar();
		$dataProvidergroupmenuauth = new CSqlDataProvider($this->sqldatagroupmenuauth,
			array(
			'totalItemCount' => $countgroupmenuauth,
			'keyField' => 'groupmenuauthid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'groupmenuauthid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProvidergroupmenuauth' => $dataProvidergroupmenuauth));
	}
	public function actionCreate() {
		parent::actionCreate();
		$menuauthid = rand(-1, -1000000000);
		echo CJSON::encode(array(
			'status' => 'success',
			'menuauthid' => $menuauthid,
		));
	}
	public function actionCreategroupmenuauth() {
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
		$model = Yii::app()->db->createCommand($this->sqldata.' where a0.menuauthid = '.$id)->queryRow();
		if ($model !== null) {
			echo CJSON::encode(array(
				'status' => 'success',
				'menuauthid' => $model['menuauthid'],
				'menuobject' => $model['menuobject'],
				'recordstatus' => $model['recordstatus'],
			));
			Yii::app()->end();
		}
	}
	public function actionUpdategroupmenuauth() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
		$model = Yii::app()->db->createCommand($this->sqldatagroupmenuauth.' where groupmenuauthid = '.$id)->queryRow();
		if ($model !== null) {
			echo CJSON::encode(array(
				'status' => 'success',
				'groupmenuauthid' => $model['groupmenuauthid'],
				'groupaccessid' => $model['groupaccessid'],
				'menuauthid' => $model['menuauthid'],
				'menuvalueid' => $model['menuvalueid'],
				'groupname' => $model['groupname'],
			));
			Yii::app()->end();
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = validatedata(array(
			array('menuobject', 'string', 'emptymenuobject'),
		));
		if ($error == false) {
			ModifyCommand(1, $this->menuname, 'menuauthid',
				array(
				array(':menuauthid', 'menuauthid', PDO::PARAM_STR),
				array(':actiontype', 'actiontype', PDO::PARAM_STR),
				array(':menuobject', 'menuobject', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				array(':vcreatedby', 'vcreatedby', PDO::PARAM_STR),
				),
				'call Insertmenuauth (:actiontype
					,:menuauthid
					,:menuobject
					,:recordstatus,:vcreatedby)',
				'call Insertmenuauth (:actiontype
					,:menuauthid
					,:menuobject
					,:recordstatus,:vcreatedby)');
		}
	}
	public function actionSavegroupmenuauth() {
		parent::actionSave();
		$error = validatedata(array(
			array('groupaccessid', 'string', 'emptygroupaccessid'),
			array('menuauthid', 'string', 'emptymenuauthid'),
			array('menuvalueid', 'string', 'emptymenuvalueid'),
		));
		if ($error == false) {
			ModifyCommand(1, $this->menuname, 'groupmenuauthid',
				array(
				array(':groupmenuauthid', 'groupmenuauthid', PDO::PARAM_STR),
				array(':groupaccessid', 'groupaccessid', PDO::PARAM_STR),
				array(':menuauthid', 'menuauthid', PDO::PARAM_STR),
				array(':menuvalueid', 'menuvalueid', PDO::PARAM_STR),
				),
				'insert into groupmenuauth (groupaccessid,menuauthid,menuvalueid)
			      values (:groupaccessid,:menuauthid,:menuvalueid)',
				'update groupmenuauth
			      set groupaccessid = :groupaccessid,menuauthid = :menuauthid,menuvalueid = :menuvalueid
			      where groupmenuauthid = :groupmenuauthid');
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
        $sql		 = "select recordstatus from menuauth where menuauthid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update menuauth set recordstatus = 0 where menuauthid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update menuauth set recordstatus = 1 where menuauthid = ".$id;
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
        $sql = "delete from menuauth where menuauthid = ".$id;
        Yii::app()->db->createCommand($sql)->execute();
      }
      $transaction->commit();
      getMessage('success', 'alreadysaved');
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionPurgegroupmenuauth() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			$ids = filterinput(4,'id');
      if ($ids == '') {
        GetMessage('error', 'chooseone');
      }
      foreach ($ids as $id) {
        $sql = "delete from groupmenuauth where groupmenuauthid = ".$id;
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
		$this->pdf->title					 = getCatalog('menuauth');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('menuauthid'), getCatalog('menuobject'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['menuauthid'], $row1['menuobject'], $row1['recordstatus']));
		}
		$this->pdf->Output();
	}
}