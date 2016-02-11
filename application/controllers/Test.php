<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.mandrillapp.com';
		$config['smtp_user'] = 'bhargava@sansrack.com';
		$config['smtp_pass'] = 'QS5tHGm6RHepb9krDfmF2A';
		$config['smtp_port'] = 587;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['mailtype']="html";
		$this->load->library('email');
		$this->email->initialize($config);

		$this->email->set_newline("\r\n");
		$this->email->clear();
		$this->email->from('editor@notionpress.com', 'Sansrack');
		$this->email->to('selva@notionpress.com'); 
		//$this->email->bcc('bhargava@notionpress.com'); 
		$this->email->subject('Test');
		//echo $message."<br><br><br>";
		$message="test";
		$this->email->message($message);
		$this->email->send();
	}
	/*function send_wishes(){
		$this->load->helper('email');
		$data['title'] = "";
		sendEmail1("selva@gmail.com",3);
		//$new = $this->load->view("email_template",$data);
	}*/
}
