<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
</head>
<body>

{include file="include_headerNavigation.tpl"}

<div id="sadrzaj">

    {if isset($evidencija) && count($evidencija) > 0}
        <table>
            <tr>
                <td>Program</td>
                <td>Opis</td>
            </tr>

            {foreach $evidencija as $e}
                <tr>
                    <td>{$e[1]}</td>
                    <td>{$e[0]}</td>
                </tr>
            {/foreach}

        </table>
    {/if}

</div>

{include file="include_cookieFooter.tpl"}

</body>
</html>