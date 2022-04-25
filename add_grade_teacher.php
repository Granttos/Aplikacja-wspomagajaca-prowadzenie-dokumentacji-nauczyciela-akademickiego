<?php
session_start();
include_once("./config/config.php");

if(!isset($_SERVER['HTTP_REFERER'])){
     // przekierowanie do lokalizacji
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
            <?php include_once './admin/layouts/sidebar_teacher.php'; ?>

            <!-- Content Wrapper,zawartosc strony -->
            <div class="content-wrapper">

                <!-- Content Header ,naglowek strony-->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Student</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Student</li>
                                    <li class="breadcrumb-item active">Dodaj ocenę</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Dodawanie studenta -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-6">
                                <!-- Horizontal Form -->
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Dodaj ocenę dla studenta </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form action="index.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                                        <div class="card-body">
                                            <div class="form-group row ">
                                                <label for="index_number" class="col-sm-2 col-form-label ">Indeks</label>
                                                <div class="col-sm-10" id="divIndexNumber">
                                                    <input type="text" class="form-control " placeholder="Podaj nr indeksu" id="index_number" name="index_number">

                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 col-form-label">Imię/Nazwisko</label>
                                                <div class="col-sm-10" id="divName">
                                                    <input type="text" class="form-control" placeholder="Podaj imię i nazwisko" id="name" name="name">

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="address" class="col-sm-2 col-form-label">Adres</label>
                                                <div class="col-sm-10" id="divAddress">
                                                    <input type="text" class="form-control" placeholder="Podaj adres" id="address" name="address">

                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label for="phone" class="col-sm-2 col-form-label">Telefon</label>
                                                <div class="col-sm-7" id="divPhone">
                                                    <input type="text" class="form-control " placeholder="Podaj numer telefonu" id="phone" name="phone">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-7" id="divEmail">
                                                    <input type="text" class="form-control" placeholder="Podaj adres email" id="email" name="email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="image" class="col-sm-2 col-form-label">Zdjęcie</label>
                                                <div class="col-sm-10" id="divImage">
                                                    <img id="profile_pic" style="width: 130px; height: 150px; margin-bottom:5px;" />
                                                    <input type="file" class="form-control-file" id="image" name="image">

                                                </div>

                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <input type="hidden" name="do" value="add_student">
                                            <button type="submit" class="btn btn-primary" id="btnSubmit">Dalej</button>

                                        </div>
                                        <!-- /.card-footer -->
                                    </form>
                                </div>
                                <!-- /.card -->

                            </div>
                        </div>
                    </div>
                </section>

                <!-- wybieranie oceny -->
                <div class="modal fade" id="modalSelectGrade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title">Wybierz ocenę</h5>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="grade_id">Ocena</label>
                                    <select id="grade_id" class="form-control">
                                        <option value="">Wybierz ocenę</option>
                                        <?php

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
                    </div>
                </div>

                <!-- $('#grade_id').change(function() -->
                <div id="divSelectSubject">
                    
                </div>

                


            </div>
            <!-- /.content-wrapper -->

            <?php include_once './admin/layouts/footer.php'; ?>
            
        </div>
        <!-- ./wrapper -->

        <?php include_once './admin/layouts/import_js.php'; ?>

        <!-- strona,plik js-->
        <script src="./js/student.js"></script>

        <!-- Alerty -->
        <?php
        if (isset($_GET["do"]) && ($_GET["do"] == "alert_from_insert")) {

            $msg = $_GET['msg'];
            $student_id = $_GET['student_id'];

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
    
                    toastr["warning"]("Ten rekord jest już w bazie!");
    
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
    
                    toastr["warning"]("Ten email i indeks jest już w bazie!!");
    
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
    
                    toastr["warning"]("Ten email jest już w bazie!!");
    
                });
                
                </script>
            ';
            }

            if ($msg == 4) {

                echo "
                <script>
                
                $(function() {
                    
                    $('#modalSelectGrade').data('id','$student_id').modal('show');
                
                });
                
                </script>
            ";
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
    
                    toastr["info"]("Spróbuj jeszcze raz!");
    
                });
                
                </script>
            ';
            }

            if ($msg == 6) {
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
    
                    toastr["error"]("ERROR");
    
                });
                
                </script>
            ';
            
        }
		if ($msg == 7) {

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
    
                    toastr["success"]("Student został dodany!!");
    
                });
                
                </script>
            ';
            }
		}
        ?>
        
    </body>

</html>