<?php
class MrpController extends AdminController {
	protected $menuname	 = 'mrp';
	public $module			 = 'Stock';
	protected $pageTitle = 'Material Requirement Planning';
	public $wfname			 = '';
	public $sqldata	 = "select a0.mrpid,a0.companyid,a0.productid,a0.slocid,a0.uomid,a0.minstock,a0.reordervalue,a0.maxvalue,a0.leadtime,a1.companyname as companyname,a2.productname as productname,a3.sloccode as sloccode,a4.uomcode as uomcode 
    from mrp a0 
    left join company a1 on a1.companyid = a0.companyid
    left join product a2 on a2.productid = a0.productid
    left join sloc a3 on a3.slocid = a0.slocid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.uomid
  ";
	public $sqlcount	 = "select count(1) 
    from mrp a0 
    left join company a1 on a1.companyid = a0.companyid
    left join product a2 on a2.productid = a0.productid
    left join sloc a3 on a3.slocid = a0.slocid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.uomid
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $mrpid = filterinput(2, 'mrpid' ,FILTER_SANITIZE_NUMBER_INT);
    $companyname = filterinput(2, 'companyname');
    $productname = filterinput(2, 'productname');
    $sloccode = filterinput(2, 'sloccode');
    $uomcode = filterinput(2, 'uomcode');
    $where .= " where coalesce(a1.companyname,'') like '%".$companyname."%' 
      and coalesce(a2.productname,'') like '%".$productname."%' 
      and coalesce(a3.sloccode,'') like '%".$sloccode."%' 
      and coalesce(a4.uomcode,'') like '%".$uomcode."%'";
    if (($mrpid !== '0') && ($mrpid !== '')) {
			$where .= " and a0.mrpid in (".$mrpid.")";
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
			'keyField' => 'mrpid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'mrpid', 'companyid', 'productid', 'slocid', 'uomid', 'minstock', 'reordervalue',
					'maxvalue', 'leadtime'
				),
				'defaultOrder' => array(
					'mrpid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index', array('dataProvider' => $dataProvider));
	}
	public function actionCreate() {
		parent::actionCreate();
		$company = getCompany();
		echo CJSON::encode(array(
			'status' => 'success',
			"companyid" => $company["companyid"], "companyname" => $company["companyname"],
			"minstock" => 0,
			"reordervalue" => 0,
			"maxvalue" => 0
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		$id = filterinput(1, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($id == '') {
			GetMessage('error', 'chooseone');
		}
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.mrpid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'mrpid' => $model['mrpid'],
        'companyid' => $model['companyid'],
        'productid' => $model['productid'],
        'slocid' => $model['slocid'],
        'uomid' => $model['uomid'],
        'minstock' => $model['minstock'],
        'reordervalue' => $model['reordervalue'],
        'maxvalue' => $model['maxvalue'],
        'leadtime' => $model['leadtime'],
        'companyname' => $model['companyname'],
        'productname' => $model['productname'],
        'sloccode' => $model['sloccode'],
        'uomcode' => $model['uomcode'],
      ));
      Yii::app()->end();
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('companyid', 'string', 'emptycompanyid'),
			array('productid', 'string', 'emptyproductid'),
			array('slocid', 'string', 'emptyslocid'),
			array('uomid', 'string', 'emptyuomid'),
			array('minstock', 'string', 'emptyminstock'),
			array('reordervalue', 'string', 'emptyreordervalue'),
			array('maxvalue', 'string', 'emptymaxvalue'),
			array('leadtime', 'string', 'emptyleadtime'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'mrpid',
				array(
				array(':mrpid', 'mrpid', PDO::PARAM_STR),
				array(':companyid', 'companyid', PDO::PARAM_STR),
				array(':productid', 'productid', PDO::PARAM_STR),
				array(':slocid', 'slocid', PDO::PARAM_STR),
				array(':uomid', 'uomid', PDO::PARAM_STR),
				array(':minstock', 'minstock', PDO::PARAM_STR),
				array(':reordervalue', 'reordervalue', PDO::PARAM_STR),
				array(':maxvalue', 'maxvalue', PDO::PARAM_STR),
				array(':leadtime', 'leadtime', PDO::PARAM_STR)
				),
				'insert into mrp (companyid,productid,slocid,uomid,minstock,reordervalue,`maxvalue`,leadtime)
			      values (:companyid,:productid,:slocid,:uomid,:minstock,:reordervalue,:maxvalue,:leadtime)',
				'update mrp 
			      set companyid = :companyid,productid = :productid,slocid = :slocid,uomid = :uomid,minstock = :minstock,reordervalue = :reordervalue,`maxvalue` = :maxvalue,leadtime = :leadtime
			      where mrpid = :mrpid');
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
        $sql = "delete from mrp where mrpid = ".$id;
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
		$this->pdf->title					 = getCatalog('mrp');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('mrpid'), getCatalog('company'),
			getCatalog('product'), getCatalog('sloc'), getCatalog('uom'),
			getCatalog('minstock'), getCatalog('reordervalue'), getCatalog('maxvalue'),
			getCatalog('leadtime'));
		$this->pdf->setwidths(array(10, 40, 40, 40, 40, 40, 40, 40, 40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['mrpid'], $row1['companyname'], $row1['productname'],
				$row1['sloccode'], $row1['uomcode'], $row1['minstock'], $row1['reordervalue'],
				$row1['maxvalue'], $row1['leadtime']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}