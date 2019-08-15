<?php

/** create XML file */
$mysqli = new mysqli("localhost", "root", "", "");

/* check connection */
if ($mysqli->connect_errno) {

   echo "Connect failed ".$mysqli->connect_error;

   exit();
}

$query = "SELECT * FROM books";

$booksArray = array();

if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {

       array_push($booksArray, $row);
    }

    if(count($booksArray)){
       //  createXMLfile($booksArray);
     }

    /* free result set */
    $result->free();
}

/* close connection */
$mysqli->close();

// function createXMLfile($booksArray){

//    $filePath = 'book.xml';

//    $dom     = new DOMDocument('1.0', 'utf-8');

//    $root      = $dom->createElement('books');

//    for($i=0; $i<count($booksArray); $i++){

//      $bookId        =  $booksArray[$i]['id'];

//      $bookName      =  $booksArray[$i]['name'];

//      $bookAuthor    =  $booksArray[$i]['author_name'];

//      $bookPrice     =  $booksArray[$i]['price'];

//      $bookISBN      =  $booksArray[$i]['ISBN'];

//      $bookCategory  =  $booksArray[$i]['category'];

//      $book = $dom->createElement('book');

//      $book->setAttribute('id', $bookId);

//      $name     = $dom->createElement('name', $bookName);

//      $book->appendChild($name);

//      $author   = $dom->createElement('author', $bookAuthor);

//      $book->appendChild($author);

//      $price    = $dom->createElement('price', $bookPrice);

//      $book->appendChild($price);

//      $isbn     = $dom->createElement('ISBN', $bookISBN);

//      $book->appendChild($isbn);

//      $category = $dom->createElement('category', $bookCategory);

//      $book->appendChild($category);

//      $root->appendChild($book);

//    }

//    $dom->appendChild($root);

//    $dom->save($filePath);

//  }



 ?>

 <!DOCTYPE html>
<html lang="en">
<head>
  <title>PHP XML app</title>
  <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


</head>
<body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Naslovna <span class="sr-only">(current)</span></a>
      </li>
  
      <li class="nav-item">
            <a class="nav-link" href="IEList.php">Lista iz <T></a>
      </li>


         <li class="nav-item">
            <a class="nav-link" href="portal.php">Tool portal</a>
      </li>





      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          T-Tomislav
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="zemljistvaUnos.php">Zemljišta</a>
          <a class="dropdown-item" href="StanoviUnos.php">Stanovi</a>
          <a class="dropdown-item" href="PoslovniUnos.php">Poslovni prostori</a>
           <a class="dropdown-item" href="googleMapGen.php" target="_blank">google Map gen</a>
                 <a class="dropdown-item" href="garaze_transfer.php">Garaže</a>
                      <a class="dropdown-item" href="apartmanUnos.php">Turizam</a>
                         <a class="dropdown-item" href="kuceUnos.php">Kuče</a>
                       <a class="dropdown-item" href="njuskalo/index.php">Njuškalo</a>
          <div class="dropdown-divider"></div>
          <!-- <a class="dropdown-item" href="#">Something else here</a> -->
        </div>
      </li>
     
    </ul>

  </div>
</nav>

<div class="container">


<div class="card text-center">
  <div class="card-header">
    Aplikacija za transfer podataka iz mysql u XML
  </div>
  <div class="card-body">
    <h5 class="card-title">Upute</h5>
    <p class="card-text">Klikni i rješio si, ako si napravio pritom kod ;)</p>
  
<p>Za T-tomislav dio, svaka aplikacija ima genereriranje google map koda


  </div>
  <div class="card-footer text-muted">
    
  </div>
</div>





</div>









</body>
</html>
