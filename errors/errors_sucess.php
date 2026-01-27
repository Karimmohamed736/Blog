<?php

if (isset($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {?>

        <div class="alert alert-danger"> <?php echo $error ?> </div>
    <?php  }

    unset($_SESSION['errors']);
}elseif ( isset($_SESSION['success'])) {?>

    <div class="alert alert-success"> <?php echo $_SESSION['success'] ?></div>  
<?php 
    unset($_SESSION['success']);
}