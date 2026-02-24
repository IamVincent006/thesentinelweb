<?php
class XmlLogs extends Model {
    
    private $tableName;
    private $model;
    
    public function __construct() {
        $this->model     = new Model();
        $this->tableName = PREFIX.'xml_logs';
    }
    
    public function insert_xml_logs($data=array()) {
        $insertXmlLogs = $this->insert($this->tableName,$data);
        return $insertXmlLogs;
    }
    
}
?>