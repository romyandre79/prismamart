<script src="<?php echo Yii::app()->baseUrl; ?>/js/admin/addressbook.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="card card-purple">
	<div class="card-header with-border">
    <h3 class="card-title"><?php echo getCatalog($this->menuname) ?></h3>
  </div>
  <div class="card-body">
      <?php $this->widget('Button',	array('menuname'=>$this->menuname)); ?>
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
		),
		array (
      'class'=>'CButtonColumn',
      'template'=>'{edit} {delete} {purge} {pdf}',
      'htmlOptions' => array('style'=>'width:160px'),
      'buttons'=>array (
        'edit' => array (
          'label'=>getCatalog('edit'),
          'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
          'visible'=>booltostr(CheckAccess('addressbook','iswrite')),							
          'url'=>'"#"',
          'click'=>"function() { 
            updatedata($(this).parent().parent().children(':nth-child(3)').text());
          }",
        ),
        'delete' => array (
          'label'=>getCatalog('delete'),
          'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
          'visible'=>booltostr(CheckAccess('addressbook','isreject')),							
          'url'=>'"#"',
          'click'=>"function() { 
            deletedata($(this).parent().parent().children(':nth-child(3)').text());
          }",
        ),
        'purge' => array (
            'label'=>getCatalog('purge'),
            'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
            'visible'=>booltostr(CheckAccess('addressbook','ispurge')),							
            'url'=>'"#"',
            'click'=>"function() { 
              purgedata($(this).parent().parent().children(':nth-child(3)').text());
            }",
        ),
        'pdf' => array (
            'label'=>getCatalog('downpdf'),
            'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
            'visible'=>booltostr(CheckAccess('addressbook','isdownload')),
            'url'=>'"#"',
            'click'=>"function() { 
              downpdf($(this).parent().parent().children(':nth-child(3)').text());
            }",
        ),
      ),
    ),
    array (
      'header'=>getCatalog('addressbookid'),
      'name'=>'addressbookid',
      'value'=>'$data["addressbookid"]'
    ),
    array(
      'header'=>getCatalog('fullname'),
      'name'=>'fullname',
      'value'=>'$data["fullname"]'
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'iscustomer',
      'header'=>getCatalog('iscustomer'),
      'selectableRows'=>'0',
      'checked'=>'$data["iscustomer"]',
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'isemployee',
      'header'=>getCatalog('isemployee'),
      'selectableRows'=>'0',
      'checked'=>'$data["isemployee"]',
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'isvendor',
      'header'=>getCatalog('isvendor'),
      'selectableRows'=>'0',
      'checked'=>'$data["isvendor"]',
    ),
    array(
      'header'=>getCatalog('currentlimit'),
      'name'=>'currentlimit',
      'value'=>'Yii::app()->format->formatNumber($data["currentlimit"])'
    ),
    array(
      'header'=>getCatalog('currentdebt'),
      'name'=>'currentdebt',
      'value'=>'Yii::app()->format->formatNumber($data["currentdebt"])'
    ),
    array(
      'header'=>getCatalog('taxno'),
      'name'=>'taxno',
      'value'=>'$data["taxno"]'
    ),
    array(
      'header'=>getCatalog('creditlimit'),
      'name'=>'creditlimit',
      'value'=>'Yii::app()->format->formatNumber($data["creditlimit"])'
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'isstrictlimit',
      'header'=>getCatalog('isstrictlimit'),
      'selectableRows'=>'0',
      'checked'=>'$data["isstrictlimit"]',
    ),
    array(
      'header'=>getCatalog('areaname'),
      'name'=>'salesareaid',
      'value'=>'$data["areaname"]'
    ),
    array(
      'header'=>getCatalog('categoryname'),
      'name'=>'pricecategoryid',
      'value'=>'$data["categoryname"]'
    ),
    array(
      'header'=>getCatalog('overdue'),
      'name'=>'overdue',
      'value'=>'$data["overdue"]'
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'recordstatus',
      'header'=>getCatalog('recordstatus'),
      'selectableRows'=>'0',
      'checked'=>'$data["recordstatus"]',
    ),
	)
));
?>
  <?php $this->widget('Button',	array('menuname'=>$this->menuname)); ?>
