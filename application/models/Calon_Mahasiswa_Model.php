<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calon_Mahasiswa_Model extends MY_Model {
	protected $_tabel 		= 'calon_mahasiswa';
	protected $_offset 		= 0;
	protected $_per_page 	= 10;

	public function get_tanggal_sekarang(){
		date_default_timezone_set('Asia/Makassar');
		return date('Y-m-d H:i:s');
	}

	public function get_last_id(){
		//parameter
		date_default_timezone_set('Asia/Makassar');
		$prefix	  = '00000000';
		$year_now = date('Y');
		$etc 	  = 'CMHS';
		$bind 	  = '-';

		//get_last_id
		$query = $this->db->query('CALL get_last_id()');
		$result = $query->result();

		//jika tahun berubah maka pake id ini
		if($year_now != $result[0]->tahun || $result==NULL){
			$new_id = '00000001'.$bind.$etc.$bind.$year_now;
			return $new_id;
		}


		$len = strlen($result[0]->urutan);
		$new_id = str_pad((int) $result[0]->urutan + 1, 8, 0, STR_PAD_LEFT).$bind.$etc.$bind.$result[0]->tahun;

		return $new_id;
	}

	public function get_agama(){
		$this->_tabel = 'agama';
		return $this->get();
	}

	public function get_semester(){
		$this->_tabel = 'semester';
		return $this->get();
	}

	public function get_negara(){
		$this->_tabel = 'negara';
		return $this->get();
	}

	public function get_provinsi(){
		$this->_tabel = 'provinsi';
		return $this->get();
	}
	
	public function get_kabupaten(){
		$this->_tabel = 'kabupaten';
		return $this->get();
	}

	public function get_kecamatan(){
		$this->_tabel = 'kecamatan';
		return $this->get();
	}

	public function get_jenis_tinggal(){
		$this->_tabel = 'jenis_tinggal';
		return $this->get();
	}

	public function get_with_search($order = array(), $attribute = array(), $offset = 0){
		$this->get_real_offset($offset);

		$kunci = $this->input->get('kata_kunci', TRUE);
		$kunci = strtolower($kunci);
		$statement = array();

		$k = 0;

		foreach($attribute as $value){
			if(strpos($kunci, 'laki') || strpos($kunci, 'perempuan')){
				$jenis = 0;
				if(strpos($kunci, 'perempuan')){
					$jenis = 1;
				}
				$statement[++$k] = '`'.'jenis_kelamin'.'` = '.$jenis;	
			} else {
				$statement[++$k] = '`'.$value.'` LIKE \'%'.$kunci.'%\'';
			}
		}
		$or_statement = implode(' OR ', $statement);

		$search = $this->db->where("(".$or_statement.")")
						   ->limit($this->_per_page, $this->_offset)
						   ->order_by($order['by'], $order['sort'])
						   ->get($this->_tabel)
						   ->result();

		return $search;
	}

	public function get_data_update($id){
		$biodata = 'biodata_calon_mahasiswa';
		$alamat = 'alamat_calon_mahasiswa';
		$this->db->select('*');
		$this->db->from($biodata);
		$this->db->join($alamat, 'biodata_calon_mahasiswa.no_reg = alamat_calon_mahasiswa.no_reg', 'left');
		$this->db->where(array('biodata_calon_mahasiswa.no_reg' => $id));
		$this->db->limit(1);

		return $this->db->get()->result();
	}

	public function create($data_biodata, $data_alamat){
		$this->_tabel = 'biodata_calon_mahasiswa';
		$insert_biodata = $this->db->insert($this->_tabel, $data_biodata);

		$this->_tabel = 'alamat_calon_mahasiswa';
		$insert_alamat = $this->db->insert($this->_tabel, $data_alamat);
		
		return ($insert_biodata && $insert_alamat);
	}

	public function edit($id, $data_biodata, $data_alamat, $limit = 1){
		//update data
		$this->_tabel = 'biodata_calon_mahasiswa';
		$update_biodata = $this->db->where($id)->limit($limit)->update($this->_tabel, $data_biodata);
		
		$this->_tabel = 'alamat_calon_mahasiswa';
		$update_alamat = $this->db->where($id)->limit($limit)->update($this->_tabel, $data_alamat);

		return ($update_biodata && $update_alamat);
	}

	public function del($id, $limit = 1){
		//delete data alamat calon mahasiswa
		$this->_tabel = 'alamat_calon_mahasiswa';
		$this->db->where(array('no_reg' => $id));
		$this->db->limit($limit);
		$delete_alamat = $this->db->delete($this->_tabel);
		
		//delete data biodata calon mahasiswa
		$this->_tabel = 'biodata_calon_mahasiswa';
		$this->db->where(array('no_reg' => $id));
		$this->db->limit($limit);
		$delete_biodata = $this->db->delete($this->_tabel);

		//return data
		return ($delete_alamat && $delete_biodata);
	}

	public function ubah_status($id, $limit = 1){
		//pembuatan nim otomatis
		$tabel = 'biodata_calon_mahasiswa';
		$this->db->where(array('no_reg' => $id));
		$result = $this->db->get($tabel)->result();
		
		$angkatan = substr($result[0]->angkatan, -2);

		if(strlen($angkatan) == 1){
			$angkatan = '0'.$angkatan;
		}

		//get last nim
		$this->db->select(
			array(
				'MAX(SUBSTRING(nim, 9)*1) AS no_urut'
			)
		);
		$this->db->from('mahasiswa');
		$this->db->where('SUBSTRING(nim, 1, 2) = '.$angkatan, NULL, FALSE);
		$nim = $this->db->get()->row();

		$no = ($nim->no_urut+1 < 10) ? '0'.($nim->no_urut+1) : $nim->no_urut+1;
		$new_nim = $angkatan.'086050'.$no;

		//insert
		$tabel = 'mahasiswa';
		$data = array(
			'nim' => $new_nim,
			'no_reg' => $id,
			'lulus' => 1
		);
		

		//exit();
		return $this->db->insert($tabel, $data);
	}
}