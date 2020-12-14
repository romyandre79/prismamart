<?php
class ProductsalesController extends AdminController {
	protected $menuname	 = 'productsales';
	public $module			 = 'Common';
	protected $pageTitle = 'Material / Service Penjualan';
	public $wfname			 = '';
	public $sqldata	 = "select a0.productsalesid,a0.productid,a0.currencyid,a0.currencyvalue,a0.pricecategoryid,a0.uomid,a1.productname as productname,a2.currencyname as currencyname,a3.categoryname as categoryname,a4.uomcode as uomcode
    from productsales a0 
    left join product a1 on a1.productid = a0.productid
    left join currency a2 on a2.currencyid = a0.currencyid
    left join pricecategory a3 on a3.pricecategoryid = a0.pricecategoryid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.uomid
  ";
	public $sqlcount	 = "select count(1)
    from productsales a0 
    left join product a1 on a1.productid = a0.productid
    left join currency a2 on a2.currencyid = a0.currencyid
    left join pricecategory a3 on a3.pricecategoryid = a0.pricecategoryid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.uomid
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
		if ((isset($_REQUEST['productname'])) && (isset($_REQUEST['currencyname'])) && (isset($_REQUEST['categoryname']))
			&& (isset($_REQUEST['uomcode']))) {
			$where .= " where a1.productname like '%".$_REQUEST['productname']."%'
and a2.currencyname like '%".$_REQUEST['currencyname']."%' 
and a3.categoryname like '%".$_REQUEST['categoryname']."%' 
and a4.uomcode like '%".$_REQUEST['uomcode']."%'";
		}
		if (isset($_REQUEST['productsalesid'])) {
			if (($_REQUEST['productsalesid'] !== '0') && ($_REQUEST['productsalesid'] !== '')) {
				$where .= " and a0.productsalesid in (".$_REQUEST['productsalesid'].")";
			}
		}
		$this->sqldata = $this->sqldata.$where;
		$this->count	 = Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	public function actionGetPrice() {
		$sql			 = "select ifnull(currencyvalue,0)
			from productsales a 
			join addressbook b on b.pricecategoryid = a.pricecategoryid 
			where productid = ".$_REQUEST['productid']." and currencyid = ".$_REQUEST['currencyid']." 
			and a.uomid = ".$_REQUEST['unitofmeasureid']."
			and b.addressbookid = ".$_REQUEST['addressbookid'];
		$currvalue = Yii::app()->db->createCommand($sql)->queryScalar();
		echo CJSON::encode(array(
			'status' => 'success',
			'currencyvalue' => (($currvalue == null) ? 0 : $currvalue)
		));
	}
	public function actionIndex() {
		parent::actionIndex();
		$this->getSQL();
		$dataProvider = new CSqlDataProvider($this->sqldata,
			array(
			'totalItemCount' => $this->count,
			'keyField' => 'productsalesid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'productsalesid', 'productid', 'currencyid', 'currencyvalue', 'pricecategoryid',
					'uomid'
				),
				'defaultOrder' => array(
					'productsalesid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index', array('dataProvider' => $dataProvider));
	}
	public function actionCreate() {
		parent::actionCreate();

		echo CJSON::encode(array(
			'status' => 'success',
			"currencyid" => getparameter("basecurrencyid"), "currencyname" => getparameter("basecurrency"),
			"currencyvalue" => 0
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			if (is_array($id)) {
				$id = $id[0];
			}
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.productsalesid = '.$id)->queryRow();
			if ($model !== null) {
				echo CJSON::encode(array(
					'status' => 'success',
					'productsalesid' => $model['productsalesid'],
					'productid' => $model['productid'],
					'currencyid' => $model['currencyid'],
					'currencyvalue' => $model['currencyvalue'],
					'pricecategoryid' => $model['pricecategoryid'],
					'uomid' => $model['uomid'],
					'productname' => $model['productname'],
					'currencyname' => $model['currencyname'],
					'categoryname' => $model['categoryname'],
					'uomcode' => $model['uomcode'],
				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('productid', 'string', 'emptyproductid'),
			array('currencyid', 'string', 'emptycurrencyid'),
			array('pricecategoryid', 'string', 'emptypricecategoryid'),
			array('uomid', 'string', 'emptyuomid'),
		));
		if ($error == false) {
			$id					 = $_POST['productsalesid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				if ($id !== '') {
					$sql = 'update productsales 
			      set productid = :productid,currencyid = :currencyid,currencyvalue = :currencyvalue,pricecategoryid = :pricecategoryid,uomid = :uomid 
			      where productsalesid = :productsalesid';
				} else {
					$sql = 'insert into productsales (productid,currencyid,currencyvalue,pricecategoryid,uomid) 
			      values (:productid,:currencyid,:currencyvalue,:pricecategoryid,:uomid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '') {
					$command->bindvalue(':productsalesid', $_POST['productsalesid'],
						PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',
					(($_POST['productid'] !== '') ? $_POST['productid'] : null), PDO::PARAM_STR);
				$command->bindvalue(':currencyid',
					(($_POST['currencyid'] !== '') ? $_POST['currencyid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':currencyvalue',
					(($_POST['currencyvalue'] !== '') ? $_POST['currencyvalue'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':pricecategoryid',
					(($_POST['pricecategoryid'] !== '') ? $_POST['pricecategoryid'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':uomid',
					(($_POST['uomid'] !== '') ? $_POST['uomid'] : null), PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				Inserttranslog($command, $id, $this->menuname);
				getMessage('success', 'alreadysaved');
			} catch (CDbException $e) {
				$transaction->rollBack();
				getMessage('error', $e->getMessage());
			}
		}
	}
	public function actionPurge() {
		parent::actionPurge();
		$connection	 = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try {
			if (isset($_POST['id'])) {
				$id = $_POST['id'];
				if (!is_array($id)) {
					$ids[] = $id;
					$id		 = $ids;
				}
				for ($i = 0; $i < count($_POST['id']); $i++) {
					$sql = "delete from productsales where productsalesid = ".$id[$i];
					Yii::app()->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				getMessage('success', 'alreadysaved');
			} else {
				getMessage('success', 'chooseone');
			}
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
		$this->pdf->title					 = getCatalog('productsales');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('productsalesid'), getCatalog('product'),
			getCatalog('currency'), getCatalog('currencyvalue'), getCatalog('pricecategory'),
			getCatalog('uom'));
		$this->pdf->setwidths(array(10, 40, 40, 40, 40, 40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['productsalesid'], $row1['productname'], $row1['currencyname'],
				$row1['currencyvalue'], $row1['categoryname'], $row1['uomcode']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}