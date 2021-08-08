<?php
function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}


function get_safe_value($str)
{
	global $conn;
	$str = mysqli_real_escape_string($conn, $str);
	return $str;
}
function redirect($link)
{
?>
	<script>
		window.location.href = '<?php echo $link ?>';
	</script>
<?php
	die();
}
?>