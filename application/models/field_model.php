<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class field_model extends CI_Model
{
	
	
	public function createfield($table,$sqlname,$sqltype,$isprimary,$defaultvalue,$isnull,$autoincrement,$title,$type,$placeholder,$showinview)
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
		$query=$this->db->insert( 'field', $data );
		$id=$this->db->insert_id();
        
		if(!$query)
			return  0;
		else
			return  1;
	}
    
	public function createfieldselectfield($name,$value,$fieldid)
	{
		$data  = array(
			'name' => $name,
			'value' => $value,
			'field' => $fieldid
		);
		$query=$this->db->insert( 'fieldselectfield', $data );
		$id=$this->db->insert_id();
        
		if(!$query)
			return  0;
		else
			return  1;
	}
    
	public function createfieldvalidation($validation,$fieldid)
	{
		$data  = array(
			'validation' => $validation,
			'field' => $fieldid
		);
		$query=$this->db->insert( 'fieldvalidation', $data );
		$id=$this->db->insert_id();
        
		if(!$query)
			return  0;
		else
			return  1;
	}
    
	public function editfieldselectfield($fieldid,$name,$value,$fieldselectfieldid)
	{
		$data  = array(
			'name' => $name,
			'value' => $value,
			'field' => $fieldid
		);
		$this->db->where( 'id', $fieldselectfieldid );
		$query=$this->db->update( 'fieldselectfield', $data );
        
		return 1;
	}
    
    
	public function editfieldvalidation($fieldid,$validation,$fieldvalidationid)
	{
		$data  = array(
			'validation' => $validation,
			'field' => $fieldid
		);
		$this->db->where( 'id', $fieldvalidationid );
		$query=$this->db->update( 'fieldvalidation', $data );
        
		return 1;
	}
    
    
	public function beforeeditfieldselectfield( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'fieldselectfield' )->row();
		return $query;
	}
    
	public function beforeeditfieldvalidation( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'fieldvalidation' )->row();
		return $query;
	}
    
    
	function deletefieldselectfield($id)
	{
		$query=$this->db->query("DELETE FROM `fieldselectfield` WHERE `id`='$id'");
	}
    
    
	function deletefieldvalidation($id)
	{
		$query=$this->db->query("DELETE FROM `fieldvalidation` WHERE `id`='$id'");
	}
    
    
    public function getfielddropdown()
	{
		$query=$this->db->query("SELECT * FROM `field`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->fieldname;
		}
		
		return $return;
	}
    
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'field' )->row();
		return $query;
	}
	
	public function editfield($id,$table,$sqlname,$sqltype,$isprimary,$defaultvalue,$isnull,$autoincrement,$title,$type,$placeholder,$showinview)
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
		$query=$this->db->update( 'field', $data );
        
		return 1;
	}
	function deletefield($id)
	{
		$query=$this->db->query("DELETE FROM `field` WHERE `id`='$id'");
	}
    
    
	public function getisprimarydropdown()
	{
		$isprimary= array(
			 "TRUE" => "Yes",
			 "FALSE" => "No",
			);
		return $isprimary;
	}
	
	public function getisnulldropdown()
	{
		$isnull= array(
			 "TRUE" => "Yes",
			 "FALSE" => "No",
			);
		return $isnull;
	}
	
	public function getautoincrementdropdown()
	{
		$autoincrement= array(
			 "TRUE" => "Yes",
			 "FALSE" => "No",
			);
		return $autoincrement;
	}
	
	public function getisdefaultdropdown()
	{
		$isdefault= array(
			 "yes" => "Yes",
			 "no" => "No",
			);
		return $isdefault;
	}
	
    public function getfieldtypedropdown()
	{
		$query=$this->db->query("SELECT * FROM `fieldtype`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    public function getsqltypedropdown()
	{
		$query=$this->db->query("SELECT * FROM `sqltype`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
}
?>