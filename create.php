<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>

<?php

if(!isset($_SESSION['username'])) {
  header("location: index.php");
}

if(isset($_POST['submit'])) {

  if($_POST['title'] == '' OR $_POST['body'] == '') {
    echo "some inputs are empty";
    
  } else {


    $title = $_POST['title'];
    $body = $_POST['body'];
    $username=$_SESSION['username'];

    $insert = $conn->prepare("INSERT INTO posts (title, body, username) 
     VALUES (:title, :body, :username)");

     $insert->execute([
      ':title' => $title,
      ':body' => $body,
      ':username' => $username,
     ]);
     header("location: index.php");
  }
}

 ?>

<main class="form-signin w-50 m-auto">
  <form method="POST" action="create.php">
    <!-- <img class="mb-4 text-center" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
    <h1 class="h3 mt-5 fw-normal text-center"><i class="fas fa-creative-commons-pd-alt ">Create Post</i> </h1>

    <div class="form-floating">
      <input name="title" type="title" class="form-control" id="floatingInput" placeholder="Title">
      <label for="floatingInput">Type Title</label>
    </div>

    <div class="form-floating mt-3">
      <textarea rows="3" name="body" class="form-control" id="body" placeholder="Type text"></textarea>
      <label for="floatingPassword">Type Text</label>
    </div>

    <button name="submit" class="w-15 btn btn-lg  btn-primary mt-3" type="submit">Create Post</button>
    <h6 class="mt-3 txt text-danger"><a href="index.php">Cancel</a></h6>

  </form>
</main>

<?php require "includes/footer.php"; ?>