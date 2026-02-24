<?php
class Select extends Stmt {
    private $start = 0;
    private $limit = -1;
    private $fieldNames = array();
    private $sortDetails = array();
    private $groupFields = array();
    private $aggregate = false;
    private $class;
    private $joins = array();
   
    /**
     * @desc defaults to 0
     * @param number $start
     */
    public function set_start($start = 0) {
        $this->start = $start * 1;
    }

    /**
     * @desc defaults to 10
     * @param number $limit
     */
    public function set_limit($limit = -1) {
        $this->limit = $limit * 1;
    }

    /**
     * @desc Add field to be retrieved. Avoid using wildcards. use the aliases
     * @param string $fieldName
     */
    public function add_field($fieldName) {
        if(!isset($fieldName) || empty($fieldName) || ctype_space($fieldName)) {
            return;
        }
        array_push($this->fieldNames, $fieldName);

        //this would be useful later on
        $this->aggregate = $this->aggregate || strpos($fieldName, "\(") !== FALSE;
    }

    /**
     * @desc Add fields to be retrieved. Avoid using wildcards. use the aliases
     * @param array $fieldNames
     */
    public function add_fields(array $fieldNames) {
        if(!isset($fieldNames) || count($fieldNames) < 1) {
            return;
        }
        
        foreach ($fieldNames as $fieldName) {
            $this->add_field($fieldName);
        }
    }

    /**
     * @desc Add join table
     * @param Join $join
     */
    public function add_join(Join $join) {
        if(null == $join) {
            return;
        }
        array_push($this->joins, $join);

    }

    /**
     * @desc Add join tables
     * @param array $joins array of Join
     */
    public function add_joins(array $joins) {
        if(!isset($joins) || count($joins) < 1) {
            return;
        }
        
        foreach ($joins as $join) {
            $this->addJoin($join);
        }
    }

    /**
     * @desc Conditions for joining tables. Note that this is simply concatenated.
     * @param CLQuery $joinCondition
     */
    public function set_join_condition(Query $joinCondition) {
        $this->joinCondition = $joinCondition;
    }

    /**
     * @desc Add field for sort.
     * @param unknown $fieldName
     */
    public function add_sort($fieldName) {
        if(!isset($fieldName) || empty($fieldName) || ctype_space($fieldName)) {
            return;
        }
        array_push($this->sortDetails, $fieldName);
    }

    /**
     * @desc Add fields for sort. 
     * @param array $fieldName
     */
    public function add_sorts(array $fieldNames) {
        if(!isset($fieldNames) || count($fieldNames) < 1) {
            return;
        }
    
        foreach ($fieldNames as $fieldName) {
            $this->add_sort($fieldName);
        }
    }
    
    /**
     * @desc Add field for group. 
     * @param string $fieldName
     */
    public function add_group($fieldName = '') {
        if(!isset($fieldName) || empty($fieldName) || ctype_space($fieldName)) {
            return;
        }
        array_push($this->groupFields, $fieldName);
    }
    
    /**
     * @desc Add fields for group. e.g. array("field1", "field2", "field3")
     * @param array $fieldName
     */
    public function add_groups(array $fieldNames) {
        if(!isset($fieldNames) || count($fieldNames) < 1) {
            return;
        }
    
        foreach ($fieldNames as $fieldName) {
            $this->add_group($fieldName);
        }
    }
    
    /**
     * @desc Cause the return object of the query to be an array of this object
     * @param string $class
     */
    public function set_return_class($class) {
        $this->class = $class;
    }

    public function get_start() {
        return $this->start;
    }

    public function get_limit() {
        return $this->limit;
    }

    public function get_fields() {
        return $this->fieldNames;
    }

    public function get_joins() {
        return $this->joins;
    }

    public function get_sorts() {
        return $this->sortDetails;
    }

    public function get_groups() {
        return $this->groupFields;
    }

    public function is_aggregate() {
        return $this->aggregate;
    }

    public function validate() {
        parent::validate();
        
        if (!isset($this->fieldNames) || count($this->fieldNames) < 1) {
            throw new Exception('Place the fields to be retrieved');
        }
        
        $this->validate_group_values();
        $this->validate_sort_values();
    }

    public function get_return_class() {
        return $this->class;
    }
    
    public function validate_sort_values(){
        $invalids = array();
        foreach ($this->sortDetails as $column) {
            if(!preg_match("/((\w+\.)?\w+)?/", $column)){
                array_push($invalids, $column);
            }
        }
        if (count($invalids) > 0) {
            throw new Exception("Invalid sort column(s) detected: ".implode(", ", $invalids));
        }
    }
    
    public function validate_group_values(){
        $invalids = array();
        foreach ($this->groupFields as $column) {
            if(!preg_match("/((\w+\.)?\w+)?/", $column)){
                array_push($invalids, $column);
            }
        }
        if (count($invalids) > 0) {
            throw new Exception("Invalid group column(s) detected: ".implode(", ", $invalids));
        }
    }
    
    public function to_json() {
        $stmt = array();
        $stmt = array_merge($stmt, parent::toJson());
        if ($this->fieldNames) {
            $stmt["fieldNames"] = $this->fieldNames;
        }
        if ($this->sortDetails) {
            $stmt["sortDetails"] = $this->sortDetails;
        }
        if ($this->groupFields) {
            $stmt["groupFields"] = $this->groupFields;
        }
        if ($this->joins) {
            $temp = array();
            foreach ($this->joins as $k=>$v) {
                $temp[] = $v->to_json();
            }
            $stmt["joins"] = $temp;
        }
        if ($this->start) {
            $stmt["start"] = $this->start;
        }
        if ($this->limit) {
            $stmt["limit"] = $this->limit;
        }
        
        $result = array();
        $result["stmt"] = $stmt;
        
        $prepCond = $this->get_condition()->to_parameterized_sql_string();
        $result["values"] = $prepCond["values"];
        
        return $result;
    }
}

?>
