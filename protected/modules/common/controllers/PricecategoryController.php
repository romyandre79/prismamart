<?php
class PricecategoryController extends AdminController {
	protected $menuname	 = 'pricecategory';
	public $module			 = 'Common';
	protected $pageTitle = 'Kategori Harga';
	public $wfname			 = '';
	public $sqldata	 = "select a0.pricecategoryid,a0.categoryname,a0.recordstatus
    from pricecategory a0 
  ";
	public $sqlcount	 = "select count(1)
    from pricecategory a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
    $pricecategoryid = filterinput(2,'pricecategoryid',FILTER_SANITIZE_NUMBER_INT);
    $categoryname = filterinput(2,'categoryname');
    $where .= " where coalesce(a0.categoryname,'') like '%".$categoryname."%'";
    if (($pricecategoryid !== '0') && ($pricecategoryid !== '')) {
      $where .= " and a0.pricecategoryid in (".$pricecategoryid.")";
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
			'keyField' => 'pricecategoryid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'pricecategoryid', 'categoryname', 'recordstatus'
				),
				'defaultOrder' => array(
					'pricecategoryid' => CSort::SORT_DESC
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
    $model = Yii::app()->db->createCommand($this->sqldata.' where a0.pricecategoryid = '.$id)->queryRow();
    if ($model !== null) {
      echo CJSON::encode(array(
        'status' => 'success',
        'pricecategoryid' => $model['pricecategoryid'],
        'categoryname' => $model['categoryname'],
        'recordstatus' => $model['recordstatus'],
      ));
      Yii::app()->end();
    }
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('categoryname', 'string', 'emptycategoryname'),
		));
		if ($error == false) {
      ModifyCommand(1, $this->menuname, 'pricecategoryid',
				array(
				array(':pricecategoryid', 'pricecategoryid', PDO::PARAM_STR),
				array(':categoryname', 'categoryname', PDO::PARAM_STR),
				array(':recordstatus', 'recordstatus', PDO::PARAM_STR),
				),
				'insert into pricecategory (categoryname,recordstatus) 
			      values (:categoryname,:recordstatus)',
				'update pricecategory 
			      set categoryname = :categoryname,recordstatus = :recordstatus 
			      where pricecategoryid = :pricecategoryid');
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
        $sql		 = "select recordstatus from pricecategory where a0.pricecategoryid = ".$id;
        $status	 = Yii::app()->db->createCommand($sql)->queryRow();
        if ($status['recordstatus'] == 1) {
          $sql = "update pricecategory set recordstatus = 0 where a0.pricecategoryid = ".$id;
        } else
        if ($status['recordstatus'] == 0) {
          $sql = "update pricecategory set recordstatus = 1 where a0.pricecategoryid = ".$id;
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
        $sql = "delete from pricecategory where pricecategoryid = ".$id;
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
		$this->pdf->title					 = getCatalog('pricecategory');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('pricecategoryid'), getCatalog('categoryname'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 70, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L');
		foreach ($dataReader as $row1) {
			$this->pdf->row(array($row1['pricecategoryid'], $row1['categoryname'], (($row1['recordstatus']
				== 1) ? 'Active' : 'NotActive')));
		}
		$this->pdf->Output();
	}
}