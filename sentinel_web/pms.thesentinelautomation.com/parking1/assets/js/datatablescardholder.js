$(document).ready(function() {

    var table = $('#cardholder_table').DataTable({
        ajax: {
         //url: 'data/data.json',
         url:  api_url+"cardholder"+t0k3n1z3d,
          //url:'<?php echo rtrim(api_url(), "/")."rates"; ?>',  
            type: 'POST',
            dataSrc: 'data'
        },
      

        idSrc: "cardholder_id",
        order: [[3, 'asc']],
        paging: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 75, 100],
        columns: [
            { data: 'date_created' },
            { data: 'cardserial' },
            { data: 'ratetype' },
            { data: 'area_id' },
            { data: 'platenum' },
            { data: 'firstname' },
            { data: 'lastname' },
            { data: 'cardvalidity' },
            {
            data: 'card_status',
                render: function (data, type) {
                    if (data == 1) {

                        return '<span style="color:green">active</span>';
                    }
                    else
                    {
                        return '<span style="color:red">inactive</span>';
                    }
     
                    return data;
                    }
            },
     

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







    $('#cardholder_table').on( 'click', 'tr', function () {
      // Get the rows id value

        var id = table.row( this ).data().cardholder_id;
       // alert(id);
        var getUrl = window.location;
        var baseurl =  getUrl.origin + '/' +getUrl.pathname.split('/')[1]  + '/cardholders/editcardholder/' + id; 

        
        window.location.href = baseurl;

    });


  





});

