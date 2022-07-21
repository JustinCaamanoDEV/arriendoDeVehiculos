<html>
<head>
    <title>Mantenedor de Datos</title>
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
            <div id="txtHora" style="text-align: right;"></div>
            <?php
            date_default_timezone_set('America/Santiago');
            $fechaHoy = date('d-m-Y');
            ?>
            <!--<td>Fecha: </td>-->
            <div id="txtDate" style="text-align: right;"><?php echo $fechaHoy; ?>
    <br>
    <center>
    <h1><b>Modificar Clientes</b></h1>
    <form name="form1" method="post">
    <?php error_reporting(0);?> 
    <?php 
        if($_POST['btnBuscar']=="Buscar"){
            include("funciones.php");
            $cnn = Conectar();
            $rut = $_POST['txtRut'];
            $rs = mysqli_query($cnn, "select * from clientes where rut='$rut'");
                if($row = mysqli_fetch_array($rs)){
                    $datoNom = $row[nombres];
                    $datoApe = $row[apellidos];
                    $datoFec = $row[fechaNacimiento];
                    $datoSex = $row[sexo];
                    $datoReg = $row[region];
                    $datoFon = $row[fono];    
                    //$option = '';
                    //$option2 = '';
                
                    //Cargar Sexo
                    /*if($datoSex == 'Masculino'){
                        $option = '<option value="'.$datoSex.'">'.$datoSex.'</option>';
                    }else if ($datoSex == 'Femenino'){
                        $option = '<option value="'.$datoSex.'">'.$datoSex.'</option>';
                    }*/

                    //Cargar Región
                    /*if($datoReg == 'I Region'){
                        $option2 = '<option value="'.$datoReg.'" select>'.$datoReg.'</option>';
                    }else if ($datoReg == 'VI Region'){
                        $option2 = '<option value="'.$datoReg.'" select>'.$datoReg.'</option>';
                    }else if ($datoReg == 'X Region'){
                        $option2 = '<option value="'.$datoReg.'" select>'.$datoReg.'</option>';
                    }*/

                }else{
                    echo "<script>alert('Rut no Existe')</script>";
                }    
        }
    ?>
    
    

    <table border="0">
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
            <td><input type="date" name="txtFec" style="width:173px" value="<?php echo $datoFec;?>"></td>
        </tr>
        <tr>
            <td><b>Sexo: </b></td>
            <td><select name="txtSex" style="width:173px">
            <?php
	            echo "<option value='$datoSex'>$datoSex</option>";
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
            <td><b>Región: </b></td>
            <td><select name="txtReg" style="width:173px">
            <?php
	            echo "<option value='$datoReg'>$datoReg</option>";
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
            <td><b></b></td>
            <td><input type="submit" name="btnModificar" value="Modificar"></td>
        </tr>
    </table>  
    
    <?php 
        if($_POST['btnModificar']=="Modificar"){
            include("funciones.php");
            $cnn = Conectar();
            $rut = $_POST['txtRut'];
            $nom = $_POST['txtNom'];
            $ape = $_POST['txtApe'];
            $fec = $_POST['txtFec'];
            $sex = $_POST['txtSex'];
            $reg = $_POST['txtReg'];
            $fon = $_POST['txtFon'];
            $sql = "
            UPDATE clientes
            SET nombres='$nom', apellidos='$ape', fechaNacimiento='$fec', sexo='$sex', region='$reg', fono='$fon'
            where rut='$rut'
            ";
            mysqli_query($cnn, $sql);
            echo "<script>alert('Se han Modificado los Registros')</script>";
        }
    ?>
    </form>  
</body>
</html>