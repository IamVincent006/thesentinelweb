<?php
abstract class Query extends Core {
    /**
     * @desc Handle values where the result of array is a key-value pair
     * 
     * @param array $condition a key-value pair array.
     * @return QueryGroup
     */
    public static function convert_to_query(array $condition) {
        $result = new QueryGroup();
        foreach($condition as $k=>$v) {
            $result->andQuery(new QueryField($k, "=", $v));
        }
        return $result;
    }
    
    /**
     * @desc Meant to be used for user provided conditions.
     */    
    abstract public function to_parameterized_sql_string();
    
    /**
     * @desc Meant to be used for table join related conditions.
     *
     * @return array
     */
    abstract public function to_sql_string($quoteValue = false);
    
    /**
     * @desc Retrieve the number of conditions present in this query
     * @return integer
     */
    abstract public function get_size();
    
    /**
     * @desc Check if this query contains an actual restriction or not
     * @return boolean
     */
    abstract public function is_empty();
    
    /**
     * @desc Converts to an object 
     * @return array
     */
    abstract public function to_json();

}
?>
