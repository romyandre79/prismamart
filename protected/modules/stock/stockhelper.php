<?php 
function getstock($addressbook='',$materialtype='',$limit=0,$latest=1){
  $dependency = new CDbCacheDependency('SELECT max(updatedate) FROM materialgroup');
  $sql = "select c.productname
    from productstock a
    left join addressbook b on b.addressbookid = a.addressbookid 
    left join product c on c.productid = a.productid 
  ";
  if ($materialtype != '') {
    $sql .= " where coalesce(b.materialtypecode,'') = '".$materialtype."'";
  }
  if ($latest == 1) {
    $sql .= " order by a.updatedate desc";
  }
  if ($limit > 0) {
    $sql .= " limit ".$limit;
  }
  return Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryAll();
}