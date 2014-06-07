<?php
$this->load->helper('form');
?>
<div class="container form-signin">
	<div class="col-lg-12 col-md-12 col-msm-12 well">
		<form class="form-horizontal" id="loginForm" role="form" method="post" action="<?php echo site_url('/auth/login');?>" accept-charset="utf-8">
			<?php
			if (isset($msg)) {
				switch ($msg) {
					case "loginFail":
						?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<b>Invalid.</b> Please check your credentials.
						</div>
						<?php
						break;
					case "unauth":
						?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<b>Unauthorised.</b> Please login first.
						</div>
						<?php
						break;
					case "emailverify":
						?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<b>Verify your Email.</b> We sent a verification link to your mail id. Please go there and click it.
						</div>
						<?php
						break;
					case "logoutSuccess":
						?>
						<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<b>Logged out.</b> You can now login again.
						</div>
						<?php
						break;
					case "logoutFail":
						?>
						<div class="alert alert-warning">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<b>Error.</b> Logout failed.
						</div>
						<?php
						break;
				}
			}// */
			?>
			<div class="form-group">
				<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="username">Email Id</label>
				<div class="col-lg-8 col-md-8 col-sm-8">
					<input tabindex="1" type="email" name="username" id="username" class="form-control" placeholder="Email Id" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="password">Password</label>
				<div class="col-lg-8 col-md-8 col-sm-8">
					<input tabindex="2" type="password" name="password" id="password" class="form-control" placeholder="Password" required/>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
					<input tabindex="3" type="submit" class="btn btn-primary btn-block" value="Log In" />
				</div>
			</div>
		</form>
		
		<a href="<?php echo site_url('/register'); ?>" class='btn-link margin-auto btn-block text-center' >Not a user yet? kitties are waiting <span class='glyphicon glyphicon-arrow-right'></span></a>
	</div>
</div>
<?php
/* End of file login_box.php */
/* Location:  ./application/views/login_box.php*/