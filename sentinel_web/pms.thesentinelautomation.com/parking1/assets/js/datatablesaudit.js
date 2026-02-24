

$(document).ready(function() {

    var table = $('#audit_table').DataTable({
        ajax: {
            url:  api_url+'auditlog_details'+t0k3n1z3d,
            type: 'POST',
            dataSrc: 'data'
        },
        order: [[0, 'desc']],
        idSrc: "id",
        paging: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 75, 100],
        //lengthMenu: [1, 1, 1, 1, 1, 1],
        columns: [
            { data: 'date' },
            { data: 'function' },
            { data: 'description' },
            { data: 'ip' },
            { data: 'pcname' },
            { data: 'username' },
   





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








});

