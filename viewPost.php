<?php require_once 'inc/header.php';
require_once "inc/conn.php";
?>

<!-- Page Content -->
<div class="page-heading products-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="text-content">
          <h4>new Post</h4>
          <h2>add new personal post</h2>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  header("location:errors/404.php");
}
$q = "select * from posts where id = $id ";
$res  = mysqli_query($conn, $q);
if (mysqli_num_rows($res) == 1) {
  $post = mysqli_fetch_assoc($res);
} else {
  // header("location:errors/404.php");

}
//join to get the created_by (user name)
$qj = "SELECT posts.*, u.name AS Created_By FROM posts JOIN users u on u.id = posts.user_id WHERE posts.id = $id";
$result = mysqli_query($conn, $qj);
$created_by = mysqli_fetch_assoc($result);
//we can put that query in $q and write ine code but for th details
?>

<div class="best-features about-features">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="section-heading">
          <h2><?php echo $post['title'] ?></h2>
        </div>
      </div>
      <div class="col-md-6">
        <div class="right-image">
          <img src="uploads/<?php echo $post['image'] ?>" alt="#">
        </div>
      </div>
      <div class="col-md-6">
        <div class="left-content">
          <h4><?php echo $post['title'] ?></h4>
          <p><?php echo $post['body'] ?></p>
          <p>Created at: <?php echo $post['created_at'] ?></p>
          <p>Created by: <?php echo $created_by['Created_By'] ?></p>


          <div class="d-flex justify-content-center">
            <?php if (isset($_SESSION['user_id'])) { ?>
              <a href="editPost.php?id=<?php echo $post['id'] ?>" class="btn btn-success mr-3 "> Edit Post</a>

              <form action="handle/deletePost.php?id=<?php echo $post['id'] ?>" method="post">
                <button type="submit" name="submit" class="btn btn-danger mr-3">Delete Post</button>
              </form>
            <?php   } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'inc/footer.php' ?>