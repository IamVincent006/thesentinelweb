   

$(document).ready(function() {

    

    var table = $('#voucher_table').DataTable({
        ajax: {
         //url: 'data/data.json',
         url:  api_url+'voucher'+t0k3n1z3d,
          //url:'<?php echo rtrim(api_url(), "/")."rates"; ?>',  
            type: 'POST',
            dataSrc: 'data'
        },
        idSrc: "dc_id",
        order: [[4, 'desc']],
        paging: true,
        pageLength: 20,
        lengthMenu: [5, 10, 25, 50, 75, 100],
        //lengthMenu: [1, 1, 1, 1, 1, 1],
        columns: [
            { data: 'dc_name' },
            { data: 'dc_amount' },
            { data: 'dc_desc' },
            { data: 'dccode' },
            { data: 'date_modified' },

        ],
              


        dom: 'lfrtipB',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Excel',
                filename: 'data.xlsx'
            },
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                filename: 'data.pdf'
            },
            {
                extend: 'print',
                text: 'Print All',
                filename: 'data.pdf'
            }
        ]
    });


  /*editor = new $.fn.dataTable.Editor( {
    ajax: 'data/data.json',
    table: '#monitoring_table',
    idSrc: 'park_id',
    fields: [ {
      label: "process:",
      name: "process"
    } ]
  });
 */



$('#voucher_table').on( 'click', 'tr', function () {
  // Get the rows id value
    
    var id = table.row( this ).data().dc_id;

    var getUrl = window.location;
    var baseurl =  getUrl.origin + '/' +getUrl.pathname.split('/')[1]  + '/voucher/editvoucher/' + id; 

    
    window.location.href = baseurl;

});





});

