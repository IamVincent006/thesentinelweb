<?php
class Supplier_Wallet extends Model {
    
    private $tableName;
    private $model;
    
    public function __construct() {
        $this->model     = new Model();
        $this->tableName = PREFIX.'supplier_wallet';
    }
    
}
?>