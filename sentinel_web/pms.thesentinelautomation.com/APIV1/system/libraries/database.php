<?php
/**
 * @desc Database connectivity using PDO (PHP Data Object)
 * @since August 15, 2016
 */
class Database extends Core implements DatabaseClient {
	
	

	public function __construct() {
		
	}
	/**
	 * @desc Create select statement
	 **/
	public function select(Select $select) {
        
	$select->validate();

        $sql 	= "SELECT ".implode(",", $select->get_fields())." FROM ".$select->get_table_name();
       
        if (null !== $select->get_joins() && count($select->get_joins()) > 0) {
            foreach ($select->get_joins() as $join) {
                $query = $join->get_condition()->to_sql_string();
                $sql .= " ".$join->get_modifier()." JOIN ".$join->get_table_name()." ON ".$query["query"];
                
            }
        }
        
        $bindValues = array();

        if (null !== $select->get_condition() && !$select->get_condition()->is_empty()) {
            $sql = $sql." WHERE ";
            $temp = $select->get_condition()->to_parameterized_sql_string();

            $sql = $sql.$temp["query"];
            $bindValues = $temp["values"];
        }

        if(null !== $select->get_groups() && count($select->get_groups())>0) {
            $sql  = $sql." GROUP BY ".implode(",", $select->get_groups());
        }

        if(null !== $select->get_sorts() && count($select->get_sorts())>0) {
            $sql  = $sql." ORDER BY ".implode(",", $select->get_sorts());
        }

        if ($select->get_limit() > 0 && $select->get_start() > 0) {
            $sql  = $sql." LIMIT ?, ?";
        } else if ($select->get_limit() > 0) {
            $sql  = $sql." LIMIT ?";
        }
        
        
        
        $stmt = $this->prepare_statement($sql, $bindValues);
        
        if ($select->get_limit() > 0 && $select->get_start() > 0) {
            //because limit will not accept strings, type has to be specified.
            $stmt->bindValue(count($bindValues) + 1, $select->get_start(), PDO::PARAM_INT);
            $stmt->bindValue(count($bindValues) + 2, $select->get_limit(), PDO::PARAM_INT);
        } else if ($select->get_limit() > 0) {
            //because limit will not accept strings, type has to be specified.
            $stmt->bindValue(count($bindValues) + 1, $select->get_limit(), PDO::PARAM_INT);
        }
        
        $stmt->execute() !== false or $this->errorinfo ();
        
        $result = array();
        if (null !== $select->get_return_class()) {
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, $select->get_return_class());
        } else {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }
    
