<?php
if($_POST){
   $bar = $_POST['bar'];
   echo'OVo je post'+$bar;
}
 

?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery.post demo</title>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<body>
 
    <form action="/" id="contactForm1" method="post">
    <input type="text" name="s" placeholder="Search...">
    <input type="submit" value="Search">
    </form>


<form id="foo">
    <label for="bar">A bar</label>
    <input id="bar" name="bar" type="text" value="" />

    <input type="submit" value="Send" />
</form>


<br/>
<hr/>

<form method="post" name="postForm">
    <ul>
        <li>
            <label>Name</label>
            <input type="text" name="name" id="name" placeholder="Bruce Wayne">
            <span class="throw_error"></span>
            <span id="success"></span>
       </li>
   </ul>
   <input type="submit" value="Send" />
</form>



<!-- the result of the search will be rendered inside this div -->
<div id="result"></div>
 
<script type="text/javascript">
    var frm = $('#contactForm1');

    frm.submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                console.log('Submission was successful.');
                alert("kiki");
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    });
</script>




<script type="text/javascript">
var request;


$("#foo").submit(function(event){

  event.preventDefault();

 
  if(request){
    request.abort();
  }

     // setup some local variables
    var $form = $(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

      // Fire off the request to /form.php
    request = $.ajax({
        url: "/",
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Hooray, it worked!");
    });


     // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });


})


</script>



<script type="text/javascript">
$(document).ready(function() {
    $('form').submit(function(event) { //Trigger on form submit
        $('#name + .throw_error').empty(); //Clear the messages first
        $('#success').empty();

        //Validate fields if required using jQuery

        var postForm = { //Fetch form data
            'name'     : $('input[name=name]').val() //Store name fields value
        };

        $.ajax({ //Process the form using $.ajax()
            type      : 'POST', //Method type
            url       : 'process.php', //Your form processing file URL
            data      : postForm, //Forms name
            dataType  : 'json',
            success   : function(data) {
                            if (!data.success) { //If fails
                                if (data.errors.name) { //Returned if any error from process.php
                                    $('.throw_error').fadeIn(1000).html(data.errors.name); //Throw relevant error
                                }
                            }
                            else {
                                    $('#success').fadeIn(1000).append('<p>' + data.posted + '</p>'); //If successful, than throw a success message
                                }
                            }
        });
        event.preventDefault(); //Prevent the default submit
    });
});

</script>
 
</body>
</html>