<?php
class Transaction extends Model {
    
    private $tableName;
    private $model;
    
    public function __construct() {
        $this->model     = new Model();
        $this->tableName = PREFIX.'transaction';
		
		$this->tableNameTerminals = PREFIX.'terminals';
        $this->tbl_payment = PREFIX.'payment';

		$this->tableNameProperty = PREFIX.'property';
    }
    
    public function insert_transaction($list=array()) {
        $insertParkID = $this->insert($this->tableName,$list);
        return $insertParkID;
    }

    public function DeleteTransaction($ParkID) {

        $DeleteParkID = $this->delete($this->tableName,new QueryField("park_id","=",$ParkID));
        return $DeleteParkID;
    }
    


   /* public function update_transaction($parkID,$exitlogid,$exitdate,$process) {
        $condition = new QueryField("parkID","=",$parkID);

        $list  = array(
            'exitdate' => $exitdate,
            'exitlogid' => $exitlogid,
            'process' => $process
         );

        $this->update($this->tableName,$list, $condition);  
    }*/

    public function get_parker_model($Platenum,$StartDate,$EndDate) {
        
        $condition = new QueryGroup();   
        $condition->and_query(new QueryField("process","!=",1));
        $condition->and_query(new QueryField("process","!=",100)); 
        $condition->and_query(new QueryField("entrydate",">=",$StartDate)); 
        $condition->and_query(new QueryField("entrydate","<=",$EndDate)); 
        $condition->and_query(new QueryField("platenum", "like", "%$Platenum%")); 
        $terminalDetails = $this->model->show_records(array("park_id","cardserial","entry_termid","entryarea_id","entrydate",
            "entrycarimage","entryfaceimage","process","platenum","ratetype"),$this->tableName, $condition);
        return $terminalDetails;       

    }
    public function void_model($Query,$datelogin) {


		$conditionplatenum = new QueryGroup();
        $conditionplatenum->or_query(new QueryField($this->tableName.".platenum","like","%$Query%"));

		$conditionreceiptnum = new QueryGroup();
        $conditionreceiptnum->or_query(new QueryField($this->tableName.".receiptnum","like","%$Query%"));
        $conditionreceiptnum->or_query($conditionplatenum);    

        $condition = new QueryGroup();  
		$condition->and_query(new QueryField($this->tableName.".process","!=",0));
        $condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$datelogin)); 
        $condition->and_query($conditionreceiptnum);
		
		
		
		
		
        //$condition->and_query(new QueryField($this->tableName.".process","!=",0));
        //$condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$datelogin));
        //$condition->and_query(new QueryField($this->tableName.".platenum","like","%$Query%"));
        //$condition->and_query(new QueryField($this->tableName.".receiptnum","like","%$Query%"));



        $select = new Select();
        $select->add_fields(array("
                    $this->tbl_payment.park_id as parkid,
                    payid,
                    cardserial,
                    entry_termid,
                    entrydate,
                    entrycarimage,
                    entryfaceimage,
                    process,
                    platenum,
                    payment_termid,
                    $this->tbl_payment.charge,
                    $this->tableName.ratetype,
                    $this->tableName.receiptnum

                 "));

        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        $select->set_condition($condition);
        $checkTransList =   $this->select($select);

        return $checkTransList;


    }

    public function reprint_model($Query) {



        $condition = new QueryGroup();

        $condition->or_query(new QueryField($this->tableName.".platenum","like","%$Query%"));
        $condition->or_query(new QueryField($this->tableName.".receiptnum","like","%$Query%"));



        $select = new Select();
        $select->add_fields(array("
                    $this->tbl_payment.park_id as parkid,
                    payid,
                    cardserial,
                    entry_termid,
                    entrydate,
                    entrycarimage,
                    entryfaceimage,
                    process,
                    platenum,
                    payment_termid,
                    $this->tbl_payment.charge,
                    $this->tableName.ratetype,
                    $this->tableName.receiptnum

                 "));

        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        $select->set_condition($condition);
        $checkTransList =   $this->select($select);

        return $checkTransList;


    }

    public function Monitoring() {
        $condition = new QueryGroup();   

        $terminalDetails = $this->model->show_records(array("park_id","entryarea_id","entry_termid ","cardserial","entry_termid","entryarea_id","entrydate","payment_termid","exit_termid","paymentdate","exitdate","entrycarimage",
            "entryfaceimage","process","platenum","ratetype","brandmodel","confidence","carcolor","vehicletype","exitcarimage","exitfaceimage"),$this->tableName, $condition);
        return $terminalDetails;        
    }


    public function getsynctransactionprocess() {
        $condition = new QueryGroup();   
        //$condition->and_query(new QueryField("process","=",2)); //for temporary
        $terminalDetails = $this->model->show_records(array("park_id","cardserial",
            "old_cardserial","payment_termid","paymentdate","process","platenum","ratetype","tellerid","paymentarea_id","receiptnum","voidnum","receiptnum","setl_ref","dccode"),$this->tableName, $condition);
        return $terminalDetails;        
    }

    public function transaction_getdate_model($terminal,$todate){


        $condition = new QueryGroup();
        
     
        $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$todate));
        $condition->and_query(new QueryField($this->tableName.".receiptnum","!=", ""));
        //$condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$from_date));


        $select = new Select();
        $select->add_fields(array("

                    count(*) as tcount,
                    min(DATE_FORMAT($this->tbl_payment.paymentdate, '%Y-%m-%d')) as minpaydate,
                    max(DATE_FORMAT($this->tbl_payment.paymentdate, '%Y-%m-%d')) as maxpaydate

                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        //$select->add_sort($this->tableName.".park_id DESC");
        $select->set_condition($condition);
        $checkTransList =   $this->select($select);

        return $checkTransList;


    }
     
     



    public function transaction_oldreceipt_model($terminal){


        $condition = new QueryGroup();
        
     



        $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));
        $condition->and_query(new QueryField($this->tableName.".receiptnum","!=", ""));
        //$condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$from_date));


        $select = new Select();
        $select->add_fields(array("


                    min($this->tbl_payment.receiptnum) as oldmin_or,                    
                    min($this->tableName.voidnum) as oldmin_void,
                    max($this->tableName.voidnum) as oldmax_void,
                    min($this->tableName.refundnum) as oldmin_refund,
                    max($this->tableName.refundnum) as oldmax_refund

                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        //$select->add_sort($this->tableName.".park_id DESC");
        $select->set_condition($condition);
        $checkTransList =   $this->select($select);

        return $checkTransList;


    }

    public function transaction_oldtotal_model($terminal,$from_date){


        $condition = new QueryGroup();
        
        $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$from_date));



        $select = new Select();
        $select->add_fields(array("



                sum($this->tbl_payment.initcharge + $this->tbl_payment.surcharge + $this->tbl_payment.lostcharge + $this->tbl_payment.oncharge) as oldtotal,
                count(*) as oldcount

                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        //$select->add_sort($this->tableName.".park_id DESC");
        $select->set_condition($condition);
        $checkTransList =   $this->select($select);

        return $checkTransList;


    }

    public function transaction_groupbyrate_void_model($terminal,$tellerid,$from_date,$to_date,$area){


        $condition = new QueryGroup();
        
        if($area==0)
            $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));
        else
            $condition->and_query(new QueryField($this->tableName.".paymentarea_id","=",$area));

        $condition->and_query(new QueryField($this->tableName.".tellerid","=",$tellerid));
        $condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$from_date));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$to_date));
        //$condition->and_query(new QueryField("process","!=",98)); // tag as void
        //$condition->and_query(new QueryField("process","!=",99)); // tag as return

        $select = new Select();


        $select->add_fields(array("
                $this->tbl_payment.ratetype,
                process,
                count(*) as count,
                sum($this->tbl_payment.charge) as charge,
                sum($this->tbl_payment.initcharge) as initcharge,
                sum($this->tbl_payment.surcharge) as surcharge,
                sum($this->tbl_payment.oncharge) as oncharge,
                sum($this->tbl_payment.lostcharge) as lostcharge,
                sum($this->tbl_payment.vat) as vat,
                sum($this->tbl_payment.vatexempt) as vatexempt,
                sum($this->tbl_payment.discount) as discount,
                sum($this->tbl_payment.vatsales) as vatsales,
                $this->tbl_payment.ratetype
                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        $select->set_condition($condition);
        $select->add_group($this->tbl_payment.".ratetype");
        $select->add_group($this->tableName.".process");
        $checkTransList =  $this->select($select);

        return $checkTransList;

    }

    public function transaction_groupbyrate_zreading_model($terminal,$from_date,$to_date,$area){


        $condition = new QueryGroup();
        
        if($area==0)
            $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));
        else
            $condition->and_query(new QueryField($this->tableName.".paymentarea_id","=",$area));


        $condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$from_date));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$to_date));
        //$condition->and_query(new QueryField("process","!=",98)); // tag as void
        //$condition->and_query(new QueryField("process","!=",99)); // tag as return

        $select = new Select();


        $select->add_fields(array("
                SUM(IF($this->tbl_payment.ratetype='10', $this->tbl_payment.vatexempt, 0)) as PWD,
                SUM(IF($this->tbl_payment.ratetype='2', $this->tbl_payment.vatexempt, 0)) as SC,
                SUM(IF(process!=98 and $this->tbl_payment.vatsales>=1, $this->tbl_payment.initcharge + $this->tbl_payment.surcharge + $this->tbl_payment.oncharge + $this->tbl_payment.lostcharge, 0)) as netamount,
                process,
                $this->tbl_payment.ratetype,
                count(*) as count,
                sum($this->tbl_payment.charge) as charge,
                sum($this->tbl_payment.initcharge) as initcharge,
                sum($this->tbl_payment.surcharge) as surcharge,
                sum($this->tbl_payment.oncharge) as oncharge,
                sum($this->tbl_payment.lostcharge) as lostcharge,
                sum($this->tbl_payment.vat) as vat,
                sum($this->tbl_payment.vatexempt) as vatexempt,
                sum($this->tbl_payment.discount) as discount,
                sum($this->tbl_payment.vatsales) as vatsales,
                $this->tbl_payment.ratetype
                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        $select->set_condition($condition);
        $select->add_group($this->tbl_payment.".ratetype");
        $select->add_group($this->tableName.".process");
        $checkTransList =  $this->select($select);

        return $checkTransList;

    }

    public function transaction_groupbyrate_model($terminal,$from_date,$to_date,$area){


        $condition = new QueryGroup();
        
        if($area==0)
            $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));
        else
            $condition->and_query(new QueryField($this->tableName.".paymentarea_id","=",$area));


        //$condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$from_date));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$to_date));
        //$condition->and_query(new QueryField("process","!=",98)); // tag as void
        //$condition->and_query(new QueryField("process","!=",99)); // tag as return

        $select = new Select();


        $select->add_fields(array("
                process,
                $this->tbl_payment.ratetype,
                count(*) as count,
                sum($this->tbl_payment.charge) as charge,
                sum($this->tbl_payment.initcharge) as initcharge,
                sum($this->tbl_payment.surcharge) as surcharge,
                sum($this->tbl_payment.oncharge) as oncharge,
                sum($this->tbl_payment.lostcharge) as lostcharge,
                sum($this->tbl_payment.vat) as vat,
                sum($this->tbl_payment.vatexempt) as vatexempt,
                sum($this->tbl_payment.discount) as discount,
                sum($this->tbl_payment.vatsales) as vatsales,
                $this->tbl_payment.ratetype
                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        $select->set_condition($condition);
        $select->add_group($this->tbl_payment.".ratetype");
        $select->add_group($this->tableName.".process");
        $checkTransList =  $this->select($select);

        return $checkTransList;

    }
    public function transaction_groupbydate_model($terminal,$from_date,$to_date){


        $condition = new QueryGroup();
        
        $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));

        $condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$from_date));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$to_date));

        $select = new Select();


        $select->add_fields(array("

            
            
            SUM(IF($this->tbl_payment.ratetype=10 and process !=98 and process!=99, $this->tbl_payment.vatexempt, 0)) as PWD,
            SUM(IF($this->tbl_payment.ratetype=2 and process !=98 and process!=99, $this->tbl_payment.vatexempt, 0)) as SC,

            SUM(IF(process!=98 and $this->tbl_payment.vatsales>=1, $this->tbl_payment.initcharge + $this->tbl_payment.surcharge + $this->tbl_payment.oncharge + $this->tbl_payment.lostcharge, 0)) as netamount,


            SUM(IF(process='98', $this->tbl_payment.initcharge + $this->tbl_payment.surcharge + $this->tbl_payment.oncharge + $this->tbl_payment.lostcharge , 0)) as void,
            SUM(IF(process='99', $this->tbl_payment.charge, 0)) as refund,
            date($this->tbl_payment.paymentdate) as pdate,
            min($this->tbl_payment.receiptnum) as min_or,
            max($this->tbl_payment.receiptnum) as max_or,
            count($this->tbl_payment.receiptnum) as tcount,
            sum($this->tbl_payment.charge) as charge,
            sum($this->tbl_payment.initcharge) as initcharge,
            sum($this->tbl_payment.surcharge) as surcharge,
            sum($this->tbl_payment.surcharge) as lostcharge,
            sum($this->tbl_payment.oncharge) as oncharge,

            sum($this->tbl_payment.oncharge) as process,                        
            sum($this->tbl_payment.vatexempt) as vatexempt,
            sum($this->tbl_payment.vatsales) as vatsales,
            sum($this->tbl_payment.discount) as discount,
            sum($this->tbl_payment.vat) as vat


        "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        $select->set_condition($condition);
        $select->add_group("pdate");
        //$select->add_group("process");
        $checkTransList =  $this->select($select);

        return $checkTransList;


    }

    public function records_byteller_model($terminal,$from_date,$to_date){


        $condition = new QueryGroup();
        
        $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));

        $condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$from_date));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$to_date));
        //$condition->and_query(new QueryField($this->tbl_payment.".tellerid","=",$tellerid));
        $select = new Select();
        $select->add_fields(array("

                cardserial,
                $this->tbl_payment.paymentdate,
                $this->tbl_payment.receiptnum,
                recieved, 
                changebill, 
                shortchange, 
                changecoin, 
                $this->tbl_payment.charge 


                
                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        $select->set_condition($condition);
        $checkTransList =   $this->select($select);

        return $checkTransList;


    }


    public function transaction_byteller_model($terminal,$from_date,$to_date,$tellerid){


        $condition = new QueryGroup();
                                                                                                                        
        $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));
        
        $condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$from_date));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$to_date));
        $condition->and_query(new QueryField($this->tbl_payment.".tellerid","=",$tellerid));
        $select = new Select();
        $select->add_fields(array("

                process,
                count(*) as count,
                sum($this->tbl_payment.charge) as charge,
                min($this->tbl_payment.receiptnum) as minor,
                max($this->tbl_payment.receiptnum) as maxor,
                recieved,
                changebill,
                changecoin,
                sum($this->tbl_payment.initcharge) as initcharge,
                sum($this->tbl_payment.surcharge) as surcharge,
                sum($this->tbl_payment.lostcharge) as lostcharge,
                sum($this->tbl_payment.oncharge) as overnight,
                sum($this->tbl_payment.discount) as discount,
                sum($this->tbl_payment.vatexempt) as vatexempt,
                sum($this->tbl_payment.vatsales) as vatsales,
                sum($this->tbl_payment.vat) as vat

                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        //$select->add_sort($this->tableName.".park_id DESC");
        $select->set_condition($condition);
        $select->add_group($this->tableName.".process");
        $checkTransList =   $this->select($select);

        return $checkTransList;


    }
    public function transaction_record_model($terminal,$from_date,$to_date){


        $condition = new QueryGroup();
        
        $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));

        $condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$from_date));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$to_date));

        $select = new Select();
        $select->add_fields(array("




                $this->tbl_payment.discount as discount,
                $this->tbl_payment.ratetype as ratetype,
                $this->tbl_payment.vatexempt as vatexempt,
                $this->tbl_payment.lostcharge as lostcharge,
                $this->tbl_payment.oncharge as oncharge,
                $this->tbl_payment.surcharge as surcharge,
                $this->tbl_payment.initcharge as initcharge,
                $this->tableName.cardserial as cardserial,
                $this->tableName.old_cardserial as oldcardserial,
                $this->tableName.entrydate as entrydate,
                $this->tableName.exitdate as exitdate,
                $this->tableName.paymentdate as paymentdate,
                $this->tableName.receiptnum as receiptnum,
                $this->tableName.voidnum as voidnum,
                $this->tableName.refundnum as refundnum,
                $this->tbl_payment.charge as charge, 
                $this->tableName.setl_ref,  
                payment_termid,    
                payid,           
                platenum,
                process,
                dccode

              

                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        //$select->add_sort($this->tableName.".park_id DESC");
        $select->set_condition($condition);
        $checkTransList =   $this->select($select);

        return $checkTransList;


    }
    public function transaction_total_xreading_model($terminal,$tellerid,$from_date,$to_date){


        $condition = new QueryGroup();
        
        $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));
        $condition->and_query(new QueryField($this->tableName.".tellerid","=",$tellerid));
        $condition->and_query(new QueryField($this->tableName.".receiptnum","!=", ""));
        $condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$from_date));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$to_date));


        $select = new Select();
        $select->add_fields(array("

                count($this->tbl_payment.receiptnum) as tcount,
                min($this->tbl_payment.receiptnum) as min_or,
                max($this->tbl_payment.receiptnum) as max_or,

    
                min($this->tableName.voidnum) as min_void,
                max($this->tableName.voidnum) as max_void,
                min($this->tableName.refundnum) as min_refund,
                max($this->tableName.refundnum) as max_refund,
                

                sum($this->tbl_payment.charge) as tcharge,
                sum($this->tbl_payment.vatsales) as vatsales,
                sum($this->tbl_payment.vatexempt) as vatexempt

                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        //$select->add_sort($this->tableName.".park_id DESC");
        $select->set_condition($condition);
        $checkTransList =   $this->select($select);

        return $checkTransList;


    }


    public function transaction_total_model($terminal,$from_date,$to_date){


        $condition = new QueryGroup();
        
        $condition->and_query(new QueryField($this->tableName.".payment_termid","=",$terminal));

        $condition->and_query(new QueryField($this->tableName.".paymentdate",">=",$from_date));
        $condition->and_query(new QueryField($this->tableName.".paymentdate","<=",$to_date));

        $select = new Select();
        $select->add_fields(array("

                count($this->tbl_payment.receiptnum) as tcount,
                min($this->tbl_payment.receiptnum) as min_or,
                max($this->tbl_payment.receiptnum) as max_or,


             
                min($this->tableName.voidnum) as min_void,
                max($this->tableName.voidnum) as max_void,
                min($this->tableName.refundnum) as min_refund,
                max($this->tableName.refundnum) as max_refund,
                

                sum($this->tbl_payment.charge) as tcharge,
                sum($this->tbl_payment.vatsales) as vatsales,
                sum($this->tbl_payment.vatexempt) as vatexempt

                 "));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_payment, new QueryField($this->tableName.".park_id", "=", $this->tbl_payment.".park_id"),"RIGHT"));
        //$select->add_sort($this->tableName.".park_id DESC");
        $select->set_condition($condition);
        $checkTransList =   $this->select($select);

        return $checkTransList;


    }

    public function get_transaction_parkid_model($ParkID) {
        $condition = new QueryGroup();  
        $condition->and_query(new QueryField("park_id","=",$ParkID));  

        $terminalDetails = $this->model->show_records(array("*"),$this->tableName, $condition);
        return $terminalDetails;        
    }
    public function get_transaction_parkid_paid_model($ParkID) {
        $condition = new QueryGroup();  
        $condition->and_query(new QueryField("park_id","=",$ParkID));  

        $terminalDetails = $this->model->show_records(array("*"),$this->tableName, $condition);
        return $terminalDetails;        
    }



    public function get_transaction_details($cardserial) {
        $condition = new QueryGroup();  
        $condition->and_query(new QueryField("cardserial","=",$cardserial));
        $condition->and_query(new QueryField("process","!=",1));   
        $condition->and_query(new QueryField("process","!=",100));   
        $condition->and_query(new QueryField("process","!=",98));   
        $condition->and_query(new QueryField("process","!=",99));   

        $terminalDetails = $this->model->show_records(array("park_id","entry_termid","entryarea_id","entrydate","cardserial","payment_termid","entry_termid",
            "entrycarimage","entryfaceimage","process","platenum","ratetype","confidence","brandmodel","vehicletype","carcolor"),$this->tableName, $condition);
        return $terminalDetails;        
    }





    public function update_transaction_details($ParkID,$list=array()) {
        $this->update($this->tableName,$list, new QueryField("park_id","=",$ParkID));      
    }


    public function get_transaction_ifexist($cardserial,$parkid) {
        //$condition = new QueryGroup();    

        $conditionparkid = new QueryGroup();
        $conditionparkid->or_query(new QueryField("park_id","=",$parkid));

        $conditioncardserial = new QueryGroup();
        $conditioncardserial->or_query(new QueryField("cardserial","=",$cardserial));
        $conditioncardserial->or_query($conditionparkid);    

        $condition = new QueryGroup();  
        $condition->and_query(new QueryField("process","!=",1));  
        $condition->and_query(new QueryField("process","!=",100));  
        $condition->and_query(new QueryField("process","!=",98));  
        $condition->and_query(new QueryField("process","!=",99));  
        $condition->and_query($conditioncardserial);

        $responseDetails = $this->model->show_records(array("park_id"),$this->tableName, $condition);
        return $responseDetails;

    }  

    public function UpdateExistTransaction($ParkID,$list=array()) {
        
        $this->update($this->tableName,$list, new QueryField("park_id","=",$ParkID));
    }





    public function get_transaction_entryRecord($entrylogid,$userID,$entryDate,$process,$parkID) {
        $condition = new QueryGroup();    
        $condition->and_query(new QueryField("entrylogid","=",$entrylogid));
        $condition->and_query(new QueryField("userID","=",$userID));
        $condition->and_query(new QueryField("entryDate","=",$entryDate));
        $condition->and_query(new QueryField("process","=",$process));  
        $condition->and_query(new QueryField("parkID","=",$parkID));

        $responseDetails = $this->model->show_records(array("parkID"),$this->tableName, $condition);

        if(empty($responseDetails)) {

             $responseValue =   "";     

        } else {
            foreach($responseDetails as $response) {
                $responseValue =   $response['parkID'];
          }

          return $responseValue;
        }
    }  

    public function get_transaction_exitRecord($parkID,$userID,$exitlogid,$exitdate,$process) {
        $condition = new QueryGroup();    
        $condition->and_query(new QueryField("parkID","=",$parkID));
        $condition->and_query(new QueryField("userID","=",$userID));
        $condition->and_query(new QueryField("exitlogid","=",$exitlogid));
        $condition->and_query(new QueryField("exitdate","=",$exitdate));
        $condition->and_query(new QueryField("process","=",$process));    

        $responseDetails = $this->model->show_records(array("parkID"),$this->tableName, $condition);

        if(empty($responseDetails)) {

             $responseValue =   "";     

        } else {
            foreach($responseDetails as $response) {
                $responseValue =   $response['parkID'];
          }

          return $responseValue;
        }
    }  

    /*public function get_transaction_details($parkinfoID) {
        
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkinfoID));   
        $condition->and_query(new QueryField("process","=",0));     

            $parkinfoDetails = $this->model->show_records(array("parkID","userID","plateNum","rateType","entryDate","entryLogid","userID"),$this->tableName, $condition);
        return $parkinfoDetails;        
    }*/











    public function check_parkinfo_details($parkinfoID) {
        
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkinfoID));
        $condition->and_query(new QueryField("process",'=',0));     

            $parkinfoDetails = $this->model->show_records(array("parkID","userID","plateNum","rateType","entryDate","entryLogid"),$this->tableName, $condition);
        return $parkinfoDetails;        
    }


    public function is_parkinfo_entry($parkinfoID) {
        
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkinfoID));      

            $parkinfoDetails = $this->model->show_records(array("process"),$this->tableName, $condition);


        $status = "notEntered";

        if($parkinfoDetails[0]['process'] == 0){
            $status = "entered";
        }else if($parkinfoDetails[0]['process'] == 2){
            $status = "exited";
        }

        return $status;     
    }

    public function update_parkinfo_payment($parkID, $list=array()) {
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkID));
        
        $this->update($this->tableName, $list, $condition);   
    }

    public function get_parkinfo_process($parkinfoID) {
        
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkinfoID));

            $parkinfoDetails = $this->model->show_records(array("parkID","process"),$this->tableName, $condition);
        return $parkinfoDetails;        
    }


    public function get_payment_list($userID){

        $condition = new QueryGroup();
        
        $condition->and_query(new QueryField($this->tableName.".userID","=",$userID));
        //$condition->and_query(new QueryField($this->tableName.".transRemarks","=","Check In"));
        //$condition->and_query(new QueryField($this->tableName.".transStatus","=",0));     
            
        $select = new Select();
        $select->add_fields(array("
                 $this->tableName.parkID,
                 $this->tableNameTerminals.terminalName,
                 $this->tableNameProperty.propertyName,
                 $this->tableName.userID,
                 $this->tableName.plateNum,
                 $this->tableName.entryLogid,
                 $this->tableName.paymentDate,
                 $this->tableName.amount,
                 $this->tableName.duration,
                 $this->tableName.remarks,
                 $this->tableName.process   
                 "
                 ));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tableNameTerminals, new QueryField($this->tableName.".entryLogid", "=", $this->tableNameTerminals.".terminalID"),"LEFT"));
        $select->add_join(new Join($this->tableNameProperty, new QueryField($this->tableNameTerminals.".propertyID", "=", $this->tableNameProperty.".propertyID"),"LEFT"));
        $select->add_sort("parkID DESC");
        $select->set_condition($condition);

        $checkTransList =   $this->select($select);

        return $checkTransList;

    }


    public function get_parkinfo_payment_details($parkinfoID) {
        
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkinfoID));

            $parkinfoDetails = $this->model->show_records(array("paymentDate","process"),$this->tableName, $condition);
        return $parkinfoDetails;        
    }



    public function send_email($parkinfo_details){

        $park_data = $parkinfo_details;
        $fullname = $park_data['fullname'];
        $txn_code = $park_data['txn_code'];
        $property = $park_data['property'];
        $terminal = $park_data['terminal'];
        $entryDate = $park_data['entryDate'];
        $paymentTime = $park_data['paymentTime'];
        $initialCharge = $park_data['initialCharge'];
        $succCharge = $park_data['succCharge'];
        $total = $park_data['total'];
        $email = $park_data['email'];


        $message = '<!DOCTYPE html>
<html>
<head>
    <title>Your iPark Receipt</title>
</head>

<style type="text/css">
    
    *{
        font-family: Helvetica,"Arial",sans-serif;
    }


</style>

<body style="
        border: 1px solid #cecfe0;
        width: 50%;
        height: 100%;">

    <div class="head" style="padding-left: 50px;
        padding-right: 50px;
        padding: top: 30px;
        padding-bottom: 10px;
        background-color: white;
        "
        >
        <img src="cid:logo_2u" style="height: 40px; width: 110px; padding-left: 10px; padding-top: 10px;">
        <div class="row" style="display: flex;">
            <div class="column" style="float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                <label style="font-weight: bold;">TOTAL:</label><br>
                <label class="green-font font-head-total" style="
                color: #14b9e6;
                font-size: 30px;
                line-height: 24px;
                font-weight: bold;
                line-height: 26px;
                text-align: left;   ">P '.$total.'</label>
            </div>
            <div class="column" style="float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                <label style="font-weight: bold;">DATE | TIME</label><br>
                <label>Payment Time:</label><label class="green-font" style="color: #14b9e6;font-weight: bold;">'.date('F d, Y H:i:s',strtotime($paymentTime)).'</label>
            </div>
            
        </div>
    </div>

    <div class="container row" style="display: flex; padding-top: 10px; background-color: #f3f4f5;
        width: 100%;
        height: 100%;">
            <div class="column" style="padding-left: 50px; float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                <label class=" green-font font-body" style="
                color: #14b9e6;
                font-size: 20px;
                line-height: 24px;
                font-weight: bold;
                line-height: 26px;
                text-align: left;">Parking Details</label>
                <div>
                    
                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Vehicle Type:</label><br>
                    <label>Car</label><br>
                    </div>
                    
                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Issued By:</label><br>
                    <label>'.$property.'</label><br>
                    </div>
                    
                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Issued To:</label><br>
                    <label>'.$fullname.'</label><br>
                    </div>

                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Transaction Code:</label><br>
                    <label>'.$txn_code.'</label><br>
                    </div>

                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Entry Terminal</label><br>
                    <label>'.$terminal.'</label><br>
                    </div>

                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Entry Date|Time</label><br>
                    <label>'.$entryDate.'</label><br>
                    </div>

                </div>
            </div>
            <div class="column" style="float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                <label class=" green-font font-body" style="color: #14b9e6;
        font-size: 20px;
        line-height: 24px;
        font-weight: bold;
        line-height: 26px;
        text-align: left;">Receipt Summary</label><br><br>
                <div class="small-box" style="padding: 20px 20px 20px 20px;
                    border: 1px solid #cecfe0;
                    background-color: white;
                    width: 85%;
                    min-height: 50px;">
                    <label>Payment Method:</label><br>
                    <label style="font-weight: bold;">iPark Credits</label><br><br>
                    <div class="row" style="display: flex; border-style: dashed none none none; border-color: #cecfe0;">
                        <div class="column" style="float: left;
                        width: 50%;
                        padding:5px;
                        min-height: 5px;">
                            <label class="gray-font" style="color: #cecfe0;">Description</label>
                        </div>
                        <div class="column" style="
                        float: left;
                        width: 50%;
                        padding:5px;
                        min-height: 5px;
                                        ">
                            <label class="gray-font" style="color: #cecfe0;">Amount</label>
                        </div>
                    </div>
                    <div class="row" style="display: flex; border-style: dashed none dashed none;  border-color: #cecfe0;">
                        <div class="column"
                        style="
                        float: left;
                        width: 50%;
                        padding:5px;
                        min-height: 5px;">
                            <label class="small-font" style="font-size: 12px;">Initial Charge:</label><br>
                            <label class="small-font" style="font-size: 12px;">Succeeding Charge:</label><br>
                            <label class="small-font" style="font-size: 12px;">Overnight Charge:</label><br>
                        </div>
                        <div class="column" style="align-content: right;
                        float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                            <label class="small-font" style="font-size: 12px;">P '.$initialCharge.'</label><br>
                            <label class="small-font" style="font-size: 12px;">P '.number_format($succCharge,2).'</label><br>
                            <label class="small-font" style="font-size: 12px;">P 0.00</label><br>
                        </div>
                    </div>
                    <div class="row" style="display: flex;">
                        <div class="column" style="float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                        </div>
                        <div class="column" style="align-content: right;float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                            <label class="small-font" style="font-weight: bold; font-size: 12px;">TOTAL</label>
                            <label class="small-font" style="font-weight: bold; font-size: 12px;">P '.$total.'</label>
                            
                        </div>
                    </div>
                </div>
            </div>
    </div>

</body>
</html>';

    // echo $message;
    $mail = new PHPMailer();
    //Enable SMTP debugging. 
    // $mail->SMTPDebug = 3; 
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "ssl";
    $mail->Port       = 465;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "znotsukaima@gmail.com";
    $mail->Password   = "mineskiwar1";
    $mail->IsHTML(true);
    $mail->AddAddress($email, $fullname);
    $mail->SetFrom("ipark.devs@gmail.com", "IPARK");
    $mail->AddEmbeddedImage('iparkname.png', 'logo_2u');
    $mail->Subject = "Your Parking Receipt"; 
    $mail->Body = $message; 

    if(!$mail->Send()) {
      // echo "Error while sending Email.";
      // var_dump($mail);
    } else {
      // echo "Email sent successfully";
    }

}

}
?>
