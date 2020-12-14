<?php
class AccperiodController extends AdminController {
	protected $menuname	 = 'accperiod';
	public $module			 = 'Common';
	protected $pageTitle = 'Periode Akuntansi';
	public $wfname			 = '';
	public $sqldata	 = "select a0.accperiodid,a0.period,a0.recordstatus
    from accperiod a0 
  ";
	public $sqlcount	 = "select count(1)
    from accperiod a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $accperiodid = filterinput(2, 'accperiodid');
    $period = filterinput(2, 'period');
		$where .= " where coalesce(a0.period,'') like '%".$period."%'";
    if (($accperiodid !== '0') && ($accperiodid !== '')) {
      $where .= " and a0.accperiodid in (".$accperiodid.")";
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
			'keyField' => 'accperiodid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'accperiodid', 'period', 'recordstatus'
				),
				'defaultOrder' => array(
					'accperiodid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index', array('dataProvider' => $dataProvider));
	}
	public function actionCreate() {
		parent::actionCreate();
		echo CJSON::encode(array(
			'status' => 'success',
			"period" => date("Y-m-d")
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldata.' where accperiodid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'accperiodid' => $model['accperiodid'],
        'period' => $model['period'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'accperiodid',
				array(
				array(':accperiodid', 'accperiodid', PDO::PARAM_STR),
				array(':period', 'period', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'insert into accperiod (period,recordstatus) 
			      values (:period,:recordstatus)',
				'update accperiod 
			      set period = :period,recordstatus = :recordstatus 
			      where accperiodid = :accperiodid');
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
        $sql		 = "select recordstatus from accperiod where accperiodid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update accperiod set recordstatus = 0 where accperiodid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update accperiod set recordstatus = 1 where accperiodid = ".$id;
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
        $sql = "delete from accperiod where accperiodid = ".$id;
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
		$this->pdf->title					 = getCatalog('accperiod');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('accperiodid'), getCatalog('period'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['accperiodid'], Yii::app()->format->formatDate($row1['period']),
				(($row1['recordstatus'] == 1) ? 'Active' : 'NotActive')));
		}
		$this->pdf->Output();
	}
}