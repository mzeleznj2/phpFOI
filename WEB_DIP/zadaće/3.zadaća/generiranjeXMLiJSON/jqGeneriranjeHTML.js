$(function () {
    $('#json').click(function (){
        var tablica = $('<table id="tablica" class="display">');
        tablica.append('<thead><tr><th>Ime</th><th>Prezime</th><th>Email</th></tr>')
            
        $.getJSON('korisnici.json',function (data){
           var tbody = $("<tbody>");
           for(i=0; i<data.length;i++){
               var red = "<tr>";
               red += "<td>"+data[i].ime+"</td>";
               red += "<td>"+data[i].prezime+"</td>";
               red += "<td>"+data[i].email+"</td>";
               red += "</tr>";
               tbody.append(red);
           }
           tbody.append("</tbody>");
           tablica.append(tbody);
           $('#content').html(tablica);
           $('#tablica').dataTable();
        });
    });
    
    $('#xml').click(function (){
        $('#content').empty();
        $('#content').html('nesto');
        var dia = '<section id="dialog" ><p>XML prihavt podataka i tablica za doma</p></section>';
        $('#content').html(dia);
        $('#dialog').dialog(
                {
                    show: {
                        effect: "blind",
                        duration: 1000
                    },
                    hide: {
                        effect: "explode",
                        duration: 1000
                    }
                }
        );
    });
    
});


