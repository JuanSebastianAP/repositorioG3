<?php
require_once "Connection.php";
require_once "get.model.php";

class DeleteModel
{
    static public function deleteData($table, $id, $nameId)
    {
        $response = GetModel::getDataFilter($table, $nameId, $nameId, $id, null, null, null, null);
        if (empty($response)) {
            return null;
        }
            
            /* eliminar registros*/
        $sql="DELETE FROM $table WHERE $nameId=:$nameId";
         $link =Connection::connect();
        $smtp=$link->prepare($sql);
        $smtp-> bindParam(":".$nameId,$id,PDO::PARAM_STR);
        if ($smtp ->execute()){
            $response = array(
                "lastId"=>$link->lastInsertId(),
                "comment"=>"proceso exitoso"
            );
            return $response;
        }else{
            return $link->errorInfo();
        }
    }
}
