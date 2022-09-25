

<table border="1">
<tr>
    <th>NO.</th>
    <th>NAME</th>
    <th>Major</th>
</tr>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cipele2";
//mysql and db connection

$con = new mysqli($servername, $username, $password, $dbname);

$sql="SELECT * FROM loxah_posts";
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result) > 0)
{
    $no = 1;
            while($data = mysqli_fetch_assoc($result))
            {echo '
                <tr>
                <td>'.$no.'</td>
                <td>'.$data['post_title'].'</td>
                <td>'.$data['post_status'].'</td>
                </tr>
                ';
                $no++;
        }
}







?>



