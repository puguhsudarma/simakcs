<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $content_header; ?>
            <small><?php echo $description; ?></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php
            $this->load->view('messages_view');
            switch($page){
                case 'read'   : $this->load->view('admin/modul/mahasiswa/read');   break;
            }
        ?>
    </section>
</div>