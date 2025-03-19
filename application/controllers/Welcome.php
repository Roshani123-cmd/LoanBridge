<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Welcome extends CI_Controller {

	
	public function __construct() {
        parent::__construct();
        // Load URL helper
		$this->load->library('session');
        $this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->library('form_validation');
		$this->load->model('Users_model');
		$this->load->model('Profile_model');
    }

	public function index()
	{
		$this->load->database();
		$data = array(
			'action' => site_url('Welcome/login_action'),
			'login_button' => 'Login Now',
			
		); 
		$this->load->view('login',$data);
		
	}
	public function login_action()
	{
		
		$this->validate_login();
		if($this->form_validation->run() == FALSE)
		{

			$this->index();	
		}
		else
		{
			$email = $this->input->post("email_address",TRUE);
			$password = md5($this->input->post("password",TRUE));
			$checkemail = $this->Users_model->GetData("users","id,name,email_address,password,status,user_type,edit_id","email_address='".$email."' and is_delete='No'","","","","1");	
			if(empty($checkemail))
			{
				$this->session->set_flashdata('error','Invalid Credentials');
				redirect('Welcome/index');
			}
			else
			{
				$subject = 'OTP For Verfication';
				$otp = rand(1000,9999);
				$message='Hii '.ucfirst($checkemail->name).' . You have an otp <b>'.$otp.'</b> for 2 step verification .';
				$mail = $this->sendMail($email,$subject,$message);
				if($mail==0){
					$this->session->set_flashdata('error','Mail not send.Plese login again !');
					redirect('Welcome');
				}else{
					// print_r('hii');exit;
					$saveOTP = $this->Users_model->SaveData('users',array('temp_otp'=>$otp),'edit_id="'.$checkemail->edit_id.'"');
					$this->session->set_flashdata('success','Mail send successfully . Please check otp in mail');
					redirect('Welcome/otp/'.$checkemail->edit_id);
				}
				
			}
		}
	}
	public function manage_customers(){
		$GetCustomers = $this->Users_model->GetData('users','id,token,name,email_address,status,created','','created DESC'); 
		$data = array(
			'page_title' => 'Manage-Customers ',
			'screen' => 'MANAGE Customers',
			'button' => 'Create',
			'button_action' => site_url('Welcome/create'),
			'GetCustomers' => $GetCustomers,
		);
		$this->load->view('users/manage_customers',$data);
	}
	public function create(){
		// print_r('hi');exit;
		$data = array(
			// 'allcities' => '',
			'id'=>"",
			'page_title' => 'Create - Manage-Customers',
			'heading' => 'Guestbook',
			'screen' => 'Create Guest',
			'action' => site_url('Welcome/create_action'),
			'button' => 'Create',
			'cancel' => 'Cancel',
			'cancel_action' => site_url('Welcome/manage_customers'),
			'name' =>  set_value('name', $this->input->post('name', TRUE)),
			'email_address' =>  set_value('email_address', $this->input->post('email_address', TRUE)),
			'address' =>  set_value('address', $this->input->post('address', TRUE)),
			'dob' =>  set_value('dob', $this->input->post('dob', TRUE)),
			'gender' => set_value('gender', $this->input->post('gender', TRUE)),
			'status' =>  set_value('status', $this->input->post('status', TRUE)),
			// 'allGuestPhoto' => $allGuestPhoto,
			
		);
    	$this->load->view('users/form',$data);
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
						// 'token' => md5('Guests-token' . time() . rand(1000, 9999)),
						'user_id' => $this->session->userdata('id'),
						'name' => ucwords($this->input->post('name', TRUE)),
						'email_address' => strtolower($this->input->post('email_address', TRUE)),
						'address' => ucwords($this->input->post('address', TRUE)),
						'gender' => $this->input->post('gender', TRUE),
						'dob' => date('Y-m-d', strtotime($this->input->post('dob', TRUE))),
						'status' => $this->input->post('status', TRUE)
					);
				
					// print_r($data);exit;
					$this->Users_model->SaveData('users', $data);
					$this->session->set_flashdata('success', 'Guest has been created successfully');
					redirect('Welcome/manage_customers');
					
				}
					// $guest_id = $this->db->insert_id();
				
		     }
		}
		public function update($id) {
			// Retrieve user data by ID to populate the form
			// $user = $this->Users_model->getUserById($id);
			$getsingleguests = $this->Users_model->GetData("users", "", "id ='" .$id . "'", "", "", "", "single");
		
			// Check if the user exists
			if (!empty($getsingleguests)) {
				// Prepare the data to send to the view
				$data = array(
					'page_title' => 'Update - Manage Customers',
					'heading' => 'Bank Management',
					'screen' => 'Update',
					'action' => site_url('Welcome/update_action/'.$id),
					'button' => 'Update',
					'cancel' => 'Cancel',
					'cancel_action' => site_url('Welcome/manage_customers'),
					'name' => set_value('name', $getsingleguests->name), // Pre-fill form with current data
					'email_address' => set_value('email_address', $getsingleguests->email_address),
					'address' => set_value('address', $getsingleguests->address),
					'dob' => set_value('dob', $getsingleguests->dob),
					'gender' => set_value('gender', $getsingleguests->gender),
					'status' => set_value('status', $getsingleguests->status)
				);
		
				// Load the form view
				$this->load->view('users/form', $data);
			} else {
				// print_r('hii');exit;
				// If user not found, show error message
				$this->session->set_flashdata('error', 'User not found');
				redirect('Welcome/manage_customers');
			}
		}
		
		public function update_action($id) {
			if (isset($_POST) && !empty($_POST)) {
				$this->validate($id);
				if ($this->form_validation->run() == FALSE) {
					$this->update($id);
				} else {
					// Prepare the data to update
					$data = array(
						'user_id' => $this->session->userdata('id'),
						'name' => ucwords($this->input->post('name', TRUE)),
						'email_address' => strtolower($this->input->post('email_address', TRUE)),
						'address' => ucwords($this->input->post('address', TRUE)),
						'gender' => $this->input->post('gender', TRUE),
						'dob' => date('Y-m-d', strtotime($this->input->post('dob', TRUE))),
						'status' => $this->input->post('status', TRUE)
					);
					
					// Decode the ID (since it's coming as base64 in the URL or request)
					// $decoded_id = base64_decode($id);  // Corrected: decode the base64-encoded ID
		
					// Now perform the update query
					$this->Users_model->SaveData('users', $data, "id = $id");
					$this->session->set_flashdata('success', 'Guest has been updated successfully');
					redirect('Welcome/manage_customers');
				}
			}
		}
		
		public function delete_action($id)
	    {
		// Fetch attachment from table against id/token
		$getuser = $this->Users_model->GetData("users","id","id='".$id."'","","","","1");
		    //    $photo = $getuser->photo;
		//If record found or not
		if(empty($getuser))
		{
			redirect('Welcome/manage_customers');
		}
		else
		{
				//Remove record from table
				$this->Users_model->DeleteData("users","id ='".$getuser->id."'");
				$this->session->set_flashdata('error','User record has been deleted successfully');
				redirect('Welcome/manage_customers');
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
					$customer = $this->Users_model->GetData("users", "id", array('token' => $token), "", "", "", "single");
	
					// Delete the customer record
					$this->Users_model->DeleteData("users", array('token' => $token));
	
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
			redirect('Welcome/manage_customers');
		}
	}
	public function view_action($id ) {
		// print_r('hii');exit;
		$CustomersData = $this->Users_model->GetData("users", "", "id ='" . $id . "'");
		// print_r($CustomersData);exit;
		if (empty($CustomersData)) {
			redirect('Welcome/manage_customers');
		} else {
			$data = array(
				'page_title' => 'View Customers',
				// 'heading' => ' Guestbook',
				'screen' => 'VIEW CUSTOMERS',
				'records' => 'Customers Detail',
				'cancel' => 'Back',
				'cancel_action' => site_url('Welcome/manage_customers'),
				'CustomersData' => $CustomersData
			);
		$this->load->view('users/view',$data);

	}
}
public function forgot_password()
	{
		// after submit button get clicked
		$data = array(
			'login_button' => 'Forgot Password',
			'page_title' => 'Forgot Password',
			'screen' => 'FORGOT PASSWORD SCREEN',
			'heading' => 'Forgot Password',
			'action' => site_url('Welcome/forgot_password_action'),
		);
		$this->load->view('forgot-password',$data);	
	}
	public function forgot_password_action()
	{
		// after submit button get clicked
		$this->validate_forgot();
		if ($this->form_validation->run() == FALSE)
		{
			$this->forgot_password();
		}
		else
		{ 
			$checkemail = $this->Users_model->GetData("users","","email_address = '".$this->input->post('email_address')."'","","","","1");
			if(!empty($checkemail))
			{
				if($checkemail->status=="Active" || $checkemail->status=="Pending")
				{
					
					$subject = 'Password for login';
					$otp = 'Alc$v'.rand(1000,9999);
					$message='Hii '.ucfirst($checkemail->name).' . You have an password <b>'.$otp.'</b> for login.';
					$mail = $this->sendMail($checkemail->email_address,$subject,$message);
					if($mail==0){
						$this->session->set_flashdata('error','Mail not send.Plese login again !');
						redirect('Welcome');
					}else{
						$savePassword = $this->Users_model->SaveData('users',array('password'=>md5($otp)),'edit_id="'.$checkemail->edit_id.'"');
						$this->session->set_flashdata('success','Mail send successfully . Please check password in mail');
						redirect('Welcome');
					}
				}
				else if($checkemail->status=="Block")
				{
					$this->session->set_flashdata('error','You are blocked by admin please contact him');
					redirect('Welcome');
				} 
			}
			else{
				$this->session->set_flashdata('error','Data not found');
					redirect('Welcome/forget_password');
			}
			
		}
	}
	public function RequestLoan(){

		$GetBanks = $this->Users_model->GetData('mst_banks',"","","mst_banks.created DESC");
		$data = array(
			'id'=> ""
		);
		$this->load->view('requestloan/form',$data );
	}
	public function linkpage($email)
	{
		$checktoken = $this->Users_model->GetData("users","token_link","email_address='".base64_decode($email)."'","","","","1");
		if(!empty($checktoken->token_link))
		{
			$data =  
					array(
							'page_title' => 'Forgot Password',
							'screen' => 'FORGOT PASSWORD SCREEN',
							'heading' => 'Guestbook',
							'forgotpasswordheading' => 'Forgot Password',
							'link_action' => site_url('Welcome/changenewpassword/'.base64_encode($checktoken->token_link)),
							'cancel' => 'Back to Login',
							'cancel_action' => site_url('Welcome/index'),
						 ); 
						$this->load->view("forgotpasswordlinkpage",$data);
		}
		else
		{
			$data = array(
					'massage'=> 'This link has been expired.',
					'page_title' => 'Forgot Password',
					'screen' => 'FORGOT PASSWORD SCREEN',
					'heading' => 'Guestbook',
					'action' => site_url('Welcome/forgot_password_action'),
					'forgotpasswordheading' => 'Forgot Password',
					'button' => 'Submit',
					'cancel' => 'Back to Login',
					'cancel_action' => site_url('Welcome/index'),
					'email_Id' => set_value('email_Id',$this->input->post('email_address',TRUE))
					);
					$this->load->view('forgot-password',$data);
		}
	}
	public function changenewpassword_action($tokenlink)
    {
    $this->validate_newforgot();

    if ($this->form_validation->run() == FALSE)
    {
        // Pass $tokenlink as an argument when reloading the form
        $this->changenewpassword($tokenlink);
    }
    else
    { 
        $checkpass = $this->Users_model->GetData("users","password","token_link='".base64_decode($tokenlink)."'","","","","1");
        if(md5($this->input->post('password')) == $checkpass->password)
        {
            $fortokenexpired = $this->Users_model->GetData("users","email_Id","token_link='".base64_decode($tokenlink)."'","","","","1");
            $tokenexired = array(
                'token_link' => ""
            );
            $this->Users_model->SaveData("users",$tokenexired,"email_Id='".$fortokenexpired->email_address."'");

            $data =array(
                'massage' => "This Password already Saved",
                'page_title' => 'Forgot Password',
                'screen' => 'FORGOT PASSWORD SCREEN',
                'heading' => 'Guestbook',
                'action' => site_url('Welcome/forgot_password_action'),
                'forgotpasswordheading' => 'Forgot Password',
                'button' => 'Submit',
                'cancel' => 'Back to Login',
                'cancel_action' => site_url('Welcome/index'),
                'email_Id' => set_value('email_Id',$this->input->post('email_address',TRUE))
            );
            $this->load->view('forgot-password',$data);
        }
        else
        {
            if($this->input->post('password') == $this->input->post('repeatpassword'))
            {
                $data = array(
                    'password' => md5($this->input->post('password',TRUE))
                );
                $fortokenexpired = $this->Users_model->GetData("users","email_Id","token_link='".base64_decode($tokenlink)."'","","","","1");
                $this->Users_model->SaveData("users",$data,"token_link='".base64_decode($tokenlink)."'");
                $tokenexired = array(
                    'token_link' => "",
                    'token_created ' => date("00:00:00"),
                );
                $this->Users_model->SaveData("users",$tokenexired,"email_Id='".$fortokenexpired->email_Id."'");
                $this->session->set_flashdata('save','Password saved successfully.');
                redirect('Welcome/index');        
            }
            else
            {
                $this->session->set_flashdata('massage','New password not matched with confirm password');
                // Make sure to pass $tokenlink here
                redirect('Welcome/changenewpassword/'.$tokenlink);
            }
        }
    }
}

	
	
		public function register()
	   {
		$data = array(
			'page_title' => 'register',
			'screen' => 'register Screen',
			'heading' => 'Bank Management',
			'register_button_action' => site_url('welcome/register_action'),
			'signupheading' => 'Register',
			'register_button' => 'Register',
			'cancel' => 'Back to Login',
			'cancel_action' => site_url('welcome/index'),
			'name' => ($this->input->post('name',TRUE)),
			'email_address' => $this->input->post('email_address',TRUE)
		);
		// before submit button get clicked
		$this->load->view('register',$data);
	   }

	   public function register_action()
	 {
			
		$this->validate_register();
		if ($this->form_validation->run() == FALSE)
		{
			$this->register();
		}
		else
		{
			$data = array(
				'edit_id' => md5('Users-token'.time().rand(1000,9999)),
				'name' => ucwords($this->input->post('name',TRUE)),
				'email_address' => strtolower($this->input->post('email_address',TRUE)),
				'password' => md5($this->input->post('password',TRUE)),
				'user_type'=>'Customer'
			);
			$this->Users_model->SaveData('users',$data);
			$this->session->set_flashdata('massage','Account added successfully');
			redirect('welcome/index');
		}
	}
 	
	
	public function profile_index(){
		$this->load->view('users/index',$data);
	}
	// Fetch user data for the profile page
