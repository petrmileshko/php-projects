<?php

function multiStrip($str) {
    return stripslashes( strip_tags( trim($str) ) );
}

function templater($fileName, $variables = [])
{

	foreach ($variables as $key => $value)
	{
		$$key = $value;
	}


	ob_start();
	include $fileName;
	return ob_get_clean();	
}

?>