<?php
$conn = mysqli_connect("localhost", "root", "", "test");
mysqli_set_charset($conn,"utf8");

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
       while (($column = fgetcsv($file, 200000, ",")) !== FALSE) {
                         $sqlInsert = "INSERT into uudqv_terms (name) values ('" . $column[3]. "')";
                         $result = mysqli_query($conn, $sqlInsert);

                         $lastQ = "SELECT term_id FROM uudqv_terms ORDER BY term_id DESC LIMIT 0 , 1";
                         $last_id = mysqli_query($conn,  $lastQ);//mysqli_insert_id($conn);
                                        $row = mysqli_fetch_assoc($last_id);
										$k = $row["term_id"];
                                        $sqlInsert_f = 'INSERT INTO uudqv_term_taxonomy (term_id,taxonomy,description,parent,count) VALUES ('.$k.',"property-city","",0,0)';
                                        $resultf = mysqli_query($conn,  $sqlInsert_f);
                                        //echo "<p>izvršen sam -----> " . $column[3] . " //ID =  ".$k."</p><br/>";
                                        //echo   $sqlInsert_f;
                                    
                     
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
//kod
// https://phppot.com/php/import-csv-file-into-mysql-using-php/
?>
<!DOCTYPE html>
<html>

<head>
<script src="jquery-3.2.1.min.js"></script>

<style>
body {
	font-family: Arial;
	width: 550px;
}

.outer-scontainer {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 20px;
	border-radius: 2px;
}

.input-row {
	margin-top: 0px;
	margin-bottom: 20px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
	color: #f0f0f0;
	font-size: 0.9em;
	width: 100px;
	border-radius: 2px;
	cursor: pointer;
}

.outer-scontainer table {
	border-collapse: collapse;
	width: 100%;
}

.outer-scontainer th {
	border: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.outer-scontainer td {
	border: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });
});
</script>
</head>

<body>
    <h2>Import CSV file into Mysql using PHP</h2>
    
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    <div class="outer-scontainer">
        <div class="row">

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Import</button>
                    <br />

                </div>

            </form>

        </div>
    </div>
	
	
	
	<div>
	<h1>taxonomy - županije</h1>
	               <?php
            $sqlSelect = "SELECT * FROM uudqv_terms";
            $result = mysqli_query($conn, $sqlSelect);
            
            if (mysqli_num_rows($result) > 0) {
                ?>
            <table id='userTable'>
            <thead>
                <tr>
                     <th>TERM ID</th>
                     <th> Name</th>
      
                </tr>
            </thead>
<?php
                
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    
                <tbody>
                <tr>
                    <td><?php  echo $row['term_id']; ?></td>
                    <td><?php  echo $row['name']; ?></td>
 
                </tr>
                    <?php
                }
                ?>
                </tbody>
        </table>
        <?php } ?>
            <?php
            $rowcount=mysqli_num_rows($result);
            mysqli_free_result($result);
            echo "<p> broj : ".$rowcount."</p>";
            ?>
	
	</div>


    <div>
<h1>Term taxonomy -- Id i županije </h1>
               <?php
            $sqlSelect2 = "SELECT * FROM uudqv_term_taxonomy";
            $result2 = mysqli_query($conn, $sqlSelect2);
            if (mysqli_num_rows($result2) > 0) {
                ?>
            <table id='userTable'>
            <thead>
                <tr>
                  <th>tax ID</th>
                 <th>TERM ID</th>
                 <th> Name</th>
                </tr>
            </thead>      
<?php
                
             while ($row2 = mysqli_fetch_array($result2)) {
            ?>     
                <tbody>
                <tr>
                    <td><?php  echo $row2['term_taxonomy_id']; ?></td>
                    <td><?php  echo $row2['term_id']; ?></td>
                    <td><?php  echo $row2['taxonomy']; ?></td>
 
                </tr>
                    <?php
                }
                ?>
                </tbody>
        </table>
        <?php } ?>

             <?php
             $rowcount2=mysqli_num_rows($result2);
             mysqli_free_result($result2);
             echo "<p> broj : ".$rowcount2."</p>";
              ?>

    </div>
</body>

</html>