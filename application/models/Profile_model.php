<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Profile_model extends CI_Model
{
    // Function to insert profile
    function setprofile()
    {
        // Check if required fields are missing
        if (!$this->input->post('name') || !$this->input->post('email_address')) {
            $this->session->set_flashdata('msg', 'Name or Email Address cannot be empty.');
            return false; // Exit the function if required fields are missing
        }
        
        // Get input values
        $name = $this->input->post('name');
        $email_address = $this->input->post('email_address');
        $mobnum = $this->input->post('mobnum');
        $gender = $this->input->post('gender');
        $educ = $this->input->post('educ');
        $hobbies = $this->input->post('hobbies'); // Get hobbies as an array

        // Check if hobbies is an array and convert it to a comma-separated string
        $hobbies_str = is_array($hobbies) ? implode(', ', $hobbies) : '';

        // Prepare data for insertion
        $data = array(
            'name' => $name,
            'email_address' => $email_address,
            'mobnum' => $mobnum,
            'gender' => $gender,
            'educ' => $educ,
            'hobbies' => $hobbies_str
        );

        // Insert data into the database
        $this->db->insert('users', $data);

        // Check if insertion was successful
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id(); // Return the inserted ID if successful
        } else {
            return false; // Return false if there was an issue with insertion
        }
    }

    // Function to get profile data
    function getprofile()
    {
        return $this->db->select('*')
            ->from('users')
            ->order_by('id', 'DESC')
            ->get()->result();
    }
}