<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Menu_model extends CI_Model
{
	public function create($name,$description,$keyword,$url,$linktype,$parentmenu,$menuaccess,$isactive,$order,$icon)
	{ 
		date_default_timezone_set('Asia/Calcutta');
		$data  = array(
			'description' =>$description,
			'name' => $name,
			'keyword' => $keyword,
			'url' => $url,
			'linktype' => $linktype,
			'parent' => $parentmenu,
			'isactive' => $isactive,
			'order' => $order,
			'icon' => $icon,
		);
		//print_r($data);
		
		$query=$this->db->insert( 'menu', $data );
		$menuid=$this->db->insert_id();
		if(! empty($menuaccess)) {
			foreach($menuaccess as $row)
			{
				$data  = array(
					'menu' => $menuid,
					'access' => $row,
				);
				$query=$this->db->insert( 'menuaccess', $data );
			}
		}
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewmenu()
	{
		$query="SELECT `menu`.`id` as `id`,`menu`.`name` as `name`,`menu`.`description` as `description`,`menu`.`keyword` as `keyword`,`menu`.`url` as `url`,`menu2`.`name` as `parentmenu`,`menu`.`linktype` as `linktype`,`menu`.`icon`,`menu`.`order` FROM `menu`
		LEFT JOIN `menu` as `menu2` ON `menu2`.`id` = `menu`.`parent` 
		ORDER BY `menu`.`order` ASC";
	   
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query['menu']=$this->db->get( 'menu' )->row();
		$query['menuaccess']=array();
		$menu_arr=$this->db->query("SELECT `access` FROM `menuaccess` WHERE `menu`='$id' ")->result();
		foreach($menu_arr as $row)
		{
			$query['menuaccess'][]=$row->access;
	    }
		
		return $query;
	}
	
	public function edit($id,$name,$description,$keyword,$url,$linktype,$parentmenu,$menuaccess,$isactive,$order,$icon)
	{
		$data  = array(
			'description' =>$description,
			'name' => $name,
			'keyword' => $keyword,
			'url' => $url,
			'linktype' => $linktype,
			'parent' => $parentmenu,
			'isactive' => $isactive,
			'order' => $order,
			'icon' => $icon,
		);
		$this->db->where( 'id', $id );
		$this->db->update( 'menu', $data );
		
		$this->db->query("DELETE FROM `menuaccess` WHERE `menu`='$id'");
		if(! empty($menuaccess)) {
		foreach($menuaccess as  $row)
		{
			$data  = array(
				'menu' => $id,
				'access' => $row,
			);
			$query=$this->db->insert( 'menuaccess', $data );
			
		} }
		return 1;
	}
	function deletemenu($id)
	{
		$query=$this->db->query("DELETE FROM `menu` WHERE `id`='$id'");
		$query=$this->db->query("DELETE FROM `menuaccess` WHERE `menu`='$id'");
	}
	public function getmenu()
	{
		$query=$this->db->query("SELECT * FROM `menu`  ORDER BY `id` ASC" )->result();
		$return=array(
		"" => ""
		);
		
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		return $return;
	}
	function viewmenus()
	{
        $accesslevel=$this->session->userdata( 'accesslevel' );
		$query="SELECT `menu`.`id` as `id`,`menu`.`name` as `name`,`menu`.`description` as `description`,`menu`.`keyword` as `keyword`,`menu`.`url` as `url`,`menu2`.`name` as `parentmenu`,`menu`.`linktype` as `linktype`,`menu`.`icon` FROM `menu`
		LEFT JOIN `menu` as `menu2` ON `menu2`.`id` = `menu`.`parent`  
        INNER  JOIN `menuaccess` ON  `menuaccess`.`menu`=`menu`.`id`
		WHERE `menu`.`parent`=0 AND `menuaccess`.`access`='$accesslevel'
		ORDER BY `menu`.`order` ASC";
	   
		$query=$this->db->query($query)->result();
		return $query;
	}
	function getsubmenus($parent)
	{
		$query="SELECT `menu`.`id` as `id`,`menu`.`name` as `name`,`menu`.`description` as `description`,`menu`.`keyword` as `keyword`,`menu`.`url` as `url`,`menu`.`linktype` as `linktype`,`menu`.`icon` FROM `menu`
		WHERE `menu`.`parent` = '$parent'
		ORDER BY `menu`.`order` ASC";
	   
		$query=$this->db->query($query)->result();
		return $query;
	}
	function getpages($parent)
	{ 
		$query="SELECT `menu`.`id` as `id`,`menu`.`name` as `name`,`menu`.`url` as `url` FROM `menu`
		WHERE `menu`.`parent` = '$parent'
		ORDER BY `menu`.`order` ASC";
	   
		$query2=$this->db->query($query)->result();
		$url = array();
		foreach($query2 as $row)
		{
			$pieces = explode("/", $row->url);
					
			if(empty($pieces) || !isset($pieces[1]))
			{
				$page2="";
			}
			else
				$page2=$pieces[1];
				
			$url[]=$page2;
		}
		//print_r($url);
		return $url;
	}
}
?>