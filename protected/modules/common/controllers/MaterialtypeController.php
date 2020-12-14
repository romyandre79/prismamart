<?php
class MaterialtypeController extends AdminController {
	protected $menuname	 = 'materialtype';
	public $module			 = 'Common';
	protected $pageTitle = 'Jenis Material';
	public $wfname			 = '';
	public $sqldata	 = "select a0.materialtypeid,a0.materialtypecode,a0.description,a0.recordstatus
    from materialtype a0 
  ";
	public $sqlcount	 = "select count(1)
    from materialtype a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $materialtypeid = filterinput(2, 'materialtypeid');
    $materialtypecode = filterinput(2,'materialtypecode');
    $description = filterinput(2,'description');
    $where .= " where coalesce(a0.materialtypecode,'') like '%".$materialtypecode."%'
      and coalesce(a0.description,'') like '%".$description."%'";
    if (($materialtypeid !== '0') && ($materialtypeid !== '')) {
      $where .= " and a0.materialtypeid in (".$materialtypeid.")";
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
			'keyField' => 'materialtypeid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'materialtypeid', 'materialtypecode', 'description', 'recordstatus'
				),
				'defaultOrder' => array(
					'materialtypeid' => CSort::SORT_DESC
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.materialtypeid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'materialtypeid' => $model['materialtypeid'],
        'materialtypecode' => $model['materialtypecode'],
        'description' => $model['description'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('materialtypecode', 'string', 'emptymaterialtypecode'),
			array('description', 'string', 'emptydescription'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'materialtypeid',
				array(
				array(':materialtypeid', 'materialtypeid', PDO::PARAM_STR),
				array(':materialtypecode', 'materialtypecode', PDO::PARAM_STR),
				array(':description', 'description', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'insert into materialtype (materialtypecode,description,recordstatus) 
			      values (:materialtypecode,:description,:recordstatus)',
				'update materialtype 
			      set materialtypecode = :materialtypecode,description = :description,recordstatus = :recordstatus 
			      where materialtypeid = :materialtypeid');
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
        $sql		 = "select recordstatus from materialtype where a0.materialtypeid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update materialtype set recordstatus = 0 where a0.materialtypeid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update materialtype set recordstatus = 1 where a0.materialtypeid = ".$id;
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
        $sql = "delete from materialtype where materialtypeid = ".$id;
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
		$this->pdf->title					 = getCatalog('materialtype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('materialtypeid'), getCatalog('materialtypecode'),
			getCatalog('description'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 80, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['materialtypeid'], $row1['materialtypecode'], $row1['description'],
				(($row1['recordstatus'] == 1) ? 'Active' : 'NotActive')));
		}
		$this->pdf->Output();
	}
}