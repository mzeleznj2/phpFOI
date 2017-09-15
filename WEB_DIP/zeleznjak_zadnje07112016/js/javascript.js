function ProvjeraBrisanjaKorisnika(id_bris,kor_ime){
					

						
var potvrdi = confirm('Da li zelite zaista izbrisati korisnika '+ kor_ime + '?');

	if(potvrdi == true)
	{
	window.location = "clan.php?brisi="+id_bris+"&kor_ime="+kor_ime;
	}
	else
	{
	window.location = "clanovi.php";
	}
}


function ProvjeraBrisanjaKnjige(id,knjiga,uri){
				
						
var potvrdi = confirm('Da li zelite zaista izbrisati knjigu '+ knjiga + '?');



	if(potvrdi == true)
	{
	window.location = "knjiga.php?brisi="+id+"&knjiga="+knjiga;
	}
	else
	{
	window.location = "knjige.php?"+uri;
	}
}


function ProvjeraBrisanjaKategorije(id,kategorija,uri){
				
						
var potvrdi = confirm('Da li zelite zaista izbrisati kategoriju '+ kategorija + '?');



	if(potvrdi == true)
	{
	window.location = "kategorija.php?brisi="+id+"&kategorija="+kategorija;
	}
	else
	{
	window.location = "kategorija.php?"+uri;
	}
}


function ProvjeraBrisanjaKnjiznice(id,knjiznica,uri){
									
var potvrdi = confirm('Da li zelite zaista izbrisati knjiznicu '+ knjiznica + '?');

	if(potvrdi == true)
	{
	window.location = "knjiznica.php?brisi="+id+"&knjiznica="+knjiznica;
	}
	else
	{
	window.location = "knjiznica.php?"+uri;
	}
}



function DodavanjeKategorije(){
	
	var knjigaOdbId = document.knjiga.kategorija.value;
	
	if (knjigaOdbId=="nk")
	{
	KatSkr.style.display = '';
	}
	else {
		KatSkr.style.display = 'none';
	}
	
}

function DodavanjeKnjiznice(){
	
	var katOdbId = document.kategorija.knjiznicaodb.value;
	//alert("Kat: "+katOdbId);
	if (katOdbId=="nkat")
	{
	KnjigSkr.style.display = '';
	AdresaSkr.style.display = '';
	KapSkr.style.display = '';
	ModSkr.style.display = '';
	SlikaSkr.style.display = '';
	}
	else {
		KnjigSkr.style.display = 'none';
		AdresaSkr.style.display = 'none';
		KapSkr.style.display = 'none';
		ModSkr.style.display = 'none';
		SlikaSkr.style.display = 'none';
	}
	
}


