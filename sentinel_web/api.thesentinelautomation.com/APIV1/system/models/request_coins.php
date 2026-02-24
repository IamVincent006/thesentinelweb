<?php
class RequestCoins extends Model {
    
    private $tableName;
    private $model;
    
    public function __construct() {
        $this->model     = new Model();
        $this->tableName = PREFIX.'request_coins';
    }
    
    /**
     * @desc Insert and queue
     * @param array $requestBody
     * @return lastID
     */
    public function insertRequest($requestBody=array()) {
        return $this->insert($this->tableName,$requestBody,1);
    }
    
    /**
     * @desc Check for existence of the queued request
     * @param integer $requestID
     * @return array
     */
    public function checkRequest($requestID) {
        $select = new Select();
        $select->add_fields(array("requestCoin"));
        $select->set_table_name($this->tableName);
        $select->set_condition(new QueryField("requestCoinID", "=", $requestID));
        
        $checkRequest = $this->select($select);
        
        return $checkRequest;
    }
    
}
?>