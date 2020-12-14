<?php
class UnitofmeasureController extends AdminController {
	protected $menuname	 = 'unitofmeasure';
	public $module			 = 'Common';
	protected $pageTitle = 'Satuan';
	public $wfname			 = '';
	public $sqldata	 = "select a0.unitofmeasureid,a0.uomcode,a0.description,a0.recordstatus
    from unitofmeasure a0 
  ";
	public $sqlcount	 = "select count(1)
    from unitofmeasure a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $uomid = filterinput(2,'unitofmeasureid',FILTER_SANITIZE_NUMBER_INT);
    $uomcode = filterinput(2,'uomcode');
    $description = filterinput(2,'description');
    $where .= " where coalesce(a0.uomcode,'') like '%".$uomcode."%'
      and coalesce(a0.description,'') like '%".$description."%'";
    if (($uomid !== '0') && ($uomid !== '')) {
      $where .= " and a0.unitofmeasureid in (".$uomid.")";
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
			'keyField' => 'unitofmeasureid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'unitofmeasureid', 'uomcode', 'description', 'recordstatus'
				),
				'defaultOrder' => array(
					'unitofmeasureid' => CSort::SORT_DESC
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.unitofmeasureid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'unitofmeasureid' => $model['unitofmeasureid'],
        'uomcode' => $model['uomcode'],
        'description' => $model['description'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('uomcode', 'string', 'emptyuomcode'),
			array('description', 'string', 'emptydescription'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'unitofmeasureid',
				array(
				array(':unitofmeasureid', 'unitofmeasureid', PDO::PARAM_STR),
				array(':uomcode', 'uomcode', PDO::PARAM_STR),
				array(':description', 'description', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'insert into unitofmeasure (uomcode,description,recordstatus) 
			      values (:uomcode,:description,:recordstatus)',
				'update unitofmeasure 
			      set uomcode = :uomcode,description = :description,recordstatus = :recordstatus 
			      where unitofmeasureid = :unitofmeasureid');
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
        $sql		 = "select recordstatus from unitofmeasure where a0.unitofmeasureid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update unitofmeasure set recordstatus = 0 where a0.unitofmeasureid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update unitofmeasure set recordstatus = 1 where a0.unitofmeasureid = ".$id;
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
        $sql = "delete from unitofmeasure where a0.unitofmeasureid = ".$id;
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
		$this->pdf->title					 = getCatalog('unitofmeasure');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('unitofmeasureid'), getCatalog('uomcode'),
			getCatalog('description'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 60, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['unitofmeasureid'], $row1['uomcode'], $row1['description'],
				(($row1['recordstatus'] == 1) ? 'Active' : 'NotActive')));
		}
		$this->pdf->Output();
	}
}