<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#image").click(function(){
                           $("#pop-up").show();
                         });
$("#image").mouseout(function(){
                           $("#pop-up").hide();
                         });
                                                 });
</script>
</head>
<body>
<h1>This is a Heading</h1>
<p>This is a paragraph.</p>
<div>
<span id="pop-up" style="position: absolute; display:none;"><img src="7.jpg"/></span>
<div id="image">tekst</div>
</div>
</body>
</html>