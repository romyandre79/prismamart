<?php
class ProductController extends AdminController {
	protected $menuname							 = 'product';
	public $module									 = 'Common';
	protected $pageTitle						 = 'Material / Service';
	public $wfname									 = '';
  public $sqldata							 = "select a0.productid,a0.productcode,a0.productname,a0.productpic,a0.isstock,a0.barcode,a0.recordstatus,
      a0.sled,a0.isautolot,a2.uomcode,a1.materialgroupcode,a1.description as materialgroupdesc,a0.materialgroupid,a0.unitofissue
    from product a0 
    left join materialgroup a1 on a1.materialgroupid = a0.materialgroupid 
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofissue 
  ";
	public $sqldataproductplant	 = "select a0.productplantid,a0.productid,a0.slocid,a0.issource,a1.sloccode as sloccode
    from productplant a0 
    left join sloc a1 on a1.slocid = a0.slocid
  ";
	public $sqlcount							 = "select count(1)
    from product a0 
  ";
	public $sqlcountproductplant	 = "select count(1)
    from productplant a0 
    left join sloc a1 on a1.slocid = a0.slocid
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $productid = filterinput(2, 'productid');
    $productcode = filterinput(2,'productcode');
    $productname = filterinput(2,'productname');
    $barcode = filterinput(2,'barcode');
    $where .= " where coalesce(a0.productcode,'') like '%".$productcode."%'
      and coalesce(a0.productname,'') like '%".$productname."%'
      and coalesce(a0.barcode,'') like '%".$barcode."%'";
    if (($productid !== '0') && ($productid !== '')) {
			$where .= " and a0.productid in (".$productid.")";
		}
		$this->sqldata = $this->sqldata.$where;
		$this->count	 = Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	public function actionUpload() {
    if (!file_exists(Yii::getPathOfAlias('webroot').'/images/product/')) {
			mkdir(Yii::getPathOfAlias('webroot').'/images/product/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/product/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
	public function actionIndex() {
		parent::actionIndex();
		$this->getSQL();
		$dataProvider = new CSqlDataProvider($this->sqldata,
			array(
			'totalItemCount' => $this->count,
			'keyField' => 'productid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'productid', 'productcode', 'productname', 'productpic', 'isstock', 'barcode',
					'recordstatus'
				),
				'defaultOrder' => array(
					'productid' => CSort::SORT_DESC
				),
			),
		));
    $productid = filterinput(2, 'productid', FILTER_SANITIZE_NUMBER_INT);
		if (($productid !== '') && ($productid !== '0')) {
			$this->sqlcountproductplant	 .= ' where a0.productid = '.$productid;
			$this->sqldataproductplant	 .= ' where a0.productid = '.$productid;
		}
		$countproductplant				 = Yii::app()->db->createCommand($this->sqlcountproductplant)->queryScalar();
		$dataProviderproductplant	 = new CSqlDataProvider($this->sqldataproductplant,
			array(
			'totalItemCount' => $countproductplant,
			'keyField' => 'productplantid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'productplantid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProviderproductplant' => $dataProviderproductplant));
	}
	public function actionGetProductPlant() {
		$productid = filterinput(1,'productid',FILTER_SANITIZE_NUMBER_INT);
		$slocid		 = filterinput(1,'slocid', FILTER_SANITIZE_NUMBER_INT);
		$sell		 = filterinput(1,'sell');
		$sql			 = "select b.unitofmeasureid,b.uomcode,a.slocid,c.sloccode 
			from productplant a
			left join unitofmeasure b on b.unitofmeasureid = a.unitofissue
			left join sloc c on c.slocid = a.slocid 
			where productid = ".$productid;
		if (($slocid !== '') && ($slocid !== '0')) {
			$sql .= " and slocid = ".$slocid;
		} else 
			if ($sell !== '') {
			$sql .= " and issource <> 1 ";
		} else {
			$sql .= ' and issource = 1';
		}
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		echo CJSON::encode(array(
			'status' => 'success',
			'uomid' => $data['unitofmeasureid'],
			'uomcode' => $data['uomcode'],
			'slocid' => $data['slocid'],
			'sloccode' => $data['sloccode'],
		));
	}
	public function actionCreate() {
		parent::actionCreate();
		$productid = rand(-1, -1000000000);
		echo CJSON::encode(array(
			'status' => 'success',
			'productid' => $productid,
			"productpic" => "default.jpg"
		));
	}
	public function actionCreateproductplant() {
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.productid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'productid' => $model['productid'],
        'productcode' => $model['productcode'],
        'productname' => $model['productname'],
        'productpic' => $model['productpic'],
        'isstock' => $model['isstock'],
        'barcode' => $model['barcode'],
        'unitofissue' => $model['unitofissue'],
        'uomcode' => $model['uomcode'],
        'materialgroupid' => $model['materialgroupid'],
        'materialgroupcode' => $model['materialgroupcode'],
        'isautolot' => $model['isautolot'],
        'sled' => $model['sled'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionUpdateproductplant() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
			$model = Yii::app()->db->createCommand($this->sqldataproductplant.' where productplantid = '.$id)->queryRow();
			if ($model !== null) {
				echo CJSON::encode(array(
					'status' => 'success',
					'productplantid' => $model['productplantid'],
					'productid' => $model['productid'],
					'slocid' => $model['slocid'],
					'unitofissue' => $model['unitofissue'],
					'isautolot' => $model['isautolot'],
					'sled' => $model['sled'],
					'snroid' => $model['snroid'],
					'materialgroupid' => $model['materialgroupid'],
					'issource' => $model['issource'],
					'sloccode' => $model['sloccode'],
					'uomcode' => $model['uomcode'],
					'snrodesc' => $model['snrodesc'],
					'materialgroupcode' => $model['materialgroupcode'],
				));
				Yii::app()->end();
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('productcode', 'string', 'emptyproductcode'),
			array('productname', 'string', 'emptyproductname'),
			array('isstock', 'string', 'emptyisstock'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'productid',
				array(
				array(':productid', 'productid', PDO::PARAM_STR),
				array(':actiontype', 'actiontype', PDO::PARAM_STR),
				array(':productcode', 'productcode', PDO::PARAM_STR),
				array(':productname', 'productname', PDO::PARAM_STR),
				array(':productpic', 'productpic', PDO::PARAM_STR),
				array(':isstock', 'isstock', PDO::PARAM_STR),
				array(':barcode', 'barcode', PDO::PARAM_STR),
				array(':sled', 'sled', PDO::PARAM_STR),
				array(':unitofissue', 'unitofissue', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				array(':isautolot', 'isautolot', PDO::PARAM_STR),
				array(':materialgroupid', 'materialgroupid', PDO::PARAM_STR),
				array(':vcreatedby', 'vcreatedby', PDO::PARAM_STR)
				),
				'call Insertproduct (:actiontype
          ,:productid
          ,:productcode
          ,:productname
          ,:productpic
          ,:isstock
          ,:barcode
          ,:sled
          ,:unitofissue
          ,:isautolot
          ,:materialgroupid
          ,:recordstatus,:vcreatedby)',
        'call Insertproduct (:actiontype
          ,:productid
          ,:productcode
          ,:productname
          ,:productpic
          ,:isstock
          ,:barcode
          ,:sled
          ,:unitofissue
          ,:isautolot
          ,:materialgroupid
          ,:recordstatus,:vcreatedby)');
		}
	}
	public function actionSaveproductplant() {
		parent::actionSave();
		$error = ValidateData(array(
			array('productid', 'string', 'emptyproductid'),
			array('slocid', 'string', 'emptyslocid'),
			array('unitofissue', 'string', 'emptyunitofissue'),
			array('isautolot', 'string', 'emptyisautolot'),
			array('sled', 'string', 'emptysled'),
			array('snroid', 'string', 'emptysnroid'),
			array('materialgroupid', 'string', 'emptymaterialgroupid'),
			array('issource', 'string', 'emptyissource'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'productplantid',
				array(
				array(':productplantid', 'productplantid', PDO::PARAM_STR),
				array(':productid', 'productid', PDO::PARAM_STR),
				array(':slocid', 'slocid', PDO::PARAM_STR),
				array(':unitofissue', 'unitofissue', PDO::PARAM_STR),
				array(':isautolot', 'isautolot', PDO::PARAM_STR),
				array(':sled', 'sled', PDO::PARAM_STR),
				array(':snroid', 'snroid', PDO::PARAM_STR),
				array(':materialgroupid', 'materialgroupid', PDO::PARAM_STR),
				array(':issource', 'issource', PDO::PARAM_STR)
				),
				'insert into productplant (productid,slocid,unitofissue,isautolot,sled,snroid,materialgroupid,issource) 
			      values (:productid,:slocid,:unitofissue,:isautolot,:sled,:snroid,:materialgroupid,:issource)',
				'update productplant 
			      set productid = :productid,slocid = :slocid,unitofissue = :unitofissue,isautolot = :isautolot,sled = :sled,snroid = :snroid,materialgroupid = :materialgroupid,issource = :issource 
			      where productplantid = :productplantid');
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
        $sql		 = "select recordstatus from product where productid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update product set recordstatus = 0 where productid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update product set recordstatus = 1 where productid = ".$id;
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
        $sql = "delete from product where productid = ".$id;
        Yii::app()->db->createCommand($sql)->execute();
      }
      $transaction->commit();
      getMessage('success', 'alreadysaved');
		} catch (CDbException $e) {
			$transaction->rollback();
			getMessage('error', $e->getMessage());
		}
	}
	public function actionPurgeproductplant() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			$ids = filterinput(4,'id');
      if ($ids == '') {
        GetMessage('error', 'chooseone');
      }
      foreach ($ids as $id) {
        $sql = "delete from productplant where productplantid = ".$id;
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
		$this->pdf->title					 = getCatalog('product');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('productid'), getCatalog('productname'),
			getCatalog('productpic'), getCatalog('isstock'), getCatalog('barcode'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 40, 15, 40, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['productid'], $row1['productname'], $row1['productpic'],
				$row1['isstock'], $row1['barcode'], $row1['recordstatus']));
		}
		$this->pdf->Output();
	}
}