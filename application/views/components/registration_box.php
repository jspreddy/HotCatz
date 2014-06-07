<?php
$this->load->helper('form');
?>
<div class="container form-signin">
	<div class="col-lg-12 col-md-12 col-msm-12 well">
		<?php
		if(isset($val_errors) && $val_errors != null){
		?>
		<div class="alert alert-danger">
			<ul>
				<?php echo $val_errors; ?>
			</ul>
		</div>
		<?php
		}?>
		<form class="form-horizontal" id="registrationForm" role="form" method="post" action="<?php echo site_url('/register/submit');?>" accept-charset="utf-8">
			
			<div class="form-group">
				<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="username">Email Id</label>
				<div class="col-lg-8 col-md-8 col-sm-8">
					<input tabindex="1" type="email" name="username" id="username" class="form-control" placeholder="Email Id" required value="<?php echo set_value('username');?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="retype_username">Email confirmation</label>
				<div class="col-lg-8 col-md-8 col-sm-8">
					<input tabindex="2" type="email" name="retype_username" id="retype_username" class="form-control" placeholder="Email confirmation" required value="<?php echo set_value('retype_username'); ?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="password">Password</label>
				<div class="col-lg-8 col-md-8 col-sm-8">
					<input tabindex="3" type="password" name="password" id="password" class="form-control" placeholder="Password" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="password_conf">Password confirmation</label>
				<div class="col-lg-8 col-md-8 col-sm-8">
					<input tabindex="3" type="password" name="password_conf" id="password_conf" class="form-control" placeholder="Password Confirmation" required/>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
					<input tabindex="3" type="submit" class="btn btn-primary btn-block" value="Register" />
				</div>
			</div>
		</form>
		
		<a href="<?php echo site_url('/auth'); ?>" class='btn-link margin-auto btn-block text-center' ><span class='glyphicon glyphicon-arrow-left'></span> Back to login.</a>
	</div>
</div>
<?php
/* End of file login.php */
/* Location:  ./application/views/login.php*/