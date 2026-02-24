   

$(document).ready(function() {

    

    var table = $('#rates_table').DataTable({
        ajax: {
         //url: 'data/data.json',
         url:  api_url+'area'+t0k3n1z3d,
          //url:'<?php echo rtrim(api_url(), "/")."rates"; ?>',  
            type: 'POST',
            dataSrc: 'data'
        },
        idSrc: "area_id",
        order: [[3, 'asc']],
        paging: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 75, 100],
        //lengthMenu: [1, 1, 1, 1, 1, 1],
        columns: [
            { data: 'area_code' },
            { data: 'area_name' },
            { data: 'payment_gracehour' },
            { data: 'payment_graceminute' },
            { data: 'entry_gracehour' },
            { data: 'entry_graceminute' },
            { data: 'cutoffhour' },
            { data: 'cutoffminute' },
     

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
    
    var id = table.row( this ).data().area_id;

    var getUrl = window.location;
    var baseurl =  getUrl.origin + '/' +getUrl.pathname.split('/')[1]  + '/area/editarea/' + id; 

    
    window.location.href = baseurl;

});





});

