<?php
class TaxController extends AdminController {
	protected $menuname	 = 'tax';
	public $module			 = 'Common';
	protected $pageTitle = 'Pajak';
	public $wfname			 = '';
	public $sqldata	 = "select a0.taxid,a0.taxcode,a0.taxvalue,a0.description,a0.recordstatus
    from tax a0 
  ";
	public $sqlcount	 = "select count(1)
    from tax a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $taxid = filterinput(2,'taxid',FILTER_SANITIZE_NUMBER_INT);
    $taxcode = filterinput(2, 'taxcode');
    $description = filterinput(2, 'description');
    $where .= " where coalesce(a0.taxcode,'') like '%".$taxcode."%'
      and coalesce(a0.description,'') like '%".$description."%'";
    if (($taxid !== '0') && ($taxid !== '')) {
      $where .= " and a0.taxid in (".$taxid.")";
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
			'keyField' => 'taxid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'taxid', 'taxcode', 'taxvalue', 'description', 'recordstatus'
				),
				'defaultOrder' => array(
					'taxid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index', array('dataProvider' => $dataProvider));
	}
	public function actionCreate() {
		parent::actionCreate();
		echo CJSON::encode(array(
			'status' => 'success',
			"taxvalue" => 0
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.taxid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'taxid' => $model['taxid'],
        'taxcode' => $model['taxcode'],
        'taxvalue' => $model['taxvalue'],
        'description' => $model['description'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('taxcode', 'string', 'emptytaxcode'),
			array('description', 'string', 'emptydescription'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'taxid',
				array(
				array(':taxid', 'taxid', PDO::PARAM_STR),
				array(':taxcode', 'taxcode', PDO::PARAM_STR),
				array(':taxvalue', 'taxvalue', PDO::PARAM_STR),
				array(':description', 'description', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'insert into tax (taxcode,taxvalue,description,recordstatus) 
			      values (:taxcode,:taxvalue,:description,:recordstatus)',
				'update tax 
			      set taxcode = :taxcode,taxvalue = :taxvalue,description = :description,recordstatus = :recordstatus 
			      where taxid = :taxid');
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
        $sql		 = "select recordstatus from tax where a0.taxid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update tax set recordstatus = 0 where a0.taxid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update tax set recordstatus = 1 where a0.taxid = ".$id;
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
        $sql = "delete from tax where taxid = ".$id;
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
		$this->pdf->title					 = getCatalog('tax');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('taxid'), getCatalog('taxcode'), getCatalog('description'),
			getCatalog('taxvalue'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 70, 40, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'R', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['taxid'], $row1['taxcode'], $row1['description'],
				$row1['taxvalue'], (($row1['recordstatus'] == 1) ? 'Active' : 'NotActive')));
		}
		$this->pdf->Output();
	}
}