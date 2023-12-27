<?php
	class Sidang_IndexController extends Zend_Controller_Action {
		public function init() {  
			$this->_helper->_acl->allow();
		}
		
		public function preDispatch() {
			$this->DenahTempatDudukService = new DenahTempatDudukService();
		}

		public function indexAction() {
			$this->_helper->getHelper('layout')->disableLayout();
			$data = $this->DenahTempatDudukService->getAllData();
			$this->view->rows = $data;

			$this->view->baseUrl = 'https://belajar.dpr.go.id/sidang';
		}

		public function seatAction() {
			$no_anggota = $this->getRequest()->getParam('no-anggota');
			$sesi = $this->getRequest()->getParam('sesi');
			if ($no_anggota != "" && $sesi != "") {
				$this->searchSeat($no_anggota, $sesi);
			} 

			$this->_helper->getHelper('layout')->disableLayout();
			$data = $this->DenahTempatDudukService->getAllData();
			$this->view->rows = $data;

			$this->view->baseUrl = 'https://belajar.dpr.go.id/sidang';

			// Tambahkan script untuk menampilkan sesi yang sesuai saat URL langsung diakses
			if($sesi == 1) {
				echo "<script>
					document.addEventListener('DOMContentLoaded', function() {
						
						let defaultSesiSection1 = document.getElementById('sesi-1');

						if (defaultSesiSection1) {
							let sesiButtons = document.querySelectorAll('.btn-sesi');
							sesiButtons.forEach(function(button) {
								button.classList.remove('active');
							});
							sesiButtons[0].classList.add('active');

							let allSesiSections = document.querySelectorAll('.sesi');
							allSesiSections.forEach(function(section) {
								section.style.display = 'none';
							});
							defaultSesiSection1.style.display = 'block';
						} 
					});
				</script>";
			} else if($sesi == 2) {
				echo "<script>
					document.addEventListener('DOMContentLoaded', function() {
						
						let defaultSesiSection2 = document.getElementById('sesi-2');

						if (defaultSesiSection2) {
							let sesiButtons = document.querySelectorAll('.btn-sesi');
							sesiButtons.forEach(function(button) {
								button.classList.remove('active');
							});
							sesiButtons[0].classList.add('active');

							let allSesiSections = document.querySelectorAll('.sesi');
							allSesiSections.forEach(function(section) {
								section.style.display = 'none';
							});
							defaultSesiSection2.style.display = 'block';
						} 
					});
				</script>";
			}
		}

		public function searchSeat($no_anggota, $sesi) {
			$baseUrl = 'https://belajar.dpr.go.id/sidang';
			$no_anggota = strtolower(trim($no_anggota));

			echo "<script>
					let allSeat = document.querySelectorAll('.blok-f, .blok-c1, .blok-c2, .blok-c3, .blok-c4, .blok-d');
					let seatFound = false;
					let errorMessageDisplay = false;
				
					allSeat.forEach(function(seat) {
						let seatNumbers = seat.querySelectorAll('.seat-number p');
						let showSeat = false;

						seatNumbers.forEach(function(seatNumber) {
							let seatNumberAnggota = seatNumber.textContent.trim().toLowerCase();

							if (seatNumberAnggota === '" . $no_anggota . "') {
								showSeat = true;
								seatFound = true;
								seatNumber.classList.add('highlighted', 'text-light', 'rounded-2');
							} else {
								seatNumber.classList.remove('highlighted', 'text-light');
							}
						});

						if (showSeat) {
							seat.style.display = 'block';
						} else {
							seat.style.display = 'none';
							let errorMessage = document.querySelector('.error-message');
							if (errorMessage) {
								errorMessage.remove();
								errorMessageDisplay = false;
							}
						}
					});

					if (!seatFound && !errorMessageDisplay) {
						let errorMessage = document.createElement('p');
						errorMessage.classList.add('error-message', 'fs-5', 'text-center', 'text-danger', 'fst-italic');
						errorMessage.style.paddingTop = '230px';
						errorMessage.innerHTML = 'Seat not found';
						document.body.appendChild(errorMessage);
						errorMessageDisplayed = true;
					};

					let seatSesis = document.querySelectorAll('.sesi');
					seatSesis.forEach(function(sesi) {
						let computedStyle = window.getComputedStyle(sesi);
						if (computedStyle.display === 'block') {
							let seatNumberSesi = sesi.querySelector('.seat-number span').textContent.trim().toLowerCase();
							let newUrl = '". $baseUrl ."' + '/index/seat/no-anggota/' + '" . $no_anggota . "' + '/sesi/' + '" . $sesi . "';
							history.pushState(null, null, newUrl);
						}
					});
			</script>";
		}

		public function undanganAction() {
			$this->_helper->getHelper('layout')->disableLayout();

			$id = $this->getRequest()->getParam('no-anggota');
			$this->view->undangan = $this->DenahTempatDudukService->getData($id);
		}

		public function fileUndanganAction() {
			$this->_helper->getHelper('layout')->disableLayout();

			$id = $this->getRequest()->getParam('no-anggota');
			$this->view->undangan = $this->DenahTempatDudukService->getData($id);
		}
	}
?>