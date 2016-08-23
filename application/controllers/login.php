<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Login extends CI_Controller
{
	public function index( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in == 'true' ) {
			redirect( base_url() . 'index.php/site', 'refresh' );
		} //$is_logged_in == 'true'
		//$data[ 'page' ] = 'login';
		//$data[ 'title' ]     = 'Login Page';
		$this->load->view( 'login' );
	}
	public function validate( )
	{
		$this->load->model('user_model');
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$validate = $this->user_model->validate($username,$password);
		if ( $validate ) {
			redirect( base_url() . 'index.php/site', 'refresh' );
		} //$validate
		else {
			$data[ 'alerterror' ] = 'Username or Password Incorrect';
			//$data[ 'page' ]  = 'login';
			//$data[ 'title' ]      = 'Login Page';
			$this->load->view( 'login' , $data );
		}
	}
	public function logout( )
	{
		$this->session->sess_destroy();
		redirect( base_url() . 'index.php/login', 'refresh' );
	}
}
?>