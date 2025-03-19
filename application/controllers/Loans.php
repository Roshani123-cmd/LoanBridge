<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Loans extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION) || empty($_SESSION) || $_SESSION['user_type']!='Employee'){
            redirect('Welcome/logout');
        }
        $this->load->model('Loan_model');
        $this->load->library('session');
        $this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->library('form_validation');
    }
    public function index()
    {
        // Manage/List page from notices folder
        $allLoanType = $this->Loan_model->GetData("mst_loans", "", "", "created DESC", "", "");
        $data = array(
            'allLoanType' => $allLoanType,
            'page_title' => 'Manage-Loans',
            'heading' => 'Manage Loans',
            'screen' => 'Manage Loans',
            'button' => 'Create',
            'button_action' =>  site_url('Loans/create'),
            'records' => 'Notice Records'
        );
        $this->load->view('loans/index', $data);      
    }
    public function create()
    {
        $allBanks =  $this->Loan_model->GetData("mst_banks", "", "status='Active'", "", "", "");
        // call form.php from notices folder
        $data = array(
            'page_title' => 'Create Loan',
            'heading' => 'Create Loan',
            'screen' => 'Create Loan',
            'action' => site_url('Loans/create_action'),
            'button' => 'Create',

            'cancel' => 'Cancel',
            'cancel_action' => site_url('Loans'),
            'bank_id'=> set_value('bank_id', $this->input->post('bank_id', TRUE)),
            'loan_name' => set_value('loan_name', $this->input->post('loan_name', TRUE)),
            'interest_rate' => set_value('interest_rate', $this->input->post('interest_rate', TRUE)),
            'status' => set_value('status', $this->input->post('status', TRUE)),
            'allBanks' => $allBanks
        );
        $this->load->view('loans/form', $data);
    }
    public function create_action()
    {
      
        if (isset($_POST) && !empty($_POST)) {
            $this->validate();
            if ($this->form_validation->run() == FALSE) {
                $this->create();
            } else {
                $token = md5('Notices-token' . time() . rand(1000, 9999));
                $data = array(
                    'edit_id' => $token,
                    'bank_id' => $this->input->post('bank_id', TRUE),
                    'loan_name'    => ucwords($this->input->post('loan_name', TRUE)),
                    'interest_rate'    => $this->input->post('interest_rate', TRUE),
                    'status'    => $this->input->post('status')
                );     
                $saveData = $this->Loan_model->SaveData('mst_loans', $data);
                $this->session->set_flashdata('success', 'Record created');
                redirect('Loans');
            }
        } else {
            $this->session->set_flashdata('error', 'Data not found');
            redirect('Loans');
        }
       
    }
    public function view_action($id)
    { //print_r($id);exit;
        //call view.php with data against id/token
        $Loandata = $this->Loan_model->GetData("mst_loans", "", "edit_id ='" .$id . "'");
        if (empty($Loandata)) {
            redirect('Loans');
        } else {
            $data = array(
                'page_title' => 'View Loan',
                'heading' => ' View Loan',
                'screen' => 'View Loan',
                'records' => 'Loan Detail',
                'cancel' => 'Back',
                'cancel_action' => site_url('Loans'),
                'Loandata' => $Loandata
            );
            $this->load->view('loans/view', $data);
        }
    }
    public function update($id)
    {
        $getsingleloans = $this->Loan_model->GetData("mst_loans", "", "edit_id='" .$id . "'", "", "", "", "single");
        $allBanks =  $this->Loan_model->GetData("mst_banks", "", "status='Active'", "", "", "");
        if (!empty($getsingleloans)) {
            $data = array(
                'page_title' => 'Update Loan',
                'heading' => 'Update Loan',
                'screen' => 'Update Loan',
                'action' => site_url('Loans/update_action/' . $id),
                'button' => 'Update',
                'cancel' => 'Cancel',
                'cancel_action' => site_url('Loans'),
                'bank_id' => set_value('bank_id', $getsingleloans->bank_id),
                'loan_name' => set_value('loan_name', $getsingleloans->loan_name),
                'interest_rate' => set_value('interest_rate', $getsingleloans->interest_rate),
                'status' => set_value('status', $getsingleloans->status),
                'allBanks'=>$allBanks
            );
            $this->load->view('loans/form', $data);
        }else{
            $this->session->set_flashdata('error', 'Data not found');
            redirect('Loans');
        }
    }
    public function update_action($id)
    {
        if (isset($_POST) && !empty($_POST)) {
            $this->validate($id);
            if ($this->form_validation->run() == FALSE) {
                $this->update($id);
            } else {
                $data = array(
                    'bank_id' => $this->input->post('bank_id', TRUE),
                    'loan_name'    => ucwords($this->input->post('loan_name', TRUE)),
                    'interest_rate'    => $this->input->post('interest_rate', TRUE),
                    'status'    => $this->input->post('status')
                );     
                $this->Loan_model->SaveData('mst_loans', $data, "edit_id= '" .$id. "'");
            }
            $this->session->set_flashdata('success', 'Loan has been updated successfully');
            redirect('Loans');
        } else {
            redirect('Loans/update/'. $id);
        }
    }
    public function delete_action($id)
    {
        // call delete function from model with id/token
        $getloan = $this->Loan_model->GetData("mst_loans", "id", "edit_id ='" .$id. "'", "", "", "", "1");
        //If record found or not
        if (empty($getloan)) {
            redirect('Loans');
        } else {
            $this->Loan_model->DeleteData("mst_loans", "id ='" . $getloan->id . "'");
            $this->session->set_flashdata('success', 'Loan status has been deleted successfully');
            redirect('Loans');
        }
    }
    public function deleteall_action()
    {
        if (isset($_POST['deleteall'])) {
            if (!empty($this->input->post('selector'))) {
                $token = $this->input->post('selector');
                if (!empty($token)) {
                    $del = 0;
                    for ($i = 0; $i < count($token); $i++) {
                        $getloan = $this->Loan_model->GetData("mst_loans", "id", "edit_id='" .$token[$i] . "'", "", "", "", "");
                        foreach ($getloan as $getnoticedata) {
                            $this->Loan_model->DeleteData("mst_loans", "id ='" . $getnoticedata->id . "'");
                            $del++;
                        }
                    }
                    $massage = $del . " Loan record has been deleted";
                    $this->session->set_flashdata('error', $massage);
                    redirect('Loans');
                }
            } else {
                $this->session->set_flashdata('error', 'Check atleast one record to delete');
                redirect('Loans');
            }
        }
    }
    public function validate($id = '')
    {
        $getData = $this->Loan_model->GetData("mst_loans", "", "edit_id !='" .$id . "' and loan_name='".$_POST['loan_name']."'  and bank_id='".$_POST['bank_id']."'", "", "", "", "single");
        $is_unique = '';
        if(!empty($getData)){
            $is_unique = '|unique[mst_loans.loan_name]';
        }
        $this->form_validation->set_rules('bank_id', 'Select Bank Name', 'required');
        $this->form_validation->set_rules('loan_name', 'Loan'.$is_unique, 'required');
        $this->form_validation->set_rules('interest_rate', 'Select Interest Rate', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
    }
}