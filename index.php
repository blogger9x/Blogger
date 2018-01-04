<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link   href="css/bootstrap.min.css" rel="stylesheet">

  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <style>

  .pagination {
    display: inline-block;
}

.pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
}

.pagination a.active {
    background-color: #4CAF50;
    color: white;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>
</head>


<body>
  <?php 

  // BƯỚC 1: KẾT NỐI CSDL
  include 'connect.php';

 // BƯỚC 2: TÌM TỔNG SỐ RECORDS
  $results = mysqli_query($db,"SELECT * FROM new_words");
  $total_records = mysqli_num_rows($results);
  // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
  $limit = 10;
  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
  // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
  // tổng số trang
  $total_page = ceil($total_records/$limit);
  if($total_page < 1){
    $total_page = 1;
  }
  // Tìm Start
  $start = ($current_page - 1) * $limit;

  $results = mysqli_query($db, "SELECT * FROM new_words  ORDER BY sentence ASC LIMIT $start, $limit");

  $sentence = "";
  $spelling = "";
  $translate = "";
  $search = "";
  $edit_state = false;
	if(isset($_POST['create'])){
		$sentence = $_POST['sentence'];
		$spelling = $_POST['spelling'];
		$translate = $_POST['translate'];
		if(!empty($sentence) && !empty($spelling) && !empty($translate)){
			$check_exist_sentence = mysqli_query($db, "SELECT * FROM new_words WHERE sentence = '$sentence'");
			if(mysqli_num_rows($check_exist_sentence)){
				 echo "Sentence is existed";
			}else{
				$query = "INSERT INTO new_words(sentence, spelling, translate) VALUES('$sentence','$spelling','$translate') ";
				if (mysqli_query($db, $query)) {
					$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
					$total_page = ceil($total_records/$limit);
					if($total_page < 1){
					  $total_page = 1;
					}
					// Tìm Start
					$start = ($current_page - 1) * $limit;
					$results = mysqli_query($db, "SELECT * FROM new_words ORDER BY sentence ASC LIMIT $start, $limit");
				}
			}
		}else {
			echo "Error: " . $query . "<br>" . mysqli_error($db);
		}
    };	
 

	if(isset($_GET["edit"])){
		$id = $_GET["edit"];
		$edit_state = true;
		$rec = mysqli_query($db,"SELECT * FROM new_words WHERE id = $id");
		$record = mysqli_fetch_array($rec);
		$sentence = $record["sentence"];
		$spelling = $record["spelling"];
		$translate = $record["translate"];
	}

  if(isset($_POST["searchBtn"])){
    $edit_state = false;
    $search = $_POST["search"];
    $results = mysqli_query($db, "SELECT * FROM new_words WHERE sentence LIKE '%$search%' ORDER BY sentence ASC");
    $total_records = mysqli_num_rows($results);
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $total_page = ceil($total_records/$limit);
    if($total_page < 1){
      $total_page = 1;
    }
    // Tìm Start
    $start = ($current_page - 1) * $limit;
    $results = mysqli_query($db, "SELECT * FROM new_words WHERE sentence LIKE '%$search%' ORDER BY sentence ASC LIMIT $start, $limit");
    $total_records = mysqli_num_rows($results);
  }

  if(isset($_GET["delete"])){
    $id = $_GET["delete"];
    $edit_state = false;
    $rec = mysqli_query($db,"DELETE FROM new_words WHERE id = $id");
    if ($rec) {
      $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
      $total_page = ceil($total_records/$limit);
      if($total_page < 1){
        $total_page = 1;
      }
      // Tìm Start
      $start = ($current_page - 1) * $limit;
      $results = mysqli_query($db, "SELECT * FROM new_words ORDER BY sentence ASC LIMIT $start, $limit");
    } else {
      echo "Error: " . $rec . "<br>" . mysqli_error($db);
    }
  }

	if(isset($_POST["update"])){
		$id = $_GET["edit"];
		$sentence = $_POST['sentence'];
		$spelling = $_POST['spelling'];
		$translate = $_POST['translate'];
		$check_exist_sentence = mysqli_query($db, "SELECT * FROM new_words WHERE sentence = '$sentence'");
		if(mysqli_num_rows($check_exist_sentence)){
			 echo "Sentence is existed";
		}else{
			$rec = mysqli_query($db,"UPDATE new_words SET sentence = '$sentence',spelling = '$spelling',translate = '$translate' WHERE id = $id");
			if ($rec) {
			  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
			  $total_page = ceil($total_records/$limit);
			  if($total_page < 1){
				$total_page = 1;
			  }
			  // Tìm Start
			  $start = ($current_page - 1) * $limit;
			  $results = mysqli_query($db, "SELECT * FROM new_words ORDER BY sentence ASC LIMIT $start, $limit");
			} else {
			  echo "Error: " . $rec . "<br>" . mysqli_error($db);
			}
		}
		
	}
  ?>
  <div class="container">
    <div class="row">
      <h3></h3>
    </div>
    <div class="row">
      <form  method="post" action = "">
        <div class="col-md-12">
          <div class="col-md-3">
           <label>Sentence</label>
           <input type="text" name="sentence" value="<?php echo $sentence;?>">
         </div>
         <div class="col-md-3">
           <label>Spelling</label>
           <input type="text" name="spelling" value="<?php echo $spelling;?>">
         </div>
         <div class="col-md-3">
           <label>Translate</label>
           <input type="text" name="translate" value="<?php echo $translate;?>">
         </div>
         <div class="col-md-2">
          <?php if($edit_state == false): ?>
            <p><button type ="submit" class="btn btn-success" name="create" href="index.php?page=<?php echo $current_page ?>">Create</button></p>
          <?php else: ?>
            <p>
              <button type ="submit" class="btn btn-primary" name="update" href="index.php?page=<?php echo $current_page ?>">Update</button>
              <a class="btn btn-warning" href="index.php?page=<?php echo $current_page ?>" title="">Cancel</a>
            </p>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-12">
        <div class="col-md-3">
         <label>Search</label>
         <input type="text" name="search" value="<?php echo $search;?>">
       </div>
       <p>
        <button type ="submit" class="btn btn-primary" name="searchBtn" >Search</button> 
      </p>
    </div>
  </form>

  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Sentence</th>
        <th>Spelling</th>
        <th>Translate</th>
        <th>Sound</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_array($results)){ ?>
      <tr>
        <td><?php echo $row['sentence']?></td>
        <td><?php echo $row['spelling']?></td>
        <td><?php echo $row['translate']?></td>
        <td></td>
        <td>
          <a class="btn btn-primary" href="index.php?edit=<?php echo $row['id']?>&page=<?php echo $current_page ?>" title="">Edit</a>
          <a class="btn btn-danger" href="index.php?delete=<?php echo $row['id']?>&page=<?php echo $current_page ?>" title="">Delete</a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="pagination">
    <a href="#">&laquo;</a>
    <?php for($i=1; $i<=$total_page;$i++){ ?>
      <?php 
			$p = isset($_GET['page'])?$_GET['page']:1;
			if($i == $p) :?>
         <a href="#" class="active"><?php echo $i ?></a>
      <?php else: ?>
         <a href="index.php?page=<?php echo $i ?>"><?php echo $i ?></a>
      <?php endif; ?>
    <?php } ?>
    <a href="#">&raquo;</a>
  </div>


</div>
</div> <!-- /container -->
</body>
</html>