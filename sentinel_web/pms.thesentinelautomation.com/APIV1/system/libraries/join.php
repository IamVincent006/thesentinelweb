<?php
class Join {
    private $tableName = '';
    private $condition;
    private $modifier;
    
    function __construct($tableName = '', Query $condition, $modifier) {
        $this->condition = $condition;
        $this->tableName = $tableName;
        $this->modifier = $modifier;
    }
    
    public function get_table_name() {
        return $this->tableName;
    }
    
    public function get_condition() {
        return $this->condition;
    }
    
    public function get_modifier() {
        return $this->modifier;
    }
    
    public function to_json() {
        $result = array();
        if($this->tableName) {
            $result["tableName"] = $this->tableName;
        }
        if($this->modifier) {
            $result["modifier"] = $this->modifier;
        }
        if($this->condition) {
            $result["condition"] = $this->condition->to_json(true);
        }
        return $result;
    }
}
?>
