<div class="navbar navbar-default">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			<li <?php if($this->uri->segment(1)=="home"){ echo "class='active'";} ?> >
				<a href="<?php echo site_url('/home');?>">
					<span class="glyphicon glyphicon-home"></span> Home
				</a>
			</li>
			<li>
				<a href="<?php echo site_url('/auth/logout'); ?>">
					<span class="glyphicon glyphicon-off"></span> Logout
				</a>
			</li>
		</ul>
	</div><!--/.nav-collapse -->
</div>
<?php
/* End of file navBar.php */
/* Location:  ./application/views/components/navBar.php*/