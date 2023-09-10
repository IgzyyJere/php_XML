<?php




$arr = array("Array ( [0] => Array ( [status] => 0 [data] => Array ( [Events] => Array ( [0] => Array ( [StatusID] => 64 [Location] => [TimeOfScan] => 2022-09-05T17:17:31 ) [1] => Array ( [StatusID] => 10 [Location] => [TimeOfScan] => 2022-09-05T17:17:46 ) [2] => Array ( [StatusID] => 30 [Location] => [TimeOfScan] => 2022-09-06T07:52:41 ) [3] => Array ( [StatusID] => 24 [Location] => [TimeOfScan] => 2022-09-06T08:04:13 ) [4] => Array ( [StatusID] => 21 [Location] => [TimeOfScan] => 2022-09-06T08:07:03 ) [5] => Array ( [StatusID] => 130 [Location] => Array ( [Lat] => 45.804536 [Long] => 16.216325 ) [TimeOfScan] => 2022-09-06T18:21:28 ) [6] => Array ( [StatusID] => 24 [Location] => [TimeOfScan] => 2022-09-06T18:29:17 ) [7] => Array ( [StatusID] => 21 [Location] => [TimeOfScan] => 2022-09-06T18:29:47 ) [8] => Array ( [StatusID] => 38 [Location] => [TimeOfScan] => 2022-09-06T18:44:20 ) [9] => Array ( [StatusID] => 1002 [Location] => [TimeOfScan] => 2022-09-06T18:45:06 ) [10] => Array ( [StatusID] => 30 [Location] => [TimeOfScan] => 2022-09-07T07:59:33 ) [11] => Array ( [StatusID] => 21 [Location] => [TimeOfScan] => 2022-09-07T08:14:30 ) [12] => Array ( [StatusID] => 22 [Location] => [TimeOfScan] => 2022-09-07T08:14:34 ) [13] => Array ( [StatusID] => 58 [Location] => [TimeOfScan] => 2022-09-07T08:14:34 ) [14] => Array ( [StatusID] => 1003 [Location] => [TimeOfScan] => 2022-09-07T08:33:10 ) [15] => Array ( [StatusID] => 95 [Location] => Array ( [Lat] => 45.806062 [Long] => 16.220078 ) [TimeOfScan] => 2022-09-07T17:33:10 ) [16] => Array ( [StatusID] => 38 [Location] => [TimeOfScan] => 2022-09-08T10:45:09 ) [17] => Array ( [StatusID] => 1002 [Location] => [TimeOfScan] => 2022-09-08T10:45:35 ) [18] => Array ( [StatusID] => 50 [Location] => [TimeOfScan] => 2022-09-08T13:47:29 ) [19] => Array ( [StatusID] => 60 [Location] => [TimeOfScan] => 2022-09-08T13:47:51 ) [20] => Array ( [StatusID] => 65 [Location] => [TimeOfScan] => 2022-09-08T15:45:59 ) [21] => Array ( [StatusID] => 60 [Location] => [TimeOfScan] => 2022-09-09T10:44:54 ) [22] => Array ( [StatusID] => 220 [Location] => [TimeOfScan] => 2022-09-09T15:10:10 ) [23] => Array ( [StatusID] => 220 [Location] => [TimeOfScan] => 2022-09-12T17:32:42 ) [24] => Array ( [StatusID] => 220 [Location] => Array ( [Lat] => 45.880478 [Long] => 16.139238 ");
$arr1 = array("Array ( [5] => Array ( [StatusID] => 130 [Location] => Array ( [Lat] => 45.804536 [Long] => 16.216325 ) [TimeOfScan] => 2022-09-06T18:21:28 ) )");

    echo "<br/>";
    echo "<br/>";
    echo "<hr/>";
    print_r($arr1);

echo "<pre>";
//print_r($new_array);
$clean = implode( ',', $arr1);
$filter_Lat = 0;
$filter_Lonf = 0;
$filter_index = 0;

//if(strpos($clean, '[Lat]') !== false){
//    $filter_Lat = strpos($clean, '[Lat]');  //substr(strpos($clean, '[Lat] => '),6, 5);
//} 

$strposition_index = strpos($clean, "130");

if($strposition_index === false){
    echo "nisam našao!";
} else{
    echo "pozicija : ".$strposition_index;
    $filter_index = $strposition_index;
    echo $filter_index;

        if($filter_index > 0){

            $filter_index = $filter_index + 35; //35 mjesta
            $filter_Lat = substr($clean, $filter_index, 10);

            $filter_index = $filter_index + 20; //35 mjesta
            $filter_Lonf = substr($clean, $filter_index, 10);

        }

}









echo "<br/>";
echo "Reza index: " .$filter_index;
echo "<br/>";
echo "Reza Lat: " .$filter_Lat;
echo "<br/>";
echo "Reza Long: " .$filter_Lonf;



///problem je u 
///https://stackoverflow.com/questions/2941169/what-does-the-php-error-message-notice-use-of-undefined-constant-mean
///dakle key nije u enclosed in quotes

?>









