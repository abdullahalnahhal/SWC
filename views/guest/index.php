<!DOCTYPE HTML>
<html>
	<?php
		$this->title = 'Landed by HTML5 UP';
		$this->tmpl('guest/head');
	?>
	<body class="landing">
		<div id="page-wrapper">

			<!-- Header -->
				<?=$this->tmpl('guest/header');?>
			<!-- Banner -->
				<?=$this->tmpl('guest/banner');?>
			<!-- Content -->
				<?=$this->tmpl('guest/content');?>
			<!-- Footer -->
				<?=$this->tmpl('guest/footer');?>

		</div>
			<?=$this->tmpl('guest/foot');?>
	</body>
</html>