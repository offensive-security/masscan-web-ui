<?php
class DBException extends Exception
{
	public function handleError()
	{
		include DOC_ROOT.'includes//error.php';
		die;
	}
}
?>