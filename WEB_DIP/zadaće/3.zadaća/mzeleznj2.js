//console.log("Prijava");

function kreirajDogadaj()
{
    var formular = document.getElementById("form1");
    var greske = document.getElementById("greske");
    var opis = document.getElementById("opis");
    //opis.readonly = true;
    
    
    opis.addEventListener("keydown", function(event){     
    console.log("keydown");
    opis.Disabled = true;
    }, false) ;
      
    formular.addEventListener("submit",function(event){
        console.log(formular.length);
        for (var i = 0; i < formular.length; i++) {
        //console.log(formular[i].value);
        
        if (formular[0].value.length < 5)
        {          
            greske.innerHTML = " Premalo znakova ";
            //greske.setAttribute("style", "");
        }
     
    }
     event.preventDefault();        
    } , false) ;
    
         
}



