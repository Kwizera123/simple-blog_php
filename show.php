<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>

<?php 

if(!isset($_SESSION['username'])) {
  header("location: login.php");
}


  if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $onePost = $conn->query("SELECT * FROM posts WHERE id='$id'");
    $onePost->execute();

    $posts = $onePost->fetch(PDO::FETCH_OBJ);
  }

      $comments = $conn->query("SELECT * FROM comments WHERE post_id='$id'");
      $comments->execute();

      $comment = $comments->fetchAll(PDO::FETCH_OBJ);

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
    <div id="msg" class="nothing col-3"></div>
    <div id="delete-msg" class="nothing"></div>

  </form>

  <!-- Comments -->
  <?php foreach($comment as $singleComment) : ?>
      <div class="card mt-3">
          <div class="card-header">Writen by <?php echo $singleComment->username; ?></div>
            <div class="card-body">
              <h5 class="card-title text text-success"><?php echo $singleComment->username; ?></h5>
              <p class="card-text"><?php echo $singleComment->comment; ?></p>
              <?php if(isset($_SESSION['username']) AND $_SESSION['username'] == $singleComment->username) : ?>
               <button id="delete-btn" value="<?php echo $singleComment->id; ?>" class="btn btn-danger mt-3">Delete Comment</button>
               <?php endif; ?>
               <p class="card-text"><small class="text-body-secondary"><?php echo $singleComment->created_at; ?></small></p>
            </div>
            
        </div>
        <?php endforeach; ?>

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
              $("#comment").val(null);
              $("#username").val(null);
              $("#post_id").val(null);

              $("#msg").html("Your Comment Added successfully").toggleClass("alert alert-success bg-success text-white mt-3");
              fetch();
            }
          });
       });

// for Delete comment

  $("#delete-btn").on('click', function(e) {
        e.preventDefault();
          //alert('Form submitted');
          var id = $(this).val();

          $.ajax({
            type: 'post',
            url: 'delete-comment.php',
            data: {
              delete: 'delete',
              id: id
            },

            success:function() {
             // alert(id);

             $("#delete-msg").html("Your Comment deleted successfully").toggleClass("alert alert-danger bg-danger text-white mt-3");
             fetch();
            }
          });
       });






       function fetch(){
        setInterval(function () {
          $("body").load("show.php?id=<?php echo $_GET['id']; ?>")
        }, 5000);
       }
  });
 </script>