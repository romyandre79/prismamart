<?php
class MaterialgroupController extends AdminController {
	protected $menuname	 = 'materialgroup';
	public $module			 = 'Common';
	protected $pageTitle = 'Grup Material';
	public $wfname			 = '';
	public $sqldata	 = "select a0.materialgroupid,a0.materialgroupcode,a0.description,a0.materialtypeid,a0.recordstatus,a1.materialtypecode as materialtypecode,
    a0.slug,a0.materialgrouppic
    from materialgroup a0 
    left join materialtype a1 on a1.materialtypeid = a0.materialtypeid
  ";
	public $sqlcount	 = "select count(1)
    from materialgroup a0 
    left join materialtype a1 on a1.materialtypeid = a0.materialtypeid
  ";
	public function actionUpload() {
    if (!file_exists(Yii::getPathOfAlias('webroot').'/images/materialgroup/')) {
			mkdir(Yii::getPathOfAlias('webroot').'/images/materialgroup/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/materialgroup/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $materialgroupid = filterinput(2,'materialgroupid',FILTER_SANITIZE_NUMBER_INT);
    $materialgroupcode = filterinput(2,'materialgroupcode');
    $materialtypecode = filterinput(2,'materialtypecode');
    $description = filterinput(2,'description');
    $where .= " where coalesce(a0.materialgroupcode,'') like '%".$materialgroupcode."%'
      and coalesce(a0.description,'') like '%".$description."%' 
      and coalesce(a1.materialtypecode,'') like '%".$materialtypecode."%'";
    if (($materialgroupid !== '0') && ($materialgroupid !== '')) {
      $where .= " and a0.materialgroupid in (".$_REQUEST['materialgroupid'].")";
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
			'keyField' => 'materialgroupid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'materialgroupid', 'materialgroupcode', 'description', 'materialtypeid', 'slug',
					'recordstatus'
				),
				'defaultOrder' => array(
					'materialgroupid' => CSort::SORT_DESC
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.materialgroupid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'materialgroupid' => $model['materialgroupid'],
        'materialgroupcode' => $model['materialgroupcode'],
        'description' => $model['description'],
        'materialtypeid' => $model['materialtypeid'],
        'recordstatus' => $model['recordstatus'],
        'materialtypecode' => $model['materialtypecode'],
        'slug' => $model['slug'],
        'materialgrouppic' => $model['materialgrouppic'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('materialgroupcode', 'string', 'emptymaterialgroupcode'),
			array('description', 'string', 'emptydescription'),
			array('materialtypeid', 'string', 'emptymaterialtypeid'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'materialgroupid',
				array(
				array(':materialgroupid', 'materialgroupid', PDO::PARAM_STR),
				array(':materialgroupcode', 'materialgroupcode', PDO::PARAM_STR),
				array(':description', 'description', PDO::PARAM_STR),
				array(':materialtypeid', 'materialtypeid', PDO::PARAM_STR),
				array(':slug', 'slug', PDO::PARAM_STR),
				array(':materialgrouppic', 'materialgrouppic', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'insert into materialgroup (materialgroupcode,description,materialtypeid,recordstatus,slug,materialgrouppic) 
			      values (:materialgroupcode,:description,:materialtypeid,:recordstatus,:slug,:materialgrouppic)',
				'update materialgroup 
			      set materialgroupcode = :materialgroupcode,description = :description,materialtypeid = :materialtypeid,recordstatus = :recordstatus,
              slug = :slug, materialgrouppic = :materialgrouppic
			      where materialgroupid = :materialgroupid');
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
        $sql		 = "select recordstatus from materialgroup where a0.materialgroupid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update materialgroup set recordstatus = 0 where a0.materialgroupid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update materialgroup set recordstatus = 1 where a0.materialgroupid = ".$id;
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
        $sql = "delete from materialgroup where materialgroupid = ".$id;
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
		$this->pdf->title					 = getCatalog('materialgroup');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('materialgroupid'), getCatalog('materialgroupcode'),
			getCatalog('description'), getCatalog('materialtype'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 40, 80, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['materialgroupid'], $row1['materialtypecode'], $row1['materialgroupcode'],
				$row1['description'], (($row1['recordstatus'] == 1) ? 'Active' : 'NotActive')));
		}
		$this->pdf->Output();
	}
}