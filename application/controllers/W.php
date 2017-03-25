<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class W extends CI_Controller
{

    public function index()
    {
        echo "lll";

    }

    public function lo()
    {
        $password = $this->encrypt->encode($this->input->post('password'));
        $data = array(
            'account' => $this->input->post('account'),
            'password' => $password,
            'email' => $this->input->post('email')
        );
        $this->db->insert('whyuser', $data);
        echo json_encode($data);
        // echo "dddddhahaha";
    }

    public function li()
    {
        $password = $this->input->post('password');
        $account = $this->input->post('account');
        $dbData = $this->db->get_where('whyuser', array('account' => $account))->result_array();
        $plaintext_string = "";
        if (isset($dbData[0]['password']))
            $plaintext_string = $this->encrypt->decode($dbData[0]['password']);
        if ($plaintext_string == $password) {

            $Data = $dbData;
            $Data['success'] = true;
            $token = $this->encrypt->encode($account + time());
            $this->myredis->psetex($dbData[0]['idWhyUser'], 20000, $token);
            $Data['token'] = $token;
        } else {
            $Data['success'] = false;

        }
        echo json_encode($Data);
        // echo $this->input->post('password');
    }

//    public  function  searchfri(){
//        $searchname = $this->input->post('searchname');
//
//        $dbData = $this->db->get_where('whyuser', array('account' => $searchname))->result_array();
//
//        $Data = null;
//
//        if(sizeof($dbData)==0){
//            $Data['success'] = false;
//        }else{
//            $Data = $dbData;
//            $Data['success'] = true;
//        }
//        echo json_encode($Data);
//
//    }
}