function ValidKorisnikForm(login){


var kor_ime = document.getElementById("kor_ime");
if(kor_ime.value == ''){
document.getElementById("lbkorisnik").innerHTML = "  Upišite korisničko ime!";
return false;

}

var sifra = document.getElementById("lozinka");
if(sifra.value == ''){
document.getElementById("lbkorisnikSifra").innerHTML = "  Upišite šifru!";
return false;
}

var sifrap = document.getElementById("lozinkap");
if(sifrap.value == ''){
document.getElementById("lbkorisnikSifrap").innerHTML = "  Upišite drugu šifru!";
return false;
}

if(sifrap.value != sifra.value){
document.getElementById("lbkorisnikSifra").innerHTML = "  Upisane šifre nisu jednake!";
document.getElementById("lbkorisnikSifrap").innerHTML = "  Upisane šifre nisu jednake!";
return false;
}

var ime = document.getElementById("ime");
if(ime.value == ''){
document.getElementById("lbkorisnikIme").innerHTML = "  Upišite ime!";
return false;
}



var duljina = ime.value.length;

if(duljina < 3){
	
document.getElementById("lbkorisnikIme").innerHTML = "  Ime mora imati min. 3 znaka!";
ime.focus();

return false;	
	
}

var prvo_slovo = ime.value.charAt(0);
if(prvo_slovo == prvo_slovo.toLowerCase()){	
document.getElementById("lbkorisnikIme").innerHTML = "  Ime ste započeli malim slovom!";
ime.focus();
return false;		
}


var prezime = document.getElementById("prezime");
if(prezime.value == ''){
document.getElementById("lbkorisnikPrezime").innerHTML = "  Upišite prezime!";
return false;
}


var adresa = document.getElementById("adresa");
if(adresa.value == ''){
document.getElementById("lbkorisnikAdresa").innerHTML = "  Upišite adresu!";
return false;
}

var datrod = document.getElementById("datrod");
if(datrod.value == ''){
document.getElementById("lbkorisnikDatrod").innerHTML = "  Upišite datum rođenja!";
return false;
}

var spol = document.getElementsByName('spol[]');
	var odabrano = false;
	for(var i=0;i<spol.length;i++){
		if(spol[i].checked == true){
			odabrano = true;
		break;
		}
		
	}
	
	if(odabrano == false){
	document.getElementById("lbkorisnikSpol").innerHTML = "  Odaberite spol!";
	return false;
	}


var email = document.getElementById("email");

var izrazi = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

if(izrazi.test(email.value) == false){
document.getElementById("lbkorisnikEmail").innerHTML = "  Pogrešan oblik mail adrese!";
email.focus();	
return false;	
}


var mobitel = document.getElementById("mob");
if(mobitel.value == ''){
document.getElementById("lbkorisnikMobitel").innerHTML = "  Upišite mobitel!";
return false;
}


return true;

}


function ValidKategorijaForm(login){


var naziv = document.getElementById("naziv");
if(naziv.value == ''){
document.getElementById("lbNazivKategorija").innerHTML = "  Upišite naziv kategorije!";
return false;

}

var knjiznicaodb = document.getElementById("knjiznicaodb");
if(knjiznicaodb.value == ''){
document.getElementById("lbKnjiznica").innerHTML = "  Odaberite knjižnicu!";
return false;
}

var NazivKnjiznica = document.getElementById("NazivKnjiznica");
if(NazivKnjiznica.value == ''){
document.getElementById("lbNazivKnjiznica").innerHTML = "  Upišite naziv knjižnice!";
return false;
}

var AdresaKnjiznica = document.getElementById("AdresaKnjiznica");
if(AdresaKnjiznica.value == ''){
document.getElementById("lbAdresaKnjiznica").innerHTML = "  Unesite adresu knjižnice!";
return false;
}

var KapacitetKnjiznica = document.getElementById("KapacitetKnjiznica");
if(Kapacitet.value == ''){
document.getElementById("lbKapacitetKnjiznica").innerHTML = "  Unesite kapacitet knjižnice!";
return false;
}


return true;

}


function ValidKnjiznicaForm(login){

var NazivKnjiznica = document.getElementById("NazivKnjiznica");
if(NazivKnjiznica.value == ''){
document.getElementById("lbNazivKnjiznica").innerHTML = "  Upišite naziv knjižnice!";
return false;
}

var AdresaKnjiznica = document.getElementById("AdresaKnjiznica");
if(AdresaKnjiznica.value == ''){
document.getElementById("lbAdresaKnjiznica").innerHTML = "  Unesite adresu knjižnice!";
return false;
}

var KapacitetKnjiznica = document.getElementById("KapacitetKnjiznica");
if(Kapacitet.value == ''){
document.getElementById("lbKapacitetKnjiznica").innerHTML = "  Unesite kapacitet knjižnice!";
return false;
}


return true;

}

function ValidRezervacijaForm(login){

var datumod = document.getElementById("datumod");
if(datumod.value == ''){
document.getElementById("lbRezDatumOd").innerHTML = "  Upišite datum od!";
return false;
}

var datumdo = document.getElementById("datumdo");
if(datumdo.value == ''){
document.getElementById("lbRezDatumOd").innerHTML = "  Upišite datum od!";
return false;
}

return true;

}