public function Profile() {
    // Fetching the session data
	
    $user_data = $this->session->userdata();

    // Check if user is logged in; if not, redirect to the login page or home
    if (empty($user_data)) {
        redirect('Welcome/login');
    }

    // Pass the session data to the view
    $data = array(
        'id' => isset($user_data['id']) ? $user_data['id'] : '',  // Session ID
        'name' => isset($user_data['name']) ? $user_data['name'] : '',  // Session Name
        'email_address' => isset($user_data['email_address']) ? $user_data['email_address'] : '', // Session Email
        'mobnum' => isset($user_data['mobnum']) ? $user_data['mobnum'] : '',  // Session Mobile
        'gender' => set_value('gender', $this->input->post('gender', TRUE)),  // Gender from session or input
        'educ' => isset($user_data['educ']) ? $user_data['educ'] : '',  // Education
        'dob' => isset($user_data['dob']) ? $user_data['dob'] : '',  // Date of Birth
        'action' => site_url('Welcome/Profile_action/'.$user_data['id']),  // Form action for the update
        'button' => 'Update Profile',  // Update button label
        'cancel_action' => site_url('Welcome/profile_index'),  // Redirect for cancel action
        'cancel' => 'Cancel',  // Cancel button label
    );

    $this->load->view('users/profile', $data);  // Load the profile view with data
}

