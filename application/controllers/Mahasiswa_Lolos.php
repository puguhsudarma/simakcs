<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_Lolos extends Admin_Controller {
	protected $_model 	 = 'Mahasiswa_Model';
	protected $_nama_model = 'mahasiswa';
	protected $phpexcel = NULL;
	
	public function __construct(){
		parent::__construct();
		$this->_data['content'] = 'mahasiswa/mahasiswa_view';
		$this->_data['content_header'] = 'Data Mahasiswa';
	}

	public function index($offset = 0){
		//var for view
		$this->_data['description'] = 'Tabel Data Mahasiswa';
		$this->_data['page'] = 'read';
		$this->_data['link_search'] = site_url('Mahasiswa_Lolos/search/');
		$this->_data['link_export'] = site_url('Mahasiswa_Lolos/excel');
		$this->_data['link_paging'] = $this->mahasiswa->paging('Mahasiswa_Lolos/index', 3);
		if($offset == 0){
			$this->_data['offset_number'] = 0;
		} else {
			$this->_data['offset_number'] = $this->mahasiswa->offset_number($offset);
		}
		
		//get data
		if($data = $this->mahasiswa->get_with_paging($offset)){
			$this->_data['data_calon_mahasiswa'] = $data;
		} else {
			$this->_data['data_calon_mahasiswa'] = array();
		}

		//load view
		$this->load->view($this->_layout, $this->_data);
	}

	public function search($offset = 0){
		//var for view
		$this->_data['description'] = 'Pencarian Data Mahasiswa';
		$this->_data['page'] = 'read';
		$this->_data['link_search'] = site_url('Mahasiswa_Lolos/search/');
		$this->_data['link_create'] = site_url('Calon_Mahasiswa/read');
		$this->_data['link_back'] = site_url('Mahasiswa_Lolos');
		if($offset == 0){
			$this->_data['offset_number'] = 0;
		} else {
			$this->_data['offset_number'] = $this->mahasiswa->offset_number($offset);
		}
		
		//set parameter
		$collumn = array(
			'nim',
			'nama_mahasiswa',
			'tgl_reg',
			'jenis_kelamin',
			'asal_sma',
			'angkatan',
			'alamat',
			'no_telp',
			'email'
		);

		$order = array(
			'by'	=> 'nomor',
			'sort'	=> 'ASC'
		);

		//get data
		if($data = $this->mahasiswa->get_with_search($order, $collumn, $offset)){
			$this->_data['data_calon_mahasiswa'] = $data;
		} else {
			$this->_data['data_calon_mahasiswa'] = array();
		}

		//paging link
		$this->_data['link_paging'] = $this->mahasiswa->paging('Mahasiswa_Lolos/search', 3, 'pencarian', $collumn);
				
		//load view
		$this->load->view($this->_layout, $this->_data);	
	}

	public function delete($id){
		if(!$this->mahasiswa->get(array('nim' => $id), 1)){
			$this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan.');
			redirect('Mahasiswa_Lolos');
		}

		if($this->mahasiswa->del($id)){
			$this->session->set_flashdata('success', 'Data mahasiswa berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data mahasiswa gagal dihapus.');
		}

		redirect('Mahasiswa_Lolos');
	}

	public function excel(){
		//get data
		$data = $this->mahasiswa->get();

		//lets get started
		require_once(APPPATH.'/third_party/PHPExcel/PHPExcel.php');

		$this->phpexcel = new PHPExcel();
		$this->phpexcel->setActiveSheetIndex(0);
		$activeSheet = $this->phpexcel->getActiveSheet();

		//set style
		$style = array(
			'font' => array(
				'header' => array(
					'font' => array('bold' => TRUE, 'size'  => 20),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				),

				'header_tbody' => array(
					'font' => array('bold' => TRUE),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				)
			),

			'border' => array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			)
			
		);

		//set dimension width collumn
		$activeSheet->getColumnDimension('A')->setWidth(5);
		$activeSheet->getColumnDimension('B')->setWidth(14);
		$activeSheet->getColumnDimension('C')->setWidth(26);
		$activeSheet->getColumnDimension('D')->setWidth(18);
		$activeSheet->getColumnDimension('E')->setWidth(13);
		$activeSheet->getColumnDimension('F')->setWidth(26);
		$activeSheet->getColumnDimension('G')->setWidth(10);
		$activeSheet->getColumnDimension('H')->setWidth(22);
		$activeSheet->getColumnDimension('I')->setWidth(12);
		$activeSheet->getColumnDimension('J')->setWidth(31);

	//-Header Information
		$activeSheet->setCellValue('A1', 'Data Mahasiswa Lolos Seleksi');
		$activeSheet->mergeCells('A1:J1');
		$activeSheet->getStyle('A1')->applyFromArray($style['font']['header']);

	//-Header Data table	
		$activeSheet->setCellValue('A3', 'No.');
		$activeSheet->setCellValue('B3', 'NIM');
		$activeSheet->setCellValue('C3', 'Nama Mahasiswa');
		$activeSheet->setCellValue('D3', 'Tanggal Registrasi');
		$activeSheet->setCellValue('E3', 'Jenis Kelamin');
		$activeSheet->setCellValue('F3', 'Asal SMA');
		$activeSheet->setCellValue('G3', 'Angkatan');
		$activeSheet->setCellValue('H3', 'Alamat');
		$activeSheet->setCellValue('I3', 'No. Telp');
		$activeSheet->setCellValue('J3', 'Email');
		
		$activeSheet->getStyle('A3')->applyFromArray($style['font']['header_tbody']);
		$activeSheet->getStyle('B3')->applyFromArray($style['font']['header_tbody']);
		$activeSheet->getStyle('C3')->applyFromArray($style['font']['header_tbody']);
		$activeSheet->getStyle('D3')->applyFromArray($style['font']['header_tbody']);
		$activeSheet->getStyle('E3')->applyFromArray($style['font']['header_tbody']);
		$activeSheet->getStyle('F3')->applyFromArray($style['font']['header_tbody']);
		$activeSheet->getStyle('G3')->applyFromArray($style['font']['header_tbody']);
		$activeSheet->getStyle('H3')->applyFromArray($style['font']['header_tbody']);
		$activeSheet->getStyle('I3')->applyFromArray($style['font']['header_tbody']);
		$activeSheet->getStyle('J3')->applyFromArray($style['font']['header_tbody']);

	//--Data Table
		$nomor = 1;
		$cell = 4;
		foreach($data as $row){
			$activeSheet->setCellValue('A'.$cell, $nomor);
			$activeSheet->setCellValue('B'.$cell, $row->nim);
			$activeSheet->setCellValue('C'.$cell, $row->nama_mahasiswa);
			$activeSheet->setCellValue('D'.$cell, $row->tgl_reg);
			$activeSheet->setCellValue('E'.$cell, $row->jenis_kelamin);
			$activeSheet->setCellValue('F'.$cell, $row->asal_sma);
			$activeSheet->setCellValue('G'.$cell, $row->angkatan);
			$activeSheet->setCellValue('H'.$cell, $row->alamat);
			$activeSheet->setCellValue('I'.$cell, $row->no_telp);
			$activeSheet->setCellValue('J'.$cell, $row->email);

			$cell++;
			$nomor++;
		}
				
	//--Style Border Table
		$activeSheet->getStyle('A3:J'.($cell-1))->applyFromArray($style['border']);
		
	//--Output .xlsx extension
		$filename = 'Data_Mahasiswa_Lolos'.'_'.date('Y-m-d').'.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$filename);
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
		$objWriter->save('php://output');
		exit();
	}
}
