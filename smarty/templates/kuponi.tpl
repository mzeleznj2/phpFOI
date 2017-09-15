<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
</head>
<body>

{include file="include_headerNavigation.tpl"}

<div id="sadrzaj">
    <form method="post" action="kuponi.php">
        <label>Program:
        <select name="program">
            {foreach $programi as $program}
                <option value="{$program[0]}" {if isset($smarty.post.program) && $program[0] == $smarty.post.program}selected{/if}>{$program[1]}</option>
            {/foreach}
        </select>
            <input type="submit" value="Prikaži">
        </label>
    </form>

    <br>
    {if isset($kuponi) && count($kuponi) > 0}

        {foreach $kuponi as $kupon}
            <div style="display: inline-block; margin-right: 10px; text-align: center">
                {$kupon[1]} <br>
                <a href="kosarica.php?idKupon={$kupon[0]}{if isset($smarty.post.program)}&program={$smarty.post.program}{/if}">
                    <img title="Ddoaj u košaricu" src="slike/{$kupon[2]}" alt="{$kupon[1]}" style="width: 125px;"> <br>
                </a>
                {$kupon[3]} bodova
            </div>
        {/foreach}

    {/if}

</div>

{include file="include_cookieFooter.tpl"}

</body>
</html>