<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createfieldvalidation?id=').$this->input->get('id'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                fieldvalidation Details
            </header>
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("fieldvalidation List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="name">name</th>
                        <th data-field="action"> Actions </th>
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
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editfieldvalidation?id=');?>"+resultrow.field +"&fieldvalidationid="+resultrow.id+"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deletefieldvalidation?id='); ?>"+resultrow.field +"&fieldvalidationid="+resultrow.id+"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>
