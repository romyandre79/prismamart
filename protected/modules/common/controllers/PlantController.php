<?php
class PlantController extends AdminController {
	protected $menuname	 = 'plant';
	public $module			 = 'Common';
	protected $pageTitle = 'Cabang';
	public $wfname			 = '';
	public $sqldata	 = "select a0.plantid,a0.companyid,a0.plantcode,a0.description,a0.plantaddress,a0.lat,a0.lng,a0.recordstatus,a1.companyname as companyname
    from plant a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
	public $sqlcount	 = "select count(1)
    from plant a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
	public function getSQL() {
		$this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where			 = "";
		if ((isset($_REQUEST['plantcode'])) && (isset($_REQUEST['description'])) && (isset($_REQUEST['companyname']))) {
			$where .= " where a0.plantcode like '%".$_REQUEST['plantcode']."%'
and a0.description like '%".$_REQUEST['description']."%' 
and a1.companyname like '%".$_REQUEST['companyname']."%'";
		}
		if (isset($_REQUEST['plantid'])) {
			if (($_REQUEST['plantid'] !== '0') && ($_REQUEST['plantid'] !== '')) {
				$where .= " and a0.plantid in (".$_REQUEST['plantid'].")";
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
			'keyField' => 'plantid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'plantid', 'companyid', 'plantcode', 'description', 'plantaddress', 'lat', 'lng',
					'recordstatus'
				),
				'defaultOrder' => array(
					'plantid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.plantid = '.$id)->queryRow();
			if ($model !== null) {
				echo CJSON::encode(array(
					'status' => 'success',
					'plantid' => $model['plantid'],
					'companyid' => $model['companyid'],
					'plantcode' => $model['plantcode'],
					'description' => $model['description'],
					'plantaddress' => $model['plantaddress'],
					'lat' => $model['lat'],
					'lng' => $model['lng'],
					'recordstatus' => $model['recordstatus'],
					'companyname' => $model['companyname'],
				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = ValidateData(array(
			array('companyid', 'string', 'emptycompanyid'),
			array('plantcode', 'string', 'emptyplantcode'),
			array('description', 'string', 'emptydescription'),
		));
		if ($error == false) {
			$id					 = $_POST['plantid'];
			$connection	 = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try {
				if ($id !== '') {
					$sql = 'update plant 
			      set companyid = :companyid,plantcode = :plantcode,description = :description,plantaddress = :plantaddress,lat = :lat,lng = :lng,recordstatus = :recordstatus 
			      where plantid = :plantid';
				} else {
					$sql = 'insert into plant (companyid,plantcode,description,plantaddress,lat,lng,recordstatus) 
			      values (:companyid,:plantcode,:description,:plantaddress,:lat,:lng,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '') {
					$command->bindvalue(':plantid', $_POST['plantid'], PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',
					(($_POST['companyid'] !== '') ? $_POST['companyid'] : null), PDO::PARAM_STR);
				$command->bindvalue(':plantcode',
					(($_POST['plantcode'] !== '') ? $_POST['plantcode'] : null), PDO::PARAM_STR);
				$command->bindvalue(':description',
					(($_POST['description'] !== '') ? $_POST['description'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':plantaddress',
					(($_POST['plantaddress'] !== '') ? $_POST['plantaddress'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':lat', (($_POST['lat'] !== '') ? $_POST['lat'] : null),
					PDO::PARAM_STR);
				$command->bindvalue(':lng', (($_POST['lng'] !== '') ? $_POST['lng'] : null),
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
					$sql		 = "select recordstatus from plant where a0.plantid = ".$id[$i];
					$status	 = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1) {
						$sql = "update plant set recordstatus = 0 where a0.plantid = ".$id[$i];
					} else
					if ($status['recordstatus'] == 0) {
						$sql = "update plant set recordstatus = 1 where a0.plantid = ".$id[$i];
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
					$sql = "delete from plant where plantid = ".$id[$i];
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
		$this->pdf->title					 = getCatalog('plant');
		$this->pdf->AddPage('P');
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->colheader			 = array(getCatalog('plantid'), getCatalog('company'),
			getCatalog('plantcode'), getCatalog('description'), getCatalog('plantaddress'),
			getCatalog('lat'), getCatalog('lng'), getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10, 40, 15, 30, 40, 20, 20, 15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L');

		foreach ($dataReader as $row1) {
			//masukkan baris untuk cetak
			$this->pdf->row(array($row1['plantid'], $row1['companyname'], $row1['plantcode'],
				$row1['description'],
				$row1['plantaddress'], $row1['lat'], $row1['lng'], (($row1['recordstatus'] == 1)
						? 'Active' : 'NotActive')));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
}