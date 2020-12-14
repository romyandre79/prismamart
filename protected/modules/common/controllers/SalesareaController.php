<?php
class SalesareaController extends AdminController {
	protected $menuname	 = 'salesarea';
	public $module			 = 'Common';
	protected $pageTitle = 'Area Penjualan';
	public $wfname			 = '';
	public $sqldata	 = "select a0.salesareaid,a0.areaname,a0.recordstatus
    from salesarea a0 
  ";
	public $sqlcount	 = "select count(1)
    from salesarea a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $salesareaid = filterinput(2,'salesareaid',FILTER_SANITIZE_NUMBER_INT);
    $areaname = filterinput(2,'areaname');
    $where .= " where coalesce(a0.areaname,'') like '%".$areaname."%'";
    if (($salesareaid !== '0') && ($salesareaid !== '')) {
      $where .= " and a0.salesareaid in (".$salesareaid.")";
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
			'keyField' => 'salesareaid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'salesareaid', 'areaname', 'recordstatus'
				),
				'defaultOrder' => array(
					'salesareaid' => CSort::SORT_DESC
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.salesareaid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'salesareaid' => $model['salesareaid'],
        'areaname' => $model['areaname'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('areaname', 'string', 'emptyareaname'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'salesareaid',
				array(
				array(':salesareaid', 'salesareaid', PDO::PARAM_STR),
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
				'insert into salesarea (areaname,recordstatus) 
			      values (:areaname,:recordstatus)',
				'update salesarea 
			      set areaname = :areaname,recordstatus = :recordstatus 
			      where salesareaid = :salesareaid');
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
        $sql		 = "select recordstatus from salesarea where a0.salesareaid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update salesarea set recordstatus = 0 where a0.salesareaid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update salesarea set recordstatus = 1 where a0.salesareaid = ".$id;
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
        $sql = "delete from salesarea where salesareaid = ".$id;
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
		$this->pdf->title					 = getCatalog('salesarea');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('salesareaid'), getCatalog('areaname'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 80, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['salesareaid'], $row1['areaname'], (($row1['recordstatus']
				== 1) ? 'Active' : 'NotActive')));
		}
		$this->pdf->Output();
	}
}