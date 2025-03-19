<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notices extends CI_Controller {

	
	public function __construct() {
		parent::__construct();
		if(!isset($_SESSION) || empty($_SESSION) || $_SESSION['user_type']!='Employee'){
			redirect('Welcome/logout');
		}
        // Load URL helper
		$this->load->library('session');
        $this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('Notice_model');
		$this->load->library('user_agent');
		$this->load->library('form_validation');
		$this->load->database();
    }

	public function index()
	{
		
		$GetNotices = $this->Notice_model->GetData('notices','','','id DESC'); 
		$data = array(
			'page_title' => 'Manage-Notices ',
			'screen' => 'MANAGE Notice',
			'button' => 'Create',
			'button_action' => site_url('Notices/create'),
			'GetNotices' => $GetNotices,
		);
		$this->load->view('notices/index',$data);
	}
	public function create() {
		// Fetch all users who can receive notifications
		$all_users = $this->Notice_model->GetData("users", "", "");
	
		$data = array(
			'page_title' => 'Create - Notice',
			'heading' => 'Notice',
			'screen' => 'Create Notice',
			'action' => site_url('Notices/create_action'),
			'button' => 'Create',
			'cancel' => 'Cancel',
			'cancel_action' => site_url('Notices'),
			'name' => set_value('name'),
			'description' => set_value('description'),
			'status' => set_value('status'),
			'all_users' => $all_users,  // Pass users to the view
			'select_all' => 'All Users' // Add "All Users" as an option
		);
		$this->load->view('notices/form', $data);
	}
	
	
	public function create_action() {
		if (isset($_POST) && !empty($_POST)) {
			$this->validate();
			if ($this->form_validation->run() == FALSE) {
				$this->create();
			} else {
				// Get the selected user IDs from the form
				$user_ids = $this->input->post('user_ids', TRUE);
				
				// Check if 'All Users' is selected and update $user_ids accordingly
				if (in_array('All Users', $user_ids)) {
					$user_ids = array_map(function($user) { return $user->id; }, $this->Notice_model->GetData("users", "", ""));
				}
	
				if (!empty($user_ids)) {
					// Loop through each selected user and send a notification
					foreach ($user_ids as $user_id) {
						$data = array(
							'user_id' => $user_id, // Store the user ID
							'title' => ucwords($this->input->post('name', TRUE)),
							'description' => $this->input->post('description', TRUE),
							'notice_date' => date('Y-m-d'),
							'status' => $this->input->post('status', TRUE),
							'notice_seen' => 'Unseen', // Default status is 'Unseen'
						);
	
						// Save notification for each user
						$this->Notice_model->SaveData('notices', $data);
					}
					$this->session->set_flashdata('success', 'Notification(s) sent successfully');
					redirect('Notices');
				} else {
					$this->session->set_flashdata('error', 'No users selected for notification');
					redirect('Notices');
				}
			}
		}
	}
	
	
		public function update($id) {
			// Retrieve user data by ID to populate the form
			// $user = $this->Notice_model->getUserById($id);
			$getsingleguests = $this->Notice_model->GetData("notices", "", "id ='" .$id . "'", "", "", "", "single");
			$all_users = $this->Notice_model->GetData("users", "", "");
			// Check if the user exists
			if (!empty($getsingleguests)) {
				// Prepare the data to send to the view
				$data = array(
					'page_title' => 'Update - Manage Notice',
					'heading' => 'Bank Management',
					'screen' => 'Update',
					'action' => site_url('Notices/update_action/'.$id),
					'button' => 'Update',
					'cancel' => 'Cancel',
					'cancel_action' => site_url('Notices'),
					'name' => set_value('name', $getsingleguests->title), // Pre-fill form with current data
					'description' => set_value('description', $getsingleguests->description),
					'notice_date'=>set_value('notice_date', $getsingleguests->notice_date),
					'all_users'=>$all_users,
					'selected_users'=>$getsingleguests->user_id,
					'status' => set_value('status', $getsingleguests->status)
				);
		
				// Load the form view
				$this->load->view('notices/form', $data);
			} else {
				// print_r('hii');exit;
				// If user not found, show error message
				$this->session->set_flashdata('error', 'User not found');
				redirect('Notices');
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
						'user_id' => $this->session->userdata('id'),
						'title' => ucwords($this->input->post('name', TRUE)),
						'description' => $this->input->post('description', TRUE),
						'notice_date'=>date('Y-m-d'),
						'status' => $this->input->post('status', TRUE)
					);
				
					// print_r($data);exit;
					$this->Notice_model->SaveData('notices', $data,'id="'.$id.'"');
					$this->session->set_flashdata('success', 'Notice has been updated successfully');
					redirect('Notices');
				}
			}
		}
		
		public function delete_action($id)
	    {
		// Fetch attachment from table against id/token
		$getuser = $this->Notice_model->GetData("notices","id","id='".$id."'","","","","1");
		    //    $photo = $getuser->photo;
		//If record found or not
		if(empty($getuser))
		{
			redirect('Notices');
		}
		else
		{
				//Remove record from table
				$this->Notice_model->DeleteData("notices","id ='".$getuser->id."'");
				$this->session->set_flashdata('error','Notice record has been deleted successfully');
				redirect('Notices');
		}
	}
	public function deleteall_action() {
		// Check if the delete action is triggered
		if ($this->input->post('deleteall')) {
			// Get the selected tokens
			$selector = $this->input->post('selector');  // This will be an array of selected token values
			
			if (!empty($selector)) {
				$del = 0;
				foreach ($selector as $token) {
					// Fetch the customer data based on the token
					$customer = $this->Notice_model->GetData("customer_management", "id", array('token' => $token), "", "", "", "single");
	
					// Delete the customer record
					$this->Notice_model->DeleteData("customer_management", array('token' => $token));
	
					// Optionally delete related data (like photos, etc.)
					// if (!empty($customer->photo)) {
					//     unlink("uploads/guests_photo/" . $customer->photo);
					// }
	
					// Increment the delete counter
					$del++;
				}
	
				// Set a success message with the number of deleted records
				$message = "$del customer record(s) have been deleted successfully.";
				$this->session->set_flashdata('error', $message);
			} else {
				// If no checkboxes are selected, set an error message
				$this->session->set_flashdata('error', 'Check at least one record to delete.');
			}
			// Redirect back to the customers management page
			redirect('Notices');
		}
	}
	public function view_action($id ) {
		// print_r('hii');exit;
		$CustomersData = $this->Notice_model->GetData("customer_management", "", "id ='" . $id . "'");
		// print_r($CustomersData);exit;
		if (empty($CustomersData)) {
			redirect('Notices');
		} else {
			$data = array(
				'page_title' => 'View Customers',
				// 'heading' => ' Guestbook',
				'screen' => 'VIEW CUSTOMERS',
				'records' => 'Customers Detail',
				'cancel' => 'Back',
				'cancel_action' => site_url('Notices'),
				'CustomersData' => $CustomersData
			);
		$this->load->view('notices/view',$data);

	}
}
	public function validate($id = '')
	{
		if ($id != '') {
			// print_r('hi');exit;
			$this->form_validation->set_rules('name', 'Title', 'required|regex_match[/^[A-Za-z\'\-\/. ]+$/]');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
		} else {
			//Validation for create
			// print_r(hii);exit;
			$this->form_validation->set_rules('name', 'Title', 'required|regex_match[/^[A-Za-z\'\-\/. ]+$/]');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
		}
	}
}
?>