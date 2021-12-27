<?php
class MBA3 { 
    /* Member variables */
    var $query; 
    var $resultado;
    /* Member functions */
    function setQuery($par){ 
        $this->query = $par; 
    } 
           
    function getQuery(){ 
        echo $this->query; 
    } 
           
    function setResultado($par){ 
        $this->resultado = $par; 
    } 
           
    function getResultado(){ 
        echo $this->resultado ; 
    } 
    function ObtenerDatos(){
        $conn=odbc_connect("DRIVER={4D v12 ODBC Driver};Server=192.168.1.2;","API","API");
        try {
            $rs=odbc_exec($conn,$this->query);
        } catch (error $e) {
            die("Error 4D : " . $e->getMessage());
        }
        return $rs;
    }
}   
      

?>