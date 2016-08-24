<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data['category']=$this->category_model->getcategorydropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
//            $category=$this->input->post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`logintype`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    //project
    
    function viewproject()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewproject';
        $data['base_url'] = site_url("site/viewprojectjson");
        
		$data['title']='View project';
		$this->load->view('template',$data);
	} 
    function viewprojectjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`project`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`project`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`project`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`project`.`databasename`";
        $elements[3]->sort="1";
        $elements[3]->header="databasename";
        $elements[3]->alias="databasename";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`project`.`databasepassword`";
        $elements[4]->sort="1";
        $elements[4]->header="databasepassword";
        $elements[4]->alias="databasepassword";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`project`.`hostname`";
        $elements[5]->sort="1";
        $elements[5]->header="hostname";
        $elements[5]->alias="hostname";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`project`.`userpassword`";
        $elements[6]->sort="1";
        $elements[6]->header="userpassword";
        $elements[6]->alias="userpassword";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`project`.`mandrillid`";
        $elements[7]->sort="1";
        $elements[7]->header="mandrillid";
        $elements[7]->alias="mandrillid";
       
        
        $elements[8]=new stdClass();
        $elements[8]->field="`project`.`mandrillpassword`";
        $elements[8]->sort="1";
        $elements[8]->header="mandrillpassword";
        $elements[8]->alias="mandrillpassword";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `project`");
        
		$this->load->view("json",$data);
	} 
    
    public function createproject()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createproject';
		$data[ 'title' ] = 'Create project';
		$this->load->view( 'template', $data );	
	}
	function createprojectsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('databasename','databasename','trim');
		$this->form_validation->set_rules('databasepassword','databasepassword','trim');
		$this->form_validation->set_rules('hostname','hostname','trim');
		$this->form_validation->set_rules('userpassword','userpassword','trim');
		$this->form_validation->set_rules('mandrillid','mandrillid','trim');
		$this->form_validation->set_rules('mandrillpassword','mandrillpassword','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createproject';
            $data[ 'title' ] = 'Create project';
            $this->load->view( 'template', $data );
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $databasename=$this->input->post('databasename');
            $databasepassword=$this->input->post('databasepassword');
            $hostname=$this->input->post('hostname');
            $userpassword=$this->input->post('userpassword');
            $mandrillid=$this->input->post('mandrillid');
            $mandrillpassword=$this->input->post('mandrillpassword');
			if($this->project_model->create($name,$email,$databasename,$databasepassword,$hostname,$userpassword,$mandrillid,$mandrillpassword)==0)
			$data['alerterror']="New project could not be created.";
			else
			$data['alertsuccess']="project created Successfully.";
			$data['redirect']="site/viewproject";
			$this->load->view("redirect",$data);
		}
	}
    
    
	function editproject()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->project_model->beforeedit($this->input->get('id'));
		$data['page']='editproject';
		$data['page2']='block/projectblock';
		$data['title']='Edit project';
		$this->load->view('templatewith2',$data);
	}
	function editprojectsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('databasename','databasename','trim');
		$this->form_validation->set_rules('databasepassword','databasepassword','trim');
		$this->form_validation->set_rules('hostname','hostname','trim');
		$this->form_validation->set_rules('userpassword','userpassword','trim');
		$this->form_validation->set_rules('mandrillid','mandrillid','trim');
		$this->form_validation->set_rules('mandrillpassword','mandrillpassword','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->project_model->getstatusdropdown();
			$data['accesslevel']=$this->project_model->getaccesslevels();
            $data[ 'logintype' ] =$this->project_model->getlogintypedropdown();
			$data['before']=$this->project_model->beforeedit($this->input->post('id'));
			$data['page']='editproject';
//			$data['page2']='block/projectblock';
			$data['title']='Edit project';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $databasename=$this->input->post('databasename');
            $databasepassword=$this->input->post('databasepassword');
            $hostname=$this->input->post('hostname');
            $userpassword=$this->input->post('userpassword');
            $mandrillid=$this->input->post('mandrillid');
            $mandrillpassword=$this->input->post('mandrillpassword');
            
			if($this->project_model->edit($id,$name,$email,$databasename,$databasepassword,$hostname,$userpassword,$mandrillid,$mandrillpassword)==0)
			$data['alerterror']="project Editing was unsuccesful";
			else
			$data['alertsuccess']="project edited Successfully.";
			
			$data['redirect']="site/viewproject";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deleteproject()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->project_model->deleteproject($this->input->get('id'));
		$data['alertsuccess']="project Deleted Successfully";
		$data['redirect']="site/viewproject";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
    
    function viewprojectaccesslevel()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewprojectaccesslevel';
        $id=$this->input->get('id');
        $data['base_url'] = site_url("site/viewprojectaccessleveljson?id=").$this->input->get('id');
        
		$data['title']='View project';
		$this->load->view('template',$data);
	} 
    function viewprojectaccessleveljson()
	{
        $id=$this->input->get('id');
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`projectaccesslevel`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`projectaccesslevel`.`accesslevel`";
        $elements[1]->sort="1";
        $elements[1]->header="accesslevel";
        $elements[1]->alias="accesslevel";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`projectaccesslevel`.`project`";
        $elements[2]->sort="1";
        $elements[2]->header="project";
        $elements[2]->alias="project";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `projectaccesslevel`","WHERE `projectaccesslevel`.`project`='$id'");
        
		$this->load->view("json",$data);
	} 
    
    public function createprojectaccesslevel()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createprojectaccesslevel';
		$data[ 'title' ] = 'Create projectaccesslevel';
		$this->load->view( 'template', $data );	
	}
	function createprojectaccesslevelsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('accesslevel','accesslevel','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createproject';
            $data[ 'title' ] = 'Create project';
            $this->load->view( 'template', $data );
		}
		else
		{
            $accesslevel=$this->input->post('accesslevel');
            $projectid=$this->input->post('id');
			if($this->project_model->createprojectaccesslevel($accesslevel,$projectid)==0)
			$data['alerterror']="New Accesslevel could not be created.";
			else
			$data['alertsuccess']="Accesslevel created Successfully.";
			$data['redirect']="site/viewprojectaccesslevel?id=".$projectid;
			$this->load->view("redirect",$data);
		}
	}
    
    
	function editprojectaccesslevel()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->project_model->beforeeditaccesslevel($this->input->get('projectaccesslevelid'));
		$data['page']='editprojectaccesslevel';
		$data['title']='Edit project Accesslevel';
		$this->load->view('template',$data);
	}
	function editprojectaccesslevelsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('accesslevel','accesslevel','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->project_model->beforeeditaccesslevel($this->input->get('projectaccesslevelid'));
            $data['page']='editprojectaccesslevel';
            $data['title']='Edit project Accesslevel';
            $this->load->view('template',$data);
		}
		else
		{
            
            $projectid=$this->input->get_post('id');
            
            $accesslevel=$this->input->post('accesslevel');
            $projectaccesslevelid=$this->input->post('projectaccesslevelid');
			if($this->project_model->editprojectaccesslevel($projectid,$accesslevel,$projectaccesslevelid)==0)
			$data['alerterror']="project Accesslevel Editing was unsuccesful";
			else
			$data['alertsuccess']="project Accesslevel edited Successfully.";
			
			$data['redirect']="site/viewprojectaccesslevel?id=".$projectid;
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deleteprojectaccesslevel()
	{
		$access = array("1");
		$this->checkaccess($access);
        $projectid=$this->input->get('id');
		$this->project_model->deleteprojectaccesslevel($this->input->get('projectaccesslevelid'));
		$data['alertsuccess']="project Deleted Successfully";
		$data['redirect']="site/viewprojectaccesslevel?id=".$projectid;
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
    //table
    
    function viewtable()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewtable';
        $data['base_url'] = site_url("site/viewtablejson");
        
		$data['title']='View table';
		$this->load->view('template',$data);
	} 
    function viewtablejson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`table`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`table`.`tablename`";
        $elements[1]->sort="1";
        $elements[1]->header="Table Name";
        $elements[1]->alias="tablename";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`project`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="projectname";
        $elements[2]->alias="projectname";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `table` LEFT OUTER JOIN `project` ON `project`.`id`=`table`.`project`");
        
		$this->load->view("json",$data);
	} 
    
    
    public function createtable()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['project']=$this->project_model->getprojectdropdown();
		$data[ 'page' ] = 'createtable';
		$data[ 'title' ] = 'Create table';
		$this->load->view( 'template', $data );	
	}
	function createtablesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('tablename','tablename','trim|required');
		$this->form_validation->set_rules('project','project','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['project']=$this->project_model->getprojectdropdown();
            $data[ 'page' ] = 'createtable';
            $data[ 'title' ] = 'Create table';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $project=$this->input->post('project');
            $tablename=$this->input->post('tablename');
			if($this->table_model->createtable($project,$tablename)==0)
			$data['alerterror']="New Table could not be created.";
			else
			$data['alertsuccess']="Table created Successfully.";
			$data['redirect']="site/viewtable";
			$this->load->view("redirect",$data);
		}
	}
    
    
	function edittable()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->table_model->beforeedit($this->input->get('id'));
		$data['project']=$this->project_model->getprojectdropdown();
		$data['page']='edittable';
		$data['title']='Edit project Accesslevel';
		$this->load->view('template',$data);
	}
	function edittablesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('tablename','tablename','trim|required');
		$this->form_validation->set_rules('project','project','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->table_model->beforeedit($this->input->get('id'));
            $data['project']=$this->project_model->getprojectdropdown();
            $data['page']='edittable';
            $data['title']='Edit project Accesslevel';
            $this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            
            $project=$this->input->post('project');
            $tablename=$this->input->post('tablename');
            
			if($this->table_model->edittable($id,$project,$tablename)==0)
			$data['alerterror']="Table Editing was unsuccesful";
			else
			$data['alertsuccess']="Table edited Successfully.";
			
			$data['redirect']="site/viewtable";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletetable()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->table_model->deletetable($this->input->get('id'));
		$data['alertsuccess']="table Deleted Successfully";
		$data['redirect']="site/viewtable";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
    
    //project
    
    function viewfield()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewfield';
        $data['base_url'] = site_url("site/viewfieldjson");
        
		$data['title']='View field';
		$this->load->view('template',$data);
	} 
    function viewfieldjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`field`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`table`.`tablename`";
        $elements[1]->sort="1";
        $elements[1]->header="tablename";
        $elements[1]->alias="tablename";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`field`.`sqlname`";
        $elements[2]->sort="1";
        $elements[2]->header="sqlname";
        $elements[2]->alias="sqlname";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`field`.`sqltype`";
        $elements[3]->sort="1";
        $elements[3]->header="sqltype";
        $elements[3]->alias="sqltype";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`field`.`isprimary`";
        $elements[4]->sort="1";
        $elements[4]->header="isprimary";
        $elements[4]->alias="isprimary";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`field`.`defaultvalue`";
        $elements[5]->sort="1";
        $elements[5]->header="defaultvalue";
        $elements[5]->alias="defaultvalue";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`field`.`isnull`";
        $elements[6]->sort="1";
        $elements[6]->header="isnull";
        $elements[6]->alias="isnull";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`field`.`autoincrement`";
        $elements[7]->sort="1";
        $elements[7]->header="autoincrement";
        $elements[7]->alias="autoincrement";
       
        
        $elements[8]=new stdClass();
        $elements[8]->field="`field`.`title`";
        $elements[8]->sort="1";
        $elements[8]->header="title";
        $elements[8]->alias="title";
       
        $elements[9]=new stdClass();
        $elements[9]->field="`field`.`type`";
        $elements[9]->sort="1";
        $elements[9]->header="type";
        $elements[9]->alias="type";
       
        $elements[10]=new stdClass();
        $elements[10]->field="`field`.`placeholder`";
        $elements[10]->sort="1";
        $elements[10]->header="placeholder";
        $elements[10]->alias="placeholder";
       
        
        $elements[11]=new stdClass();
        $elements[11]->field="`field`.`showinview`";
        $elements[11]->sort="1";
        $elements[11]->header="showinview";
        $elements[11]->alias="showinview";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `field` LEFT OUTER JOIN `table` ON `table`.`id`=`field`.`table`");
        
		$this->load->view("json",$data);
	} 
    
    
    public function createfield()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['table']=$this->table_model->gettabledropdown();
        $data['isprimary']=$this->field_model->getisprimarydropdown();
        $data['isnull']=$this->field_model->getisnulldropdown();
        $data['isdefault']=$this->field_model->getisdefaultdropdown();
        $data['autoincrement']=$this->field_model->getautoincrementdropdown();
        $data['type']=$this->field_model->getfieldtypedropdown();
        $data['sqltype']=$this->field_model->getsqltypedropdown();
		$data[ 'page' ] = 'createfield';
		$data[ 'title' ] = 'Create field';
		$this->load->view( 'template', $data );	
	}
	function createfieldsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('table','table','trim|required');
		$this->form_validation->set_rules('sqlname','sqlname','trim');
		$this->form_validation->set_rules('sqltype','sqltype','trim');
		$this->form_validation->set_rules('isprimary','isprimary','trim');
		$this->form_validation->set_rules('defaultvalue','defaultvalue','trim');
		$this->form_validation->set_rules('isnull','isnull','trim');
		$this->form_validation->set_rules('autoincrement','autoincrement','trim');
		$this->form_validation->set_rules('title','title','trim');
		$this->form_validation->set_rules('type','type','trim');
		$this->form_validation->set_rules('placeholder','placeholder','trim');
		$this->form_validation->set_rules('showinview','showinview','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['table']=$this->table_model->gettabledropdown();
            $data['isprimary']=$this->field_model->getisprimarydropdown();
            $data['isnull']=$this->field_model->getisnulldropdown();
            $data['isdefault']=$this->field_model->getisdefaultdropdown();
            $data['autoincrement']=$this->field_model->getautoincrementdropdown();
            $data['type']=$this->field_model->getfieldtypedropdown();
            $data['sqltype']=$this->field_model->getsqltypedropdown();
            $data[ 'page' ] = 'createfield';
            $data[ 'title' ] = 'Create field';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $table=$this->input->post('table');
            $sqlname=$this->input->post('sqlname');
            $sqltype=$this->input->post('sqltype');
            $isprimary=$this->input->post('isprimary');
            $defaultvalue=$this->input->post('defaultvalue');
            $isnull=$this->input->post('isnull');
            $autoincrement=$this->input->post('autoincrement');
            $title=$this->input->post('title');
            $type=$this->input->post('type');
            $placeholder=$this->input->post('placeholder');
            $showinview=$this->input->post('showinview');
			if($this->field_model->createfield($table,$sqlname,$sqltype,$isprimary,$defaultvalue,$isnull,$autoincrement,$title,$type,$placeholder,$showinview)==0)
			$data['alerterror']="New field could not be created.";
			else
			$data['alertsuccess']="field created Successfully.";
			$data['redirect']="site/viewfield";
			$this->load->view("redirect",$data);
		}
	}
    
    
	function editfield()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->field_model->beforeedit($this->input->get('id'));
        
        $data['table']=$this->table_model->gettabledropdown();
        $data['isprimary']=$this->field_model->getisprimarydropdown();
        $data['isnull']=$this->field_model->getisnulldropdown();
        $data['isdefault']=$this->field_model->getisdefaultdropdown();
        $data['autoincrement']=$this->field_model->getautoincrementdropdown();
        $data['type']=$this->field_model->getfieldtypedropdown();
        $data['sqltype']=$this->field_model->getsqltypedropdown();
        
		$data['title']='Edit Field';
		$data['page']='editfield';
		$data['page2']='block/fieldblock';
		$this->load->view('templatewith2',$data);
	}
	function editfieldsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('table','table','trim|required');
		$this->form_validation->set_rules('sqlname','sqlname','trim');
		$this->form_validation->set_rules('sqltype','sqltype','trim');
		$this->form_validation->set_rules('isprimary','isprimary','trim');
		$this->form_validation->set_rules('defaultvalue','defaultvalue','trim');
		$this->form_validation->set_rules('isnull','isnull','trim');
		$this->form_validation->set_rules('autoincrement','autoincrement','trim');
		$this->form_validation->set_rules('title','title','trim');
		$this->form_validation->set_rules('type','type','trim');
		$this->form_validation->set_rules('placeholder','placeholder','trim');
		$this->form_validation->set_rules('showinview','showinview','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->field_model->beforeedit($this->input->get('id'));
            
            $data['table']=$this->table_model->gettabledropdown();
            $data['isprimary']=$this->field_model->getisprimarydropdown();
            $data['isnull']=$this->field_model->getisnulldropdown();
            $data['isdefault']=$this->field_model->getisdefaultdropdown();
            $data['autoincrement']=$this->field_model->getautoincrementdropdown();
            $data['type']=$this->field_model->getfieldtypedropdown();
            $data['sqltype']=$this->field_model->getsqltypedropdown();
            
            $data['title']='Edit Field';
            $data['page']='editfield';
            $this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            
            $table=$this->input->post('table');
            $sqlname=$this->input->post('sqlname');
            $sqltype=$this->input->post('sqltype');
            $isprimary=$this->input->post('isprimary');
            $defaultvalue=$this->input->post('defaultvalue');
            $isnull=$this->input->post('isnull');
            $autoincrement=$this->input->post('autoincrement');
            $title=$this->input->post('title');
            $type=$this->input->post('type');
            $placeholder=$this->input->post('placeholder');
            $showinview=$this->input->post('showinview');
            
			if($this->field_model->editfield($id,$table,$sqlname,$sqltype,$isprimary,$defaultvalue,$isnull,$autoincrement,$title,$type,$placeholder,$showinview)==0)
			$data['alerterror']="field Editing was unsuccesful";
			else
			$data['alertsuccess']="field edited Successfully.";
			
			$data['redirect']="site/viewfield";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletefield()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->field_model->deletefield($this->input->get('id'));
		$data['alertsuccess']="field Deleted Successfully";
		$data['redirect']="site/viewfield";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
    //page
    
    function viewpage()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewpage';
        $data['base_url'] = site_url("site/viewpagejson");
        
		$data['title']='View page';
		$this->load->view('template',$data);
	} 
    function viewpagejson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`page`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`table`.`tablename`";
        $elements[1]->sort="1";
        $elements[1]->header="tablename";
        $elements[1]->alias="tablename";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`page`.`navigationname`";
        $elements[2]->sort="1";
        $elements[2]->header="navigationname";
        $elements[2]->alias="navigationname";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`page`.`navigationtype`";
        $elements[3]->sort="1";
        $elements[3]->header="navigationtype";
        $elements[3]->alias="navigationtype";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`page`.`navigationparent`";
        $elements[4]->sort="1";
        $elements[4]->header="navigationparent";
        $elements[4]->alias="navigationparent";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`page`.`crudtype`";
        $elements[5]->sort="1";
        $elements[5]->header="crudtype";
        $elements[5]->alias="crudtype";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`crudtype`.`name`";
        $elements[5]->sort="1";
        $elements[5]->header="crudtypename";
        $elements[5]->alias="crudtypename";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `page` LEFT OUTER JOIN `table` ON `table`.`id`=`page`.`table` LEFT OUTER JOIN `crudtype` ON `crudtype`.`id`=`page`.`crudtype`");
        
		$this->load->view("json",$data);
	} 
    
    public function createpage()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['crudtype']=$this->page_model->getcrudtypedropdown();
        $data['table']=$this->table_model->gettabledropdown();
		$data[ 'page' ] = 'createpage';
		$data[ 'title' ] = 'Create page';
		$this->load->view( 'template', $data );	
	}
	function createpagesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('table','table','trim|required');
		$this->form_validation->set_rules('navigationname','navigationname','trim');
		$this->form_validation->set_rules('navigationtype','navigationtype','trim');
		$this->form_validation->set_rules('navigationparent','navigationparent','trim');
		$this->form_validation->set_rules('crudtype','crudtype','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['crudtype']=$this->page_model->getcrudtypedropdown();
            $data['table']=$this->table_model->gettabledropdown();
            $data[ 'page' ] = 'createpage';
            $data[ 'title' ] = 'Create page';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $table=$this->input->post('table');
            $navigationname=$this->input->post('navigationname');
            $navigationtype=$this->input->post('navigationtype');
            $navigationparent=$this->input->post('navigationparent');
            $crudtype=$this->input->post('crudtype');
//            $accesslevel=$this->input->post('accesslevel');
			if($this->page_model->createpage($table,$navigationname,$navigationtype,$navigationparent,$crudtype)==0)
			$data['alerterror']="New page could not be created.";
			else
			$data['alertsuccess']="page created Successfully.";
			$data['redirect']="site/viewpage";
			$this->load->view("redirect",$data);
		}
	}
    
	function editpage()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->page_model->beforeedit($this->input->get('id'));
		$data['crudtype']=$this->page_model->getcrudtypedropdown();
