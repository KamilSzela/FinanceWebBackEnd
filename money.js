
$(document).ready(function(){	
	adjustNavBar();
	//prepareSummaryBoard();
	adjustSummaryContainerheight();	
});
$( window ).resize(function() {
    adjustNavBar();
});
function adjustNavBar(){
	var screenWidth = $(window).width();
	
	if(parseInt(screenWidth)< 990){
		$('#navList li').removeClass('w-20');
	}
	else{
		$('#navList li').addClass('w-20');
	}
}
$('#generateSummaryButton').on('click',function(){
	adjustSummaryContainerheight();
});
$('#chosenDateSpan').on('change', function(){
	prepareSummaryBoard();
});

function prepareSummaryBoard() {
	var chosenSpan = $('#chosenDateSpan').val();
	$('#expenceTable').html("");
	$('#expenceTableHeader').html("");
	$('#expenceCategoriesTable').html("");
	$('#expenceCategoriesTableHeader').html("");
	$('#incomeCategoriesTableHeader').html("");
	$('#incomeCategoriesTable').html("");
	$('#incomeTable').html("");
	$('#incomeTableHeader').html("");
	$('#chartExpencesContainer').html("");
	$('#chartExpencesContainer').css('height', '0px');
	$('#showEvaluation').html("");
	$('#showEvaluation').css({'background': 'none'});
	$('#dateMessageDiv').html("");
	$('#summaryContainer').css({
				'height': '500px'
				});
	if(chosenSpan=='nonStandardSpan'){
		$('#nonStandardDateInput').removeClass("d-none");
		$('#nonStandardDateInput').addClass("d-flex");
	}
	else{
		$('#nonStandardDateInput').removeClass("d-flex");
		$('#nonStandardDateInput').addClass("d-none");
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