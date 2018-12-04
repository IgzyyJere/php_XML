<?php

/** create XML file */
$mysqli = new mysqli("localhost", "root", "", "testnekrenine");

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

         createXMLfile($booksArray);

     }

    /* free result set */
    $result->free();
}

/* close connection */
$mysqli->close();

function createXMLfile($booksArray){

   $filePath = 'book.xml';

   $dom     = new DOMDocument('1.0', 'utf-8');

   $root      = $dom->createElement('books');

   for($i=0; $i<count($booksArray); $i++){

     $bookId        =  $booksArray[$i]['id'];

     $bookName      =  $booksArray[$i]['name'];

     $bookAuthor    =  $booksArray[$i]['author_name'];

     $bookPrice     =  $booksArray[$i]['price'];

     $bookISBN      =  $booksArray[$i]['ISBN'];

     $bookCategory  =  $booksArray[$i]['category'];

     $book = $dom->createElement('book');

     $book->setAttribute('id', $bookId);

     $name     = $dom->createElement('name', $bookName);

     $book->appendChild($name);

     $author   = $dom->createElement('author', $bookAuthor);

     $book->appendChild($author);

     $price    = $dom->createElement('price', $bookPrice);

     $book->appendChild($price);

     $isbn     = $dom->createElement('ISBN', $bookISBN);

     $book->appendChild($isbn);

     $category = $dom->createElement('category', $bookCategory);

     $book->appendChild($category);

     $root->appendChild($book);

   }

   $dom->appendChild($root);

   $dom->save($filePath);

 }



 ?>

 <!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}

    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }

    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;}
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4>John's Blog</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#section1">Home</a></li>
        <li><a href="apartmanUnos.php">turizam</a></li>
        <li><a href="#section3">Family</a></li>
        <li><a href="#section3">Photos</a></li>
      </ul><br>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Blog..">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </div>


  </div>
</div>

<footer class="container-fluid">
  <p>Footer Text</p>
</footer>

</body>
</html>
