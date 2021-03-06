<?php
include_once './config/config.php';
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location: index.php');
    exit;
}
?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="./uploads/IngeniousLogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">eNoteBook</span>
    </a>

    <?php
    
    $teacher_id = $_SESSION['id'];

	$sql = "SELECT * FROM teacher WHERE id='$teacher_id'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
		
    ?>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $row["image"]; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $row["name"]; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashboard_teacher.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Panel Główny</p>             
            </a>
          </li>
          <li class="nav-item">
            <a href="teacher_profile.php" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>Mój profil</p>             
            </a>
          </li>
          <li class="nav-item">
            <a href="my_student.php" class="nav-link">
            <i class="nav-icon fas fa-user-graduate"></i>
              <p>Mój student</p>             
            </a>
          </li> 
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Przedmioty
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="my_subject_teacher.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mój przedmiot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="all_subject_teacher.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Wszystkie przedmioty</p>
                </a>
              </li>
            </ul>
			<li class="nav-item ">
            <a href="add_grade_teacher.php" class="nav-link">
              <i class="nav-icon fas fa-user-graduate"></i>
                Dodaj ocenę 
            </a>
			</li>
			
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>