<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function sendEmail($to,$template,$attachment = NULL,$contant = NULL,$subject = NULL) 
{    
		$CI =& get_instance();
		$email_cont = get_data('prp_email_template',array('id'=>$template))->row_array();
		if($subject == NULL)
		$subject = $email_cont['subject']; 
		if($contant == NULL)
		$contant=$email_cont['content'];
		if($to == NULL)
		$to=$email_cont['to'];
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = $CI->config->item("smtp_host");
		$config['smtp_user'] = $CI->config->item("smtp_user"); 
		$config['smtp_pass'] = $CI->config->item("smtp_pass");
		$config['smtp_port'] = 587;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['mailtype']="html";
		$frm = explode(',',$email_cont['email_from']);
		$CI->load->library('email', $config);
		$CI->email->clear(TRUE);
		$CI->email->set_newline("\r\n");
		
		$CI->email->from($frm[0],$frm[1]);
		if($email_cont['cc'] != "")
		$CI->email->cc("selva@notionpress.com");
		$CI->email->to("yeskayselva@gmail.com");
		$CI->email->subject($subject);
		$CI->email->message($contant);
		if( $attachment != NULL )
		$CI->email->attach($attachment,'inline');	
		return $result=$CI->email->send(); 
}

/*function sendEmail1($to,$template,$attachment = NULL,$contant = NULL) 
{    
		$CI =& get_instance();
		$email_cont = get_data('prp_email_template',array('id'=>$template))->row_array();
		$subject = $template == 1 ? $email_cont['subject']." : ".date("d-m-Y") : $email_cont['subject'];
		if($contant == NULL)
		$contant=$email_cont['content'];
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = $CI->config->item("smtp_host");
		$config['smtp_user'] = $CI->config->item("smtp_user"); 
		$config['smtp_pass'] = $CI->config->item("smtp_pass");
		$config['smtp_port'] = 587;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['mailtype']="html";
		$CI->load->library('email', $config);
		$CI->email->set_newline("\r\n");
		$CI->email->from("sandhya@notionpress.com","SANDHYA BALAKRISHNAN");
		$CI->email->to("sandhya@notionpress.com");
		$CI->email->subject("christma christ");
		$CI->email->message($contant);
		if( $attachment != NULL )
		$CI->email->attach($attachment,'inline');
		return $result=$CI->email->send(); 
}
*/

?>