public function Profile_action($id) {
    // Validate the form data
    $this->validate_profile();

    // Check if form validation passes
    if ($this->form_validation->run() == FALSE) {
        // If validation fails, reload the profile page with error messages
        $this->Profile();  // Reload the profile page with validation errors
    } else {
        // Fetch the session data for user_id
        $user_data = $this->session->userdata();

        // Prepare the data to update the user's profile
        $data = array(
            'name' => ucwords($this->input->post('name', TRUE)), // Capitalize first letter of name
            'email_address' => strtolower($this->input->post('email_address', TRUE)), // Ensure email is lowercase
            'address' => ucwords($this->input->post('address', TRUE)), // Capitalize first letter of address
            'gender' => $this->input->post('gender', TRUE),  // Gender from the form input
            'dob' => date('Y-m-d', strtotime($this->input->post('dob', TRUE))), // Format DOB as Y-m-d
            'educ' => $this->input->post('educ', TRUE),  // Education
            'mobnum' => $this->input->post('mobnum', TRUE),  // Mobile number
        );
		// print_r($data);exit;

        // Check if the user exists with the given ID
        $user_exists = $this->Users_model->GetData("users","","id='".$id."'","","","","");

        if ($user_exists) {
            // If user exists, proceed with the update
            $this->Users_model->SaveData("users", $data, "id='".$id."'");

            // Set a success message in the session
            $this->session->set_flashdata('success', 'Profile has been updated successfully');
        } else {
            // User not found, set an error message
            $this->session->set_flashdata('error', 'User not found');
        }

        // Redirect to the profile index page (or any other page)
        redirect('Welcome/profile_index');
    }
}


