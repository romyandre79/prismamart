<?php
class RomawiController extends AdminController {
	protected $menuname	 = 'romawi';
	public $module			 = 'Common';
	protected $pageTitle = 'Romawi';
	public $wfname			 = '';
	public $sqldata	 = "select a0.romawiid,a0.monthcal,a0.monthrm,a0.recordstatus
    from romawi a0 
  ";
	public $sqlcount	 = "select count(1)
    from romawi a0 
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
		if (isset($_REQUEST['monthrm'])) {
			$where .= " where a0.monthrm like '%".$_REQUEST['monthrm']."%'";
		}
		if (isset($_REQUEST['romawiid'])) {
			if (($_REQUEST['romawiid'] !== '0') && ($_REQUEST['romawiid'] !== '')) {
				$where .= " and a0.romawiid in (".$_REQUEST['romawiid'].")";
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
			'keyField' => 'romawiid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'romawiid', 'monthcal', 'monthrm', 'recordstatus'
				),
				'defaultOrder' => array(
					'romawiid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.romawiid = '.$id)->queryRow();
			if ($model !== null) {
				echo CJSON::encode(array(
					'status' => 'success',
					'romawiid' => $model['romawiid'],
					'monthcal' => $model['monthcal'],
					'monthrm' => $model['monthrm'],
					'recordstatus' => $model['recordstatus'],
				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('monthrm', 'string', 'emptymonthrm'),
			array('monthcal', 'string', 'emptymonthcal'),
		));
		if ($error == false) {
			$id					 = $_POST['romawiid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				if ($id !== '') {
					$sql = 'update romawi 
			      set monthcal = :monthcal,monthrm = :monthrm,recordstatus = :recordstatus 
			      where romawiid = :romawiid';
				} else {
					$sql = 'insert into romawi (monthcal,monthrm,recordstatus) 
			      values (:monthcal,:monthrm,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '') {
					$command->bindvalue(':romawiid', $_POST['romawiid'], PDO::PARAM_STR);
				}
				$command->bindvalue(':monthcal',
					(($_POST['monthcal'] !== '') ? $_POST['monthcal'] : null), PDO::PARAM_STR);
				$command->bindvalue(':monthrm',
					(($_POST['monthrm'] !== '') ? $_POST['monthrm'] : null), PDO::PARAM_STR);
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
					$sql		 = "select recordstatus from romawi where a0.romawiid = ".$id[$i];
					$status	 = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1) {
						$sql = "update romawi set recordstatus = 0 where a0.romawiid = ".$id[$i];
					} else
					if ($status['recordstatus'] == 0) {
						$sql = "update romawi set recordstatus = 1 where a0.romawiid = ".$id[$i];
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
					$sql = "delete from romawi where romawiid = ".$id[$i];
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
		$this->pdf->title					 = getCatalog('romawi');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('romawiid'), getCatalog('monthcal'),
			getCatalog('monthrm'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 40, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['romawiid'], $row1['monthcal'], $row1['monthrm'],
				(($row1['recordstatus'] == 1) ? 'Active' : 'NotActive')));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}