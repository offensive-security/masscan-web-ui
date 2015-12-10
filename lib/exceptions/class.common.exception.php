<?php
class CommonException extends Exception
{
	public function handleError()
	{
		echo $this->getMessage();
		die;
	}

	private function writeLog()
	{

	}

	private function sendNotification()
	{

	}

	public function flowError()
	{

	}
}