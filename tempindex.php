<!DOCTYPE HTML>
<html>
<head>  
<meta charset="UTF-8">
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script>
window.onload = function () {

	var tempData = [];
	
	var chart = new CanvasJS.Chart("chartContainer", {
		title: {
			text: "Data Chart"
		},
		axisX: {
			valueFormatString: "DD-MM-YY HH:mm:ss"
		},
		axisY: {
			title: "Temperature",
			prefix: "",
			
				tickLength: 5,
				tickColor: "DarkSlateBlue" ,
				tickThickness: 1
		},
		toolTip: {
			shared: true
		},
		legend: {
			cursor: "pointer",
			verticalAlign: "top",
			horizontalAlign: "center",
			dockInsidePlotArea: true,
			itemclick: toogleDataSeries
		},

		data: [
			{
			
				type:"line",
				axisYType: "secondary",
				name: "Temperature",
				showInLegend: true,
				markerSize: 6,
				yValueFormatString: "0.0C",
				dataPoints: tempData
			}
		]
	});

	chart.render();

	function toogleDataSeries(e){

		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		} else{
			e.dataSeries.visible = true;
		}

		chart.render();
	}


	function addData(data) {	
		
			var tl = tempData.length;

			for (var i = 0; i < data.record.length; i++) {

				currentValues = data.record[i];
				[dateValues, timeValues] = currentValues.time.toString().split(' ');
				[day, month, year] = dateValues.split('-');
				[hours, minutes, seconds] = timeValues.split(':');
				date_in = new Date(+year, +month - 1, +day, +hours, +minutes, +seconds);
				
				if (tempData.length == 0 || date_in > tempData[tempData.length - 1].x){					
					
					// Check if the temp is a spike and set the color to red if it is
					let pointColor = ( currentValues.label == 'spike') ? 'red' : null;
					
					tempData.push({x: date_in, y: (currentValues.temp * 1.0),markerColor: pointColor
					});	

					if(tempData.length > 60) {
				tempData.shift();
			}
		}
	}
			
			chart.options.data[0].dataPoints = tempData;
						
			chart.render();			
			console.log(tempData);		
			setTimeout(updateData, 5000);
	}

	function updateData() {
		$.getJSON("http://iotserver.com/convertXMLtoJSON.php", addData);				
	}
	
	setTimeout(updateData, 1000);
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; max-width: 1520px; margin: 0px auto;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
