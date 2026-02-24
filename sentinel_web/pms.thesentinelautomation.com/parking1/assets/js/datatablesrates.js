   

$(document).ready(function() {

    

    var table = $('#rates_table').DataTable({
        ajax: {
         //url: 'data/data.json',
         url:  api_url+'rates'+t0k3n1z3d,
          //url:'<?php echo rtrim(api_url(), "/")."rates"; ?>',  
            type: 'POST',
            dataSrc: 'data'
        },
        idSrc: "rate_id",
        order: [[3, 'asc']],
        paging: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 75, 100],
        //lengthMenu: [1, 1, 1, 1, 1, 1],
        columns: [
            { data: 'rate_code' },
            { data: 'initcharge_hour' },
            { data: 'initcharge' },
            { data: 'succharge_hour' },
            { data: 'succharge' },
            { data: 'oncharge' },
            { data: 'lostcharge' },
            { data: 'member_type' },
            { data: 'discount' },
     

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



$('#rates_table').on( 'click', 'tr', function () {
  // Get the rows id value
    
    var id = table.row( this ).data().rate_id;

    var getUrl = window.location;
    var baseurl =  getUrl.origin + '/' +getUrl.pathname.split('/')[1]  + '/rates/editrate/' + id; 

    
    window.location.href = baseurl;

});





});

