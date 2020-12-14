<?php
class Materialstockoverview extends Portlet {
	protected function renderContent() {
		$sql					 = Yii::app()->db->createCommand('select a0.productstockid,a0.productid,a0.slocid,a0.storagebinid,a0.qty,a0.unitofmeasureid,a0.qtyinprogress,a1.productname as productname,a2.sloccode as sloccode,a3.description as storagedesc,a4.uomcode as uomcode
    from productstock a0 
    left join product a1 on a1.productid = a0.productid
    left join sloc a2 on a2.slocid = a0.slocid
    left join storagebin a3 on a3.storagebinid = a0.storagebinid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid');
		$sqlcount			 = "select count(1)
    from productstock a0 
    left join product a1 on a1.productid = a0.productid
    left join sloc a2 on a2.slocid = a0.slocid
    left join storagebin a3 on a3.storagebinid = a0.storagebinid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid
  ";
		$count				 = Yii::app()->db->createCommand($sqlcount)->queryScalar();
		$dataProvider	 = new CSqlDataProvider($sql,
			array(
			'totalItemCount' => $count,
			'keyField' => 'productstockid',
			'pagination' => array(
				'pageSize' => getparameter('DefaultPageSize'),
				'pageVar' => 'page',
			),
			'sort' => array(
				'attributes' => array(
					'productstockid', 'productid', 'slocid', 'storagebinid', 'qty', 'unitofmeasureid',
					'qtyinprogress'
				),
				'defaultOrder' => array(
					'productstockid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('materialstockoverview', array('dataProvider' => $dataProvider));
	}
}