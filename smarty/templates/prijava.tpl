<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
</head>
<body>

    {include file="include_headerNavigation.tpl"}

    <div id="sadrzaj">

        <form id="prijava" method="post" action="prijava.php">
            <label for="korime">Korisničko ime: </label>
            <input type="text" id="korime" name="korime" placeholder="Korisničko ime" value="{if isset($korime)}{$korime}{/if}"><br>
            <label for="lozinka">Lozinka: </label>
            <input type="password" id="lozinka" name="lozinka" placeholder="Lozinka" ><br>
            Zapamti me:
            <label>
                <input id="zapamti" type="radio" name="zapamtiMe" value="1" {if isset($korime)} checked="checked" {/if}>DA
            </label>
            <label>
                <input type="radio" name="zapamtiMe" value="0" {if !isset($korime)} checked="checked" {/if}>NE
            </label>
            <br>
            <input id="submit" type="submit" name="login" value=" Prijavi se "><br>
            <a href="registracija.php"> Registracija </a> <br> <br>
            <a href="promjena_lozinke.php"> Zaboravili ste lozinku? </a> <br> <br>
        </form>

        

    </div>

    {include file="include_cookieFooter.tpl"}

</body>
</html>