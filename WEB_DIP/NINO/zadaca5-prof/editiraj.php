<?php
/*
 * The MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author Jurica Ševa <jurica.seva@foi.hr>
 */

include './_headerLogika.php';

#BRISANJE ZAPISA IZ TABLICE
if(isset($_GET['akcija']) && isset($_GET['idKorisnika'])){
    
    #promjena podataka tablice korisnik
    if($_GET['akcija']== 3){        
        $upit = "update korisnici set korisnici_email = '{$_POST['korisnici_email']}',"
        . "korisnici_lozinka = '{$_POST['korisnici_lozinka']}',"
        . "korisnici_naziv = '{$_POST['korisnici_naziv']}',"
        . "korisnici_prezime = '{$_POST['korisnici_prezime']}',"
        . "korisnici_adresa = '{$_POST['korisnici_adresa']}' ,"
        . "korisnici_grad = '{$_POST['korisnici_grad']}' "            
        . "where korisnici_id = '{$_GET['idKorisnika']}'";

        $baza->updateDB($upit,"korisnici.php");
    }    
    
    #"obriši" zapis
    if($_GET['akcija']==1){
        $crud->promijeniStanjeZapis('korisnici',$_GET['idKorisnika'],'0');
    }
        
    #aktiviraj zapis
    if($_GET['akcija']==0){
        $crud->promijeniStanjeZapis('korisnici',$_GET['idKorisnika'],'1');        
    }
    
    #PRIPREMA PROMJENE PODATAKA
    if($_GET['akcija']==2){
        
        $upit = "select * from korisnici where korisnici_id='{$_GET['idKorisnika']}'";
        $rezultatUpit = $baza->selectDB($upit);
        
        include './_headerHTML.php';
        
        if($rezultatUpit->num_rows == 1){
        
            $red = $rezultatUpit->fetch_assoc();
            #print_r($red);
        
    ?>   
        <article id="formular">
            <form name="registracija" action="<?php echo $aktivnaSkripta."?akcija=3&idKorisnika=".$red['korisnici_id']; ?>" method="POST">
                <label forname="korisnici_email">E-mail (korisničko ime!):</label>
                <input type="text" name="korisnici_email" size="50" value="<?php echo $red['korisnici_email']; ?>"><br>
                <label forname="korisnici_lozinka">Lozinka:</label>
                <input type="password" name="korisnici_lozinka" size="50" maxlength="20" value="<?php echo $red['korisnici_lozinka']; ?>"><br>
                <label forname="korisnici_naziv">Ime:</label><input type="text" name="korisnici_naziv" size="50" maxlength="100" value="<?php echo $red['korisnici_naziv']; ?>"><br>
                <label forname="korisnici_prezime">Prezime:</label><input type="text" name="korisnici_prezime" size="50" maxlength="100" value="<?php echo $red['korisnici_prezime']; ?>"><br>
                <label forname="korisnici_adresa">Adresa:</label><input type="text" name="korisnici_adresa" size="50" maxlength="45" value="<?php echo $red['korisnici_adresa']; ?>"><br>
                <label forname="korisnici_grad">Grad:</label><input type="text" name="korisnici_grad" size="50" maxlength="45" value="<?php echo $red['korisnici_grad']; ?>"><br>        
                <input type="submit" name="registracija" class="gumb" value="Promijeni"><input type="reset" name="Poništi" class="gumb" value="Resetiraj">
            </form>
        </article>
    <?php
        }
    }
    

} else {
    header("Location: greske.php?idGreske=2");
}

include './_footer.php';

?>