<?php 
	ob_start();
	$result['content'] = ob_get_contents();
	$result['message'] = 1;
	ob_end_clean();
	echo json_encode($result);
?>