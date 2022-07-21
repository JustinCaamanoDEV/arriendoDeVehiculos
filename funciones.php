<?php
    function Conectar()
    {
        if(!($cnn = mysqli_connect("localhost", "root","")))
        {
            exit();
        }
        if(! mysqli_select_db($cnn, "arriendodevehiculos"))
        {
            exit();
        }
        return $cnn;
    }

    function Verifica($cajaTexto){
        $cont=2;
        $suma=0;
        $largo=strlen($cajaTexto);
        for($i=$largo;$i>0;$i--){
            $suma=$suma + (substr($cajaTexto,$i-1,1)*$cont);
            $cont=$cont+1;
            if($cont==8){$cont=2;}
        }
        $Digito=11-($suma%11);
        if($Digito==10){$Digito="K";}
        if($Digito==11){$Digito="0";}
        return $Digito;
    }
?>