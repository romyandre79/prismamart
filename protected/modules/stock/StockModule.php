<?php
class StockModule extends CWebModule {
	public function init() {
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		// import the module-level models and components
		$this->setImport(array(
			'stock.components.*',
		));
	}
	public function beforeControllerAction($controller, $action) {
		if (parent::beforeControllerAction($controller, $action)) {
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		} else return false;
	}
	public function Install() {
		$connection	 = Yii::app()->db;
		$sql				 = "select moduleid from modules where lower(modulename) = 'admin'";
		$adminid		 = $connection->createCommand($sql)->queryScalar();
		if ($adminid > 0) {
      $sql			 = "select moduleid from modules where lower(modulename) = 'adminerp'";
      $adminerpid	 = $connection->createCommand($sql)->queryScalar();
      if ($adminerpid > 0) {
        $sql			 = "select moduleid from modules where lower(modulename) = 'common'";
				$commonid	 = $connection->createCommand($sql)->queryScalar();
				if ($commonid > 0) {
					$this->UnInstall();
					$sql = "insert into modules (modulename,description,createdby,moduleversion,installdate,themeid,recordstatus) 
						values ('stock','Stock Module','Prisma Data Abadi','1.0',now(),2,1)";
					$connection->createCommand($sql)->execute();

					$sql			 = "select moduleid from modules where lower(modulename) = 'stock'";
					$moduleid	 = $connection->createCommand($sql)->queryScalar();

					$sql = "replace into modulerelation (moduleid,relationid)
						values (".$moduleid.",".$adminid.")";
          $connection->createCommand($sql)->execute();
          
					$sql = "replace into modulerelation (moduleid,relationid)
						values (".$moduleid.",".$adminerpid.")";
					$connection->createCommand($sql)->execute();

					$sql = "replace into modulerelation (moduleid,relationid)
						values (".$moduleid.",".$commonid.")";
					$connection->createCommand($sql)->execute();

					$sql = "replace into widget (widgetname,widgettitle,widgetversion,widgetby,description,widgeturl,moduleid,recordstatus)
						values ('materialstockoverview','Material Stock Overview','0.1','Prisma Data Abadi','Material Stock Overiew','materialstockoverview',".$moduleid.",1)";
					$connection->createCommand($sql)->execute();

					$sql			 = "select max(sortorder) from menuaccess where menuurl is null";
					$sortorder = $connection->createCommand($sql)->queryScalar() + 1;

					$sql = "replace into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus)
						values ('stock','Material Stock','Material Stock',".$moduleid.",null,null,".$sortorder.",1)";
					$connection->createCommand($sql)->execute();

					$sql				 = "select menuaccessid from menuaccess where lower(menuname) = 'stock'";
					$menuparent	 = $connection->createCommand($sql)->queryScalar();

					$sql = "
						replace into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
						values ('formrequest','Form Request','Form Request',".$moduleid.",".$menuparent.",'formrequest',1,1);

						replace into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
						values ('prheader','Purchase Requisition','Purchase Requisition',".$moduleid.",".$menuparent.",'prheader',2,1);

						replace into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
						values ('stockopname','Stock Opname','Stock Opname',".$moduleid.",".$menuparent.",'stockopname',3,1);
						
						replace into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
						values ('productstock','Material Stock Overvew','Material Stock Overvew',".$moduleid.",".$menuparent.",'productstock',4,1);
						
						replace into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
						values ('productdetail','Material Detail','Material Detail',".$moduleid.",".$menuparent.",'productdetail',5,1);
					";
					$connection->createCommand($sql)->execute();

					$sql = "
						replace into groupmenu (groupaccessid,menuaccessid,isread,iswrite,ispost,isreject,ispurge,isupload,isdownload)
						select 2,menuaccessid,1,1,1,1,1,1,1
						from menuaccess 
						where moduleid = ".$moduleid."
						";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE TABLE IF NOT EXISTS `formrequest` (
              `formrequestid` INT(11) NOT NULL AUTO_INCREMENT,
              `frdate` DATE NOT NULL,
              `companyid` INT(11) NOT NULL,
              `frno` VARCHAR(50) NULL DEFAULT NULL,
              `productplanid` INT(11) NULL DEFAULT NULL,
              `slocid` INT(11) NOT NULL,
              `headernote` TEXT NULL,
              `useraccessid` INT(11) NULL DEFAULT NULL,
              `recordstatus` TINYINT(4) NOT NULL DEFAULT '1',
              PRIMARY KEY (`formrequestid`),
              INDEX `fk_fr_com` (`companyid`),
              INDEX `fk_fr_sloc` (`slocid`),
              CONSTRAINT `fk_fr_com` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`),
              CONSTRAINT `fk_fr_sloc` FOREIGN KEY (`slocid`) REFERENCES `sloc` (`slocid`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
          ";
					$connection->createCommand($sql)->execute();

					$sql = "
            CREATE TABLE IF NOT EXISTS `formrequestdet` (
              `formrequestdetid` INT(11) NOT NULL AUTO_INCREMENT,
              `formrequestid` INT(11) NOT NULL,
              `productid` INT(11) NOT NULL,
              `qty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
              `poqty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
              `grqty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
              `tsqty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
              `prqty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
              `unitofmeasureid` INT(11) NOT NULL DEFAULT '0',
              `productplandetailid` INT(11) NULL DEFAULT NULL,
              `reqdate` DATE NULL DEFAULT NULL,
              `slocid` INT(11) NOT NULL,
              `itemtext` TEXT NULL,
              PRIMARY KEY (`formrequestdetid`),
              INDEX `fk_frdet_pro` (`productid`),
              INDEX `fk_frdet_uom` (`unitofmeasureid`),
              INDEX `fk_frdet_sloc` (`slocid`),
              INDEX `fk_frdet_ppdet` (`productplandetailid`),
              CONSTRAINT `fk_frdet_pro` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`),
              CONSTRAINT `fk_frdet_sloc` FOREIGN KEY (`slocid`) REFERENCES `sloc` (`slocid`),
              CONSTRAINT `fk_frdet_uom` FOREIGN KEY (`unitofmeasureid`) REFERENCES `unitofmeasure` (`unitofmeasureid`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
          ";
					$connection->createCommand($sql)->execute();

					$sql = "
            CREATE TABLE IF NOT EXISTS `prheader` (
              `prheaderid` INT(11) NOT NULL AUTO_INCREMENT,
              `prdate` DATE NOT NULL,
              `companyid` INT(11) NOT NULL,
              `prno` VARCHAR(50) NULL DEFAULT NULL,
              `formrequestid` INT(10) NULL DEFAULT NULL,
              `headernote` TEXT NULL,
              `recordstatus` TINYINT(4) NOT NULL DEFAULT '1',
              PRIMARY KEY (`prheaderid`),
              INDEX `fk_prh_fr` (`formrequestid`),
              INDEX `fk_prh_com` (`companyid`),
              CONSTRAINT `fk_prh_com` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`),
              CONSTRAINT `fk_prh_fr` FOREIGN KEY (`formrequestid`) REFERENCES `formrequest` (`formrequestid`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
          ";
					$connection->createCommand($sql)->execute();

					$sql = "
            CREATE TABLE IF NOT EXISTS `prmaterial` (
              `prmaterialid` INT(11) NOT NULL AUTO_INCREMENT,
              `prheaderid` INT(11) NOT NULL,
              `productid` INT(11) NOT NULL,
              `qty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
              `unitofmeasureid` INT(11) NOT NULL,
              `reqdate` DATE NULL DEFAULT NULL,
              `itemtext` TEXT NULL,
              `poqty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
              `formrequestdetid` INT(10) NULL DEFAULT NULL,
              `grqty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
              `giqty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
              PRIMARY KEY (`prmaterialid`),
              INDEX `fk_prm_pro` (`productid`),
              INDEX `fk_prm_uom` (`unitofmeasureid`),
              CONSTRAINT `fk_prm_pro` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`),
              CONSTRAINT `fk_prm_uom` FOREIGN KEY (`unitofmeasureid`) REFERENCES `unitofmeasure` (`unitofmeasureid`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
          ";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE TABLE IF NOT EXISTS `stockopname` (
              `stockopnameid` INT(11) NOT NULL AUTO_INCREMENT,
              `transdate` DATE NOT NULL,
              `slocid` INT(10) NOT NULL,
              `stockopnameno` VARCHAR(50) NULL DEFAULT NULL,
              `headernote` TEXT NOT NULL,
              `recordstatus` TINYINT(4) NOT NULL DEFAULT '1',
              PRIMARY KEY (`stockopnameid`),
              INDEX `fk_stokopname_sloc` (`slocid`),
              CONSTRAINT `fk_stokopname_sloc` FOREIGN KEY (`slocid`) REFERENCES `sloc` (`slocid`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB
					";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE TABLE IF NOT EXISTS `stockopnamedet` (
	`stockopnamedetid` INT(11) NOT NULL AUTO_INCREMENT,
	`stockopnameid` INT(11) NOT NULL,
	`productid` INT(11) NOT NULL,
	`unitofmeasureid` INT(11) NOT NULL,
	`storagebinid` INT(11) NOT NULL,
	`qty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
	`buyprice` INT(10) NOT NULL,
	`buydate` DATE NOT NULL,
	`currencyid` INT(11) NOT NULL,
	`expiredate` DATE NOT NULL,
	`materialstatusid` INT(10) NOT NULL,
	`ownershipid` INT(10) NOT NULL,
	`serialno` VARCHAR(50) NOT NULL,
	`location` VARCHAR(50) NOT NULL,
	`itemnote` TEXT NOT NULL,
	PRIMARY KEY (`stockopnamedetid`),
	INDEX `fk_stokonamedet_pro` (`productid`),
	INDEX `fk_stokopnamedet_uom` (`unitofmeasureid`),
	INDEX `fk_stokopnamedet_cur` (`currencyid`),
	INDEX `fk_stokopnamedet_mat` (`materialstatusid`),
	INDEX `fk_stokopnamedet_own` (`ownershipid`),
	INDEX `fk_stokopnamedet_sbin` (`storagebinid`),
	CONSTRAINT `fk_stokopnamedet_sbin` FOREIGN KEY (`storagebinid`) REFERENCES `storagebin` (`storagebinid`),
	CONSTRAINT `fk_stokonamedet_pro` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`),
	CONSTRAINT `fk_stokopnamedet_cur` FOREIGN KEY (`currencyid`) REFERENCES `currency` (`currencyid`),
	CONSTRAINT `fk_stokopnamedet_mat` FOREIGN KEY (`materialstatusid`) REFERENCES `materialstatus` (`materialstatusid`),
	CONSTRAINT `fk_stokopnamedet_own` FOREIGN KEY (`ownershipid`) REFERENCES `ownership` (`ownershipid`),
	CONSTRAINT `fk_stokopnamedet_uom` FOREIGN KEY (`unitofmeasureid`) REFERENCES `unitofmeasure` (`unitofmeasureid`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB";
					$connection->createCommand($sql)->execute();


					$sql = "CREATE TABLE IF NOT EXISTS `productstock` (
	`productstockid` INT(11) NOT NULL AUTO_INCREMENT,
	`productid` INT(11) NOT NULL,
	`slocid` INT(11) NOT NULL,
	`storagebinid` INT(11) NOT NULL,
	`addressbookid` INT(11) NULL,
	`qty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
	`unitofmeasureid` INT(11) NOT NULL,
	`qtyinprogress` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
	PRIMARY KEY (`productstockid`),
	UNIQUE INDEX `uq_prodstock_pssu` (`productid`, `slocid`, `storagebinid`, `unitofmeasureid`),
	INDEX `fk_prodstock_pro` (`productid`),
	INDEX `fk_prodstock_sloc` (`slocid`),
	INDEX `fk_prodstock_uom` (`unitofmeasureid`),
	INDEX `fk_prodstock_sbin` (`storagebinid`),
	INDEX `fk_prodstock_ab` (`addressbookid`),
	CONSTRAINT `fk_prodstock_pro` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`),
	CONSTRAINT `fk_prodstock_ab` FOREIGN KEY (`addressbookid`) REFERENCES `addressbook` (`addressbookid`),
	CONSTRAINT `fk_prodstock_sbin` FOREIGN KEY (`storagebinid`) REFERENCES `storagebin` (`storagebinid`),
	CONSTRAINT `fk_prodstock_sloc` FOREIGN KEY (`slocid`) REFERENCES `sloc` (`slocid`),
	CONSTRAINT `fk_prodstock_uom` FOREIGN KEY (`unitofmeasureid`) REFERENCES `unitofmeasure` (`unitofmeasureid`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
					";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE TABLE IF NOT EXISTS `productstockdet` (
	`productstockdetid` INT(11) NOT NULL AUTO_INCREMENT,
	`productdetid` INT(10) NOT NULL,
	`qtydet` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
	`uomdetid` INT(10) NOT NULL,
	`slocdetid` INT(10) NOT NULL,
	`addressbookid` INT(10) NULL,
	`referenceno` VARCHAR(50) NOT NULL,
	`productstockid` INT(10) NOT NULL,
	`storagebindetid` INT(11) NOT NULL,
	`transdate` DATE NOT NULL,
	PRIMARY KEY (`productstockdetid`),
	INDEX `fk_prodstockdet_ab` (`addressbookid`),
	INDEX `fk_prodstockdet_pro` (`productdetid`),
	INDEX `fk_prodstockdet_uom` (`uomdetid`),
	INDEX `fk_prodstockdet_sloc` (`slocdetid`),
	INDEX `fk_prodstockdet_sbin` (`storagebindetid`),
	CONSTRAINT `fk_prodstockdet_ab` FOREIGN KEY (`addressbookid`) REFERENCES `addressbook` (`addressbookid`),
	CONSTRAINT `fk_prodstockdet_pro` FOREIGN KEY (`productdetid`) REFERENCES `product` (`productid`),
	CONSTRAINT `fk_prodstockdet_sbin` FOREIGN KEY (`storagebindetid`) REFERENCES `storagebin` (`storagebinid`),
	CONSTRAINT `fk_prodstockdet_sloc` FOREIGN KEY (`slocdetid`) REFERENCES `sloc` (`slocid`),
	CONSTRAINT `fk_prodstockdet_uom` FOREIGN KEY (`uomdetid`) REFERENCES `unitofmeasure` (`unitofmeasureid`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
					";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE TABLE IF NOT EXISTS `productdetail` (
	`productdetailid` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`materialcode` VARCHAR(50) NOT NULL,
	`productid` INT(10) NOT NULL,
	`slocid` INT(10) NOT NULL,
	`storagebinid` INT(11) NOT NULL,
	`qty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
	`unitofmeasureid` INT(10) NOT NULL,
	`buydate` DATE NOT NULL,
	`expiredate` DATE NOT NULL,
	`buyprice` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
	`currencyid` INT(10) NOT NULL,
	`location` VARCHAR(150) NOT NULL,
	`locationdate` DATE NOT NULL DEFAULT '0000-00-00',
	`materialstatusid` INT(10) NOT NULL,
	`ownershipid` INT(10) NOT NULL,
	`referenceno` VARCHAR(50) NOT NULL,
	`vrqty` DECIMAL(30,4) NOT NULL DEFAULT '0.0000',
	`serialno` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`productdetailid`),
	UNIQUE INDEX `uq_productdetail` (`productid`, `slocid`, `unitofmeasureid`, `storagebinid`, `materialstatusid`, `ownershipid`),
	INDEX `fk_prodet_pro` (`productid`),
	INDEX `fk_prodet_sloc` (`slocid`),
	INDEX `fk_prodet_uom` (`unitofmeasureid`),
	INDEX `fk_prodet_curr` (`currencyid`),
	INDEX `fk_prodet_sbin` (`storagebinid`),
	INDEX `fk_prodet_matstatus` (`materialstatusid`),
	INDEX `fk_prodet_own` (`ownershipid`),
	CONSTRAINT `fk_prodet_curr` FOREIGN KEY (`currencyid`) REFERENCES `currency` (`currencyid`),
	CONSTRAINT `fk_prodet_matstatus` FOREIGN KEY (`materialstatusid`) REFERENCES `materialstatus` (`materialstatusid`),
	CONSTRAINT `fk_prodet_own` FOREIGN KEY (`ownershipid`) REFERENCES `ownership` (`ownershipid`),
	CONSTRAINT `fk_prodet_pro` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`),
	CONSTRAINT `fk_prodet_sbin` FOREIGN KEY (`storagebinid`) REFERENCES `storagebin` (`storagebinid`),
	CONSTRAINT `fk_prodet_sloc` FOREIGN KEY (`slocid`) REFERENCES `sloc` (`slocid`),
	CONSTRAINT `fk_prodet_uom` FOREIGN KEY (`unitofmeasureid`) REFERENCES `unitofmeasure` (`unitofmeasureid`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE TABLE  IF NOT EXISTS `productdetailhist` (
	`productdetailhistid` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`slocid` INT(10) NOT NULL,
	`expiredate` DATE NOT NULL,
	`serialno` VARCHAR(50) NULL DEFAULT NULL,
	`qty` DECIMAL(30,6) NOT NULL,
	`unitofmeasureid` INT(10) NOT NULL,
	`buydate` DATE NULL DEFAULT NULL,
	`buyprice` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
	`currencyid` INT(10) NOT NULL,
	`productid` INT(10) NOT NULL,
	`storagebinid` INT(11) NOT NULL,
	`location` VARCHAR(150) NOT NULL,
	`locationdate` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	`materialcode` VARCHAR(50) NULL DEFAULT NULL,
	`materialstatusid` INT(10) NOT NULL,
	`ownershipid` INT(10) NOT NULL,
	`referenceno` VARCHAR(50) NOT NULL,
	`productdetailid` INT(10) NOT NULL,
	PRIMARY KEY (`productdetailhistid`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE PROCEDURE `Insertformrequest`(
	IN `vactiontype` INT,
	IN `vformrequestid` INT,
	IN `vfrdate` DATE,
	IN `vcompanyid` INT,
	IN `vslocid` INT,
	IN `vheadernote` TEXT,
	IN `vrecordstatus` TINYINT,
	IN `vuseraccessid` INT,
	IN `vcreatedby` VARCHAR(50)

)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
	declare k int;if (vactiontype = 0) then
  		insert into formrequest (companyid,frdate,slocid,headernote,recordstatus,useraccessid)
  		values (vcompanyid,vfrdate,vslocid,vheadernote,vrecordstatus,vuseraccessid);set k = last_insert_id();else
	  	if (vactiontype = 1) then
	  		update formrequest
	  		set companyid = vcompanyid, 
			  frdate = vfrdate,slocid = vslocid,headernote=vheadernote
	  		where formrequestid = vformrequestid;set k = vformrequestid;end if;end if;update formrequestdet
		  	set formrequestid = k
		  	where formrequestid = vformrequestid;END
          ";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE PROCEDURE `InsertPrheader`(
	IN `vactiontype` INT,
	IN `vprheaderid` INT,
	IN `vprdate` DATE,
	IN `vcompanyid` INT,
	IN `vformrequestid` INT,
	IN `vheadernote` TEXT,
	IN `vrecordstatus` TINYINT,
	IN `vcreatedby` VARCHAR(50)

)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
	declare k int;if (vactiontype = 0) then
  		insert into prheader (companyid,prdate,formrequestid,headernote,recordstatus)
  		values (vcompanyid,vprdate,vformrequestid,vheadernote,vrecordstatus);set k = last_insert_id();else
	  	if (vactiontype = 1) then
	  		update prheader
	  		set companyid = vcompanyid, 
			  prdate = vprdate,formrequestid = vformrequestid,headernote=vheadernote
	  		where prheaderid = vprheaderid;set k = vformrequestid;end if;end if;update prmaterial
		  	set prheaderid = k
		  	where prheaderid = vprheaderid;END";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE PROCEDURE `Approveformrequest`(
	IN `vid` INT,
	IN `vlastupdateby` VARCHAR(50)

)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
	declare vsnroid,vrecstat,vnextstat,vtypeid,k,m,n,vcompanyid,u integer;declare vpodate date;declare vgrno varchar(50);select abc.frdate, abc.recordstatus, getcompanysloc(abc.slocid)
	into vpodate, vrecstat,vcompanyid
	from formrequest abc
	where abc.formrequestid = vid;select getwfrecstatbycreated('appda',vrecstat,vlastupdateby)
	into vnextstat;select a.snroid
	into vsnroid
	from snro a
	where description = 'Delivery Advice';select ifnull(count(1),0)
into u
from formrequestdet d
inner join formrequest e on e.formrequestid = d.formrequestid
where d.formrequestid = vid and d.unitofmeasureid not in (select xx.unitofissue from productplant xx where xx.productid = d.productid);select ifnull(count(1),0)
into k
from formrequestdet
where formrequestid = vid;select ifnull(count(1),0)
into n
from formrequestdet d
inner join formrequest e on e.formrequestid = d.formrequestid
where d.formrequestid = vid and d.slocid not in (select x.slocid from productplant x where x.productid = d.productid);select ifnull(count(1),0)
into m
from formrequestdet d
inner join formrequest e on e.formrequestid = d.formrequestid
where e.formrequestid = vid and e.slocid not in (select x.slocid from productplant x where x.productid = d.productid);if u = 0 then
if k > 0 then
	if m = 0 then
		if n = 0 then
			if checkaccperiod(vpodate) > 0 then
				if GetWfBefStatByCreated('appda',vrecstat,vlastupdateby) > 0 then
	   			update formrequest
	   			set frno = ifnull(frno, getrunno(vcompanyid,vsnroid,vpodate)),
					recordstatus=vnextstat
	   			where formrequestid = vid;call inserttranslog (vlastupdateby,'approve','','formreqpp',vid);select frno
		   into vgrno
		   from formrequest
		   where formrequestid = vid;call sendnotif('listda',vnextstat,
				'formrequest',
		   	vgrno,(select catalogval from catalogsys where languageid = (select paramvalue from parameter where paramname = 'language') and catalogname = 'approvedoc'));else
CALL pRaiseError('flowapp');end if;else
CALL pRaiseError('periodover');end if;else
  CALL pRaiseError('falsesloc');end if;else
  CALL pRaiseError('falsesloc');end if;else
  CALL pRaiseError('detailempty');end if;else
  CALL pRaiseError('falseunitofmeasure');end if;END";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE PROCEDURE `ApprovePR`(
	IN `vid` INT,
	IN `vlastupdateby` VARCHAR(50)

)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
	declare vsnroid,vrecstat,vnextstat,vslocid,vtypeid,vuomid,vuomgudangid,vproductid,visd, vpoid, vpodetailid,
    vsid,visasset,vgrid,vcurrencyid,k,vcompanyid integer;declare vpostdate,vdate,vbuydate date;declare vgrno varchar(50);declare vconv,vcurrstock,vqty,vqtyres,vbuyprice decimal(30,4);declare vpodate date;DECLARE done INT DEFAULT 0;DECLARE cur1 CURSOR FOR SELECT productid,qty,unitofmeasureid,formrequestdetid,prmaterialid
  FROM prmaterial where prheaderid = vid;DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done=1;select abc.prdate, abc.recordstatus, getcompanysloc(a.slocid)
	into vpodate, vrecstat, vcompanyid
	from prheader abc
	inner join formrequest a on a.formrequestid = abc.formrequestid
	where abc.prheaderid = vid;select getwfrecstatbycreated('apppr',vrecstat,vlastupdateby)
	into vnextstat;select a.snroid
	into vsnroid
	from snro a
	where description = 'Purchase Requisition';select ifnull(count(1),0)
into k
from prmaterial
where prheaderid = vid;if k > 0 then

if checkaccperiod(vpodate) > 0 then
		if GetWfBefStatByCreated('apppr',vrecstat,vlastupdateby) > 0 then
	   		update prheader
	   		set prno = ifnull(prno, getrunno(vcompanyid,vsnroid,vpodate)),
				  recordstatus=vnextstat
	   		where prheaderid = vid;call inserttranslog (vlastupdateby,'approve','','prheader',vid);select prno
into vgrno
from prheader
where prheaderid = vid;call sendnotif('listpr',vnextstat,
				'prheader',
		   	vgrno,(select catalogval from catalogsys where languageid = (select paramvalue from parameter where paramname = 'language') and catalogname = 'approvedoc'));OPEN cur1;read_loop: LOOP
      
      FETCH cur1 INTO vproductid,vqty,vuomid,vpodetailid,visd;IF done THEN
        LEAVE read_loop;END IF;select ifnull(tsqty,0)
      into vqtyres
      from formrequestdet
      where formrequestdetid = vpodetailid;if vqtyres = 0 then

        if getwfcomparemax('apppr',vnextstat,vlastupdateby) = 1 then

      update formrequestdet
      set prqty=prqty + vqty
      where formrequestdetid = vpodetailid;end if;else
        set done=2;CALL pRaiseError('iprover');LEAVE read_loop;end if;END LOOP;CLOSE cur1;else
CALL pRaiseError('flowapp');end if;else
CALL pRaiseError('periodover');end if;else
  CALL pRaiseError('detailempty');end if;END";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE PROCEDURE `Deleteformrequest`(
	IN `vid` INT,
	IN `vlastupdateby` VARCHAR(50)

)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
	declare vsnroid,vrecstat,vnextstat,vtypeid,k integer;declare vpodate date;declare vgrno varchar(50);select abc.frdate, abc.recordstatus,abc.frno
	into vpodate, vrecstat,vgrno
	from formrequest abc
	where abc.formrequestid = vid;select getwfrecstatbycreated('rejda',vrecstat,vlastupdateby)
	into vnextstat;if vnextstat > 0 then
	update formrequest
	set recordstatus=vnextstat
	where formrequestid = vid;call inserttranslog (vlastupdateby,'reject','','formrequest',vid);call sendnotif('listda',vnextstat,
		'formrequest',
	  	vgrno,(select catalogval from catalogsys where languageid = (select paramvalue from parameter where paramname = 'language') and catalogname = 'rejectdoc'));else
  				CALL pRaiseError('flowapp');end if;END";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE PROCEDURE `DeletePR`(
	IN `vid` INT,
	IN `vlastupdateby` VARCHAR(50)

)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
	declare vsnroid,vrecstat,vnextstat,vslocid,vtypeid,vuomid,vuomgudangid,vproductid,visd, vpoid, vpodetailid,
    vsid,visasset,vgrid,vcurrencyid,k integer;declare vpostdate,vdate,vbuydate date;declare vgrno varchar(50);declare vconv,vcurrstock,vqty,vqtyres,vbuyprice decimal(30,4);declare vpodate date;select abc.prdate, abc.recordstatus,abc.prno
	into vpodate, vrecstat, vgrno
	from prheader abc
	where abc.prheaderid = vid;select getwfrecstatbycreated('rejpr',vrecstat,vlastupdateby)
	into vnextstat;update prheader
	   		set  recordstatus=vnextstat
	   		where prheaderid = vid;call inserttranslog (vlastupdateby,'reject','','prheader',vid);call sendnotif('listpr',vnextstat,
				'prheader',
		   	vgrno,(select catalogval from catalogsys where languageid = (select paramvalue from parameter where paramname = 'language') and catalogname = 'rejectdoc'));END";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE PROCEDURE `ApproveStockopname`(IN `vid` INT, IN `vlastupdateby` VARCHAR(50))
	LANGUAGE SQL
	NOT DETERMINISTIC
	CONTAINS SQL
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN
	declare vsnroid,vrecstat,vnextstat,vslocid,vproductid,vtypeid,vuomid,k,l,
  		vbsdetailid,vownershipid,vmaterialstatusid,vmatcode,vcompanyid,vcurrencyid   integer;
  	declare vqty,vprice decimal(30,6);declare vpostdate,vdate,vexpiredate date;
	declare vgrno,vcc,vpt,vpp,vlocation,vstoragebin,vserialno varchar(50);
  	declare vitemnote text;
  	DECLARE done INT DEFAULT 0;
  	DECLARE cur1 CURSOR FOR SELECT stockopnamedetid,productid,qty,unitofmeasureid,itemnote,location,
		expiredate,ownershipid,materialstatusid,storagebinid,currencyid,buyprice,serialno
	FROM stockopnamedet where stockopnameid = vid;
	DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done=1;
	
	select a.transdate, a.transdate, a.recordstatus, a.slocid, d.companyid
	into vpostdate, vdate, vrecstat, vslocid, vcompanyid
	from stockopname a
	inner join sloc b on b.slocid = a.slocid 
	inner join plant c on c.plantid = b.plantid 
	inner join company d on d.companyid = c.companyid
	where a.stockopnameid = vid;
	
	select a.snroid
	into vsnroid 
	from snro a
	where upper(a.formatdoc) like upper('%TSO%');
	
	select getwfrecstatbycreated('appbs',vrecstat,vlastupdateby)
	into vnextstat;
	
	select ifnull(count(1),0)
	into k
	from stockopnamedet
	where stockopnameid = vid;

select ifnull(count(1),0)
into l
from stockopname a
inner join stockopnamedet b on b.stockopnameid = a.stockopnameid
where a.stockopnameid = vid and a.slocid not in 
(select x.slocid from productplant x 
where x.productid = b.productid and x.unitofissue = b.unitofmeasureid);

if k > 0 then
	if l = 0 then
		if checkaccperiod(vpostdate) > 0 then
			if GetWfBefStatByCreated('appbs',vrecstat,vlastupdateby) > 0 then
		   	update stockopname
		   	set stockopnameno = ifnull(stockopnameno,getrunno(vcompanyid,vsnroid,vdate)),
				recordstatus=vnextstat
		   	where stockopnameid = vid;
					
				call inserttranslog (vlastupdateby,'approve','','','stockopname',vid);
				
				select stockopnameno
	   		into vgrno
	   		from stockopname
	   		where stockopnameid = vid;
					
				call sendnotif('listbs',vnextstat,
				(select catalogval from catalogsys where languageid = (select paramvalue from parameter where paramname = 'language') and catalogname = 'bsheader'),
		   	vgrno,(select catalogval from catalogsys where languageid = (select paramvalue from parameter where paramname = 'language') and catalogname = 'approvedoc'));if getwfcomparemax('appbs',vnextstat,vlastupdateby) = 1 then
	
				OPEN cur1;read_loop: LOOP
	   		FETCH cur1 INTO vbsdetailid,vproductid,vqty,vuomid,vitemnote,
						 vlocation,vexpiredate,vownershipid,vmaterialstatusid,vstoragebin,vcurrencyid,vprice,vserialno;
					IF done THEN
	     			LEAVE read_loop;
					END IF;
					  
					call insertstock (vgrno,vcompanyid,vproductid,vuomid,vslocid,vstoragebin,vqty,0,vdate,vexpiredate,vprice,vcurrencyid,vlocation,
						vdate,vmaterialstatusid,vownershipid,vserialno);
						
				END LOOP;
				CLOSE cur1;
			end if;
			else
  				CALL pRaiseError('flowapp');
  			end if;
  		else
  			CALL pRaiseError('periodover');
  		end if;
	else
		CALL pRaiseError('falsesloc');
  	end if;
else
  CALL pRaiseError('detailempty');
end if;
END";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE PROCEDURE `InsertStockopname`(IN `vactiontype` TINYINT, IN `vstockopnameid` INT, IN `vtransdate` DATE, IN `vslocid` INT, IN `vheadernote` TEXT, IN `vrecordstatus` TINYINT, IN `vcreatedby` VARCHAR(50))
	LANGUAGE SQL
	NOT DETERMINISTIC
	CONTAINS SQL
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN
	declare k int;if (vactiontype = 0) then
  		insert into stockopname (slocid,transdate,headernote,recordstatus)
  		values (vslocid,vtransdate,vheadernote,vrecordstatus);set k = last_insert_id();else
	  	if (vactiontype = 1) then
	  		update stockopname
	  		set slocid = vslocid,transdate = vtransdate,headernote = vheadernote
	  		where stockopnameid = vstockopnameid;set k = vstockopnameid;end if;end if;update stockopnamedet
  	set stockopnameid = k
  	where stockopnameid = vstockopnameid;END";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE PROCEDURE `InsertStock`(IN `vreferenceno` VARCHAR(50), IN `vcompanyid` INT, IN `vproductid` INT, IN `vuomid` INT, IN `vslocid` INT, IN `vstoragebinid` INT, IN `vqty` DECIMAL(30,6), IN `vqtyinprogress` DECIMAL(30,6), IN `vbuydate` DATE, IN `vexpiredate` DATE, IN `vbuyprice` DECIMAL(30,6), IN `vcurrencyid` INT, IN `vlocation` TEXT, IN `vlocationdate` DATE, IN `vmaterialstatusid` INT, IN `vownershipid` INT, IN `vserialno` VARCHAR(50))
	LANGUAGE SQL
	NOT DETERMINISTIC
	CONTAINS SQL
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN
	declare k,vsnroid int;
	declare vcc varchar(50);
	
	select snroid
	into vsnroid
	from productplant 
	where productid = vproductid and slocid = vslocid and unitofissue = vuomid;
	
	select ifnull(count(1),0)
	into k
	from productstock
	where productid = vproductid and unitofmeasureid = vuomid and slocid = vslocid and storagebinid = vstoragebinid;
	
	if k > 0 then
		select productstockid
		into k
		from productstock
		where productid = vproductid and unitofmeasureid = vuomid and slocid = vslocid and storagebinid = vstoragebinid;
		
		update productstock
		set qty = ifnull(qty,0)+vqty,qtyinprogress = ifnull(qtyinprogress,0) + vqtyinprogress
		where productstockid = k;
		
	else
		insert into productstock (productid,slocid,storagebinid,qty,unitofmeasureid,qtyinprogress)
		values (vproductid,vslocid,vstoragebinid,vqty,vuomid,0);
		
		set k = last_insert_id();
		
	end if;
		
	insert into productstockdet (referenceno,productstockid,productdetid,slocdetid,storagebindetid,qtydet,uomdetid,transdate)
	values (vreferenceno,k,vproductid,vslocid,vstoragebinid,vqty,vuomid,vbuydate);
	
	select ifnull(count(1),0)
	into k
	from productdetail
	where productid = vproductid and unitofmeasureid = vuomid and slocid = vslocid and storagebinid = vstoragebinid;
	
	if k > 0 then
		select productdetailid
		into k
		from productdetail
		where productid = vproductid and unitofmeasureid = vuomid and slocid = vslocid and storagebinid = vstoragebinid;
		
		update productdetail
		set qty = ifnull(qty,0)+vqty,buydate = vbuydate,buyprice = vbuyprice,expiredate = vexpiredate
		where productdetailid = k;
	else
		set vcc=getrunno(vcompanyid,vsnroid,vbuydate);
		
		insert into productdetail (referenceno,materialcode,productid,slocid,storagebinid,qty,unitofmeasureid,materialstatusid,ownershipid,currencyid,buydate,expiredate,buyprice,location,locationdate)
		values (vreferenceno,vcc, vproductid,vslocid,vstoragebinid,vqty,vuomid,vmaterialstatusid,vownershipid,vcurrencyid,vbuydate,vexpiredate,vbuyprice,vlocation,vlocationdate);
		
		set k = last_insert_id();
	end if;
		
	insert into productdetailhist (referenceno,productdetailid,productid,slocid,storagebinid,qty,unitofmeasureid,materialcode,materialstatusid,ownershipid,currencyid,buydate,expiredate,buyprice,
		location,locationdate)
	values (vreferenceno,k,vproductid,vslocid,vstoragebinid,vqty,vuomid,vcc,vmaterialstatusid,vownershipid,vcurrencyid,vbuydate,vexpiredate,vbuyprice,
		vlocation,vlocationdate);
END";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE PROCEDURE `DeleteStockopname`(IN `vid` INT, IN `vlastupdateby` VARCHAR(50))
	LANGUAGE SQL
	NOT DETERMINISTIC
	CONTAINS SQL
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN
	declare vsnroid,vrecstat,vnextstat,vslocid,vproductid,vtypeid,vuomid,k,
  vbsdetailid,vownershipid,vmaterialstatusid,vmatcode   integer;
declare vqty decimal(30,4);
	declare vpostdate,vdate,vexpiredate date;
	declare vgrno,vcc,vpt,vpp,vlocation,vserialno,vstoragebin varchar(50);
	declare vitemnote text;

	select a.transdate, a.transdate, a.recordstatus, a.slocid,a.stockopnameno
	into vpostdate, vdate, vrecstat, vslocid,vgrno
	from stockopname a
	where a.stockopnameid = vid;

	select a.snroid
	from snro a
	where upper(a.description) = upper('Tools Stock');

	select getwfrecstatbycreated('rejbs',vrecstat,vlastupdateby)
	into vnextstat;

   		update stockopname
	   		set recordstatus=vnextstat
	   		where stockopnameid = vid;
	   		
	   		call inserttranslog (vlastupdateby,'reject','','','stockopname',vid);

call sendnotif('listbs',vnextstat,
				(select catalogval from catalogsys where languageid = (select paramvalue from parameter where paramname = 'language') and catalogname = 'stockopname'),
		   	vgrno,(select catalogval from catalogsys where languageid = (select paramvalue from parameter where paramname = 'language') and catalogname = 'rejectdoc'));
END";
					$connection->createCommand($sql)->execute();

					$sql = "CREATE FUNCTION `GetStock`(
	`vproductid` int,
	`vuomid` int,
	`vslocid` int
)
RETURNS decimal(30,6)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
	declare k decimal(30,6);
	select ifnull(sum(a0.qty),0)
	into k
	from productstock a0
	where a0.productid = vproductid and a0.unitofmeasureid = vuomid and a0.slocid = vslocid;
	return k; 
END";
					$connection->createCommand($sql)->execute();
					return "ok";
				} else {
					return "Need module Common to be installed";
				}
				} else {
					return "Need module Admin ERP to be installed";
				}
		} else {
			return "Need module Admin to be installed";
		}
	}
	public function UnInstall() {
		$connection	 = Yii::app()->db;
		$sql				 = "select moduleid from modules where modulename = 'stock'";
		$module			 = $connection->createCommand($sql)->queryScalar();

		if ($module > 0) {
			$sql = "delete from menuaccess where moduleid = ".$module;
			$connection->createCommand($sql)->execute();

			$sql = "delete from modulerelation where moduleid = ".$module;
			$connection->createCommand($sql)->execute();

			$sql = "delete from widget where moduleid = ".$module;
			$connection->createCommand($sql)->execute();

			$sql = "delete from modules where modulename = 'stock'";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists prmaterial";
      $connection->createCommand($sql)->execute();

			$sql = "drop table if exists prheader";
      $connection->createCommand($sql)->execute();

			$sql = "drop table if exists formrequestdet";
      $connection->createCommand($sql)->execute();

			$sql = "drop table if exists formrequest";
      $connection->createCommand($sql)->execute();
      
			$sql = "drop table if exists productdetailhist";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists productdetail";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists productstockdet";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists productstock";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists stockopnamedet";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists stockopname";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists Insertformrequest";
      $connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists Deleteformrequest";
      $connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists Approveformrequest";
      $connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists InsertPrheader";
      $connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists ApprovePR";
      $connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists DeletePR";
      $connection->createCommand($sql)->execute();
      
			$sql = "drop procedure if exists approvestockopname";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists insertstock";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists deletestockopname";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists insertstockopname";
      $connection->createCommand($sql)->execute();
      
			$sql = "drop function if exists GetStock";
			$connection->createCommand($sql)->execute();
		}
		return "ok";
	}
}