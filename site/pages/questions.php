<?php
	set_include_path(get_include_path() . ":/home/web-apps/tps-exam/site");
	include 'api/dbfunc.php';
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();
?>
<div id='mainbody'>
	<div id='topGrid'>
		<?php if ( isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == "yes" ): ?>
			<?php if ( ! isset($_GET['action']) ): ?>
				<div align='left'>Choose actions from the bottom menu</div>
			<?php elseif ( $_GET['action'] == 'add' ): ?>
				<script>
					changeSize('topGrid','65%');
				</script>
				<?php include 'pages/addq.php'; ?>
			<?php elseif ( $_GET['action'] == 'change' ): ?>
				<script>
					changeSize('topGrid','60%');
				</script>
				<?php include 'pages/chq.php'; ?>
			<?php elseif ( $_GET['action'] == 'delete' ): ?>
				<div align='left'>Delete question</div>
				<?php include 'pages/delq.php'; ?>
			<?php elseif ( $_GET['action'] == 'cat' ): ?>
				<script>
					changeSize('topGrid','60%');
				</script>
				<?php include 'pages/mgmcat.php'; ?>
			<?php endif; ?>
	</div>
	<div id='btmGrid'>
		<div id='menu' align='left'>
			<table style='cursor: pointer'><tr>
			<td class='menu'><a href='index.php?page=questions&action=cat'>Manage Categories</a></td><td class='menu'><a href='index.php?page=questions&action=add'>Add Question</a></td><td class='menu'><a href='index.php?page=questions&action=change'>Change Question</a></td><td class='menu'><a href='index.php?page=questions&action=delete'>Delete Questions</a></td></tr>
			</table>
		</div>
		<?php endif; ?>
	</div>
</div>
