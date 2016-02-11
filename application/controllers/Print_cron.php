<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print_cron extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function send_order(){
		$this->load->helper('email');
		$bavish_id = 1;
		$repro_id = 2;
		$file_origin_data = array();
		$cont = array('Job Id','Printer Name','Title','ISBN','File Origin','Qtn','Size','B/W Pages','Color Pages',
						'Total Pages','Paper','Cover','Binding','Section Sewing','Dust Jacket','Lamination',
						'Poster','Shrink Wrapping','Special Instruction','Courier Mode','Due Date','To','Type Of Order','Shipping Name','Address 1','Address 2 / Landmark','City','State','Pincode','Phone');
		
		$printer_info_arr = get_data('prp_printer',array('deleted'=>'0'))->result_array();
		$query = $this->db->query('SELECT spec.*,assign.print_exp_date as due_date,assign.printer_id as printer_id,ord.*,ord.id as order_id,printer.name as printer_name FROM `prp_orders` as ord 
						  JOIN prp_assign_print as assign on assign.deleted = 0 and assign.order_id = ord.id
						  JOIN prp_printer as printer on printer.deleted = 0 AND printer.id = assign.printer_id
						  JOIN inventory.book_spec as spec ON spec.deleted = 0 AND spec.book_id = ord.book_id
						  WHERE ord.deleted = 0 AND ord.order_stage = 2');
		if($query->num_rows()){
			
			foreach($query->result() as $row){
				$file_origin_arr = get_data('prp_file_origin',array('deleted'=>'0','book_id'=>$row->book_id,'printer_id'=>$row->printer_id));
				if($file_origin_arr->num_rows()) {
					$file_origin_data[] =  $file_origin_arr->row()->id;
					$file_origin = $file_origin_arr->row()->file_origin;
				}
				else
				    $file_origin = "FTP";  
				$dust_jacket = $row->dust_jacket == 'Yes' ? 'Yes' : 'N/A';
				$to = $row->order_type == '2' ? 'Notion Press' : 'Author';
				$ship_to = $row->order_type == '2' ? 'Refill' : 'Author Copies';
			 	$shipping_addr = implode(',',array($row->shipping_name,$row->phone,$row->addr1,$row->addr2,$row->city,$row->state,$row->pincode));
				if($row->color_page == "")
				$total_page_count = $row->page_count + 0;
				else
				$total_page_count = $row->page_count + $row->color_page;
				//$total_page_count = $row->page_count + count(explode(',',$row->color_page));
				$courier_mode = $this->config->item('courier_mode');
				$printer_id[$row->printer_id][] =  array($row->order_id,$row->printer_name,$row->book_name,(int)$row->book_isbn,$file_origin,$row->no_of_copies,$row->width.'X'.$row->height,$row->page_count,$row->color_page,$total_page_count,$row->paper_gsm_type,$row->cover_type,
										$row->book_type,'N/A',$dust_jacket,$row->lamination,'N/A','Yes',$row->special_inst,$courier_mode[$row->courier_mode],$row->due_date,$to,$ship_to,$row->shipping_name,$row->addr1,$row->addr2,$row->city,$row->state,$row->pincode,$row->phone);	
				
				//update_data('prp_orders',array('order_stage'=>'3'),array('deleted'=>'0','order_stage'=>'2'));
				
			
				/*if($row->printer_id == $bavish_id){
					
					$printer_1[] = array($row->order_id,$row->name,$row->book_name,$row->book_isbn,'FTP',$row->no_of_copies,$row->width.'X'.$row->height,$row->page_count,$row->color_page,$total_page_count,$row->paper_gsm_type,$row->cover_type,
										$row->book_type,'N/A',$dust_jacket,$row->lamination,'N/A','Yes',$row->due_date,$to,$ship_to,$row->shipping_name,$row->addr1,$row->addr2,$row->city,$row->state,$row->pincode,$row->phone);	
				}
				elseif($row->printer_id == $repro_id){
					
					$printer_2[] = array($row->order_id,$row->name,$row->book_name,$row->book_isbn,'FTP',$row->no_of_copies,$row->width.'X'.$row->height,$row->page_count,$row->color_page,$total_page_count,$row->paper_gsm_type,$row->cover_type,
										$row->book_type,'N/A',$dust_jacket,$row->lamination,'N/A','Yes',$row->due_date,$to,$ship_to,$row->shipping_name,$row->addr1,$row->addr2,$row->city,$row->state,$row->pincode,$row->phone);
				}*/
				
			}
			
		}


		 $file_name_path =  FCPATH.'print_job_files/';	
		/* $result = get_data('prp_printer',array('deleted'=>0));*/
		if(sizeof($printer_id)){
			$template = 1;
			foreach($printer_info_arr as $printer_row){
		 		$printer = $printer_id[$printer_row['id']];
		 			if(sizeof($printer)){

						$filename = $file_name_path.date('Ymd').'_'.$printer_row['id'].'.xls';
						array_unshift($printer,$cont);
						$path = $this->downloadxlsx($printer,$filename);
						$subject = get_data('prp_email_template',array('id'=>$template))->row()->subject;
						$subject = str_replace(array("#PRINTERNAME#"),array($printer_row['name']),$subject).': '.date("d-m-Y H:i A");
						//$email_cont = get_data('prp_email_template',array('id'=>$template))->row()->subject.': '.date("d-m-Y H:i A");
						$email_response = sendEmail($printer_row['email2'],$template,$path,NULL,$subject);	
					}
			}	
			
		}
		if($email_response){
			foreach($file_origin_data as $key => $value){
				 update_data('prp_file_origin',array('file_origin'=>"Hard Disk"),array('id'=>$value));
			}
			$upd = update_data('prp_orders',array('order_stage'=>'3'),array('deleted'=>'0','order_stage'=>'2'));
			if($upd)
			redirect(site_url('orders/view_orders/3'));
		}
	}
	
	
function downloadxlsx($header,$file_name_path)
{

$this->load->library('PHPExcel');
/*$filename = date('Ymd').'.xlsx';
$file_name_path =  'C:/xampp/htdocs/prp/'.$filename;*/			
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
		    ->setCreator("Notionpress Publishing Solutions")
		    ->setLastModifiedBy("Notionpress Publishing Solutions")
		    ->setSubject("PRIS/EPZ Orders");
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$styleArray = array(
    'font' => array(
        'bold' => true
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
 'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => '00000000'),
        ),
    ),
);

$objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()
    ->getStyle('D1')
    ->getNumberFormat()
    ->setFormatCode(
        PHPExcel_Style_NumberFormat::FORMAT_GENERAL
    );
$objPHPExcel->getActiveSheet()->fromArray($header, NULL, 'A1');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save(str_replace(__FILE__,$file_name_path,__FILE__));

$objPHPExcel->disconnectWorksheets();
unset($objPHPExcel);
return  $file_name_path;

//return $file_name_path;
	}

}
