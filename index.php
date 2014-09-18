<?php ob_start("ob_gzhandler"); ?>
<?php
include 'config.php';

$mysqli = connect();

$date = date("Y-m-d H:i:s");
$pw = "";

if(isset($_GET['pw'])){
	$pw = $_GET['pw'];
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="InstanceLabs">
<meta name="description" content="The epic Effner-Index to help categorize all the stuff we have to know.">
<title>Effner Index</title>
<!-- Trivia: I came up with that idea when thinking the first time in the holidays about school starting soon -->
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="s/css/semantic.min.css">
<link rel="stylesheet" type="text/css" href="index.css">
<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="s/javascript/s.js"></script>
<script type="text/javascript" src="s/javascript/jquery.address.js"></script>
<script type="text/javascript">

$(document).ready(function(){

	/*function parseHtml (str) {      
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2');
	}*/
	function parseHtml (str) {
		return str;
	}

	$('button.menu').tab();

	$('button.item').tab();

	
	$('button.menu').tab('change tab', 'Geschichte');
	var col =  $('button.yellow').css('background-color');
	$('body').css('background-color', col);
	$('.bgtext').html("GESCHICHTE");

	$('button.menu').click(function(){
		var col =  $(this).css('background-color');
		$("body").css('background-color', col);
		var subj = $(this).html();
		$('.bgtext').html(subj.toUpperCase(subj));
	});
	
	$('button.item').click(function(){
		var subj = $(this).attr('subject');
		$('div.ui.raised.segment.content.' + subj).html('<div class="ui active dimmer"><div class="ui mini loader"></div></div>');
		$.ajax({
			type: "POST",
			url: "getPost.php",
			data: { subject: subj, id: $(this).attr('id') }
		})
		.done(function(msg) {
			$('div.ui.raised.segment.content.' + subj).html(parseHtml(msg));
		});
	});
	
	$('button.save').click(function(){
		$.ajax({
			type: "POST",
			url: "savePost.php",
			data: { subject: $("#subjectinput").val(), title: $("#titleinput").val(), description: $("#descinput").val(), pw: "<?php echo($pw) ?>" }
		})
		.done(function(msg) {
			if(msg == "1"){
				location.reload();
			}else{
				alert(msg);
			}
		});
	});
	
	
});


</script>
</head>
<body>
<div class="shader"></div>
<div class="bgtext">-</div>
<div class="mainmenu">
<button class="menu yellow" data-tab="Geschichte">Geschichte</button>
<button class="menu blue" data-tab="Deutsch">Deutsch</button>
<button class="menu red" data-tab="Mathe">Mathe</button>
<button class="menu green" data-tab="Englisch">Englisch</button>
<button class="menu teal" data-tab="Latein">Latein</button>
<button class="menu orange" data-tab="Sozialkunde">Sozialkunde</button>
<button class="menu purple" data-tab="Biologie">Biologie</button>
<button class="menu lightgreen" data-tab="Wirtschaft">Wirtschaft</button>
<button class="menu rosa" data-tab="Religion">Religion</button>
<button class="menu red right" data-tab="Add">+</button>
</div>



<?php

$arr = array('Geschichte', 'Deutsch', 'Mathe', 'Englisch', 'Latein', 'Sozialkunde', 'Biologie', 'Wirtschaft', 'Religion');

foreach($arr as $subject) {
	
	echo('<div class="ui tab" data-tab="'.$subject.'"><div class="ui raised segment content"><h3>'.$subject.'</h3>');
	$result = $mysqli->query("SELECT * FROM subjposts WHERE subject = '".$subject."'");
	while($row = $result->fetch_assoc()){
		echo('<button class="item" subject="'.$subject.'" id="'.$row['id'].'">'.$row['title'].'</button>');
	}
	echo('</div><div class="ui raised segment content '.$subject.' data">-/-</div></div>');
	
}

?>

<div class="ui tab" data-tab="Add">
<div class="ui raised segment content">
	<div class="ui form">
		<div class="ui two fields">
			<div class="field">
			<label>Subject</label>
			<input placeholder="Subject" type="text" id="subjectinput">
			</div>
			<div class="field">
			<label>Title</label>
			<input placeholder="Title" type="text" id="titleinput">
			</div>
		</div>
		<div class="field">
			<label>Description</label>
			<textarea id="descinput"></textarea>
		</div>
		<button class="right save">Save</button>
	</div>
</div>
</div>

</body>
</html>