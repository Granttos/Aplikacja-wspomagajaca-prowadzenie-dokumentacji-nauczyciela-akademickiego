<?php
include_once './config/config.php';
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location: index.php');
    exit;
}
?>
<div class="modal fade" id="modalInvoice" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="div-logo">
                            <img class="logo" src="./uploads/logo.png">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h2>eNoteBook</h2>

                        <div >
                            Cieplice 23<br>
                            58-500 Jelenia Góra, PL
                        </div>

                    </div>
                    <div class="col-md-5">
                        <div class="school-email text-right">
                            Email: eNoteBook@gmail.com<br>
                            Phone: 444-888-1111
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Zatwierdzone dla:</h4>
                        <div>

                            <?php
                        
                            $grade_id = $_GET['grade_id'];
                            $subject_id = $_GET['subject_id'];
                            $monthly_fee = number_format($monthly_fee, 2, '.', '');

                            $sql = "SELECT * FROM student WHERE id='$student_id'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);


                            ?>
                            <span class="student-name"><?php echo $row['name']; ?></span>

                        </div>

                    </div>
                    <div class="col-md-6 current-date text-right">

                        <?php

                        $sql1 = "SELECT * FROM student_payment ORDER BY id DESC LIMIT 1";
                        $result1 = mysqli_query($conn, $sql1);
                        $row1 = mysqli_fetch_assoc($result1);

                        $id1 = $row1["id"];

                        $inv_number = $id1 + 1;

                        $current_year = date("Y");
                        $current_month = date("Y");
                        $current_date = date("Y-m-d");


                        ?>

                        <h3>Potwierdzenie - #<?php echo $inv_number; ?></h3>
                        <div>
                            Rok: <?php echo $current_year; ?><br>
                            Miesiąc:<?php echo $current_month; ?><br>
                            Data <?php echo $current_date; ?>
                        </div>

                    </div>
                </div>

                <table class="table table-bordered ">
                    <thead>
                        <tr class="t-head">
                            <th>#</th>
                            <th>Opis</th>
                            <th class="text-right">Fee</th>
                            <th class="text-right">Sub Total</th>
                        </tr>
                    </thead>
                   
                </table>
                <div class="row">
                 
                        
                        

                    </div>

                </div>
                <center><h1>Dziękuje!</h1></center>
            </div>

           
           
        </div>
    </div>
</div>