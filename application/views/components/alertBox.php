<?php
if(isset($alertType) && isset($message)){
?>
	<div class="alert <?php echo $alertType; ?>"><?php echo $message; ?></div>
<?php
}

