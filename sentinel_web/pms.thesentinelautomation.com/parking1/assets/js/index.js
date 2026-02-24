

// Set the date we're counting down to
var countDownDate = new Date("Jan 5, 2024 15:37:25").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

// Get the current date and time
var now = new Date();

// Get the date part of the current date and time
var date = now.getDate();
var month = now.getMonth() + 1;
var year = now.getFullYear();

// Get the time part of the current date and time
var h = now.getHours();
h = (h < 10) ? ("0" + h) : h ;

var m = now.getMinutes();
m = (m < 10) ? ("0" + m) : m ;
//var second = now.getSeconds();
var s = now.getSeconds();
s = (s < 10) ? ("0" + s) : s ;

// Change the time to 12-hour format
var amPm = "AM";
if (h > 11) {
    h -= 12;
    amPm = "PM";
}

// Display the date and time
document.getElementById("displayDate").innerHTML = date + "/" + month + "/" + year;
document.getElementById("displayTime").innerHTML = h + ":" + m + ":" + s + " " + amPm;


}, 1000);