
<?php error_reporting(0);?> 
<?php
if ($_POST['btnBuscarRut']){
            include("funciones.php");
            $cnn = Conectar();
            $rut = $_POST['txtRut'];
            $rs = mysqli_query($cnn, "select * from empleado where rut='$rut'");
                if($row = mysqli_fetch_array($rs)){
                    $datoNom = $row['nombres'];
                    $datoApe = $row['apellidos'];
                }else{
                    echo "<script>alert('Rut no Existe')</script>";
                } 
} 
/*      
if (isset($_POST['btnBuscarPat'])){
        if($_POST['btnBuscarPat']=="Buscar Patente"){
            include("funciones.php");
            $cnn = Conectar();
            $pat = $_POST['txtPat'];
            $rs = mysqli_query($cnn, "select * from vehiculo where patente='$pat'");
                if($row = mysqli_fetch_array($rs)){
                    $datoMar = $row['marca'];
                    $datoMod = $row['modelo'];
                    $datoVal = $row['valorArriendo'];
                    $datoGar = $row['garantia']; 
                }else{
                    echo "<script>alert('Rut no Existe')</script>";
                } 
        } 
}   */    
?>                   
