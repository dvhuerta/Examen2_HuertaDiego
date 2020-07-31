<?php
//CONEXION
include 'mainService.php';

class ModuloService extends MainService {

    function findAll(){
        return $this->conex->query("SELECT * FROM SEG_MODULO WHERE ESTADO LIKE '%ACT%'");
        
    }

    function findByPK($codModulo){
        //$conex = getConection();
        $result = $this->conex->query("SELECT * FROM SEG_MODULO WHERE cod_modulo='$codModulo'");
        if ($result->num_rows > 0) {
            $row1 = $result->fetch_assoc();
            return $row1;
        }else{
            return null;
        }
    }

    function insert($codModulo, $nombre, $estado){
        //$conex = getConection();
        $stmt = $this->conex->prepare("INSERT INTO SEG_MODULO (cod_modulo, nombre, estado) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $codModulo, $nombre, $estado);
        $stmt->execute();
        $stmt->close();
        //$this->conex->close();
    }

    function update($nombre, $codCliente){
        //$conex = getConection();
        $stmt = $this->conex->prepare("UPDATE SEG_MODULO SET nombre=? WHERE cod_modulo = ?");
        $stmt->bind_param("ss",  $nombre,  $codCliente);
        $stmt->execute();
        $stmt->close();
    }

    function delete($codModulo){
        //$conex = getConection();
        $stmt = $this->conex->prepare("UPDATE SEG_MODULO SET ESTADO = 'INA' WHERE cod_modulo = ?");
        $stmt->bind_param("s", $codModulo);
        $stmt->execute();
        $stmt->close();
    }
}
?>