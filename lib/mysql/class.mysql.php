<?php
class MySQL implements dbInterface
{
	private $_con				= false;
	private $_res_resource		= null;
	private $_res_num			= 0;
	private $_affected_rows		= 0;
	private $_last_inserted_id	= 0;
	private $_queryExecutionTime= 0;
	private $_executedQueries	= array();


	public function __construct()
	{
		try {
			$this->_con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
			if (!$this->_con) {
				throw new DBException("Problem with connection to the mysql server.<br><strong>Error message: ".mysqli_connect_error()."</strong>");
			}
			if (!mysqli_select_db($this->_con, DB_DATABASE)) {
				throw new DBException('Database '.DB_DATABASE.' not found!!');
			}
			mysqli_set_charset($this->_con, 'utf8'); 
		} catch (DBException $e) {
			$e->handleError();
		}
	}

	/**
	 * Native function for executing mysql query
	 */
	private function executeQuery($q)
	{
		if (empty($q)) {
			throw new DBException('Empty query submitted!');
		}
		if (defined('DB_DEBUG') && DB_DEBUG):
			$start = microtime(true);
		endif;

		$this->_res_resource = mysqli_query($this->_con, $q);
		if (defined('DB_DEBUG') && DB_DEBUG):
			$end = microtime(true);
			$this->_executedQueries[] = array(	'q'		=> $q,
												'time'	=> $end-$start);
		endif;
		if (!$this->_res_resource) {
			throw new DBException(mysqli_error($this->_con));
		}
		if (preg_match('/^SELECT.+/',strtoupper($q))) {
			$this->_res_num = @mysqli_num_rows($this->_res_resource);
		}
		elseif (preg_match('/^INSERT.+/',strtoupper($q))) {
			$this->_last_inserted_id = mysqli_insert_id($this->_con);
			$this->_affected_rows = @mysqli_affected_rows($this->_con);
		}
		else{
			$this->_affected_rows = @mysqli_affected_rows($this->_con);
		}
		return true;
	}

	/**
	 * Fetch all results for current mysql result resource and return as an associative array
	 *
	 * @access public
	 * @param none
	 * @return array
	 */
	private function fetchRowsFromResource()
	{
		$results = array();
		while($row = mysqli_fetch_assoc($this->_res_resource)) {
			$results[] = $row;
		}
		return $results;
	}

	/**
	 * Get one row from the database according to submitted query
	 *
	 * @access public
	 * @param string $q mysql query
	 * @return array Array with data from mysql. Can be empty.
	 */
	public function fetch($q)
	{
		$this->executeQuery($q);
		return mysqli_fetch_assoc($this->_res_resource);
	}
	/**
	 * Get all rows from the database which satisfy the
	 * conditions from submitted mysql query
	 *
	 * @access public
	 * @param string $q mysql query
	 * @return array Array with data from mysql. Can be empty.
	 */
	public function fetchAll($q)
	{
		$this->executeQuery($q);
		return $this->fetchRowsFromResource();

	}

	/**
	 * Execute a SQL statement and return the number of affected rows
	 *
	 * @access public
	 * @param string $q mysql statement
	 * @return int Affected rows
	 */
	public function execute($q)
	{
		$this->executeQuery($q);
		return $this->_affected_rows;
	}

	/**
	 * Execute a SQL statement and return true on success or false on failure
	 *
	 * @access public
	 * @param string $q SQL statement
	 * @return bool true on success otherwise false
	 *
	 */
	public function query($q)
	{
		return $this->executeQuery($q);
	}

	/**
	 * Return last inserted id
	 *
	 * @access public
	 * @param none
	 * @return int Id of last inserted row in database
	 */
	public function insertId()
	{
		return $this->_last_inserted_id;
	}

	/**
	 * Return the number of all found rows from the last SQL query
	 * @access public
	 * @param none
	 * @return int Number of rows or 0
	 */
	public function foundedRows()
	{
			
	}

	public function resNum()
	{
		return $this->_res_num;
	}

	public function escape($value)
	{
		$value = strip_tags(trim($value));
		return mysqli_real_escape_string($this->_con, $value);
	}

	public function mysql_real_escape($value)
	{
		return mysqli_real_escape_string($this->_con, $value);
	}

	public function getQueryExecutionTime()
	{
		return $this->_queryExecutionTime;
	}

	public function profile()
	{
		if (!empty($this->_executedQueries)):
			$content = <<<CSS
	<style>
		table { border:2px solid #ccc;}
		table td { border:1px solid #ccc; background:#e1e1e1; padding:2px 5px;}
		table td.label { border:0; background:white; text-align:right;}
	</style>
CSS;
			$totalQueries = 0;
			$totalExecutionTime = 0;
			$content .="<table>";
			foreach ($this->_executedQueries as $q):
				$totalQueries++;
				$totalExecutionTime += (float) $q['time'];
				$content .= "<tr>";
				$content .= "<td>";
				$content .= htmlentities($q['q']);
				$content .= "</td>";
				$content .= "<td>";
				$content .= htmlentities($q['time']);
				$content .= "</td>";
				$content .= "</tr>";
			endforeach;
			$content .= "<tr><td class='label'>Total Queries:</td><td>{$totalQueries}</td></tr>";
			$content .= "<tr><td class='label'>Total Execution Time:</td><td>{$totalExecutionTime}</td></tr>";
			$content .="</table>";
			ob_start();
			?>
			<script>
				function writeConsole(content)
				{
					top.consoleRef=window.open('','myconsole','fullscreen=1');
					top.consoleRef.document.write(content);
					top.consoleRef.document.close();
				}
				var html = <?php echo json_encode($content);?>;
				writeConsole(html);
			</script>
			<?php
			ob_end_flush();
		endif;
	}
}