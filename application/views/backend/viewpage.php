<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createpage'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Page Details
            </header>
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("table List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="tablename">tablename</th>
                        <th data-field="navigationname">navigationname</th>
                        <th data-field="navigationtype">navigationtype</th>
                        <th data-field="navigationparent">navigationparent</th>
                        <th data-field="crudtypename">crudtypename</th>
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
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.tablename + "</td><td>" + resultrow.navigationname + "</td><td>" + resultrow.navigationtype + "</td><td>" + resultrow.navigationparent + "</td><td>" + resultrow.crudtypename + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editpage?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deletepage?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>
