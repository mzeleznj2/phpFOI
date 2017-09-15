<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" type="text/css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#bodoviTable').DataTable({
                "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
            });
        });
    </script>
</head>
<body>

{include file="include_headerNavigation.tpl"}

<div id="sadrzaj">

    {if isset($bodovi) && count($bodovi) > 0}
        <table id="bodoviTable">
            <thead>
                <tr>
                    <td>Akcija</td>
                    <td>Vrijeme</td>
                    <td>Bodovi</td>
                </tr>
            </thead>

            <tbody>
                {foreach $bodovi as $bod}
                    <tr>
                        <td>{$bod[2]}</td>
                        <td>{$bod[0]}</td>
                        <td>{$bod[1]}</td>
                    </tr>
                {/foreach}
            </tbody>

            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">
                        <div>Ukupno: {$ukupno['bodovi']} bodova</div>
                        <div>Potrošeno: {$ukupno['potroseno']} bodova</div>
                        <div>Preostalo: {$ukupno['bodovi'] - $ukupno['potroseno']} bodova</div>
                    </td>
                </tr>
            </tfoot>

        </table>
    {/if}

</div>

{include file="include_cookieFooter.tpl"}

</body>
</html>