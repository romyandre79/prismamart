<?php
class DefaultController extends Controller {
	private $CreatedBy	 = 'Prisma Data Abadi';
	private $Version		 = '0.1';
	private $Description = 'Blog Module';
	protected $menuname	 = 'common';
	public $module			 = 'common';
	protected $pageTitle = 'Common';
	public function actionIndex() {
		parent::actionIndex();
		$this->render('index');
	}
}