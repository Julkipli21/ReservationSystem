

<title>Cottages</title>

<?php

    //resume session here to fetch session values
    session_start();
    /*
        if user is not login then redirect to login page,
        this is to prevent users from accessing pages that requires
        authentication such as the dashboard
    */
    if (!isset($_SESSION['logged_id'])){
        header('location: ../login/login.php');
    }

    if($_SESSION['user_type'] != 'admin'){
        header('location: dashboard.php');
    }
    //if the above code is false then html below will be displayed

    require_once '../inclusion/header.php';
    require_once '../inclusion/sidebar.php';
    require_once '../tools/variables.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://kit.fontawesome.com/0cc7e94eea.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    
    <style>
    /* Style the modal */
    .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .modal-content {
      background-color: #fefefe;
      margin: 8% auto; /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 50%; /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
    #DataTables_Table_0_filter > label{
      display: flex;
      flex-wrap: nowrap;
      align-items: center;
      justify-content: center;
    }

    .dataTables_wrapper .dataTables_length select{
      border: 1px solid #000;
      border-radius: 3px;
      padding: 5px;
      background-color: #ffffff;
      padding: 4px;
      }
    
    .dataTables_wrapper .dataTables_filter input{
      border: 1px solid #000;
      border-radius: 3px;
      padding: 5px;
      background-color: #fffffffc;
      margin-left: 3px;
      }
  
    .element.style{
      display: inline-flex;
      /* align-content: center; */
      justify-content: center;
      align-items: baseline;
      flex-wrap: nowrap;
      flex-direction: row;
    }

    select {
     margin-left: 5px;
     margin-right: 5px;
    }

  </style>





</head>
<body id="villa-page">
    

