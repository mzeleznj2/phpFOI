<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
</head>
<body>

    {include file="include_headerNavigation.tpl"}

    <div id="sadrzaj">

        <h4 style="margin-left: 400px;"> Unesite email sa kojim ste registrirani na koji ćemo vam poslati novu lozinku: </h4> <br>

        <form id="promjena_pass" method="post" action="promjena_lozinke.php">
            <label for="email">Email: </label>
            <input id="email" type="text" name="email" placeholder="Email"><br><br>
            <input type="submit" value="Pošalji">
        </form>

    </div>

    {include file="include_cookieFooter.tpl"}

</body>
</html>