function ValidKnjigaForm(login){

var naziv = document.getElementById("naziv");
if(naziv.value == ''){
document.getElementById("lbKnjigaNaziv").innerHTML = "  Upišite naziv knjige!";
return false;
}

var isbn = document.getElementById("isbn");
if(isbn.value == ''){
document.getElementById("lbKnjigaISBN").innerHTML = "  Upišite ISBN!";
return false;
}

var autor = document.getElementById("autor");
if(autor.value == ''){
document.getElementById("lbKnjigaAutor").innerHTML = "  Upišite autor!";
return false;
}

var izdavac = document.getElementById("izdavac");
if(izdavac.value == ''){
document.getElementById("lbKnjigaIzdavac").innerHTML = "  Upišite izdavača!";
return false;
}

var godina = document.getElementById("godina");
if(godina.value == ''){
document.getElementById("lbKnjigaGodina").innerHTML = "  Upišite godinu!";
return false;
}

var kolicina = document.getElementById("kolicina");
if(kolicina.value == ''){
document.getElementById("lbKnjigaKolicina").innerHTML = "  Upišite količinu!";
return false;
}


var stranice = document.getElementById("stranice");
if(stranice.value == ''){
document.getElementById("lbKnjigaStrana").innerHTML = "  Upišite stranice!";
return false;
}

var novakat = document.getElementById("NovaKategorija");
if(novakat.value == ''){
document.getElementById("lbNovaKategorija").innerHTML = "  Upišite naziv kategorije!";
return false;
}

var opis = document.getElementById("opis");
if(opis.value == ''){
document.getElementById("lbKnjigaOpis").innerHTML = "  Upišite opis knjige!";
return false;
}

return true;

}


$(document).ready(function(){
	$("#image").mouseover(function(){
							   $("#pop-up").show();
							 });
	$("#image").mouseout(function(){
							   $("#pop-up").hide();
							 });
	});
	
	function prikazi(){
		
		alert("nesto");
	}
	
	
	function VratiPopisKategorija()
		{
		  var pojam = document.getElementById("pojam").value

		 if(pojam!=""){
		  
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttpKlijent=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttpKlijent=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttpKlijent.onreadystatechange=function()
		  {
		  if (xmlhttpKlijent.readyState==4 && xmlhttpKlijent.status==200)
			{	
			//document.tretman.cijena.value = xmlhttp.responseText;
			//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			var Kategorije = xmlhttpKlijent.responseText;
			
			document.getElementById("datagrid").innerHTML = Kategorije;
			}
		  }
		xmlhttpKlijent.open("GET","VratiKategorije.php?pojam="+pojam,true);
		xmlhttpKlijent.send();
		}
		else
		{
			window.location.href="kategorije.php";
		}	
		
		}
		
