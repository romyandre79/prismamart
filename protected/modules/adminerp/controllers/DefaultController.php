<?php
class DefaultController extends Controller {
	protected $menuname	 = 'gmerp';
	public $module			 = 'admin';
	public function actionIndex() {
		parent::actionIndex();
		$this->redirect(Yii::app()->createUrl('admin'));
	}
}