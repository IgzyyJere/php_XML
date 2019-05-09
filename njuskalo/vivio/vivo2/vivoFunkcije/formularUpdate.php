<?php


function formUpdate ( $naziv, $var, $podaci )

{
    
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea"><input type="text" name="',$var,'" value="',$podaci,'"></div>
          </div>';
           
}

function radioUpdate ( $naziv, $var, $podaci )

{
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea">
                <input type="radio" name="',$var,'" value="0"';
                
                if ( !$podaci ) {
                    
                    echo ' checked ';
                    
                }
                
                echo '>Ne
                <input type="radio" name="',$var,'" value="1"';
                
                if ( $podaci ) {
                    
                    echo ' checked ';
                    
                }
                
                echo '>Da
            </div>
          </div>';
          
}

function selectUpdate ( $naziv, $var, $podaci )

{
    
    $array = dajPolje ( $var );
    
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea"><select name="',$var,'">';
           
    foreach ( $array as $key => $value ) {
    
            echo '<option value="',$key,'" ';
            
            
            if ( $key == $podaci ) {
                    
                    echo ' selected="selected" ';
                    
                }
            
            echo '>',$value,'</option>';       
            
            } 
               
    echo  '</select></div>
          </div>';
          
}

function selectUpdateArray ( $naziv, $var, $array, $podaci )

{
    
    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea"><select name="',$var,'">';
           
    foreach ( $array as $key => $value ) {
    
            echo '<option value="',$key,'" ';
            
            
            if ( $key == $podaci ) {
                    
                    echo ' selected="selected" ';
                    
                }
            
            echo '>',$value,'</option>';       
            
            } 
               
    echo  '</select></div>
          </div>';
          
}

function textareaUpdate ( $naziv, $var, $podaci )

{
 
    echo  '<div class="textField">
            <div class="textTitle">',$naziv,'</div>
            <div class="textareaUpdate"><textarea name="',$var,'" class="dodajEditor">',$podaci,'</textarea>
          </div></div>';
          
}

    
function multiRadioUpdate ( $naziv, $var, $podaci )

{
    
    $opcije = dajPolje ( $var );

    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea">';
            
            foreach ( $opcije as $key => $value ) { 
                
                echo '<input type="radio" name="',$var,'" value="',$key,'"';
                
                if ( $key == $podaci ) {
                    
                    echo ' checked ';
                    
                }
                
                echo '>',$value,'<br />';
                
            }

    echo '</div>
          </div>';      

}

function mixedUpdate ( $naziv, $var, $varOption, $varValue )

{
    
    $opcije = dajPolje ( $var );

    echo '<div class="inputField">
            <div class="inputText">',$naziv,' : </div>
            <div class="inputArea">';
            
            foreach ( $opcije as $key => $value ) { 
                
                echo '<input type="radio" name="',$var,'Option" value="',$key,'"';
                
                
                if ( $key == $varOption ) {
                    
                    echo ' checked ';
                    
                }
                
                echo '>',$value,'<br />';
                
            }

    echo '<input type="text" name="',$var,'Value" value="',$varValue,'"></div>
          </div>';      

}

function mixedDropUpdate ( $naziv, $var )

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
