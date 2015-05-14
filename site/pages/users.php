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
				<div align='left'>Adding user</div>
				<?php include 'pages/adduser.php'; ?>
			<?php elseif ( $_GET['action'] == 'change' ): ?>
				<div align='left'>Changing user</div>
			<?php elseif ( $_GET['action'] == 'lock' ): ?>
				<div align='left'>Locking user</div>
			<?php endif; ?>
	</div>
	<div id='btmGrid'>
		<div id='menu' align='left'>
			<table style='cursor: pointer'><tr>
			<td class='menu'><a href='index.php?page=users&action=add'>Add User</a></td><td class='menu'><a href='index.php?page=users&action=change'>Change User</a></td><td class='menu'><a href='index.php?page=users&action=lock'>Lock User</a></td></tr>
			</table>
		</div>
		<?php endif; ?>
	</div>
</div>
