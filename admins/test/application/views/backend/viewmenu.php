<div class=" row" style="padding:1% 0;">
	<div class=" pull-right col-md-1 createbtn" ><a class="btn btn-primary" href="<?php echo site_url('menu/createmenu'); ?>"><i class="icon-plus"></i>Create </a></div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Menu Details
            </header>
			<table class="table table-striped table-hover border-top " id="sample_1" cellpadding="0" cellspacing="0" >
			<thead>
				<tr>
					<!--<th>Id</th>-->
					<th>Name</th>
					<th>URL</th>
					<th>Parent Menu</th>
					<th>Link Type</th>
					<th>Order</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<!--<td><?php echo $row->id; ?></td>-->
						<td><?php echo $row->name; ?></td>
						<td><?php echo $row->url; ?></td>
						<td><?php echo $row->parentmenu; ?></td>
						<td><?php if($row->linktype==1) { 
							echo "Site url";
						 }
						 else if($row->linktype==2) { 
							echo "Base url";
						 }
						 else if($row->linktype==3) { 
							echo "External url";
						 }
						 ?>
						</td>
						<td><?php echo $row->order; ?></td>
						<td> <a class="btn btn-primary btn-xs" href="<?php echo site_url('menu/editmenu?id=').$row->id;?>"><i class="icon-pencil"></i></a>
                                      <a class="btn btn-danger btn-xs" href="<?php echo site_url('menu/deletemenu?id=').$row->id; ?>"><i class="icon-trash "></i></a>
									 
					  </td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
	</div>
  </div>
