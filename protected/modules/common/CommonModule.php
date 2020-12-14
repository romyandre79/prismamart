<?php
class CommonModule extends CWebModule {
	public function init() {
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		// import the module-level models and components
		$this->setImport(array(
			'common.components.*',
		));
	}
	public function beforeControllerAction($controller, $action) {
		if (parent::beforeControllerAction($controller, $action)) {
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		} else return false;
	}
	public function UnInstall() {
		$connection	 = Yii::app()->db;
		$sql				 = "select moduleid from modules where modulename = 'common'";
		$module			 = $connection->createCommand($sql)->queryScalar();
		if ($module > 0) {
			$sql = "delete from menuaccess where moduleid = ".$module;
			$connection->createCommand($sql)->execute();

			$sql = "delete from modulerelation where moduleid = ".$module;
			$connection->createCommand($sql)->execute();

			$sql = "delete from modules where moduleid = ".$module;
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists tax";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists insertsupplier";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists insertcustomer";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists paymentmethod";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists productsales";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists productplant";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists product";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists ownership";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists materialstatus";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists materialgroup";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists materialtype";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists salesarea";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists pricecategory";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists unitofmeasure";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists storagebin";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists sloc";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists plant";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists romawi";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists identitytype";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists contacttype";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists addresstype";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists accperiod";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists tax";
      $connection->createCommand($sql)->execute();
      
			$sql = "drop table if exists address";
      $connection->createCommand($sql)->execute();
      
			$sql = "drop table if exists addresscontact";
      $connection->createCommand($sql)->execute();
      
			$sql = "drop table if exists addressbook";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists InsertSloc";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists InsertProduct";
			$connection->createCommand($sql)->execute();
		}
		return "ok";
	}
	public function Install() {
		$this->UnInstall();
		$connection	 = Yii::app()->db;
		$sql				 = "select moduleid from modules where lower(modulename) = 'admin'";
		$adminid		 = $connection->createCommand($sql)->queryScalar();
		if ($adminid > 0) {
			$sql = "insert into modules (modulename,description,createdby,moduleversion,installdate,themeid,recordstatus)
					values ('common','Common Module','Prisma Data Abadi','1.0',now(),2,1)";
			$connection->createCommand($sql)->execute();

			$sql			 = "select moduleid from modules where lower(modulename) = 'common'";
			$moduleid	 = $connection->createCommand($sql)->queryScalar();

			$sql = "insert into modulerelation (moduleid,relationid)
					values (".$moduleid.",".$adminid.")";
			$connection->createCommand($sql)->execute();

			$sql			 = "select max(sortorder) from menuaccess where menuurl is null";
			$sortorder = $connection->createCommand($sql)->queryScalar() + 1;

			$sql = "insert into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus)
					values ('common','Common','Common',".$moduleid.",null,null,".$sortorder.",1)";
			$connection->createCommand($sql)->execute();

			$sql				 = "select menuaccessid from menuaccess where lower(menuname) = 'common'";
			$menuparent	 = $connection->createCommand($sql)->queryScalar();

			$sql = "
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('accperiod', 'Accounting Period', 'Accounting Period', ".$moduleid.", ".$menuparent.", 'accperiod', 1, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('paymentmethod', 'Payment Method', 'Payment Method', ".$moduleid.", ".$menuparent.", 'paymentmethod', 2, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('addresstype', 'Address Type', 'Address Type', ".$moduleid.", ".$menuparent.", 'addresstype', 3, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('contacttype', 'Contact Type', 'Contact Type', ".$moduleid.", ".$menuparent.", 'contacttype', 4, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('identitytype', 'Identity Type', 'Identity Type', ".$moduleid.", ".$menuparent.", 'identitytype', 5, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('romawi', 'Romawi', 'Romawi', ".$moduleid.", ".$menuparent.", 'romawi', 6, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('plant', 'Plant', 'Plant', ".$moduleid.", ".$menuparent.", 'plant', 7, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('sloc', 'Storage Location', 'Storage Location', ".$moduleid.", ".$menuparent.", 'sloc', 8, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('unitofmeasure', 'Unit of Measure', 'Unit of Measure', ".$moduleid.", ".$menuparent.", 'unitofmeasure', 9, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('pricecategory', 'Price Category', 'Price Category', ".$moduleid.", ".$menuparent.", 'pricecategory', 10, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('salesarea', 'Sales Area', 'Sales Area', ".$moduleid.", ".$menuparent.", 'salesarea', 11, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('materialtype', 'Material Type', 'Material Type', ".$moduleid.", ".$menuparent.", 'materialtype', 12, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('materialgroup', 'Material Group', 'Material Group', ".$moduleid.", ".$menuparent.", 'materialgroup', 13, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('addressbook', '3rd Party', '3rd Party', ".$moduleid.", ".$menuparent.", 'addressbook', 14, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('supplier', 'Supplier', 'Supplier', ".$moduleid.", ".$menuparent.", 'supplier', 15, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('customer', 'Customer', 'Customer', ".$moduleid.", ".$menuparent.", 'customer', 16, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('materialstatus', 'Material Status', 'Material Status', ".$moduleid.", ".$menuparent.", 'materialstatus', 17, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('ownership', 'Ownership', 'Ownership', ".$moduleid.", ".$menuparent.", 'ownership', 18, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('product', 'Product', 'Product', ".$moduleid.", ".$menuparent.", 'product', 19, 1);
					insert INTO `menuaccess` (`menuname`, `menutitle`, `description`, `moduleid`, `parentid`, `menuurl`, `sortorder`, `recordstatus`) VALUES ('tax', 'Tax', 'Tax', ".$moduleid.", ".$menuparent.", 'tax', 20, 1);
				";
			$connection->createCommand($sql)->execute();

			$sql = "
					insert into groupmenu (groupaccessid,menuaccessid,isread,iswrite,ispost,isreject,ispurge,isupload,isdownload)
					select 2,menuaccessid,1,1,1,1,1,1,1
					from menuaccess 
					where moduleid = ".$moduleid;
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `accperiod` (
					`accperiodid` INT(11) NOT NULL AUTO_INCREMENT,
					`period` DATE NOT NULL,
					`recordstatus` TINYINT(4) NOT NULL,
					PRIMARY KEY (`accperiodid`),
					INDEX `ix_accperiod` (`accperiodid`, `period`, `recordstatus`)
				)
				COLLATE='utf8_general_ci'
				ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `addresstype` (
						`addresstypeid` INT(11) NOT NULL AUTO_INCREMENT,
						`addresstypename` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL DEFAULT '0',
						PRIMARY KEY (`addresstypeid`),
						UNIQUE INDEX `uq_addresstype` (`addresstypename`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
					";
			$connection->createCommand($sql)->execute();

			$sql = "
					insert INTO `addresstype` (`addresstypeid`, `addresstypename`, `recordstatus`) VALUES (1, 'Rumah', 1);
					insert INTO `addresstype` (`addresstypeid`, `addresstypename`, `recordstatus`) VALUES (2, 'Tempat Tinggal Sekarang', 1);
					insert INTO `addresstype` (`addresstypeid`, `addresstypename`, `recordstatus`) VALUES (3, 'Alamat Pemilik sesuai KTP', 1);
					insert INTO `addresstype` (`addresstypeid`, `addresstypename`, `recordstatus`) VALUES (4, 'Kantor Pusat', 1);
					insert INTO `addresstype` (`addresstypeid`, `addresstypename`, `recordstatus`) VALUES (5, 'Kantor Cabang', 1);
					insert INTO `addresstype` (`addresstypeid`, `addresstypename`, `recordstatus`) VALUES (6, 'Alamat NPWP', 1);
					insert INTO `addresstype` (`addresstypeid`, `addresstypename`, `recordstatus`) VALUES (7, 'Alamat Customer (Toko)', 1);";
      $connection->createCommand($sql)->execute();
      
      $sql = "CREATE TABLE `contacttype` (
        `contacttypeid` INT(11) NOT NULL AUTO_INCREMENT,
        `contacttypename` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
        `recordstatus` TINYINT(4) NOT NULL,
        `createddate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updatedate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`contacttypeid`) USING BTREE,
        UNIQUE INDEX `uq_contacttype_conname` (`contacttypename`) USING BTREE,
        INDEX `ix_contacttype` (`contacttypeid`, `contacttypename`, `recordstatus`) USING BTREE
      )
      COLLATE='utf8_general_ci'
      ENGINE=InnoDB;
      ";
      $connection->createCommand($sql)->execute();

      $sql = "
          insert INTO `contacttype` (`contacttypeid`, `contacttypename`, `recordstatus`) VALUES (1, 'Purchasing', 1);
          insert INTO `contacttype` (`contacttypeid`, `contacttypename`, `recordstatus`) VALUES (2, 'Marketing', 1);
          insert INTO `contacttype` (`contacttypeid`, `contacttypename`, `recordstatus`) VALUES (3, 'Direktur', 1);";
      $connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `identitytype` (
						`identitytypeid` INT(11) NOT NULL AUTO_INCREMENT,
						`identitytypename` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL,
						PRIMARY KEY (`identitytypeid`),
						UNIQUE INDEX `uq_identitytypename` (`identitytypename`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
					";
			$connection->createCommand($sql)->execute();

			$sql = "
					insert INTO `identitytype` (`identitytypeid`, `identitytypename`, `recordstatus`) VALUES (1, 'Kartu Tanda Penduduk (KTP)', 1);
					insert INTO `identitytype` (`identitytypeid`, `identitytypename`, `recordstatus`) VALUES (2, 'Surat Ijin Mengemudi tipe A (SIM A)', 1);
					insert INTO `identitytype` (`identitytypeid`, `identitytypename`, `recordstatus`) VALUES (3, 'Passport', 1);
					insert INTO `identitytype` (`identitytypeid`, `identitytypename`, `recordstatus`) VALUES (4, 'Surat Ijin Mengemudi tipe C (SIM C)', 1);";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `romawi` (
						`romawiid` INT(11) NOT NULL AUTO_INCREMENT,
						`monthcal` INT(11) NOT NULL,
						`monthrm` VARCHAR(10) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL,
						PRIMARY KEY (`romawiid`),
						UNIQUE INDEX `uq_romawi` (`monthcal`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
					";
			$connection->createCommand($sql)->execute();

			$sql = "
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (1, 1, 'A', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (2, 2, 'B', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (3, 3, 'C', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (4, 4, 'D', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (5, 5, 'E', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (6, 6, 'F', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (7, 7, 'G', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (8, 8, 'H', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (9, 9, 'I', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (10, 10, 'J', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (11, 11, 'K', 1);
					insert INTO `romawi` (`romawiid`, `monthcal`, `monthrm`, `recordstatus`) VALUES (12, 12, 'L', 1);";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `plant` (
						`plantid` INT(11) NOT NULL AUTO_INCREMENT,
						`companyid` INT(11) NOT NULL DEFAULT '1',
						`plantcode` VARCHAR(10) NOT NULL,
						`description` VARCHAR(50) NOT NULL,
						`plantaddress` TEXT NOT NULL,
						`lat` FLOAT(10,6) NOT NULL,
						`lng` FLOAT(10,6) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL,
						PRIMARY KEY (`plantid`),
						UNIQUE INDEX `uq_plant` (`plantcode`),
						INDEX `fk_plant_com` (`companyid`),
						CONSTRAINT `fk_plant_com` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
					";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `sloc` (
						`slocid` INT(11) NOT NULL AUTO_INCREMENT,
						`plantid` INT(11) NOT NULL,
						`sloccode` VARCHAR(20) NOT NULL,
						`description` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL DEFAULT '0',
						PRIMARY KEY (`slocid`),
						INDEX `fk_sloc_plant` (`plantid`),
						CONSTRAINT `fk_sloc_plant` FOREIGN KEY (`plantid`) REFERENCES `plant` (`plantid`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
					";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `storagebin` (
						`storagebinid` INT(10) NOT NULL AUTO_INCREMENT,
						`slocid` INT(10) NULL DEFAULT NULL,
						`description` VARCHAR(50) NULL DEFAULT NULL,
						`ismultiproduct` TINYINT(4) NULL DEFAULT '1',
						`qtymax` DECIMAL(30,6) NULL DEFAULT '0.000000',
						`recordstatus` TINYINT(4) NULL DEFAULT '1',
						PRIMARY KEY (`storagebinid`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `unitofmeasure` (
						`unitofmeasureid` INT(11) NOT NULL AUTO_INCREMENT,
						`uomcode` VARCHAR(5) NOT NULL,
						`description` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL DEFAULT '0',
						PRIMARY KEY (`unitofmeasureid`),
						UNIQUE INDEX `uq_uomcode` (`uomcode`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "
				insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (1, 'Kg', 'Kilogram',1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (2, 'Pcs', 'Pcs', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (3, 'Unit', 'Unit', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (4, 'Box', 'Box', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (5, 'Lusin', 'Lusin', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (6, 'Mtr', 'Meter', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (7, 'Roll', 'Roll', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (8, 'Feet', 'Feet', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (9, 'm2', 'meter persegi', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (10, 'Lot', 'Lot', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (11, 'Pack', 'Pack', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (12, 'M3', 'Meter Cubic', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (13, 'CL', 'Coly', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (14, 'Ltr', 'Liter', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (15, 'Pail', 'Pail', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (16, 'Jrg', 'Jerigen', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (17, 'Klg', 'Kaleng', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (18, 'Hr', 'Hour', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (19, 'Prsn', 'Person', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (20, 'Lbr', 'Lembar', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (21, 'Btg', 'Batang', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (22, 'Tbg', 'Tabung', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (23, 'Set', 'Set', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (24, 'Day', 'hari', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (25, 'Zak', 'Karung', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (26, 'PSG', 'Pasang', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (27, 'Dus', 'Dus', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (28, 'Dsc', 'Discount', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (29, 'Rim', 'Rim', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (30, 'Ton', 'Ton', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (31, 'IKT', 'Ikat', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (32, 'Drum', 'Drum', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (33, 'Weeks', 'Weeks', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (34, 'Truck', 'Truck', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (35, 'Btl', 'Botol', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (36, 'Gln', 'galon', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (37, 'ekl', 'engkel', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (38, 'Sht', 'Sheet', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (39, 'Kjg', 'kijang', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (40, 'Ttk', 'titik', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (41, 'Cm', 'Centi Meter', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (42, 'Buk', 'Buku', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (43, 'Bgk', 'Bungkus', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (44, 'Rp', 'Rupiah', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (45, 'Ons', 'Ons', 1);
					insert INTO `unitofmeasure` (`unitofmeasureid`, `uomcode`, `description`, `recordstatus`) VALUES (46, 'Bal', 'Bal', 1);";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `pricecategory` (
						`pricecategoryid` INT(11) NOT NULL AUTO_INCREMENT,
						`categoryname` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL DEFAULT '1',
						PRIMARY KEY (`pricecategoryid`),
						UNIQUE INDEX `uq_pricecategory` (`categoryname`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "
					insert INTO `pricecategory` (`categoryname`, `recordstatus`) VALUES ('Price List', 1);
					insert INTO `pricecategory` (`categoryname`, `recordstatus`) VALUES ('Gold', 1);
					insert INTO `pricecategory` (`categoryname`, `recordstatus`) VALUES ('Silver', 1);
					insert INTO `pricecategory` (`categoryname`, `recordstatus`) VALUES ('Bronze', 1);
				";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `salesarea` (
						`salesareaid` INT(11) NOT NULL AUTO_INCREMENT,
						`areaname` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL DEFAULT '1',
						PRIMARY KEY (`salesareaid`),
						UNIQUE INDEX `uq_salesarea` (`areaname`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "
					insert INTO `salesarea` (`areaname`, `recordstatus`) VALUES ('Sumatera', 1);
					insert INTO `salesarea` (`areaname`, `recordstatus`) VALUES ('Kalimantan', 1);
					insert INTO `salesarea` (`areaname`, `recordstatus`) VALUES ('Sulawesi', 1);
					insert INTO `salesarea` (`areaname`, `recordstatus`) VALUES ('Papua', 1);
					insert INTO `salesarea` (`areaname`, `recordstatus`) VALUES ('Jawa', 1);
					insert INTO `salesarea` (`areaname`, `recordstatus`) VALUES ('Bali', 1);
					insert INTO `salesarea` (`areaname`, `recordstatus`) VALUES ('Nusa Tenggara Timur', 1);
					insert INTO `salesarea` (`areaname`, `recordstatus`) VALUES ('Maluku', 1);
				";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `materialtype` (
						`materialtypeid` INT(11) NOT NULL AUTO_INCREMENT,
						`materialtypecode` VARCHAR(5) NOT NULL,
						`description` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL DEFAULT '0',
						PRIMARY KEY (`materialtypeid`),
						UNIQUE INDEX `uq_materialtype` (`materialtypecode`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "
					insert INTO `materialtype` (`materialtypecode`, `description`, `recordstatus`) VALUES ('OPS', 'Operating Supplies', 1);
					insert INTO `materialtype` (`materialtypecode`, `description`, `recordstatus`) VALUES ('CPU', 'Central Processing Unit', 1);
					insert INTO `materialtype` (`materialtypecode`, `description`, `recordstatus`) VALUES ('NSM', 'Non Stockable Materials', 1);
					insert INTO `materialtype` (`materialtypecode`, `description`, `recordstatus`) VALUES ('MTR', 'Monitor', 1);
					insert INTO `materialtype` (`materialtypecode`, `description`, `recordstatus`) VALUES ('PRN', 'Printer', 1);
				";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `materialgroup` (
						`materialgroupid` INT(11) NOT NULL AUTO_INCREMENT,
						`materialgroupcode` VARCHAR(10) NOT NULL,
						`description` VARCHAR(50) NOT NULL,
						`materialtypeid` INT(10) NOT NULL,
						`materialgrouppic` VARCHAR(50) NOT NULL DEFAULT 'default.png',
						`slug` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL DEFAULT '0',
						PRIMARY KEY (`materialgroupid`),
						INDEX `fk_materialgroup_mattype` (`materialtypeid`),
						CONSTRAINT `fk_materialgroup_mattype` FOREIGN KEY (`materialtypeid`) REFERENCES `materialtype` (`materialtypeid`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `materialstatus` (
						`materialstatusid` INT(10) NOT NULL AUTO_INCREMENT,
						`materialstatusname` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(3) NOT NULL DEFAULT '0',
						PRIMARY KEY (`materialstatusid`),
						UNIQUE INDEX `uq_materialstatus` (`materialstatusname`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "
					insert INTO `materialstatus` (`materialstatusname`, `recordstatus`) VALUES ('Service', 1);
					insert INTO `materialstatus` (`materialstatusname`, `recordstatus`) VALUES ('Good', 1);
					insert INTO `materialstatus` (`materialstatusname`, `recordstatus`) VALUES ('Obsolete', 1);
					insert INTO `materialstatus` (`materialstatusname`, `recordstatus`) VALUES ('Under Repair', 1);
				";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `paymentmethod` (
						`paymentmethodid` INT(11) NOT NULL AUTO_INCREMENT,
						`paycode` VARCHAR(5) NULL DEFAULT NULL,
						`paydays` INT(11) NOT NULL,
						`paymentname` VARCHAR(50) NULL DEFAULT NULL,
						`recordstatus` TINYINT(4) NOT NULL DEFAULT '1',
						PRIMARY KEY (`paymentmethodid`),
						UNIQUE INDEX `uq_paytod_code` (`paycode`),
						UNIQUE INDEX `uq_paytod_name` (`paymentname`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
				";
			$connection->createCommand($sql)->execute();

			$sql = "insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('CASH', 0, 'Cash / Tunai', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('TP 7', 7, 'Tempo 7 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('TP 14', 14, 'Tempo 14 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('TP 30', 30, 'Tempo 30 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('PP', 0, 'Partial Payment', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('TP 21', 21, 'Tempo 21 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('TP 45', 45, 'Tempo 45 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('TP 60', 60, 'Tempo 60 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('TP 90', 90, 'Tempo 90 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('G 15', 15, 'Giro 15 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('G 30', 30, 'Giro 30 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('G 45', 45, 'Giro 45 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('G 60', 60, 'Giro 60 days', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('CBD', 0, 'Cash Before Delivery', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('T/T', 0, 'T/T UPON RECEIPT OF YOUR FAX B/L', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('COD', 0, 'cash on delivery', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('G 21', 21, 'Giro 21 Hari', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('G 5', 5, 'Giro Mundur 5 Hari', 1);
					insert INTO `paymentmethod` (`paycode`, `paydays`, `paymentname`, `recordstatus`) VALUES ('G 7', 7, 'Giro Mundur 7 Hari', 1);				
				";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `ownership` (
						`ownershipid` INT(10) NOT NULL AUTO_INCREMENT,
						`ownershipname` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(3) NOT NULL DEFAULT '0',
						PRIMARY KEY (`ownershipid`),
						UNIQUE INDEX `uq_ownership` (`ownershipname`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "
					insert INTO `ownership` (`ownershipname`, `recordstatus`) VALUES ('Own', 1);
					insert INTO `ownership` (`ownershipname`, `recordstatus`) VALUES ('Asset', 1);
					insert INTO `ownership` (`ownershipname`, `recordstatus`) VALUES ('Sharing', 1);";

			$sql = "CREATE TABLE `product` (
						`productid` INT(11) NOT NULL AUTO_INCREMENT,
						`isstock` TINYINT(4) NOT NULL DEFAULT '1',
						`productname` VARCHAR(250) NOT NULL,
						`productpic` VARCHAR(50) NULL DEFAULT 'default.jpg',
						`barcode` VARCHAR(50) NOT NULL,
						`isautolot` TINYINT(11) NOT NULL,
						`materialgroupid` INT(11) NOT NULL,
						`isautolot` TINYINT(4) NOT NULL DEFAULT '1',
						`sled` INT(11) NOT NULL DEFAULT '0',
						`unitofissue` INT(11) NOT NULL,
						`recordstatus` TINYINT(4) NULL DEFAULT '0',
						PRIMARY KEY (`productid`),
						UNIQUE INDEX `uq_productname` (`productname`),
						INDEX `fk_pplant_uom` (`unitofissue`),
						INDEX `fk_pplant_matgroup` (`materialgroupid`),
						CONSTRAINT `fk_pplant_uom` FOREIGN KEY (`unitofissue`) REFERENCES `unitofmeasure` (`unitofmeasureid`),
						CONSTRAINT `fk_pplant_matgroup` FOREIGN KEY (`materialgroupid`) REFERENCES `materialgroup` (`materialgroupid`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `tax` (
						`taxid` INT(11) NOT NULL AUTO_INCREMENT,
						`taxcode` VARCHAR(10) NOT NULL,
						`taxvalue` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
						`accmasukid` INT(11) NULL DEFAULT NULL,
						`acckeluarid` INT(11) NULL DEFAULT NULL,
						`description` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL,
						PRIMARY KEY (`taxid`),
						UNIQUE INDEX `uq_tax` (`taxcode`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
					";
			$connection->createCommand($sql)->execute();

			$sql = "
				REPLACE INTO `tax` (`taxid`, `taxcode`, `taxvalue`, `accmasukid`, `acckeluarid`, `description`, `recordstatus`) VALUES (1, 'PPN 10%', 10.000000, NULL, NULL, 'Value Added Tax', 1);
				REPLACE INTO `tax` (`taxid`, `taxcode`, `taxvalue`, `accmasukid`, `acckeluarid`, `description`, `recordstatus`) VALUES (2, 'PPh 23 (2)', 2.000000, NULL, NULL, 'Pajak Jasa untuk badan', 1);
				REPLACE INTO `tax` (`taxid`, `taxcode`, `taxvalue`, `accmasukid`, `acckeluarid`, `description`, `recordstatus`) VALUES (3, 'PPh 23 (3)', 3.000000, NULL, NULL, 'PPH 23 Jasa Pribadi', 1);
				REPLACE INTO `tax` (`taxid`, `taxcode`, `taxvalue`, `accmasukid`, `acckeluarid`, `description`, `recordstatus`) VALUES (4, 'PPh 21', 21.000000, NULL, NULL, 'pajak restoran', 1);
				REPLACE INTO `tax` (`taxid`, `taxcode`, `taxvalue`, `accmasukid`, `acckeluarid`, `description`, `recordstatus`) VALUES (5, 'NT', 0.000000, NULL, NULL, 'Tanpa Pajak / Pajak ditanggung oleh Cust/Supplier', 1);
				REPLACE INTO `tax` (`taxid`, `taxcode`, `taxvalue`, `accmasukid`, `acckeluarid`, `description`, `recordstatus`) VALUES (6, 'PPh 23(-)', -2.000000, NULL, NULL, 'PPh 23 (Pengurang)', 1);
				REPLACE INTO `tax` (`taxid`, `taxcode`, `taxvalue`, `accmasukid`, `acckeluarid`, `description`, `recordstatus`) VALUES (7, 'PPN 1%', 1.000000, NULL, NULL, 'DPP Nilai Lain', 1);
				REPLACE INTO `tax` (`taxid`, `taxcode`, `taxvalue`, `accmasukid`, `acckeluarid`, `description`, `recordstatus`) VALUES (8, 'PPh 4 (2)', 10.000000, NULL, NULL, 'jasa sewa tanah dan bangunan', 1);
				";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `productplant` (
						`productplantid` INT(11) NOT NULL AUTO_INCREMENT,
						`productid` INT(11) NOT NULL,
						`slocid` INT(11) NOT NULL,
						`issource` TINYINT(4) NOT NULL DEFAULT '0',
						`recordstatus` TINYINT(3) NOT NULL DEFAULT '1',
						PRIMARY KEY (`productplantid`),
						INDEX `fk_pplant_pro` (`productid`),
						INDEX `fk_pplant_sloc` (`slocid`),
						CONSTRAINT `fk_pplant_sloc` FOREIGN KEY (`slocid`) REFERENCES `sloc` (`slocid`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `productsales` (
						`productsalesid` INT(10) NOT NULL AUTO_INCREMENT,
						`productid` INT(10) NOT NULL,
						`currencyid` INT(10) NOT NULL,
						`currencyvalue` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
						`pricecategoryid` INT(11) NOT NULL,
						`uomid` INT(11) NOT NULL,
						PRIMARY KEY (`productsalesid`),
						INDEX `fk_prosales_pro` (`productid`),
						INDEX `fk_prosales_cur` (`currencyid`),
						INDEX `fk_prosales_pricat` (`pricecategoryid`),
						INDEX `fk_prosales_uom` (`uomid`),
						CONSTRAINT `fk_prosales_cur` FOREIGN KEY (`currencyid`) REFERENCES `currency` (`currencyid`),
						CONSTRAINT `fk_prosales_pricat` FOREIGN KEY (`pricecategoryid`) REFERENCES `pricecategory` (`pricecategoryid`),
						CONSTRAINT `fk_prosales_uom` FOREIGN KEY (`uomid`) REFERENCES `unitofmeasure` (`unitofmeasureid`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
      $connection->createCommand($sql)->execute();
      
			$sql = "CREATE TABLE `addressbook` (
        `addressbookid` int(11) NOT NULL,
        `fullname` varchar(50) DEFAULT NULL,
        `iscustomer` tinyint(4) DEFAULT '0',
        `isemployee` tinyint(4) DEFAULT '0',
        `isvendor` tinyint(4) DEFAULT '0',
        `ishospital` tinyint(4) DEFAULT '0',
        `currentlimit` decimal(30,6) NOT NULL DEFAULT '0.000000',
        `currentdebt` decimal(30,6) NOT NULL DEFAULT '0.000000',
        `taxno` varchar(50) DEFAULT NULL,
        `accpiutangid` int(10) DEFAULT NULL,
        `acchutangid` int(10) DEFAULT NULL,
        `creditlimit` decimal(30,6) NOT NULL DEFAULT '0.000000',
        `isstrictlimit` tinyint(4) DEFAULT '0',
        `bankname` varchar(50) DEFAULT NULL,
        `bankaccountno` varchar(50) DEFAULT NULL,
        `accountowner` varchar(50) DEFAULT NULL,
        `salesareaid` int(11) DEFAULT NULL,
        `pricecategoryid` int(11) DEFAULT NULL,
        `overdue` int(11) DEFAULT '60',
        `invoicedate` date DEFAULT NULL,
        `logo` varchar(50) DEFAULT NULL,
        `url` varchar(50) DEFAULT NULL,
        `recordstatus` tinyint(4) NOT NULL DEFAULT '1'
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      $connection->createCommand($sql)->execute();
      
			$sql = "ALTER TABLE `addressbook`
      ADD PRIMARY KEY (`addressbookid`);
      ALTER TABLE `addressbook`
  MODIFY `addressbookid` int(11) NOT NULL AUTO_INCREMENT;";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `address` (
        `addressid` int(11) NOT NULL,
        `addressbookid` int(11) NOT NULL,
        `addresstypeid` int(11) NOT NULL,
        `addressname` text NOT NULL,
        `rt` varchar(5) DEFAULT NULL,
        `rw` varchar(5) DEFAULT NULL,
        `cityid` int(11) NOT NULL,
        `phoneno` varchar(50) DEFAULT NULL,
        `faxno` varchar(50) DEFAULT NULL,
        `lat` float(10,6) DEFAULT NULL,
        `lng` float(10,6) DEFAULT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      $connection->createCommand($sql)->execute();
      
			$sql = "ALTER TABLE `address`
      ADD PRIMARY KEY (`addressid`),
      ADD KEY `fk_address_type` (`addresstypeid`),
      ADD KEY `fk_address_city` (`cityid`);
      ALTER TABLE `address`
  MODIFY `addressid` int(11) NOT NULL AUTO_INCREMENT;";
			$connection->createCommand($sql)->execute();

			$sql = "CREATE TABLE `addresscontact` (
  `addresscontactid` int(11) NOT NULL,
  `contacttypeid` int(11) NOT NULL,
  `addressbookid` int(11) NOT NULL,
  `addresscontactname` varchar(50) NOT NULL,
  `phoneno` varchar(45) DEFAULT NULL,
  `mobilephone` varchar(45) DEFAULT NULL,
  `emailaddress` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
      $connection->createCommand($sql)->execute();
      
			$sql = "ALTER TABLE `addresscontact`
      ADD PRIMARY KEY (`addresscontactid`),
      ADD KEY `fk_addresscontact_type` (`contacttypeid`);
      ALTER TABLE `addresscontact`
  MODIFY `addresscontactid` int(11) NOT NULL AUTO_INCREMENT";
			$connection->createCommand($sql)->execute();

			$sql = "
				CREATE PROCEDURE `InsertProduct`(
	IN `vactiontype` TINYINT,
	IN `vproductid` INT,
	IN `vproductname` VARCHAR(50),
	IN `vproductpic` VARCHAR(50),
	IN `visstock` TINYINT,
	IN `vbarcode` VARCHAR(50)
,
	IN `vrecordstatus` TINYINT,
	IN `vcreatedby` VARCHAR(50)
)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
	declare k int;
	if (vactiontype = 0) then
	  	insert into product (productname,productpic,isstock,barcode,recordstatus)
	  	values (vproductname,vproductpic,visstock,vbarcode,vrecordstatus);
		set k = last_insert_id();
		call InsertTransLog(vcreatedby,'insert',
			concat('productname=',vproductname,',productpic=',vproductpic,',isstock=',visstock,',barcode=',vbarcode),
			'product',k);
	else
		if (vactiontype = 1) then
	  		update product
	  		set productname = vproductname,productpic = vproductpic,isstock = visstock,barcode = vbarcode,recordstatus=vrecordstatus
	  		where productid = vproductid;
			set k = vproductid;
			call InsertTransLog(vcreatedby,'update',
				concat('productname=',vproductname,',productpic=',vproductpic,',isstock=',visstock,',barcode=',vbarcode),
				'product',k);
		end if;
	end if;
	update productplant
	set productid = k
	where productid = vproductid;
END
				";
			$connection->createCommand($sql)->execute();

			$sql = "
				CREATE PROCEDURE `InsertSloc`(
	IN `vactiontype` TINYINT,
	IN `vslocid` INT,
	IN `vplantid` INT,
	IN `vsloccode` VARCHAR(50),
	IN `vdescription` VARCHAR(50),
	IN `vrecordstatus` TINYINT,
	IN `vcreatedby` VARCHAR(50)
)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
	declare k int;
	if (vactiontype = 0) then
	  	insert into sloc (plantid,sloccode,description,recordstatus)
	  	values (vplantid,vsloccode,vdescription,vrecordstatus);
		set k = last_insert_id();
		call InsertTransLog(vcreatedby,'insert',
			concat('plantid=',vplantid,',sloccode=',vsloccode,',description=',vdescription),
			'sloc',k);
	else
		if (vactiontype = 1) then
	  		update sloc
	  		set plantid = vplantid,sloccode = vsloccode,description = vdescription,recordstatus=vrecordstatus
	  		where slocid = vslocid;
			set k = vslocid;
			call InsertTransLog(vcreatedby,'update',
				concat('plantid=',vplantid,',sloccode=',vsloccode,',description=',vdescription),
				'sloc',k);
		end if;
	end if;
	update storagebin
	set slocid = k
	where slocid = vslocid;
END;
				";
			$connection->createCommand($sql)->execute();

			$sql = "
				CREATE PROCEDURE `InsertSupplier`(IN `vactiontype` TINYINT, IN `vaddressbookid` INT, IN `vfullname` VARCHAR(50), IN `vtaxno` VARCHAR(50), IN `vbankname` VARCHAR(50), IN `vbankaccountno` VARCHAR(50), IN `vaccountowner` VARCHAR(50), IN `vlogo` VARCHAR(50), IN `vurl` VARCHAR(50), IN `vrecordstatus` INT)
	LANGUAGE SQL
	NOT DETERMINISTIC
	CONTAINS SQL
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN
	declare k int;
	
	if (vactiontype = 0) then
  		insert into addressbook (fullname,taxno,bankname,bankaccountno,
  			accountowner,isvendor,logo,url,recordstatus)
  		values (vfullname,vtaxno,vbankname,vbankaccountno,
  			vaccountowner,1,vlogo,vurl,vrecordstatus);
		set k = last_insert_id();
	else
	  	if (vactiontype = 1) then
	  		update addressbook
			set fullname = vfullname,  taxno = vtaxno,
				bankname = vbankname, bankaccountno = vbankaccountno, accountowner = vaccountowner,
				accountowner = vaccountowner, 
			logo = vlogo, url = vurl, recordstatus = vrecordstatus
			where addressbookid = vaddressbookid;
			set k = vaddressbookid;
		end if;
	end if;
	
	update address
  	set addressbookid = k
  	where addressbookid = vaddressbookid;
  	
  	update addresscontact
  	set addressbookid = k
  	where addressbookid = vaddressbookid;
END
				";
			$connection->createCommand($sql)->execute();

			$sql = "
				CREATE PROCEDURE `InsertCustomer`(IN `vactiontype` TINYINT, IN `vaddressbookid` INT, IN `vfullname` VARCHAR(50), IN `vcreditlimit` DECIMAL(30,6), IN `vtaxno` VARCHAR(50), IN `visstrictlimit` TINYINT, IN `vbankname` VARCHAR(50), IN `vbankaccountno` VARCHAR(50), IN `vaccountowner` VARCHAR(50), IN `vsalesareaid` INT, IN `vpricecategoryid` INT, IN `voverdue` INT, IN `vlogo` VARCHAR(50), IN `vurl` VARCHAR(50), IN `vrecordstatus` INT)
	LANGUAGE SQL
	NOT DETERMINISTIC
	CONTAINS SQL
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN
	declare k int;

  	if (vactiontype = 0) then
  		insert into addressbook (fullname,creditlimit,taxno,isstrictlimit,bankname,bankaccountno,
  			accountowner,salesareaid,pricecategoryid,overdue,iscustomer,logo,url,recordstatus)
  		values (vfullname,vcreditlimit,vtaxno,visstrictlimit,vbankname,vbankaccountno,
  			vaccountowner,vsalesareaid,vpricecategoryid,voverdue,1,vlogo,vurl,vrecordstatus);
  		set k = last_insert_id();
  	else
	  	if (vactiontype = 1) then
	  		update addressbook
			set fullname = vfullname, creditlimit = vcreditlimit, taxno = vtaxno, isstrictlimit = visstrictlimit,
				bankname = vbankname, bankaccountno = vbankaccountno, accountowner = vaccountowner,
				accountowner = vaccountowner, salesareaid = vsalesareaid, pricecategoryid = vpricecategoryid,
				overdue = voverdue, logo = vlogo, url = vurl, recordstatus = vrecordstatus
			where addressbookid = vaddressbookid;	
			set k = vaddressbookid;	
	  	end if;
  	end if;
  	
  	update address
  	set addressbookid = k
  	where addressbookid = vaddressbookid;
  	
  	update addresscontact
  	set addressbookid = k
  	where addressbookid = vaddressbookid;
END";
			$connection->createCommand($sql)->execute();
			return "ok";
		} else {
			return "Need module Admin to be installed";
		}
	}
}