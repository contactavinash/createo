<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class table_model extends CI_Model
{
	
	
	public function createtable($project,$tablename)
	{
		$data  = array(
			'tablename' => $tablename,
			'project' => $project
			
		);
		$query=$this->db->insert( 'table', $data );
		$id=$this->db->insert_id();
        
		if(!$query)
			return  0;
		else
			return  1;
	}
    
    
    public function gettabledropdown()
	{
		$query=$this->db->query("SELECT `table`.`id` AS `id`,`table`.`tablename` AS `tablename`,`project`.`name` AS `projectname` FROM `table` LEFT OUTER JOIN `project` ON `project`.`id`=`table`.`project`  ORDER BY `id` DESC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->tablename."-".$row->projectname;
		}
		
		return $return;
	}
    
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'table' )->row();
		return $query;
	}
	
	public function edittable($id,$project,$tablename)
	{
		$data  = array(
					'tablename' => $tablename,
			         'project' => $project
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'table', $data );
        
		return 1;
	}
	function deletetable($id)
	{
		$query=$this->db->query("DELETE FROM `table` WHERE `id`='$id'");
	}
}
?>