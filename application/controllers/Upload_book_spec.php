<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_book_spec extends CI_Controller {

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
		$file = base_url("print_job_files/book_spec.csv");
	$this->db2 = $this->load->database('inventory',TRUE,FALSE);
/*
		while(! feof($file))
		  {
		  print_r(fgetcsv($file,'r'));
		  }

		fclose($file);*/
		/*  
		$csvData = file_get_contents($file);
		$lines = explode(PHP_EOL, $csvData);
		$array = array();
		
		foreach ($lines as $line) {
			echo $line;
			$array[] = fgetcsv($line, 0, ",");
		   //$array[] = str_getcsv($line);
		}
		var_dump($array);
		exit;*/
		$multidimentionarr = $this->csv_to_array($file);
		//print_r($this->db2->get_where("books_attributes",array('id'=>1100))->result());
		$i = 0;
		foreach($multidimentionarr as $key =>  $row){
			
			/*if($i!=0){
				
			}
			$i++;*/
			$row['book_id'] = $this->db2->get_where("books_attributes",array('bookid'=>$row['inventory_book_id'],'name'=>'book_npbook_tagdb'))->row()->value;
			$row['production_cost'] = $this->db2->get_where("books_attributes",array('bookid'=>$row['inventory_book_id'],'name'=>'book_prodcostdb'))->row()->value;
			$row['book_author'] = $this->db2->get_where("books",array('id'=>$row['inventory_book_id'],'deleted'=>'0'))->row()->author;
			$row['created_date'] = date("Y-m-d H:i:s"); 
			var_dump($row);
			$this->db->insert('book_spec',$row);
			/*if($key != 0){
				var_dump($row['0']);
				echo $row['book_id'] = $this->db2->get_where("books_attributes",array('bookid'=>$row->inventory_book_id,'name'=>'book_npbook_tagdb'))->row()->value;
			}*/
			/*exit;
			echo $row->inventory_book_id;
			exit;
			
			exit;*/
			/*inverntory_book_id
				book_author
				production_cost
				created_date
				updated_date*/
			//var_dump($row);
		
		
		}
	}
	function csv_to_array($file_name) {
		
        $data =  $header = array();
        $i = 0;
        $file = fopen($file_name, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            if( $i==0 ) {
                $header = $line;
            } else {
                $data[] = $line;      
            }
            $i++;
        }
        fclose($file);
        foreach ($data as $key => $_value) {
            $new_item = array();
            foreach ($_value as $key => $value) {
                $new_item[ $header[$key] ] =$value;
            }
            $_data[] = $new_item;
        }
        return $_data;
    }
	
	
}
