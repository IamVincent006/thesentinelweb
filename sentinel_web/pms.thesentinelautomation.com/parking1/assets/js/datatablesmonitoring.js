$(document).ready(function() {



    var table = $('#monitoring_table').DataTable({
        ajax: {
            url:  api_url+'monitoring'+t0k3n1z3d,
            type: 'POST',
            dataSrc: 'data'
        },
        order: [[2, 'desc']],
        idSrc: "park_id",
        paging: true,
        pageLength: 4,
        lengthMenu: [4, 4, 4, 4, 4],
        paging: false,
        scrollCollapse: true,
        scrollY: '200px',
        columns: [
            { data: 'cardserial' },
            { data: 'entry_termid' },
            { data: 'entrydate' },
            { data: 'payment_termid' },
            { data: 'paymentdate' },
            { data: 'exit_termid' },
            { data: 'exitdate' },
            { data: 'platenum' },
            { data: 'brandmodel' },
            { data: 'process' },

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



$('#monitoring_table').on( 'click', 'tr', function () {
  // Get the rows id value
    
    var id = table.row( this ).data().park_id;
    //alert(id);

    const link = api_url+"get_transaction_parkid" + t0k3n1z3d + "&park_id="+id;
    //alert(apiUrl);
    
     $.ajax({
            url: link,
            dataType: 'json',
            success: function(response) {
                //entrycar
                var entrycarimage = response[0]['entrycarimage'];
                var entryip = response[0]['entrytermIP'];
                srccar = "http://" + entryip + "/Snapshotcar/" + entrycarimage;
                var entrycar = document.getElementById("entrycar");
                entrycar.src = srccar;    
                //entryface
                var entryfaceimage = response[0]['entryfaceimage'];
                var entryip = response[0]['entrytermIP'];
                srcface = "http://" + entryip + "/Snapshotface/" + entryfaceimage;
                var entryface = document.getElementById("entryface");
                entryface.src = srcface;    
                //exit
                var exitip = response[0]['exittermIP'];
                var base_url = window.location.origin;
                var exitcar = document.getElementById("exitcar");
                var exitface = document.getElementById("exitface");
                if (exitip != "null"){
                    //car
                    var exitcarimage = response[0]['exitcarimage'];
                    srccar = "http://" + exitip + "/Snapshotcar/" + exitcarimage;
                    exitcar.src = srccar; 
                    //face
                    var exitfaceimage = response[0]['exitfaceimage'];
                    srcface = "http://" + exitip + "/Snapshotface/" + exitfaceimage;
                    exitface.src = srcface; 
                }
                else
                {
                 
                    exitcar.src = base_url + "/parking1/assets/img/car.png"; 
                    exitface.src = base_url + "/parking1/assets/img/driver.png"; 
                                     
                }




            },
             error: function() {
                //$("#results").append("error");
                alert('error');
            }
        });

 
});





});