</div>
</div>
<?php $this->widget('SearchPopUp',array('searchitems'=>array(
  array('searchtype'=>'text','searchname'=>'fullname'),
  array('searchtype'=>'text','searchname'=>'taxno'),
  array('searchtype'=>'text','searchname'=>'bankname'),
  array('searchtype'=>'text','searchname'=>'bankaccountno'),
  array('searchtype'=>'text','searchname'=>'accountowner'),
))); ?>
<?php $this->widget('HelpPopUp',array('helpurl'=>'https://www.youtube.com/embed/yDg-qwmPAU0')); ?>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><?php echo getCatalog('addressbook') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
        <input type="hidden" class="form-control" name="addressbookid">
        <div class="row">
          <div class="col-md-4">
            <label for="fullname"><?php echo getCatalog('fullname')?></label>
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="fullname">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="iscustomer"><?php echo getCatalog('iscustomer')?></label>
          </div>
          <div class="col-md-8">
            <input type="checkbox" name="iscustomer">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="isemployee"><?php echo getCatalog('isemployee')?></label>
          </div>
          <div class="col-md-8">
            <input type="checkbox" name="isemployee">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="isvendor"><?php echo getCatalog('isvendor')?></label>
          </div>
          <div class="col-md-8">
            <input type="checkbox" name="isvendor">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="currentlimit"><?php echo getCatalog('currentlimit')?></label>
          </div>
          <div class="col-md-8">
            <input type="number" class="form-control" name="currentlimit">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="currentdebt"><?php echo getCatalog('currentdebt')?></label>
          </div>
          <div class="col-md-8">
            <input type="number" class="form-control" name="currentdebt">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="taxno"><?php echo getCatalog('taxno')?></label>
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="taxno">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="creditlimit"><?php echo getCatalog('creditlimit')?></label>
          </div>
          <div class="col-md-8">
            <input type="number" class="form-control" name="creditlimit">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="isstrictlimit"><?php echo getCatalog('isstrictlimit')?></label>
          </div>
          <div class="col-md-8">
            <input type="checkbox" name="isstrictlimit">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="bankname"><?php echo getCatalog('bankname')?></label>
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="bankname">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="bankaccountno"><?php echo getCatalog('bankaccountno')?></label>
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="bankaccountno">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="accountowner"><?php echo getCatalog('accountowner')?></label>
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="accountowner">
          </div>
        </div>
        <?php $this->widget('DataPopUp',
          array('id'=>'Widget','IDField'=>'salesareaid','ColField'=>'areaname',
            'IDDialog'=>'salesareaid_dialog','titledialog'=>getCatalog('areaname'),'classtype'=>'col-md-4',
            'classtypebox'=>'col-md-8',
            'PopUpName'=>'common.components.views.SalesareaPopUp','PopGrid'=>'salesareaidgrid')); 
        ?>
        <?php $this->widget('DataPopUp',
          array('id'=>'Widget','IDField'=>'pricecategoryid','ColField'=>'categoryname',
            'IDDialog'=>'pricecategoryid_dialog','titledialog'=>getCatalog('categoryname'),'classtype'=>'col-md-4',
            'classtypebox'=>'col-md-8',
            'PopUpName'=>'common.components.views.PricecategoryPopUp','PopGrid'=>'pricecategoryidgrid')); 
        ?>	
        <div class="row">
          <div class="col-md-4">
            <label for="overdue"><?php echo getCatalog('overdue')?></label>
          </div>
          <div class="col-md-8">
            <input type="number" class="form-control" name="overdue">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="invoicedate"><?php echo getCatalog('invoicedate')?></label>
          </div>
          <div class="col-md-8">
            <input type="date" class="form-control" name="invoicedate">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="logo"><?php echo getCatalog('logo')?></label>
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="logo">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="url"><?php echo getCatalog('url')?></label>
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="url">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="recordstatus"><?php echo getCatalog('recordstatus')?></label>
          </div>
          <div class="col-md-8">
            <input type="checkbox" name="recordstatus">
          </div>
        </div>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo getCatalog('close') ?></button>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/adminlte.min.css">