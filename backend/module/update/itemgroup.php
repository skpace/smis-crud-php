<?php
    ob_start();
    include('../../include/config.php');
    include('../../include/class.php');
    include('view.php');

    session_start(); 
    $username = $_SESSION['username'];
    $query1 = $user->users();   // for postby_id
    $query2 = $user->users();   //for verified_id
    // $result1 = mysqli_fetch_assoc($query1);
    // $result2 = mysqli_fetch_assoc($query2);

    $id = $_GET['id'];    // current department id
    $query = $user->viewItemgroup($id);
    $result = mysqli_fetch_assoc($query);
    $title = $result['title'];  // current department name
    // echo '<br><br>This is me old '.$id.' and '.$title;

    if(isset($_POST['update'])){
      $new_id = $_POST['id'];
      $new_title = $_POST['title'];
      $remarks = $_POST['remarks'];
      $status = $_POST['status'];
      $postby_id = $_POST['postby_id'];
      $verifiedby_id = $_POST['verifiedby_id'];

      echo '<br><br>This is me new one '.$new_id.' and '.$new_title.' and '.$remarks.' and '.$status.' and '.$postby_id.' and '.$verifiedby_id;
      // die();

      $query0 = $user->updateItemgroup($id, $title, $new_id, $new_title, $remarks, $postby_id, $verifiedby_id, $status);
        
              if($query0 == 0){
                // echo 'suscesjflk';
                header('location: ../itemgroup.php');
              }
    }
?>


    <style type="text/css">
      section{
        border: 1px solid #ccc;
        padding: 20px 50px;
      }
      .submit{
        margin-top: 25px;
      }
      .left{
        width: 45%;
        margin-right: 50px;
        margin-left: 0px;
      }      
      .right{
        width: 45%;
      }
      .bg{
        background-color: #eee;
        border-radius: 5px;
      }
    </style>
    <div class="container">
      <section class="main">
        <div class="center">
            <ol class="breadcrumb">
                <li>
                    <i class="glyphicon glyphicon-home"></i><a href="<?php echo $_SESSION['url_visit_2']; ?>"> Dashboard</a>
                </li>
                <li>
                    <i class="glyphicon glyphicon-leaf"></i> <a href="../itemgroup.php">Itemgroup</a>
                </li>
                <li class="active">
                    <i class="fa fa-cubes"></i> Update
                </li>
            </ol><br>
            <?php 
              if($query0 == 1){?>
                  <div class="alert alert-warning fade in" style="width: 100%; margin: -20px 0px 20px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Itemgroup Title And ID Already Exists !</strong> Choose Another Title and ID.
                  </div><?php 
              }
              if($query0 == 2){?>
                  <div class="alert alert-warning fade in" style="width: 100%; margin: -20px 0px 20px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Itemgroup ID Already Exists !</strong> Choose Another ID.
                  </div><?php                 
              }
              if($query0 == 3){?>
                  <div class="alert alert-warning fade in" style="width: 100%; margin: -20px 0px 20px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Itemgroup Title Already Exists !</strong> Choose Another Title.
                  </div><?php                 
              }
            ?>
            <section>
              <form class="form-horizontal" action="" method="post" >
                <div class="row">
                    <h4>Instutional remarkss</h4>
                    <!-- Selection Dropdown-->
                    <div class="col-sm-6 left">
                      <div class="form-group">
                        <label for="exampleInputName2"  class="control-label">ID</label>
                        <div class="">
                          <input type="text" class="form-control"  name="id" value="<?php echo $result['id']?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName2"  class="control-label">Itemgroup Title</label>
                        <div class="">
                          <input type="text" class="form-control"  name="title" value="<?php echo $result['title']?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName2"  class="control-label">Remarks</label>
                        <div class="">
                          <textarea rows="4" cols="46" name='remarks' placeholder="Small Description About The Itemgroup..."><?php echo $result['remarks']?></textarea>
                          <!-- <input type="text" class="form-control"  name="remarks" value="<?php echo $result['remarkss']?>"> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 right">
                      <div class="form-group">
                        <label for="exampleInputName2"  class="control-label">Status</label>
                        <div class="">
                          <select class='form-control' id='exampleInputName2' name='status'>
                            <option disabled><i>Select Status</i></option>
                            <?php 
                                if($result['status'] == 'OFF'){
                                  echo "<option value = 'ON'>ON</option>";
                                  echo "<option value='OFF' selected>".$result['status']."</option>";
                                }
                                else if($result['status'] == 'ON'){
                                    echo "<option value='ON' selected>".$result['status']."</option>";
                                    echo "<option value = 'OFF'>OFF</option>";
                                }
                                else{
                                  echo "<option value='' disabled selected>Select Status</option>";
                                    echo "<option value='ON'>ON</option>";
                                    echo "<option value = 'OFF'>OFF</option>";
                                }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputName2"  class="control-label">Post By</label>
                          <div class="">
                              <?php
                                  echo "<select  class='form-control' id='exampleInputName2' name='postby_id'>";
                                  // echo "<option disabled selected>Select User</option>";
                                  echo "<option value='".$result['postby_id']."' selected>".$result['postedby']."</option>";
                                  while($result1 = mysqli_fetch_assoc($query1)){
                                    if($result1['fullname'] != $result['postedby'])
                                      echo "<option value='".$result1['id']."'>".$result1['fullname']."</option>";
                                  }
                                  echo "</select>";
                              ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputName"  class="control-label">Verified By</label>
                          <div class="">
                              <?php
                                  echo "<select  class='form-control' id='exampleInputName' name='verifiedby_id'>";
                                  // echo "<option disabled selected>Select User</option>";
                                  echo "<option value='".$result['verifiedby_id']."'>".$result['fullname']."</option>";
                                  while($result2 = mysqli_fetch_assoc($query2)){
                                    if($result2['fullname'] != $result['fullname'])
                                      echo "<option value='".$result2['id']."'>".$result2['fullname']."</option>";
                                  }
                                  echo "</select>";
                              ?>
                          </div>
                      </div>
                    </div>
                </div>

                <div class="row submit">
                  <button type="submit" name="update" type="button" class="btn btn-primary">Update</button>
                </div>
              </form>
            </section>
        </div>
    </section>