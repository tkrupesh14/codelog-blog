<?php
if(! file_exists('db.php')){
  header("location: install.php");
}

 require './db.php';
 include './function.php';
 if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}

$post_per_page = 5;
$result = ($page - 1)*$post_per_page;
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Codelog - The Code Blog</title>
    <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>">
  </head>
  <body>
  <?php  include './nav.php'; ?>

<!-- posts section -->
<div>
    <div class="container m-auto mt-3 row">
        <div class="col-12">
            <?php
                if(isset($_GET['search'])){
                    $keyword = $_GET['search'];
                    $postSelect = "SELECT * FROM posts WHERE title LIKE '%$keyword%'ORDER BY id DESC LIMIT $result, $post_per_page";
                }
               
                
                else{
                    $postSelect = "SELECT * FROM posts ORDER BY id DESC LIMIT $result, $post_per_page";

                }
                
                $runPQ = mysqli_query($conn, $postSelect);

                    while($post = mysqli_fetch_assoc($runPQ)){

                    ?>
                    <a href="post.php?id=<?= $post ['id']?>" style="text-decoration: none; color:#000;">
          <div class="" style="max-width: 1000px; height:200px">
            <div class="row g-0">
                

            
              <div class="col-md-5" style="background-image: url('./admin/Post Images/<?= getPostThumb($conn, $post ['id'])?>');background-size: cover; height: 200px">
                <!-- <img src="https://images.moneycontrol.com/static-mcnews/2020/04/stock-in-the-news-770x433.jpg" alt="..."> -->
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <h5 class="card-title post-title"><?= $post ['title'] ?></h5>
                  
          
                  <p class="card-text"><small class="text-muted">Posted On :  <?= date('F jS, Y',strtotime($post['created_at'])) ?></small></p>
                </div>
              </div>
            </div>
          </div>
          
          </a>
                    <?php
                    }
            ?>
            
        </div>
 
    <!-- posts section over -->

    <?php include './sidebar.php'; ?>

    <!-- page navigation section -->

    <?php
    if(isset($_GET['search'])){
        $keyword = $_GET['search'];
        $pageSelect = "SELECT * FROM posts WHERE title LIKE '%$keyword%'";

    }else{
        $pageSelect = "SELECT * FROM posts";

    }
    $runpageQ = mysqli_query($conn , $pageSelect);
    $totalPosts = mysqli_num_rows($runpageQ);
    $totalPages = ceil($totalPosts/$post_per_page); 
      

    ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">

        <?php
                if($page >1){
                    $switch = "";
                }else{
                    $switch = "disabled";
                }

                if($page < $totalPages){
                    $nswitch = "";
                }else{
                    $nswitch = "disabled";
                }
        ?>
          <li class="page-item <?=$switch ?>">
            <a class="page-link"  href="?<?php if(isset($_GET['search'])){echo "search=$keyword&";} ?>page=<?=$page-1 ?>" tabindex="-1" aria-disabled="true">Previous</a>
          </li>

          <?php
                for($npage = 1; $npage<=$totalPages; $npage++){
                    ?>

<li class="page-item ">
    <a class="page-link" href="?page=<?= $npage?>"><?= $npage?></a></li>
                    <?php
                }
          ?>

<?php
              
        ?>
  
          <li class="page-item <?= $nswitch?>">
            <a class="page-link" href="?<?php if(isset($_GET['search'])){echo "search=$keyword&";} ?>page=<?=$page+1?>">Next</a>
          </li>
        </ul>
      </nav>
      <!-- page navigation section over -->
<?php  include './footer.php'; ?>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>