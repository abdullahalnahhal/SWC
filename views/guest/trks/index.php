<!DOCTYPE HTML>
<html>
	<?php
		$this->title = 'Landed by HTML5 UP';
		$this->tmpl('guest/general/head');
	?>
	<body class="landing">
		<div id="page-wrapper">

			<!-- Header -->
				<?=$this->tmpl('guest/general/header');?>
			<!-- Content -->
				<?=$this->tmpl('guest/trks/content');?>
			<!-- Footer -->
				<?=$this->tmpl('guest/general/footer');?>

		</div>
			<?=$this->tmpl('guest/general/foot');?>
	</body>
</html>