<?php
$config = array(
	'Calon_Mahasiswa/create' => array(		
		array(
			'field' => 'nama_mhs',
			'label' => 'Nama Mahasiswa',
			'rules' => 'required'
		)
	),

	'Calon_Mahasiswa/update' => array(
		array(
			'field' => 'noreg',
			'label' => 'Nomor Registrasi',
			'rules' => 'required'
		),
		
		array(
			'field' => 'nama_mhs',
			'label' => 'Nama Mahasiswa',
			'rules' => 'required'
		)
	)
);