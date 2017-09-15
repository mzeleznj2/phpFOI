$(document).ready(function(){
    
    $("#tablica").dataTable({
        "aaSorting" : [[0,"asc"],[1,"asc"]],
        "bPaginate" : true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true });
    
    $("#tablica1").dataTable({
        "aaSorting" : [[0,"asc"],[1,"asc"]],
        "bPaginate" : true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true });
});