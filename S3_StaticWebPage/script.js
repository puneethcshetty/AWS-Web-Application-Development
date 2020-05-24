"use strict";
let main = function () {
	for(var i = 0; i < chest.length; i++) {
		x_axis.push(i);
	}
	console.log(x_axis);
	buildChart();
};

// Our labels along the x-axis
// For drawing the lines
var chest = []
var x_axis = []
var API_URL = 'https://tdv1x27ai2.execute-api.us-east-2.amazonaws.com/default';
	
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
			fill: false
		  }
		]
	  }
	});
}
 
console.log("starting...");
refreshData(main);
