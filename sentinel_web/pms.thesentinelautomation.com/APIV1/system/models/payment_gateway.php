<?php
class PaymentGateway extends Model {
    
    private $tableName;
    private $model;
    
    public function __construct() {
        $this->model     = new Model();
        $this->tableName = PREFIX.'payment_gateway';
    }
    
    public function get_payment_gateway_url($paymentGatewayID) {
        $paymentGatewayDetails = $this->model->show_records(array("url"),$this->tableName, new QueryField("paymentGatewayID","=",$paymentGatewayID));
        return $paymentGatewayDetails[0]['url'];
    }
    
}

?>