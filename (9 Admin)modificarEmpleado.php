<html>
<head>
    <title>Administrador</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2:wght@500;600;700&display=swap" rel="stylesheet">
    <script>    
        function ValidaSoloNumeros(){
            if((event.keyCode < 48) || (event.keyCode > 57))
                event.returnValue = false;   
        }
        function ValidaSoloLetras(){
            if((event.keyCode != 32) && (event.keyCode < 65) ||
                (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
                event.returnValue = false;   
        }

        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            // add a zero in front of numbers<10
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById("txtHora").innerHTML = h + ":" + m + ":" + s;
            var t = setTimeout(function(){ startTime() }, 500);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
    </script>
</head>
<body onload="startTime()">
            <!--<td>Hora: </td>-->
            <div id="txtHora" style="text-align: right; color: white;"></div>
            <?php
            date_default_timezone_set('America/Santiago');
            $fechaHoy = date('d-m-Y');
            ?>
            <!--<td>Fecha: </td>-->
            <div id="txtDate" style="text-align: right; color: white;"><?php echo $fechaHoy; ?>
    <br>
    <center>
    <h1><b>Modificar Empleado</b></h1>
    <form name="form1" method="post">
    <?php error_reporting(0);?> 
    <?php 
        if($_POST['btnBuscar']=="Buscar"){
            include("funciones.php");
            $cnn = Conectar();
            $rut = $_POST['txtRut'];
            $rs = mysqli_query($cnn, "select * from empleado where rut='$rut'");
                if($row = mysqli_fetch_array($rs)){
                    $datoNom = $row[nombres];
                    $datoApe = $row[apellidos];
                    $datoFec = $row[fechaNac];
                    $datoSex = $row[sexo];
                    $datoDir = $row[direccion];
                    $datoReg = $row[region];
                    $datoFon = $row[fono];    
                    $datoCor = $row[correo];
                    $datoCar = $row[cargo];
                    $datoUsu = $row[usuario];
                    $datoCon = $row[contraseña]; 

                    $resultSex = mysqli_query($cnn,"SELECT descripcion FROM sexo WHERE id='$datoSex'");
                    $rw1 = mysqli_fetch_array($resultSex);
                    $sexo = $rw1[0];

                    $resultReg = mysqli_query($cnn,"SELECT nombreRegion FROM regiones WHERE id='$datoReg'");
                    $rw2 = mysqli_fetch_array($resultReg);
                    $region = $rw2[0];

                    $resultCar = mysqli_query($cnn,"SELECT descripcion FROM cargos WHERE id='$datoCar'");
                    $rw3 = mysqli_fetch_array($resultCar);
                    $cargo = $rw3[0];
                }else{
                    echo "<script>alert('Rut no Existe')</script>";
                }    
        }
    ?>
    
    

    <table border="0" style="color: white;">
        <tr>
            <td><b>Rut: </b></td>
            <td><input type="text" name="txtRut" value="<?php echo $rut;?>"></td>
            <td><input type="submit" name="btnBuscar" value="Buscar"></td>
        </tr>
        <tr>
            <td><b>Nombres: </b></td>
            <td><input type="text" name="txtNom" value="<?php echo $datoNom;?>" onkeypress="ValidaSoloLetras()"></td>
        </tr>
        <tr>
            <td><b>Apellidos: </b></td>
            <td><input type="text" name="txtApe" value="<?php echo $datoApe;?>" onkeypress="ValidaSoloLetras()"></td>
        </tr>
        <tr>
            <td><b>Fecha de Nacimiento: </b></td>
            <td><input type="date" name="txtFec" style="width:160px" value="<?php echo $datoFec;?>"></td>
        </tr>
        <tr>
            <td><b>Sexo: </b></td>
            <td><select name="txtSex" style="width:160px">
            <?php
	            echo "<option value='$sexo'>$sexo</option>";
	            echo "<option value=''>----------------</option>";
            ?>
	            <?php
                    $sql = "SELECT descripcion FROM sexo";
                    $result = mysqli_query($cnn,$sql);
                    while ($row = mysqli_fetch_array($result)){
                            echo'<option>'.$row["descripcion"].'</option>';
                    }
                ?>
            </select></td>
        </tr>
        <tr>
            <td><b>Dirección: </b></td>
            <td><input type="text" name="txtDir" value="<?php echo $datoDir;?>"></td>
        </tr>
        <tr>
            <td><b>Región: </b></td>
            <td><select name="txtReg" style="width:160px">
            <?php
	            echo "<option value='$region'>$region</option>";
	            echo "<option value=''>----------------</option>";
            ?>
                <?php
                    $sql = "SELECT nombreRegion FROM regiones";
                    $result = mysqli_query($cnn,$sql);
                    while ($row = mysqli_fetch_array($result)){
                            echo'<option>'.$row["nombreRegion"].'</option>';
                    }
                ?>
            </select></td>
        </tr>
        <tr>
            <td><b>Fono: </b></td>
            <td><input type="text" name="txtFon" value="<?php echo $datoFon;?>" onkeypress="ValidaSoloNumeros()"></td>
        </tr>
        <tr>
            <td><b>Correo: </b></td>
            <td><input type="text" name="txtCor" value="<?php echo $datoCor;?>"></td>
        </tr>
        <tr>
            <td><b>Cargo: </b></td>
            <td><select name="txtCar" style="width:160px">
            <?php
	            echo "<option value='$cargo'>$cargo</option>";
	            echo "<option value=''>----------------</option>";
            ?>
	            <?php
                    $sql = "SELECT descripcion FROM cargos";
                    $result = mysqli_query($cnn,$sql);
                    while ($row = mysqli_fetch_array($result)){
                            echo'<option>'.$row["descripcion"].'</option>';
                    }
                ?>
            </select></td>
        </tr>
        <tr>
            <td><b>Usuario: </b></td>
            <td><input type="text" name="txtUsu" value="<?php echo $datoUsu;?>"></td>
        </tr>
        <tr>
            <td><b>Contraseña: </b></td>
            <td><input type="text" name="txtCon" value="<?php echo $datoCon;?>"></td>
        </tr>
        <tr>
            <td><b></b></td>
            <td><input type="submit" name="btnModificar" style="width:160px; height:50px;" value="MODIFICAR"></td>
        </tr>
    </table>  
    
    <?php 
        if($_POST['btnModificar']=="MODIFICAR"){
            include("funciones.php");
            $cnn = Conectar();
            $rut = $_POST['txtRut'];
            $nom = $_POST['txtNom']; 
            $ape = $_POST['txtApe'];
            $fec = $_POST['txtFec'];
            $sex = $_POST['txtSex'];
            $dir = $_POST['txtDir'];
            $reg = $_POST['txtReg'];
            $fon = $_POST['txtFon']; 
            $cor = $_POST['txtCor'];
            $car = $_POST['txtCar'];
            $usu = $_POST['txtUsu'];
            $con = $_POST['txtCon'];

            if(empty($nom) || empty($ape) || empty($fec) || empty($sex) || empty($dir) || empty($reg) || empty($fon) || empty($cor) || empty($car) || empty($usu) || empty($con)){
                ?><script>alert("Los campos obligatorios deben contener datos")</script><?php
            }else{
            //Comparar y buscar la llave primaria de la tabla Sexo para insertar
            $result1 = mysqli_query($cnn,"SELECT id FROM sexo WHERE descripcion='$sex'");
            $rw1 = mysqli_fetch_array($result1);
            $idSex = $rw1[0];
            //Fin de Comparar y buscar tabla Sexo
            //Comparar y buscar la llave primaria de la tabla Region para insertar
            $result2 = mysqli_query($cnn,"SELECT id FROM regiones WHERE nombreRegion='$reg'");
            $rw2 = mysqli_fetch_array($result2);
            $idReg = $rw2[0];
            //Fin de Comparar y buscar tabla Region
            //Comparar y buscar la llave primaria de la tabla Cargo para insertar
            $result3 = mysqli_query($cnn,"SELECT id FROM cargos WHERE descripcion='$car'");
            $rw3 = mysqli_fetch_array($result3);
            $idCar = $rw3[0];
            //Fin de Comparar y  tabla Cargo

            $sql = "
            UPDATE empleado
            SET nombres='$nom', apellidos='$ape', fechaNac='$fec', sexo='$idSex', direccion='$dir', region='$idReg', fono='$fon', correo='$cor', cargo='$idCar', usuario='$usu', contraseña='$con'
            where rut='$rut'
            ";
            mysqli_query($cnn, $sql);
            echo "<script>alert('Se han Modificado los Registros')</script>";
            }
        }
    ?>
    </form>  
</body>
</html>