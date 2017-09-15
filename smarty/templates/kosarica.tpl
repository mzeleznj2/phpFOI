<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
</head>
<body>

{include file="include_headerNavigation.tpl"}

<div id="sadrzaj">

    {if !empty($rezultat)}

        <table>
        <tr>
            <td>Naziv</td>
            <td>Slika</td>
            <td>Aktivan od</td>
            <td>Aktivan do</td>
            <td>Bodovi</td>
            <td>Kupi</td>
        </tr>
        {foreach $rezultat as $item}
        <tr>
            <td>{$item[2]}</td>
            <td><img src="slike/{$item[3]}" style="max-width: 60px;"></td>
            <td>{$item[4]}</td>
            <td>{$item[5]}</td>
            <td>{$item[6]}</td>
            <td>
                <form method="post" action="kosarica.php">
                    <input type="hidden" name="idKupon" value="{$item[0]}">
                    <input type="hidden" name="idProgram" value="{$item[1]}">
                    <input type="submit" value="Kupi">
                </form>
            </td>

        </tr>
    {/foreach}
            <tr>
                <td style="text-align: right;" colspan="6">
                    <form method="post" action="kosarica.php">
                        <input type="submit" name="isprazni" value="Isprazni košaricu">
                    </form>
                </td>
            </tr>
        </table>

    {/if}

</div>

{include file="include_cookieFooter.tpl"}

</body>
</html>