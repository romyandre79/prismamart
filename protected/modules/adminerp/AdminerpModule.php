<?php
class AdminerpModule extends CWebModule {
	public function init() {
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		// import the module-level models and components
		$this->setImport(array(
			'adminerp.components.*',
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
		$sql				 = "select moduleid from modules where lower(modulename) = 'adminerp'";
		$moduleid		 = $connection->createCommand($sql)->queryScalar();
		if ($moduleid > 0) {
			$sql = "delete from menuaccess where moduleid = ".$moduleid;
      $connection->createCommand($sql)->execute();

			$sql = "delete from modulerelation where moduleid = ".$moduleid;
      $connection->createCommand($sql)->execute();

      $sql = "delete from modules where moduleid = ".$moduleid;
      $connection->createCommand($sql)->execute();
      
			$sql = "drop table if exists wfstatus";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists wfgroup";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists workflow";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists snrodet";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists snro";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists groupmenuauth";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists menuauth";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists insertworkflow";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists InsertMenuAuth";
			$connection->createCommand($sql)->execute();

			$sql = "drop procedure if exists InsertSnro";
			$connection->createCommand($sql)->execute();

			$sql = "drop function if exists getrunno";
			$connection->createCommand($sql)->execute();

			$sql = "drop function if exists GetWfBefStat";
			$connection->createCommand($sql)->execute();

			$sql = "drop function if exists GetWfBefStatByCreated";
			$connection->createCommand($sql)->execute();

			$sql = "drop function if exists GetWFCompareMax";
			$connection->createCommand($sql)->execute();

			$sql = "drop function if exists GetWFCompareMinApp";
			$connection->createCommand($sql)->execute();

			$sql = "drop function if exists getwfmaxstatbywfname";
			$connection->createCommand($sql)->execute();

			$sql = "drop function if exists GetWfMinStatByWfName";
			$connection->createCommand($sql)->execute();

			$sql = "drop function if exists GetWfNextStatByCreated";
			$connection->createCommand($sql)->execute();

			$sql = "drop function if exists GetWFRecStatByCreated";
			$connection->createCommand($sql)->execute();

			$sql = "drop function if exists GetWFStatusByWfName";
			$connection->createCommand($sql)->execute();
		}
		return "ok";
	}
	public function Install() {
		try {
			$connection	 = Yii::app()->db;
			$sql				 = "select moduleid from modules where lower(modulename) = 'admin'";
			$adminid		 = $connection->createCommand($sql)->queryScalar();
			if ($adminid > 0) {
        $this->UnInstall();
        $sql = "insert into modules (modulename,description,createdby,moduleversion,installdate,themeid,recordstatus)
        values ('adminerp','Admin ERP','Prisma Data Abadi','1.0',now(),2,1)";
        $connection->createCommand($sql)->execute();

				$sql			 = "select max(sortorder) from menuaccess where menuurl is null";
				$sortorder = $connection->createCommand($sql)->queryScalar() + 1;

        $sql				 = "select moduleid from modules where lower(modulename) = 'adminerp'";
        $moduleid		 = $connection->createCommand($sql)->queryScalar();

        $sql = "insert into modulerelation (moduleid,relationid)
          values (".$moduleid.",".$adminid.")";
        $connection->createCommand($sql)->execute();

				$sql				 = "select menuaccessid from menuaccess where lower(menuname) = 'admin'";
				$menuparent	 = $connection->createCommand($sql)->queryScalar();

				$sql = "
					insert into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
					values ('menuauth','ERP Menu Object','ERP Menu Object',".$moduleid.",".$menuparent.",'menuauth',18,1);
					
					insert into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
					values ('snro','ERP Specific Number Range Object','ERP Specific Number Range Object',".$moduleid.",".$menuparent.",'snro',19,1);
					
					insert into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
					values ('workflow','ERP Workflow','ERP Workflow',".$moduleid.",".$menuparent.",'workflow',20,1);
					";
				$connection->createCommand($sql)->execute();

				$sql = "
					insert into groupmenu (groupaccessid,menuaccessid,isread,iswrite,ispost,isreject,ispurge,isupload,isdownload)
					select 2,menuaccessid,1,1,1,1,1,1,1
					from menuaccess 
					where moduleid = ".$moduleid;
				$connection->createCommand($sql)->execute();

				$sql = "
					CREATE TABLE `menuauth` (
						`menuauthid` INT(11) NOT NULL AUTO_INCREMENT,
						`menuobject` VARCHAR(50) NOT NULL,
						`recordstatus` TINYINT(3) NOT NULL,
						PRIMARY KEY (`menuauthid`),
						UNIQUE INDEX `uq_menuobject` (`menuobject`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;";
				$connection->createCommand($sql)->execute();

				$sql = "
					insert into `menuauth` (`menuobject`, `recordstatus`) VALUES ('sloc', 1);
					insert into `menuauth` (`menuobject`, `recordstatus`) VALUES ('useraccess', 1);
					insert into `menuauth` (`menuobject`, `recordstatus`) VALUES ('currency', 1);
					insert into `menuauth` (`menuobject`, `recordstatus`) VALUES ('employee', 1);
					insert into `menuauth` (`menuobject`, `recordstatus`) VALUES ('company', 1);
					insert into `menuauth` (`menuobject`, `recordstatus`) VALUES ('overdue', 1);
					insert into `menuauth` (`menuobject`, `recordstatus`) VALUES ('tolerance', 1);
				";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE TABLE `groupmenuauth` (
					`groupmenuauthid` INT(11) NOT NULL AUTO_INCREMENT,
					`groupaccessid` INT(11) NOT NULL,
					`menuauthid` INT(11) NOT NULL,
					`menuvalueid` VARCHAR(50) NOT NULL,
					PRIMARY KEY (`groupmenuauthid`),
					INDEX `fk_grmauth_group` (`groupaccessid`),
					CONSTRAINT `fk_grmauth_group` FOREIGN KEY (`groupaccessid`) REFERENCES `groupaccess` (`groupaccessid`)
				)
				COLLATE='utf8_general_ci'
				ENGINE=InnoDB;
				";
				$connection->createCommand($sql)->execute();

				$sql = "
					CREATE TABLE `snro` (
						`snroid` INT(11) NOT NULL AUTO_INCREMENT,
						`description` VARCHAR(50) NOT NULL,
						`formatdoc` VARCHAR(50) NOT NULL,
						`formatno` VARCHAR(10) NOT NULL,
						`repeatby` VARCHAR(30) NULL DEFAULT NULL,
						`recordstatus` TINYINT(4) NOT NULL,
						PRIMARY KEY (`snroid`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
				";
				$connection->createCommand($sql)->execute();

				$sql = "
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Employee Type Harian', 'E00000', '00000', '', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Employee Type Karyawan', '000000', '000000', '', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Employee Type Outsourcing', 'A00000', '00000', '', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Purchase Requisition', 'PP-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Sickness Transaction', '000/001/MONROM/YYYY', '000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cuti Tahunan', '000/004/CT/MONROM/YYYY', '000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cuti Melahirkan', '000/004/CM/MONROM/YYYY', '000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cuti Duka Cita', '000/004/CD/MONROM/YYYY', '000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cuti Menikah', '000/004/CN/MONROM/YYYY', '000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cuti Keguguran', '000/004/CK/MONROM/YYYY', '000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cuti Istri Melahirkan', '000/004/CIM/MONROM/YYYY', '000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cuti Istri Keguguran', '000/004/CIK/MONROM/YYYY', '000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cuti Khitan Anak', '000/004/CKA/MONROM/YYYY', '000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cuti Bencana Alam', '000/004/CBA/MONROM/YYYY', '000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Permit Exit', 'PME-YYMONROM000000', '000000', 'MMYYYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Permit In', 'PMI-YYMONROM000000', '000000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Goods Receipt', 'GR-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Tools Stock', 'TSO-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Purchase Order', 'PO-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Goods Issue', 'SJ-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Purchase Order Customer', 'POC-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Sales Order', 'SO-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Delivery Order', 'DO-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Transfer Stock', 'TFS-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Petty Cash', 'PC-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('General Journal', 'JU-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Employee Overtime', 'EO-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Project', 'YYCC.PT.PP.MM000', '000', 'CCPTPPMMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Delivery Advice', 'FPB-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cuti Besar', 'CB-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Kode Barang', 'YYMM0000000000', '0000000000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Trouble Ticket No', '0000/OPS/TTI/MMYY', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cash Bank Withdrawal', 'BKK-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cash Bank Deposit', 'BKM-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Invoice Customer', 'INV-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Faktur Pajak', '010.000-YY.00000000', '00000000', 'YY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cash Bank Out', 'CBP-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cash Bank In', 'CBR-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cash Out', 'CP-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Bank Out', 'BP-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Cash In', 'CR-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Bank In', 'BR-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Journal Adjustment', 'JP-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Production Output', 'OP-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Menu Source', 'YYYYMMDD-00000000', '00000000', 'YYYYMM', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('GR Retur', 'GRR-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Laundry Trans', '000000000MMYY', '000000000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('GI Retur', 'GIR-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Nota GR Retur', 'NGRR-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('TTNT', 'TTNT-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Production Planning', 'SPP-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Request Payment', 'RP-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Expedition', 'EXP-YYMONROM0000', '0000', 'MMYY', 1);
					insert into `snro` (`description`, `formatdoc`, `formatno`, `repeatby`, `recordstatus`) VALUES ('Nota GI Retur', 'NGIR-YYMONROM0000', '0000', 'MMYY', 1);
				";
				$connection->createCommand($sql)->execute();

				$sql = "
					CREATE TABLE `snrodet` (
	`snrodid` INT(11) NOT NULL AUTO_INCREMENT,
	`snroid` INT(11) NULL DEFAULT NULL,
	`companyid` INT(11) NULL DEFAULT NULL,
	`curdd` INT(11) NULL DEFAULT NULL,
	`curmm` INT(11) NULL DEFAULT NULL,
	`curyy` INT(11) NULL DEFAULT NULL,
	`curvalue` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`snrodid`),
	INDEX `fk_snrod_snro` (`snroid`),
	INDEX `fk_snro_company` (`companyid`),
	CONSTRAINT `fk_snro_company` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
				";
				$connection->createCommand($sql)->execute();

				$sql = "
					CREATE TABLE `workflow` (
						`workflowid` INT(11) NOT NULL AUTO_INCREMENT,
						`wfname` VARCHAR(20) NOT NULL,
						`wfdesc` VARCHAR(50) NOT NULL COMMENT 'wf description',
						`wfminstat` TINYINT(4) NOT NULL,
						`wfmaxstat` TINYINT(4) NOT NULL,
						`recordstatus` TINYINT(4) NOT NULL DEFAULT '0',
						PRIMARY KEY (`workflowid`),
						UNIQUE INDEX `uq_wfname` (`wfname`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
				";
				$connection->createCommand($sql)->execute();

				$sql = "
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('apppo', 'Approve PO', 1, 5, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appjournal', 'Approve Journal', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('apppr', 'Approve PR', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listpo', 'List PO', 0, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listjournal', 'list Journal', 0, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listbs', 'List Stock Opname', 0, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appbs', 'Approve Stock Opname', 1, 5, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appgi', 'Approve Goods Issue ', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listgi', 'List Goods Issue', 0, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('apppoc', 'Approve Purchase Order Customer', 1, 4, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listpoc', 'List Purchase Order Customer', 0, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appso', 'Approve Sales Order', 1, 6, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listso', 'List Sales Order', 0, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appdo', 'Approve Delivery Order', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listdo', 'List Delivery Order', 0, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appevent', 'Approve Event', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listevent', 'List Event Admin', 0, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listgr', 'List GR', 0, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appgr', 'Approve GR', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listpr', 'List PR', 0, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listproject', 'List Project', 0, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listts', 'List Transfer Out', 0, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appts', 'Approve Transfer Out', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('apppettycash', 'Approve Petty Cash', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listpettycash', 'List Petty Cash', 0, 4, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listempover', 'List Employee Over', 0, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appempover', 'Approve Employee Over', 1, 4, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appproject', 'Approve Project', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appempsched', 'Approve Employee Schedule', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listempsched', 'List Employee Schedule', 0, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('apponleavetrans', 'Approve Onleave Trans', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listonleavetrans', 'List Onleave Trans', 0, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('apptransout', 'Approve Permit Exit Trans', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listtransout', 'List Permit Exit Trans', 0, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appda', 'Approve Form Request', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listda', 'List Form Request', 0, 4, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('apptransin', 'Approve Permit In Trans', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listtransin', 'List Permit In Trans', 0, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('apptranssickness', 'Approve Sickness Transaction', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listtranssickness', 'List Sickness Transaction', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insempsched', 'Insert Employee Schedule', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insda', 'Insert Form Request', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('inspr', 'Insert PR', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('inspo', 'Insert PO', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insgr', 'Insert GR', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insts', 'Insert Transfer Out', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insbs', 'Insert Stock Opname', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listempspletter', 'List Employee SP Letter', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insproject', 'Insert Project', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appbaol', 'Approve BAOL', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listbaol', 'List BAOL', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insbaol', 'Insert BAOL', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insjournal', 'Insert General Journal', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insgi', 'Insert Goods Issue', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insso', 'Insert Sales Order', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insonleavetrans', 'Insert Onleave Trans', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insinvap', 'Insert Invoice AP', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listinvap', 'List Invoice AP', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appinvap', 'Approve Invoice AP', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appcbin', 'Approve Cash Bank Receivable', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listcbin', 'List Cash Bank Receivable', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('inscbin', 'Insert Cash Bank Receivable', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appcbout', 'Approve Cash Bank Payment', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listcbout', 'List Cash Bank Payment', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('inscbout', 'Insert Cash Bank Payment', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insinvar', 'Insert Invoice AR', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listinvar', 'List Invoice AR', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appinvar', 'Approve Invoice AR', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejjournal', 'Reject General Journal', 1, 5, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('prijournal', 'Print General Journal', 1, 5, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('priso', 'Print Sales Order', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejso', 'Reject Sales Order', 1, 6, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('prida', 'Print Form Request', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('pripr', 'Print of Purchase Requisition', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('prigr', 'Print of Goods Received', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('priinvap', 'Print of Invoice from Supplier', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('pripo', 'Print of Purchase Order', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('pricbo', 'Print of Cash Bank Payment', 2, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('pricbin', 'Print of Cash Bank Receivable', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('priinvar', 'Print of Invoice AR', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('prigi', 'Print of Goods Issue', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('prits', 'Print of Transfer Out', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appop', 'Approve Production Output', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listop', 'List Production Output', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insop', 'Insert Production Output', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejda', 'Reject Form Request', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejpr', 'Reject PR', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejpo', 'Reject PO', 1, 5, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejgr', 'Reject GR', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejgi', 'Reject Goods Issue', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejbs', 'Reject Stock Opname', 1, 5, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejts', 'Reject Transfer Out', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejop', 'Reject Production Output', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejap', 'Reject Invoice AP', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejar', 'Reject Invoice AR', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejcbin', 'Reject Cash Bank Receivable', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejcbout', 'Reject Cash Bank Payment', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejempsched', 'Reject Employee Schedule', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insempover', 'Insert Employee Over', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejempover', 'Reject Employee Over', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('inslaundry', 'Insert Laundry Transaction', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('applaundry', 'Approval Laundry Transaction', 1, 2, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejlaundry', 'Reject Laundry Transaction', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listlaundry', 'List Laundry Transaction', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appgiretur', 'Approve GI Retur', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listgiretur', 'List GI Retur', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejgiretur', 'Reject GI Retur', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insgiretur', 'Insert GI Retur', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appgrretur', 'Approve GR Return', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listgrretur', 'List GR Retur', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejgrretur', 'Reject GR Return', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insgrretur', 'Insert GR Retur', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appttnt', 'Approve TTNT', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insttnt', 'Insert TTNT', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listttnt', 'List TTNT', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejttnt', 'Reject TTNT', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('apppayreq', 'Approve Payment Request', 1, 6, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('inspayreq', 'Insert Payment Request', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejpayreq', 'Reject Payment Request', 1, 6, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listpayreq', 'List Payment Request', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listprodplan', 'List Production Planning', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appprodplan', 'Approve Production Planning', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejprodplan', 'Reject Production Planning', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insprodplan', 'Insert Production Planning', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('apptsin', 'Approve Transfer In', 3, 5, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listtsin', 'List Transfer In', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejtsin', 'Reject Transfer In', 3, 5, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appeksp', 'Approve Expedition', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('inseksp', 'Insert Expedition', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejeksp', 'Reject Expedition', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listeksp', 'List Expedition', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejfa', 'Reject Fix Asset', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insfa', 'Insert Fix Asset', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listfa', 'List Fix Asset', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appfa', 'Approve Fix Asset', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insnotagrretur', 'Insert Nota Retur Pembelian', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejnotagrretur', 'Reject Nota Retur Pembelian', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listnotagrretur', 'List Nota Retur Pembelian', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appnotagrretur', 'Approve Nota Retur Pembelian', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insnotagir', 'Insert Nota Retur Penjualan', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejnotagir', 'Reject Nota Retur Penjualan', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listnotagir', 'List Nota Retur Penjualan', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appnotagir', 'Approve Nota Retur Penjualan', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appabstrans', 'Approve Transaksi Absensi', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listabstrans', 'List Transaksi Absensi', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insabstrans', 'Insert Transaksi Absensi', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('rejabstrans', 'Reject Transaksi Absensi', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('insconvert', 'Insert Konversi Produk', 1, 1, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('appconvert', 'Approve Konversi Produk', 1, 3, 1);
					insert into `workflow` (`wfname`, `wfdesc`, `wfminstat`, `wfmaxstat`, `recordstatus`) VALUES ('listconvert', 'List Konversi Produk', 1, 3, 1);
				";
				$connection->createCommand($sql)->execute();

				$sql = "
					CREATE TABLE `wfgroup` (
						`wfgroupid` INT(11) NOT NULL AUTO_INCREMENT,
						`workflowid` INT(11) NOT NULL,
						`groupaccessid` INT(11) NOT NULL,
						`wfbefstat` TINYINT(4) NOT NULL,
						`wfrecstat` TINYINT(4) NOT NULL,
						PRIMARY KEY (`wfgroupid`),
						INDEX `fk_wfgroup_wf` (`workflowid`),
						INDEX `fk_wfgroup_group` (`groupaccessid`),
						CONSTRAINT `fk_wfgroup_group` FOREIGN KEY (`groupaccessid`) REFERENCES `groupaccess` (`groupaccessid`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
				";
				$connection->createCommand($sql)->execute();

				$sql = "				
					CREATE TABLE `wfstatus` (
						`wfstatusid` INT(11) NOT NULL AUTO_INCREMENT,
						`workflowid` INT(11) NOT NULL,
						`wfstat` TINYINT(4) NOT NULL,
						`wfstatusname` VARCHAR(50) NOT NULL,
						PRIMARY KEY (`wfstatusid`),
						INDEX `fk_wfstatus_wf` (`workflowid`)
					)
					COLLATE='utf8_general_ci'
					ENGINE=InnoDB;
				";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE PROCEDURE `InsertSnro`(
	IN `vactiontype` TINYINT,
	IN `vsnroid` INT,
	IN `vdescription` VARCHAR(50),
	IN `vformatdoc` VARCHAR(50),
	IN `vformatno` VARCHAR(10),
	IN `vrepeatby` VARCHAR(10),
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
	  	insert into snro (description,formatdoc,formatno,repeatby,recordstatus)
	  	values (vdescription,vformatdoc,vformatno,vrepeatby,vrecordstatus);
		set k = last_insert_id();
		call InsertTransLog(vcreatedby,'insert',
			concat('description=',vdescription,',formatdoc=',vformatdoc,',formatno=',vformatno,',repeatby=',vrepeatby),
			'snro',k);
	else
		if (vactiontype = 1) then
	  		update snro
	  		set description = vdescription,formatdoc = vformatdoc,formatno = vformatno, repeatby = vrepeatby,recordstatus=vrecordstatus
	  		where snroid = vsnroid;
			set k = vsnroid;
			call InsertTransLog(vcreatedby,'update',
				concat('description=',vdescription,',formatdoc=',vformatdoc,',formatno=',vformatno,',repeatby=',vrepeatby),
				'snro',k);
		end if;
	end if;
	update snrodet
	set snroid = k
	where snroid = vsnroid;
END
				";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE PROCEDURE `InsertWorkflow`(
	IN `vactiontype` TINYINT,
	IN `vworkflowid` INT,
	IN `vwfname` VARCHAR(50),
	IN `vwfdesc` VARCHAR(50),
	IN `vwfminstat` INT,
	IN `vwfmaxstat` INT,
	IN `vrecordstatus` INT,
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
	  	insert into workflow (wfname,wfdesc,wfminstat,wfmaxstat,recordstatus)
	  	values (vwfname,vwfdesc,vwfminstat,vwfmaxstat,vrecordstatus);
		set k = last_insert_id();
		call InsertTransLog(vcreatedby,'insert',
			concat('wfname=',vwfname,',wfdesc=',vwfdesc,',wfminstat=',vwfminstat,',wfmaxstat=',vwfmaxstat),
			'workflow',k);
	else
		if (vactiontype = 1) then
	  		update workflow
	  		set wfname = vwfname,wfdesc = vwfdesc,wfminstat = vwfminstat,wfmaxstat = vwfmaxstat,recordstatus=vrecordstatus
	  		where workflowid = vworkflowid;
			set k = vworkflowid;
			call InsertTransLog(vcreatedby,'update',
				concat('wfname=',vwfname,',wfdesc=',vwfdesc,',wfminstat=',vwfminstat,',wfmaxstat=',vwfmaxstat),
				'workflow',k);
		end if;
	end if;
	update wfgroup
	set workflowid = k
	where workflowid = vworkflowid;
	update wfstatus
	set workflowid = k
	where workflowid = vworkflowid;
END
				";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE FUNCTION  `getrunno`(`vcompanyid` INT, `vsnroid` int, `vdate` datetime)
		RETURNS varchar(100) CHARSET utf8
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare vformatdoc,vformatno,vmr,vrepeatby,vrom varchar(100);
		declare vdd,vmm,vyy,vcurrvalue,lyy,vtrap integer;

		select formatdoc,formatno,repeatby
		into vformatdoc,vformatno,vrepeatby
		from snro
		where snroid = vsnroid
		limit 1;

		select day(vdate) into vdd;
		select month(vdate) into vmm;	
		select year(vdate) into vyy;
		if position('MONROM' in vformatno) then
			select monthrm into vmr 
			from romawi
			where monthcal = vmm
			limit 1;
		end if; 

		if (position('YYYY' in vrepeatby) > 0) then
			set lyy = 4;
		else
			if (position('YY' in vrepeatby) > 0) then
				set lyy = 2;
			end if;
		end if;

		if (vrepeatby = '') then
			select ifnull(count(1),0)
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and companyid = vcompanyid
			limit 1;
			set vtrap = 4;

			if vcurrvalue > 0 then
				select curvalue
				into vcurrvalue
				from snrodet
				where snroid = vsnroid and companyid = vcompanyid
				limit 1;

				set vcurrvalue=vcurrvalue + 1;

				update snrodet
				set curvalue = vcurrvalue
				where snroid = vsnroid and companyid = vcompanyid;
			else
				set vcurrvalue=1;
				insert into snrodet (snroid,curdd,curmm,curyy,curvalue,companyid)
				values (vsnroid,0,0,0,1,vcompanyid);
			end if;
		else
	if (position('DD' in vrepeatby) > 0) and
			 (position('MM' in vrepeatby) > 0) and
			 (position('YY' in vrepeatby) > 0) then
			select ifnull(count(1),0)
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curdd = vdd and 
				curmm = vmm and curyy = vyy and companyid = vcompanyid
			limit 1;
	set vtrap = 3;

			if vcurrvalue > 0 then
				select curvalue
				into vcurrvalue
				from snrodet
				where snroid = vsnroid and curdd = vdd 
					and curmm = vmm and curyy = vyy and companyid = vcompanyid
				limit 1;

				set vcurrvalue=vcurrvalue + 1;

				update snrodet
				set curvalue = vcurrvalue
				where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy 
				and companyid = vcompanyid;
			else
				set vcurrvalue=1;
				insert into snrodet (snroid,curdd,curmm,curyy,curvalue,companyid)
				values (vsnroid,vdd,vmm,vyy,1,vcompanyid);
			end if;
		else
	if (position('MM' in vrepeatby) > 0) and
			 (position('YY' in vrepeatby) > 0) then
	set vtrap = 2;
			select ifnull(count(1),0)
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curmm = vmm 
				and curyy = vyy and companyid = vcompanyid
			limit 1;


			if vcurrvalue > 0 then
				select curvalue
				into vcurrvalue
				from snrodet
				where snroid = vsnroid and curmm = vmm 
					and curyy = vyy and companyid = vcompanyid
				limit 1;

				set vcurrvalue=vcurrvalue + 1;

				update snrodet
				set curvalue = vcurrvalue
				where snroid = vsnroid and curmm = vmm and curyy = vyy and companyid = vcompanyid;
			else
				set vcurrvalue=1;
				insert into snrodet (snroid,curdd,curmm,curyy,curvalue,companyid)
				values (vsnroid,0,vmm,vyy,1,vcompanyid);
			end if;
		else
		if (position('YY' in vrepeatby) > 0) then
			select ifnull(count(1),0)
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curyy = vyy and companyid = vcompanyid;

			if vcurrvalue > 0 then
				select curvalue
				into vcurrvalue
				from snrodet
				where snroid = vsnroid and curyy = vyy and companyid = vcompanyid
				limit 1;

				set vcurrvalue=vcurrvalue + 1;
				
				update snrodet
				set curvalue = vcurrvalue
				where snroid = vsnroid and curyy = vyy and companyid = vcompanyid;
			else
				set vcurrvalue=1;
				insert into snrodet (snroid,curdd,curmm,curyy,curvalue,companyid)
				values (vsnroid,0,0,vyy,1,vcompanyid);
			end if;
		end if;

		end if;

		end if;
		end if;


		select concat(abc,substring(formatdoc,length(abc)+1)) 
		into vformatdoc
		from (
		select formatdoc,formatno, concat(left(formatdoc,position(formatno in formatdoc)-1),
		concat(left(formatno,length(formatno)-length(angka)),angka))
		as abc
		from (
		select vcurrvalue as angka, formatdoc, formatno 
		from snro where snroid = vsnroid limit 1
		) a ) b;

		if vdd < 10 then
			select replace(vformatdoc,'DD',concat('0',vdd)) into vformatdoc;
		else
			select replace(vformatdoc,'DD',vdd) into vformatdoc;
		end if;

		if vmm < 10 then
			select replace(vformatdoc,'MM',concat('0',vmm)) into vformatdoc;
		else
			select replace(vformatdoc,'MM',vmm) into vformatdoc;
		end if;
		
		if (position('YY' in vrepeatby) > 0) then
			if lyy = 4 then
				select replace(vformatdoc,'YYYY',vyy) into vformatdoc;
			else
			if lyy = 2 then
				select replace(vformatdoc,'YY',right(vyy,lyy)) into vformatdoc;
			end if;	
			end if;
		else
			select replace(vformatdoc,'YY',right(vyy,2)) into vformatdoc;
		end if;

		if (position('MONROM' in vformatdoc) > 0) then
			select monthrm 
			into vrom 
			from romawi
			where monthcal = vmm limit 1;
			select replace(vformatdoc,'MONROM',vrom) into vformatdoc;
		end if;

		return vformatdoc;
	END";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE FUNCTION  `GetWfBefStat`(`vwfname` varchar(50), `vcreatedby` varchar(50))
		RETURNS int(11)
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare vreturn int;
		select b.wfbefstat
		into vreturn
		from assignments a
		inner join wfgroup b on upper(b.items) = upper(a.itemname)
		inner join workflow c on c.workflowid = b.workflowid
		where a.userid = vcreatedby and upper(c.wfname) = upper(vwfname)
		limit 1;

		return vreturn;
	END";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE FUNCTION  `GetWfBefStatByCreated`(`vwfname` varchar(50), `vbefstat` tinyint, `vcreatedby` varchar(50))
		RETURNS int(11)
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare vreturn int;

		select ifnull(count(1),0)
		into vreturn
		from usergroup a
		inner join useraccess d on d.useraccessid = a.useraccessid
		inner join wfgroup b on b.groupaccessid = a.groupaccessid
		inner join workflow c on c.workflowid = b.workflowid
		where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) and b.wfbefstat = vbefstat;

		if vreturn > 0 then
		select b.wfgroupid
		into vreturn
		from usergroup a
		inner join useraccess d on d.useraccessid = a.useraccessid
		inner join wfgroup b on b.groupaccessid = a.groupaccessid
		inner join workflow c on c.workflowid = b.workflowid
		where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) and b.wfbefstat = vbefstat
		limit 1;
		end if;

		return vreturn;
	END";
				$connection->createCommand($sql)->execute();

				$sql = "CREATE PROCEDURE `InsertMenuAuth`(
	IN `vactiontype` TINYINT,
	IN `vmenuauthid` INT,
	IN `vmenuobject` VARCHAR(50),
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
	  	insert into menuauth (menuobject,recordstatus)
	  	values (vmenuobject,vrecordstatus);
		set k = last_insert_id();
		call InsertTransLog(vcreatedby,'insert',
			concat('menuobject=',vmenuobject),
			'menuauth',k);
	else
		if (vactiontype = 1) then
	  		update menuauth
	  		set menuobject = vmenuobject,recordstatus=vrecordstatus
	  		where menuauthid = vmenuauthid;
			set k = vmenuauthid;
			call InsertTransLog(vcreatedby,'update',
				concat('menuobject=',vmenuobject),
				'menuauth',k);
		end if;
	end if;
	update groupmenuauth
	set menuauthid = k
	where menuauthid = vmenuauthid;
END";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE FUNCTION  `GetWFCompareMax`(`vwfname` varchar(50), `vnextstat` int, `vcreatedby` varchar(50))
		RETURNS int(11)
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare vrecstat,vmaxstat,vreturn int;
		select distinct b.wfrecstat,c.wfmaxstat
		into vrecstat,vmaxstat
		from usergroup a
		inner join useraccess d on d.useraccessid = a.useraccessid
		inner join wfgroup b on b.groupaccessid = a.groupaccessid
		inner join workflow c on c.workflowid = b.workflowid
		where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) and b.wfbefstat = vnextstat-1
		limit 1;

		if vnextstat = vmaxstat then
			set vreturn = 1;
		else
			set vreturn = 0;
		end if;

		return vreturn;
	END";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE FUNCTION  `GetWFCompareMinApp`(`vwfname` varchar(50), `vnextstat` int, `vcreatedby` varchar(50))
		RETURNS int(11)
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare vrecstat,vmaxstat,vreturn int;
		select b.wfrecstat,c.wfminstat
		into vrecstat,vmaxstat
		from usergroup a
		inner join useraccess d on d.useraccessid = a.useraccessid
		inner join wfgroup b on b.groupaccessid = a.groupaccessid
		inner join workflow c on c.workflowid = b.workflowid
		where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) limit 1;


		if vnextstat = vmaxstat then
			set vreturn = 1;
		else
			set vreturn = 0;
		end if;

		return vreturn;
	END";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE FUNCTION  `getwfmaxstatbywfname`(`vwfname` varchar(50))
		RETURNS int(11)
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare vreturn int;

		select ifnull(count(1),0)
		into vreturn
		from workflow c
		where upper(c.wfname) = upper(vwfname);

		if vreturn > 0 then
			select c.wfmaxstat
			into vreturn
			from workflow c
			where upper(c.wfname) = upper(vwfname)
			limit 1;
		end if;

		return vreturn;
	END";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE FUNCTION  `GetWfMinStatByWfName`(`vwfname` varchar(50))
		RETURNS int(11)
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare vreturn int;

		select ifnull(count(1),0)
		into vreturn
		from workflow c
		where upper(c.wfname) = upper(vwfname);

		if vreturn > 0 then
			select c.wfminstat
			into vreturn
			from workflow c
			where upper(c.wfname) = upper(vwfname)
			limit 1;
		end if;

		return vreturn;
	END";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE FUNCTION  `GetWfNextStatByCreated`(`vwfname` varchar(50), `vbefstat` tinyint, `vcreatedby` varchar(50))
		RETURNS int(11)
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare vreturn int;
		select ifnull(b.wfgroupid,0)
		into vreturn
		from assignments a
		inner join wfgroup b on upper(b.items) = upper(a.itemname)
		inner join workflow c on c.workflowid = b.workflowid
		where a.userid = vcreatedby and upper(c.wfname) = upper(vwfname) and b.wfrecstat = vbefstat
		limit 1;

		return vreturn;
	END";
				$connection->createCommand($sql)->execute();

				$sql = "
				CREATE FUNCTION  `GetWFRecStatByCreated`(`vwfname` varchar(50), `vbefstat` tinyint, `vcreatedby` varchar(50))
		RETURNS int(11)
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare vreturn int;

		select ifnull(count(1),0)
		into vreturn
		from usergroup a
		inner join useraccess d on d.useraccessid = a.useraccessid
		inner join wfgroup b on b.groupaccessid = a.groupaccessid
		inner join workflow c on c.workflowid = b.workflowid
		where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) and b.wfbefstat = vbefstat;

		if vreturn > 0 then
			select b.wfrecstat
			into vreturn
			from usergroup a
			inner join useraccess d on d.useraccessid = a.useraccessid
			inner join wfgroup b on b.groupaccessid = a.groupaccessid
			inner join workflow c on c.workflowid = b.workflowid
			where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) and b.wfbefstat = vbefstat
			limit 1;
		end if;
		return vreturn;
	END";
				$connection->createCommand($sql)->execute();

				$sql = "CREATE FUNCTION `GetWFStatusByWfName`(`vwfname` VARCHAR(50), `vrecordstatus` TINYINT)
		RETURNS TEXT
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare k varchar(50);
		
		select a.wfstatusname
		into k
		from wfstatus a
		inner join workflow b on b.workflowid = a.workflowid 
		where b.wfname = vwfname and a.wfstat = vrecordstatus
		limit 1;
		
		return k;
	END";
				$connection->createCommand($sql)->execute();
				return "ok";
			} else {
				return "Need module admin to be installed";
			}
		} catch (Exception $ex) {
			return $ex->getMessage();
		}
	}
}