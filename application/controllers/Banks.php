<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banks extends CI_Controller {

	
	public function __construct() {
		parent::__construct();
		if(!isset($_SESSION) || empty($_SESSION) || $_SESSION['user_type']!='Employee'){
				redirect('Welcome/logout');
		}
        
        // Load URL helper
		$this->load->library('session');
        $this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('Bank_model');
		$this->load->library('user_agent');
		$this->load->library('form_validation');
		$this->load->database();
    }

	public function index()
	{
		
		$GetNotices = $this->Bank_model->GetData('mst_banks','','','id DESC'); 
		$data = array(
			'page_title' => 'Manage Banks',
			'heading'=>'Manage Banks',
			'button' => 'Create',
			'button_action' => site_url('Banks/create'),
			'GetNotices' => $GetNotices,
		);
		$this->load->view('banks/index',$data);
	}
	public function create(){
		// print_r('hi');exit;
		$data = array(
			// 'allcities' => '',
			'id'=>"",
			'page_title' => 'Create Bank',
			'heading' => 'Create Bank',
			'screen' => 'Create Bank',
			'action' => site_url('Banks/create_action'),
			'button' => 'Create',
			'cancel' => 'Cancel',
			'cancel_action' => site_url('Banks'),
			'name' =>  set_value('name', $this->input->post('name', TRUE)),
			'branch_name' =>  set_value('branch_name', $this->input->post('branch_name', TRUE)),
			'ifsc_code' =>  set_value('ifsc_code', $this->input->post('ifsc_code', TRUE)),
			'status' =>  set_value('status', $this->input->post('status', TRUE)),
			
		);
    	$this->load->view('banks/form',$data);
	}
	public function create_action(){
            	// print_r($_POST);exit;
		if (isset($_POST) && !empty($_POST)) {
			$this->validate();
			if ($this->form_validation->run() == FALSE) {
				$this->create();
			} 
			else{
					$data = array(
						 'edit_id' => md5('Bank-token' . time() . rand(1000, 9999)),
						'name' => ucwords($this->input->post('name', TRUE)),
						// 'branch_name' => ucwords($this->input->post('branch_name', TRUE)),
						'ifsc_code' => $this->input->post('ifsc_code', TRUE),
						'status' => $this->input->post('status', TRUE)
					);
				
					// print_r($data);exit;
					$this->Bank_model->SaveData('mst_banks', $data);
					$this->session->set_flashdata('success', 'Bank has been created successfully');
					redirect('Banks');
					
				}
					// $guest_id = $this->db->insert_id();
				
		     }
		}
		public function update($id) {
			// Retrieve user data by ID to populate the form
			// $user = $this->Bank_model->getUserById($id);
			$getsingleguests = $this->Bank_model->GetData("mst_banks", "", "edit_id ='" .$id . "'", "", "", "", "single");
		
			// Check if the user exists
			if (!empty($getsingleguests)) {
				// Prepare the data to send to the view
				$data = array(
					'page_title' => 'Update Bank',
					'heading' => 'Update Bank',
					'screen' => 'Update Bank',
					'action' => site_url('Banks/update_action/'.$id),
					'button' => 'Update',
					'cancel' => 'Cancel',
					'cancel_action' => site_url('Banks'),
					'name' => set_value('name', $getsingleguests->name), // Pre-fill form with current data
					// 'branch_name' => set_value('branch_name', $getsingleguests->branch_name),
					'ifsc_code'=>set_value('ifsc_code', $getsingleguests->ifsc_code),
					'status' => set_value('status', $getsingleguests->status)
				);
		
				// Load the form view
				$this->load->view('banks/form', $data);
			} else {
				// print_r('hii');exit;
				// If user not found, show error message
				$this->session->set_flashdata('error', 'Bank not found');
				redirect('Banks');
			}
		}
		
		public function update_action($id) {
			
			if (isset($_POST) && !empty($_POST)) {
				$this->validate($id);
				if ($this->form_validation->run() == FALSE) {
					$this->update($id);
				} else {
					
					$data = array(
						// 'token' => md5('Guests-token' . time() . rand(1000, 9999)),
						'name' => ucwords($this->input->post('name', TRUE)),
						// 'branch_name' => ucwords($this->input->post('branch_name', TRUE)),
						'ifsc_code' => $this->input->post('ifsc_code', TRUE),
						'status' => $this->input->post('status', TRUE)
					);
				
					// print_r($data);exit;
					$this->Bank_model->SaveData('mst_banks', $data,'edit_id="'.$id.'"');
					$this->session->set_flashdata('success', 'Bank has been updated successfully');
					redirect('Banks');
				}
			}
		}
		
		public function delete_action($id)
	    {
		// Fetch attachment from table against id/token
		$getuser = $this->Bank_model->GetData("mst_banks","id","edit_id='".$id."'","","","","1");
		    //    $photo = $getuser->photo;
		//If record found or not
		if(empty($getuser))
		{
			$this->session->set_flashdata('error','Bank not found');
			redirect('Banks');
		}
		else
		{
				//Remove record from table
				$this->Bank_model->DeleteData("mst_banks","id ='".$getuser->id."'");
				$this->session->set_flashdata('success','Bank record has been deleted successfully');
				redirect('Banks');
		}
	}
	public function view_action($id ) {
		// print_r('hii');exit;
		$CustomersData = $this->Bank_model->GetData("mst_banks", "", "edit_id ='" . $id . "'");
		// print_r($CustomersData);exit;
		if (empty($CustomersData)) {
			redirect('Banks');
		} else {
			$data = array(
				'page_title' => 'View Bank',
				 'heading' => ' View Bank',
				'records' => 'Bank Details',
				'cancel' => 'Back',
				'cancel_action' => site_url('Banks'),
				'CustomersData' => $CustomersData
			);
		$this->load->view('banks/view',$data);

	}
}
	public function validate($id = '')
	{
		$getData = $this->Bank_model->GetData("mst_banks", "", "edit_id !='" .$id . "' and name='".$_POST['name']."'  and is_delete='No'", "", "", "", "single");
		$getIfscCode = $this->Bank_model->GetData("mst_banks", "", "edit_id !='" .$id . "' and ifsc_code='".$_POST['ifsc_code']."'  and is_delete='No' ", "", "", "", "single");
		$is_unique = '';
		$is_ifscode_unique = '';
		if(!empty($getData)){
			$is_unique = '|is_unique[mst_banks.name]';
		}
		if(!empty($getIfscCode)){
			$is_ifscode_unique ='|is_unique[mst_banks.ifsc_code]';
		}
		$this->form_validation->set_rules('name', 'Name', 'required|regex_match[/^[A-Za-z\'\-\/. ]+$/]'.$is_unique,array(
			'required'      => 'You have not provided %s.',
	  ));
		// $this->form_validation->set_rules('branch_name', 'Branch Name', 'required'.$is_unique,array(
		// 	  'required'      => 'You have not provided %s.',
        //         'is_unique'     => 'This %s already exists.'
		// ));
		$this->form_validation->set_rules('ifsc_code', 'Ifsc Code', 'required'.$is_ifscode_unique,array(
			'required'      => 'You have not provided %s.',
			  'is_unique'     => 'This %s already exists.'
	  ));
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
	}
	public function deleteall_action() {
		// Check if the delete action is triggered
		if ($this->input->post('deleteall')) {
			// Get the selected tokens
			$selector = $this->input->post('selector');  // This will be an array of selected token values
			
			if (!empty($selector)) {
				$del = 0;
				foreach ($selector as $token) {
					// Delete the customer record
					$this->Bank_model->DeleteData("mst_banks", array('edit_id' => $token));
	
					// Optionally delete related data (like photos, etc.)
					// if (!empty($customer->photo)) {
					//     unlink("uploads/guests_photo/" . $customer->photo);
					// }
	
					// Increment the delete counter
					$del++;
				}
	
				// Set a success message with the number of deleted records
				$message = "$del customer record(s) have been deleted successfully.";
				$this->session->set_flashdata('success', $message);
			} else {
				// If no checkboxes are selected, set an error message
				$this->session->set_flashdata('error', 'Check at least one record to delete.');
			}
			// Redirect back to the customers management page
			
		}else{
			$this->session->set_flashdata('error', 'Data not found');
		}
		redirect('Banks');
	}
}
?>