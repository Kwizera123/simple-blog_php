
<?php require "config.php"; ?>
<?php require "includes/header.php"; ?>
<?php 
  if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $onePost = $conn->query("SELECT * FROM posts WHERE id='$id'");
    $onePost->execute();

    $posts = $onePost->fetch(PDO::FETCH_OBJ);
  }
?>

  <div class="card mt-3">
    <div class="card-header">Writen by <?php echo $posts->username; ?></div>
      <div class="card-body">
        <h5 class="card-title text text-primary"><?php echo $posts->title; ?></h5>
        <p class="card-text"><?php echo $posts->body; ?></p>
        <p class="card-text"><small class="text-body-secondary"><?php echo $posts->created_at; ?></small></p>
        
      </div>
    </div>


    
    <div class="card-header">Comment</div>
  <form method="POST" id="comment_data">
    <!-- <img class="mb-4 text-center" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
    <!-- <h1 class="h3 mt-5 fw-normal text-center"><i class="fas fa-creative-commons-pd-alt ">Create Post</i> </h1> -->

    <div class="form-floating">
      <input name="username" type="hidden" value="<?php echo $_SESSION['username']; ?>" class="form-control" id="username">
    </div>

    <div class="form-floating">
      <input name="post_id" type="hidden" value="<?php echo $posts->id; ?>" class="form-control" id="post_id">
    </div>

    <div class="form-floating mt-3">
      <textarea rows="3" name="comment" class="form-control" id="comment" placeholder="Type your comment"></textarea>
      <label for="floatingPassword">Type comment</label>
    </div>

    <button name="submit" id="submit" class="w-15 btn btn-lg  btn-primary mt-3" type="submit">Create Comment</button>

  </form>


  <?php require "includes/footer.php"; ?>

 <script>
  $(document).ready(function() {

       $(document).on('submit', function(e) {
        e.preventDefault();
          //alert('Form submitted');
          var formdata = $("#comment_data").serialize()+'&submit=submit';

          $.ajax({
            type: 'post',
            url: 'insert-comments.php',
            data: formdata,

            success:function() {
              //alert('success');
              $("#comment").text('');
            }
          })
       })
  });
 </script>