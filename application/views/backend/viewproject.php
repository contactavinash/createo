<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createproject'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Project Details
            </header>
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("Project List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="name">Name</th>
                        <th data-field="email">Email</th>
                        <th data-field="databasename">databasename</th>
                        <th data-field="databasepassword">databasepassword</th>
                        <th data-field="hostname">hostname</th>
                        <th data-field="userpassword">userpassword</th>
                        <th data-field="mandrillid">mandrillid</th>
                        <th data-field="mandrillpassword">mandrillpassword</th>
                        <th data-field="action"> Actions </th>
                        <th data-field="execute"> Execute </th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
                </table>
                   <?php $this->chintantable->createpagination();?>
            </div>
		</section>
		<script>
            function drawtable(resultrow) {
                if(!resultrow.name)
                {
                    resultrow.name="";
                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.email + "</td><td>" + resultrow.databasename + "</td><td>" + resultrow.databasepassword + "</td><td>" + resultrow.hostname + "</td><td>" + resultrow.userpassword + "</td><td>" + resultrow.mandrillid + "</td><td>" + resultrow.mandrillpassword + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editproject?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteproject?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/executeproject?id='); ?>"+resultrow.id +"'>Execute</a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>
