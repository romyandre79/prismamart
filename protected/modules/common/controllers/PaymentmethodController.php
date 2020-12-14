<?php
class PaymentmethodController extends AdminController {
	protected $menuname	 = 'paymentmethod';
	public $module			 = 'Common';
	protected $pageTitle = 'Metode Pembayaran';
	public $wfname			 = '';
	public $sqldata	 = "select a0.paymentmethodid,a0.paycode,a0.paydays,a0.paymentname,a0.recordstatus
    from paymentmethod a0 
  ";
	public $sqlcount	 = "select count(1)
    from paymentmethod a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $paymentmethodid = filterinput(2, 'paymentmethodid');
    $paycode = filterinput(2, 'paycode');
    $paymentname = filterinput(2,'paymentname');
    $where .= " where coalesce(a0.paycode,'') like '%".$paycode."%'
      and coalesce(a0.paymentname,'') like '%".$paymentname."%'";
    if (($paymentmethodid !== '0') && ($paymentmethodid !== '')) {
      $where .= " and a0.paymentmethodid in (".$paymentmethodid.")";
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
			'keyField' => 'paymentmethodid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'paymentmethodid', 'paycode', 'paydays', 'paymentname', 'recordstatus'
				),
				'defaultOrder' => array(
					'paymentmethodid' => CSort::SORT_DESC
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.paymentmethodid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'paymentmethodid' => $model['paymentmethodid'],
        'paycode' => $model['paycode'],
        'paydays' => $model['paydays'],
        'paymentname' => $model['paymentname'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('paycode', 'string', 'emptypaycode'),
			array('paymentname', 'string', 'emptypaymentname'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'paymentmethodid',
				array(
				array(':paymentmethodid', 'paymentmethodid', PDO::PARAM_STR),
				array(':paycode', 'paycode', PDO::PARAM_STR),
				array(':paydays', 'paydays', PDO::PARAM_STR),
				array(':paymentname', 'paymentname', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'insert into paymentmethod (paycode,paydays,paymentname,recordstatus) 
			      values (:paycode,:paydays,:paymentname,:recordstatus)',
				'update paymentmethod 
			      set paycode = :paycode,paydays = :paydays,paymentname = :paymentname,recordstatus = :recordstatus 
			      where paymentmethodid = :paymentmethodid');	
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
        $sql		 = "select recordstatus from paymentmethod where a0.paymentmethodid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update paymentmethod set recordstatus = 0 where a0.paymentmethodid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update paymentmethod set recordstatus = 1 where a0.paymentmethodid = ".$id;
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
        $sql = "delete from paymentmethod where paymentmethodid = ".$id;
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
		$this->pdf->title					 = getCatalog('paymentmethod');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('paymentmethodid'), getCatalog('paycode'),
			getCatalog('paydays'), getCatalog('paymentname'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 30, 20, 100, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['paymentmethodid'], $row1['paycode'], $row1['paydays'],
				$row1['paymentname'],
				(($row1['recordstatus'] == 1) ? 'Active' : 'NotActive')));
		}
		$this->pdf->Output();
	}
}