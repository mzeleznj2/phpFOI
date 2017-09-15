<!DOCTYPE html>
<html>
<head>
<title>Lokacija knjižnice</title>

</head>
<body>

 
 <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>
 <div style='overflow:hidden;height:440px;width:700px;'>
 <div id='gmap_canvas' style='height:440px;width:700px;'></div>
 <div><small><a href="http://embedgooglemaps.com">embed google maps</a></small></div>
 <div><small><a href="https://disclaimergenerator.net">disclaimer generator</a></small></div>
 <style>#gmap_canvas img{max-width:none!important;background:none!important}
 </style>
 </div><script type='text/javascript'>


 //var lang = getParameterByName(lang, url.substring(poz,url.length);
 function init_map(){
 var url = window.location.href;
 var jednako = url.indexOf("=");
 var zadnje = url.lastIndexOf("=");
 var end = url.indexOf("&");
 var prva = url.substr(jednako+1,(end-jednako-1));
 var druga = url.substr(zadnje+1,url.length);
 
 var myOptions = {zoom:12,center:new google.maps.LatLng(prva,druga),mapTypeId: google.maps.MapTypeId.ROADMAP};
 map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
 marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(prva,druga)});
 infowindow = new google.maps.InfoWindow({content:'<strong>Lokacija knjižnice</strong>'});
 google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);
 </script>
</body>
</html>


