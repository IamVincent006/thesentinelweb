<?php
class Stmt extends Database {
    private $tableName = '';
    private $condition;
    private $dbh;

    function __construct() {
        $this->condition = new QueryGroup();
    }

    /**
     * @desc Add table to look up to. make sure to add aliases. 
     * @param variable $tableName
     */
    public function set_table_name($tableName) {
        $this->tableName = $tableName;
    }

    /**
     * @desc Conditions for the actual search. This will be parameterized.
     * @param Query $condition
     */
    public function set_condition(Query $condition) {
        if (null == $condition) {
            return;
        }
        $this->condition = $condition;
    }

    public function get_table_name() {
        return $this->tableName;
    }

    public function get_condition() {
        return $this->condition;
    }

    public function validate() {
        if (!isset($this->tableName) || ctype_space($this->tableName) || empty($this->tableName)) {
            throw new Exception('Specify a source');
        }
    }
    
    public function to_json() {
        $result = array();
        if ($this->tableName) {
            $result["tableName"] = $this->tableName;
        }
        if ($this->condition) {
            $result["condition"] = $this->condition->to_json();
        }
        return $result;
    }
}
?>
