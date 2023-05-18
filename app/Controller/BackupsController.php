<?php
 App::uses('ConnectionManager', 'Model');
class BackupsController extends AppController {


protected function _connect($MYSQLHOST,$MYSQLUSER,$MYSQLPASS,$MYSQLDB)
    {
		if($this->link = new mysqli($MYSQLHOST,$MYSQLUSER,$MYSQLPASS)) {
			$this->link->select_db($MYSQLDB);
			$this->multiQuery('
				SET NAMES "utf8";
				SET collation_connection = "utf8_persian_ci";
				SET collation_server = "utf8_persian_ci";
				SET character_set_client = "utf8";
				SET character_set_connection = "utf8";
				SET character_set_results = "utf8";
				SET character_set_server = "utf8";
				SET CHARACTER SET UTF8;
				SET session collation_connection="utf8_persian_ci";
				DEFAULT CHARSET = "utf8"; ');
		}else {
			$this->link_flag=0;
			echo '::Error connecting to Databse::';
			die();
		}
	}
	
	public function closeConnection()
    {
        $this->link->close();
        $this->link = null;
    }
	
	
	
	/**
	 * DB::query()
	 * 
	 * @param string $sql
	 * @return
	 */
	function  query($sql)
	{
		return $this->link->query($sql);
	}
	
	
	/**
     * Begin a transaction.
     *
     * @return void
     */
    protected function _beginTransaction()
    {
        //$this->_connect();
        $this->link->autocommit(false);
		$this->link->query('START TRANSACTION');
    }

    /**
     * Commit a transaction.
     *
     * @return void
     */
    protected function _commit()
    {
        //$this->_connect();
        $this->link->commit();
        $this->link->autocommit(true);
    }

    /**
     * Roll-back a transaction.
     *
     * @return void
     */
    protected function _rollBack()
    {
       // $this->_connect();
        $this->link->rollback();
        $this->link->autocommit(true);
    }
	
	/**
	 * DB::query_arr()
	 * 
	 * @param string $sql
	 * @return
	 */
	function query_arr($sql_arr)
	{
		
		if(count($sql_arr)>0)
		{
			$this->_beginTransaction();
			foreach($sql_arr as $key=> $sql)
			 {
				if(trim($sql)!='')
				{
				  $error=$this->link->query($sql);
				   if(!$error)
					 {
					   $this->_rollBack(); 
					   return false;
					 }
				 }
			 }
			$this->_commit();
			//$this->closeConnection();
			return true;
			
		}
		return false;
	}
	
	/**
	 * DB::escape()
	 * 
	 * @param mixed $var
	 * @return
	 */
	function escape($var){
		return mysqli_real_escape_string($this->link,$var);
	}
	
	/**
	 * DB::num_rows()
	 * 
	 * @param mixed $result
	 * @return
	 */
	function num_rows($result)
	{
		return $result->num_rows;
	}
	/**
	 * DB::dbselect()
	 * 
	 * @param string $dbname
	 * @return
	 */
	function dbselect($dbname)
	{
		$this->link->select_db($dbname);
	}
		
	/**
	 * DB::insert_id()
	 * 
	 * @return
	 */
	function insert_id()
	{
		return mysqli_insert_id($this->link);
	}
	
	/**
	 * DB::getAll()
	 * 
	 * @param string $sql
	 * @return
	 */
	function getAll($sql)
	{
        $list = array();
		if($result=$this->link->query($sql)) {
			while($row=$result->fetch_array(MYSQLI_ASSOC))
				$list[]=$row;
				
			return $list;
		}else {
			return false;
		}
	}
	
	/**
	 * DB::getRow()
	 * 
	 * @param string $sql
	 * @return
	 */
	function getRow($sql)
	{
		
		if($result=$this->link->query($sql)) {
			$list=$result->fetch_array(MYSQLI_ASSOC);
			return $list;
		}else {
			
			return false;
		}
	}
	
	/**
	 * DB::getOne()
	 * 
	 * @param string $sql
	 * @return
	 */
	function getOne($sql)
	{
		if($result=$this->link->query($sql)) {
			$list=$result->fetch_row();
			$list=$list[0];
			return $list;
		}else {
			return false;
		}
	}
	
	
	/**
	 * DB::fieldCount()
	 * 
	 * @param string $sql
	 * @return
	 */
	function fieldCount($sql)
	{
		if($result=$this->link->query($sql)) {
			$count=$result->field_count;
			return $count;
		}else {
			return false;
		}
	}
	
	/**
	 * DB::multiQuery()
	 * 
	 * @param string $query
	 * @param mixed $params
	 * @return
	 */
	function multiQuery($query, $params = array())
	{
		if(empty($query)) return NULL;
		
		$qLine = explode("\n", $query);
		foreach($qLine as $key=>$q) {
			$qLine[$key] = trim($q);
		}
		$query = implode("\n", $qLine);
		$qLine = explode(";\n", $query);
		foreach($qLine as $key=>$q) {
			if(trim($q)){
				$res[] = $this->link->query($q);
			}	
		}
		return $res;
	}


 function admin_index()
	{
		$this->layout = $this->autoLayout = $this->autoRender = false;
		$dataSource= ConnectionManager::getDataSource('default');
		$database_name=	$dataSource->config['database']; 
		$host=$dataSource->config['host']; 
		$user=$dataSource->config['login']; 
		$password=$dataSource->config['password']; 
		$this->backup_tables($host,$user,$password,$database_name,'*');
	}
	
	
	function backup_tables($MYSQLHOST,$MYSQLUSER,$MYSQLPASS,$MYSQLDB,$tables = '*')
	 {
		 
		 $this->_connect($MYSQLHOST,$MYSQLUSER,$MYSQLPASS,$MYSQLDB);
		 $return = '';
		 if($tables == '*')
	    {
	        $tables = array();
	        $result = $this->getAll('SHOW TABLES');
			$index='Tables_in_'.$MYSQLDB;
			for ($i = 0; $i < count($result); $i ++)
	            {
					$tables[]=$result[$i][$index];
					
				}
	    
	    }
	    else
	    {
	        $tables = is_array($tables) ? $tables : explode(',',$tables);
	    }
		
		foreach($tables as $key=>$table)
	    {
			$sql='SELECT * FROM '.$table;
			$num_fields=$this->fieldCount($sql);
		  
	        
	        ///$return.= 'DROP TABLE '.$table.';';
			$sql='SHOW CREATE TABLE '.$table;
			$row2=$this->getRow($sql);
	        
	        $return.= "\n\n".$row2['Create Table'].";\n\n";
	        
			$sql='SELECT * FROM '.$table;
			
	        
	            
				$row=$this->getAll($sql);
							
				for ($i = 0; $i < count($row); $i ++)
	            {
					$j=0;
					$return.= 'INSERT INTO '.$table.' VALUES(';
					foreach ($row[$i] as $fieldname=>$value)
					 {	
						$value = addslashes($value);
	                    $value = ereg_replace("\n","\\n",$value);
	                    if (isset($value)) { $return.= '"'.$value.'"'; } 
						else { $return.= '""';}
						if ($j<($num_fields-1)) { $return.= ','; }
						$j++;
					 }
					 $return.= ");\n";
	 			}

	        
			
			
	        $return.="\n\n\n";

	    }
		
		
		//pr($return);exit();
		
		
		//save file

		$time=date('H.i.s');
		$today=date("dMY-his");
		$filenameSufix=$today.'-'.(md5(implode(',',$tables))).'.sql';
		$filename=__BackUp_Path.'db-backup-'.$filenameSufix;
	    $handle = fopen($filename,'w+');
	    fwrite($handle,$return);
	    fclose($handle);
		
		
		if (class_exists('ZipArchive') && filesize($filename) > 100) {
			$zip = new ZipArchive();
			$zip->open($filename . '.zip', ZIPARCHIVE::CREATE);
			$zip->addFile($filename, $filenameSufix);
			$zip->close();	
			if (file_exists($filename . '.zip') && filesize($filename) > 10) {
				unlink($filename);
			}
			$filename = $filename.'.zip';
		}
		
		
		if (file_exists($filename)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($filename));
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($filename));
		    ob_clean();
		    flush();
		    readfile($filename);
		    exit;
		}
		
		
	 }
	
	
}
?>