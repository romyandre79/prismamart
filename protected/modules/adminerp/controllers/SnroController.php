<?php
class SnroController extends AdminController {
	protected $menuname			 = 'snro';
	public $module					 = 'Adminerp';
	protected $pageTitle		 = 'Sistem Penomoran';
	public $wfname					 = '';
	public $sqldata					 = "select a0.snroid,a0.description,a0.formatdoc,a0.formatno,a0.repeatby,a0.recordstatus 
    from snro a0 
  ";
	public $sqldatasnrodet	 = "select a0.snrodid,a0.snroid,a0.companyid,a0.curdd,a0.curmm,a0.curyy,a0.curvalue,a1.companyname as companyname 
    from snrodet a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
	public $sqlcount				 = "select count(1) 
    from snro a0 
  ";
	public $sqlcountsnrodet	 = "select count(1) 
    from snrodet a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
		$snroid			 = filterinput(2, 'snroid');
		$description = filterinput(2, 'description');
		$formatdoc	 = filterinput(2, 'formatdoc');
		$formatno		 = filterinput(2, 'formatno');
		$repeatby		 = filterinput(2, 'repeatby');
		$where			 .= " where coalesce(a0.description,'') like '%".$description."%'
			and coalesce(a0.formatdoc,'') like '%".$formatdoc."%'
			and coalesce(a0.formatno,'') like '%".$formatno."%'
			and coalesce(a0.repeatby,'') like '%".$repeatby."%'";
		if (($snroid !== '0') && ($snroid !== '')) {
			$where .= " and a0.snroid in (".$snroid.")";
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
			'keyField' => 'snroid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'snroid', 'description', 'formatdoc', 'formatno', 'repeatby', 'recordstatus'
				),
				'defaultOrder' => array(
					'snroid' => CSort::SORT_DESC
				),
			),
		));
    $snroid = filterinput(2, 'snroid', FILTER_SANITIZE_NUMBER_INT);
		if ($snroid > 0) {
			$this->sqlcountsnrodet .= ' where a0.snroid = '.$snroid;
			$this->sqldatasnrodet	 .= ' where a0.snroid = '.$snroid;
		}
		$countsnrodet				 = Yii::app()->db->createCommand($this->sqlcountsnrodet)->queryScalar();
		$dataProvidersnrodet = new CSqlDataProvider($this->sqldatasnrodet,
			array(
			'totalItemCount' => $countsnrodet,
			'keyField' => 'snrodid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'snrodid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProvidersnrodet' => $dataProvidersnrodet));
	}
	public function actionCreate() {
		parent::actionCreate();
		$snroid = rand(-1, -1000000000);
		echo CJSON::encode(array(
			'status' => 'success',
			'snroid' => $snroid,
		));
	}
	public function actionCreatesnrodet() {
		parent::actionCreate();
		$company = getCompany();
		echo CJSON::encode(array(
			'status' => 'success',
			"companyid" => $company["companyid"], "companyname" => $company["companyname"]
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.snroid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'snroid' => $model['snroid'],
        'description' => $model['description'],
        'formatdoc' => $model['formatdoc'],
        'formatno' => $model['formatno'],
        'repeatby' => $model['repeatby'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionUpdatesnrodet() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldatasnrodet.' where snrodid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'snrodid' => $model['snrodid'],
        'snroid' => $model['snroid'],
        'companyid' => $model['companyid'],
        'curdd' => $model['curdd'],
        'curmm' => $model['curmm'],
        'curyy' => $model['curyy'],
        'curvalue' => $model['curvalue'],
        'companyname' => $model['companyname'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = validatedata(array(
			array('description', 'string', 'emptydescription'),
			array('formatdoc', 'string', 'emptyformatdoc'),
			array('formatno', 'string', 'emptyformatno'),
			array('repeatby', 'string', 'emptyrepeatby'),
		));
		if ($error == false) {
			ModifyCommand(1, $this->menuname, 'snroid',
				array(
				array(':snroid', 'snroid', PDO::PARAM_STR),
				array(':actiontype', 'actiontype', PDO::PARAM_STR),
				array(':description', 'description', PDO::PARAM_STR),
				array(':formatdoc', 'formatdoc', PDO::PARAM_STR),
				array(':formatno', 'formatno', PDO::PARAM_STR),
				array(':repeatby', 'repeatby', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				array(':vcreatedby', 'vcreatedby', PDO::PARAM_STR),
				),
				'call Insertsnro (:actiontype
					,:snroid
					,:description
					,:formatdoc
					,:formatno
					,:repeatby
					,:recordstatus,:vcreatedby)',
				'call Insertsnro (:actiontype
					,:snroid
					,:description
					,:formatdoc
					,:formatno
					,:repeatby
					,:recordstatus,:vcreatedby)');
		}
	}
	public function actionSavesnrodet() {
		parent::actionSave();
		$error = validatedata(array(
			array('companyid', 'string', 'emptycompanyid'),
		));
		if ($error == false) {
			ModifyCommand(1, $this->menuname, 'snrodid',
				array(
				array(':snrodid', 'snrodid', PDO::PARAM_STR),
				array(':snroid', 'snroid', PDO::PARAM_STR),
				array(':companyid', 'companyid', PDO::PARAM_STR),
				array(':curdd', 'curdd', PDO::PARAM_STR),
				array(':curmm', 'curmm', PDO::PARAM_STR),
				array(':curyy', 'curyy', PDO::PARAM_STR),
				array(':curvalue', 'curvalue', PDO::PARAM_STR),
				),
				'insert into snrodet (snroid,companyid,curdd,curmm,curyy,curvalue)
			      values (:snroid,:companyid,:curdd,:curmm,:curyy,:curvalue)',
				'update snrodet
			      set snroid = :snroid,companyid = :companyid,curdd = :curdd,curmm = :curmm,curyy = :curyy,curvalue = :curvalue
			      where snrodid = :snrodid');
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
        $sql		 = "select recordstatus from snro where snroid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update snro set recordstatus = 0 where snroid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update snro set recordstatus = 1 where snroid = ".$id;
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
        $sql = "delete from snro where snroid = ".$id;
        Yii::app()->db->createCommand($sql)->execute();
      }
      $transaction->commit();
      getMessage('success', 'alreadysaved');
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionPurgesnrodet() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			$ids = filterinput(4,'id');
      if ($ids == '') {
        GetMessage('error', 'chooseone');
      }
      foreach ($ids as $id) {
        $sql = "delete from snrodet where snrodid = ".$id;
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
		$this->pdf->title					 = getCatalog('snro');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('snroid'), getCatalog('description'),
			getCatalog('formatdoc'), getCatalog('formatno'), getCatalog('repeatby'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 45, 50, 20, 40, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['snroid'], $row1['description'], $row1['formatdoc'],
				$row1['formatno'], $row1['repeatby'], $row1['recordstatus']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}