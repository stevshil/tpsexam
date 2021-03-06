<?php
	set_include_path(get_include_path() . ":/home/web-apps/tps-exam/site");
	include 'api/dbfunc.php';
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();
?>
<div id='mainbody'>
	<div id='topGrid'>
		<?php if ( $_SESSION["loggedin"] == "yes" ): ?>
			<?php if ( ! isset($_GET['action']) ): ?>
				<div align='left'>Choose actions from the bottom menu</div>
			<?php elseif ( $_GET['action'] == 'add' ): ?>
				<script>
					changeSize('topGrid','50%');
				</script>
				<?php include 'pages/adduser.php'; ?>
			<?php elseif ( $_GET['action'] == 'change' ): ?>
				<script>
					changeSize('topGrid','55%');
				</script>
				<?php include 'pages/chuser.php'; ?>
			<?php elseif ( $_GET['action'] == 'changeuser'): ?>
				<script>
					changeSize('topGrid','55%');
				</script>
				<?php include 'pages/chuserdets.php'; ?>
			<?php elseif ( $_GET['action'] == 'lock' ): ?>
				<?php include 'pages/lockuser.php'; ?>
				<script>
					changeSize('topGrid','55%');
				</script>
			<?php elseif ( $_GET['action'] == 'pwreset' ): ?>
				<div align='left'>Reset users password</div>
				<?php include 'pages/selectuser.php'; ?>
			<?php endif; ?>
	</div>
	<div id='btmGrid'>
		<div id='menu' align='left'>
			<table style='cursor: pointer'><tr>
			<td class='menu'><a href='index.php?page=users&action=add'>Add User</a></td><td class='menu'><a href='index.php?page=users&action=change'>Change User</a></td><td class='menu'><a href='index.php?page=users&action=lock'>Lock User</a></td><td class='menu'><a href='index.php?page=users&action=pwreset'>Change Users Password</a></td></tr>
			</table>
		</div>
		<?php endif; ?>
	</div>
</div>
