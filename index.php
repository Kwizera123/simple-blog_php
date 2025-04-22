<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>
<?php 
    $select = $conn->query("SELECT * FROM posts");
    $select->execute();
    $rows = $select->fetchAll(PDO::FETCH_OBJ);
 ?>


<main class="form-signin w-50 m-auto  mt-3">
  <div class="col-sm-12 mb-3 mb-sm-0 mt-2">
    <?php  foreach($rows as $row) : ?>
    <div class="card">
    <div class="card-header"><?php echo $row->username; ?>'post</div>
      <div class="card-body">
        <h5 class="card-title text text-primary"><?php echo $row->title; ?></h5>
        <p class="card-text"><?php echo substr($row->body, 0, 200) .'..'; ?></p>
        <p class="card-text"><small class="text-body-secondary"><?php echo $row->created_at; ?></small></p>
        <a href="show.php?id=<?php echo $row->id; ?>" class="btn btn-secondary">Read more</a>
      </div>
    </div>
    <br>
    <?php endforeach; ?> 
  </div>
</div>



<?php require "includes/footer.php"; ?>
