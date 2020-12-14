<?php
class ProductdetailController extends AdminController {
	protected $menuname									 = 'productdetail';
	public $module											 = 'Stock';
	protected $pageTitle								 = 'Detail Stok Barang';
	public $wfname											 = '';
	public $sqldata									 = "select a0.productdetailid,a0.materialcode,a0.productid,a0.slocid,a0.storagebinid,a0.qty,a0.unitofmeasureid,a0.buydate,a0.expiredate,a0.buyprice,a0.currencyid,a0.location,a0.locationdate,a0.materialstatusid,a0.ownershipid,a0.referenceno,a0.vrqty,a0.serialno,a1.productname as productname,a2.sloccode as sloccode,a3.description as storagedesc,a4.uomcode as uomcode,a5.currencyname as currencyname,a6.materialstatusname as materialstatusname,a7.ownershipname as ownershipname,
			a9.materialgroupcode
    from productdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join sloc a2 on a2.slocid = a0.slocid
    left join storagebin a3 on a3.storagebinid = a0.storagebinid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid
    left join currency a5 on a5.currencyid = a0.currencyid
    left join materialstatus a6 on a6.materialstatusid = a0.materialstatusid
    left join ownership a7 on a7.ownershipid = a0.ownershipid
		left join productplant a8 on a8.productid = a0.productid and a8.unitofissue = a4.unitofmeasureid and a8.slocid = a2.slocid
		left join materialgroup a9 on a9.materialgroupid = a8.materialgroupid 
		
