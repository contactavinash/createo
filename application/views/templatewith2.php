<?php echo $this->load->view('backend/header'); ?>
<div class="row">
	<div class="col-md-9">
	    <?php echo $this->load->view('backend/'.$page); ?>
    </div>
	<div class="col-md-3">
		<?php echo $this->load->view('backend/'.$page2); ?>
	</div>
</div>
<?php echo $this->load->view('backend/footer'); ?>