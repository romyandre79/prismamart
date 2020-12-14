<?php
class MaterialstatusController extends AdminController {
	protected $menuname	 = 'materialstatus';
	public $module			 = 'Common';
	protected $pageTitle = 'Status Material';
	public $wfname			 = '';
	public $sqldata	 = "select a0.materialstatusid,a0.materialstatusname,a0.recordstatus
    from materialstatus a0 
  ";
	public $sqlcount	 = "select count(1)
    from materialstatus a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
		if ((isset($_REQUEST['materialstatusname']))) {
			$where .= " where a0.materialstatusname like '%".$_REQUEST['materialstatusname']."%'";
		}
		if (isset($_REQUEST['materialstatusid'])) {
			if (($_REQUEST['materialstatusid'] !== '0') && ($_REQUEST['materialstatusid']
				!== '')) {
				$where .= " and a0.materialstatusid in (".$_REQUEST['materialstatusid'].")";
			}
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
			'keyField' => 'materialstatusid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'materialstatusid', 'materialstatusname', 'recordstatus'
				),
				'defaultOrder' => array(
					'materialstatusid' => CSort::SORT_DESC
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
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			if (is_array($id)) {
				$id = $id[0];
			}
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.materialstatusid = '.$id)->queryRow();
			if ($model !== null) {
				echo CJSON::encode(array(
					'status' => 'success',
					'materialstatusid' => $model['materialstatusid'],
					'materialstatusname' => $model['materialstatusname'],
					'recordstatus' => $model['recordstatus'],
				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('materialstatusname', 'string', 'emptymaterialstatusname'),
		));
		if ($error == false) {
			$id					 = $_POST['materialstatusid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				if ($id !== '') {
					$sql = 'update materialstatus 
			      set materialstatusname = :materialstatusname,recordstatus = :recordstatus 
			      where materialstatusid = :materialstatusid';
				} else {
					$sql = 'insert into materialstatus (materialstatusname,recordstatus) 
			      values (:materialstatusname,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '') {
					$command->bindvalue(':materialstatusid', $_POST['materialstatusid'],
						PDO::PARAM_STR);
				}
				$command->bindvalue(':materialstatusname',
					(($_POST['materialstatusname'] !== '') ? $_POST['materialstatusname'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':recordstatus',
					(($_POST['recordstatus'] !== '') ? $_POST['recordstatus'] : null),
					PDO::PARAM_STR);
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
	public function actionDelete() {
		parent::actionDelete();
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
					$sql		 = "select recordstatus from materialstatus where a0.materialstatusid = ".$id[$i];
					$status	 = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1) {
						$sql = "update materialstatus set recordstatus = 0 where a0.materialstatusid = ".$id[$i];
					} else
					if ($status['recordstatus'] == 0) {
						$sql = "update materialstatus set recordstatus = 1 where a0.materialstatusid = ".$id[$i];
					}
					$connection->createCommand($sql)->execute();
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
					$sql = "delete from materialstatus where materialstatusid = ".$id[$i];
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
		$this->pdf->title					 = getCatalog('materialstatus');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('materialstatusid'), getCatalog('materialstatusname'),
			getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 80, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['materialstatusid'], $row1['materialstatusname'],
				(($row1['recordstatus'] == 1) ? 'Active' : 'NotActive')));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}