//		$data['selectedcrudtype']=$this->page_model->getselectedcrudtypedropdown();
        $data['table']=$this->table_model->gettabledropdown();
		$data['page']='editpage';
		$data['page2']='block/pageblock';
		$data['title']='Edit page';
		$this->load->view('templatewith2',$data);
	}
	function editpagesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('databasename','databasename','trim');
		$this->form_validation->set_rules('databasepassword','databasepassword','trim');
		$this->form_validation->set_rules('hostname','hostname','trim');
		$this->form_validation->set_rules('userpassword','userpassword','trim');
		$this->form_validation->set_rules('mandrillid','mandrillid','trim');
		$this->form_validation->set_rules('mandrillpassword','mandrillpassword','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->project_model->getstatusdropdown();
			$data['accesslevel']=$this->project_model->getaccesslevels();
            $data[ 'logintype' ] =$this->project_model->getlogintypedropdown();
			$data['before']=$this->project_model->beforeedit($this->input->post('id'));
			$data['page']='editproject';
//			$data['page2']='block/projectblock';
			$data['title']='Edit project';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $databasename=$this->input->post('databasename');
            $databasepassword=$this->input->post('databasepassword');
            $hostname=$this->input->post('hostname');
            $userpassword=$this->input->post('userpassword');
            $mandrillid=$this->input->post('mandrillid');
            $mandrillpassword=$this->input->post('mandrillpassword');
            
			if($this->project_model->edit($id,$name,$email,$databasename,$databasepassword,$hostname,$userpassword,$mandrillid,$mandrillpassword)==0)
			$data['alerterror']="project Editing was unsuccesful";
			else
			$data['alertsuccess']="project edited Successfully.";
			
			$data['redirect']="site/viewproject";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
     
    function viewpageaccesslevel()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewpageaccesslevel';
        $id=$this->input->get('id');
        $data['base_url'] = site_url("site/viewpageaccessleveljson?id=").$this->input->get('id');
        
		$data['title']='View project';
		$this->load->view('template',$data);
	} 
    function viewpageaccessleveljson()
	{
        $id=$this->input->get('id');
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`pageaccesslevel`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`pageaccesslevel`.`accesslevel`";
        $elements[1]->sort="1";
        $elements[1]->header="accesslevel";
        $elements[1]->alias="accesslevel";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`pageaccesslevel`.`page`";
        $elements[2]->sort="1";
        $elements[2]->header="page";
        $elements[2]->alias="page";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `pageaccesslevel`","WHERE `pageaccesslevel`.`page`='$id'");
        
		$this->load->view("json",$data);
	} 
    
    public function createpageaccesslevel()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createpageaccesslevel';
		$data[ 'title' ] = 'Create pageaccesslevel';
		$this->load->view( 'template', $data );	
	}
	function createpageaccesslevelsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('accesslevel','accesslevel','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createproject';
            $data[ 'title' ] = 'Create project';
            $this->load->view( 'template', $data );
		}
		else
		{
            $accesslevel=$this->input->post('accesslevel');
            $pageid=$this->input->post('id');
			if($this->page_model->createpageaccesslevel($accesslevel,$pageid)==0)
			$data['alerterror']="New Accesslevel could not be created.";
			else
			$data['alertsuccess']="Accesslevel created Successfully.";
			$data['redirect']="site/viewpageaccesslevel?id=".$pageid;
			$this->load->view("redirect",$data);
		}
	}
    
    
	function editpageaccesslevel()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->page_model->beforeeditaccesslevel($this->input->get('pageaccesslevelid'));
		$data['page']='editpageaccesslevel';
		$data['title']='Edit project Accesslevel';
		$this->load->view('template',$data);
	}
	function editpageaccesslevelsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('accesslevel','accesslevel','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->page_model->beforeeditaccesslevel($this->input->get('pageaccesslevelid'));
            $data['page']='editpageaccesslevel';
            $data['title']='Edit project Accesslevel';
            $this->load->view('template',$data);
		}
		else
		{
            
            $pageid=$this->input->get_post('id');
            
            $accesslevel=$this->input->post('accesslevel');
            $pageaccesslevelid=$this->input->post('pageaccesslevelid');
			if($this->page_model->editpageaccesslevel($pageid,$accesslevel,$pageaccesslevelid)==0)
			$data['alerterror']="project Accesslevel Editing was unsuccesful";
			else
			$data['alertsuccess']="project Accesslevel edited Successfully.";
			
			$data['redirect']="site/viewpageaccesslevel?id=".$pageid;
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletepageaccesslevel()
	{
		$access = array("1");
		$this->checkaccess($access);
        $pageid=$this->input->get('id');
		$this->page_model->deletepageaccesslevel($this->input->get('pageaccesslevelid'));
		$data['alertsuccess']="Page Deleted Successfully";
		$data['redirect']="site/viewpageaccesslevel?id=".$pageid;
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
    
    //fieldselectfield
    
    function viewfieldselectfield()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewfieldselectfield';
        $id=$this->input->get('id');
        $data['base_url'] = site_url("site/viewfieldselectfieldjson?id=").$this->input->get('id');
        
		$data['title']='View project';
		$this->load->view('template',$data);
	} 
    function viewfieldselectfieldjson()
	{
        $id=$this->input->get('id');
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`fieldselectfield`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`fieldselectfield`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`fieldselectfield`.`field`";
        $elements[2]->sort="1";
        $elements[2]->header="field";
        $elements[2]->alias="field";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`fieldselectfield`.`value`";
        $elements[3]->sort="1";
        $elements[3]->header="value";
        $elements[3]->alias="value";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fieldselectfield`","WHERE `fieldselectfield`.`field`='$id'");
        
		$this->load->view("json",$data);
	} 
    
    public function createfieldselectfield()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createfieldselectfield';
		$data[ 'title' ] = 'Create fieldselectfield';
		$this->load->view( 'template', $data );	
	}
	function createfieldselectfieldsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','name','trim|required');
		$this->form_validation->set_rules('value','value','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createfieldselectfield';
            $data[ 'title' ] = 'Create fieldselectfield';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $value=$this->input->post('value');
            $fieldid=$this->input->post('id');
			if($this->field_model->createfieldselectfield($name,$value,$fieldid)==0)
			$data['alerterror']="New Field could not be created.";
			else
			$data['alertsuccess']="Field created Successfully.";
			$data['redirect']="site/viewfieldselectfield?id=".$fieldid;
			$this->load->view("redirect",$data);
		}
	}
    
    
	function editfieldselectfield()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->field_model->beforeeditfieldselectfield($this->input->get('fieldselectfieldid'));
		$data['page']='editfieldselectfield';
		$data['title']='Edit Field Select Field';
		$this->load->view('template',$data);
	}
	function editfieldselectfieldsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','name','trim|required');
		$this->form_validation->set_rules('value','value','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->field_model->beforeeditfieldselectfield($this->input->get('fieldselectfieldid'));
            $data['page']='editfieldselectfield';
            $data['title']='Edit Field Select Field';
            $this->load->view('template',$data);
		}
		else
		{
            
            $fieldid=$this->input->get_post('id');
            
            $name=$this->input->post('name');
            $value=$this->input->post('value');
            $fieldselectfieldid=$this->input->post('fieldselectfieldid');
			if($this->field_model->editfieldselectfield($fieldid,$name,$value,$fieldselectfieldid)==0)
			$data['alerterror']="Field Select Field Editing was unsuccesful";
			else
			$data['alertsuccess']="Field Select Field edited Successfully.";
			
			$data['redirect']="site/viewfieldselectfield?id=".$fieldid;
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletefieldselectfield()
	{
		$access = array("1");
		$this->checkaccess($access);
        $fieldid=$this->input->get('id');
		$this->field_model->deletefieldselectfield($this->input->get('fieldselectfieldid'));
		$data['alertsuccess']="field Deleted Successfully";
		$data['redirect']="site/viewfieldselectfield?id=".$fieldid;
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
    //fieldvalidation
    
    function viewfieldvalidation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewfieldvalidation';
        $id=$this->input->get('id');
        $data['base_url'] = site_url("site/viewfieldvalidationjson?id=").$this->input->get('id');
        
		$data['title']='View project';
		$this->load->view('template',$data);
	} 
    function viewfieldvalidationjson()
	{
        $id=$this->input->get('id');
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`fieldvalidation`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`fieldvalidation`.`validation`";
        $elements[1]->sort="1";
        $elements[1]->header="name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`fieldvalidation`.`field`";
        $elements[2]->sort="1";
        $elements[2]->header="field";
        $elements[2]->alias="field";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fieldvalidation`","WHERE `fieldvalidation`.`field`='$id'");
        
		$this->load->view("json",$data);
	} 
    
    public function createfieldvalidation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createfieldvalidation';
		$data[ 'title' ] = 'Create fieldvalidation';
		$this->load->view( 'template', $data );	
	}
	function createfieldvalidationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('validation','validation','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createfieldvalidation';
            $data[ 'title' ] = 'Create fieldvalidation';
            $this->load->view( 'template', $data );
		}
		else
		{
            $validation=$this->input->post('validation');
            $fieldid=$this->input->post('id');
            
			if($this->field_model->createfieldvalidation($validation,$fieldid)==0)
			$data['alerterror']="New Field could not be created.";
			else
			$data['alertsuccess']="Field created Successfully.";
			$data['redirect']="site/viewfieldvalidation?id=".$fieldid;
			$this->load->view("redirect",$data);
		}
	}
    
    
	function editfieldvalidation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->field_model->beforeeditfieldvalidation($this->input->get('fieldvalidationid'));
		$data['page']='editfieldvalidation';
		$data['title']='Edit Field Select Field';
		$this->load->view('template',$data);
	}
	function editfieldvalidationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('validation','validation','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['before']=$this->field_model->beforeeditfieldvalidation($this->input->get('fieldvalidationid'));
            $data['page']='editfieldvalidation';
            $data['title']='Edit Field Select Field';
            $this->load->view('template',$data);
		}
		else
		{
            
            $fieldid=$this->input->get_post('id');
            
            $validation=$this->input->post('validation');
            $fieldvalidationid=$this->input->post('fieldvalidationid');
			if($this->field_model->editfieldvalidation($fieldid,$validation,$fieldvalidationid)==0)
			$data['alerterror']="Field Select Field Editing was unsuccesful";
			else
			$data['alertsuccess']="Field Select Field edited Successfully.";
			
			$data['redirect']="site/viewfieldvalidation?id=".$fieldid;
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletefieldvalidation()
	{
		$access = array("1");
		$this->checkaccess($access);
        $fieldid=$this->input->get('id');
		$this->field_model->deletefieldvalidation($this->input->get('fieldvalidationid'));
		$data['alertsuccess']="field Validation Deleted Successfully";
		$data['redirect']="site/viewfieldvalidation?id=".$fieldid;
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
    
    //git
    
	function executeproject()
	{
        
        
		$access = array("1");
		$this->checkaccess($access);
        $id=$this->input->get('id');
        
        $project=$this->project_model->beforeedit($id);  //calling model for getting details right1
        
        $projectid=$id;
        $databasename=$project->name;
        $this->load->dbforge();
        
        $tablenames=$this->admin_model->gettablebyproject($id); //right2
        
        foreach ($tablenames as $rowtable)
        {
            $tableid=$rowtable->id;
            $tablename=$rowtable->tablename;
            
            $allfields=$this->admin_model->getallfieldsbytable($tableid); //right3
            
            $fields=array();
            
           foreach($allfields as $fieldrow)
            {
                        $id=$fieldrow->id;
                        $sqlname=$fieldrow->sqlname;
                        $type=$fieldrow->sqltypename;
                        $isprimary=$fieldrow->isprimary;
                        $autoincrement=$fieldrow->autoincrement;
                        
                        $fields[$sqlname]= array('type' => $type);
                
//                        $fields[$sqlname]= array();
                        $fields[$sqlname]["type"]= $type;
                        if($type=='int')
                        {     
                            $fields[$sqlname]["constraint"]= 11;
                        }
                        else if($type=='varchar')
                        {
                            $fields[$sqlname]["constraint"]= 255;
                        }
                        if($isprimary=='TRUE')
                        {
                            $this->dbforge->add_key($sqlname, TRUE);
                        }
                        if($autoincrement=='TRUE')
                        {
                            $fields[$sqlname]["auto_increment"]= TRUE;
                        }
             }
//            print_r($fields);
            
            $this->dbforge->add_field($fields);
            $this->dbforge->create_table($databasename."_".$tablename);
            
           
        
        }
    
//         for git only    
//        echo shell_exec("git clone https://github.com/avinashghare/createO.git");
//        echo shell_exec("mv createO $databasename");
//        echo shell_exec("mv $databasename admins");
        
        $this->executeprojectoptimize($projectid);
//        $this->executeproject1($projectid);
            
	}
    
    
	public function executeprojectoptimize($id)
    {
//        $id=$this->input->get("id");
        
        $project=$this->project_model->beforeedit($id); //right1
        $databasename=$project->name;
        $this->load->dbforge();
        $modelcreatorreturn=$this->admin_model->modelcreator($id);
        $controllercreatorreturn=$this->admin_model->controllercreator($id);
        $jsoncreatorreturn=$this->admin_model->jsoncreator($id);
        $viewpagecreatorreturn=$this->admin_model->viewpagecreator($id);
        $createpagecreatorreturn=$this->admin_model->createpagecreator($id);
        $editpagecreatorreturn=$this->admin_model->editpagecreator($id);
        
        $otherappendsreturn=$this->admin_model->otherappends($id);
        
//        $data['alertsuccess']="Basic Backend Panel created Successfully.";
//		$data['redirect']="site/index";
//		$this->load->view("redirect",$data);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
//	function executeproject1()
	function executeproject1($id)
	{
        
        
		$access = array("1");
		$this->checkaccess($access);
        
        
//        $id=$this->input->get('id');
        
//        $project=$this->db->query("SELECT * FROM `project` WHERE `id`='$id'")->row(); //wrong1
        $project=$this->project_model->beforeedit($id); //right1
        $databasename=$project->name;
        $this->load->dbforge();
        
        
        
//        $tablenames=$this->db->query("SELECT * FROM `table` WHERE `project`='$id'")->result(); //wrong2
        $tablenames=$this->admin_model->gettablebyproject($id); //right2
//        print_r($tablenames);
        $alljson="";
        $alljson.='<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{';
        
    $controller="";
        
		$urlforcontrollertest=$_SERVER["SCRIPT_FILENAME"];
        $urlforcontrollertest=substr($urlforcontrollertest,0,-9);
        $urlcontrollertest=$urlforcontrollertest.'admins/'.$databasename.'/application/controllers/site.php';
        
        $controllerfile=read_file($urlcontrollertest);
        $controllerfile=substr($controllerfile,0,-5);
        $controller.=$controllerfile;
        
        
        foreach ($tablenames as $rowtable)
        {
//            echo $rowtable->id;
            $tableid=$rowtable->id;
            $tablename=$rowtable->tablename;
            //wrong3 start
//        $allfields=$this->db->query("SELECT `field`.`id`, `field`.`table`, `field`.`sqlname`, `field`.`sqltype`, `field`.`isprimary`, `field`.`defaultvalue`, `field`.`isnull`, `field`.`autoincrement`, `field`.`title`, `field`.`type`, `field`.`placeholder`, `field`.`showinview`,`sqltype`.`name` AS `sqltypename`,`fieldtype`.`name` AS `fieldtypename`,`table`.`tablename` AS `tablename`
//FROM `field`
//LEFT OUTER JOIN `table` ON `field`.`table`=`table`.`id`
//LEFT OUTER JOIN `sqltype` ON `field`.`sqltype`=`sqltype`.`id`
//LEFT OUTER JOIN `fieldtype` ON `field`.`type`=`fieldtype`.`id` WHERE `field`.`table`='$tableid'")->result();
            //wrong3 end
            $allfields=$this->admin_model->getallfieldsbytable($tableid); //right3
            
            //for viewtable
//            echo "public function view".$tablename."()\n";
//            echo "{\n";
//            echo '$access=array("1");'."\n";
//            echo '$this->checkaccess($access);'."\n";
//            echo '$data["page"]="view'.$tablename.'";'."\n";
//            echo '$data["base_url"]=site_url("site/view'.$tablename.'json");'."\n";
//            echo '$data["title"]="View '.$tablename.'";'."\n";
//            echo '$this->load->view("template",$data);'."\n";
//            echo "}\n";
            
//            $controller="";
            $controller.="public function view".$tablename."()\n";
            $controller.="{\n";
            $controller.='$access=array("1");'."\n";
//            echo $controller;
            $controller.='$this->checkaccess($access);'."\n";
            $controller.='$data["page"]="view'.$tablename.'";'."\n";
            $controller.='$data["base_url"]=site_url("site/view'.$tablename.'json");'."\n";
            $controller.='$data["title"]="View '.$tablename.'";'."\n";
            $controller.='$this->load->view("template",$data);'."\n";
            $controller.="}\n";
            
            
            $controller.='function view'.$tablename.'json()'."\n";
            $controller.="{\n";
            $j=0;
            
            $controller.='$elements=array();'."\n";
            foreach($allfields as $fieldrow)
            {
                        $id=$fieldrow->id;
                        $sqlname=$fieldrow->sqlname;
                        $title=$fieldrow->title;
                        $type=$fieldrow->sqltypename;
                        $isprimary=$fieldrow->isprimary;
                        $autoincrement=$fieldrow->autoincrement;
                $controller.='$elements['.$j.']=new stdClass();'."\n";
                $controller.='$elements['.$j.']->field="`'.$databasename."_".$tablename.'`.`'.$sqlname.'`";'."\n";
                $controller.='$elements['.$j.']->sort="1";'."\n";
                $controller.='$elements['.$j.']->header="'.$title.'";'."\n";
                $controller.='$elements['.$j.']->alias="'.$sqlname.'";'."\n";
                
               $j++;
             }
            
            $controller.='$search=$this->input->get_post("search");'."\n";
            $controller.='$pageno=$this->input->get_post("pageno");'."\n";
            $controller.='$orderby=$this->input->get_post("orderby");'."\n";
            $controller.='$orderorder=$this->input->get_post("orderorder");'."\n";
            $controller.='$maxrow=$this->input->get_post("maxrow");'."\n";
            
            $controller.='if($maxrow=="")'."\n";
            $controller.='{'."\n";
            $controller.='$maxrow=20;'."\n";
            $controller.='}'."\n";
            $controller.='if($orderby=="")'."\n";
            $controller.='{'."\n";
            $controller.='$orderby="id";'."\n";
            $controller.='$orderorder="ASC";'."\n";
            $controller.='}'."\n";
            
            $controller.= '$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `'.$databasename."_".$tablename.'`");'."\n";
            
            $controller.='$this->load->view("json",$data);'."\n";
            $controller.= "}\n\n";
         
//            echo $controller;
            //create 
            
            $controller.='public function create'.$tablename."()"."\n";
            $controller.='{'."\n";
            $controller.='$access=array("1");'."\n";
            $controller.='$this->checkaccess($access);'."\n";
            $controller.='$data["page"]="create'.$tablename.'";'."\n";
            $controller.='$data["title"]="Create '.$tablename.'";'."\n";
            $controller.='$this->load->view("template",$data);'."\n";
            $controller.='}'."\n";
            
            //createsubmit
            
            $controller.='public function create'.$tablename.'submit() '."\n";
            $controller.='{'."\n";
            $controller.='$access=array("1");'."\n";
            $controller.='$this->checkaccess($access);'."\n";
            
            foreach($allfields as $fieldrow)
            {
                        $id=$fieldrow->id;
                        $sqlname=$fieldrow->sqlname;
                        $title=$fieldrow->title;
                        $type=$fieldrow->sqltypename;
                        $isprimary=$fieldrow->isprimary;
                        $autoincrement=$fieldrow->autoincrement;
                        
                        if($fieldrow->sqlname=='id')
                        {
                        }
                        elseif($fieldrow->sqltype== 10)
                        {
                            $controller.='Hello image is arrived'."\n";
                        }
                        else
                        {
                            $controller.='$this->form_validation->set_rules("'.$sqlname.'","'.$title.'","trim");'."\n";
                        }
                
             }
            $controller.='if($this->form_validation->run()==FALSE)'."\n";
            $controller.='{'."\n";
                $controller.='$data["alerterror"]=validation_errors();'."\n";
                $controller.='$data["page"]="create'.$tablename.'";'."\n";
                $controller.='$data["title"]="Create '.$tablename.'";'."\n";
                $controller.='$this->load->view("template",$data);'."\n";
            $controller.='}'."\n";
            $controller.='else'."\n";
            $controller.='{'."\n";
                foreach($allfields as $fieldrow)
                {
                            $id=$fieldrow->id;
                            $sqlname=$fieldrow->sqlname;
                            $title=$fieldrow->title;
                            $fieldtype=$fieldrow->type;
                            $type=$fieldrow->sqltypename;
                            $isprimary=$fieldrow->isprimary;
                            $autoincrement=$fieldrow->autoincrement;
                            
                        if($fieldrow->sqlname=='id')
                        {
                        }
//                        else if($fieldtype== 10)
//                        {
//                            $controller.='$config["upload_path"] = "./uploads/";';
//                            $controller.='$config["allowed_types"] = "gif|jpg|png|jpeg";';
//                            $controller.='$this->load->library("upload", $config);';
//                            $controller.='$filename="'.$sqlname.'"';
//                            $controller.='$'.$sqlname.'="";';
//                            $controller.='if (  $this->upload->do_upload($filename))';
//                            $controller.='{';
//                                $controller.='$uploaddata = $this->upload->data();';
//                                $controller.='$'.$sqlname.'=$uploaddata["file_name"];';
//                                $controller.='$config_r["source_image"]   = "./uploads/" . $uploaddata["file_name"];';
//                                $controller.='$config_r["maintain_ratio"] = TRUE;';
//                                $controller.='$config_t["create_thumb"] = FALSE;';
//                                $controller.='$config_r["width"]   = 600;';
//                                $controller.='$config_r["height"]   = 600;';
//                                $controller.='$config_r["quality"]   = 100;';
//                                $controller.='$this->load->library("image_lib", $config_r);';
//                                $controller.='$this->image_lib->initialize($config_r);';
//                                $controller.='if(!$this->image_lib->resize())';
//                                $controller.='{';
//                                    $controller.='echo "Failed".$this->image_lib->display_errors();';
//                                $controller.='}';
//                                $controller.='else';
//                                $controller.='{';
//                                    $controller.='$'.$sqlname.'=$this->image_lib->dest_image;';
//                                $controller.='}';
//                            $controller.='}';
//                           
//                        }
                        else
                        {
                            $controller.='$'.$sqlname.'=$this->input->get_post("'.$sqlname.'");'."\n";
                        }

                 }
                $controller.='if($this->'.$tablename.'_model->create(';
            $string="";
                foreach($allfields as $fieldrow)
                {
                            $id=$fieldrow->id;
                            $sqlname=$fieldrow->sqlname;
                            $title=$fieldrow->title;
                            $type=$fieldrow->sqltypename;
                            $isprimary=$fieldrow->isprimary;
                            $autoincrement=$fieldrow->autoincrement;
//                    if(end($allfields))
                    if($fieldrow->sqlname=='id')
                        {
                        }
                    else
                    {
                    $string=$string.'$'.$sqlname.',';
                    }

                 }
                $controller.=rtrim($string, ",");
                $controller.=')==0)'."\n";
                
                $controller.='$data["alerterror"]="New '.$tablename.' could not be created.";'."\n";
                $controller.='else'."\n";
                $controller.='$data["alertsuccess"]="'.$tablename.' created Successfully.";'."\n";
            
                $controller.='$data["redirect"]="site/view'.$tablename.'";'."\n";
                $controller.='$this->load->view("redirect",$data);'."\n";
            $controller.='}'."\n";
            
            
            $controller.='}'."\n";
            
//            echo $controller;
            
            //edit
            
            $controller.='public function edit'.$tablename.'()'."\n";
            $controller.='{'."\n";
            $controller.='$access=array("1");'."\n";
            $controller.='$this->checkaccess($access);'."\n";
            $controller.='$data["page"]="edit'.$tablename.'";'."\n";
            $controller.='$data["title"]="Edit '.$tablename.'";'."\n";
            $controller.='$data["before"]=$this->'.$tablename.'_model->beforeedit($this->input->get("id"));'."\n";
            $controller.='$this->load->view("template",$data);'."\n";
            $controller.='}'."\n";
            
            
            //editsubmit
            
            $controller.='public function edit'.$tablename.'submit()'."\n";
            $controller.='{'."\n";
            $controller.='$access=array("1");'."\n";
            $controller.='$this->checkaccess($access);'."\n";
            
            foreach($allfields as $fieldrow)
            {
                        $id=$fieldrow->id;
                        $sqlname=$fieldrow->sqlname;
                        $title=$fieldrow->title;
                        $type=$fieldrow->sqltypename;
                        $isprimary=$fieldrow->isprimary;
                        $autoincrement=$fieldrow->autoincrement;
                $controller.='$this->form_validation->set_rules("'.$sqlname.'","'.$title.'","trim");'."\n";
                
             }
            $controller.='if($this->form_validation->run()==FALSE)'."\n";
            $controller.='{'."\n";
                $controller.='$data["alerterror"]=validation_errors();'."\n";
                $controller.='$data["page"]="edit'.$tablename.'";'."\n";
                $controller.='$data["title"]="Edit '.$tablename.'";'."\n";
                $controller.='$data["before"]=$this->'.$tablename.'_model->beforeedit($this->input->get("id"));'."\n";
                $controller.='$this->load->view("template",$data);'."\n";
            $controller.='}'."\n";
            $controller.='else'."\n";
            $controller.='{'."\n";
                foreach($allfields as $fieldrow)
                {
                            $id=$fieldrow->id;
                            $sqlname=$fieldrow->sqlname;
                            $title=$fieldrow->title;
                            $type=$fieldrow->sqltypename;
                            $isprimary=$fieldrow->isprimary;
                            $autoincrement=$fieldrow->autoincrement;
                    $controller.='$'.$sqlname.'=$this->input->get_post("'.$sqlname.'");'."\n";

                 }
                $controller.='if($this->'.$tablename.'_model->edit(';
            $string="";
                foreach($allfields as $fieldrow)
                {
                            $id=$fieldrow->id;
                            $sqlname=$fieldrow->sqlname;
                            $title=$fieldrow->title;
                            $type=$fieldrow->sqltypename;
                            $isprimary=$fieldrow->isprimary;
                            $autoincrement=$fieldrow->autoincrement;
//                    if(end($allfields))
                    $string=$string.'$'.$sqlname.',';

                 }
                $controller.=rtrim($string, ",");
                $controller.=')==0)'."\n";
                
                $controller.='$data["alerterror"]="New '.$tablename.' could not be Updated.";'."\n";
                $controller.='else'."\n";
                $controller.='$data["alertsuccess"]="'.$tablename.' Updated Successfully.";'."\n";
            
                $controller.='$data["redirect"]="site/view'.$tablename.'";'."\n";
                $controller.='$this->load->view("redirect",$data);'."\n";
            $controller.='}'."\n";
            
            
            $controller.='}'."\n";
            
            //delete
            
            $controller.='public function delete'.$tablename.'()'."\n";
            $controller.='{'."\n";
            $controller.='$access=array("1");'."\n";
            $controller.='$this->checkaccess($access);'."\n";
            $controller.='$this->'.$tablename.'_model->delete($this->input->get("id"));'."\n";
            $controller.='$data["redirect"]="site/view'.$tablename.'";'."\n";
            $controller.='$this->load->view("redirect",$data);'."\n";
            $controller.='}'."\n";
            
//            echo $controller;
            
            
            //model
            $modeldata='<?php';
            $modeldata.= "\n" .'if ( !defined( "BASEPATH" ) )'."\n".'exit( "No direct script access allowed" );'."\n";
            $modeldata.='class '.$tablename.'_model extends CI_Model'."\n";
            $modeldata.='{'."\n";
            
            //create
                $modeldata.='public function create(';
            $string="";
                    foreach($allfields as $fieldrow)
                        {
                                    $id=$fieldrow->id;
                                    $sqlname=$fieldrow->sqlname;
                                    $title=$fieldrow->title;
                                    $type=$fieldrow->sqltypename;
                                    $isprimary=$fieldrow->isprimary;
                                    $autoincrement=$fieldrow->autoincrement;
                        
									if($fieldrow->sqlname=='id')
                                    {
                                    }
                                    else
                                    {
                                        $string=$string.'$'.$sqlname.',';
                                    }

                 }
                $string=rtrim($string, ",");
            $modeldata.=$string;
                $modeldata.=')'."\n";
                $modeldata.='{'."\n";
                    $modeldata.='$data=array(';
                        $datastring="";
                         foreach($allfields as $fieldrow)
                        {
                                    $id=$fieldrow->id;
                                    $sqlname=$fieldrow->sqlname;
                                    $title=$fieldrow->title;
                                    $type=$fieldrow->sqltypename;
                                    $isprimary=$fieldrow->isprimary;
                                    $autoincrement=$fieldrow->autoincrement;
                             
									if($fieldrow->sqlname=='id')
                                    {
                                    }
                                    else
                                    {
                                        $datastring=$datastring. '"'.$sqlname.'" => $'.$sqlname.',';
                                    }
                            
                         }
                        $datastring=rtrim($datastring, ",");
                        $modeldata.=$datastring;
                    $modeldata.=');'."\n";
                    $modeldata.='$query=$this->db->insert( "'.$databasename."_".$tablename.'", $data );'."\n";
                    $modeldata.='$id=$this->db->insert_id();'."\n";
                    $modeldata.='if(!$query)'."\n".'return  0;'."\n".'else'."\n".'return  $id;'."\n";
                $modeldata.='}'."\n";
            
             
            //beforeedit
            $modeldata.='public function beforeedit($id)'."\n";
                $modeldata.='{'."\n";
                    $modeldata.='$this->db->where("id",$id);'."\n";
                    $modeldata.='$query=$this->db->get("'.$databasename."_".$tablename.'")->row();'."\n";
                    $modeldata.='return $query;'."\n";
                $modeldata.='}'."\n";
            
            //getsingle for json
            $modeldata.='function getsingle'.$tablename.'($id)';
                $modeldata.='{'."\n";
                    $modeldata.='$this->db->where("id",$id);'."\n";
                    $modeldata.='$query=$this->db->get("'.$databasename."_".$tablename.'")->row();'."\n";
                    $modeldata.='return $query;'."\n";
                $modeldata.='}'."\n";
            
            //edit
            $modeldata.='public function edit(';
            $string="";
                    foreach($allfields as $fieldrow)
                        {
                                    $id=$fieldrow->id;
                                    $sqlname=$fieldrow->sqlname;
                                    $title=$fieldrow->title;
                                    $type=$fieldrow->sqltypename;
                                    $isprimary=$fieldrow->isprimary;
                                    $autoincrement=$fieldrow->autoincrement;
                            $string=$string.'$'.$sqlname.',';

                 }
                $string=rtrim($string, ",");
            $modeldata.=$string;
                $modeldata.=')'."\n";
                $modeldata.='{'."\n";
                    $modeldata.='$data=array(';
            $datastring="";
                         foreach($allfields as $fieldrow)
                        {
                                    $id=$fieldrow->id;
                                    $sqlname=$fieldrow->sqlname;
                                    $title=$fieldrow->title;
                                    $type=$fieldrow->sqltypename;
                                    $isprimary=$fieldrow->isprimary;
                                    $autoincrement=$fieldrow->autoincrement;
                                    if($fieldrow->sqlname=='id')
                                    {
                                    }
                                    else
                                    {
                                        $datastring=$datastring. '"'.$sqlname.'" => $'.$sqlname.',';
                                    }
                            
                         }
                        $datastring=rtrim($datastring, ",");
                        $modeldata.=$datastring;
                    $modeldata.=');'."\n";
                    $modeldata.='$this->db->where( "id", $id );'."\n";
                    $modeldata.='$query=$this->db->update( "'.$databasename."_".$tablename.'", $data );'."\n";
                    $modeldata.='return 1;'."\n";
                $modeldata.='}'."\n";
                
            
             //delete
            $modeldata.='public function delete($id)'."\n";
                $modeldata.='{'."\n";
                    $modeldata.='$query=$this->db->query("DELETE FROM `'.$databasename."_".$tablename.'` WHERE `id`=\'$id\'");'."\n";
                    $modeldata.='return $query;'."\n";
                $modeldata.='}'."\n";
            
            $modeldata.='}'."\n";
            
//            echo $modeldata;
            
           //json
			
            //getalljson
            $jsondata="";
            $jsondata.='function getall'.$tablename.'()'."\n";
            $jsondata.='{'."\n";
                $j=0;
                foreach($allfields as $fieldrow)
                {
                            $id=$fieldrow->id;
                            $sqlname=$fieldrow->sqlname;
                            $title=$fieldrow->title;
                            $type=$fieldrow->sqltypename;
                            $isprimary=$fieldrow->isprimary;
                            $autoincrement=$fieldrow->autoincrement;
                    $jsondata.='$elements=array();'."\n";
                    $jsondata.='$elements['.$j.']=new stdClass();'."\n";
                    $jsondata.='$elements['.$j.']->field="`'.$databasename."_".$tablename.'`.`'.$sqlname.'`";'."\n";
                    $jsondata.='$elements['.$j.']->sort="1";'."\n";
                    $jsondata.='$elements['.$j.']->header="'.$title.'";'."\n";
                    $jsondata.='$elements['.$j.']->alias="'.$sqlname.'";'."\n\n";

                   $j++;
                 }
                $jsondata.='$search=$this->input->get_post("search");'."\n";
                $jsondata.='$pageno=$this->input->get_post("pageno");'."\n";
                $jsondata.='$orderby=$this->input->get_post("orderby");'."\n";
                $jsondata.='$orderorder=$this->input->get_post("orderorder");'."\n";
                $jsondata.='$maxrow=$this->input->get_post("maxrow");'."\n";

                $jsondata.='if($maxrow=="")'."\n";
                $jsondata.='{'."\n";
                $jsondata.='}'."\n";
                $jsondata.='if($orderby=="")'."\n";
                $jsondata.='{'."\n";
                $jsondata.='$orderby="id";'."\n";
                $jsondata.='$orderorder="ASC";'."\n";
                $jsondata.='}'."\n";

                $jsondata.='$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `'.$databasename."_".$tablename.'`");'."\n";

                $jsondata.='$this->load->view("json",$data);'."\n";
            $jsondata.='}'."\n";
            
            //getsingle
            $jsondata.='public function getsingle'.$tablename.'()'."\n";
            $jsondata.='{'."\n";
                $jsondata.='$id=$this->input->get_post("id");'."\n";
                $jsondata.='$data["message"]=$this->'.$tablename.'_model->getsingle'.$tablename.'($id);'."\n";
                $jsondata.='$this->load->view("json",$data);'."\n";
            $jsondata.='}'."\n";
           
            $alljson.=$jsondata;
            
            
            
            
            
            
            $url=$_SERVER["SCRIPT_FILENAME"];
            $url=substr($url,0,-9);
            $url.='admins/'.$databasename.'/application/models/'.$tablename.'_model.php';
//            $urljson=$url.'admins/'.$databasename.'/application/controllers/json.php';
//                $url='C:\xampp\htdocs\createOBackend\admins\\'.$databasename.'\application\models\\'.$tablename.'_model.php';
//            echo $url;
           $modeldata.='?>'."\n";
        if ( ! write_file($url, $modeldata))
        {
             echo 'Unable to write the file';
        }
        else
        {
             echo 'File written!';
        }
        
            
            
            
            
             //views
            $viewdata="";
            $viewdata.='<div id="page-title">'."\n";
            $viewdata.='<a class="btn btn-primary btn-labeled fa fa-plus margined pull-right" href="<?php echo site_url("site/create'.$tablename.'"); ?>">Create</a>'."\n";
           $viewdata.='<h1 class="page-header text-overflow">'.$tablename.' Details </h1>'."\n";  
            $viewdata.='</div>'."\n"; 
            
            $viewdata.='<div id="page-content">'."\n"; 
            $viewdata.='<div class="row">'."\n";
	$viewdata.='<div class="col-lg-12">'."\n";
		$viewdata.='<div class="panel drawchintantable">'."\n";
            $viewdata.='<?php $this->chintantable->createsearch("'.$tablename.' List");?>'."\n";
            
		$viewdata.='<div class="fixed-table-container">'."\n";
		$viewdata.='<div class="fixed-table-body">'."\n";
			
            $viewdata.='<table class="table table-hover" id="" cellpadding="0" cellspacing="0">'."\n";
            $viewdata.='<thead>'."\n";
            $viewdata.='<tr>'."\n";
            $string="";
            foreach($allfields as $fieldrow)
                        {
                                    $id=$fieldrow->id;
                                    $sqlname=$fieldrow->sqlname;
                                    $title=$fieldrow->title;
                                    $type=$fieldrow->sqltypename;
                                    $isprimary=$fieldrow->isprimary;
                                    $autoincrement=$fieldrow->autoincrement;
//                            $string=$string.'$'.$sqlname.',';
                                $viewdata.='<th data-field="'.$sqlname.'">'.$title.'</th>'."\n";   
                        }
            $viewdata.='<th data-field="Action">Action</th>'."\n";
            $viewdata.='</tr>'."\n";
            $viewdata.='</thead>'."\n";
            $viewdata.='<tbody>'."\n";
            $viewdata.='</tbody>'."\n";
            $viewdata.='</table>'."\n";
            $viewdata.='</div>'."\n";
            
            $viewdata.='<div class="fixed-table-pagination" style="display: block;">'."\n";
            $viewdata.='<div class="pull-left pagination-detail">'."\n";
            
            $viewdata.='<?php $this->chintantable->createpagination();?>'."\n";
            
            $viewdata.='</div>'."\n";
            $viewdata.='</div>'."\n";
            
            $viewdata.='</div>'."\n";
            $viewdata.='</div>'."\n";
            $viewdata.='</div>'."\n";
            $viewdata.='</div>'."\n";
            
            $viewdata.='<script>'."\n";
            $viewdata.='function drawtable(resultrow) {'."\n";
            $viewdata.='return "<tr>';
            $numItems = count($allfields);
            $i = 0;
            $endtext="";
            foreach($allfields as $fieldrow)
                        {
                if($fieldrow->sqlname=='id')
                {
                    $endtext='id';
                }
                if ($fieldrow === end($allfields))
                                    $id=$fieldrow->id;
                                    $sqlname=$fieldrow->sqlname;
                                    $title=$fieldrow->title;
                                    $type=$fieldrow->sqltypename;
                                    $isprimary=$fieldrow->isprimary;
                                    $autoincrement=$fieldrow->autoincrement;
                                    $viewdata.='<td>" + resultrow.'.$sqlname.' + "</td>';
//                                    if ($fieldrow === end($allfields))
//                                    {
//                                        
//                                    }
                        }
              $confirm='return confirm(\"Are you sure you want to delete?\")';
            $viewdata.="<td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/edit".$tablename."?id=');?>\"+resultrow.".$endtext."+\"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' onclick=$confirm href='<?php echo site_url('site/delete".$tablename."?id='); ?>\"+resultrow.".$endtext."+\"'><i class='icon-trash '></i></a></td>";
            
//            $viewdata.=endtext();
            $viewdata.='</tr>';
            $viewdata.='";'."\n";
            $viewdata.='}'."\n";
            $viewdata.='generatejquery("<?php echo $base_url;?>");'."\n";
            $viewdata.='</script>'."\n";
            $viewdata.='</div>'."\n";
            $viewdata.='</div>'."\n";
            
            
		$urlforviewpage=$_SERVER["SCRIPT_FILENAME"];
        $urlforviewpage=substr($urlforviewpage,0,-9);
        $urlviewpage=$urlforviewpage.'admins/'.$databasename.'/application/views/backend/view'.$tablename.'.php';
        if ( ! write_file($urlviewpage, $viewdata))
        {
             echo 'Unable to write the file';
        }
        else
        {
             echo 'File written!';
        }
		 
            
            
            //createpage
            
            $createdata="";
            $createdata.='<div id="page-title">'."\n";
            $createdata.='<a href="<?php echo site_url("site/view'.$tablename.'"); ?>" class="btn btn-primary btn-labeled fa fa-arrow-left margined pull-right">Back</a>'."\n";
            $createdata.='<h1 class="page-header text-overflow">'.$tablename.' Details </h1>'."\n";
            $createdata.='</div>'."\n";
            
            $createdata.='<div id="page-content">'."\n";
            $createdata.='<div class="row">'."\n";
            $createdata.='<div class="col-lg-12">'."\n";
            $createdata.='<section class="panel">'."\n";
            $createdata.='<div class="panel-heading">'."\n";
            $createdata.='<h3 class="panel-title">'."\n";
            $createdata.='Create '.$tablename.' </h3>'."\n";
            $createdata.='</div>'."\n";
            $createdata.='<div class="panel-body">'."\n";
            $createdata.="<form class='form-horizontal tasi-form' method='post' action='<?php echo site_url(\"site/create".$tablename."submit\");?>' enctype= 'multipart/form-data'>"."\n";
            $createdata.='<div class="panel-body">'."\n";
            foreach($allfields as $fieldrow)
                        {
                                    $id=$fieldrow->id;
                                    $sqlname=$fieldrow->sqlname;
                                    $title=$fieldrow->title;
                                    $fieldtype=$fieldrow->type;
                                    $fieldtypename=$fieldrow->fieldtypename;
                                    $type=$fieldrow->sqltypename;
                                    $isprimary=$fieldrow->isprimary;
                                    $autoincrement=$fieldrow->autoincrement;
                                    if($fieldrow->sqlname=='id')
                                    {
                                    }
                                    elseif($fieldrow->sqltype== 4)
                                    {

                                    }
                                    else
                                    {
                                        if($fieldtype==1)
                                        {
                                        $createdata.='<div class="form-group">'."\n";
                                        $createdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
                                        $createdata.='<div class="col-sm-4">'."\n";
                                        $createdata.='<input type="text" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\');?>\'>'."\n";
                                        $createdata.='</div>'."\n";
                                        $createdata.='</div>'."\n";
                                        }
                                        if($fieldtype==2)
                                        {
                                        $createdata.='<div class=" form-group">'."\n";
                                        $createdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
                                        $createdata.='<div class="col-sm-8">'."\n";
                                        $createdata.='<textarea name="'.$sqlname.'" id="" cols="20" rows="10" class="form-control tinymce"><?php echo set_value( \''.$sqlname.'\');?></textarea>'."\n";
                                        $createdata.='</div>'."\n";
                                        $createdata.='</div>'."\n";
                                        }
                                        if($fieldtype==3)
                                        {
                                        $createdata.='<div class=" form-group">'."\n";
                                        $createdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
                                        $createdata.='<div class="col-sm-4">'."\n";
                                        $createdata.='<?php echo form_dropdown("'.$sqlname.'",$'.$sqlname.',set_value(\''.$sqlname.'\'),"class=\'chzn-select form-control\'");?>'."\n";
                                        $createdata.='</div>'."\n";
                                        $createdata.='</div>'."\n";
                                        }
                                        if($fieldtype==5)
                                        {
                                        $createdata.='<div class=" form-group">'."\n";
                                        $createdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
                                        $createdata.='<div class="col-sm-4">'."\n";
                                        $createdata.='<?php echo form_dropdown("'.$sqlname.'",$'.$sqlname.',set_value(\''.$sqlname.'\'),"class=\'chzn-select form-control\'" multiple);?>'."\n";
                                        $createdata.='</div>'."\n";
                                        $createdata.='</div>'."\n";
                                        }

                                        if($fieldtype==7)
                                        {
                                        $createdata.='<div class="form-group" style="display:none;">'."\n";
                                        $createdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
                                        $createdata.='<div class="col-sm-4">'."\n";
                                        $createdata.='<input type="text" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\');?>\'>'."\n";
                                        $createdata.='</div>'."\n";
                                        $createdata.='</div>'."\n";
                                        }

                                        if($fieldtype==8)
                                        {
                                        $createdata.='<div class="form-group">'."\n";
                                        $createdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
                                        $createdata.='<div class="col-sm-4">'."\n";
                                        $createdata.='<input type="email" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\');?>\'>'."\n";
                                        $createdata.='</div>'."\n";
                                        $createdata.='</div>'."\n";
                                        }
                                        if($fieldtype==9)
                                        {
                                        $createdata.='<div class="form-group">'."\n";
                                        $createdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
                                        $createdata.='<div class="col-sm-4">'."\n";
                                        $createdata.='<input type="number" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\');?>\'>'."\n";
                                        $createdata.='</div>'."\n";
                                        $createdata.='</div>'."\n";
                                        }
                                        if($fieldtype==11)
                                        {
                                        $createdata.='<div class="form-group">'."\n";
                                        $createdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
                                        $createdata.='<div class="col-sm-4">'."\n";
                                        $createdata.='<input type="date" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\');?>\'>'."\n";
                                        $createdata.='</div>'."\n";
                                        $createdata.='</div>'."\n";
                                        }

                                        if($fieldtype==10)
                                        {
                                        $createdata.='<div class=" form-group">'."\n";
                                        $createdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
                                        $createdata.='<div class="col-sm-4">'."\n";
                                        $createdata.='<input type="file" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\');?>\'>'."\n";
                                        $createdata.='</div>'."\n";
                                        $createdata.='</div>'."\n";
                                        }
                                    }
                
                        }
            
            
                                    $createdata.='<div class="form-group">'."\n";
                                    $createdata.='<label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>'."\n";
                                    $createdata.='<div class="col-sm-4">'."\n";
                                    $createdata.='<button type="submit" class="btn btn-primary">Save</button>'."\n";
                                    $createdata.='<a href="<?php echo site_url("site/view'.$tablename.'"); ?>" class="btn btn-secondary">Cancel</a>'."\n";
                                    $createdata.='</div>'."\n";
                                    $createdata.='</div>'."\n";
            
            $createdata.='</form>'."\n";
            $createdata.='</div>'."\n";
            $createdata.='</section>'."\n";
            $createdata.='</div>'."\n";
            $createdata.='</div>'."\n";
            $createdata.='</div>'."\n";
            
            
                          
		$urlforcreatepage=$_SERVER["SCRIPT_FILENAME"];
        $urlforcreatepage=substr($urlforcreatepage,0,-9);
        $urlcreatepage=$urlforcreatepage.'admins/'.$databasename.'/application/views/backend/create'.$tablename.'.php';
        if ( ! write_file($urlcreatepage, $createdata))
        {
             echo 'Unable to write the file';
        }
        else
        {
             echo 'File written!';
        }
		 
           //editdata
            
            $editdata='';
            $editdata.='<section class="panel">'."\n";
            $editdata.='<header class="panel-heading">'."\n";
            $editdata.='<h3 class="panel-title">'.$tablename.' Details </h3>'."\n";
            $editdata.='</header>'."\n";
            $editdata.='<div class="panel-body">'."\n";
            $editdata.="<form class='form-horizontal tasi-form' method='post' action='<?php echo site_url(\"site/edit".$tablename."submit\");?>' enctype= 'multipart/form-data'>"."\n";
            $editdata.='<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value(\'id\',$before->id);?>" style="display:none;">'."\n";
            foreach($allfields as $fieldrow)
                        {
//                if ($fieldrow === end($allfields))
                                    $id=$fieldrow->id;
                                    $sqlname=$fieldrow->sqlname;
                                    $title=$fieldrow->title;
                                    $fieldtype=$fieldrow->type;
                                    $fieldtypename=$fieldrow->fieldtypename;
                                    $type=$fieldrow->sqltypename;
                                    $isprimary=$fieldrow->isprimary;
                                    $autoincrement=$fieldrow->autoincrement;
									
									if($fieldrow->sqlname=='id')
                                    {
//                                        $endtext=$fieldrow->sqlname;
                                    }
									else
									{
                
										if($fieldtype==1)
										{
										$editdata.='<div class="form-group">'."\n";
										$editdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
										$editdata.='<div class="col-sm-4">'."\n";
										$editdata.='<input type="text" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\',$before->'.$sqlname.');?>\'>'."\n";
										$editdata.='</div>'."\n";
										$editdata.='</div>'."\n";
										}
										if($fieldtype==2)
										{
										$editdata.='<div class=" form-group">'."\n";
										$editdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
										$editdata.='<div class="col-sm-8">'."\n";
										$editdata.='<textarea name="'.$sqlname.'" id="" cols="20" rows="10" class="form-control tinymce"><?php echo set_value( \''.$sqlname.'\',$before->'.$sqlname.');?></textarea>'."\n";
										$editdata.='</div>'."\n";
										$editdata.='</div>'."\n";
										}
										if($fieldtype==3)
										{
										$editdata.='<div class=" form-group">'."\n";
										$editdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
										$editdata.='<div class="col-sm-4">'."\n";
										$editdata.='<?php echo form_dropdown("'.$sqlname.'",$'.$sqlname.',set_value(\''.$sqlname.'\',$before->'.$sqlname.'),"class=\'chzn-select form-control\'");?>'."\n";
										$editdata.='</div>'."\n";
										$editdata.='</div>'."\n";
										}
										if($fieldtype==5)
										{
										$editdata.='<div class=" form-group">'."\n";
										$editdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
										$editdata.='<div class="col-sm-4">'."\n";
										$editdata.='<?php echo form_dropdown("'.$sqlname.'",$'.$sqlname.',set_value(\''.$sqlname.'\',$before->'.$sqlname.'),"class=\'chzn-select form-control\' " multiple);?>'."\n";
										$editdata.='</div>'."\n";
										$editdata.='</div>'."\n";
										}
										
										if($fieldtype==7)
										{
										$editdata.='<div class="form-group" style="display:none;">'."\n";
										$editdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
										$editdata.='<div class="col-sm-4">'."\n";
										$editdata.='<input type="text" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\',$before->'.$sqlname.');?>\'>'."\n";
										$editdata.='</div>'."\n";
										$editdata.='</div>'."\n";
										}
					
										if($fieldtype==8)
										{
										$editdata.='<div class="form-group">'."\n";
										$editdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
										$editdata.='<div class="col-sm-4">'."\n";
										$editdata.='<input type="email" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\',$before->'.$sqlname.');?>\'>'."\n";
										$editdata.='</div>'."\n";
										$editdata.='</div>'."\n";
										}
										if($fieldtype==9)
										{
										$editdata.='<div class="form-group">'."\n";
										$editdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
										$editdata.='<div class="col-sm-4">'."\n";
										$editdata.='<input type="number" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\',$before->'.$sqlname.');?>\'>'."\n";
										$editdata.='</div>'."\n";
										$editdata.='</div>'."\n";
										}
										if($fieldtype==11)
										{
										$editdata.='<div class="form-group">'."\n";
										$editdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
										$editdata.='<div class="col-sm-4">'."\n";
										$editdata.='<input type="date" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\',$before->'.$sqlname.');?>\'>'."\n";
										$editdata.='</div>'."\n";
										$editdata.='</div>'."\n";
										}
					
										if($fieldtype==10)
										{
										$editdata.='<div class=" form-group">'."\n";
										$editdata.='<label class="col-sm-2 control-label" for="normal-field">'.$title.'</label>'."\n";
										$editdata.='<div class="col-sm-4">'."\n";
										$editdata.='<input type="file" id="normal-field" class="form-control" name="'.$sqlname.'" value=\'<?php echo set_value(\''.$sqlname.'\',$before->'.$sqlname.');?>\'>'."\n";
										$editdata.='</div>'."\n";
										$editdata.='</div>'."\n";
										}
									}
//                                    $createdata.='<td>" + resultrow.'.$sqlname.' + "</td>';
                        }
            
                                    $editdata.='<div class="form-group">'."\n";
                                    $editdata.='<label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>'."\n";
                                    $editdata.='<div class="col-sm-4">'."\n";
                                    $editdata.='<button type="submit" class="btn btn-primary">Save</button>'."\n";
                                    $editdata.="<a href='<?php echo site_url(\"site/view".$tablename."\"); ?>' class='btn btn-secondary'>Cancel</a>"."\n";
                                    $editdata.='</div>'."\n";
                                    $editdata.='</div>'."\n";
            
            $editdata.='</form>'."\n";
            $editdata.='</div>'."\n";
            $editdata.='</section>'."\n";
              
                          
		$urlforeditpage=$_SERVER["SCRIPT_FILENAME"];
        $urlforeditpage=substr($urlforeditpage,0,-9);
        $urleditpage=$urlforeditpage.'admins/'.$databasename.'/application/views/backend/edit'.$tablename.'.php';
        if ( ! write_file($urleditpage, $editdata))
        {
             echo 'Unable to write the file';
        }
        else
        {
             echo 'File written!';
        }
		 
         
       
        
    }
        
        
//        echo $controller;
           
        $controller.=''."\n";
        $controller.='}'."\n";
        $controller.='?>'."\n";
        
		$urlforcontroller=$_SERVER["SCRIPT_FILENAME"];
        $urlforcontroller=substr($urlforcontroller,0,-9);
        $urlcontroller=$urlforcontroller.'admins/'.$databasename.'/application/controllers/site.php';
        if ( ! write_file($urlcontroller, $controller))
        {
             echo 'Unable to write the file';
        }
        else
        {
             echo 'File written!';
        }
		 
//        $afterinsertcontrollerdata=read_file($urlcontroller);
//        $afterinsertcontrollerdata=substr($afterinsertcontrollerdata,0,-3);
//            echo $afterinsertcontrollerdata;
        
          $alljson.='} ?>';
        
            $urlforjson=$_SERVER["SCRIPT_FILENAME"];
            $urlforjson=substr($urlforjson,0,-9);
            $urljson=$urlforjson.'admins/'.$databasename.'/application/controllers/json.php';
        if ( ! write_file($urljson, $alljson))
        {
             echo 'Unable to write the file';
        }
        else
        {
             echo 'File written!';
        }
    
            
	}
    
    function readpath() {
        $this->load->helper('file');
        echo base_url('/admins/toykraft/application/controllers/site.php');
//        $string = read_file(base_url('/admins/toykraft/application/controllers/site.php'));
//        $string = read_file('C:\xampp\htdocs\createOBackend\admins\toykraft\application\controllers\site.php');
        $data = 'Some file data';

        if ( ! write_file('C:\xampp\htdocs\createOBackend\admins\toykraft\application\controllers\demo.php', $data))
        {
             echo 'Unable to write the file';
        }
        else
        {
             echo 'File written!';
        }
        
    }
    function testing () {
        print_r($_SERVER);
//        $text=$_SERVER["SCRIPT_FILENAME"];
//        $text=substr($text,0,-9);
        echo $text;
    }
   
    
}
?>