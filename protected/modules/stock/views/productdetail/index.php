<script src="<?php echo Yii::app()->baseUrl; ?>/js/stock/productdetail.js"></script>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo getCatalog($this->menuname) ?></h3>
	</div>
	<div class="box-body">
    <?php $this->widget('Button',	array('menuname'=>'productdetail','iswrite'=>false,'ispurge'=>false,'isreject'=>false)); ?>
		<?php
		$this->widget('zii.widgets.grid.CGridView',
			array(
			'dataProvider' => $dataProvider,
			'id' => 'GridList',
			'selectableRows' => 2,
			'ajaxUpdate' => true,
			'filter' => null,
			'enableSorting' => true,
			'columns' => array(
				array(
					'class' => 'CCheckBoxColumn',
					'id' => 'ids',
					'htmlOptions' => array('style' => 'width:10px'),
				),
				array
					(
					'class' => 'CButtonColumn',
					'template' => '{select} {edit} {approve} {delete} {purge}',
					'htmlOptions' => array('style' => 'width:100px'),
					'buttons' => array
						(
						'select' => array
							(
							'label' => getCatalog('detail'),
							'imageUrl' => Yii::app()->baseUrl.'/images/detail.png',
							'url' => '"#"',
							'click' => "function() {
								GetDetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'edit' => array
							(
							'label' => getCatalog('edit'),
							'imageUrl' => Yii::app()->baseUrl.'/images/edit.png',
							'visible' => 'false',
							'url' => '"#"',
							'click' => "function() {
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'approve' => array
							(
							'label' => getCatalog('approve'),
							'imageUrl' => Yii::app()->baseUrl.'/images/approved.png',
							'visible' => 'false',
							'url' => '"#"',
							'click' => "function() {
								approvedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'delete' => array
							(
							'label' => getCatalog('delete'),
							'imageUrl' => Yii::app()->baseUrl.'/images/active.png',
							'visible' => 'false',
							'url' => '"#"',
							'click' => "function() {
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => 'false',
							'url' => '"#"',
							'click' => "function() {
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('productdetail',
									'isdownload')),
							'url' => '"#"',
							'click' => "function() {
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('productdetailid'),
					'name' => 'productdetailid',
					'value' => '$data["productdetailid"]'
				),
				array(
					'header' => getCatalog('materialcode'),
					'name' => 'materialcode',
					'value' => '$data["materialcode"]'
				),
				array(
					'header' => getCatalog('materialgroupcode'),
					'name' => 'materialgroupcode',
					'value' => '$data["materialgroupcode"]'
				),
				array(
					'header' => getCatalog('productname'),
					'name' => 'productid',
					'value' => '$data["productname"]'
				),
				array(
					'header' => getCatalog('sloccode'),
					'name' => 'slocid',
					'value' => '$data["sloccode"]'
				),
				array(
					'header' => getCatalog('storagedesc'),
					'name' => 'storagebinid',
					'value' => '$data["storagedesc"]'
				),
				array(
					'header' => getCatalog('qty'),
					'name' => 'qty',
					'value' => 'Yii::app()->format->formatNumber($data["qty"]) . " " . $data["uomcode"]'
				),
				array(
					'header' => getCatalog('buydate'),
					'name' => 'buydate',
					'value' => 'Yii::app()->format->formatDate($data["buydate"])'
				),
				array(
					'header' => getCatalog('expiredate'),
					'name' => 'expiredate',
					'value' => 'Yii::app()->format->formatDate($data["expiredate"])'
				),
				array(
					'header' => getCatalog('buyprice'),
					'name' => 'buyprice',
					'value' => 'Yii::app()->format->formatNumber($data["buyprice"])'
				),
				array(
					'header' => getCatalog('currencyname'),
					'name' => 'currencyid',
					'value' => '$data["currencyname"]'
				),
				array(
					'header' => getCatalog('location'),
					'name' => 'location',
					'value' => '$data["location"]'
				),
				array(
					'header' => getCatalog('locationdate'),
					'name' => 'locationdate',
					'value' => 'Yii::app()->format->formatDate($data["locationdate"])'
				),
				array(
					'header' => getCatalog('materialstatusname'),
					'name' => 'materialstatusid',
					'value' => '$data["materialstatusname"]'
				),
				array(
					'header' => getCatalog('ownershipname'),
					'name' => 'ownershipid',
					'value' => '$data["ownershipname"]'
				),
				array(
					'header' => getCatalog('referenceno'),
					'name' => 'referenceno',
					'value' => '$data["referenceno"]'
				),
				array(
					'header' => getCatalog('vrqty'),
					'name' => 'vrqty',
					'value' => 'Yii::app()->format->formatNumber($data["vrqty"])'
				),
				array(
					'header' => getCatalog('serialno'),
					'name' => 'serialno',
					'value' => '$data["serialno"]'
				),
			)
		));
		?>
    <?php $this->widget('Button',	array('menuname'=>'productdetail','iswrite'=>false,'ispurge'=>false,'isreject'=>false)); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'materialcode'),
  array('searchtype'=>'text','searchname'=>'materialgroupcode'),
  array('searchtype'=>'text','searchname'=>'productname'),
  array('searchtype'=>'text','searchname'=>'sloccode'),
  array('searchtype'=>'text','searchname'=>'description'),
  array('searchtype'=>'text','searchname'=>'uomcode'),
  array('searchtype'=>'text','searchname'=>'currencyname'),
  array('searchtype'=>'text','searchname'=>'location'),
  array('searchtype'=>'text','searchname'=>'referenceno'),
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/IC_DpM3ZHoU')); ?>
<div id="ShowDetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo getCatalog('productdetailhist') ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php
						$this->widget('zii.widgets.grid.CGridView',
							array(
							'dataProvider' => $dataProviderproductdetailhist,
							'id' => 'DetailproductdetailhistList',
							'ajaxUpdate' => true,
							'filter' => null,
							'enableSorting' => true,
							'columns' => array(
								array(
									'header' => getCatalog('productdetailhistid'),
									'name' => 'productdetailhistid',
									'value' => '$data["productdetailhistid"]'
								),
								array(
									'header' => getCatalog('sloc'),
									'name' => 'slocid',
									'value' => '$data["sloccode"]'
								),
								array(
									'header' => getCatalog('expiredate'),
									'name' => 'expiredate',
									'value' => 'Yii::app()->format->formatDate($data["expiredate"])'
								),
								array(
									'header' => getCatalog('serialno'),
									'name' => 'serialno',
									'value' => '$data["serialno"]'
								),
								array(
									'header' => getCatalog('qty'),
									'name' => 'qty',
									'value' => 'Yii::app()->format->formatNumber($data["qty"])'
								),
								array(
									'header' => getCatalog('unitofmeasure'),
									'name' => 'unitofmeasureid',
									'value' => '$data["uomcode"]'
								),
								array(
									'header' => getCatalog('buydate'),
									'name' => 'buydate',
									'value' => 'Yii::app()->format->formatDate($data["buydate"])'
								),
								array(
									'header' => getCatalog('buyprice'),
									'name' => 'buyprice',
									'value' => 'Yii::app()->format->formatNumber($data["buyprice"])'
								),
								array(
									'header' => getCatalog('currency'),
									'name' => 'currencyid',
									'value' => '$data["currencyname"]'
								),
								array(
									'header' => getCatalog('product'),
									'name' => 'productid',
									'value' => '$data["productname"]'
								),
								array(
									'header' => getCatalog('storagebin'),
									'name' => 'storagebinid',
									'value' => '$data["storagedesc"]'
								),
								array(
									'header' => getCatalog('location'),
									'name' => 'location',
									'value' => '$data["location"]'
								),
								array(
									'header' => getCatalog('locationdate'),
									'name' => 'locationdate',
									'value' => 'Yii::app()->format->formatDateTime($data["locationdate"])'
								),
								array(
									'header' => getCatalog('materialcode'),
									'name' => 'materialcode',
									'value' => '$data["materialcode"]'
								),
								array(
									'header' => getCatalog('materialstatus'),
									'name' => 'materialstatusid',
									'value' => '$data["materialstatusname"]'
								),
								array(
									'header' => getCatalog('ownership'),
									'name' => 'ownershipid',
									'value' => '$data["ownershipname"]'
								),
								array(
									'header' => getCatalog('referenceno'),
									'name' => 'referenceno',
									'value' => '$data["referenceno"]'
								),
							)
						));
						?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>