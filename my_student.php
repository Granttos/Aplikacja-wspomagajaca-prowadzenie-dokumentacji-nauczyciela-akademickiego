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
<html lang="en">

    <?php include_once './admin/layouts/header.php'; ?>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <?php include_once './admin/layouts/top_nav.php'; ?>
            <?php include_once './admin/layouts/sidebar_teacher.php'; ?>

            <!-- Content Wrapper, zawartosc strony -->
            <div class="content-wrapper">
                <!-- Content Header, naglowek strony -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Mój student</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Mój student</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Wybierz ocene -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-6">
                                <!-- general form elements -->
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Wybierz ocene</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->

                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="grade_id" class="col-sm-2 col-form-label">Ocena</label>
                                            <div class="col-sm-4" id="divGrade">
                                                <select class="form-control" id="grade_id">
                                                    <option>Wybierz ocene</option>
                                                    <?php
                                                    
                                                    $teacher_id = $_SESSION['id'];

                                                    $sql = "SELECT * FROM grade";
                                                    $result = mysqli_query($conn, $sql);

                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {

                                                    ?>

                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                                    <?php }
                                                    } ?>
                                                </select>  
                                                                            
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    
                                    <div class="card-footer">
                                    
                                        <button type="button" class="btn btn-primary" id="btnSubmit" onclick="showStudentTable(this);"  data-id="<?php echo $teacher_id; ?>">Wybierz</button>
                                    </div>

                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </section>

                <!-- function showStudentTable(recordID) & function showStudentTable1(grade_id,teacher_id) -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row" id="table1">
                        
                        </div>

                    </div>
                </section>

                <!-- Dane studenta -->
                <div class="modal fade" id="studentDetails" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-green">
                                <h5 class="modal-title" id="sName"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img id="sImage" class="img-circle" style="width: 120px; height: 120px;">	
                                    </div>
                                    <div class="col-sm-9">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Index </td>
                                                    <td id="sIndex"></td>
                                                </tr>
                                                <tr>
                                                    <td>Imie/Nazwisko</td>
                                                    <td id="sName1"></td>
                                                </tr>
                                                <tr>
                                                    <td>Adres</td>
                                                    <td id="sAddress"></td>
                                                </tr>
                                                <tr>
                                                    <td>Płeć</td>
                                                    <td id="sGender"></td>
                                                </tr>
                                                <tr>
                                                    <td>Telefon</td>
                                                    <td id="sPhone"></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td id="sEmail"></td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Record Modal-->
                <?php include_once 'delete_record_modal.php'; ?>

                <!-- function editStudentSubject(editSubject) -->
                <div id="editSubject">
                                                    
                </div>

            </div>
            <!-- /.content-wrapper -->

            <?php include_once './admin/layouts/footer.php'; ?>
            
        </div>
        <!-- ./wrapper -->

        <?php include_once './admin/layouts/import_js.php'; ?>

        <!-- This Page JS File-->
        <script src="./js/my_student.js"></script>

        <?php
        if (isset($_GET["do"]) && ($_GET["do"] == "alert_from_update")) {

            $msg = $_GET['msg'];
            $grade_id = $_GET['grade_id'];
            $teacher_id = $_SESSION['id'];

            echo "
            
            <script>

            $(function() {

                showStudentTable1($grade_id,$teacher_id);

            });

            </script>
            
            
            
            ";

            if ($msg == 1) {

                echo '
                <script>
                
                $(function() {
                    toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "show",
                    "hideMethod": "fadeOut"
                    }
    
                    toastr["success"]("Your information has been successfully updated in our database.", "Success!");
    
                });
                
                </script>
            ';
            }
            
            if ($msg == 2) {

                echo '
                <script>
                
                $(function() {
                    toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "show",
                    "hideMethod": "fadeOut"
                    }

                    toastr["info"]("Check your internet connection and try again.", "Something is wrong!");
    
                    
    
                });
                
                </script>
            ';
            }
            
            if ($msg == 3) {

                echo '
                <script>
                
                $(function() {
                    toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "show",
                    "hideMethod": "fadeOut"
                    }
    
                    toastr["error"]("Sorry, there was an error uploading your file.", "Something is wrong!");

                    
    
                });
                
                </script>
            ';
            }

            if ($msg == 4) {

                echo '
                <script>
                
                $(function() {
                    toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "show",
                    "hideMethod": "fadeOut"
                    }
    
                    toastr["warning"]("This email address already has in our Database.", "Warning!");
    
                });
                
                </script>
            ';
            }

            if ($msg == 5) {
                echo '
                <script>
                
                $(function() {
                    toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "show",
                    "hideMethod": "fadeOut"
                    }
    
                    toastr["warning"]("This index number already has in our Database.", "Warning!");
    
                });
                
                </script>
            ';
            }
            
        
        }

        ?>
        
    </body>

</html>