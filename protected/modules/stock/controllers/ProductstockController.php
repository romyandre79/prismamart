<?php
class ProductstockController extends AdminController {
	protected $menuname								 = 'productstock';
	public $module										 = 'Stock';
	protected $pageTitle							 = 'Stock Barang';
	public $wfname										 = '';
	public $sqldata								 = "select a0.productstockid,a0.productid,a0.slocid,a0.storagebinid,a0.qty,a0.unitofmeasureid,a0.qtyinprogress,a1.productname as productname,a2.sloccode as sloccode,a3.description as storagebindesc,a4.uomcode as uomcode,
			a6.materialgroupcode
    from productstock a0 
    join product a1 on a1.productid = a0.productid
    join sloc a2 on a2.slocid = a0.slocid
    join storagebin a3 on a3.storagebinid = a0.storagebinid
    join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid
		join productplant a5 on a5.productid = a1.productid and a5.unitofissue = a4.unitofmeasureid and a5.slocid = a0.slocid
		left join materialgroup a6 on a6.materialgroupid = a5.materialgroupid 
  ";
	public $sqldataproductstockdet	 = "select a0.productstockdetid,a0.productdetid,a0.qtydet,a0.uomdetid,a0.slocdetid,a0.referenceno,a0.productstockid,a0.storagebindetid,a0.transdate,a1.productname as productdetname,a2.uomcode as uomdetcode,a3.sloccode as sloccodedet,a4.description as storagebindesc
    from productstockdet a0 
    join product a1 on a1.productid = a0.productdetid
    join unitofmeasure a2 on a2.unitofmeasureid = a0.uomdetid
    join sloc a3 on a3.slocid = a0.slocdetid
    join storagebin a4 on a4.storagebinid = a0.storagebindetid
  ";
	public $sqlcount								 = "select count(1)
    from productstock a0 
    join product a1 on a1.productid = a0.productid
    join sloc a2 on a2.slocid = a0.slocid
    join storagebin a3 on a3.storagebinid = a0.storagebinid
    join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid
		join productplant a5 on a5.productid = a1.productid and a5.unitofissue = a4.unitofmeasureid and a5.slocid = a0.slocid
		left join materialgroup a6 on a6.materialgroupid = a5.materialgroupid 
  ";
	public $sqlcountproductstockdet = "select count(1)
    from productstockdet a0 
    join product a1 on a1.productid = a0.productdetid
    join unitofmeasure a2 on a2.unitofmeasureid = a0.uomdetid
    join sloc a3 on a3.slocid = a0.slocdetid
    join storagebin a4 on a4.storagebinid = a0.storagebindetid
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $productstockid = filterinput(2,'productstockid',FILTER_SANITIZE_NUMBER_INT);
    $productname = filterinput(2,'productname');
    $sloccode = filterinput(2,'sloccode');
    $uomcode = filterinput(2,'uomcode');
    $materialgroupcode = filterinput(2,'materialgroupcode');
    $materialgroupname = filterinput(2,'materialgroupname');
    $storagebindesc = filterinput(2,'storagebindesc');
    $where .= " where coalesce(a1.productname,'') like '%".$productname."%'
      and coalesce(a2.sloccode,'') like '%".$sloccode."%' 
      and coalesce(a3.description,'') like '%".$storagebindesc."%' 
      and coalesce(a4.uomcode,'') like '%".$uomcode."%'
      and coalesce(a6.materialgroupcode) like '%".$materialgroupcode."%'
      and coalesce(a6.description,'') like '%".$materialgroupname."%'
      ";
    if (($productstockid !== '0') && ($productstockid !== '')) {
      $where .= " and a0.productstockid in (".$productstockid.")";
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
			'keyField' => 'productstockid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'productstockid', 'productid', 'slocid', 'storagebinid', 'qty', 'unitofmeasureid',
					'qtyinprogress',
					'materialgroupcode'
				),
				'defaultOrder' => array(
					'productstockid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['productstockid'])) {
			$this->sqlcountproductstockdet .= ' where a0.productstockid = '.$_REQUEST['productstockid'];
			$this->sqldataproductstockdet	 .= ' where a0.productstockid = '.$_REQUEST['productstockid'];
		}
		$countproductstockdet				 = Yii::app()->db->createCommand($this->sqlcountproductstockdet)->queryScalar();
		$dataProviderproductstockdet = new CSqlDataProvider($this->sqldataproductstockdet,
			array(
			'totalItemCount' => $countproductstockdet,
			'keyField' => 'productstockdetid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'defaultOrder' => array(
					'productstockdetid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',
			array('dataProvider' => $dataProvider, 'dataProviderproductstockdet' => $dataProviderproductstockdet));
	}
	public function actionDownPDF() {
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader = Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title					 = getCatalog('productstock');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('productstockid'), getCatalog('product'),
			getCatalog('sloc'), getCatalog('storagebin'), getCatalog('qty'),
			getCatalog('unitofmeasure'), getCatalog('qtyinprogress'));
		$this->pdf->setwidths(array(10, 70, 30, 25, 20, 20, 20));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'C', 'C', 'R', 'L', 'R');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['productstockid'], $row1['productname'], $row1['sloccode'],
				$row1['storagebindesc'], $row1['qty'], $row1['uomcode'], $row1['qtyinprogress']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}