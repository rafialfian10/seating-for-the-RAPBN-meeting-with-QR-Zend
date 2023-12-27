<?php
class Sidang_DenahDudukController extends Zend_Controller_Action
{
	public function init() {
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user');
		$this->_helper->_acl->allow('user.akd');
		$this->_helper->_acl->allow('user.fraksi');
	}

	public function preDispatch() {
		$this->DenahTempatDudukService = new DenahTempatDudukService();
		$this->RestService = new RestService();
	}

	public function indexAction() {
		$this->view->rows = $this->DenahTempatDudukService->getAllData();
	}

	public function denahAction() {
		
	}

	public function addAction() {
		if ($this->getRequest()->isPost()) {
			$id_sidang = $this->getRequest()->getParam('id_sidang');
			$seat = $this->getRequest()->getParam('seat');
			$kode = $this->getRequest()->getParam('kode');
			$blok = $this->getRequest()->getParam('blok');
			$baris = $this->getRequest()->getParam('baris');
			$kursi = $this->getRequest()->getParam('kursi');
			$id_anggota = $this->getRequest()->getParam('id_anggota');
			$nama_anggota = $this->getRequest()->getParam('nama_anggota');
			$no_anggota = $this->getRequest()->getParam('no_anggota');
			$fraksi_anggota = $this->getRequest()->getParam('fraksi_anggota');
			$lembaga = $this->getRequest()->getParam('lembaga');
			$undangan = $this->getRequest()->getParam('undangan');

			$id = $this->DenahTempatDudukService->addData($id_sidang, $seat, $kode, $blok, $baris, $kursi, $id_anggota, $nama_anggota, $no_anggota, $fraksi_anggota, $lembaga, $undangan);

			$this->_redirect('/sidang/denah-duduk/edit/id/' . $id);
		}
	}

	public function editAction(){
		$id = $this->getRequest()->getParam('id');

		if ($this->getRequest()->isPost()) {
			$id_sidang = $this->getRequest()->getParam('id_sidang');
			$seat = $this->getRequest()->getParam('seat');
			$kode = $this->getRequest()->getParam('kode');
			$blok = $this->getRequest()->getParam('blok');
			$baris = $this->getRequest()->getParam('baris');
			$kursi = $this->getRequest()->getParam('kursi');
			$id_anggota = $this->getRequest()->getParam('id_anggota');
			$nama_anggota = $this->getRequest()->getParam('nama_anggota');
			$no_anggota = $this->getRequest()->getParam('no_anggota');
			$fraksi_anggota = $this->getRequest()->getParam('fraksi_anggota');
			$lembaga = $this->getRequest()->getParam('lembaga');
			$undangan = $this->getRequest()->getParam('undangan');
			
			$this->DenahTempatDudukService->editData($id, $id_sidang, $seat, $kode, $blok, $baris, $kursi, $id_anggota, $nama_anggota, $no_anggota, $fraksi_anggota, $lembaga, $undangan);
			
			// $this->_redirect('/admin/denah-duduk/edit/id/' . $id);
			$this->_redirect('/sidang/denah-duduk/');
		}
		else{
			$this->view->row = $this->DenahTempatDudukService->getData($id);
		}
	}

	public function deleteAction() {
		$id = $this->getRequest()->getParam('id');
		$this->DenahTempatDudukService->softDeleteData($id);

		$this->_redirect('/sidang/denah-duduk/index');
	}

	public function searchAnggotaAction() {
		$this->_helper->getHelper('layout')->disableLayout();

		$indeks = $this->getRequest()->getParam('indeks');
		$this->view->indeks = $indeks;
		$this->view->rows = $this->RestService->getAllData('anggota');
	}

	public function getBarisAction() {
		$this->_helper->getHelper('layout')->disableLayout();

		$blok = $this->getRequest()->getParam('blok');
		$this->view->rows = $this->DenahTempatDudukService->getBarisByBlok($blok);
	}

	public function getKursiAction() {
		$this->_helper->getHelper('layout')->disableLayout();

		$baris = $this->getRequest()->getParam('baris');
		$this->view->rows = $this->DenahTempatDudukService->getKursiByBaris($baris);
	}

	public function undanganAction() {
		$id = $this->getRequest()->getParam('id');
		$this->view->undangan = $this->DenahTempatDudukService->getData($id);
		
	}

		// public function cobaAction() {
			// 	$this->_helper->getHelper('layout')->disableLayout();
			// 	$this->_helper->viewRenderer->setNoRender();

			// 	$rows = $this->DenahTempatDudukService->getAllData();

			// 	foreach($rows as $row)
			// 	{
			// 		$seat[$row->kode] = $row->no_anggota;
			// 		// echo $row->kode . ' ' . $row->no_anggota . '<br>';
			// 	}

			// 	$this->_helper->getHelper('layout')->disableLayout();
			// 	$this->_helper->viewRenderer->setNoRender();

			// 	echo '<table border="1" dir="rtl">';

