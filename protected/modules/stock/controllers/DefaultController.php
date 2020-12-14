<?php
class DefaultController extends AdminController {
	public $menuname = 'stock';
	public $module	 = 'stock';
	public function actionIndex() {
		parent::actionIndex();
		$this->pageTitle = "Dashboard";
		$sql						 = "select widgetname,widgettitle,widgeturl,dashgroup,webformat,position,(
			select count(1)
			from userdash d
			where d.dashgroup = a.dashgroup and d.menuaccessid = a.menuaccessid 
			) dashcount 
			from userdash a 
			inner join menuaccess b on b.menuaccessid = a.menuaccessid 
			inner join widget c on c.widgetid = a.widgetid 
			where lower(menuname) = lower('".$this->menuname."') 
			order by dashgroup asc, position asc ";
		$dependency			 = new CDbCacheDependency('SELECT MAX(userdashid) FROM userdash');
		$datas					 = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
		$this->render('index', array('datas' => $datas));
	}
}