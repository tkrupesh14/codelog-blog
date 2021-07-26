<?php

?>
    <!-- navbar -->
  <nav class="navbar sticky-top navbar-expand-lg ">
  <div class="container">
    <a class="navbar-brand" href="./index.php">Codelog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">

      <?php
        $menusel = "SELECT * FROM menu";
        $menuque = mysqli_query($conn, $menusel);

        while($menu  = mysqli_fetch_assoc($menuque)){

          $no = getSubMenuNo($conn, $menu['id']);
          if(!$no){
                  
            ?>
 <li class="nav-item">
          <a class="nav-link" aria-current="page" href="./<?= $menu ['action'] ?>"><?=$menu ['name']; ?></a>
        </li>
            <?php
          }else{
            ?>
<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?= $menu ['name']; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
           
          <?php
            // $menu_id = $_GET ['menu_id'];
            $submenu = "SELECT * FROM submenu ";
            $submenuque = mysqli_query($conn, $submenu);
            while($sm = mysqli_fetch_assoc($submenuque)){
              
              ?>
<li><a class="dropdown-item" href="<?= $sm ['action'] ?>"><?= $sm ['name'] ?></a></li>


<?php
            }
          ?>
            
            
          </ul>
        </li>

            <?php
          }
          
      ?>
          
        <?php
        }
        ?>
     
        
      </ul>
      <a href="" class="search-icon" data-bs-toggle="modal" data-bs-target="#exampleModal" ><i class="fa fa-search" aria-hidden="true"></i></a>
      </form>
    </div>
  </div>
</nav>
<!-- search modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Search Codelogs</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-backdrop="keyboard"></button>
        <span class="mdl-close disabled">Esc</span>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label"></label>
            <input type="text" class="form-control" name="search" id="recipient-name">
          </div>
          <button type="submit" class="btn btn-primary search-m-btn">Search</button>
          
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<!-- navbar over -->
