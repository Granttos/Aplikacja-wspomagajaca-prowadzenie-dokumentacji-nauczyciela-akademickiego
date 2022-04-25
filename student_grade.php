<?php
session_start();
include_once './config/config.php';

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
            <?php include_once './admin/layouts/sidebar.php'; ?>

            <!-- Content Wrapper , zawartosc strony -->
            <div class="content-wrapper">

                <!-- naglowek tresci (naglowek strony) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Oceny</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Oceny</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Tabela -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row" id="table1">
                            <div class="col-10">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">

                                        <h3 class="card-title">Oceny</h3>
                                        

                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="dTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Ocena</th>
                                                    <th>Przedmiot</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                               
                                                $sql = "SELECT  subject_routing.id as sr_id, grade.name as g_name, subject.name as s_name 
                                                        FROM subject_routing 
                                                        INNER JOIN  grade
                                                        ON subject_routing.grade_id=grade.id
                                                        INNER JOIN  subject
                                                        ON subject_routing.subject_id=subject.id
                                                        ";
                                                
                                                $result = mysqli_query($conn, $sql);
                                                $count = 0;
                                                
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $count++;

                                                ?>
                                                        <tr>
                                                            <td><?php echo $count; ?></td>
                                                            <td id="td1_<?php echo $row['sr_id']; ?>"><?php echo $row['g_name']; ?></td>
                                                            <td id="td2_<?php echo $row['sr_id']; ?>"><?php echo $row['s_name']; ?></td>
                                                            
                                    
                                                           
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

                 <!-- Dodawanie nowych rekordow-->
                <div class="modal fade" id="modalInsertForm" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title">Przypisz ocenę do przedmiotu i nauczyciela</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="index.php" method="POST" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group" >
                                        <label for="grade_id">Ocena</label>
                                        <select name="grade_id" id="grade_id" class="form-control">
                                            <option value="">Wybierz ocene</option>
                                        <?php 
                                        
                                        $sql="SELECT * FROM grade";
                                        $result=mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($result) > 0){
                                            while($row=mysqli_fetch_assoc($result)){
                                        
                                        ?>

                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                        <?php } } ?>
                                        </select>
                                    </div>
                                    <div class="form-group" >
                                        <label for="subject_id">Przedmiot</label>
                                        <select name="subject_id" id="subject_id" class="form-control">
                                            <option value="">Wybierz przedmiot</option>
                                        <?php 
                                        
                                        $sql="SELECT * FROM subject";
                                        $result=mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($result) > 0){
                                            while($row=mysqli_fetch_assoc($result)){
                                        
                                        ?>

                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                        <?php } } ?>
                                        </select>
                                    </div>
                                    <div class="form-group" >
                                        <label for="grade_id">Nauczyciel</label>
                                        <select name="teacher_id" id="teacher_id" class="form-control">
                                            <option value="">Wybierz nauczyciela</option>
                                        <?php 
                                        
                                        $sql="SELECT * FROM teacher";
                                        $result=mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($result) > 0){
                                            while($row=mysqli_fetch_assoc($result)){
                                        
                                        ?>

                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                        <?php } } ?>
                                        </select>
                                    </div>
                                   
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="do" value="add_subject_routing">
                                    <button type="submit" class="btn bg-primary" id="btnSubmit" style="width:100%;">Dodaj</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                 <!-- Edytowanie -->
                <div class="modal fade" id="modalUpdateForm" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title">Edytuj przypisanie oceny</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                <div class="modal-body">
                                    <div class="form-group" >
                                        <label for="grade_id1">Ocena</label>
                                        <select id="grade_id1" class="form-control">
                                            
                                        <?php 

                                        $sql="SELECT * FROM grade";
                                        $result=mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($result) > 0){
                                            while($row=mysqli_fetch_assoc($result)){
                                        
                                        ?>

                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                        <?php } } ?>
                                        </select>
                                    </div>
                                    <div class="form-group" >
                                        <label for="subject_id1">Przedmiot</label>
                                        <select id="subject_id1" class="form-control">
                                            
                                        <?php 

                                        $sql="SELECT * FROM subject";
                                        $result=mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($result) > 0){
                                            while($row=mysqli_fetch_assoc($result)){
                                        
                                        ?>

                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                        <?php } } ?>
                                        </select>
                                    </div>
                                    <div class="form-group" >
                                        <label for="teacher_id1">Nauczyciel</label>
                                        <select id="teacher_id1" class="form-control">
                                            
                                        <?php 

                                        $sql="SELECT * FROM teacher";
                                        $result=mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($result) > 0){
                                            while($row=mysqli_fetch_assoc($result)){
                                        
                                        ?>

                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                        <?php } } ?>
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    
                                    <input type="hidden" id="id1">
                                    <button type="button" class="btn bg-primary" id="btnUpdate" onclick="updateRecord1();" style="width:100%;">Aktualizuj</button>
                                </div>
                        
                        </div>
                    </div>
                </div>

                <!-- Usuwanie rekordow-->
                <?php include_once 'delete_record_modal.php'; ?>

            </div>
            <!-- /.content-wrapper -->

            <?php include_once './admin/layouts/footer.php'; ?>
            
        </div>
        <!-- ./wrapper -->

        <?php include_once './admin/layouts/import_js.php'; ?>

        <!-- Strona ,plik js-->
        <script src="./js/subject_routing.js"></script>

        <!-- Alerty -->
        <?php
        if (isset($_GET["do"]) && ($_GET["do"] == "alert_from_insert")) {

            $msg = $_GET['msg'];

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
    
                    toastr["warning"]("Uwaga!Rekord został zduplikowany.");
    
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
    
                    toastr["success"]("Informacje zostały dodane do bazy.");
    
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
    
                    toastr["info"]("Spróbuj jeszcze raz.");
    
                });
                
                </script>
            ';
            }
        }
        ?>
        
    </body>

</html>