			// 	$f = array(null, 10,12,12,14,8,7,7,8,7,7,7,7,6,5,4,3);
			// 	for($baris=1; $baris<=16; $baris++)
			// 	{
			// 		for($kolom=$f[$baris]; $kolom>=1; $kolom--)
			// 		{
			// 			if ($kolom == $f[$baris])
			// 			{
			// 				echo '<tr>';
			// 			}
					
			// 			if ($baris < 13) {
			// 				$seatx = 'F . '  .  $baris . '.' . $kolom;
			// 				echo '<td>' . $seatx .  '</td>';
			// 			}
			// 			else
			// 				echo '<td align="center">E</td>';

			// 			if ($kolom == 1) 
			// 			{
			// 				echo '</tr>';
			// 			}		
			// 		}
			// 	}

			// 	echo '</table>';
		// }
	
		// public function insertAction() {		
			// 	$this->_helper->getHelper('layout')->disableLayout();
			// 	$this->_helper->viewRenderer->setNoRender();

			// 	$f = array(null, 10,12,12,14,8,7,7,8,7,7,7,7,6,5,4,3);
			// 	for($baris=1; $baris<=16; $baris++) {
			// 		for($kolom=$f[$baris]; $kolom>=1; $kolom--) {
			// 			if ($kolom == $f[$baris]) {
			// 				echo '<tr>';
			// 			}
						
			// 			if ($baris < 13)
			// 				echo '<td>' . $kolom . '</td>';
			// 			else
			// 				echo '<td align="center">E</td>';

			// 			if ($kolom == 1) {
			// 				echo '</tr>';
			// 			}		
			// 		}
			// 	}

			// 	$c1 = array(null, 6,7,8,8,8,9,9,9,9,10,10,10,11,9,11,11,9);
			// 	for($baris=1; $baris<=17; $baris++)
			// 	{
			// 		for($kolom=$c1[$baris]; $kolom>=1; $kolom--)
			// 		{
			// 			if ($kolom == $c1[$baris])
			// 			{
			// 				echo '<tr>';
			// 			}
						
			// 			if ($baris < 15)
			// 				echo '<td>' . $kolom . '</td>';
			// 			else
			// 				echo '<td align="center">E</td>';

			// 			if ($kolom == 1) 
			// 			{
			// 				echo '</tr>';
			// 			}		
			// 		}
			// 	}

			// 	$c2 = array(null, 6,7,7,8,8,9,9,9,10,10,10,10,11,11,11,11,9);
			// 	for($baris=1; $baris<=17; $baris++)
			// 	{
			// 		for($kolom=$c2[$baris]; $kolom>=1; $kolom--)
			// 		{
			// 			if ($kolom == $c2[$baris])
			// 			{
			// 				echo '<tr>';
			// 			}
						
			// 			if ($baris < 15)
			// 				echo '<td>' . $kolom . '</td>';
			// 			else
			// 				echo '<td align="center">E</td>';

			// 			if ($kolom == 1) 
			// 			{
			// 				echo '</tr>';
			// 			}		
			// 		}
			// 	}

			// 	$c3 = array(null, 6,7,8,8,8,9,9,9,10,10,10,10,11,10,11,12,9);
			// 	for($baris=1; $baris<=17; $baris++)
			// 	{
			// 		for($kolom=1; $kolom<=$c3[$baris]; $kolom++)
			// 		{
			// 			if ($kolom == 1)
			// 			{
			// 				echo '<tr>';
			// 			}
						
			// 			if ($baris < 15)
			// 				echo '<td>' . $kolom . '</td>';
			// 			else
			// 				echo '<td align="center">E</td>';

			// 			if ($kolom == $c3[$baris]) 
			// 			{
			// 				echo '</tr>';
			// 			}		
			// 		}
			// 	}

			// 	$c4 = array(null, 6,7,8,8,8,8,9,9,10,10,9,11,10,8,11,11,9);
			// 	for($baris=1; $baris<=17; $baris++)
			// 	{
			// 		for($kolom=1; $kolom<=$c4[$baris]; $kolom++)
			// 		{
			// 			if ($kolom == 1)
			// 			{
			// 				echo '<tr>';
			// 			}
						
			// 			if ($baris < 15)
			// 				echo '<td>' . $kolom . '</td>';
			// 			else
			// 				echo '<td align="center">E</td>';

			// 			if ($kolom == $c4[$baris]) 
			// 			{
			// 				echo '</tr>';
			// 			}		
			// 		}
			// 	}

			// 	$d = array(null, 9,12,13,14,7,8,8,7,7,7,5,5,7,5,4,3);
			// 	for($baris=1; $baris<=16; $baris++)
			// 	{
			// 		for($kolom=1; $kolom<=$d[$baris]; $kolom++)
			// 		{
			// 			if ($kolom == 1)
			// 			{
			// 				echo '<tr>';
			// 			}
						
			// 			if ($baris < 15)
			// 				echo '<td>' . $kolom . '</td>';
			// 			else
			// 				echo '<td align="center">E</td>';

			// 			if ($kolom == $d[$baris]) 
			// 			{
			// 				echo '</tr>';
			// 			}		
			// 		}
			// 	}
		// }
}
