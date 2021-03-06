<?php
$sqldata = "select a.slocid,a.plantid,a.sloccode,a.description
		from sloc a 
		join plant b on b.plantid = a.plantid 
		join company c on c.companyid = b.companyid 
		where a.recordstatus = 1 and a.sloccode like '%".(isset($_REQUEST['sloccode'])
		? $_REQUEST['sloccode'] : '')."%'
		and c.companyid = ".(isset($_REQUEST['companyid']) ? $_REQUEST['companyid'] : 'null')."
		and a.description like '%".(isset($_REQUEST['description']) ? $_REQUEST['description']
		: '')."%'
		and slocid in (select gm.menuvalueid from groupaccess c
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
inner join groupmenuauth gm on gm.groupaccessid = c.groupaccessid
inner join menuauth ma on ma.menuauthid = gm.menuauthid
where upper(e.username)=upper('".Yii::app()->user->name."') and upper(ma.menuobject) = upper('sloc'))";
$count	 = count(Yii::app()->db->createCommand($sqldata)->queryAll());
$product = new CSqlDataProvider($sqldata,
	array(
	'totalItemCount' => $count,
	'keyField' => 'slocid',
	'pagination' => array(
		'pageSize' => ('DefaultPageSize'),
		'pageVar' => 'page',
	),
	'sort' => array(
		'attributes' => array(
			'slocid', 'sloccode', 'description'
		),
		'defaultOrder' => array(
			'slocid' => CSort::SORT_DESC
		),
	),
	));
?>
<script>
	function <?php echo $this->IDField ?>searchdata() {
		$.fn.yiiGridView.update("<?php echo $this->PopGrid ?>", {data: {
				'sloccode': $("input[name='<?php echo $this->IDField ?>_search_sloccode']").val(),
				'companyid': $("input[name='<?php echo $this->RelationID ?>']").val(),
				'description': $("input[name='<?php echo $this->IDField ?>_search_description']").val()
			}});
		return false;
	}
	function <?php echo $this->IDField ?>ShowButtonClick() {
		$('#<?php echo $this->IDDialog ?>').modal();
<?php echo $this->IDField ?>searchdata();
	}
	function <?php echo $this->IDField ?>ClearButtonClick() {
		$("input[name='<?php echo $this->ColField ?>']").val('');
		$("input[name='<?php echo $this->IDField ?>']").val('');
	}
	function <?php echo $this->PopGrid ?>onSelectionChange() {
		$("#<?php echo $this->PopGrid ?> > table > tbody > tr").each(function (i) {
			if ($(this).hasClass("selected")) {
				$("input[name='<?php echo $this->ColField ?>']").val($(this).find("td:nth-child(2)").text());
				$("input[name='<?php echo $this->IDField ?>']").val($(this).find('td:first-child').text());<?php echo $this->onaftersign ?>
			}
		});
		$('#<?php echo $this->IDDialog ?>').modal('hide');
	}
	$(document).ready(function () {
		$("input[name='<?php echo $this->ColField; ?>']").keyup(function (e) {
			if (e.keyCode == 13) {
<?php echo $this->IDField ?>ShowButtonClick();
			}
		});
		$(":input[name*='<?php echo $this->IDField; ?>_search_']").keyup(function (e) {
			if (e.keyCode == 13) {
<?php echo $this->IDField ?>searchdata()
			}
		});
	});

</script>
<div class="row">
	<div class="<?php echo $this->classtype ?>">
		<label class="control-label" for="<?php echo $this->ColField; ?>"><?php echo $this->titledialog ?></label>
	</div>
	<div class="<?php echo $this->classtypebox ?>">
		<input name="<?php echo $this->IDField ?>" type="hidden" value="">
		<div class="input-group">
			<input type="text" name="<?php echo $this->ColField ?>" readonly class="form-control">
			<span class="input-group-btn">
				<button name="<?php echo $this->IDField ?>ShowButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField ?>ShowButtonClick()"><span class="fa fa-search"></span></button>
				<button name="<?php echo $this->IDField ?>ClearButton" type="button" class="btn btn-danger" onclick="<?php echo $this->IDField ?>ClearButtonClick()"><span class="fa fa-ban"></span></button>
			</span>
		</div>
	</div>
</div>

<div id="<?php echo $this->IDDialog ?>" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">	
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $this->titledialog ?></h4>
				<button type="button" class="close" data-dismiss="modal" href="#<?php echo $this->IDDialog ?>">&times;</button>
      </div>
      <div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<label class="control-label" for="<?php echo $this->IDField ?>_search_sloccode"><?php echo getCatalog('sloccode') ?></label>
					</div>
					<div class="col-md-8">
						<div class="input-group">
							<input type="text" name="<?php echo $this->IDField ?>_search_sloccode" class="form-control">
							<span class="input-group-btn">
								<button name="<?php echo $this->IDField ?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField ?>searchdata()"><span class="fa fa-search"></span></button>
							</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label class="control-label" for="<?php echo $this->IDField ?>_search_description"><?php echo getCatalog('description') ?></label>
					</div>
					<div class="col-md-8">
						<input type="text" name="<?php echo $this->IDField ?>_search_description" class="form-control">
					</div>
				</div>
				<?php
				$this->widget('zii.widgets.grid.CGridView',
					array(
					'id' => $this->PopGrid,
					'selectableRows' => 1,
					'dataProvider' => $product,
					'selectionChanged' => 'function(id){'.$this->PopGrid.'onSelectionChange()}',
					'columns' => array(
						array(
							'header' => getCatalog('slocid'),
							'name' => 'slocid',
							'value' => '$data["slocid"]',
							'htmlOptions' => array('width' => '1%')
						),
						array(
							'header' => getCatalog('sloccode'),
							'name' => 'sloccode',
							'value' => '$data["sloccode"]',
						),
						array(
							'header' => getCatalog('description'),
							'name' => 'description',
							'value' => '$data["description"]',
						),
					),
				));
				?>
			</div>
		</div>
	</div>
</div>