<?php
$tbody = '';
foreach($data_calon_mahasiswa as $data){
    $id = $data->no_reg;

    $link_update = '
        <a href="'.site_url('Calon_Mahasiswa/update/'.$id).'" class="btn btn-success" title="Update Data ID : '.$id.'">
        <span class="glyphicon glyphicon-edit"></span>
        <span class="sr-only">Update</span>
        </a>
    ';
    $link_delete = '
        <a href="'.site_url('Mahasiswa_Lolos/delete/'.$data->nim).'" class="btn btn-danger" data-confirm="Apakah anda yakin rollback menjadi calon mahasiswa, data NIM : '.$data->nim.' ?"  title="Rollback Data NIM : '.$data->nim.'">
        <span class="glyphicon glyphicon-share-alt"></span>
        <span class="sr-only">Delete</span>
        </a>
    ';
    $jenis_kelamin = ($data->jenis_kelamin == 0) ? 'Laki - Laki' : 'Perempuan';
    $tbody .= '
        <tr>
            <td align="center">'.$link_update.'</td>
            <td align="center">'.$link_delete.'</td>
            <td>'.++$offset_number.'</td>
            <td>'.$data->nim.'</td>
            <td>'.$data->nama_mahasiswa.'</td>
            <td>'.$data->tgl_reg.'</td>
            <td>'.$jenis_kelamin.'</td>
            <td>'.$data->asal_sma.'</td>
            <td>'.$data->angkatan.'</td>
            <td>'.$data->alamat.'</td>
            <td>'.$data->no_telp.'</td>
            <td>'.$data->email.'</td>
        </tr>
    ';
}
$search_view = '
    <div class="row">
        <div class="col-xs-12 col-md-6 pull-left" style="margin-bottom:10px;">
            <a href="'.$link_export.'" class="btn btn-primary">
                <span class="glyphicon glyphicon-th-list"></span>
                <span class="sr-only">(Export)</span>
                &nbsp;Export to Spreadsheet
            </a>
        </div>
    
        <div class="col-xs-12 col-md-6 pull-right form-pencarian">
            <form role="form" action="'.$link_search.'" method="GET" class="form-horizontal form-search">
                <div class="input-group">
                    <input type="text" name="kata_kunci" class="form-control" placeholder="Search Data" id="kata_kunci" value="'.$this->input->get('kata_kunci').'" required="required" />
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <i class="glyphicon glyphicon-search"></i>
                            <span class="sr-only">(Search)</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
';

echo '
    <div class="box box-primary">
        <div class="box-header with-border">
            '.$search_view.'
        </div>
        <div class="box-body">
            <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th colspan="2">Opsi</th>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Tgl. Registrasi</th>
                <th>Jenis Kelamin</th>
                <th>Asal SMA</th>
                <th>Angkatan</th>
                <th>Alamat</th>
                <th>No. Telp</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
                '.$tbody.'
            </tbody>
            </table>
            </div>
            '.$link_paging.'
        </div>
    </div>
';
