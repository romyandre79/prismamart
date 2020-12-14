<?php
class OwnershipController extends AdminController {
	protected $menuname	 = 'ownership';
	public $module			 = 'Common';
	protected $pageTitle = 'Kepemilikan';
	public $sqldata	 = 'select a0.ownershipid,a0.ownershipname,a0.recordstatus
    from ownership a0 
  ';
	public $sqlcount	 = 'select count(1)
    from ownership a0 
  ';
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = '';
    $ownershipid = filterinput(2, 'ownershipid',FILTER_SANITIZE_NUMBER_INT);
    $ownershipname = filterinput(2,'ownershipname');
    $where = " where coalesce(a0.ownershipname,'') like '%".$ownershipname."%'";
    if (($ownershipid !== '0') && ($ownershipid !== '')) {
      $where .= " and a0.ownershipid in (".$ownershipid.")";
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
			'keyField' => 'ownershipid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'ownershipid', 'ownershipname', 'recordstatus'
				),
				'defaultOrder' => array(
					'ownershipid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index', array('dataProvider' => $dataProvider));
	}
	public function actionCreate() {
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where ownershipid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'ownershipid' => $model['ownershipid'],
        'ownershipname' => $model['ownershipname'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('ownershipname', 'string', 'emptyownershipname'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'ownershipid',
				array(
				array(':ownershipid', 'ownershipid', PDO::PARAM_STR),
				array(':ownershipname', 'ownershipname', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR)
				),
				'insert into ownership (ownershipname,recordstatus) 
			      values (:ownershipname,:recordstatus)',
				'update ownership 
			      set ownershipname = :ownershipname,recordstatus = :recordstatus 
			      where ownershipid = :ownershipid');
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
				$sql		 = "select recordstatus from ownership where ownershipid = ".$id;
				$status	 = Yii::app()->db->createCommand($sql)->queryRow();
				if ($status['recordstatus'] == 1) {
					$sql = "update ownership set recordstatus = 0 where ownershipid = ".$id;
				} else
				if ($status['recordstatus'] == 0) {
					$sql = "update ownership set recordstatus = 1 where ownershipid = ".$id;
				}
      }
      $connection->createCommand($sql)->execute();
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
				$sql = "delete from ownership where ownershipid = ".$id;
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
		$this->pdf->title					 = getCatalog('ownership');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('ownershipid'), getCatalog('ownershipname'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['ownershipid'], $row1['ownershipname'], (($row1['recordstatus']
				== 1) ? 'Active' : 'NotActive')));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}