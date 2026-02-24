   

$(document).ready(function() {

    

    var table = $('#rates_table').DataTable({
        ajax: {
         //url: 'data/data.json',
         url:  api_url+'get_terminals'+t0k3n1z3d,
            type: 'POST',
            dataSrc: 'data'
        },
        idSrc: "termID",
        order: [[3, 'asc']],
        paging: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 75, 100],
        //lengthMenu: [1, 1, 1, 1, 1, 1],
        columns: [
            { data: 'termID' },
            { data: 'termIP' },
            { data: 'termname' },
            { data: 'termtype' },
            { data: 'area_code' },
            { data: 'docnum' },
            { data: 'termarea' },
            { data: 'termcnt' },
            { data: 'termreceipt' },
            { data: 'termtellerlogID' },
            { data: 'termparkid' },

     

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




$('#rates_table').on( 'click', 'tr', function () {
  // Get the rows id value
    
    var id = table.row( this ).data().termID;
    //alert(id);
    var getUrl = window.location;
    var baseurl =  getUrl.origin + '/' +getUrl.pathname.split('/')[1]  + '/terminals/editterminal/' + id; 

    
    window.location.href = baseurl;

});





});

