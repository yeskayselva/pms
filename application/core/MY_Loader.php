<?php
(defined('BASEPATH')) or exit('No direct script access allowed');

/* load the HMVC_Loader class */

/* 

if user want to change default file path ( header,footer path (template))
you can send data with file path name like

$data['template_path'] = 'login/template'

$this->load->template('dashboard',$data);

 */
require APPPATH . 'third_party/HMVC/Loader.php';

class MY_Loader extends HMVC_Loader {
	
	public function template($template_name, $vars = array(), $return = FALSE)
    {
        if($return){
			$content  = $this->view('templates/header', $vars, $return);
	        $content  = $this->view('templates/aside', $vars, $return);
	        $content .= $this->view($template_name, $vars, $return);
	        $content .= $this->view('templates/footer', $vars, $return);
	         return $content;
		}else if(isset($vars['template_path'])){
			$template_path = $vars['template_path'];
			$this->view($template_path, $vars);
	        $content  = $this->view($template_path, $vars, $return);
	        $this->view($template_name, $vars);
	        $this->view($template_path, $vars);
		}else{
			$this->view('templates/header', $vars);
	        $content  = $this->view('templates/aside', $vars, $return);
	        $this->view($template_name, $vars);
	        $this->view('templates/footer', $vars);
		}
    }
    
}