"use strict";
let main = function () {
	//create x axis according to length of chest data
	for(var i = 0; i < chest.length; i=i+1) {
		x_axis.push(i);
	}
	console.log(x_axis);
	buildChart();
};

// Our labels along the x-axis
// For drawing the lines
var chest = []
var x_axis = []

//SPI url which links lambda function
var API_URL = 'https://tdv1x27ai2.execute-api.us-east-2.amazonaws.com/default';
	
//use ajax call to trigger API_URL
function getData() {
    return $.ajax({
        url: API_URL,
        type: "GET",
        dataType: "json",
        //  headers: {"Content-type":"application/json"}, // needed
        success: function (result) {
            console.log("We did GET to lambda");
            console.log(result);
            chest = JSON.parse(result.body);
        }
    });
}

function refreshData(thenFn) {
    // wait until all promises
    Promise.all([getData()]).then(thenFn);
}

//build line chart
function buildChart(){
	var ctx = document.getElementById("myChart");
	var myChart = new Chart(ctx, {
	  type: 'line',
	  data: {
		labels: x_axis,
		datasets: [
		  { 
			data: chest,
			label: "Chest",
			borderColor: "#3e95cd",
			borderWidth: 0.25,
			pointRadius: 0.25,
			fill: false
		  }
		]
	  }
	});
}
 
console.log("starting...");
refreshData(main);
