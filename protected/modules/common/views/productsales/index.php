<script src="<?php echo Yii::app()->baseUrl; ?>/js/common/productsales.js"></script>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo getCatalog('productsales') ?></h3>
	</div>
	<div class="box-body">
    <?php $this->widget('Button',	array('menuname'=>'productsales')); ?>
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
					'template' => '{edit} {delete} {purge} {pdf}',
					'htmlOptions' => array('style' => 'width:160px'),
					'buttons' => array
						(
						'edit' => array
							(
							'label' => getCatalog('edit'),
							'imageUrl' => Yii::app()->baseUrl.'/images/edit.png',
							'visible' => booltostr(CheckAccess('productsales', 'iswrite')),
							'url' => '"#"',
							'click' => "function() {
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'delete' => array
							(
							'label' => getCatalog('delete'),
							'imageUrl' => Yii::app()->baseUrl.'/images/active.png',
							'visible' => booltostr(CheckAccess('productsales', 'isreject')),
							'url' => '"#"',
							'click' => "function() {
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'purge' => array
							(
							'label' => getCatalog('purge'),
							'imageUrl' => Yii::app()->baseUrl.'/images/trash.png',
							'visible' => booltostr(CheckAccess('productsales', 'ispurge')),
							'url' => '"#"',
							'click' => "function() {
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
						'pdf' => array
							(
							'label' => getCatalog('downpdf'),
							'imageUrl' => Yii::app()->baseUrl.'/images/pdf.png',
							'visible' => booltostr(CheckAccess('productsales', 'isdownload')),
							'url' => '"#"',
							'click' => "function() {
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
						),
					),
				),
				array(
					'header' => getCatalog('productsalesid'),
					'name' => 'productsalesid',
					'value' => '$data["productsalesid"]'
				),
				array(
					'header' => getCatalog('productname'),
					'name' => 'productid',
					'value' => '$data["productname"]'
				),
				array(
					'header' => getCatalog('currencyname'),
					'name' => 'currencyid',
					'value' => '$data["currencyname"]'
				),
				array(
					'header' => getCatalog('currencyvalue'),
					'name' => 'currencyvalue',
					'value' => 'Yii::app()->format->formatNumber($data["currencyvalue"])'
				),
				array(
					'header' => getCatalog('categoryname'),
					'name' => 'pricecategoryid',
					'value' => '$data["categoryname"]'
				),
				array(
					'header' => getCatalog('uomcode'),
					'name' => 'uomid',
					'value' => '$data["uomcode"]'
				),
			)
		));
		?>
    <?php $this->widget('Button',	array('menuname'=>'productsales')); ?>
	</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'productname'),
  array('searchtype'=>'text','searchname'=>'currencyname'),
  array('searchtype'=>'text','searchname'=>'categoryname'),
  array('searchtype'=>'text','searchname'=>'uomcode')
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/PFhphroOHJs')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo getCatalog('productsales') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="productsalesid">
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'productid', 'ColField' => 'productname',
					'IDDialog' => 'productid_dialog', 'titledialog' => getCatalog('productname'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.ProductPopUp', 'PopGrid' => 'productidgrid'));
				?>
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'currencyid', 'ColField' => 'currencyname',
					'IDDialog' => 'currencyid_dialog', 'titledialog' => getCatalog('currencyname'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'admin.components.views.CurrencyPopUp', 'PopGrid' => 'currencyidgrid'));
				?>
        <div class="row">
					<div class="col-md-4">
						<label for="currencyvalue"><?php echo getCatalog('currencyvalue') ?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="currencyvalue">
					</div>
				</div>
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'pricecategoryid', 'ColField' => 'categoryname',
					'IDDialog' => 'pricecategoryid_dialog', 'titledialog' => getCatalog('categoryname'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8',
					'PopUpName' => 'common.components.views.PricecategoryPopUp', 'PopGrid' => 'pricecategoryidgrid'));
				?>
				<?php
				$this->widget('DataPopUp',
					array('id' => 'Widget', 'IDField' => 'uomid', 'ColField' => 'uomcode',
					'IDDialog' => 'uomid_dialog', 'titledialog' => getCatalog('uomcode'),
					'classtype' => 'col-md-4',
					'classtypebox' => 'col-md-8', 'RelationID' => 'productid',
					'PopUpName' => 'common.components.views.UomPlantPopUp', 'PopGrid' => 'uomidgrid'));
				?>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
    </div>
  </div>
</div>