<?php
class QueryField extends Query {
    private $key;
    private $comp;
    private $value;

    function __construct($key = '', $comp='=', $value){
        if (!isset($key) || ctype_space($key) || empty($key)) {
            throw new Exception('Field cannot be empty.');
        }
        $this->key = $key;
        $this->comp = $comp;
        $this->value = $value;
    }

    function get_field(){
        return $this->key;
    }
    
    function set_field($field){
        $this->key = $field;
    }

    function get_value(){
        return $this->value;
    }
    
    function set_value($value){
        $this->value = $value;
    }

    function get_comparator(){
        return $this->comp;
    }
    
    public function to_parameterized_sql_string() {
        $query = "$this->key $this->comp ";
        $values = array();
        if (is_array($this->value)) {
            $query .= "(";
            foreach ($this->value as $value) {
                $query .= "?,";
            }
            $query = rtrim($query, ",");
            $query .= ")";
            $values = $this->value;
        } else {
            $query .= "?";
            array_push($values, $this->value);
        }
        
        return array("query"=>$query, "values"=>$values);
    }
    
    public function to_sql_string($quoteValue = false) {
        $query = "$this->key $this->comp ";
        
        if (is_array($this->value)) {
            $query .= "(";
            foreach ($this->value as $value) {
                if ($quoteValue) {
                    $query .= "'".mysql_escape_string($value)."'";
                } else {
                    $query .= $value;
                }
                $query .= ",";
            }
            $query = rtrim($query, ",");
            $query .= ")";
        } else {
            if ($quoteValue) {
                $query .= "'".mysql_escape_string($this->value)."'";
            } else {
                $query .= $this->value;
            }
        }
        
        return array("query"=>$query, "values"=>array());
    }
    
    public function is_empty() {
        return !isset($this->key) || empty($this->key) || ctype_space($this->key);
    }
    
    public function get_size() {
        return $this->is_empty() ? 0 : 1;
    }
    
    public function to_json($isJoin = false) {
        $result = array();
        $result['key'] = $this->key;
        
        if ($this->comp) {
            $result['comp'] = $this->comp;
        } else {
            $result['comp'] = '=';
        }
        
        if ($isJoin) {
            $result['value'] = $this->value;
        } else {
            $temp = "";
            if (is_array($this->value)) {
                $temp .= "(";
                foreach ($this->value as $value) {
                    $temp .= "?,";
                }
                $temp = rtrim($temp, ",");
                $temp .= ")";
            } else {
                $temp .= "?";
            }
            
            $result['value'] = $temp;
        }
        
        return $result;
    }
}

?>
