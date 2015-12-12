<?php
require dirname(__FILE__).'/exceptions/class.db.exception.php';

interface dbInterface
{
	public function fetch($q);
	public function fetchAll($q);
	public function execute($q);
	public function query($q);
	public function insertId();
	public function foundedRows();
}

class DB
{
	private static $_Instance;
	private $_Driver;

	private function __construct()
	{
		try {
			if (!file_exists(dirname(__FILE__).'/mysql/class.mysql.php')):
				throw new DBException('MySQL Database class not found!');
			elseif (!is_readable(dirname(__FILE__).'/mysql/class.mysql.php')):
				throw new DBException('MySql Database class not readable. Check file permissions for '.dirname(__FILE__).'/mysql/class.mysql.php');
			endif;
			require dirname(__FILE__).'/mysql/class.mysql.php';
			try {
				$this->_Driver = new MySQL();
			} catch (DBException $e) {
				$e->handleError();
			}
		} catch (DBException $e) {
			$e->handleError();
		}
	}

	protected static function getInstance()
	{
		if (!self::$_Instance instanceof self) {
			self::$_Instance = new self;
		}
		return self::$_Instance;
	}

	/**
	 * Get one row from database according to the submitted query.
	 *
	 * @access public
	 * @param string $q mysql query
	 * @return array Array with data from mysql. Can be empty.
	 */
	public static function fetch($q)
	{
		try {
			return self::getInstance()->_Driver->fetch($q);
		} catch (DBException $e) {
			$e->handleError();
		}
	}

	/**
	 * Get all rows from database which satisfy the
	 * condition from the submitted mysql query
	 *
	 * @access public
	 * @param string $q mysql query
	 * @return array Array with data from mysql. Can be empty.
	 */
	public static function fetchAll($q)
	{
		try {
			return self::getInstance()->_Driver->fetchAll($q);
		} catch (DBException $e) {
			$e->handleError();
		}
	}

	/**
	 * Execute a SQL statement and return the number of affected rows
	 *
	 * @access public
	 * @param string $q mysql statement
	 * @return int Affected rows
	 */
	public static function execute($q)
	{
		try {
			return self::getInstance()->_Driver->execute($q);
		} catch (DBException $e) {
			$e->handleError();
		}
	}

	/**
	 * Execute a SQL statement and return true on success or false on failure
	 *
	 * @access public
	 * @param string $q SQL statement
	 * @return bool true on success otherwise false
	 *
	 */
	public static function query($q, $throwException = true)
	{
		try {
			return self::getInstance()->_Driver->query($q);
		} catch (DBException $e) {
			if ($throwException):
				$e->handleError();
			else:
				return false;
			endif;
		}
	}

	/**
	 * Return last inserted id
	 *
	 * @access public
	 * @param none
	 * @return int Id of last inserted row in database
	 */
	public static function insertId()
	{
		try {
			return self::getInstance()->_Driver->insertId();
		} catch (DBException $e) {
			$e->handleError();
		}
	}

	public static function resNum()
	{

	}

	public static function getQueryExecutionTime()
	{
		return self::getInstance()->_Driver->getQueryExecutionTime();
	}


	/**
	 * Return the number of all found rows from the last SQL query
	 * @access public
	 * @param none
	 * @return int Number of rows or 0
	 */
	public static function foundedRows()
	{
		try {
			return self::getInstance()->_Driver->foundedRows();
		} catch (DBException $e) {
			$e->handleError();
		}
	}

	/**
	 * Escape special characters in a string for use in a sql statement
	 * This function use three native PHP function
	 * mysq_real_escape_string, strip_tags and trim
	 *
	 * @access public static
	 * @param $value string String to be escaped
	 * @return string escaped string
	 */
	public static function escape($value)
	{
		return self::getInstance()->_Driver->escape($value);
	}

	public static function mysql_real_escape($value)
	{
		return self::getInstance()->_Driver->mysql_real_escape($value);
	}


	public static function profile()
	{
		return self::getInstance()->_Driver->profile();
	}
}