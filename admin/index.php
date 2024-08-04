<?php
session_start();
require '../config/config.php';
if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}
?>



<?php include 'header.html';?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <?php
              if(!empty($_GET['pageno'])){
                $pageno=  $_GET['pageno'];

              }else{  
                $pageno =1 ;
                
              }
              $numOfRecs = 2;
              $offset =($pageno-1) * $numOfRecs;

              if(empty($_POST['search'])){
                $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                $stmt->execute();
                $rawResult = $stmt->fetchAll();
                $total_pages = ceil(count($rawResult) / $numOfRecs);

                $stmt= $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset, $numOfRecs");
                $stmt->execute();
                $result = $stmt->fetchAll();

              }else{
                $searchKey = $_POST['search'];
                $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
                $stmt->execute();
                $rawResult = $stmt->fetchAll();
                $total_pages = ceil(count($rawResult) / $numOfRecs);

                $stmt= $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset, $numOfRecs");
                $stmt->execute();
                $result = $stmt->fetchAll();
              }

               ?>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="">
                  <a href="add.php" class="btn btn-primary">New Blog Post</a>
                </div>
                <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($result){
                      $i = 1;
                      foreach($result as $value){?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $value['title'];?></td>
                          <td><?php echo $value['content'];?></td>
                            <td>
                              <div class="btn-group">
                                <div class="container">
                                  <a href="edit.php?id=<?php echo $value['id'];?>" class="btn btn-secondary">Edit</a>
                                </div>
                                <div class="container">
                                  <a href="delete.php?id=<?php echo $value['id'];?>" class="btn btn-warning">Delete</a>
                                </div>
                              </div>
                            </td>
                        </tr> 
                        <?php
                          $i++;
                      }
                    }

                     ?>
                  </tbody>
                </table> <br>
                <nav aria-label="Page navigation example" style="float:right">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1) {echo '#';}else{ echo "?pageno=".($pageno-1);}?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages) {echo '#';}else{ echo "?pageno=".($pageno+1);}?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages?>">Last</a></li>
                  </ul>
                </nav>
              </div>
              <!-- /.card-body -->
                  <!-- Pagination -->
                 
                    
            </div>
            <!-- /.card -->


          </div>



          </div>
          <!-- /.col-md-6 -->



        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include'footer.html'; ?>
