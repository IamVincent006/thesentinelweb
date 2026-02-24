<?php
/**
 * @desc A builder class that calls the functional parameters in a given condition
 */
class QueryGroup extends Query{
    private $ored = array();
    private $anded = array();

    /**
     * @desc OR condition
     * 
     */
    public function or_query(Query $query) {
        array_push($this->ored, $query);
    }

    /**
     * Use AND on this condition along with other conditions in this object
     */
    public function and_query(Query $query) {
        array_push($this->anded, $query);
    }

    public function to_parameterized_sql_string() {
        return $this->construct_sql_string(true);
    }
    
    public function to_sql_string($quoteValue = false) {
        return $this->construct_sql_string(false, $quoteValue);
    }
    
    public function is_empty() {
        return empty($this->anded) && empty($this->ored);
    }
    
    public function to_json() {
        $result = array();
        foreach ($this->anded as $k=>$v) {
            $result[] = $v->to_json();
        }
        $result = array("and" => $result);
        if (count($this->ored) < 1) {
            return $result;
        }
        $tmp = array($result);
        foreach ($this->ored as $k=>$v) {
            $tmp[] = $v->toJson();
        }
        return array("or"=>$tmp);
    }
    
    private function construct_sql_string($parameterize=false, $quoteValue = false) {
        $bindValues = array();
        $temp = $this->join_query($this->anded, $parameterize, false, $quoteValue);
        $ands = $temp["fields"];
        $bindValues = array_merge($bindValues, $temp["values"]);
    
        if (count($this->ored) < 1) {
            return array("query"=>implode(" AND ", $ands), "values"=>$bindValues);
        }
    
        $ord = array();
        if (count($ands) > 0) {
            array_push($ord, "(".implode(" AND ", $ands).")");
        }
    
        $temp = $this->join_query($this->ored, $parameterize, true, $quoteValue);
        $ord = array_merge($ord, $temp["fields"]);
        $bindValues = array_merge($bindValues, $temp["values"]);
    
        return array("query"=>"(".implode(" OR ", $ord).")", "values"=>$bindValues);
    }


    private function join_query(array $toProcess, $parameterize = false, $groupMulti = false, $quoteValue = false){
        $fields = array();
        $bindValues = array();
    
        foreach ($toProcess as $k=>$v) {
            if ($parameterize) {
                $sub = $v->to_parameterized_sql_string();
            } else {
                $sub = $v->to_sql_string($quoteValue);
            }
            
            if ($v->get_size() > 1 && $groupMulti) {
                array_push($fields, "(".$sub["query"].")");
            } else {
                array_push($fields, $sub["query"]);
            }
            $bindValues = array_merge($bindValues, $sub["values"]);
        }
    
        return array("fields"=>$fields, "values"=>$bindValues);
    }
    
    public function get_size() {
        return count($this->anded) + count($this->ored);
    }
    
    public function get_conditions() {
        return array_merge($this->anded, $this->ored);
    }
    
    public function get_ored() {
        return $this->ored;
    }
    
    public function get_anded() {
        return $this->anded;
    }
}

?>
