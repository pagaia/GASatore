<?php

if(DEBUG){
	echo "<div id='debug'>";
	echo "DEBUG:";
	echo "<pre>";
	echo "SESSION:\n";
	print_r ( $_SESSION);
	echo "POST:\n";
	print_r($_POST);
	echo "GET:\n";
	print_r($_GET);
	echo "</pre>";
	echo "</div>";
}

echo "<div id='footer'>
<a rel='license' href='http://creativecommons.org/licenses/by-sa/3.0/'><img alt='Creative Commons Licence' style='border-width:0' src='http://i.creativecommons.org/l/by-sa/3.0/88x31.png' /></a> &nbsp;
<a href='mailto:remo.moro@sesaspa.it?Subject=[Effort Report]' title='Send email'>Contacts</a>
</div>";
?>
