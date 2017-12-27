<?php
echo '
    <div class="row">
        <div class="col-xs-12 col-md-6 pull-left" style="margin-bottom:10px;">
            <a href="'.$link_create.'" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus"></span>
                <span class="sr-only">(Add)</span>
                &nbsp;Tambah Data
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