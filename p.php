






<?php


// utility functions
include 'potKlasa.php';
// function print_vars($obj)
// {
// foreach (get_object_vars($obj) as $prop => $val) {
//     echo "\t$prop = $val\n";
// }
// }

// function print_methods($obj)
// {
// $arr = get_class_methods(get_class($obj));
// foreach ($arr as $method) {
//     echo "\tfunction $method()\n";
// }
// }

// function class_parentage($obj, $class)
// {
// if (is_subclass_of($GLOBALS[$obj], $class)) {
//     echo "Object $obj belongs to class " . get_class($GLOBALS[$obj]);
//     echo ", a subclass of $class\n";
// } else {
//     echo "Object $obj does not belong to a subclass of $class\n";
// }
// }

// // instantiate 2 objects

$veggie = new Vegetable(true, "blue");
$leafy = new Spinach();
$klasa = new mojaKlasa();



// // print out information about objects
// echo "veggie: CLASS " . get_class($veggie) . "\n";
// echo "leafy: CLASS " . get_class($leafy);
// echo ", PARENT " . get_parent_class($leafy) . "\n";

// // show veggie properties
// echo "\nveggie: Properties\n";
// print_vars($veggie);

// // and leafy methods
// echo "\nleafy: Methods\n";
// print_methods($leafy);

// echo "\nParentage:\n";
// class_parentage("leafy", "Spinach");
// class_parentage("leafy", "Vegetable");

echo '<h1>'.$klasa->miki.'</h1>';





function Insertdata($table,$field,$data)
{
   //$mysqli = new mysqli("localhost", "webzyco1_crmUser", "~7ZnPi,%jHU@", "webzyco1_crm");
        $mysqli = new mysqli("localhost", "root", "", "test");
        mysqli_set_charset($mysqli,'utf-8');
        $field_values= implode(',',$field);
        $data_values=implode("','",$data);

        $sql= "INSERT INTO $table (".$field_values.") 
        VALUES ('".$data_values."') ";
        $result = $mysqli->query($sql);
}

$field = array('levelID','description', 'title');
$data = array('1', 'kiki', 'kurac');
//Insertdata("level", $field, $data);






function UpdatedataT(array $id, array $values, $tableName)
{
   //$mysqli = new mysqli("localhost", "webzyco1_crmUser", "~7ZnPi,%jHU@", "webzyco1_crm");
        $mysqli = new mysqli("localhost", "root", "", "test");
        mysqli_set_charset($mysqli,'utf-8');

        $ID = $id;
        $sIDColumn = key($id);
        $sIDValue  = current($id);
        $arrayValues = $values;

                array_walk($values, function(&$value, $key)
                {
                $value = "{$key} = '{$value}'";
                });
        $sUpdate = implode(", ", array_values($values));
        $sql = "UPDATE {$tableName} SET {$sUpdate} WHERE {$sIDColumn} = '{$sIDValue}'";
        $mysqli->query($sql);
     
        echo $sql;
}

$testArray = array(
     "levelID" => '2',
    "description" => "test222",
    "title" => "test222"
);

$table = "level";
//UpdatedataT(array("levelID"=> 1 ), $testArray, $table);











// again where clause is left optional
function dbRowUpdate($table_name, $form_data, $where_clause='')
{
            $mysqli = new mysqli("localhost", "root", "", "test");
           mysqli_set_charset($mysqli,'utf8');
    $whereSQL = '';
    if(!empty($where_clause))
    {

        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {

            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }

    $sql = "UPDATE ".$table_name." SET ";
 
    $sets = array();
    foreach($form_data as $column => $value)
    {
         $sets[] = "`".$column."` = '".$value."'";
    }
    $sql .= implode(', ', $sets);

    $sql .= $whereSQL;


 //return mysql_query($sql, $mysql);
// return $link->query($sql);
   return  mysqli_query($mysqli, $sql); // $result = $mysqli->query($sql);
}



	$form_data = array(
     "levelID" => '3',
    "description" => "test221",
    "title" => "test221"
);
	
dbRowUpdate('level', $form_data, "WHERE levelID= '3'");






?>
<!-- //https://phpenthusiast.com/object-oriented-php-tutorials/create-classes-and-objects -->
