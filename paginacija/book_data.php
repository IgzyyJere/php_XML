<?php
	require_once 'connect.php';
 
	$record_per_page = 5;
 
	$page = "";
	$result = "";
 
	if(ISSET($_POST['page'])){
		$page = $_POST['page'];
	}else{
		$page =  1;
	}
 
	$start = ($page - 1) * $record_per_page;
 
	$q_book = $conn->query ("SELECT * FROM `kgrdr_posts` LIMIT $start, $record_per_page") or die(mysqli_error());
 
	$result .="
		<table class = 'table table-bordered'>
			<thead>
				<tr>
					<th colspan = '2'><center>List of Books</center></th>
				</tr>
				<tr>
					<th>id #</th>
					<th>Title</th>
				</tr>
			</thead>
			<tbody>
	";
 
	while($f_book = $q_book->fetch_array()){
		$result .= "
			<tr>
				<td style = 'width:50%;'>".$f_book['ID']."</td>
				<td style = 'width:50%;'>".$f_book['post_title']."</td>
			</tr>
		";
	}
	$result .= "
		</tbody></table>
	";
 
	$q_page = $conn->query("SELECT * FROM `kgrdr_posts`") or die(mysqli_error());
	$v_page = $q_page->num_rows;
	$total_pages = ceil($v_page/$record_per_page);
	for($i = 1; $i <= $total_pages; $i++){
		$result .="<span class = 'pagination' style = 'cursor:pointer; margin:1px; padding:8px; border:1px solid #ccc;' id = '".$i."'>".$i."</span>";
	}
	$result .="
		<span class = 'pull-right'>Page of ".$page." out of ".$total_pages."</span>
	";
	echo $result;
?>


