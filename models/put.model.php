<?php
require_once "Connection.php";
require_once "get.model.php";

class PutModel
{
    static public function putData($table, $data, $id, $nameId)
    {
        $response = GetModel::getDataFilter($table, $nameId, $nameId, $id, null, null, null, null);
        if (empty($response)) {
            return null;
        }
        /* actualizar registros*/
        $set = "";
        foreach ($data as $key => $value) {
            $set .= $key . "= :" . $key . ",";
        }
        $set = substr($set, 0, -1);
        $sql = "UPDATE $table SET $set WHERE $nameId=:$nameId";
        $link = Connection::connect();
        $smtp = $link->prepare($sql);
        $smtp->bindParam(":" . $nameId, $id, PDO::PARAM_STR);
        if ($smtp->execute()) {
            $response = array(
                "lastId" => $link->lastInsertId(),
                "comment" => "proceso exitoso"
            );
            return $response;
        } else {
            return $link->errorInfo();
        }
    }
}
