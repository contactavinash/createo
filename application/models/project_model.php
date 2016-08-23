<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class project_model extends CI_Model
{
	
	
	public function create($name,$email,$databasename,$databasepassword,$hostname,$userpassword,$mandrillid,$mandrillpassword)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
			'databasename' =>$databasename,
			'databasepassword' => $databasepassword,
			'hostname' => $hostname,
            'userpassword'=> $userpassword,
            'mandrillid'=> $mandrillid,
            'mandrillpassword'=> $mandrillpassword
		);
		$query=$this->db->insert( 'project', $data );
		$id=$this->db->insert_id();
        
		if(!$query)
			return  0;
		else
			return  1;
	}
    
	public function createprojectaccesslevel($accesslevel,$projectid)
	{
		$data  = array(
			'accesslevel' => $accesslevel,
			'project' => $projectid
		);
		$query=$this->db->insert( 'projectaccesslevel', $data );
		$id=$this->db->insert_id();
        
		if(!$query)
			return  0;
		else
			return  1;
	}
    
	function viewprojects($startfrom,$totallength)
	{
		$project = $this->session->projectdata('accesslevel');
		$query="SELECT DISTINCT `project`.`id` as `id`,`project`.`firstname` as `firstname`,`project`.`lastname` as `lastname`,`accesslevel`.`name` as `accesslevel`	,`project`.`email` as `email`,`project`.`contact` as `contact`,`project`.`status` as `status`,`project`.`accesslevel` as `access`
		FROM `project`
	   INNER JOIN `accesslevel` ON `project`.`accesslevel`=`accesslevel`.`id`  ";
	   $accesslevel=$this->session->projectdata('accesslevel');
	   if($accesslevel==1)
		{
			$query .= " ";
		}
		else if($accesslevel==2)
		{
			$query .= " WHERE `project`.`accesslevel`> '$accesslevel' ";
		}
		
	   $query.=" ORDER BY `project`.`id` ASC LIMIT $startfrom,$totallength";
		$query=$this->db->query($query)->result();
        
        $return=new stdClass();
        $return->query=$query;
        $return->totalcount=$this->db->query("SELECT count(*) as `totalcount` FROM `project`
	   INNER JOIN `accesslevel` ON `project`.`accesslevel`=`accesslevel`.`id`  ")->row();
        $return->totalcount=$return->totalcount->totalcount;
		return $return;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'project' )->row();
		return $query;
	}
	
	public function beforeeditaccesslevel( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'projectaccesslevel' )->row();
		return $query;
	}
	
	public function edit($id,$name,$email,$databasename,$databasepassword,$hostname,$userpassword,$mandrillid,$mandrillpassword)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
			'databasename' =>$databasename,
			'databasepassword' => $databasepassword,
			'hostname' => $hostname,
            'userpassword'=> $userpassword,
            'mandrillid'=> $mandrillid,
            'mandrillpassword'=> $mandrillpassword
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'project', $data );
        
		return 1;
	}
    
	public function editprojectaccesslevel($projectid,$accesslevel,$projectaccesslevelid)
	{
		$data  = array(
			'accesslevel' => $accesslevel
		);
		$this->db->where( 'id', $projectaccesslevelid );
		$query=$this->db->update( 'projectaccesslevel', $data );
        
		return 1;
	}
    
	public function getprojectimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `project` WHERE `id`='$id'")->row();
		return $query;
	}
	function deleteproject($id)
	{
		$query=$this->db->query("DELETE FROM `project` WHERE `id`='$id'");
	}
	function deleteprojectaccesslevel($id)
	{
		$query=$this->db->query("DELETE FROM `projectaccesslevel` WHERE `id`='$id'");
	}
	function changepassword($id,$password)
	{
		$data  = array(
			'password' =>md5($password),
		);
		$this->db->where('id',$id);
		$query=$this->db->update( 'project', $data );
		if(!$query)
			return  0;
		else
			return  1;
	}
    
    public function getprojectdropdown()
	{
		$query=$this->db->query("SELECT * FROM `project`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function getaccesslevels()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `accesslevel` ORDER BY `id` ASC")->result();
		$accesslevel=$this->session->projectdata('accesslevel');
			foreach($query as $row)
			{
				if($accesslevel==1)
				{
					$return[$row->id]=$row->name;
				}
				else if($accesslevel==2)
				{
					if($row->id > $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
				else if($accesslevel==3)
				{
					if($row->id > $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
				else if($accesslevel==4)
				{
					if($row->id == $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
			}
	
		return $return;
	}
    public function getstatusdropdown()
	{
		$query=$this->db->query("SELECT * FROM `statuses`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	function changestatus($id)
	{
		$query=$this->db->query("SELECT `status` FROM `project` WHERE `id`='$id'")->row();
		$status=$query->status;
		if($status==1)
		{
			$status=0;
		}
		else if($status==0)
		{
			$status=1;
		}
		$data  = array(
			'status' =>$status,
		);
		$this->db->where('id',$id);
		$query=$this->db->update( 'project', $data );
		if(!$query)
			return  0;
		else
			return  1;
	}
	function editaddress($id,$address,$city,$pincode)
	{
		$data  = array(
			'address' => $address,
			'city' => $city,
			'pincode' => $pincode,
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'project', $data );
		if($query)
		{
			$this->saveprojectlog($id,'project Address Edited');
		}
		return 1;
	}
	
	function saveprojectlog($id,$status)
	{
//		$fromproject = $this->session->projectdata('id');
		$data2  = array(
			'onproject' => $id,
			'status' => $status
		);
		$query2=$this->db->insert( 'projectlog', $data2 );
        $query=$this->db->query("UPDATE `project` SET `status`='$status' WHERE `id`='$project'");
	}
    function signup($email,$password) 
    {
         $password=md5($password);   
        $query=$this->db->query("SELECT `id` FROM `project` WHERE `email`='$email' ");
        if($query->num_rows == 0)
        {
            $this->db->query("INSERT INTO `project` (`id`, `firstname`, `lastname`, `password`, `email`, `website`, `description`, `eventinfo`, `contact`, `address`, `city`, `pincode`, `dob`, `accesslevel`, `timestamp`, `facebookprojectid`, `newsletterstatus`, `status`,`logo`,`showwebsite`,`eventsheld`,`topeventlocation`) VALUES (NULL, NULL, NULL, '$password', '$email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, NULL, NULL,NULL, NULL, NULL,NULL);");
            $project=$this->db->insert_id();
            $newdata = array(
                'email'     => $email,
                'password' => $password,
                'logged_in' => true,
                'id'=> $project
            );

            $this->session->set_projectdata($newdata);
            
          //  $queryorganizer=$this->db->query("INSERT INTO `organizer`(`name`, `description`, `email`, `info`, `website`, `contact`, `project`) VALUES(NULL,NULL,NULL,NULL,NULL,NULL,'$project')");
            
            
           return $project;
        }
        else
         return false;
        
        
    }
    function login($email,$password) 
    {
        $password=md5($password);
        $query=$this->db->query("SELECT `id` FROM `project` WHERE `email`='$email' AND `password`= '$password'");
        if($query->num_rows > 0)
        {
            $project=$query->row();
            $project=$project->id;
            

            $newdata = array(
                'email'     => $email,
                'password' => $password,
                'logged_in' => true,
                'id'=> $project
            );

            $this->session->set_projectdata($newdata);
            //print_r($newdata);
            return $project;
        }
        else
        return false;


    }
    function authenticate() {
        $is_logged_in = $this->session->projectdata( 'logged_in' );
        //print_r($is_logged_in);
        if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
            return false;
        } //$is_logged_in !== 'true' || !isset( $is_logged_in )
        else {
            $projectid = $this->session->projectdata( 'id' );
         return $projectid;
        }
    }
    
    function frontendauthenticate($email,$password) 
    {
        $query=$this->db->query("SELECT `id`, `name`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `projectname`, `socialid`, `logintype`, `json` FROM `project` WHERE `email` LIKE '$email' AND `password`='$password' LIMIT 0,1");
        if ($query->num_rows() > 0)
        {
        	$query=$query->row();
            $data['project']=$query;
            $id=$query->id;
            $status=$query->status;
            if($status==3)
            {
//                $updatequery=$this->db->query("UPDATE `project` SET `status`=4 WHERE `id`='$id'");
                $status=4;
//                if($updatequery)
//                {
                    $this->saveprojectlog($id,$status);
//                }
            }
            else if($status==1)
            {
                $status=2;
//                $updatequery=$this->db->query("UPDATE `project` SET `status`=2 WHERE `id`='$id'");
//                if($updatequery)
//                {
                    $this->saveprojectlog($id,$status);
//                }
            }
            
        $query2=$this->db->query("SELECT `id`, `name`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `projectname`, `socialid`, `logintype`, `json` FROM `project` WHERE `id`='$id' LIMIT 0,1")->row();
            
        $newdata        = array(
				'id' => $query2->id,
				'email' => $query2->email,
				'name' => $query2->name ,
				'accesslevel' => $query2->accesslevel ,
				'status' => $query2->status ,
				'logged_in' => 'true',
			);
			$this->session->set_projectdata( $newdata );
            
            
            $accesslevel=$query->accesslevel;
            if($accesslevel==2)
            {
            $data['category']=$this->db->query("SELECT `id`,`categoryid`,`operatorid` FROM `operatorcategory` WHERE `operatorid`='$id'")->result();
            }
        	return $data;
        }
        else 
        {
        	return false;
        }
    }
    
    function frontendregister($name,$email,$password,$socialid,$logintype,$json) 
    {
        $data  = array(
			'name' => $name,
			'email' => $email,
			'password' =>md5($password),
			'accesslevel' => 3,
			'status' => 2,
            'socialid'=> $socialid,
            'json'=> $json,
			'logintype' => $logintype
		);
		$query=$this->db->insert( 'project', $data );
		$id=$this->db->insert_id();
        $queryselect=$this->db->query("SELECT * FROM `project` WHERE `id` LIKE '$id' LIMIT 0,1")->row();
        
        $accesslevel=$queryselect->accesslevel;
//        $queryselect=$query;
        $data1['project']=$queryselect;
        if($accesslevel==2)
        {
            $data1['category']=$this->db->query("SELECT `id`,`categoryid`,`operatorid` FROM `operatorcategory` WHERE `operatorid`='$id'")->result();
        }
        return $data1;
    }
    
	function getallinfoofproject($id)
	{
		$project = $this->session->projectdata('accesslevel');
		$query="SELECT DISTINCT `project`.`id` as `id`,`project`.`firstname` as `firstname`,`project`.`lastname` as `lastname`,`accesslevel`.`name` as `accesslevel`	,`project`.`email` as `email`,`project`.`contact` as `contact`,`project`.`status` as `status`,`project`.`accesslevel` as `access`
		FROM `project`
	   INNER JOIN `accesslevel` ON `project`.`accesslevel`=`accesslevel`.`id` 
       WHERE `project`.`id`='$id'";
		$query=$this->db->query($query)->row();
		return $query;
	}
    
	public function getlogintypedropdown()
	{
		$query=$this->db->query("SELECT * FROM `logintype`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function frontendlogout($project)
	{
        $query=$this->db->query("SELECT `id`, `name`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `projectname`, `socialid`, `logintype`, `json` FROM `project` WHERE `id`='$project' LIMIT 0,1")->row();
        $status=$query->status;
        if($status==4)
        {
            $status=3;
//            $updatequery=$this->db->query("UPDATE `project` SET `status`=3 WHERE `id`='$project'");
//            if($updatequery)
//            {
                $this->saveprojectlog($id,$status);
//            }
        }
        else if($status==2)
        {
            $status=1;
//            $updatequery=$this->db->query("UPDATE `project` SET `status`=1 WHERE `id`='$project'");
//            if($updatequery)
//            {
                $this->saveprojectlog($id,$status);
//            }
        }
//        $updatequery=$this->db->query("UPDATE `project` SET `status`=5 WHERE `id`='$project'");
        
//        if(!$updatequery)
//            return 0;
//        else
//        {
            
		$this->session->sess_destroy();
            return 1;
//        }
	}
}
?>