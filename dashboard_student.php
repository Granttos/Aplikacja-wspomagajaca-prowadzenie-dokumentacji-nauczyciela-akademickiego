<?php
session_start();
include_once './config/config.php';
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">

    <?php include_once './admin/layouts/header.php'; ?>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <?php include_once './admin/layouts/top_nav.php'; ?>
            <?php include_once './admin/layouts/sidebar_student.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Panel Główny</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Panel Główny</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">

                        <?php
                        
                        $student_id = $_SESSION['id'];

                        $current_year = date('Y');

                        $total_student = 0;
                        $total_teacher = 0;
                       

                        //Total Student 
                        $sql = "SELECT count(id) FROM student";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $total_student = $row['count(id)'];

                        //Total Teacher 
                        $sql1 = "SELECT count(id) FROM teacher";
                        $result1 = mysqli_query($conn, $sql1);
                        $row1 = mysqli_fetch_assoc($result1);
                        $total_teacher = $row1['count(id)'];

                  

                        
                        
                        //Total Teacher 
                        $sql4 = "SELECT * FROM student WHERE id='$student_id'";
                        $result4 = mysqli_query($conn, $sql4);
                        $row4 = mysqli_fetch_assoc($result4);
                        $name = $row4['name'];
                       
                        ?>
                        
                        <!-- Info boxes -->
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-graduate"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Studenci</span>
                                        <span class="info-box-number"><?php echo $total_student; ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Nauczyciele</span>
                                        <span class="info-box-number"><?php echo $total_teacher; ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <!-- fix for small devices only -->
                            <div class="clearfix hidden-md-up"></div>

                           
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <h6><?php echo $name; ?>,<strong style="color:#cf4ed4;"> Witaj!</strong></h6>
                        <br>
                    
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Moje przedmioty</h5>
                                    </div>
                                    <div class="card-body">

                                    <table id="mySubject" class="table table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Przedmiot</th>
                                                    <th>Nauczyciel</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                $student_id = $_SESSION['id'];
                                                $current_year = date('Y');

                                                $sql = "SELECT subject.name as s_name,teacher.name as t_name 
                                                        FROM student_subject 
                                                        INNER JOIN subject_routing
                                                        ON student_subject.sr_id=subject_routing.id
                                                        INNER JOIN subject
                                                        ON subject_routing.subject_id=subject.id
                                                        INNER JOIN teacher
                                                        ON subject_routing.teacher_id=teacher.id
                                                        WHERE student_subject.student_id='$student_id'";

                                                $result = mysqli_query($conn, $sql);
                                                $count = 0;
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $count++;

                                                ?>
                                                        <tr>
                                                            <td><?php echo $count; ?></td>
                                                            <td><?php echo $row['s_name']; ?></td>
                                                            <td><?php echo $row['t_name']; ?></td>
                                                            
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
            <!-- /.content-wrapper -->

            <?php include_once './admin/layouts/footer.php'; ?>
            
        </div>
        <!-- ./wrapper -->

        <?php include_once './admin/layouts/import_js.php'; ?>
        
    </body>

</html>