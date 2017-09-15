<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
</head>
<body>

    {include file="include_headerNavigation.tpl"}

    <div id="sadrzaj">

        <form method="post" action="prijava_drugi_korak.php">
            <label for='aktivacijskiKod'>Aktivacijski kod: </label>
            <input id='aktivacijskiKod' type='text' name='aktivacijskiKod'>
            <input type='submit' value='Potvrdi'>
        </form>

    </div>

    {include file="include_cookieFooter.tpl"}

</body>
</html>