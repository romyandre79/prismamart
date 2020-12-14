<?php
class ContacttypeController extends AdminController {
	protected $menuname	 = 'contacttype';
	public $module			 = 'Common';
	protected $pageTitle = 'Jenis Kontak';
	public $wfname			 = '';
	public $sqldata	 = "select a0.contacttypeid,a0.contacttypename,a0.recordstatus
    from contacttype a0 
  ";
	public $sqlcount	 = "select count(1)
    from contacttype a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $contacttypeid = filterinput(2,'contacttypeid');
    $contacttypename = filterinput(2,'contacttypename');
    $where .= " where coalesce(a0.contacttypename,'') like '%".$contacttypename."%'";
    if (($contacttypeid !== '0') && ($contacttypeid !== '')) {
      $where .= " and a0.contacttypeid in (".$contacttypeid.")";
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
			'keyField' => 'contacttypeid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'contacttypeid', 'contacttypename', 'recordstatus'
				),
				'defaultOrder' => array(
					'contacttypeid' => CSort::SORT_DESC
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.contacttypeid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'contacttypeid' => $model['contacttypeid'],
        'contacttypename' => $model['contacttypename'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('contacttypename', 'string', 'emptycontacttypename'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'contacttypeid',
				array(
				array(':contacttypeid', 'contacttypeid', PDO::PARAM_STR),
				array(':contacttypename', 'contacttypename', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR)
				),
				'insert into contacttype (contacttypename,recordstatus) 
			      values (:contacttypename,:recordstatus)',
				'update contacttype 
			      set contacttypename = :contacttypename,recordstatus = :recordstatus 
			      where contacttypeid = :contacttypeid');
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
        $sql		 = "select recordstatus from contacttype where a0.contacttypeid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update contacttype set recordstatus = 0 where a0.contacttypeid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update contacttype set recordstatus = 1 where a0.contacttypeid = ".$id;
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
        $sql = "delete from contacttype where contacttypeid = ".$id;
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
		$this->pdf->title					 = getCatalog('contacttype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('contacttypeid'), getCatalog('contacttypename'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 90, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['contacttypeid'], $row1['contacttypename'], (($row1['recordstatus']
				== 1) ? 'Active' : 'NotActive')));
		}
		$this->pdf->Output();
	}
}