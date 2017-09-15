<!DOCTYPE html>
<html>
<head>
    {include file="include_head.tpl"}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" type="text/css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#korisniciTable').DataTable({
                "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
            });
        });
    </script>
</head>
<body>
{include file="include_headerNavigation.tpl"}

<div id="sadrzaj">

    {if count($korisnici) > 0}

        <table id="korisniciTable">
            <thead>
                <tr>
                    <td>Korisničko ime</td>
                    <td>Ime</td>
                    <td>Prezime</td>
                    <td>Email</td>
                    <td>Tip</td>
                    <td>Aktivan</td>
                </tr>
            </thead>
            <tbody>
        {foreach $korisnici as $korisnik}
            <tr>
                <td>{$korisnik[1]}</td>
                <td>{$korisnik[2]}</td>
                <td>{$korisnik[3]}</td>
                <td>{$korisnik[4]}</td>
                <td>
                    <form method="post" action="korisnici.php">
                        <input type="hidden" name="idKorisnik" value="{$korisnik[0]}">
                        <select name="tip">
                            <option value="1" {if $korisnik[5] == 1}selected{/if}>Administrator</option>
                            <option value="2" {if $korisnik[5] == 2}selected{/if}>Moderator</option>
                            <option value="3" {if $korisnik[5] == 3}selected{/if}>Registrirani</option>
                        </select>
                        <input type="submit" value="Izmjeni">
                    </form>

                </td>
                <td>
                    {if $korisnik[6] == 1}
                        DA
                        <form style="float: right;" method="post" action="korisnici.php">
                            <input type="hidden" name="zakljucaj" value="{$korisnik[0]}">
                            <input type="submit" value="Zaključaj">
                        </form>
                    {else}
                        NE
                        <form style="float: right;" method="post" action="korisnici.php">
                            <input type="hidden" name="otkljucaj" value="{$korisnik[0]}">
                            <input type="submit" value="Otključaj">
                        </form>
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