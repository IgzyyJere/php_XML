<?php
//PO TUTORIALU ZA API : https://medium.com/@miladev95/how-to-make-crud-rest-api-in-php-with-mysql-5063ae4cc89
//CREATE TABLE books (
// id  int AUTO_INCREMENT  primary key,
// title varchar(50),
// author varchar(50),
// published_at varchar(50)
// 
//
//);


//oprezno s ovim
//require_once './Framework/connector_class.php';
require_once './Framework/connector_class.php';

$ConnectionClass = new Connector();


try {
$db = new mysqli("localhost", "root", "", "api_test");
} catch (Exception $e){
    die("Database connection failed: " . $e->getMessage());
}


header('Content-Type: application/json');

// Handle HTTP methods
$method = $_SERVER['REQUEST_METHOD'];


switch($method){
    case 'GET':
        $sql_select =  'SELECT * FROM books'; //$db->query('SELECT * FROM books');
        $result = $db->query($sql_select);
        $rows = array();

                while($row = $result->fetch_assoc()){
                    $rows[] = $row;
                }

        if($result == false){
            echo json_encode(['message' => 'NOTHING!!']);
            break;
        }

        else
        echo $rows;
        break;

    case 'POST':
        //$data = json_decode(file_get_contents('php://input'), true);
        $title = $data['title'];
        $author = $data['author'];
        $published_at = $data['published_at'];  

        //$stmt = $pdo->prepare('INSERT INTO books (title, author, published_at) VALUES (?, ?, ?)');
      
      
           
            $sql_insert = 'INSERT INTO books (title, author, published_at) VALUES ("'.$title.'", "'.$author.'", "'.$published_at.'")';
            $db->query($sql_insert);
  
 
        echo json_encode(['message' => 'Book added successfully']);
        break;



    case 'PUT':
        // Update operation (edit a book)
        //parse_str(file_get_contents('php://input'), $data);
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $title = $data['title'];
        $author = $data['author'];
        $published_at = $data['published_at'];

        
        $sql_put = 'UPDATE books SET title= "'.$title.'", author = "'.$author.'", published_at = "'.$published_at.'" WHERE id = '.$id.'';
        $db->query($sql_put);

        echo json_encode(['message' => 'Book updated successfully']);
        break;


        case 'DELETE':
            // Delete operation (remove a book)
            $id = $_GET['id'];
            $sql_delete = 'DELETE FROM book WHERE id= "'.$id.'"';
            $db->query($sql_delete);

            echo json_encode(['message' => 'Book deleted successfully']);
            break;


            default:
             // Invalid method
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            break;

}





//close me!!
mysqli_close($db);

?>