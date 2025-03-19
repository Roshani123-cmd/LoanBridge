<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	
	public function __construct() {
		parent::__construct();
		if(!isset($_SESSION) || empty($_SESSION)){
			redirect('Welcome/logout');
		}
        // Load URL helper
		$this->load->library('session');
        $this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('Dashboard_model');
		$this->load->library('user_agent');
		$this->load->library('form_validation');
		$this->load->database();
    }

	public function index()
	{
		$GetLoans = $this->Dashboard_model->GetData('mst_loans','','is_delete="No" and status="Active"','loan_name asc'); 
		$GetBank = $this->Dashboard_model->GetData('mst_banks','name,id','is_delete="No" and status="Active"','','','',''); 
		$userCond = '';
		if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='Customer') { 
			$userCond = 'user_id="'.$this->session->userdata('id').'"';
		}
		$getRequest = $this->Dashboard_model->GetData('customer_loans','',$userCond,'','','','');
		$checkRequest = $this->Dashboard_model->GetData('customer_loans','','user_id="'.$this->session->userdata('id').'" and (status="Pending" or status="Rejected") ','','','','');
		$checkRequestApproved = $this->Dashboard_model->GetData('customer_loans','','user_id="'.$this->session->userdata('id').'" and (status="Approved") ','','','','');
		$totalCustomer = $this->Dashboard_model->GetData('users','count(id) as TOTAL','status="Active" and is_delete="No" and user_type="Customer"','','','','1');
		$totalCustomerPendingLoanRequest = $this->Dashboard_model->GetData('customer_loans','count(id) as TOTAL','status="Pending"','','','','1');
		$totalCustomerApprovedLoanRequest = $this->Dashboard_model->GetData('customer_loans','count(id) as TOTAL','status="Approved"','','','','1');
		$totalCustomerRejectedLoanRequest = $this->Dashboard_model->GetData('customer_loans','count(id) as TOTAL','status="Rejected"','','','','1');
		$getEmiData = $this->Dashboard_model->GetData('customer_emi_dates','','customer_id="'.$this->session->userdata('id').'"','','','','');
		// print_r($getEmiData); exit();
		$emiDateCalendarArray = [];
		if(!empty($getEmiData)){
			foreach($getEmiData as $data){
				$dummyArray= [];
				$title = '<center>EMI Day <br/> ['.$data->request_number.'] <br/> Amount : Rs <b>'.$data->emi_amount.'</b> <br/> Is EMI Paid ? : <b>'.$data->payment_done.'</b><center>';
				$dummyArray['title'] = $title;
				$dummyArray['status'] = $data->payment_done;
				$dummyArray['start'] = $data->emi_date;
				$dummyArray['end'] = $data->emi_date;
				array_push($emiDateCalendarArray,$dummyArray);
			}

		}
		
		$emiDateCalendarArray = json_encode($emiDateCalendarArray);
		$data = array(
			'GetLoans'=>$GetLoans,
			'GetBank'=>$GetBank,
			'getRequest'=>$getRequest,
			'totalCustomer'=>$totalCustomer->TOTAL,
			'totalCustomerPendingLoanRequest'=>$totalCustomerPendingLoanRequest->TOTAL,
			'totalCustomerApprovedLoanRequest'=>$totalCustomerApprovedLoanRequest->TOTAL,
			'totalCustomerRejectedLoanRequest'=>$totalCustomerRejectedLoanRequest->TOTAL,
			'checkRequest'=>$checkRequest,
			'emiDateCalendarArray'=>$emiDateCalendarArray,
			'checkRequestApproved'=>$checkRequestApproved

		);
		
		$this->load->view('dashboard/index',$data);
	}
	public function getLoanType(){
		$html ="<option value=''>Select Loan Type</option>";
		if(isset($_POST['bank_id']) && !empty($_POST['bank_id'])){
			$GetLoans = $this->Dashboard_model->GetData('mst_loans','id,loan_name,interest_rate','is_delete="No" and status="Active" and bank_id="'.$_POST['bank_id'].'"'); 
			if(!empty($GetLoans)){
				foreach($GetLoans as $loanData){
					 $html.="<option value='".$loanData->id."'>".$loanData->loan_name."</option>";
				}
			}
			$data = array('success'=>1,'html'=>$html);
		}else{
			$data = array('success'=>0,'html'=>'');
		}
		print_r(json_encode($data));exit();
		
	}
	public function getInterest(){
		$html ="0";
		if(isset($_POST['loan_type']) && !empty($_POST['loan_type'])){
			$GetLoans = $this->Dashboard_model->GetData('mst_loans','id,loan_name,interest_rate','is_delete="No" and status="Active" and id="'.$_POST['loan_type'].'"','','','','1'); 
			if(!empty($GetLoans)){
				$html = $GetLoans->interest_rate;
			}
			$data = array('success'=>1,'html'=>$html);
		}else{
			$data = array('success'=>0,'html'=>'');
		}
		print_r(json_encode($data));exit();
		
	}
	public function  saveLoanRequest(){
		$checkRequest = $this->Dashboard_model->GetData('customer_loans','id','user_id="'.$this->session->userdata('id').'" and status="Pending"','','','','1');
		if(!empty($checkRequest)){
			$this->session->set_flashdata('error', 'Loan request is already pending');
			redirect('Dashboard');
		}
		$edit_id=md5('Loan Request -'.date('Y-m-d H:i:s'));  
		$user_id=$this->session->userdata('id'); 
		$bank_id='';if(isset($_POST['bank_id']) && !empty($_POST['bank_id'])) $bank_id = $_POST['bank_id']; 
		$loan_amount='';if(isset($_POST['loan_amount']) && !empty($_POST['loan_amount'])) $loan_amount = $_POST['loan_amount'];  
		$total_payable='';if(isset($_POST['total_payment']) && !empty($_POST['total_payment'])) $total_payable = $_POST['total_payment'];  
		$interest_rate='';if(isset($_POST['interest_rate']) && !empty($_POST['interest_rate'])) $interest_rate = $_POST['interest_rate'];  
		$monthly_interest_rate='';if(isset($_POST['total_interest_rate_value']) && !empty($_POST['total_interest_rate_value'])) $monthly_interest_rate = $_POST['total_interest_rate_value'];  
		$loan_type='';if(isset($_POST['loan_type']) && !empty($_POST['loan_type'])) $loan_type = $_POST['loan_type'];
		$tennure='';if(isset($_POST['tennure']) && !empty($_POST['tennure'])) $tennure = $_POST['tennure'];  
		$processing_fee='';if(isset($_POST['processing_fee_value']) && !empty($_POST['processing_fee_value'])) $processing_fee = $_POST['processing_fee_value'];  
		$emi_amount='';if(isset($_POST['loan_emi_value']) && !empty($_POST['loan_emi_value'])) $emi_amount = $_POST['loan_emi_value'];  
		$status='Pending';
		$request_number = 'REQ -'.rand(1000,9999);
		$data = array(
			'edit_id'=>$edit_id,
			'user_id'=>$user_id,
			'bank_id'=>$bank_id,
			'loan_amount'=>$loan_amount,
			'total_payable'=>$total_payable,
			'interest_rate'=>$interest_rate,
			'monthly_interest_rate'=>$monthly_interest_rate,
			'loan_type'=>$loan_type,
			'tennure'=>$tennure,
			'processing_fee'=>$processing_fee,
			'emi_amount'=>$emi_amount,
			'status'=>$status,
			'request_number'=>$request_number
		);
		$saveRecord = $this->Dashboard_model->SaveData('customer_loans',$data);
		$this->session->set_flashdata('success', 'Loan request successfully');
		redirect('Dashboard');
	}
	public function deleteLoanRequest($edit_id=''){
		$getData = $this->Dashboard_model->GetData('customer_loans','id','edit_id="'.$edit_id.'"','','','','1');
		if(empty($getData)){
			$this->session->set_flashdata('error', 'Data not found');
			redirect('Dashboard');
		}
		$deleteData = $this->Dashboard_model->DeleteData('customer_loans','edit_id="'.$edit_id.'"');
		$delteEmiDates = $this->Dashboard_model->DeleteData('customer_emi_dates','customer_loan_id="'.$getData->id.'"');
		$this->session->set_flashdata('success', 'Loan request delete successfully');
		redirect('Dashboard');
	}
	public function viewLoanRequest($edit_id=''){
		$getData = $this->Dashboard_model->GetData('customer_loans','id','edit_id="'.$edit_id.'"','','','','1');
		if(empty($getData)){
			$this->session->set_flashdata('error', 'Data not found');
			redirect('Dashboard');
		}
		$getData = $this->Dashboard_model->GetData('customer_loans','','edit_id="'.$edit_id.'" ','','','','1');
		$GetLoans = $this->Dashboard_model->GetData('mst_loans','','is_delete="No" and status="Active"','loan_name asc'); 
		$GetBank = $this->Dashboard_model->GetData('mst_banks','name,id','is_delete="No" and status="Active"','','','',''); 
		$getEmiData = $this->Dashboard_model->GetData('customer_emi_dates','emi_date,payment_done,payment_done_datetime,remaining_payment,edit_id,paid_amount','customer_loan_id="'.$getData->id.'"','','','',''); 
		$total_paid = $this->Dashboard_model->GetData('customer_emi_dates','sum(paid_amount) as TOTAL','customer_loan_id="'.$getData->id.'"','','','','1');
		$total_rem =  $getData->total_payable - $total_paid->TOTAL;
		$getUserName = $this->Dashboard_model->GetData('users','name','id="'.$getData->user_id.'" ','','','','1');
		$cust_name = '';if(!empty($getUserName->name)) $cust_name = $getUserName->name;
		$data = array(
			'heading'=>'View Loan Request'.'[ <b>'.$cust_name.'</b> '.$getData->request_number.' ]',
			'getData'=>$getData,
			'GetBank'=>$GetBank,
			'GetLoans'=>$GetLoans,
			'getEmiData'=>$getEmiData,
			'total_paid'=>$total_paid->TOTAL,
			'total_rem'=>$total_rem
		);
		$this->load->view('dashboard/request_loan_view',$data);
	}
	public function changeStatusLoanRequest(){
		if(!isset($_POST['id'])){
			$this->session->set_flashdata('error', 'Data not found');
			redirect('Dashboard');
		}
		$getData = $this->Dashboard_model->GetData('customer_loans','','edit_id="'.$_POST['id'].'"','','','','1');
		if(empty($getData)){
			$this->session->set_flashdata('error', 'Data not found');
			redirect('Dashboard');
		}
		$STATUS = '';if(isset($_POST['status']) && !empty($_POST['status'])) $STATUS = $_POST['status'];
		$updateData = $this->Dashboard_model->SaveData('customer_loans',array('status'=>$STATUS),'edit_id="'.$_POST['id'].'"');
		// for status approved
			if($STATUS=='Approved'){
				if(!empty($getData->tennure)){
					for($i=0;$i<$getData->tennure;$i++){
						$date = date('Y-m-d',strtotime('+'.($i+1).' month'));
						$data_array = array(
							'edit_id'=>md5(time().$i.'-'.date('Y')),
							'user_id'=>$this->session->userdata('id'),
							'bank_id'=>$getData->bank_id,
							'loan_type'=>$getData->loan_type,
							'customer_id'=>$getData->user_id,
							'emi_date'=>$date,
							'total_payment'=>$getData->total_payable,
							'remaining_payment'=>$getData->total_payable,
							'emi_amount'=>$getData->emi_amount,
							'request_number'=>$getData->request_number,
							'customer_loan_id'=>$getData->id
						);
						$saveEmiDate = $this->Dashboard_model->SaveData('customer_emi_dates',$data_array);
					}
				}	
			}
		// for status approved
		$message = 'Your Loan Request Number : ['.$getData->request_number.'] has been <b>'.$STATUS.'</b>. Please check in LoanBridge web application .';
		$subject = 'Your Loan Request Number : ['.$getData->request_number.'] status has been changed .';
		$getCustomer =  $this->Dashboard_model->GetData('users','email_address','status="Active" and is_delete="No" and user_type="Customer" and id="'.$getData->user_id.'"','','','','1');
		if(!empty($getCustomer->email_address)){
			$mailData= $this->sendMail($getCustomer->email_address,$subject,$message);
		}
		
		$this->session->set_flashdata('success', 'Loan request status change successfully');
		redirect('Dashboard');
	}
	public function sendMail($to,$subject='',$message=''){
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.gmail.com',
			'smtp_port' => '587',
			'smtp_user' => 'roshnigirhepunje42@gmail.com',
			'smtp_pass' =>'vizf fimu gjhk espg',
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
	
	public function changeStatusEmiPay(){
		if(!isset($_POST['id'])){
			$this->session->set_flashdata('error', 'Data not found');
			redirect('Dashboard');
		}
		$getData = $this->Dashboard_model->GetData('customer_emi_dates','','edit_id="'.$_POST['id'].'"','','','','1');
		if(empty($getData)){
			$this->session->set_flashdata('error', 'Data not found');
			redirect('Dashboard');
		}
		$getReqData = $this->Dashboard_model->GetData('customer_loans','edit_id,total_payable','id="'.$getData->customer_loan_id.'"','','','','1');
		$STATUS = '';if(isset($_POST['status']) && !empty($_POST['status'])) $STATUS = $_POST['status'];
		$amount='0';if(isset($_POST['amount']) && !empty($_POST['amount'])) $amount = $_POST['amount'];
		if(empty($getReqData->edit_id))
		{
			redirect('Dashboard');
		}
		if(!is_numeric($amount) || $amount==0 || $amount<0 || $amount > $getData->emi_amount){
			$this->session->set_flashdata('error', 'Please enter proper amount');
			redirect('Dashboard/viewLoanRequest/'.$getReqData->edit_id);
		}
		$total_payment = $getData->remaining_payment - $amount;
		$paymentDateDone='';
		if($STATUS=='Yes'){
			$paymentDateDone = date('Y-m-d H:i:s');
		}
		$updateData = $this->Dashboard_model->SaveData('customer_emi_dates',array('payment_done'=>$STATUS,'payment_done_datetime'=>$paymentDateDone,'remaining_payment'=>$total_payment,'paid_amount'=>$amount),'edit_id="'.$_POST['id'].'"');
		if($total_payment=='0'){
			$updateDataCustomer = $this->Dashboard_model->SaveData('customer_loans',array('status'=>'Paid'),'edit_id="'.$getReqData->edit_id.'"');
		}
		$this->session->set_flashdata('success', 'Status change successfully');
		if(empty($getReqData->edit_id))
		{
			redirect('Dashboard');
		}
		redirect('Dashboard/viewLoanRequest/'.$getReqData->edit_id);
	}
}
?>