    /** 
     * @param string $procedureName
     * @param array $input These will be forwarded to the stored procedure in the same chronology
     */
    public function call_stored_procedure($procedureName = '', array $input = null) {
        if(!isset($procedureName) || empty($procedureName) || ctype_space($procedureName)) {
            throw new Exception("Procedure Name cannot be empty.");
        }
        
        $sql = "CALL $procedureName (";
        if (isset($input) && count($input) > 0) {
            foreach($input as $i) {
                $sql .= "?,";
            }
            $sql = rtrim($sql, ",");
        }
        $sql .= ")";
        
        $stmt = $this->prepare_statement($sql, $input);
        $stmt->execute() !== false or $this->errorinfo ();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * 
     * @param string $tableName
     * @param array $data containing fields to be set.
     * @throws Exception
     * @return last generated id (when applicable)
     */
    public function insert($tableName='', array $data) {
    	global $dbh;
        foreach ($data as $k=>$v)    {
            $new[] = $k;
            $placeholder[] = "?";
            $bindValues[] = "$v";
        }
        
        if (!isset($tableName) || ctype_space($tableName) || empty($tableName)) {
            throw new Exception("Target table must be set.");
        }
        
        $fields = implode(", ", $new);
        $values = implode(", ", $placeholder);
        $sql = "INSERT INTO $tableName ($fields) VALUES ($values)";
        $stmt = $this->prepare_statement($sql, $bindValues);
        
        $lastInsertID = $stmt->execute() or $this->errorinfo();
        return $dbh->lastInsertId();
    }


     /**
     * 
     * @param string $tableName
     * @param array $data containing fields to be set.
     * @throws Exception
     * @return last generated id (when applicable)
     */
    public function replace($tableName='', array $data) {
    	global $dbh;
        foreach ($data as $k=>$v)    {
            $new[] = $k;
            $placeholder[] = "?";
            $bindValues[] = "$v";
        }
        
        if (!isset($tableName) || ctype_space($tableName) || empty($tableName)) {
            throw new Exception("Target table must be set.");
        }
        
        $fields = implode(", ", $new);
        $values = implode(", ", $placeholder);
        $sql = "replace into $tableName ($fields) VALUES ($values)";
        $stmt = $this->prepare_statement($sql, $bindValues);
        
        $lastInsertID = $stmt->execute() or $this->errorinfo();
        return $dbh->lastInsertId();
    }



    /**
     * @param string $tableName
     * @param array $data containing fields to be set. 
     * @throws Exception
     * @return boolean if successful or not
     */
    public function update($tableName='', array $data, Query $conditions) {
        if (!isset($tableName) || ctype_space($tableName) || empty($tableName)) {
            throw new Exception("Target table must be set.");
        }
        if (!isset($conditions) || $conditions->is_empty()) {
            throw new Exception("Condition must be set.");
        }
        
        $sql = " UPDATE $tableName SET ";
        foreach ($data as $k=>$v) {
            $bindValues[] = $v;
            $sql = $sql." $k = ?,";
        }
        $sql = rtrim($sql, ",");
        
        $query = $conditions->to_parameterized_sql_string();
        $sql = $sql." WHERE ".$query["query"];
        
        $bindValues = array_merge($bindValues, $query["values"]);
        $stmt = $this->prepare_statement($sql, $bindValues);
                
        $result = $stmt->execute() or $this->errorinfo();
        return $result;
    }


   

    /**
     * 
     * @param string $tablename
     * @param Query $conditions limit update to records that satisfy the given condition. Required.
     * @throws Exception
     * @return boolean
     */
    public function delete($tablename='', Query $conditions) {
        //do not allow an empty delete
        if (!isset($conditions)
               || $conditions->is_empty()) {
            throw new Exception("Condition must be set.");
        }

        $query = $conditions->to_parameterized_sql_string();

        $sql = "DELETE FROM $tablename WHERE ".$query["query"];
        $stmt = $this->prepare_statement($sql, $query["values"]);
        
        return $stmt->execute() or $this->errorinfo ();
    }

	
	/**
	 * @desc Create prepare statements to call queries
	 * @param string $sql
	 * @param array $values
	 * @return PDOStatement
	 */
	private function prepare_statement($sql, array $values = null) {
		global $dbh;	
		$dbh = $this->db_connect();

		
		$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$stmt = $dbh->prepare($sql);
	
		if (isset($values) && count($values) > 0) {
			foreach ($values as $k=>$v) {
				if ($v === null) {
					$stmt->bindValue($k + 1, null);
				}else {
					$stmt->bindValue($k + 1, "$v");
				}
			}
		}
		return $stmt;
		
	}
	
	public function get_as_map($inTable, $inTableKey, array $inFields) {
		$select = new Select();
	
		$select->add_fields(array_merge($inFields, array($inTableKey)));
	
		$select->set_table_name($inTable);
		$details = $this->select($select);
		$result = array();
		foreach ($details as $detail) {
			$result[$detail[$inTableKey]] = $detail;
		}
		return $result;
	}
	
	public function get_as_map_from_list($inList, $inListKey, $inTable, $inTableKey, array $inFields, $inGroupFields = null) {
		
		$values = array();
		foreach($inList as $item) {
			$value = $item[$inListKey];
			if ($value == null || $value == "") {
				continue;
			}
			array_push($values, $value);
		}
		$values = array_unique($values);
		if (count($values) < 1) {
			return array();
		}
		 
		$result = array();
		$select = new Select();
		$select->add_fields(array_merge($inFields, array($inTableKey)));
	
		if ($inGroupFields != null) {
			$select->add_groups($inGroupFields);
		}
	
		$select->set_table_name($inTable);
	
		$chunks = array_chunk($values, 500);
		foreach($chunks as $chunk) {
			$condition = new QueryField($inTableKey, 'in', $chunk);
			 
			$select->set_condition($condition);
			$details = $this->select($select);
			foreach ($details as $detail) {
				$result[$detail[$inTableKey]] = $detail;
			}
		}
		return $result;
	}
	
	public function get_as_map_from_list_stmt($inList, $inListKey, $select, $inTableKey, $inTableKeyPrefix = null, $inAddCond = null) {
		
		$values = array();
		foreach($inList as $item) {
			$value = $item[$inListKey];
			if ($value == null || $value == "") {
				continue;
			}
			array_push($values, $value);
		}
		$values = array_unique($values);
		if (count($values) < 1) {
			return array();
		}
	
		$result = array();
		$condField = $inTableKey;
		if ($inTableKeyPrefix != null) {
			$condField = $inTableKeyPrefix.".".$inTableKey;
		}
	
		$chunks = array_chunk($values, 500);
		foreach($chunks as $chunk) {
			$condition = new QueryField($inTableKey, 'in', $chunk);
			 
			if ($inAddCond != null){
				$finCond = new QueryGroup();
				$finCond->and_query($inAddCond);
				$finCond->and_query($condition);
				 
				$select->set_condition($finCond);
			} else {
				$select->set_condition($condition);
			}
			 
			$details = $this->select($select);
			foreach ($details as $detail) {
				$result[$detail[$inTableKey]] = $detail;
			}
		}
		 
		return $result;
	}
	

	public function get_as_map_of_list_from_list_stmt($inList, $inListKey, $inTable, $inTableKey, array $inFields, $inAddCond = null, $inGroup = null, $inSort = null) {
		
		$values = array();
		foreach($inList as $item) {
			$value = $item[$inListKey];
			if ($value == null || $value == "") {
				continue;
			}
			array_push($values, $value);
		}
		$values = array_unique($values);
		if (count($values) < 1) {
			return array();
		}
	
		$result = array();
		$select = new Select();
		$select->add_fields(array_merge($inFields, array($inTableKey)));
	
		if ($inGroup != null) {
			$select->add_groups(array_unique(array_merge(array($inTableKey), $inGroup)));
		}
	
		$select->set_table_name($inTable);
		if ($inSort != null) {
			$select->add_sorts($inSort);
		}
	
		$chunks = array_chunk($values, 500);
		foreach($chunks as $chunk) {
			$condition = new QueryField($inTableKey, 'in', $chunk);
			 
			if ($inAddCond != null){
				$finCond = new QueryGroup();
				$finCond->and_query($inAddCond);
				$finCond->and_query($condition);
	
				$select->set_condition($finCond);
			} else {
				$select->set_condition($condition);
			}
			$details = $this->select($select);
			foreach ($details as $detail) {
				if (!array_key_exists($detail[$inTableKey], $result)
						|| $result[$detail[$inTableKey]] == null) {
							$result[$detail[$inTableKey]] = array();
						}
						array_push($result[$detail[$inTableKey]], $detail);
			}
		}
		 
		return $result;
	}
	
	/**
	 * @desc Connect to database
	 * @return PDO
	 */
	private function db_connect() {
		
		try {
			$dbh = new PDO(
						  DB_TYPE.":host=".DB_HOSTNAME.";dbname=".DB_NAME,
						  DB_USERNAME,
						  DB_PASSWORD,
						  array(PDO::ATTR_PERSISTENT => true)
						  );
		} catch (Exception $e) {
			error_log("Unable to establish connection to ".DB_TYPE." database: ".$e->getMessage());
		}
		return $dbh;
		
	}
	
	
	

}
?>