</body>
</html>
<div class="home-section">
<div class="home-content"><nav>
            <div class="side-bar-button"><i class='bx bx-menu' ></i>
            <span class="text">Cottages</span> </div>
        </nav> 
        <div class="table-container">
        
            <div class="table-heading">
                <?php
                    if($_SESSION['user_type'] == 'admin'){ 
                ?>
                    
                
                    <button class="button" id="myBtn">+ Add</button>
                <?php
                    }
                ?>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cottage Type</th>
                        <th>Room Description</th>
                        <th>Capacity</th>
                        <th>Inclusion</th>
                        <th>Price</th>
                        <th>Status</th>
                        <?php
                            if($_SESSION['user_type'] == 'admin'){ 
                        ?>
                            <th class="action">Action</th>
                        <?php
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once '../classes/cottages.class.php';

                        $cottage = new Cottage();
                        //We will now fetch all the records in the array using loop
                        //use as a counter, not required but suggested for the table
                        $i = 1;
                        //loop for each record found in the array
                        foreach ($cottage->show() as $value){ //start of loop
                    ?>
                        <tr>
                            <!-- always use echo to output PHP values -->
                            <td><?php echo $i ?></td>
                            <td><?php echo $value['cottype']?></td>
                            <td><?php echo $value['description'] ?></td>
                            <td><?php echo $value['capacity'] ?></td>
                            <td><?php echo $value['inclusion'] ?></td>
                            <td><?php echo $value['price'] ?></td>
                            <td><?php echo $value['status'] ?></td>
                            <?php
                                if($_SESSION['user_type'] == 'admin'){ 
                            ?>
                                <td>
                                    <div class="action">
                                        <a class="action-edit" href="editcottages.php?id=<?php echo $value['id'] ?>"><i class="fas fa-edit"></i></a>
                                        <a class="action-delete" href="deletecottages.php?id=<?php echo $value['id'] ?>"><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </td>
                            <?php
                                }
                            ?>
                        </tr>
                    <?php
                        $i++;
                    //end of loop
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


      <!-- Trigger/Open The Modal -->
  

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal Content -->
  <div class="modal-content">
  <div class="row"><span class="close">&times;</span></div>
    <form action="addcottages.php" method="post">
  <div class="row">
    <div class="col-25">
      <label for="cottype">Cottage Type</label>
    </div>
    <div class="col-75">
      <select id="cottype" name="cottype" style="margin-left: 0;">
        <option value="None" <?php if(isset($_POST['cottype'])) { if ($_POST['cottype'] == 'None') echo ' selected="selected"'; } ?>> <--Please Select--></option>
        <option value="Small" <?php if(isset($_POST['cottype'])) { if ($_POST['cottype'] == 'Small') echo ' selected="selected"'; } ?>>Small</option>
        <option value="Bahay Kubo" <?php if(isset($_POST['cottype'])) { if ($_POST['cottype'] == 'Bahay Kubo') echo ' selected="selected"'; } ?>>Bahay Kubo</option>
        <option value="Gazebo" <?php if(isset($_POST['cottype'])) { if ($_POST['cottype'] == 'Gazebo') echo ' selected="selected"'; } ?>>Gazebo</option>
      </select>
      
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="description"> Description</label>
    </div>
    <div class="col-75">
      <input type="text" id="description" name="description" required placeholder="Enter Cottage Description" value="<?php if(isset($_POST['description'])) { echo $_POST['description']; } ?>">
    </div>
    
  </div>
  <div class="row">
    <div class="col-25">
      <label for="capacity">Capacity</label>
    </div>
    <div class="col-75">
      <select id="capacity" name="capacity" style="margin: 0;">
        <option value="None" <?php if(isset($_POST['capacity'])) { if ($_POST['capacity'] == 'None') echo ' selected="selected"'; } ?>> <--Please Select--></option>
        <option value="Max of 8 Persons Only" <?php if(isset($_POST['capacity'])) { if ($_POST['capacity'] == 'Max of 8 Persons Only') echo ' selected="selected"'; } ?>>Max of 8 Persons Only</option>
        <option value="Max of 15 Persons Only" <?php if(isset($_POST['capacity'])) { if ($_POST['capacity'] == 'Max of 15 Persons Only') echo ' selected="selected"'; } ?>>Max of 15 Persons Only</option>
        <option value="Max of 20 Persons Only" <?php if(isset($_POST['capacity'])) { if ($_POST['capacity'] == 'Max of 20 Persons Only') echo ' selected="selected"'; } ?>>Max of 20 Persons Only</option>
      </select>
      
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="inclusion">Inclusion</label>
    </div>
    <div class="col-75">
      <textarea id="inclusion" name="inclusion"  required placeholder="Write something.." style="height:200px"  value="<?php if(isset($_POST['inclusion'])) { echo $_POST['inclusion']; } ?>"></textarea>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="price">Price</label>
    </div>
    <div class="col-75">
      <input type="number" id="price" name="price" required placeholder="Enter Price"value="<?php if(isset($_POST['price'])) { echo $_POST['price']; } ?>">
    </div>

    <div class="row">
      <div class="col-25">
        <label for="status">Status</label><br>
        </div>
        <div class="col-75">
        <label class="container1" for="Active">Available
            <input type="radio" name="status" id="ActiAvailableve" value="Available" <?php if(isset($_POST['status'])) { if ($_POST['status'] == 'Available') echo ' checked'; } ?>>
            <span class="checkmark"></span>
        </label>
        <label class="container1" for="Expired">Unavailable
            <input type="radio" name="status" id="Unavailable" value="Unavailable" <?php if(isset($_POST['status'])) { if ($_POST['status'] == 'Unavailable') echo ' checked'; } ?>>
            <span class="checkmark"></span>
        </label>
        </div>
    </div>
  <br>
  
  <div class="row">
    <input type="submit" value="submit" name="save" id="save">
    <a type="button" href="villas.php" class="btn cancel">Close</a>
  </div>
  </form>
  </div>

</div>

<script>
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[1];

  // When the user clicks the button, open the modal 
  btn.onclick = function() {
    modal.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

 // When the user clicks anywhere outside of the modal, close it
  
 window.onclick = function(event) {
if (event.target == modal) {
modal.style.display = "none";
}
}


</script>

  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
   arrowParent.classList.toggle("showMenu");
    });
  }
  // let sidebar = $('.sidebar')
  // let sidebarBtn = document.querySelector(".bx-menu");
  // console.log(sidebarBtn);
  // sidebarBtn.addEventListener("click", ()=>{
  //   sidebar.classList.toggle("close");
  // });

    $('.bx-menu').on('click', function(){
      $('.sidebar').toggleClass('close');
    });

//   document.getElementById("addform").addEventListener("click", function(){
//   document.getElementById("formcontainer").style.display = "block";
// });

  $('#addform').on('click', function(){
    $('#formcontainer').show();
  });

function closeForm() {
        document.getElementById("formcontainer").style.display = "none";
      }

      $(document).ready(function() {
    $('table').DataTable();
});
  </script>
  
</body>
</html>