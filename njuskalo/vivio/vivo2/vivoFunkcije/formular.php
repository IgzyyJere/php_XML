<?php

function formInsert ( $naziv, $var )

{
    
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea"><input type="text" name="',$var,'"></div>
          </div>';
           
}

function radioInsert ( $naziv, $var )

{
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea">
                <input type="radio" name="',$var,'" value="0">Ne
                <input type="radio" name="',$var,'" value="1">Da
            </div>
          </div>';
          
}

function selectInsert ( $naziv, $var )

{   

    $array = dajPolje ( $var ); 
  
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea"><select name="',$var,'">';
           
    foreach ( $array as $key => $value ) {
    
            echo '<option value="',$key,'">',$value,'</option>';       
            
            } 
               
    echo  '</select></div>
          </div>';
          
}

function selectInsertArray ( $naziv, $var, $array )

{   
  
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea"><select name="',$var,'">';
           
    foreach ( $array as $key => $value ) {
    
            echo '<option value="',$key,'">',$value,'</option>';       
            
            } 
               
    echo  '</select></div>
          </div>';

}

function textareaInsert ( $naziv, $var )

{
 
    echo  '<div class="textField">
            <div class="textTitle">',$naziv,'</div>
            <div class="textareaInsert"><textarea name="',$var,'" class="dodajEditor"></textarea>
          </div></div>';
          
}
 
function formGallery ( $broj ) 

{

    echo '<div>';
    for ( $i=0; $i<$broj; $i++ ) {
    
        echo '<div class="formPicture"><img src="slike/test.jpg"><br />
        <a href=""><img src="ikone/delete.png" class="deletePic"></a></div>';
        
    }
    echo '</div>';
    
} 
function formPicUpload ()

    {
    
     echo '<div class="uploadForm">
            <form id="uploadSlike" action="upload.php" method="post" enctype="multipart/form-data"> 
            <input type="file" name="datoteka">
            <button type="submit" class="buttonSubmit"><img src="ikone/arrow_up.png">Pošalji datoteku</button>
            </form></div>';
            
    }
    
function multiRadioInsert ( $naziv, $var )

{
     
    $opcije = dajPolje ( $var );    
       
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea">';
            
            foreach ( $opcije as $key => $value ) { 
                
                echo '<input type="radio" name="',$var,'" value="',$key,'">',$value,'<br />';
                
            }

    echo '</div>
          </div>';      

}

function mixedInsert ( $naziv, $var )

{
    
    $opcije = dajPolje ( $var );    
   
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea">';
            
            foreach ( $opcije as $key => $value ) { 
                
                echo '<input type="radio" name="',$var,'Option" value="',$key,'">',$value,'<br />';
                
            }

    echo '<input type="text" name="',$var,'Value"></div>
          </div>';      

}

function mixedDropInsert ( $naziv, $var )

{
    
    $array = dajPolje ( $var );    
     
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea"><select name="',$var,'">';
           
    foreach ( $array as $key => $value ) {
    
            echo '<option value="',$key,'">',$value,'</option>';       
            
            } 
               
    echo  '</select><br />
            <div class="inputArea mixedDrop" title=',$var,'>Nova mikrolokacija</div>
            </div>
          </div>';          
  
}  
        
?>
