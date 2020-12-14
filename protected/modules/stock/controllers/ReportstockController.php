<?php
class ReportstockController extends AdminController {
	protected $menuname	 = 'reportstock';
	public $module			 = 'stock';
	protected $pageTitle = 'Basic Stock Report';
	public function actionIndex() {
		parent::actionIndex();
		$this->render('index');
	}
	public function actionDownPDF() {
		parent::actionDownPDF();
		$qty = filter_input(INPUT_GET, 'qty');
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['product'])
			&& isset($_GET['startdate']) && isset($_GET['enddate']) && ($_GET['company'] !== '')) {
			if ($_GET['lro'] == 0) {
				$this->RincianHistoriBarang($_GET['company'], $_GET['sloc'],
					$_GET['product'], $_GET['startdate'], $_GET['enddate']);
			} else if ($_GET['lro'] == 1) {
				$this->RekapHistoriBarang($_GET['company'], $_GET['sloc'], $_GET['product'],
					$_GET['startdate'], $_GET['enddate']);
			} else
			if ($_GET['lro'] == 2) {
				$this->KartuStokBarang($_GET['company'], $_GET['sloc'], $_GET['product'],
					$_GET['startdate'], $_GET['enddate']);
			} else
			if ($_GET['lro'] == 3) {
				$this->RekapStokBarang($_GET['company'], $_GET['sloc'], $_GET['product'],
					$_GET['startdate'], $_GET['enddate']);
			} else
			if ($_GET['lro'] == 4) {
				$this->PendinganFpb($_GET['company'], $_GET['sloc'], $_GET['product'],
					$_GET['startdate'], $_GET['enddate']);
			} else
			if ($_GET['lro'] == 5) {
				$this->PendinganFpp($_GET['company'], $_GET['sloc'], $_GET['product'],
					$_GET['startdate'], $_GET['enddate']);
			} else if ($_GET['lro'] == 6) {
				$this->RekapStockOpnamePerDokumentBelumStatusMax($_GET['company'],
					$_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
			} else if ($_GET['lro'] == 7) {
				$this->LaporanFPBStatusBelumMax($_GET['company'], $_GET['sloc'],
					$_GET['product'], $_GET['startdate'], $_GET['enddate']);
			} else if ($_GET['lro'] == 8) {
				$this->LaporanKetersediaanBarang($_GET['company'], $_GET['sloc'],
					$_GET['product'], $_GET['startdate'], $_GET['enddate']);
			} else if ($_GET['lro'] == 9) {
				$this->LaporanMaterialNotMoving($_GET['company'], $_GET['sloc'],
					$_GET['product'], $_GET['startdate'], $_GET['enddate']);
			} else if ($_GET['lro'] == 10) {
				$this->LaporanMaterialSlowMoving($_GET['company'], $_GET['sloc'],
					$_GET['product'], $_GET['startdate'], $_GET['enddate'], $qty);
			} else if ($_GET['lro'] == 11) {
				$this->LaporanMaterialFastMoving($_GET['company'], $_GET['sloc'],
					$_GET['product'], $_GET['startdate'], $_GET['enddate'], $qty);
			} else {
				echo getCatalog('reportdoesnotexist');
			}
		} else
		if ($_GET['company'] === '') {
			echo getCatalog('emptycompanyid');
		} else
		if ($_GET['startdate'] === '') {
			echo getCatalog('emptystartdate');
		} else
		if ($_GET['enddate'] === '') {
			echo getCatalog('emptyenddate');
		}
	}
	public function RincianHistoriBarang($companyid, $sloc, $product, $startdate,
																			$enddate) {
		parent::actionDownpdf();
		$sql				 = "
		select distinct a.productid,b.productname,d.slocid,d.sloccode,d.description as slocdesc,
(select ifnull(sum(x.qtydet),0) from productstockdet x
						where x.productdetid = a.productid and x.slocdetid = d.slocid and
                        x.transdate < '".Yii::app()->format->formatDateSQL($startdate)."') as awal
from productplant a
join product b on b.productid=a.productid
join sloc d on d.slocid = a.slocid
join plant c on d.plantid = c.plantid
where b.isstock = 1 
and c.companyid = ".$companyid;
if ($sloc !== '') {
$sql .= " and d.slocid = ".$sloc;
}
if ($product !== '') {
$sql .= " and b.productid = ".$product;
}
$sql .= " order by productname";
		$dataReader	 = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title			 = 'Rincian Histori Barang';
		$this->pdf->subtitle	 = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('L', 'Legal');
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->setFont('Arial', 'B', 8);
		$this->pdf->colalign	 = array(
			'C',
			'C',
			'C',
			'C',
			'C',
			'C',
			'C',
			'C',
			'C',
			'C',
			'C',
			'C',
			'C'
		);
		$this->pdf->setwidths(array(
			39,
			25,
			25,
			25,
			25,
			25,
			25,
			25,
			25,
			25,
			25,
			25,
			28
		));
		$this->pdf->colheader	 = array(
			'Dokumen',
			'Tanggal',
			'Saldo Awal',
			'Beli',
			'R.Jual',
			'Trf In',
			'Prod',
			'Jual',
			'R.Beli',
			'Trf Out',
			'Pemakaian',
			'Koreksi',
			'Saldo'
		);
		$this->pdf->RowHeader();
		foreach ($dataReader as $row) {
			$this->pdf->SetFont('Arial', '', 10);
			$this->pdf->text(10, $this->pdf->gety() + 5, $row['productname']);
			$this->pdf->text(10, $this->pdf->gety() + 10, $row['sloccode'].' - '.$row['slocdesc']);
			$sql1											 = "select *,(awal+beli+returjual+trfin+produksi+jual+returbeli+trfout+pemakaian+koreksi+konversiin+konversiout) as saldo
                        from
                        (select referenceno as dokumen,transdate as tanggal,awal,slocid,
                        case when instr(referenceno,'GR-') > 0 then qty else 0 end as beli,
                        case when instr(referenceno,'GIR-') > 0 then qty else 0 end as returjual,
                        case when (instr(referenceno,'TFS-') > 0) and (qty > 0) then qty else 0 end as trfin,
                        case when (instr(referenceno,'OP-') > 0) and (qty > 0) then qty else 0 end as produksi,
                        case when instr(referenceno,'SJ-') > 0 then qty else 0 end as jual,
                        case when instr(referenceno,'GRR-') > 0 then qty else 0 end as returbeli,
                        case when (instr(referenceno,'TFS-') > 0) and (qty < 0) then qty else 0 end as trfout,
                        case when (instr(referenceno,'OP-') > 0) and (qty < 0) then qty else 0 end as pemakaian,
                        case when instr(referenceno,'TSO-') > 0 then qty else 0 end as koreksi,
						case when (instr(referenceno,'konversi') > 0) and (qty > 0) then qty else 0 end as konversiin,
						case when (instr(referenceno,'konversi') > 0) and (qty < 0) then qty else 0 end as konversiout
                        from
						(select a.referenceno,a.transdate,a.qtydet as qty,a.slocdetid as slocid,
						(select ifnull(sum(x.qtydet),0) from productstockdet x
						where x.productdetid = '".$row['productid']."' and x.slocdetid = '".$row['slocid']."' and
                        x.transdate < '".Yii::app()->format->formatDateSQL($startdate)."') as awal
                        from productstockdet a
                        inner join sloc b on b.slocid = a.slocdetid
                        inner join plant c on c.plantid = b.plantid
                        inner join company d on d.companyid = c.companyid
						inner join product e on e.productid = a.productdetid
                        where a.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
						and '".Yii::app()->format->formatDateSQL($enddate)."'
						and a.productdetid = '".$row['productid']."'
						)z )zz";
			$dataReader1							 = Yii::app()->db->createCommand($sql1)->queryAll();
			$awal											 = 0;
			$beli											 = 0;
			$r_jual										 = 0;
			$trfin										 = 0;
			$prod											 = 0;
			$jual											 = 0;
			$r_beli										 = 0;
			$trfout										 = 0;
			$pemakaian								 = 0;
			$koreksi									 = 0;
			$total										 = 0;
			$this->pdf->sety($this->pdf->gety() + 15);
			$this->pdf->coldetailalign = array(
				'L',
				'C',
				'C',
				'R',
				'R',
				'R',
				'R',
				'R',
				'R',
				'R',
				'R',
				'R',
				'R'
			);
			$this->pdf->setFont('Arial', '', 8);
			foreach ($dataReader1 as $row1) {
				$this->pdf->row(array(
					$row1['dokumen'],
					date(Yii::app()->params['datefromdb'], strtotime($row1['tanggal'])),
					'',
					Yii::app()->format->formatNumber($row1['beli']),
					Yii::app()->format->formatNumber($row1['returjual']),
					Yii::app()->format->formatNumber($row1['trfin']),
					Yii::app()->format->formatNumber($row1['produksi']),
					Yii::app()->format->formatNumber($row1['jual']),
					Yii::app()->format->formatNumber($row1['returbeli']),
					Yii::app()->format->formatNumber($row1['trfout']),
					Yii::app()->format->formatNumber($row1['pemakaian']),
					Yii::app()->format->formatNumber($row1['koreksi'] + $row1['konversiin'] + $row1['konversiout'])
				));
				$awal			 = $row1['awal'];
				$beli			 += $row1['beli'];
				$r_jual		 += $row1['returjual'];
				$trfin		 += $row1['trfin'];
				$prod			 += $row1['produksi'];
				$jual			 += $row1['jual'];
				$r_beli		 += $row1['returbeli'];
				$trfout		 += $row1['trfout'];
				$pemakaian += $row1['pemakaian'];
				$koreksi	 += $row1['koreksi'] + $row1['konversiin'] + $row1['konversiout'];
				$total		 = $awal + $beli + $r_jual + $trfin + $prod + $jual + $r_beli + $trfout
					+ $pemakaian + $koreksi;
			}
			$this->pdf->row(array(
				'',
				'Total',
				Yii::app()->format->formatNumber($awal),
				Yii::app()->format->formatNumber($beli),
				Yii::app()->format->formatNumber($r_jual),
				Yii::app()->format->formatNumber($trfin),
				Yii::app()->format->formatNumber($prod),
				Yii::app()->format->formatNumber($jual),
				Yii::app()->format->formatNumber($r_beli),
				Yii::app()->format->formatNumber($trfout),
				Yii::app()->format->formatNumber($pemakaian),
				Yii::app()->format->formatNumber($koreksi),
				Yii::app()->format->formatNumber($total)
			));
			$this->pdf->checkPageBreak(20);
		}
		$this->pdf->Output();
	}
	public function RekapHistoriBarang($companyid, $sloc, $product, $startdate,
																		$enddate) {
		parent::actionDownpdf();
		$total1			 = 0;
		$totaldisc1	 = 0;
		$totalnetto1 = 0;
		$disc				 = 0;
		$sql				 = "
		select zz.*,(awal+beli+rjual+trfin+prod+jual+rbeli+trfout+pakai+koreksi) as saldo
		from (
		select a.productname,c.uomcode,d.sloccode,
(
select ifnull(sum(z.qtydet),0)
from productstockdet z
where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
and z.transdate < '".Yii::app()->format->formatdateSQL($startdate)."'
) as awal,
(
select ifnull(sum(z.qtydet),0)
from productstockdet z
where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
and z.referenceno like '%GR-%'
) as beli,
(
select ifnull(sum(z.qtydet),0)
from productstockdet z
where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
and z.referenceno like '%GIR-%'
) as rjual,
(
select ifnull(sum(z.qtydet),0)
from productstockdet z
where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
and z.qtydet > 0
and z.referenceno like '%TFS-%'
) as trfin,
(
select ifnull(sum(z.qtydet),0)
from productstockdet z
where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
and z.qtydet > 0
and z.referenceno like '%OP-%'
) as prod,
(
select ifnull(sum(z.qtydet),0)
from productstockdet z
where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
and z.referenceno like '%SJ-%'
) as jual,
(
select ifnull(sum(z.qtydet),0)
from productstockdet z
where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
and z.referenceno like '%GRR-%'
) as rbeli,
(
select ifnull(sum(z.qtydet),0)
from productstockdet z
where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
and z.qtydet < 0
and z.referenceno like '%TFS-%'
) as trfout,
(
select ifnull(sum(z.qtydet),0)
from productstockdet z
where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
and z.qtydet < 0
and z.referenceno like '%OP-%'
) as pakai,
(
select ifnull(sum(z.qtydet),0)
from productstockdet z
where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
and z.referenceno like '%TSO-%'
) as koreksi
from product a
join productplant b on b.productid = a.productid
join unitofmeasure c on c.unitofmeasureid = b.unitofissue
join sloc d on d.slocid = b.slocid
join plant e on e.plantid = d.plantid
where e.companyid = ".$companyid."
and a.isstock = 1";
if ($product !== '') {
$sql .= " and a.productid = ".$product;
}
if ($sloc !== '') {
$sql .= " and d.slocid = ".$sloc;
}
$sql .= " order by d.slocid,a.productid) zz";

		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title					 = 'Rekap Histori Barang';
		$this->pdf->subtitle			 = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('L', 'LEGAL');
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->setFont('Arial', 'B', 7);
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C',
			'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->setwidths(array(10, 60, 20, 10, 20, 20, 20, 20, 20, 20, 20, 20, 20,
			20, 20, 20, 20, 20, 20, 20));
		$this->pdf->colheader			 = array('No', 'Nama Barang', 'Sloc', 'Unit', 'Awal', 'Beli',
			'R Jual', 'Trf In', 'Prod', 'Jual', 'R Beli', 'Trf Out', 'Pakai', 'Koreksi', 'Saldo');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'R', 'R', 'R', 'R', 'R', 'R',
			'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R',
			'R');
		$this->pdf->setFont('Arial', '', 7);
		$i												 = 0;

		foreach ($dataReader as $row) {
			$i += 1;
			$this->pdf->row(array(
				$i,
				$row['productname'],
				$row['sloccode'],
				$row['uomcode'],
				Yii::app()->format->formatNumber($row['awal']),
				Yii::app()->format->formatNumber($row['beli']),
				Yii::app()->format->formatNumber($row['rjual']),
				Yii::app()->format->formatNumber($row['trfin']),
				Yii::app()->format->formatNumber($row['prod']),
				Yii::app()->format->formatNumber($row['jual']),
				Yii::app()->format->formatNumber($row['rbeli']),
				Yii::app()->format->formatNumber($row['trfout']),
				Yii::app()->format->formatNumber($row['pakai']),
				Yii::app()->format->formatNumber($row['koreksi']),
				Yii::app()->format->formatNumber($row['saldo'])));
		}
		$this->pdf->Output();
	}
	public function KartuStokBarang($companyid, $sloc, $product, $startdate,
																 $enddate) {
		parent::actionDownpdf();
		$total1			 = 0;
		$totaldisc1	 = 0;
		$totalnetto1 = 0;
		$disc				 = 0;
		$sql				 = "select a.productid,a.productname
		from product a
		where a.isstock = 1";
		if ($product !== '') {
			$sql .= " and a.productid = ".$product;
		}

		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title		 = 'Kartu Stok Barang';
		$this->pdf->subtitle = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('P');
		$this->pdf->sety($this->pdf->gety() + 5);

		foreach ($dataReader as $row) {
			$this->pdf->SetFont('Arial', '', 10);
			$this->pdf->text(10, $this->pdf->gety() + 10,
				getCatalog('product').': '.$row['productname']);
			$sql1											 = "select a.referenceno, a.transdate,b.productname, c.sloccode,a.qtydet,d.uomcode
				from productstockdet a
				join product b on b.productid = a.productdetid
				join sloc c on c.slocid = a.slocdetid
				join unitofmeasure d on d.unitofmeasureid = a.uomdetid
				join plant e on e.plantid = c.plantid
				where b.productid = ".$row['productid']."
				and b.isstock = 1
				and e.companyid like '%".$companyid."%'";
				if ($sloc !== '') {
				$sql1 .= " and c.slocid = ".$sloc;
				}
				if ($product !== '') {
				$sql1 .= " and b.productid = ".$product;
				}
				$sql1 .= " and a.transdate between '".Yii::app()->format->formatdateSQL($startdate)."'
					and '".Yii::app()->format->formatdateSQL($enddate)."'
				order by a.transdate";
			$dataReader1							 = Yii::app()->db->createCommand($sql1)->queryAll();
			$i												 = 0;
			$this->pdf->sety($this->pdf->gety() + 15);
			$this->pdf->setFont('Arial', 'B', 7);
			$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C',
				'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
			$this->pdf->setwidths(array(10, 90, 20, 30, 30, 20, 20, 20, 20, 20, 20, 20, 20,
				20, 20, 20, 20, 20, 20, 20));
			$this->pdf->colheader			 = array('No', 'Dokumen', 'Tgl Dok', 'Sloc', 'Qty');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L', 'L', 'C', 'R', 'R', 'R', 'R', 'R', 'R',
				'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R',
				'R');
			$this->pdf->setFont('Arial', '', 7);
			$subtotal									 = 0;
			foreach ($dataReader1 as $row1) {
				$i++;
				$this->pdf->row(array(
					$i,
					$row1['referenceno'],
					Yii::app()->format->formatDate($row1['transdate']),
					$row1['sloccode'],
					Yii::app()->format->formatNumber($row1['qtydet'])));
				$subtotal += $row1['qtydet'];
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->row(array(
				'',
				'Total '.$row['productname'],
				'',
				'',
				Yii::app()->format->formatNumber($subtotal)));
		}
		$this->pdf->Output();
	}
	public function RekapStokBarang($companyid, $sloc, $product, $startdate,
																 $enddate) {
		parent::actionDownpdf();
		$total1			 = 0;
		$totaldisc1	 = 0;
		$totalnetto1 = 0;
		$disc				 = 0;
		$sql				 = "
			select zzz.*, (awal+masuk+keluar+koreksi) as total
			from
			(
			select zz.productname,zz.uomcode,zz.sloccode,awal,(beli+rjual+trfin+prod) as masuk,
			(jual+rbeli+trfout+pakai)*-1 as keluar,koreksi
			from
			(
					select a.productname,c.uomcode,d.sloccode,
			(
			select ifnull(sum(z.qtydet),0)
			from productstockdet z
			where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
			and z.transdate < '".Yii::app()->format->formatdateSQL($startdate)."'
			) as awal,
			(
			select ifnull(sum(z.qtydet),0)
			from productstockdet z
			where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
			and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
			and z.referenceno like '%GR-%'
			) as beli,
			(
			select ifnull(sum(z.qtydet),0)
			from productstockdet z
			where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
			and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
			and z.referenceno like '%GIR-%'
			) as rjual,
			(
			select ifnull(sum(z.qtydet),0)
			from productstockdet z
			where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
			and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
			and z.qtydet > 0
			and z.referenceno like '%TFS-%'
			) as trfin,
			(
			select ifnull(sum(z.qtydet),0)
			from productstockdet z
			where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
			and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
			and z.qtydet > 0
			and z.referenceno like '%OP-%'
			) as prod,
			(
			select ifnull(sum(z.qtydet),0)
			from productstockdet z
			where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
			and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
			and z.referenceno like '%SJ%'
			) as jual,
			(
			select ifnull(sum(z.qtydet),0)
			from productstockdet z
			where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
			and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
			and z.referenceno like '%GR-%'
			) as rbeli,
			(
			select ifnull(sum(z.qtydet),0)
			from productstockdet z
			where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
			and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
			and z.qtydet < 0
			and z.referenceno like '%TFS-%'
			) as trfout,
			(
			select ifnull(sum(z.qtydet),0)
			from productstockdet z
			where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
			and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
			and z.qtydet < 0
			and z.referenceno like '%OP-%'
			) as pakai,
			(
			select ifnull(sum(z.qtydet),0)
			from productstockdet z
			where z.productdetid = a.productid and z.slocdetid = b.slocid and z.uomdetid = c.unitofmeasureid
			and z.transdate between '".Yii::app()->format->formatdateSQL($startdate)."' and '".Yii::app()->format->formatdateSQL($enddate)."'
			and z.referenceno like '%TSO%'
			) as koreksi
			from product a
			join productplant b on b.productid = a.productid
			join unitofmeasure c on c.unitofmeasureid = b.unitofissue
			join sloc d on d.slocid = b.slocid
			join plant e on e.plantid = d.plantid
			where e.companyid = ".$companyid;
			if ($product !== '') {
			$sql .= " and a.productid = ".$product;
			}
			if ($sloc !== '') {
			$sql .= " and d.slocid = ".$sloc;
			}
			$sql .= " order by d.slocid,a.productid) zz ) zzz";

		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title					 = 'Rekap Stok Barang';
		$this->pdf->subtitle			 = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('P');
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->setFont('Arial', 'B', 7);
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C',
			'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->setwidths(array(10, 60, 15, 10, 20, 20, 20, 20, 20, 20, 20, 20, 20,
			20, 20, 20, 20, 20, 20, 20));
		$this->pdf->colheader			 = array('No', 'Nama Barang', 'Sloc', 'Unit', 'Awal', 'Masuk',
			'Keluar', 'Koreksi', 'Saldo');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'R', 'R', 'R', 'R', 'R', 'R',
			'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R',
			'R');
		$this->pdf->setFont('Arial', '', 7);
		$i												 = 0;

		foreach ($dataReader as $row) {
			$i += 1;
			$this->pdf->row(array(
				$i,
				$row['productname'],
				$row['sloccode'],
				$row['uomcode'],
				Yii::app()->format->formatNumber($row['awal']),
				Yii::app()->format->formatNumber($row['masuk']),
				Yii::app()->format->formatNumber($row['keluar']),
				Yii::app()->format->formatNumber($row['koreksi']),
				Yii::app()->format->formatNumber($row['total'])));
		}
		$this->pdf->Output();
	}
	public function PendinganFpb($companyid, $sloc, $product, $startdate, $enddate) {
		parent::actionDownpdf();
		$sql				 = "select d.frno,d.frdate,b.productname,c.uomcode,a.qty,a.poqty,a.grqty,a.tsqty,a.prqty,a.itemtext
			from formrequestdet a
			join product b on b.productid = a.productid
			join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
			join formrequest d on d.formrequestid = a.formrequestid
			join company e on e.companyid = d.companyid
			where d.recordstatus = getwfmaxstatbywfname('appda')
			and a.qty > a.tsqty
			and e.companyid = ".$companyid;
			if ($product !== '') {
			$sql .= " and b.productid = ".$product;
			}
			if ($sloc !== '') {
			$sql .= " and d.slocid = ".$sloc;
			}
			$sql .= " and d.frdate between '".Yii::app()->format->formatDateSQL($startdate)."' and '".Yii::app()->format->formatDateSQL($enddate)."'
			order by d.frdate,d.frno
			";
		$dataReader	 = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title					 = 'Pendingan Form Permintaan Barang';
		$this->pdf->subtitle			 = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.
			Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('P');
		$i												 = 0;
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->setFont('Arial', 'B', 8);
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C',
			'C', 'C');
		$this->pdf->setwidths(array(10, 20, 20, 50, 15, 15, 15, 15, 15, 15, 15, 15, 15,
			15));
		$this->pdf->colheader			 = array('No', 'No FPB', 'Tgl FPB', 'Nama Barang', 'Qty',
			'Trf Qty', 'Pr Qty', 'Po Qty', 'Gr Qty', 'Note');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'R', 'R', 'R', 'R', 'R',
			'C');
		$this->pdf->setFont('Arial', '', 8);

		foreach ($dataReader as $row) {
			$i += 1;
			$this->pdf->row(array(
				$i,
				$row['frno'],
				Yii::app()->format->formatDate($row['frdate']),
				$row['productname'],
				Yii::app()->format->formatNumber($row['qty']),
				Yii::app()->format->formatNumber($row['tsqty']),
				Yii::app()->format->formatNumber($row['prqty']),
				Yii::app()->format->formatNumber($row['poqty']),
				Yii::app()->format->formatNumber($row['grqty']),
				$row['itemtext'],
			));
		}
		$this->pdf->Output();
	}
	public function PendinganFpp($companyid, $sloc, $product, $startdate, $enddate) {
		parent::actionDownpdf();
		$sql				 = "select d.prno,d.prdate,b.productname,c.uomcode,a.qty,a.poqty,a.grqty,a.itemtext
			from prmaterial a
			join product b on b.productid = a.productid
			join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
			join prheader d on d.prheaderid = a.prheaderid
			join company e on e.companyid = d.companyid
			join formrequest f on f.formrequestid = d.formrequestid
			where d.recordstatus = getwfmaxstatbywfname('apppr')
			and e.companyid = ".$companyid;
			if ($sloc !== '') {
			$sql .= " and f.slocid = ".$sloc;
			}
			if ($product !== '') {
			$sql .= " and b.productid = ".$product;
			}
			$sql .= " and d.prdate between '".Yii::app()->format->formatDateSQL($startdate)."' and '".Yii::app()->format->formatDateSQL($enddate)."'
			and a.qty > a.poqty
			";
		$dataReader	 = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title					 = 'Pendingan Form Permohonan Pembelian';
		$this->pdf->subtitle			 = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.
			Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('P');
		$i												 = 0;
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->setFont('Arial', 'B', 8);
		$this->pdf->colalign			 = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
		$this->pdf->setwidths(array(10, 20, 20, 50, 20, 20, 20, 20));
		$this->pdf->colheader			 = array('No', 'No FPB', 'Tgl FPB', 'Nama Barang', 'Qty',
			'Po Qty', 'Gr Qty', 'Note');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L', 'L', 'L', 'L', 'R', 'R', 'R', 'L');
		$this->pdf->setFont('Arial', '', 8);

		foreach ($dataReader as $row) {
			$i += 1;
			$this->pdf->row(array(
				$i,
				$row['prno'],
				Yii::app()->format->formatDate($row['prdate']),
				$row['productname'],
				Yii::app()->format->formatNumber($row['qty']),
				Yii::app()->format->formatNumber($row['poqty']),
				Yii::app()->format->formatNumber($row['grqty']),
				$row['itemtext'],
			));
		}
		$this->pdf->Output();
	}
	public function RekapStockOpnamePerDokumentBelumStatusMax($companyid, $sloc,
																													 $product, $startdate, $enddate) {
		parent::actionDownpdf();
		$sql				 = "select distinct a.stockopnameid,a.transdate,a.stockopnameno,d.sloccode,a.headernote,a.recordstatus,getwfstatusbywfname(a.recordstatus,'appbs') as statusname
								from stockopname a
								join stockopnamedet b on b.stockopnameid = a.stockopnameid
								join product c on c.productid = b.productid
								join sloc d on d.slocid = a.slocid
								join plant e on e.plantid = d.plantid
								where a.transdate between '".Yii::app()->format->formatDateSQL($startdate)."' and '".Yii::app()->format->formatDateSQL($enddate)."'
								and a.recordstatus between 1 and 4
								and e.companyid = ".$companyid;
								if ($product !== '') {
								$sql .= " and c.productid = ".$product;
								}
								if ($sloc !== '') {
								$sql .= " and d.slocid = ".$sloc;
								}
								$sql .= " order by a.recordstatus";
		$dataReader	 = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title					 = 'Rekap Stock Opname Per Dokumen Status Belum Max';
		$this->pdf->subtitle			 = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial', 'B', 8);
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->colalign			 = array(
			'C',
			'C',
			'C',
			'C',
			'C',
			'C',
			'L',
			'L'
		);
		$this->pdf->setwidths(array(
			10,
			20,
			25,
			20,
			20,
			22,
			50,
			25
		));
		$this->pdf->colheader			 = array(
			'No',
			'ID Transaksi',
			'No Transaksi',
			'Tanggal',
			'No Referensi',
			'Gudang',
			'Keterangan',
			'Status'
		);
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array(
			'C',
			'C',
			'C',
			'C',
			'C',
			'C',
			'L',
			'L'
		);
		$i												 = 0;
		foreach ($dataReader as $row) {
			$i += 1;
			$this->pdf->setFont('Arial', '', 7);
			$this->pdf->row(array(
				$i,
				$row['stockopnameid'],
				$row['stockopnameno'],
				Yii::app()->format->formatDate($row['transdate']),
				'-',
				$row['sloccode'],
				$row['headernote'],
				$row['statusname']
			));
			$this->pdf->checkPageBreak(20);
		}
		$this->pdf->Output();
	}
	public function LaporanFPBStatusBelumMax($companyid, $sloc, $product,
																					$startdate, $enddate) {
		parent::actionDownpdf();
		$sql				 = "select a.formrequestid, a.frdate,a.frno,b.sloccode,a.headernote,getwfstatusbywfname(a.recordstatus,'appda') as statusname
				from formrequest a
				join sloc b on b.slocid = a.slocid
				where a.recordstatus between 1 and 2
				and a.formrequestid in
				(
				select c.formrequestid 
from formrequestdet c";
if ($product !== '') {
$sql .= " where c.productid = ".$product;
}
				$sql .= ")";
				if ($sloc !== '') {
				$sql .= " and a.slocid = ".$sloc;
				}
				$sql .= " and a.frdate between ('".Yii::app()->format->formatDateSQL($startdate)."') AND ('".Yii::app()->format->formatDateSQL($enddate)."')
            ORDER BY formrequestid DESC";
		$dataReader	 = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title					 = 'Dokumen FPB Status Belum Max';
		$this->pdf->subtitle			 = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial', 'B', 8);
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->colalign			 = array(
			'C',
			'C',
			'C',
			'C',
			'C',
			'C'
		);
		$this->pdf->setwidths(array(
			10,
			25,
			30,
			30,
			50,
			30
		));
		$this->pdf->colheader			 = array(
			'No',
			'No FPB',
			'Tanggal Request',
			'User Request',
			'Keterangan',
			'Status'
		);
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array(
			'C',
			'L',
			'L',
			'L',
			'L',
			'L'
		);
		$i												 = 0;
		foreach ($dataReader as $row) {
			$i += 1;
			$this->pdf->setFont('Arial', '', 10);
			$this->pdf->row(array(
				$i,
				$row['frno'],
				Yii::app()->format->formatDate($row['frdate']),
				$row['username'],
				$row['headernote'],
				$row['statusname']
			));
			$this->pdf->checkPageBreak(20);
		}
		$this->pdf->Output();
	}
	public function LaporanKetersediaanBarang($companyid, $sloc, $product,
																					 $startdate, $enddate) {
		parent::actionDownpdf();
		$sql				 = "SELECT *, c.productname, d.sloccode, e.uomcode,SUM(b.qty) as qty
                   FROM mrp a
									 join product c on c.productid = a.productid
									 join sloc d on d.slocid = a.slocid
									 join unitofmeasure e on e.unitofmeasureid = a.uomid
                   LEFT JOIN productstock b ON b.productid = a.productid AND b.unitofmeasureid = a.uomid AND a.slocid = b.slocid";
									 if ($sloc !== '') {
										 $sql .= " where b.slocid = ".$sloc;
										 if ($product !== '') {
											 $sql .= " and b.productid = ".$product;
										 }
									 } else {
										 if ($product !== '') {
											 $sql .= " where b.productid = ".$product;
										 }
									 }
									 $sql .= "
                   GROUP By  b.productid
                   HAVING qty <= a.reordervalue";
		$dataReader	 = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title					 = 'Laporan Ketersediaan Barang';
		$this->pdf->subtitle			 = 'Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial', 'B', 8);
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->colalign			 = array(
			'C',
			'C',
			'C',
			'C',
			'C'
		);
		$this->pdf->setwidths(array(
			10,
			80,
			50,
			25,
			20
		));
		$this->pdf->colheader			 = array(
			'No',
			'Nama Barang',
			'Gudang',
			'Satuan',
			'QTY'
		);
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array(
			'C',
			'L',
			'L',
			'C',
			'R'
		);
		$i												 = 0;
		foreach ($dataReader as $row) {
			$i += 1;
			$this->pdf->setFont('Arial', '', 7);
			$this->pdf->row(array(
				$i,
				$row['productname'],
				$row['sloccode'],
				$row['uomcode'],
				Yii::app()->format->formatNumber($row['qty'])
			));
			$this->pdf->checkPageBreak(20);
		}

		$this->pdf->Output();
	}
	public function LaporanMaterialNotMoving($companyid, $sloc, $product,
																					$startdate, $enddate) {
		parent::actionDownpdf();
		$awal2			 = 0;
		$masuk2			 = 0;
		$keluar2		 = 0;
		$akhir2			 = 0;
		$sql				 = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = ".$companyid;
										if ($sloc !== '') {
										$sql .= " and c.slocid = ".$sloc;
										}
										if ($product !== '') {
										$sql .= " and f.productid = ".$product;
										}
										$sql .= " and f.productid in
                    (select z.productdetid
                    from productstockdet z
                    join sloc za on za.slocid = z.slocdetid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = ".$companyid." and z.slocdetid = c.slocid and z.uomdetid = b.unitofissue)";
		$dataReader	 = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title			 = 'Laporan Material Not Moving';
		$this->pdf->subtitle	 = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('P');
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->setFont('Arial', 'B', 8);
		$this->pdf->colalign	 = array(
			'C',
			'C',
			'C',
			'C',
			'C',
			'C'
		);
		$this->pdf->setwidths(array(
			80,
			20,
			20,
			20,
			20,
			20
		));
		$this->pdf->colheader	 = array(
			'Nama Barang',
			'Satuan',
			'Awal',
			'Masuk',
			'Keluar',
			'Akhir'
		);
		$this->pdf->RowHeader();
		foreach ($dataReader as $row) {
			$awal1			 = 0;
			$masuk1			 = 0;
			$keluar1		 = 0;
			$akhir1			 = 0;
			$this->pdf->SetFont('Arial', 'B', 10);
			$this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
			$this->pdf->text(28, $this->pdf->gety() + 7, ': '.$row['sloccode']);
			$sql1				 = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = ".$companyid." 
										and c.slocid = ".$row['slocid'];
										if ($sloc !== '') {
										$sql1 .= " and c.slocid = ".$sloc;
										}
										if ($product !== '') {
										$sql1 .= " and f.productid = ".$product;
										}
										$sql1 .= " and f.productid in
                    (select z.productdetid
                    from productstockdet z
                    join sloc za on za.slocid = z.slocdetid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = ".$companyid." and z.slocdetid = c.slocid and z.uomdetid = b.unitofissue)";
			$dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
			$this->pdf->sety($this->pdf->gety() + 5);
			foreach ($dataReader1 as $row1) {
				$awal				 = 0;
				$masuk			 = 0;
				$keluar			 = 0;
				$akhir			 = 0;
				$this->pdf->SetFont('Arial', 'BI', 9);
				$this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
				$this->pdf->text(45, $this->pdf->gety() + 7, ': '.$row1['divisi']);
				$this->pdf->text(80, $this->pdf->gety() + 7, '');
				$this->pdf->text(165, $this->pdf->gety() + 7, ''.$row['sloccode']);
				$sql2				 = "select distinct b.productid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '".$companyid."' 
										and a.materialgroupid = ".$row1['materialgroupid'];
										if ($sloc !== '') {
										$sql2 .= " and d.slocid = ".$sloc;
										}
										if ($product !== '') {
										$sql2 .= " and g.productid = ".$product;
										}
										$sql2 .= " and b.productid in
                    (select z.productdetid
                    from productstockdet z
                    join sloc za on za.slocid = z.slocdetid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = ".$companyid." and z.slocdetid = b.slocid and z.uomdetid = b.unitofissue)";
				$dataReader2 = Yii::app()->db->createCommand($sql2)->queryAll();
				$this->pdf->sety($this->pdf->gety() + 8);
				foreach ($dataReader2 as $row2) {
					$sql3											 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,keluar2
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,(jual+returbeli+trfout+pemakaian+konversiout) as keluar2
                            from
                            (select
                            (
                            select distinct za.productname
                            from productstockdet a
														join product za on za.productid = a.productdetid
                            where a.productdetid = t.productid and
                            a.uomdetid = t.unitofissue
														limit 1
                            ) as barang,
                            (
                            select distinct zb.uomcode
                            from productstockdet b
														join unitofmeasure zb on zb.unitofmeasureid = b.uomdetid
                            where b.productdetid = t.productid and
                            b.uomdetid = t.unitofissue
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qtydet),0)
                            from productstockdet aw
                            where aw.productdetid = t.productid and
                            aw.transdate < '".Yii::app()->format->formatDateSQL($startdate)."' and
                            aw.slocdetid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qtydet),0)
                            from productstockdet c
                            where c.productdetid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocdetid = t.slocid and
                            c.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as beli,
                            (
                            select ifnull(sum(d.qtydet),0)
                            from productstockdet d
                            where d.productdetid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocdetid = t.slocid and
                            d.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qtydet),0)
                            from productstockdet e
                            where e.productdetid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qtydet > 0 and
                            e.slocdetid = t.slocid and
                            e.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qtydet),0)
                            from productstockdet f
                            where f.productdetid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qtydet > 0 and
                            f.slocdetid = t.slocid and
                            f.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qtydet),0)
                            from productstockdet g
                            where g.productdetid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocdetid = t.slocid and
                            g.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as jual,
                            (
                            select ifnull(sum(h.qtydet),0)
                            from productstockdet h
                            where h.productdetid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocdetid = t.slocid and
                            h.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qtydet),0)
                            from productstockdet i
                            where i.productdetid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qtydet < 0 and
                            i.slocdetid = t.slocid and
                            i.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qtydet),0)
                            from productstockdet j
                            where j.productdetid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qtydet < 0 and
                            j.slocdetid = t.slocid and
                            j.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qtydet),0)
                            from productstockdet k
                            where k.productdetid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocdetid = t.slocid and
                            k.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as koreksi,
							(select ifnull(sum(l.qtydet),0)
                            from productstockdet l
                            where l.productdetid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qtydet > 0 and
                            l.slocdetid = t.slocid
							and l.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qtydet),0)
                            from productstockdet m
                            where m.productdetid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qtydet < 0 and
                            m.slocdetid = t.slocid and
                            m.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '".$row2['productid']."' and u.materialgroupid = '".$row1['materialgroupid']."'
							and v.slocid = '".$row['slocid']." order by keluar2') z) zz )zzz
							where (awal <> 0 or masuk <> 0  or akhir <> 0 or keluar <> 0) and keluar2 =0 order by keluar2 asc";
					$this->pdf->sety($this->pdf->gety());
					$this->pdf->coldetailalign = array(
						'L',
						'C',
						'R',
						'R',
						'R',
						'R'
					);
					$this->pdf->setFont('Arial', '', 8);
					$dataReader3							 = Yii::app()->db->createCommand($sql3)->queryAll();
					foreach ($dataReader3 as $row3) {
						$this->pdf->row(array(
							$row3['barang'],
							$row3['satuan'],
							Yii::app()->format->formatNumber($row3['awal']),
							Yii::app()->format->formatNumber($row3['masuk']),
							Yii::app()->format->formatNumber($row3['keluar']),
							Yii::app()->format->formatNumber($row3['akhir'])
						));
						$awal		 += $row3['awal'];
						$masuk	 += $row3['masuk'];
						$keluar	 += $row3['keluar'];
						$akhir	 += $row3['akhir'];
					}
				}
				$this->pdf->SetFont('Arial', 'BI', 8);
				$this->pdf->row(array(
					'JUMLAH '.$row1['divisi'],
					'',
					Yii::app()->format->formatNumber($awal),
					Yii::app()->format->formatNumber($masuk),
					Yii::app()->format->formatNumber($keluar),
					Yii::app()->format->formatNumber($akhir)
				));
				$awal1	 += $awal;
				$masuk1	 += $masuk;
				$keluar1 += $keluar;
				$akhir1	 += $akhir;
			}
			$this->pdf->row(array(
				'TOTAL '.$row['sloccode'],
				'',
				Yii::app()->format->formatNumber($awal1),
				Yii::app()->format->formatNumber($masuk1),
				Yii::app()->format->formatNumber($keluar1),
				Yii::app()->format->formatNumber($akhir1)
			));
			$awal2	 += $awal1;
			$masuk2	 += $masuk1;
			$keluar2 += $keluar1;
			$akhir2	 += $akhir1;
		}
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->SetFont('Arial', 'BI', 9);
		$this->pdf->row(array(
			'GRAND TOTAL',
			'',
			Yii::app()->format->formatNumber($awal2),
			Yii::app()->format->formatNumber($masuk2),
			Yii::app()->format->formatNumber($keluar2),
			Yii::app()->format->formatNumber($akhir2)
		));
		$this->pdf->Output();
	}
	public function LaporanMaterialSlowMoving($companyid, $sloc, $product,
																					 $startdate, $enddate, $keluar3) {
		parent::actionDownpdf();
		$awal2			 = 0;
		$masuk2			 = 0;
		$keluar2		 = 0;
		$akhir2			 = 0;
		$sql				 = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = ".$companyid;
										if ($sloc !== '') {
										$sql .= " and c.slocid = ".$sloc;
										}
										if ($product !== '') {
										$sql .= " and f.productid = ".$product;
										}
										$sql .= " and f.productid in
                    (select z.productdetid
                    from productstockdet z
                    join sloc za on za.slocid = z.slocdetid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = ".$companyid." and z.slocdetid = c.slocid and z.uomdetid = b.unitofissue)";
		$dataReader	 = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title		 = 'Laporan Material Slow Moving';
		$this->pdf->subtitle = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('P');

		$this->pdf->sety($this->pdf->gety() + 5);

		if ($keluar3 == 0) {
			$this->pdf->SetFont('helvetica', 'B', 20);
			$this->pdf->text(70, 90, 'Anda Belum Mengisi');
			$this->pdf->text(90, 110, 'QTY Keluar,');
			$this->pdf->text(50, 130, 'Silahkan Isi Dahulu QTY Keluar');
		} else {
			$this->pdf->setFont('Arial', 'B', 8);
			$this->pdf->colalign	 = array(
				'C',
				'C',
				'C',
				'C',
				'C',
				'C'
			);
			$this->pdf->setwidths(array(
				80,
				20,
				20,
				20,
				20,
				20
			));
			$this->pdf->colheader	 = array(
				'Nama Barang',
				'Satuan',
				'Awal',
				'Masuk',
				'Keluar',
				'Akhir'
			);
			$this->pdf->RowHeader();
			foreach ($dataReader as $row) {
				$awal1			 = 0;
				$masuk1			 = 0;
				$keluar1		 = 0;
				$akhir1			 = 0;
				$this->pdf->SetFont('Arial', 'B', 10);
				$this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
				$this->pdf->text(28, $this->pdf->gety() + 7, ': '.$row['sloccode']);
				$sql1				 = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = ".$companyid." 
										and c.slocid = ".$row['slocid'];
										if ($sloc !== '') {
										$sql1 .= " and c.slocid = ".$sloc;
										}
										if ($product !== '') {
										$sql1 .= " and f.productid = ".$product;
										}
										$sql1 .= " and f.productid in
                    (select z.productdetid
                    from productstockdet z
                    join sloc za on za.slocid = z.slocdetid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = ".$companyid." and z.slocdetid = c.slocid and z.uomdetid = b.unitofissue)";
				$dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
				$this->pdf->sety($this->pdf->gety() + 5);
				foreach ($dataReader1 as $row1) {
					$awal		 = 0;
					$masuk	 = 0;
					$keluar	 = 0;
					$akhir	 = 0;
					$this->pdf->SetFont('Arial', 'BI', 9);
					$this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
					$this->pdf->text(45, $this->pdf->gety() + 7, ': '.$row1['divisi']);
					$this->pdf->text(80, $this->pdf->gety() + 7, '');
					$this->pdf->text(165, $this->pdf->gety() + 7, ''.$row['sloccode']);

					$this->pdf->sety($this->pdf->gety() + 8);
					$sql3											 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,keluar2
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,(jual+returbeli+trfout+pemakaian+konversiout) as keluar2
                            from
                            (select
                            (
                            select distinct b.productname
                            from productstockdet a
														join product b on b.productid = a.productdetid
                            where a.productdetid = t.productid and
                            a.uomdetid = t.unitofissue
														limit 1
                            ) as barang,
                            (
                            select distinct zb.uomcode
                            from productstockdet b
														join unitofmeasure zb on zb.unitofmeasureid = b.uomdetid
                            where b.productdetid = t.productid and
                            b.uomdetid = t.unitofissue
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qtydet),0)
                            from productstockdet aw
                            where aw.productdetid = t.productid and
                            aw.transdate < '".Yii::app()->format->formatDateSQL($startdate)."' and
                            aw.slocdetid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qtydet),0)
                            from productstockdet c
                            where c.productdetid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocdetid = t.slocid and
                            c.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as beli,
                            (
                            select ifnull(sum(d.qtydet),0)
                            from productstockdet d
                            where d.productdetid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocdetid = t.slocid and
                            d.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qtydet),0)
                            from productstockdet e
                            where e.productdetid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qtydet > 0 and
                            e.slocdetid = t.slocid and
                            e.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qtydet),0)
                            from productstockdet f
                            where f.productdetid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qtydet > 0 and
                            f.slocdetid = t.slocid and
                            f.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qtydet),0)
                            from productstockdet g
                            where g.productdetid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocdetid = t.slocid and
                            g.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as jual,
                            (
                            select ifnull(sum(h.qtydet),0)
                            from productstockdet h
                            where h.productdetid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocdetid = t.slocid and
                            h.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qtydet),0)
                            from productstockdet i
                            where i.productdetid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qtydet < 0 and
                            i.slocdetid = t.slocid and
                            i.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qtydet),0)
                            from productstockdet j
                            where j.productdetid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qtydet < 0 and
                            j.slocdetid = t.slocid and
                            j.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qtydet),0)
                            from productstockdet k
                            where k.productdetid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocdetid = t.slocid and
                            k.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as koreksi,
							(select ifnull(sum(l.qtydet),0)
                            from productstockdet l
                            where l.productdetid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qtydet > 0 and
                            l.slocdetid = t.slocid
							and l.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qtydet),0)
                            from productstockdet m
                            where m.productdetid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qtydet < 0 and
                            m.slocdetid = t.slocid and
                            m.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where u.materialgroupid = '".$row1['materialgroupid']."'
							and v.slocid = '".$row['slocid']."') z) zz )zzz
							where (awal <> 0 or masuk <> 0  or akhir <> 0 or keluar <> 0) and keluar2 > - ".$keluar3;
							if ($product !== '') {
								$sql3 .= " and t.productid = ".$product;
							}
						$sql3 .= " order by keluar2 asc";
					$this->pdf->sety($this->pdf->gety());
					$this->pdf->coldetailalign = array(
						'L',
						'C',
						'R',
						'R',
						'R',
						'R'
					);
					$this->pdf->setFont('Arial', '', 8);
					$dataReader3							 = Yii::app()->db->createCommand($sql3)->queryAll();
					foreach ($dataReader3 as $row3) {
						$this->pdf->row(array(
							$row3['barang'],
							$row3['satuan'],
							Yii::app()->format->formatNumber($row3['awal']),
							Yii::app()->format->formatNumber($row3['masuk']),
							Yii::app()->format->formatNumber($row3['keluar']),
							Yii::app()->format->formatNumber($row3['akhir'])
						));
						$awal		 += $row3['awal'];
						$masuk	 += $row3['masuk'];
						$keluar	 += $row3['keluar'];
						$akhir	 += $row3['akhir'];
					}
					$this->pdf->SetFont('Arial', 'BI', 8);
					$this->pdf->row(array(
						'JUMLAH '.$row1['divisi'],
						'',
						Yii::app()->format->formatNumber($awal),
						Yii::app()->format->formatNumber($masuk),
						Yii::app()->format->formatNumber($keluar),
						Yii::app()->format->formatNumber($akhir)
					));
					$awal1	 += $awal;
					$masuk1	 += $masuk;
					$keluar1 += $keluar;
					$akhir1	 += $akhir;
				}
				$this->pdf->row(array(
					'TOTAL '.$row['sloccode'],
					'',
					Yii::app()->format->formatNumber($awal1),
					Yii::app()->format->formatNumber($masuk1),
					Yii::app()->format->formatNumber($keluar1),
					Yii::app()->format->formatNumber($akhir1)
				));
				$awal2	 += $awal1;
				$masuk2	 += $masuk1;
				$keluar2 += $keluar1;
				$akhir2	 += $akhir1;
			}
			$this->pdf->sety($this->pdf->gety() + 5);
			$this->pdf->SetFont('Arial', 'BI', 9);
			$this->pdf->row(array(
				'GRAND TOTAL',
				'',
				Yii::app()->format->formatNumber($awal2),
				Yii::app()->format->formatNumber($masuk2),
				Yii::app()->format->formatNumber($keluar2),
				Yii::app()->format->formatNumber($akhir2)
			));
		}
		$this->pdf->Output();
	}
	public function LaporanMaterialFastMoving($companyid, $sloc, $product,
																					 $startdate, $enddate, $keluar3) {
		parent::actionDownpdf();
		$awal2			 = 0;
		$masuk2			 = 0;
		$keluar2		 = 0;
		$akhir2			 = 0;
		$sql				 = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = ".$companyid;
										if ($sloc !== '') {
										$sql .= " and c.slocid = ".$sloc;
										}
										if ($product !== '') {
										$sql .= " and f.productid = ".$product;
										}
										$sql .= " and f.productid in
                    (select z.productdetid
                    from productstockdet z
                    join sloc za on za.slocid = z.slocdetid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = ".$companyid." and z.slocdetid = c.slocid and z.uomdetid = b.unitofissue)";
		$dataReader	 = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($dataReader as $row) {
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title		 = 'Laporan Material Fast Moving';
		$this->pdf->subtitle = 'Dari Tgl :'.Yii::app()->format->formatDate($startdate).' s/d '.Yii::app()->format->formatDate($enddate);
		$this->pdf->AddPage('P');

		$this->pdf->sety($this->pdf->gety() + 5);

		if ($keluar3 == 0) {
			$this->pdf->SetFont('helvetica', 'B', 20);
			$this->pdf->text(70, 90, 'Anda Belum Mengisi');
			$this->pdf->text(90, 110, 'QTY Keluar,');
			$this->pdf->text(50, 130, 'Silahkan Isi Dahulu QTY Keluar');
		} else {
			$this->pdf->setFont('Arial', 'B', 8);
			$this->pdf->colalign	 = array(
				'C',
				'C',
				'C',
				'C',
				'C',
				'C'
			);
			$this->pdf->setwidths(array(
				80,
				20,
				20,
				20,
				20,
				20
			));
			$this->pdf->colheader	 = array(
				'Nama Barang',
				'Satuan',
				'Awal',
				'Masuk',
				'Keluar',
				'Akhir'
			);
			$this->pdf->RowHeader();
			foreach ($dataReader as $row) {
				$awal1			 = 0;
				$masuk1			 = 0;
				$keluar1		 = 0;
				$akhir1			 = 0;
				$this->pdf->SetFont('Arial', 'B', 10);
				$this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
				$this->pdf->text(28, $this->pdf->gety() + 7, ': '.$row['sloccode']);
				$sql1				 = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = ".$companyid." 
										and c.slocid = ".$row['slocid'];
										if ($sloc !== '') {
										$sql1 .= " and c.slocid = ".$sloc;
										}
										if ($product !== '') {
										$sql1 .= " and f.productid = ".$product;
										}
										$sql1 .= " and f.productid in
                    (select z.productdetid
                    from productstockdet z
                    join sloc za on za.slocid = z.slocdetid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = ".$companyid." and z.slocdetid = c.slocid and z.uomdetid = b.unitofissue)";
				$dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
				$this->pdf->sety($this->pdf->gety() + 5);
				foreach ($dataReader1 as $row1) {
					$awal		 = 0;
					$masuk	 = 0;
					$keluar	 = 0;
					$akhir	 = 0;
					$this->pdf->SetFont('Arial', 'BI', 9);
					$this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
					$this->pdf->text(45, $this->pdf->gety() + 7, ': '.$row1['divisi']);
					$this->pdf->text(80, $this->pdf->gety() + 7, '');
					$this->pdf->text(165, $this->pdf->gety() + 7, ''.$row['sloccode']);

					$this->pdf->sety($this->pdf->gety() + 8);
					$sql3											 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,keluar2
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,(jual+returbeli+trfout+pemakaian+konversiout) as keluar2
                            from
                            (select
                            (
                            select distinct b.productname
                            from productstockdet a
														join product b on b.productid = a.productdetid
                            where a.productdetid = t.productid and
                            a.uomdetid = t.unitofissue
														limit 1
                            ) as barang,
                            (
                            select distinct zb.uomcode
                            from productstockdet b
														join unitofmeasure zb on zb.unitofmeasureid = b.uomdetid
                            where b.productdetid = t.productid and
                            b.uomdetid = t.unitofissue
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qtydet),0)
                            from productstockdet aw
                            where aw.productdetid = t.productid and
                            aw.transdate < '".Yii::app()->format->formatDateSQL($startdate)."' and
                            aw.slocdetid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qtydet),0)
                            from productstockdet c
                            where c.productdetid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocdetid = t.slocid and
                            c.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as beli,
                            (
                            select ifnull(sum(d.qtydet),0)
                            from productstockdet d
                            where d.productdetid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocdetid = t.slocid and
                            d.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qtydet),0)
                            from productstockdet e
                            where e.productdetid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qtydet > 0 and
                            e.slocdetid = t.slocid and
                            e.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qtydet),0)
                            from productstockdet f
                            where f.productdetid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qtydet > 0 and
                            f.slocdetid = t.slocid and
                            f.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qtydet),0)
                            from productstockdet g
                            where g.productdetid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocdetid = t.slocid and
                            g.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as jual,
                            (
                            select ifnull(sum(h.qtydet),0)
                            from productstockdet h
                            where h.productdetid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocdetid = t.slocid and
                            h.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qtydet),0)
                            from productstockdet i
                            where i.productdetid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qtydet < 0 and
                            i.slocdetid = t.slocid and
                            i.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qtydet),0)
                            from productstockdet j
                            where j.productdetid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qtydet < 0 and
                            j.slocdetid = t.slocid and
                            j.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qtydet),0)
                            from productstockdet k
                            where k.productdetid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocdetid = t.slocid and
                            k.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as koreksi,
							(select ifnull(sum(l.qtydet),0)
                            from productstockdet l
                            where l.productdetid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qtydet > 0 and
                            l.slocdetid = t.slocid
							and l.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qtydet),0)
                            from productstockdet m
                            where m.productdetid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qtydet < 0 and
                            m.slocdetid = t.slocid and
                            m.transdate between '".Yii::app()->format->formatDateSQL($startdate)."'
                            and '".Yii::app()->format->formatDateSQL($enddate)."'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where u.materialgroupid = '".$row1['materialgroupid']."'
							and v.slocid = '".$row['slocid']."') z) zz )zzz
							where (awal <> 0 or masuk <> 0  or akhir <> 0 or keluar <> 0) and keluar2 < - ".$keluar3;
							if ($product !== '') { 
							$sql3 .= " t.productid = ".$product; 
							} $sql3 .= " order by keluar2 asc";
					$this->pdf->sety($this->pdf->gety());
					$this->pdf->coldetailalign = array(
						'L',
						'C',
						'R',
						'R',
						'R',
						'R'
					);
					$this->pdf->setFont('Arial', '', 8);
					$dataReader3							 = Yii::app()->db->createCommand($sql3)->queryAll();
					foreach ($dataReader3 as $row3) {
						$this->pdf->row(array(
							$row3['barang'],
							$row3['satuan'],
							Yii::app()->format->formatNumber($row3['awal']),
							Yii::app()->format->formatNumber($row3['masuk']),
							Yii::app()->format->formatNumber($row3['keluar']),
							Yii::app()->format->formatNumber($row3['akhir'])
						));
						$awal		 += $row3['awal'];
						$masuk	 += $row3['masuk'];
						$keluar	 += $row3['keluar'];
						$akhir	 += $row3['akhir'];
					}
					$this->pdf->SetFont('Arial', 'BI', 8);
					$this->pdf->row(array(
						'JUMLAH '.$row1['divisi'],
						'',
						Yii::app()->format->formatNumber($awal),
						Yii::app()->format->formatNumber($masuk),
						Yii::app()->format->formatNumber($keluar),
						Yii::app()->format->formatNumber($akhir)
					));
					$awal1	 += $awal;
					$masuk1	 += $masuk;
					$keluar1 += $keluar;
					$akhir1	 += $akhir;
				}
				$this->pdf->row(array(
					'TOTAL '.$row['sloccode'],
					'',
					Yii::app()->format->formatNumber($awal1),
					Yii::app()->format->formatNumber($masuk1),
					Yii::app()->format->formatNumber($keluar1),
					Yii::app()->format->formatNumber($akhir1)
				));
				$awal2	 += $awal1;
				$masuk2	 += $masuk1;
				$keluar2 += $keluar1;
				$akhir2	 += $akhir1;
			}
			$this->pdf->sety($this->pdf->gety() + 5);
			$this->pdf->SetFont('Arial', 'BI', 9);
			$this->pdf->row(array(
				'GRAND TOTAL',
				'',
				Yii::app()->format->formatNumber($awal2),
				Yii::app()->format->formatNumber($masuk2),
				Yii::app()->format->formatNumber($keluar2),
				Yii::app()->format->formatNumber($akhir2)
			));
		}
		$this->pdf->Output();
	}
}