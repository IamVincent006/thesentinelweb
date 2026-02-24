   

$(document).ready(function() {


   
    var table = $('#users_table').DataTable({
        ajax: {
       
            url:  api_url+"userinfo_details"+t0k3n1z3d,
            type: 'POST',
            dataSrc: 'data'
        },
      

        idSrc: "userid",
        order: [[3, 'asc']],
        paging: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 75, 100],
        columns: [
            { data: 'username' },
            { data: 'firstname' },
            { data: 'lastname' },
            { data: 'levelname' },
            { data: 'logindate' },
            { data: 'last_pc' },
            { data: 'loginstatus' },

        

            {
            data: 'status',
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


$.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

  //var fromAge, toAge, inEmpAgeRange, inEmpStartingDateRange;
    var level;

    //alert(loginlevel);
  //var level = parseInt(data[3]);
  //var empStartDate = Date.parse(data[4]);
  //alert(data[3]);
    if(data[3] == 'Admin')
        level = 1;
    if(data[3] == 'Parking Admin')
        level = 2;
    if(data[3] == 'Audit Admin')
        level = 3;
    if(data[3] == 'Treasury Admin')
        level = 4;
    if(data[3] == 'Ticket Seller')
        level = 5;


    if(level > loginlevel)
        return true;
    else
        return false;    
   


});


/*var filteredData = table
    .columns( [0, 1] )
    .data()
    .flatten()
    .filter( function ( value, index ) {
        return value > 20 ? true : false;
    } );

*/
/*let minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
DataTable.ext.search.push(function (settings, data, dataIndex) {
    let min = minDate.val();
    let max = maxDate.val();
    let date = new Date(data[4]);
 
    if (
        (min === null && max === null) ||
        (min === null && date <= max) ||
        (min <= date && max === null) ||
        (min <= date && date <= max)
    ) {
        return true;
    }
    return false;
});*/







$('#users_table').on( 'click', 'tr', function () {
  // Get the rows id value

    var id = table.row( this ).data().userid;
   // alert(id);
    var getUrl = window.location;
    var baseurl =  getUrl.origin + '/' +getUrl.pathname.split('/')[1]  + '/users/edituser/' + id; 

    
    window.location.href = baseurl;

});





});

