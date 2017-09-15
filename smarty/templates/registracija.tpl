<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

    {include file="include_headerNavigation.tpl"}

    <div id="jsGreske"></div>

    <div id="sadrzaj">

        <form id="registracija" action="registracija.php" method="POST">
            <label>Način prijave: </label>
            <label><input type="radio" name="nacinPrijave" value="1" checked> Jedan korak</label>
            <label><input type="radio" name="nacinPrijave" value="2"> Dva koraka</label>
            <br><br><br>
            <label for ="ime"> Ime: </label>
            <input type="text" id="ime" name="ime" placeholder="Ime" ><br>
            <label for="prezime">Prezime: </label>
            <input type="text" id="prezime" name="prezime" placeholder="Prezime"  ><br>
            <label for="korime">Korisničko ime: </label>
            <input type="text" id="korime" name="korime" placeholder="Korisničko ime"  ><br>
            <label for="email">Email adresa: </label>
            <input  id="email" name="email" placeholder="Email"  ><br>
            <label for="lozinka1">Lozinka: </label>
            <input type="password" id="lozinka1" name="lozinka1" placeholder="Lozinka" ><br>
            <label for="lozinka2">Ponovi pozinku: </label>
            <input type="password" id="lozinka2" name="lozinka2" placeholder="Ponovi lozinku">
            <br><br>
            <div class="g-recaptcha" data-sitekey="6Leb7h4TAAAAALvUW1yxckRyPN6d9_4-4LJudwyc"></div>
            <br>
            <input id="registracijaSubmit" type="submit" value="Registriraj se">
        </form>

    </div>

    {include file="include_cookieFooter.tpl"}

</body>
</html>