  ";
	public $sqldataproductdetailhist	 = "select a0.productdetailhistid,a0.slocid,a0.expiredate,a0.serialno,a0.qty,a0.unitofmeasureid,a0.buydate,a0.buyprice,a0.currencyid,a0.productid,a0.storagebinid,a0.location,a0.locationdate,a0.materialcode,a0.materialstatusid,a0.ownershipid,a0.referenceno,a0.productdetailid,a1.sloccode as sloccode,a2.uomcode as uomcode,a3.currencyname as currencyname,a4.productname as productname,a5.description as storagedesc,a6.materialstatusname as materialstatusname,a7.ownershipname as ownershipname
    from productdetailhist a0 
    left join sloc a1 on a1.slocid = a0.slocid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join currency a3 on a3.currencyid = a0.currencyid
    left join product a4 on a4.productid = a0.productid
    left join storagebin a5 on a5.storagebinid = a0.storagebinid
    left join materialstatus a6 on a6.materialstatusid = a0.materialstatusid
    left join ownership a7 on a7.ownershipid = a0.ownershipid
  ";
	public $sqlcount									 = "select count(1)
    from productdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join sloc a2 on a2.slocid = a0.slocid
    left join storagebin a3 on a3.storagebinid = a0.storagebinid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid
    left join currency a5 on a5.currencyid = a0.currencyid
    left join materialstatus a6 on a6.materialstatusid = a0.materialstatusid
    left join ownership a7 on a7.ownershipid = a0.ownershipid
		left join productplant a8 on a8.productid = a0.productid and a8.unitofissue = a4.unitofmeasureid and a8.slocid = a2.slocid
		left join materialgroup a9 on a9.materialgroupid = a8.materialgroupid 
  ";
	public $sqlcountproductdetailhist = "select count(1)
    from productdetailhist a0 
    left join sloc a1 on a1.slocid = a0.slocid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join currency a3 on a3.currencyid = a0.currencyid
    left join product a4 on a4.productid = a0.productid
    left join storagebin a5 on a5.storagebinid = a0.storagebinid
    left join materialstatus a6 on a6.materialstatusid = a0.materialstatusid
    left join ownership a7 on a7.ownershipid = a0.ownershipid
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $productdetailid = filterinput(2,'productdetailid',FILTER_SANITIZE_NUMBER_INT);
    $materialcode = filterinput(2,'materialcode');
    $materialgroupcode = filterinput(2,'materialgroupcode');
    $location = filterinput(2,'location');
    $referenceno = filterinput(2,'referenceno');
    $serialno = filterinput(2,'serialno');
    $productname = filterinput(2,'productname');
    $sloccode = filterinput(2,'sloccode');
    $storagedesc = filterinput(2,'storagedesc');
    $uomcode = filterinput(2,'uomcode');
    $currencyname = filterinput(2,'currencyname');
    $ownershipname = filterinput(2,'ownershipname');
    $where .= " where coalesce(a0.materialcode,'') like '%".$materialcode."%'
      and coalesce(a0.location,'') like '%".$location."%' 
      and coalesce(a0.referenceno,'') like '%".$referenceno."%' 
      and coalesce(a0.serialno,'') like '%".$serialno."%' 
      and coalesce(a1.productname,'') like '%".$productname."%' 
      and coalesce(a2.sloccode,'') like '%".$sloccode."%' 
      and coalesce(a3.description,'') like '%".$storagedesc."%' 
      and coalesce(a4.uomcode,'') like '%".$uomcode."%' 
      and coalesce(a9.materialgroupcode,'') like '%".$materialgroupcode."%' 
      and coalesce(a5.currencyname,'') like '%".$currencyname."%' 
      and coalesce(a7.ownershipname,'') like '%".$ownershipname."%'";
    if (($productdetailid !== '0') && ($productdetailid !== '')) {
      $where .= " and a0.productdetailid in (".$productdetailid.")";
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
			'keyField' => 'productdetailid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'productdetailid', 'materialcode', 'productid', 'slocid', 'storagebinid', 'qty',
					'unitofmeasureid', 'buydate', 'expiredate', 'buyprice', 'currencyid', 'location',
					'locationdate', 'materialstatusid', 'ownershipid', 'referenceno', 'vrqty', 'serialno',
					'materialgroupcode'
				),
				'defaultOrder' => array(
					'productdetailid' => CSort::SORT_DESC
				),
			),
		));
    $productdetailid = filterinput(2,'productdetailid',FILTER_SANITIZE_NUMBER_INT);
		if (($productdetailid!=='') && ($productdetailid !== '0')) {
			$this->sqlcountproductdetailhist .= ' where a0.productdetailid = '.$productdetailid;
			$this->sqldataproductdetailhist	 .= ' where a0.productdetailid = '.$productdetailid;
		}
		$countproductdetailhist				 = Yii::app()->db->createCommand($this->sqlcountproductdetailhist)->queryScalar();
		$dataProviderproductdetailhist = new CSqlDataProvider($this->sqldataproductdetailhist,
			array(
			'totalItemCount' => $countproductdetailhist,
			'keyField' => 'productdetailhistid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'productdetailhistid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProviderproductdetailhist' => $dataProviderproductdetailhist));
	}
	public function actionDownPDF() {
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader = Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title					 = getCatalog('productdetail');
		$this->pdf->AddPage('L');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C',
			'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('productdetailid'), getCatalog('materialcode'),
			getCatalog('product'), getCatalog('sloc'), getCatalog('storagebin'),
			getCatalog('qty'), getCatalog('unitofmeasure'), getCatalog('buydate'),
			getCatalog('expiredate'), getCatalog('buyprice'), getCatalog('currency'),
			getCatalog('location'), getCatalog('locationdate'), getCatalog('referenceno'));
		$this->pdf->setwidths(array(10, 25, 45, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17,
			25));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L', 'R', 'L', 'L', 'L',
			'R', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['productdetailid'], $row1['materialcode'],
				$row1['productname'], $row1['sloccode'], $row1['storagedesc'],
				Yii::app()->format->formatNumber($row1['qty']), $row1['uomcode'],
				Yii::app()->format->formatDate($row1['buydate']), Yii::app()->format->formatDate($row1['expiredate']),
				Yii::app()->format->formatNumber($row1['buyprice']), $row1['currencyname'], $row1['location'],
				Yii::app()->format->formatDate($row1['locationdate']), $row1['referenceno']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}