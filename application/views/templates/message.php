<?php 
if($this->session->flashdata('success_message')!="")
echo '<div class="alert alert-block alert-success fade in" style="width:100%;"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>'.$this->session->flashdata('success_message').'</div>';
else if($this->session->flashdata('error_message')!="")
echo '<div class="alert alert-danger" style="width:100%;"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>'.$this->session->flashdata('error_message').'</div>';

?>