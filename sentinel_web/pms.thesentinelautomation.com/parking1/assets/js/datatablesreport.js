$(document).ready(function() {

$('#tablearea').DataTable();
$('#termtable').DataTable();


});

function ValidateForm(){
    var dt1=document.reportfrm.from_date;
	var dt2=document.reportfrm.to_date;
    if(!dt1.value){
    	dt1.focus()
    	return false;	 
    }

	if(!dt2.value){
    	dt2.focus()
    	return false;	 
    }
    	return true;
    //var dt2=document.reportfrm.to_date
 }

function SubmitForm(targetreport) {
	if(ValidateForm()){
    //if(1==1){
     //alert(targetreport);
     //return;
        if(targetreport=='transactionpdf') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='transactionpdf';
            document.reportfrm.action='reports/transactionpdf';
            document.reportfrm.submit();
        } 
        if(targetreport=='xreadpdf') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='xreadpdf';
            document.reportfrm.action='reports/xreadpdf';
            document.reportfrm.submit();
        } 
        if(targetreport=='zreadpdf') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='zreadpdf';
            document.reportfrm.action='reports/zreadpdf';
            document.reportfrm.submit();
        } 
        if(targetreport=='birpdf') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='birpdf';
            document.reportfrm.action='reports/birpdf';
            document.reportfrm.submit();
        }
        if(targetreport=='seniorbookpdf') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='seniorbookpdf';
            document.reportfrm.action='reports/seniorbookpdf';
            document.reportfrm.submit();
        }
        if(targetreport=='pwdbookpdf') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='pwdbookpdf';
            document.reportfrm.action='reports/pwdbookpdf';
            document.reportfrm.submit();
        }

        if(targetreport=='voucherbookpdf') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='voucherbookpdf';
            document.reportfrm.action='reports/voucherbookpdf';
            document.reportfrm.submit();
        }

        if(targetreport=='ejournal') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='ejournal';
            document.reportfrm.action='reports/ejournal';
            document.reportfrm.submit();
        }
        if(targetreport=='ejournaltxt') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='ejournaltxt';
            document.reportfrm.action='reports/ejournaltxt';
            document.reportfrm.submit();
        }


        if(targetreport=='activitylog') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='activitylog';
            document.reportfrm.action='reports/activitylog';
            document.reportfrm.submit();
        }


        
        if(targetreport=='autosum') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='autosum';
            document.reportfrm.action='reports/autosumpdf';
            document.reportfrm.submit();
        }
        if(targetreport=='autorep') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='autorep';
            document.reportfrm.action='reports/autoreppdf';
            document.reportfrm.submit();
        }

        if(targetreport=='accountabilitypdf') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='accountabilitypdf';
            document.reportfrm.action='reports/accountabilitypdf';
            document.reportfrm.submit();
        }
        if(targetreport=='dailypdf') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='dailypdf';
            document.reportfrm.action='reports/dailypdf';
            document.reportfrm.submit();
        }
        if(targetreport=='cashierdailypdf') {
            document.reportfrm.no_date.value=0;
            document.reportfrm.target='cashierdailypdf';
            document.reportfrm.action='reports/cashierdailypdf';
            document.reportfrm.submit();
        }

	}
}
