<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_Model extends MY_Model {
	protected $_tabel 		= 'data_mahasiswa';
	protected $_offset 		= 0;
	protected $_per_page 	= 10;

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

	public function del($id, $limit = 1){
		//delete data alamat calon mahasiswa
		$this->_tabel = 'mahasiswa';
		$this->db->where(array('nim' => $id));
		$this->db->limit($limit);
		
		return $this->db->delete($this->_tabel);
	}
}