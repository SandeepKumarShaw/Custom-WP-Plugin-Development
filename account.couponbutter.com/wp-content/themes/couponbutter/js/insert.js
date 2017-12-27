<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js">
$(document).ready(function(){
	alert('hello');
$('#myform').submit(function(){
	return false;
});

$('#insert').click(function(){
	alert('hi');
	$.post(		
		$('#myform').attr('action'),
		$('#myform :input').serializeArray(),
		function(result){
			$('#result').html(result);
		}
	);
});
});