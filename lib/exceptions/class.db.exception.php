<?php
class DBException extends Exception
{
	public function handleError()
	{
		if (substr(php_sapi_name(), 0, 3) == 'cli'):
			echo $this->getMessage();
			die;
		endif;
		if (preg_match('/^Table (.*) doesn\'t exist/', $this->getMessage())):
			include DOC_ROOT.'includes/install.php';
		elseif(preg_match('/^(.*)Access denied for user (.*)/s', $this->getMessage())):
			include DOC_ROOT.'includes/setup.php';
		else:
			include DOC_ROOT.'includes/error.php';
		endif;
		die;
	}
}