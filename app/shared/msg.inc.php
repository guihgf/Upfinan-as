<?php
	if(isset($_SESSION["msg"])){?>
		
		<div class="alert alert-block <?php if($_SESSION["tipo_msg"]==2){echo 'alert-danger';}else{ echo 'alert-info';}?>">
			<button type="button" class="close" data-dismiss="alert">X</button>
			<p id="body_msg"><?php echo $_SESSION["msg"];?></p>
		</div>
<?php 
		$_SESSION["tipo_msg"]=null;
		$_SESSION["msg"]=null;
	}?>