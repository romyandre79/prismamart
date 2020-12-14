<script async defer type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDnL4wf9zebY7PwS7vDd1EvDE7mDh9drSA"></script>
<script type="text/javascript">
$(document).ready(function(){
 var latlng = new google.maps.LatLng(0.7674052,123.2230338);
 var myOptions = {
	 zoom: 5,
	 center: latlng,
 };
 var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
 var image = {
		url: '<?php echo Yii::app()->request->hostInfo . Yii::app()->baseUrl.'/images/bigcity.png'?>',
		size: new google.maps.Size(32, 32),
		origin: new google.maps.Point(0, 0),
		anchor: new google.maps.Point(0, 32)
	};
  <?php 
 $companys = Yii::app()->db->createCommand("select a.addressbookid,fullname,b.lat,b.lng,creditlimit,currentlimit,b.addressname from addressbook a 
	inner join address b on b.addressbookid = a.addressbookid 
	where iscustomer=1 and fullname <> '' and fullname is not null")->queryAll();
	foreach($companys as $company)
	{
		echo "var customer".$company['addressbookid']."= {lat: ".$company['lat'].", lng: ".$company['lng']."};";
		echo "var contentString".$company['addressbookid']." = 'Customer: ".$company['fullname']."<br>Address: ".$company['addressname']."<br>Current Limit: ".Yii::app()->format->formatNumber($company['currentlimit'])."<br>Credit Limit: ".Yii::app()->format->formatNumber($company['creditlimit'])."';";
		echo "var infowindow".$company['addressbookid']." = new google.maps.InfoWindow({
          content: contentString".$company['addressbookid']."
        });";
		echo "var marker".$company['addressbookid']." = new google.maps.Marker({
          position: customer".$company['addressbookid'].",
					icon:image,
          map: map,
          title: '".$company['fullname']."'
        });";
		echo "marker".$company['addressbookid'].".addListener('click', function() {
          infowindow".$company['addressbookid'].".open(map, marker".$company['addressbookid'].");
        });";
	}
	?>

});
</script>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Customer</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
	<div id="map_canvas" style="height:700px"></div>
	</div><!-- /.box-body -->
</div><!-- /.box -->