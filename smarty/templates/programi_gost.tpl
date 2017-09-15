<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
</head>
<body>

{include file="include_headerNavigation.tpl"}

<div id="sadrzaj">

    Odaberite vrstu programa:
    <form method="post" action="programi_gost.php">
        <select name="idVrsta">
            {foreach $vrstaPrograma as $vrstaP}
                <option value="{$vrstaP[0]}" {if isset($smarty.post.idVrsta) && $vrstaP[0] == $smarty.post.idVrsta} selected {/if}>{$vrstaP[1]}</option>
            {/foreach}
        </select>
        <input type="submit" value="Prikaži">
    </form>

    {if isset($programi) && count($programi) > 0}
    <table>
        <tr>
            <td>Naziv</td>
            <td>Vrijeme</td>
            <td>Trajanje</td>
            <td>Broj polaznika</td>
        </tr>

        {foreach $programi as $program}
        <tr>
            <td>{$program[0]}</td>
            <td>{$program[1]}</td>
            <td>{$program[2]}</td>
            <td>{$program[3]}</td>
        </tr>
        {/foreach}

    </table>
    {/if}

</div>

{include file="include_cookieFooter.tpl"}

</body>
</html>