<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class page_model extends CI_Model
{
	
	
	public function createpage($table,$navigationname,$navigationtype,$navigationparent,$crudtype)
	{
		$data  = array(
			'table' => $table,
			'navigationname' => $navigationname,
			'navigationtype' => $navigationtype,
			'navigationparent' => $navigationparent,
			'crudtype' => $crudtype
			
		);
		$query=$this->db->insert( 'page', $data );
		$id=$this->db->insert_id();
//        $accesslevelarray=explode(",",$accesslevel);
//        foreach($accesslevelarray AS $key=>$value)
//        {
////            echo $value;
//            $this->db->query("INSERT INTO `pageaccesslevel`( `page`, `accesslevel`) VALUES ('$id','$value')");
//        }
		if(!$query)
			return  0;
		else
			return  1;
	}
    
	public function createpageaccesslevel($accesslevel,$pageid)
	{
		$data  = array(
			'accesslevel' => $accesslevel,
			'page' => $pageid
		);
		$query=$this->db->insert( 'pageaccesslevel', $data );
		$id=$this->db->insert_id();
        
		if(!$query)
			return  0;
		else
			return  1;
	}
    
	public function beforeeditaccesslevel( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'pageaccesslevel' )->row();
		return $query;
	}
    
	public function editpageaccesslevel($pageid,$accesslevel,$pageaccesslevelid)
	{
		$data  = array(
			'accesslevel' => $accesslevel
		);
		$this->db->where( 'id', $pageaccesslevelid );
		$query=$this->db->update( 'pageaccesslevel', $data );
        
		return 1;
	}
    
	function deletepageaccesslevel($id)
	{
		$query=$this->db->query("DELETE FROM `pageaccesslevel` WHERE `id`='$id'");
	}
//     public function getselectedcrudtype($id)
//	{
//         $return=array();
//		$query=$this->db->query("SELECT `id`,`operatorid`,`categoryid` FROM `crudtype`  WHERE `operatorid`='$id'");
//        if($query->num_rows() > 0)
//        {
//            $query=$query->result();
//            foreach($query as $row)
//            {
//                $return[]=$row->categoryid;
//            }
//        }
//         return $return;
//         
//		
//	}
    
    public function getpagedropdown()
	{
		$query=$this->db->query("SELECT * FROM `page`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    public function getcrudtypedropdown()
	{
		$query=$this->db->query("SELECT * FROM `crudtype`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'page' )->row();
		return $query;
	}
	
	public function editpage($id,$table,$sqlname,$sqltype,$isprimary,$defaultvalue,$isnull,$autoincrement,$title,$type,$placeholder,$showinview)
	{
		$data  = array(
			'table' => $table,
			'sqlname' => $sqlname,
			'sqltype' => $sqltype,
			'isprimary' => $isprimary,
			'defaultvalue' => $defaultvalue,
			'isnull' => $isnull,
			'autoincrement' => $autoincrement,
			'title' => $title,
			'type' => $type,
			'placeholder' => $placeholder,
			'showinview' => $showinview
			
		  );
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'page', $data );
        
		return 1;
	}
	function deletepage($id)
	{
		$query=$this->db->query("DELETE FROM `page` WHERE `id`='$id'");
	}
}
?>