<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
Template Name: Educational
Author: <a href="http://www.os-templates.com/">OS Templates</a>
Author URI: http://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: http://www.os-templates.com/template-terms
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Knjižnica</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="layout/styles/layout.css" type="text/css" />
<script type="text/javascript" src="layout/scripts/jquery.min.js"></script>
<script type="text/javascript" src="layout/scripts/jquery.slidepanel.setup.js"></script>
<script type="text/javascript" src="layout/scripts/jquery.ui.min.js"></script>
<script type="text/javascript" src="layout/scripts/jquery.tabs.setup.js"></script>
</head>
<body>
<div class="wrapper col0">
  <div id="topbar">
    <div id="slidepanel">
      <div class="topbox">
        <h2>Knjižnica</h2>
        <p>U funkcionalno uređenim prostorima na tri lokacije, ukupne površine 1.330 m2, smješteno je oko 200.000 jedinica knjižnične građe na različitim medijima. Uz 18 stručnih djelatnika zaposleno je i administrativno te pomoćno osoblje, ukupno 22.</p>
        <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>
      </div>

      <div class="topbox">
        <h2>Administratori</h2>
        <form action="#" method="post">
          <fieldset>
            <legend>Admin forma</legend>
            <label for="teachername">Korisničko ime:
              <input type="text" name="teachername" id="teachername" value="" />
            </label>
            <label for="teacherpass">Lozinka:
              <input type="password" name="teacherpass" id="teacherpass" value="" />
            </label>
            <label for="teacherremember">
              <input class="checkbox" type="checkbox" name="teacherremember" id="teacherremember" checked="checked" />
              Zapamti me</label>
            <p>
              <input type="submit" name="teacherlogin" id="teacherlogin" value="Prijava" />
              &nbsp;
              <input type="reset" name="teacherreset" id="teacherreset" value="Poništi" />
            </p>
          </fieldset>
        </form>
      </div>

      <div class="topbox last">
        <h2>Korisnici</h2>
        <form action="#" method="post">
          <fieldset>
            <legend>Korisnička forma</legend>
            <label for="pupilname">Korisničko ime:
              <input type="text" name="pupilname" id="pupilname" value="" />
            </label>
            <label for="pupilpass">Lozinka:
              <input type="password" name="pupilpass" id="pupilpass" value="" />
            </label>
            <label for="pupilremember">
              <input class="checkbox" type="checkbox" name="pupilremember" id="pupilremember" checked="checked" />
              Zapamti me</label>
            <p>
              <input type="submit" name="pupillogin" id="pupillogin" value="Prijava" />
              &nbsp;
              <input type="reset" name="pupilreset" id="pupilreset" value="Poništi" />
            </p>
          </fieldset>
        </form>
      </div>

      <br class="clear" />
    </div>
    <div id="loginpanel">
      <ul>
        <li class="left">Prijava &raquo;</li>
        <li class="right" id="toggle"><a id="slideit" href="#slidepanel">Korisnici</a><a id="closeit" style="display: none;" href="#slidepanel">Zatvori panel</a></li>
      </ul>
    </div>
    <br class="clear" />
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col1">
  <div id="header">
    <div id="logo">
      <h1><a href="index.php">Knjižnica</a></h1>
      <p>Osvježite svoje znanje</p>
    </div>
    <div class="fl_right">
      <ul>
        <li class="last"><a href="#">Pretraga</a></li>
        <li><a href="#">Mapa weba</a></li>
        <li><a href="#">Dokumentacija</a></li>
      </ul>
      <p>Tel: xxxxx xxxxxxxxxx | Mail: info@domain.com</p>
    </div>
    <br class="clear" />
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col2">
  <div id="topnav">
    <ul>

      <li><a href="index.php">Home</a></li>
      <li><a href="knjiznice.php">Knjižnice</a>
        <ul>
          <li><a href="#">Unos</a></li>
          <li><a href="#">Ispis</a></li>
          <li><a href="#">Ažuriranje i brisanje</a></li>
          <li class="last"><a href="#">Suspendisse</a></li>
        </ul>
      </li>
	  <li><a href="kategorije.php">Kategorije</a>
        <ul>
          <li><a href="#">Unos</a></li>
          <li><a href="#">Ispis</a></li>
          <li><a href="#">Ažuriranje i brisanje</a></li>
          <li class="last"><a href="#">Suspendisse</a></li>
        </ul>
      </li>
      <li><a href="knjige.php">Knjige</a>
        <ul>
          <li><a href="#">Unos</a></li>
          <li><a href="#">Ispis</a></li>
          <li><a href="#">Ažuriranje i brisanje</a></li>
          <li class="last"><a href="#">Suspendisse</a></li>
        </ul>
      </li>
	   <li><a href="clanovi.php">Članovi</a>
        <ul>
          <li><a href="#">Unos</a></li>
          <li><a href="#">Ispis</a></li>
          <li><a href="#">Ažuriranje i brisanje</a></li>
          <li class="last"><a href="#">Suspendisse</a></li>
        </ul>
      </li>
	   <li class="active"><a href="posudbe.php">Posudbe</a>
        <ul>
          <li><a href="#">Unos</a></li>
          <li><a href="#">Ispis</a></li>
          <li><a href="#">Ažuriranje i brisanje</a></li>
          <li class="last"><a href="#">Suspendisse</a></li>
        </ul>
      </li>
	  <!--
      <li><a href="#">Our Services</a></li>
	  -->
      <li class="last"><a href="lokacije.php">Lokacije</a></li>
    </ul>
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col3">
  <div id="featured_slide">
    <div id="featured_wrap">
      <ul id="featured_tabs">
        <li><a href="#fc1">Gradska knjižnica "Metel Ožegović"<br />
          <span>Trg Slobode 8a, Varaždin</span></a></li>
        <li><a href="#fc2">Gradska knjižnica "Ivanec"<br />
          <span>Ivanečka 8a, Ivanec</span></a></li>
        <li><a href="#fc3">Gradska knjižnica "Nikola Zrinski"<br />
          <span>Trg Republike 4, Čakovec</span></a></li>
        <li class="#last"><a href="#fc4">Gradska Knjižnica "Prelog"<br />
          <span>Glavna ulica 5, Prelog</span></a></li>
		  Stranice:
      </ul>
	  
      <div id="featured_content">
        <div class="featured_box" id="fc1"><img src="images/demo/1.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc2"><img src="images/demo/2.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc3"><img src="images/demo/3.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc4"><img src="images/demo/4.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
      </div>
	  
    </div>
  </div>
  
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col4">
  <div id="container">
    <div id="hpage">
      <ul>
        <li>
          <h2>Indonectetus facilis leo</h2>
          <div class="imgholder"><a href="#"><img src="images/demo/5.jpg" alt="" /></a></div>
          <p>This is a W3C standards compliant free website template from <a href="http://www.os-templates.com/">OS Templates</a>. For more CSS templates visit <a href="http://www.os-templates.com/">Free Website Templates</a>. Etmetus conse cte tuer leo nisl justo sed vest vitae nunc massa scelerit</p>
          <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>
        </li>
        <li>
          <h2>Indonectetus facilis leo</h2>
          <div class="imgholder"><a href="#"><img src="images/demo/6.jpg" alt="" /></a></div>
          <p>This template is distributed using a <a href="http://www.os-templates.com/template-terms">Website Template Licence</a>, which allows you to use and modify the template for both personal and commercial use when you keep the provided credit links in the footer.</p>
          <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>
        </li>
        <li>
          <h2>Indonectetus facilis leo</h2>
          <div class="imgholder"><a href="#"><img src="images/demo/7.jpg" alt="" /></a></div>
          <p>Seddui vestibulum vest mi liberos estibulum urna at eget amet sed. Etmetus consectetuer leo nisl justo sed vest vitae nunc massa scelerit. Namaucibulum lor ligula nullam risque et ristie sollis sapien nulla neque.</p>
          <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>
        </li>
        <li class="last">
          <h2>Indonectetus facilis leo</h2>
          <div class="imgholder"><a href="#"><img src="images/demo/8.jpg" alt="" /></a></div>
          <p>Nullamlacus dui ipsum conseque loborttis non euisque morbi pen as dapibulum orna. Urna ultrices quis curabitur phasellentesque congue magnis vestibulum. Orcieleifendimentum risuspenatoque massa nunc.</p>
          <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>
        </li>
      </ul>
      <br class="clear" />
    </div>
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col5">
  <div id="footer">
    <div id="newsletter">
      <h2>Stay In The Know !</h2>
      <p>Please enter your email to join our mailing list</p>
      <form action="#" method="post">
        <fieldset>
          <legend>News Letter</legend>
          <input type="text" value="Enter Email Here&hellip;"  onfocus="this.value=(this.value=='Enter Email Here&hellip;')? '' : this.value ;" />
          <input type="submit" name="news_go" id="news_go" value="GO" />
        </fieldset>
      </form>
      <p>To unsubscribe please <a href="#">click here &raquo;</a></p>
    </div>
    <div class="footbox">
      <h2>Lacus interdum</h2>
      <ul>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Lorem ipsum dolor</a></li>
        <li><a href="#">Suspendisse in neque</a></li>
        <li class="last"><a href="#">Praesent et eros</a></li>
      </ul>
    </div>
    <div class="footbox">
      <h2>Lacus interdum</h2>
      <ul>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Lorem ipsum dolor</a></li>
        <li><a href="#">Suspendisse in neque</a></li>
        <li class="last"><a href="#">Praesent et eros</a></li>
      </ul>
    </div>
    <div class="footbox">
      <h2>Lacus interdum</h2>
      <ul>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Lorem ipsum dolor</a></li>
        <li><a href="#">Suspendisse in neque</a></li>
        <li class="last"><a href="#">Praesent et eros</a></li>
      </ul>
    </div>
    <br class="clear" />
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col6">
  <div id="copyright">
    <p class="fl_left">Copyright &copy; 2014 - All Rights Reserved - <a href="#">Domain Name</a></p>
    <p class="fl_right">Template by <a target="_blank" href="http://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
    <br class="clear" />
  </div>
</div>
</body>
</html>