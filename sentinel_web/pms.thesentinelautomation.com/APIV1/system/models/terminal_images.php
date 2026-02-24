<?php
class TerminalImages extends Model {
    
    private $tableName;
    private $model;
    
    public function __construct() {
        $this->model     = new Model();
        $this->tableName = PREFIX.'terminal_images';
    }
    
    public function get_terminal_images($terminalID) {
        $terminalImageDetails = $this->model->show_records(array("terminalID","terminalImage","terminalImageCode"),$this->tableName, new QueryField("terminalID","=",$terminalID),array("terminalImageCode ASC"));
        return $terminalImageDetails;
    }
    
    
}
?>