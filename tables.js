$(document).ready(function(){	
	$('#generateSummaryButton').on('click', function(){

		var dateSpan = $('#chosenDateSpan').val();
		if(dateSpan == 'nonStandardSpan'){
			
			var beginningOfDateSpan = $('#beginDateInput').val();
			var endingOfDateSpan = $('#endingDateInput').val();
			
			if(checkIfDateOneIsOlder(beginningOfDateSpan,endingOfDateSpan)){			
				$.get("expencesTables.php", {beginDate: beginningOfDateSpan, endDate: endingOfDateSpan} , function(json){
					generateExpenceTable(json);		
				});
				$.get("incomesTables.php", {beginDate: beginningOfDateSpan, endDate: endingOfDateSpan} , function(json){
					generateIncomeTable(json);		
				});
				$.get("expenceSummaryTable.php", {beginDate: beginningOfDateSpan, endDate: endingOfDateSpan} , function(json){
					generateExpenceSummaryTable(json);		
				});
				$.get("incomeSummarytable.php", {beginDate: beginningOfDateSpan, endDate: endingOfDateSpan} , function(json){
					generateExpenceSummaryTable(json);		
				});
			}
			else{
				$('#dateMessageDiv').html('Data końca okresu nie może być starsza niż data początku okresu');
			}
		}else{		
			$.get("expencesTables.php", {timePeriod: dateSpan} , function(json){
				generateExpenceTable(json);	
			});
			$.get("incomesTables.php", {timePeriod: dateSpan} , function(json){
				generateIncomeTable(json);		
			});		
			$.get("expenceSummaryTable.php", {timePeriod: dateSpan} , function(json){
				generateExpenceSummaryTable(json);		
			});			
			$.get("incomeSummarytable.php", {timePeriod: dateSpan} , function(json){
				generateIncomeSummaryTable(json);		
			});
		}		
	});
function checkIfDateOneIsOlder(dateOne, dateTwo){
	if(dateOne.substr(0,4) < dateTwo.substr(0,4)) return true;
	else if(dateOne.substr(0,4) > dateTwo.substr(0,4)) return false;
	else{
		if(dateOne.substr(5,2) < dateTwo.substr(5,2)) return true;
		else if(dateOne.substr(5,2) > dateTwo.substr(5,2)) return false;
		else{
			if(dateOne.substr(8,2) < dateTwo.substr(8,2)) return true;
			else return false;
		}
	}
}
function generateExpenceTable(json){		
		var jsonObj = $.parseJSON(json);
		if(jsonObj.length == 0){
			$('#expenceTable').html('<p class="text-center"><b>Brak wydatków w rozpatrywanym okresie</b></p>');
		}else{
			$('#expenceTableHeader').html("<b>Tabela podsumowująca twoje wydatki:</b>");
			$("<thead><tr><th>kwota</th><th>data</th><th>id_kategoria</th><th>id_platność</th><th>komenatrz</th></tr><thead><tbody>").appendTo('#expenceTable');
			for(var klucz in jsonObj){
				var wiersz = jsonObj[klucz];      
				var kwota = wiersz[0];
				var data = wiersz[1];
				var id_kategorii = wiersz[2];
				var id_platnosc = wiersz[3];
				var komentarz = wiersz[4];
				$("<tr><td>"+kwota+"</td><td>"+data+"</td><td>"+id_kategorii+"</td><td>"+id_platnosc+"</td><td>"+komentarz+"</td></tr>").appendTo('#expenceTable');             
			}
			$('</tbody>').appendTo('#expenceTable');
		}		
}
function generateIncomeSummaryTable(json){
	var jsonObj = $.parseJSON(json);

	if(jsonObj.length == 0){
			$('#incomeCategoriesTable').html('');
		}else{
			$('#incomeCategoriesTableHeader').html('<b>Tabela podsumowująca twoje dochody względem kategorii:</b>');
			$('<thead><tr><th class="text-center">Wartość w kategorii</th><th class="text-center">Kategoria</th></thead><tbody>').appendTo('#incomeCategoriesTable');
			for(key in jsonObj){
				var row = jsonObj[key];
				var amount = row[0];
				var category = row[1];				
				$('<tr><td class="text-center">'+amount+'</td><td class="text-center">'+category+'</td></tr>').appendTo('#incomeCategoriesTable');
			}
			$('</tbody>').appendTo('#incomeCategoriesTable');
		}		
		adjustSummaryContainerheight();
}
function generateExpenceSummaryTable(json){
	var jsonObj = $.parseJSON(json);
	var dataPoints = [];
	var sumOfExpences = 0;
	if(jsonObj.length == 0){
			$('#expenceCategoriesTable').html('');
		}else{
			$('#expenceCategoriesTableHeader').html('<b>Tabela podsumowująca twoje wydatki względem kategorii:</b>');
			$('<thead><tr><th class="text-center">Wartość w kategorii</th><th class="text-center">Kategoria</th></thead><tbody>').appendTo('#expenceCategoriesTable');
			for(key in jsonObj){
				var row = jsonObj[key];
				var amount = row[0];
				var category = row[1];
				sumOfExpences += parseFloat(amount);
				let oneDataToChart = {
					y: 0,
					label: ""
				};
				oneDataToChart.y = amount;
				oneDataToChart.label = category;
				dataPoints.push(oneDataToChart);
				$('<tr><td class="text-center">'+amount+'</td><td class="text-center">'+category+'</td></tr>').appendTo('#expenceCategoriesTable');
			}
			$('</tbody>').appendTo('#expenceCategoriesTable');
		}
	if(dataPoints.length>0){	
		for(var k=0; k<dataPoints.length; k++){
		  dataPoints[k].y = dataPoints[k].y/sumOfExpences * 100;
	    }
		var chart = new CanvasJS.Chart("chartExpencesContainer", {
			animationEnabled: true,
			title: {
				text: "Wydatki według kategorii"
			},
			data: [{
				type: "pie",
				startAngle: 240,
				yValueFormatString: "##0.00\"%\"",
				indexLabel: "{label} {y}",
				dataPoints
			}]
		});
		chart.render();
		$('#chartExpencesContainer').css('height', '400px');
		$('#summaryContainer').css({
				'height': 'auto'
				});
	}
}
function generateIncomeTable(json){
			
		var jsonObj = $.parseJSON(json);
		if(jsonObj.length == 0){
			$('#incomeTable').html('<p class="text-center"><b>Brak dochodów w rozpatrywanym okresie</b></p>');
		}else{
			$('#incomeTableHeader').html("<b>Tabela podsumowująca twoje dochody:</b>");
			$("<thead><tr><th>kwota</th><th>data</th><th>Kategoria</th><th>komentarz</th></tr><thead><tbody>").appendTo('#incomeTable');
			for(var klucz in jsonObj){
				var wiersz = jsonObj[klucz];      
				var kwota = wiersz[0];
				var data = wiersz[1];
				var id_kategorii = wiersz[2];
				var komentarz = wiersz[3];
				  $("<tr><td>"+kwota+"</td><td>"+data+"</td><td>"+id_kategorii+"</td><td>"+komentarz+"</td></tr>").appendTo('#incomeTable');             
			}
			$('</tbody>').appendTo('#incomeTable');
		}	
}
function adjustSummaryContainerheight(){
	let summaryHeight = $('#divToHeightEvaluation').height();
	if(summaryHeight>500){
		$('#summaryContainer').css({
			'height': 'auto'
		});
	}
	else {
		$('#summaryContainer').css({
			'height': '500px'
		});
	}
}
});