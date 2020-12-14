<?php
class IdentitytypeController extends AdminController {
	protected $menuname	 = 'identitytype';
	public $module			 = 'Common';
	protected $pageTitle = 'Jenis Identitas';
	public $wfname			 = '';
	public $sqldata	 = "select a0.identitytypeid,a0.identitytypename,a0.recordstatus
    from identitytype a0 
  ";
	public $sqlcount	 = "select count(1)
    from identitytype a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $identitytypeid = filterinput(2, 'identitytypeid');
    $identitytypename = filterinput(2, 'identitytypename');
		$where .= " where coalesce(a0.identitytypename,'') like '%".$identitytypename."%'";
    if (($identitytypeid !== '0') && ($identitytypeid !== '')) {
      $where .= " and a0.identitytypeid in (".$identitytypeid.")";
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
			'keyField' => 'identitytypeid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'identitytypeid', 'identitytypename', 'recordstatus'
				),
				'defaultOrder' => array(
					'identitytypeid' => CSort::SORT_DESC
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.identitytypeid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'identitytypeid' => $model['identitytypeid'],
        'identitytypename' => $model['identitytypename'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('identitytypename', 'string', 'emptyidentitytypename'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'identitytypeid',
				array(
				array(':identitytypeid', 'identitytypeid', PDO::PARAM_STR),
				array(':identitytypename', 'identitytypename', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'insert into identitytype (identitytypename,recordstatus) 
			      values (:identitytypename,:recordstatus)',
				'update identitytype 
			      set identitytypename = :identitytypename,recordstatus = :recordstatus 
			      where identitytypeid = :identitytypeid');
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
        $sql		 = "select recordstatus from identitytype where a0.identitytypeid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update identitytype set recordstatus = 0 where a0.identitytypeid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update identitytype set recordstatus = 1 where a0.identitytypeid = ".$id;
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
        $sql = "delete from identitytype where identitytypeid = ".$id;
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
		$this->pdf->title					 = getCatalog('identitytype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('identitytypeid'), getCatalog('identitytypename'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 100, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['identitytypeid'], $row1['identitytypename'], (($row1['recordstatus']
				== 1) ? 'Active' : 'NotActive')));
		}
		$this->pdf->Output();
	}
}