<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class admin_model extends CI_Model
{
	public function gettablebyproject($projectid)
    {
        $query=$this->db->query("SELECT * FROM `table` WHERE `project`='$projectid'")->result();
        return $query;
    }
	
	public function getallfieldsbytable($tableid)
    {
        $query=$this->db->query("SELECT `field`.`id`, `field`.`table`, `field`.`sqlname`, `field`.`sqltype`, `field`.`isprimary`, `field`.`defaultvalue`, `field`.`isnull`, `field`.`autoincrement`, `field`.`title`, `field`.`type`, `field`.`placeholder`, `field`.`showinview`,`sqltype`.`name` AS `sqltypename`,`fieldtype`.`name` AS `fieldtypename`,`table`.`tablename` AS `tablename`
FROM `field`
LEFT OUTER JOIN `table` ON `field`.`table`=`table`.`id`
LEFT OUTER JOIN `sqltype` ON `field`.`sqltype`=`sqltype`.`id`
LEFT OUTER JOIN `fieldtype` ON `field`.`type`=`fieldtype`.`id` WHERE `field`.`table`='$tableid'")->result();
        return $query;
    }
	
    public function modelcreator($id)
    {
    
        $project=$this->project_model->beforeedit($id); //right1
        $databasename=$project->name;
        $this->load->dbforge();
    
        $tablenames=$this->admin_model->gettablebyproject($id); //right2
        
        
        
        foreach ($tablenames as $rowtable)
        {
//            echo $rowtable->id;
            $tableid=$rowtable->id;
            $tablename=$rowtable->tablename;
            $allfields=$this->admin_model->getallfieldsbytable($tableid); //right3
            
            
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
            $modeldata.='function getsingle'.$tablename.'($id)'."\n";
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
            
            
            //export
            
            $modeldata.='public function export'.$tablename.'csv()'."\n";
                $modeldata.='{'."\n";
                    $modeldata.='$this->load->dbutil();'."\n";
                    $modeldata.='$query=$this->db->query("SELECT * FROM `'.$databasename."_".$tablename.'`");'."\n";
                    $modeldata.='$content= $this->dbutil->csv_from_result($query);'."\n";
                    $modeldata.='$timestamp=new DateTime();'."\n";
                    $modeldata.='$timestamp=$timestamp->format("Y-m-d_H.i.s");'."\n";
                    $modeldata.='$filename=$tablename."_Export_".$timestamp;'."\n";
                    $modeldata.='if ( ! write_file("./csvgenerated/$filename.csv", $content))'."\n";
                    $modeldata.='{'."\n";
                    $modeldata.='echo "Unable to write the file";'."\n";
                    $modeldata.='}'."\n";
                    $modeldata.='else'."\n";
                    $modeldata.='{'."\n";
                    $modeldata.='redirect(base_url("csvgenerated/$filename.csv"), "refresh");'."\n";
                    $modeldata.='echo "File written!";'."\n";
                    $modeldata.='}'."\n";
                $modeldata.='}'."\n";
            
            $modeldata.='}'."\n";
            
    function exportshippingimportcsv($license)
	{
        $licensequery=$this->db->query("SELECT * FROM `shipping_license` WHERE `id`='$license'")->row();
        $licensenumber=$licensequery->number;
		$this->load->dbutil();
        $q="SELECT `shipping_shippingimport`. `billofentry` as `Bill of entry number`,`shipping_shippingimport`. `date` as `Date`,`shipping_import`. `product` as `Product`,`shipping_shippingimport`. `qty` as `Quantity`,`shipping_shippingimport`. `amount` as `Amount` FROM `shipping_shippingimport` LEFT OUTER JOIN `shipping_import` ON `shipping_shippingimport`.`material`=`shipping_import`.`id` LEFT OUTER JOIN `shipping_license` ON `shipping_shippingimport`.`license`=`shipping_license`.`id` WHERE `shipping_shippingimport`.`license`='$license'";
		$query=$this->db->query("SELECT `shipping_shippingimport`. `billofentry` as `Bill of entry number`,`shipping_shippingimport`. `date` as `Date`,`shipping_import`. `product` as `Product`,`shipping_shippingimport`. `qty` as `Quantity`,`shipping_shippingimport`. `amount` as `Amount` FROM `shipping_shippingimport` LEFT OUTER JOIN `shipping_import` ON `shipping_shippingimport`.`material`=`shipping_import`.`id` LEFT OUTER JOIN `shipping_license` ON `shipping_shippingimport`.`license`=`shipping_license`.`id` WHERE `shipping_shippingimport`.`license`='$license'");

        $content= $this->dbutil->csv_from_result($query);
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
        $filename=$licensenumber."_Import_Entries_".$timestamp;
        if ( ! write_file("./csvgenerated/$filename.csv", $content))
        {
             echo "Unable to write the file";
        }
        else
        {
            redirect(base_url("csvgenerated/$filename.csv"), "refresh");
             echo "File written!";
        }
	}
            
            
//            echo $modeldata;
            
            $url=$_SERVER["SCRIPT_FILENAME"];
            $url=substr($url,0,-9);
            $url.='admins/'.$databasename.'/application/models/'.$tablename.'_model.php';

           $modeldata.='?>'."\n";
        if ( ! write_file($url, $modeldata))
        {
             echo 'Unable to write the file <br>';
        }
        else
        {
             echo $tablename.'_model.php '.'File written!<br>';
        }
      
    }
        
    }
    
    public function controllercreator($id)
    {
    
        $project=$this->project_model->beforeedit($id); //right1
        $databasename=$project->name;
        $this->load->dbforge();
    
        $tablenames=$this->admin_model->gettablebyproject($id); //right2
        
           
        $controller="";
        
		$urlforcontrollertest=$_SERVER["SCRIPT_FILENAME"];
        $urlforcontrollertest=substr($urlforcontrollertest,0,-9);
        $urlcontrollertest=$urlforcontrollertest.'admins/'.$databasename.'/application/controllers/site.php';
        
        $controllerfile=read_file($urlcontrollertest);
        $controllerfile=substr($controllerfile,0,-5);
        $controller.=$controllerfile;
        
        
        
        foreach ($tablenames as $rowtable)
        {
            $tableid=$rowtable->id;
            $tablename=$rowtable->tablename;
            $tableexport=$rowtable->export;
            $allfields=$this->admin_model->getallfieldsbytable($tableid); //right3
            
        
        
        $controller.="public function view".$tablename."()\n";
        $controller.="{\n";
        $controller.='$access=array("1");'."\n";
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
        
//           echo $controller;
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
            
            
            //export
            
            if($tableexport==1)
            {
                $controller.='public function export'.$tablename.'csv()'."\n";
                $controller.='{'."\n";
                $controller.='$access=array("1");'."\n";
                $controller.='$this->checkaccess($access);'."\n";
                $controller.='$this->'.$tablename.'_model->export'.$tablename.'csv();'."\n";
                $controller.='$data["redirect"]="site/view'.$tablename.'";'."\n";
                $controller.='$this->load->view("redirect",$data);'."\n";
                $controller.='}'."\n";
            }
            
//            echo $controller;
        
        
        
           
        $controller.=''."\n";
        $controller.='}'."\n";
        $controller.='?>'."\n";
        
		$urlforcontroller=$_SERVER["SCRIPT_FILENAME"];
        $urlforcontroller=substr($urlforcontroller,0,-9);
        $urlcontroller=$urlforcontroller.'admins/'.$databasename.'/application/controllers/site.php';
        if ( ! write_file($urlcontroller, $controller))
        {
             echo 'Unable to write Controller the file <br>';
        }
        else
        {
             echo 'Controller File appended i.e site.php!<br>';
        }
		 
        }
    
    }
    
    
    
    public function jsoncreator($id)
    {
    
        $project=$this->project_model->beforeedit($id); //right1
        $databasename=$project->name;
        $this->load->dbforge();
    
        $tablenames=$this->admin_model->gettablebyproject($id); //right2
        
           
        $controller="";
        
		$urlforcontrollertest=$_SERVER["SCRIPT_FILENAME"];
        $urlforcontrollertest=substr($urlforcontrollertest,0,-9);
        $urlcontrollertest=$urlforcontrollertest.'admins/'.$databasename.'/application/controllers/site.php';
        
        $controllerfile=read_file($urlcontrollertest);
        $controllerfile=substr($controllerfile,0,-5);
        $controller.=$controllerfile;
        
        
        
        foreach ($tablenames as $rowtable)
        {
            $tableid=$rowtable->id;
            $tablename=$rowtable->tablename;
            $allfields=$this->admin_model->getallfieldsbytable($tableid); //right3
            
        //json
			$alljson="";
            $alljson.='<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{';
        
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
            
            
          $alljson.='} ?>';
        
            $urlforjson=$_SERVER["SCRIPT_FILENAME"];
            $urlforjson=substr($urlforjson,0,-9);
            $urljson=$urlforjson.'admins/'.$databasename.'/application/controllers/json.php';
            if ( ! write_file($urljson, $alljson))
            {
                 echo 'Unable to write the file <br>';
            }
            else
            {
                 echo 'File written! <br>';
            }
    
            
        }
    
    }
    
    
    public function viewpagecreator($id)
    {
    
        $project=$this->project_model->beforeedit($id); //right1
        $databasename=$project->name;
        $this->load->dbforge();
    
        $tablenames=$this->admin_model->gettablebyproject($id); //right2
        
        
        
        foreach ($tablenames as $rowtable)
        {
            $tableid=$rowtable->id;
            $tablename=$rowtable->tablename;
            $allfields=$this->admin_model->getallfieldsbytable($tableid); //right3
            
            
             //views
            $viewdata="";
            $viewdata.='<div id="page-title">'."\n";
            $viewdata.='<a class="btn btn-primary btn-labeled fa fa-plus margined pull-right" href="<?php echo site_url("site/create'.$tablename.'"); ?>">Create</a>'."\n";
            $viewdata.='<a class="btn btn-primary" style="margin-left: 643px;margin-top: 10px;" href="<?php echo site_url("site/export'.$tablename.'csv"); ?>"target="_blank"><i class="glyphicon glyphicon-export"></i> Export to CSV </a>'."\n";
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
             echo 'view'.$tablename.'.php Unable to write the file <br>';
        }
        else
        {
             echo 'view'.$tablename.'.php File written! <br>';
        }
		 
            
            
        }
    
    }
    
    
    
    public function createpagecreator($id)
    {
    
        $project=$this->project_model->beforeedit($id); //right1
        $databasename=$project->name;
        $this->load->dbforge();
    
        $tablenames=$this->admin_model->gettablebyproject($id); //right2
        
         
            //createpage
            
        
        foreach ($tablenames as $rowtable)
        {
            $tableid=$rowtable->id;
            $tablename=$rowtable->tablename;
            $allfields=$this->admin_model->getallfieldsbytable($tableid); //right3
            
            
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
             echo 'create'.$tablename.'.php Unable to write the file <br>';
        }
        else
        {
             echo 'create'.$tablename.'.php File written! <br>';
        }
		 
        }
    }
    
    
    
    
    public function editpagecreator($id)
    {
    
        $project=$this->project_model->beforeedit($id); //right1
        $databasename=$project->name;
        $this->load->dbforge();
    
        $tablenames=$this->admin_model->gettablebyproject($id); //right2
        
         
           
        
        foreach ($tablenames as $rowtable)
        {
            $tableid=$rowtable->id;
            $tablename=$rowtable->tablename;
            $allfields=$this->admin_model->getallfieldsbytable($tableid); //right3
            
             
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
             echo 'edit'.$tablename.'.php Unable to write the file <br>';
        }
        else
        {
             echo 'edit'.$tablename.'.php File written! <br>';
        }
		 
        }
		 
    
    }
    
    public function otherappends($id)
    {
        $projectdetails=$this->project_model->beforeedit($id);
        $databasename=$projectdetails->databasename;
        $projectname=ucfirst ($projectdetails->name);
        $googleid=$projectdetails->googleid;
        $googlesecret=$projectdetails->googlesecret;
        $facebookid=$projectdetails->facebookid;
        $facebooksecret=$projectdetails->facebooksecret;
        
        $path_to_file = $_SERVER["SCRIPT_FILENAME"];
        $path_to_file=substr($path_to_file,0,-9);
        
        //hybridauth credentials library file
        $path_to_file=$path_to_file.'admins/'.$databasename.'/application/config/hybridauthlib.php';
        $file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace("183458610887-ebv9fjk75daruf33qc59fjn16secjo6t.apps.googleusercontent.com",$googleid,$file_contents);
        $file_contents = str_replace("nQ8QtVjvB0Zx5JEZQB6ssA-I",$googlesecret,$file_contents);
        $file_contents = str_replace("263699107356388",$facebookid,$file_contents);
        $file_contents = str_replace("b7e7da8e232a4e85c404cfa4a21685d7",$facebooksecret,$file_contents);
        file_put_contents($path_to_file,$file_contents);
        
        //header file change with name of project
        $path_to_file=$path_to_file.'admins/'.$databasename.'/application/views/backend/header.php';
        $file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace("CreateO",$projectname,$file_contents);
        file_put_contents($path_to_file,$file_contents);
        
        //database file change
        $path_to_file=$path_to_file.'admins/'.$databasename.'/application/config/database.php';
        $file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace("createo",$databasename,$file_contents);
        file_put_contents($path_to_file,$file_contents);
        
        //login file change with name of project
        $path_to_file=$path_to_file.'admins/'.$databasename.'/application/views/login.php';
        $file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace("CreateO",$projectname,$file_contents);
        file_put_contents($path_to_file,$file_contents);
        
    }
    
}
?>