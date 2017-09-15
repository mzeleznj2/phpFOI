<?php
//include('baza_class.php');
include('dbconnect.php');
include('zaglavlje.php');
$_SESSION['strurl']="";
if($_SESSION['strurl']!=basename($_SERVER['SCRIPT_NAME'])){
$_SESSION['sort']='';
$_SESSION['strurl']=basename($_SERVER['SCRIPT_NAME']);
}

?>
<section id="sadrzaj">

 <?php
 echo "<h3 class='naslov'>";
if(isset($_SESSION['korime'])){
	echo "Vi ste: ".$_SESSION['korime'];
}
else
{
	echo "Niste prijavljeni";
}
echo "</h3>";
$idk=0;
	  if(isset($_SESSION['nazivknjiz'])){ 
	  $idk=$_SESSION['idknjiz'];
	  ?>
		<p id="defknjiznica"><a href="#"><strong>Knjižnica:</strong> <?php echo $_SESSION['nazivknjiz'].", ".$_SESSION['adresaknjiz'];?></p>	  
     <!--     <div id="defknjiznica"></div> -->
		<?php
		}
		
		if(isset($_SESSION['nazivknjiz']) || isset($_SESSION['korime']))
		{
		?>
		  <form name="knjiz" action="knjiznica.php" method="POST">
		  <p>Odaberite knjižnicu:<select name="knjiz" id="knjiz" class="gumb" onchange="VratiKnjiznicu()">
		  <option value="odb">Odaberite knjižnicu:</option>
		  <?php
		  $knjiz = PopisKnjiznica();
		  foreach($knjiz as $id=>$naziv){
			  echo "<option value='$id'";
			  if($id==$idk){
				  echo " selected";
			  }
			  echo ">$naziv</option>";
		  }		  
		  ?>
		  </select></p>
		<!--  <p><input type="submit" class="gumb" name="frmKnjiz" value="OK"></p> -->
		  </form>
		  </a>		
		<?php
		
		}
		DBConnect();
		$knjige = "select
  knj.autor,
  knj.naziv,  
    count(knj.idKnjiga),
	knj.slika
from posudbe pos, knjiga knj, kategorija kat, korisnik kor, knjiznica knjiz
where pos.idKnjiga = knj.idKnjiga
  and pos.idKorisnik = kor.idKorisnik
  and knj.kategorijaID = kat.idKategorija
  and kat.idKnjiznica = knjiz.idKnjiznica
group by knj.idKnjiga order by count(knj.idKnjiga) desc limit 10";
$_SESSION['url']='';


	
	echo "<h2>Gledate popis top 10 posudjenih knjiga po autoru<h2>";


//echo "<br>Upit: ".$knjige;
$qu = mysqli_query($dbc,$knjige);

	$tablica = "<div class='datagrid'>";
	$tablica.="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th>Autor</th><th>Naziv</th><th>Broj posudbi</th>";	
	$tablica.="</tr>";
	$tablica.="</thead>";
	$tablica.="<tbody>";
	$red=0;
	while(list($autor,$naziv,$brposudbi,$slika)=mysqli_fetch_array($qu)){
		
	$tablica.="<tr>";	
	$tablica.="<td>$autor</td><td>$naziv</td><td>$brposudbi</td>";
	//$tablica.="<td><img src='$slika'></td>";		
	$tablica.="</tr>";
	}
$tablica.="</tbody>";
$tablica.="</table>";
$tablica.="</div>";
echo $tablica;
$aktivna=1;
$imetbl = "tablica".$aktivna;
$_SESSION[$imetbl]=$tablica;

echo "<p><a href=\"knjigetop10.php?pdf=1&aktivna=$aktivna\" target=\"_blank\">Pretvori u pdf</p>";	


if(isset($_GET['pdf'])){
	ob_clean();
	require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Nicola Asuni');
// $pdf->SetTitle('TCPDF Example 048');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->Write(0, 'Top 10 knjiga', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------
if(session_id()==""){
session_start();	
}

$ime="tablica".$_GET['aktivna'];

if(isset($_SESSION[$ime])){
	$tabla = $_SESSION[$ime];
	unset($_SESSION[$ime]);
	unset($_SESSION['aktivna']);
}


$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td rowspan="3">COL 1 - ROW 1<br />COLSPAN 3</td>
        <td>COL 2 - ROW 1</td>
        <td>COL 3 - ROW 1</td>
    </tr>
    <tr>
        <td rowspan="2">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
        <td>COL 3 - ROW 2</td>
    </tr>
    <tr>
       <td>COL 3 - ROW 3</td>
    </tr>

</table>
EOD;



$pdf->writeHTML($tabla, true, false, false, false, ''); $naziv=str_replace("php","pdf",$skripta);


// -----------------------------------------------------------------------------
error_reporting(E_ALL);
//Close and output PDF document
$pdf->Output("$naziv", 'I');
}
		?>   
</section>
<?php
include('podnozje.php');
?>


