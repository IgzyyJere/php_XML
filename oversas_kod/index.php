<?php

$arr = array("Array ( [status] => 0 [data] => Array ( [Events] => Array ( [0] => 
Array ( [StatusID] => 64 [Location] => [TimeOfScan] => 2022-09-05T17:17:31 ) [1] => 
Array ( [StatusID] => 10 [Location] => [TimeOfScan] => 2022-09-05T17:17:46 ) [2] => 
Array ( [StatusID] => 30 [Location] => [TimeOfScan] => 2022-09-06T07:52:41 ) [3] => 
Array ( [StatusID] => 24 [Location] => [TimeOfScan] => 2022-09-06T08:04:13 ) [4] => 
Array ( [StatusID] => 21 [Location] => [TimeOfScan] => 2022-09-06T08:07:03 ) 
[5] => Array ( [StatusID] => 130 [Location] => Array ( [Lat] => 45.804536 [Long] => 16.216325 ) [TimeOfScan] => 2022-09-06T18:21:28 )");


print_r(array_keys($arr));

function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}



//$value = "Events";
//$search = "130";
//$key = array_search($search, array_column($arr, "Events"));
//print_r($arr[$key]);


//function find_array($search, $value, $array){
//    $key = array_search($search, array_column($array, $value));
//    return $array[$key];
//}

//$to = find_array("StatusID", "130", $arr);

   // print_r($to);

   //https://morioh.com/p/99b33b04e0a8

//   function searchByKey($keyVal, $arr) {
//    foreach ($arr as $key => $val) {
//        if ($keyVal == $key) {
//          $resultSet['Long'] = $val['Long'];
//         // $resultSet['key'] = $key;
//          $resultSet['StatusID'] = $val['StatusID'];
//          return $resultSet;
//        }
//    }
//    return "Not found"; //null;
// }
//
//$searchByKey = searchByKey("130", $arr);
//print_r($searchByKey);
//die;




function arr_to_obj_recursive_data($arr) {
    if (is_array($arr)){
        $generat_array = array();
        foreach($arr as $k => $v) {
            if (is_integer($k)) {
                $generat_array['index'][$k] = arr_to_obj_recursive_data($v);
            }
            else {
                $generat_array[$k] = arr_to_obj_recursive_data($v);
            }
        }

        return (object) $generat_array;
    }

    // else maintain the type of $arr
	//PHP: Recursively convert an object to an array
    return $arr; 
}


//https://stackoverflow.com/questions/8102221/php-multidimensional-array-searching-find-key-by-specific-value?%3E





function search2($myarray, $mykey) {
    foreach ($myarray as $key => $value) {
        if (is_array($value)) {
            search($value, $mykey);
        }
        else {
            if ($key == $mykey) {
                echo 'found ';
                if ($value != null) {
                    echo 'and value of '.$mykey.' is '.$value;
                }
                else {
                    echo 'and value is null';
                }
            }
        }
    }
};

//search2($arr, "Long2");
//https://www.php.net/manual/en/function.array-search.php


https://www.geeksforgeeks.org/how-to-search-by-keyvalue-in-a-multidimensional-array-in-php/


function search_2($array, $key, $value) {
    $results = array();
      
    // if it is array
    if (is_array($array)) {
          
        // if array has required key and value
        // matched store result 
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }
          
        // Iterate for each element in array
        foreach ($array as $subarray) {
              
            // recur through each element and append result 
            $results = array_merge($results, 
                    search($subarray, $key, $value));
        }
    }
  
    return $results;
}



$res = search_2($arr, 'StatusID', '');
foreach ($res as $var) {
    echo $var["Lat"]." - ".$var[1] . "<br>";
}
//https://www.geeksforgeeks.org/how-to-search-by-keyvalue-in-a-multidimensional-array-in-php/

?>