function VratiPopisKnjiga()
		{
		  var pojam = document.getElementById("pojam").value

		 if(pojam!=""){
		  
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttpKlijent=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttpKlijent=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttpKlijent.onreadystatechange=function()
		  {
		  if (xmlhttpKlijent.readyState==4 && xmlhttpKlijent.status==200)
			{	
			//document.tretman.cijena.value = xmlhttp.responseText;
			//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			var Kategorije = xmlhttpKlijent.responseText;
			
			document.getElementById("datagrid").innerHTML = Kategorije;
			}
		  }
		xmlhttpKlijent.open("GET","VratiKnjige.php?pojam="+pojam,true);
		xmlhttpKlijent.send();
		}
		else
		{
			window.location.href="knjige.php";
		}	
		
		}
		
		function VratiPopisClanova()
		{
		  var pojam = document.getElementById("pojam").value
			pojam = pojam.trim();
		 if(pojam!=""){
		  
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttpKlijent=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttpKlijent=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttpKlijent.onreadystatechange=function()
		  {
		  if (xmlhttpKlijent.readyState==4 && xmlhttpKlijent.status==200)
			{	
			//document.tretman.cijena.value = xmlhttp.responseText;
			//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			var Kategorije = xmlhttpKlijent.responseText;
			
			document.getElementById("datagrid").innerHTML = Kategorije;
			}
		  }
		xmlhttpKlijent.open("GET","VratiClanove.php?pojam="+pojam,true);
		xmlhttpKlijent.send();
		}
		else
		{
			window.location.href="clanovi.php";
		}	
		
		}
		
		
		function VratiStatistike()
		{
		  var pojam = document.getElementById("korisnik").value
			pojam = pojam.trim();
		 if(pojam!=""){
		  
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttpKlijent=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttpKlijent=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttpKlijent.onreadystatechange=function()
		  {
		  if (xmlhttpKlijent.readyState==4 && xmlhttpKlijent.status==200)
			{	
			//document.tretman.cijena.value = xmlhttp.responseText;
			//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			var Kategorije = xmlhttpKlijent.responseText;
			
			document.getElementById("datagrid").innerHTML = Kategorije;
			}
		  }
		xmlhttpKlijent.open("GET","VratiStatistike.php?pojam="+pojam,true);
		xmlhttpKlijent.send();
		}
		else
		{
			window.location.href="statknjige.php";
		}	
		
		}
		
		
		function VratiPodatkeDnevnika()
		{
		  var pojam = document.getElementById("pojam").value
			pojam = pojam.trim();
		 if(pojam!=""){
		  
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttpKlijent=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttpKlijent=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttpKlijent.onreadystatechange=function()
		  {
		  if (xmlhttpKlijent.readyState==4 && xmlhttpKlijent.status==200)
			{	
			//document.tretman.cijena.value = xmlhttp.responseText;
			//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			var Kategorije = xmlhttpKlijent.responseText;
			
			document.getElementById("datagrid").innerHTML = Kategorije;
			}
		  }
		xmlhttpKlijent.open("GET","VratiPodatkeDnevnika.php?pojam="+pojam,true);
		xmlhttpKlijent.send();
		}
		else
		{
			window.location.href="dnevnik.php";
		}	
		
		}
		
		
		function VratiKnjiznicu()
		{
		  var pojam = document.getElementById("knjiz").value
		  //alert("Pojam: "+pojam);
			//pojam = pojam.trim();
		 //if(pojam!=""){
		  
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttpKlijent=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttpKlijent=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttpKlijent.onreadystatechange=function()
		  {
			//alert("REady state: "+xmlhttpKlijent.readyState);  
			//alert("status: "+xmlhttpKlijent.status);  
		  if (xmlhttpKlijent.readyState==4 && xmlhttpKlijent.status==200)
			{	
			//document.tretman.cijena.value = xmlhttp.responseText;
			//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			var Kategorije = xmlhttpKlijent.responseText;
			
			document.getElementById("defknjiznica").innerHTML = Kategorije;
			window.location.href="index.php";
			}
		  }
		xmlhttpKlijent.open("GET","OdaberiKnjiznicu.php?knjiz="+pojam,true);
		xmlhttpKlijent.send();
		
		}
		
		
		function VratiTrazKnjiznice()
		{
		  var pojam = document.getElementById("pojam").value
			pojam = pojam.trim();
		 if(pojam!=""){
		  
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttpKlijent=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttpKlijent=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttpKlijent.onreadystatechange=function()
		  {
		  if (xmlhttpKlijent.readyState==4 && xmlhttpKlijent.status==200)
			{	
			//document.tretman.cijena.value = xmlhttp.responseText;
			//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			var Kategorije = xmlhttpKlijent.responseText;
			
			document.getElementById("datagrid").innerHTML = Kategorije;
			}
		  }
		xmlhttpKlijent.open("GET","VratiKnjiznice.php?pojam="+pojam,true);
		xmlhttpKlijent.send();
		}
		else
		{
			window.location.href="knjiznice.php";
		}	
		
		}