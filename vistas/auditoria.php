<?php 
    session_start();
    if(isset($_SESSION['usuario'])){
    include "header.php"; 
?>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Auditoría</h1>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <div id="tablaAuditoria"></div>
                </div>
            </div>
        </div>
    </div>

<?php include "footer.php"; ?>
    <script src="../js/auditoria.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablaAuditoria').load("auditoria/tablaAuditoria.php");
        });
    </script>
<?php
    }else{
        header("location:../index.php");
    }
?>