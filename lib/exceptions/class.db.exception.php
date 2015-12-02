<?php
class DBException extends Exception
{
	public function handleError()
	{
			echo $this->getMessage();
			die;
	}
}
?>