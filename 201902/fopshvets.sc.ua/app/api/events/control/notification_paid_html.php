<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script   src="https://code.jquery.com/jquery-3.2.1.js"   integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="   crossorigin="anonymous"></script>
</head>
<body>

<script type="text/javascript">
	var interval = setInterval( function() {
	    $.ajax ({
	        url: "notification_paid.php",
	        success: function(data) {
	            $("#users").html(data);
	            // alert('done');
	        }
	    });
	}, 5000);

	$('document').ready(function(){
		interval;
	});
</script>

<div id="users"></div>
</body>
</html>