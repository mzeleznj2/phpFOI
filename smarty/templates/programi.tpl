<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" type="text/css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#programiTable').DataTable({
                "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
            });
        });
    </script>
</head>
<body>

{include file="include_headerNavigation.tpl"}

<div id="sadrzaj">

    Odaberite vrstu programa:
    <form method="post" action="programi.php">
        <select name="idVrsta">
            {foreach $vrstaPrograma as $vrstaP}
                <option value="{$vrstaP[0]}" {if isset($smarty.post.idVrsta) && $vrstaP[0] == $smarty.post.idVrsta} selected {/if}>{$vrstaP[1]}</option>
            {/foreach}
        </select>
        <input type="submit" value="Prikaži">
    </form>
    <br>

    {if isset($programi) && count($programi) > 0}
    <table id="programiTable">
        <thead>
            <tr>
                <td>Naziv</td>
                <td>Vrijeme</td>
                <td>Zamjenski termin</td>
                <td>Trajanje</td>
                <td>Max.broj polaznika</td>
                <td>Broj prijavljenih polaznika</td>
                <td>Prijava</td>
            </tr>
        </thead>

        <tbody>
            {foreach $programi as $program}
            <tr>
                <td>{$program[7]}</td>
                <td>{date("d.m.Y H:i", $program[1])}</td>
                <td>
                    {if $program[2] > 0 }
                        {date("d.m.Y H:i", $program[2])}
                    {/if}
                </td>
                <td>{$program[6]}</td>
                <td>{$program[3]}</td>
                <td>{$program[8]}</td>
                <td>
                    {if $program[9] == 1}
                        Prijavljen
                    {elseif $program[8] < $program[3]}
                        <form method="post" action="programi_prijava.php">
                            <input type="hidden" name="idProgram" value="{$program[0]}">
                            <input type="submit" value="Prijavi me">
                        </form>
                    {else}
                        Popunjeno
                    {/if}
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
    {/if}

</div>

{include file="include_cookieFooter.tpl"}

</body>
</html>