// Example profile validation method
public function validate_profile() {
    // Name validation: Only allow alphabets, spaces, and hyphens
    $this->form_validation->set_rules('name', 'Name', 'required|regex_match[/^[a-zA-Z\s-]+$/]');

    // Email Address: Valid email format
    $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/]');

    // Password: Should contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,16}$/]');

    // Repeat Password: Should match the original password and follow the same criteria
    $this->form_validation->set_rules('repeatpassword', 'Repeat Password', 'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,16}$/]');

    // Error delimiters
    $this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
}

	public function validate_register()
     {
    // Name: Only allow alphabets, spaces, and hyphens
        $this->form_validation->set_rules('name', 'Name', 'required|regex_match[/^[a-zA-Z\s-]+$/]');

    // Email Address: Valid email format
        $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/]|is_unique[users.email_address]');

    // Password: Should contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character
	    $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,16}$/]',array("regex_match"=>"The format is wrong.The format is like atleast 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character " ));




    // Repeat Password: Should match the original password and follow the same criteria
        $this->form_validation->set_rules('repeatpassword', 'Repeat Password', 'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,16}$/]',array("regex_match"=>"The format is wrong.The format is like atleast 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character " ));




    // Error delimiters
        $this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
     }
	//  public function validate_profile()
    //  {
    // // Name: Only allow alphabets, spaces, and hyphens
    //     $this->form_validation->set_rules('name', 'Name', 'required|regex_match[/^[a-zA-Z\s-]+$/]');

    // // Email Address: Valid email format
    //     $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/]|is_unique[users.email_address]');
       
	// 	$this->form_validation->set_rules('dob', 'DOB', '');
	// 	$this->form_validation->set_rules('gender', 'GENDER', '');
	// 	$this->form_validation->set_rules('educ', 'EDUCATION', '');
	// 	$this->form_validation->set_rules('mobnum', 'Ex 8888888885', '');
    //     $this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
    //  }


	public function validate_login()
      {
    // Email Address: Valid email format
       $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/]');

    // Password: Should contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character
	   $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,16}$/]',array("regex_match"=>"The format is wrong.The format is like atleast 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character " ));


    // Error delimiters
       $this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
     }

	public function validate($id = '')
	{
		if ($id != '') {
			// print_r('hi');exit;
			$this->form_validation->set_rules('name', 'Name', 'required|regex_match[/^[A-Za-z\'\-\/. ]+$/]');
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('gender', 'Gender', 'required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
		} else {
			//Validation for create
			// print_r(hii);exit;
			$this->form_validation->set_rules('name', 'Name', 'required|regex_match[/^[A-Za-z\'\-\/. ]+$/]');
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|is_unique[ users.email_address]');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('gender', 'Gender', 'required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
		}
	}
	public function validate_forgot()
	{
		$this->form_validation->set_rules('email_address','Email Address','required|valid_email');
		$this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
	}
	public function validate_verify(){
		$this->form_validation->set_rules('otp','OTP','required');
		$this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
	}
	public function validate_newforgot()
	{
		$this->form_validation->set_rules('password','Password','required|min_length[8]|max_length[16]' );
		$this->form_validation->set_rules('repeatpassword','Repeat Password','required|min_length[8]|max_length[16]|matches[password]');
		$this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
	}
	public function logout()
	{
		session_destroy();
		redirect('Welcome');
		
	}
	public function otp($edit_id='')
	{
		if(empty($edit_id)){
			$this->session->set_flashdata('error','Data not found');
				redirect('Welcome');
		}
		$this->load->database();
		$data = array(
			'action' => site_url('Welcome/verify_action'),
			'login_button' => 'Verify Now',
			'edit_id'=>$edit_id
		); 
		$this->load->view('otp',$data);
	}
	public function verify_action()
	{
		
		$this->validate_verify();
		if($this->form_validation->run() == FALSE)
		{
			$this->otp();	
		}
		else
		{
			$otp = $this->input->post("otp",TRUE);
			$edit_id = $this->input->post("edit_id",TRUE);
			$checkemail = $this->Users_model->GetData("users","id,name,email_address,password,status,user_type,temp_otp,edit_id,profile_pic,educ,mobnum","temp_otp='".$otp."' and is_delete='No' and edit_id='".$edit_id."'","","","","1");
			if(empty($checkemail))
			{
				$this->session->set_flashdata('error','Invalid OTP');
				redirect('Welcome/otp');
			}
			else
			{
				$sessiondata = array(
								"id" => $checkemail -> id, 
								"user_type" => $checkemail ->user_type, 
								"name" => $checkemail -> name, 
								"email_address" => $checkemail -> email_address,	
								"educ" => $checkemail -> educ,	
								"mobnum" => $checkemail -> mobnum,		
								"status" => $checkemail -> status,
								'profile_pic'=>$checkemail->profile_pic
							);
				$updateData = $this->Users_model->SaveData('users',array('temp_otp'=>''),'edit_id="'.$checkemail ->edit_id.'"');		
				$this->session->set_userdata($sessiondata);
				$this->session->set_flashdata('success','Login Successfully');
				redirect('Dashboard');
			}
		}
		
	}
	public function sendMail($to,$subject='',$message=''){
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.gmail.com',
			'smtp_port' => '587',
			'smtp_user' => 'roshnigirhepunje42@gmail.com',
			'smtp_pass' => 'vizf fimu gjhk espg',
			'mailtype'  => 'html', 
			'charset'   => 'utf-8',
			'smtp_crypto'=>'tls',
			'send_multipart'=>FALSE,
			'wordwrap'=>TRUE
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('roshnigirhepunje42@gmail.com', 'Loan Bridge');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		
		// $this->email->send();
		if ( ! $this->email->send())
		{
        	return 0;
		}else{
			return 1;
		}
		
	}
	function sendOTP(){
		if(!empty($_POST['edit_id'])){
			$checkemail = $this->Users_model->GetData("users","name,email_address as email,edit_id","edit_id='".$_POST['edit_id']."'","","","","1");
			if(!empty($checkemail)){
				$subject = 'OTP For Verfication';
				$otp = rand(0000,9999);
				$message='Hii '.ucfirst($checkemail->name).' . You have an otp <b>'.$otp.'</b> for 2 step verification .';
				$to = $checkemail->email;
				$mailData= $this->sendMail($to,$subject,$message);
				if($mailData==1){
					$saveOTP = $this->Users_model->SaveData('users',array('temp_otp'=>$otp),'edit_id="'.$checkemail->edit_id.'"');
					$data = array('success'=>'1','message'=>'Mail Send Successfully . Please check your mail for OTP .');
				}else{
					$data = array('success'=>'0','message'=>'Mail not send .Please resend mail.');
				}
			}else{
				$data = array('success'=>'2','message'=>'data not found');
			}
		}else{
			$data = array('success'=>'3','message'=>'data not found');
		}
		print_r(json_encode($data));exit();
	}
	function SendPassword(){
		
			$checkemail = $this->Users_model->GetData("users","name,email_address as email,edit_id","","","","","1");
			if(!empty($checkemail)){
				$subject = 'Your New Password is';
				$newpassword = rand(10000000, 99999999);
				$message='Hii '.ucfirst($checkemail->name).' . You have an new password suggetion <b>'.$newpassword.'</b> for 2 step verification .';
				$to = $checkemail->email;
				$mailData= $this->sendMail($to,$subject,$message);
				if($mailData==1){
					$saveOTP = $this->Users_model->SaveData('users',array('temp_otp'=>$otp),'edit_id="'.$checkemail->edit_id.'"');
					$data = array('success'=>'1','message'=>'Mail Send Successfully . Please check your mail for OTP .');
				}else{
					$data = array('success'=>'0','message'=>'Mail not send .Please resend mail.');
				}
			}else{
				$data = array('success'=>'2','message'=>'data not found');
			}
		// {
		// 	$data = array('success'=>'3','message'=>'data not found');
		// }
		print_r(json_encode($data));exit();
	}
}
?>
