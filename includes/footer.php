<?php
//BEGIN page genarated time
//HEADER side is in soruce/settings.php
$gentime = microtime();
$gentime = explode(' ', $gentime);
$gentime = $gentime[1] + $gentime[0];
$genfinish = $gentime;
$gentotal_time = round(($genfinish - $genstart), 4);
//END page genarated time
?>
<div class="kt-footer  kt-grid__item" id="kt_footer">
	<div class="kt-container  kt-container--fluid ">
		<div class="kt-footer__wrapper">
			<div class="kt-footer__copyright">
                <?= date("Y") == 2018 ? '2018' : '2018 - ' . date("Y") ?> &copy; <a href="http://dentasmadencilik.com/" target="_blank" class="kt-link">&nbsp;dERM</a>&nbsp;<?=$siteJsVersion?>
			</div>
			<div class="kt-footer__menu">
                Bu sayfa <?=$gentotal_time?> saniyede oluşturuldu.
			</div>
		</div>
	</div>
</div>