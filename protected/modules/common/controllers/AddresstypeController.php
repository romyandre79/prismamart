<?php
class AddresstypeController extends AdminController {
	protected $menuname	 = 'addresstype';
	public $module			 = 'Common';
	protected $pageTitle = 'Jenis Alamat';
	public $wfname			 = '';
	public $sqldata	 = "select a0.addresstypeid,a0.addresstypename,a0.recordstatus
    from addresstype a0 
  ";
	public $sqlcount	 = "select count(1)
    from addresstype a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $addresstypeid = filterinput(2, 'addresstypeid');
    $addresstypename = filterinput(2, 'addresstypename');
    $where .= " where coalesce(a0.addresstypename,'') like '%".$addresstypename."%'";
    if (($addresstypeid !== '0') && ($addresstypeid !== '')) {
      $where .= " and a0.addresstypeid in (".$addresstypeid.")";
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
			'keyField' => 'addresstypeid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'addresstypeid', 'addresstypename', 'recordstatus'
				),
				'defaultOrder' => array(
					'addresstypeid' => CSort::SORT_DESC
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where addresstypeid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'addresstypeid' => $model['addresstypeid'],
        'addresstypename' => $model['addresstypename'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('addresstypename', 'string', 'emptyaddresstypename'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'addresstypeid',
				array(
				array(':addresstypeid', 'addresstypeid', PDO::PARAM_STR),
				array(':addresstypename', 'addresstypename', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'insert into addresstype (addresstypename,recordstatus) 
			      values (:addresstypename,:recordstatus)',
				'update addresstype 
			      set addresstypename = :addresstypename,recordstatus = :recordstatus 
			      where addresstypeid = :addresstypeid');
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
        $sql		 = "select recordstatus from addresstype where addresstypeid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update addresstype set recordstatus = 0 where addresstypeid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update addresstype set recordstatus = 1 where addresstypeid = ".$id;
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
        $sql = "delete from addresstype where addresstypeid = ".$id;
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
		$this->pdf->title					 = getCatalog('addresstype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('addresstypeid'), getCatalog('addresstypename'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 90, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['addresstypeid'], $row1['addresstypename'], (($row1['recordstatus']
				== 1) ? 'Active' : 'NotActive')));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}