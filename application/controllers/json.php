<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Json extends CI_Controller 
{
	
	public function execute()
    {
        $id=$this->input->get("id");
        
        $project=$this->project_model->beforeedit($id); //right1
        $databasename=$project->name;
        $this->load->dbforge();
        $modelcreatorreturn=$this->admin_model->modelcreator($id);
        $controllercreatorreturn=$this->admin_model->controllercreator($id);
        $jsoncreatorreturn=$this->admin_model->jsoncreator($id);
        $viewpagecreatorreturn=$this->admin_model->viewpagecreator($id);
        $createpagecreatorreturn=$this->admin_model->createpagecreator($id);
        $editpagecreatorreturn=$this->admin_model->editpagecreator($id);
        
        $data['alertsuccess']="Basic Backend Panel created Successfully.";
		$data['redirect']="site/index";
		$this->load->view("redirect",$data);
    }
    
}
//EndOfFile
?>