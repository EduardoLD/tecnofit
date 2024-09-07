<?php

require_once('../../lib/Database/Connection.php');

$conn    = Connection::getConnection();
$request = $_SERVER['REQUEST_METHOD'];
$action  = $_REQUEST['action'] ?? null;
$return  = [];

if ( $request === 'GET' && !is_null($action) && function_exists($action) ) {
    $return = $action($conn);
} else {
    // Método não permitido ou ação inválida
    http_response_code(405);
    $return = ["message" => "Método de requisição não permitido ou ação inválida!"];
}

function getRanking($conn, $fetchall=true)
{
    $sql = "SELECT pr.movement_id, pr.user_id, pr.value, m.name movement_name, u.name user_name, pr.date
            FROM personal_record pr
                
                INNER JOIN movement m
                ON m.id = pr.movement_id
                
                INNER JOIN user u
                ON u.id = pr.user_id
                
            ORDER BY pr.movement_id, pr.value DESC";
    
    $qry = $conn->prepare($sql);
    $qry->execute();

    if ( $fetchall ) {
        return $qry->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return $qry->fetch(PDO::FETCH_ASSOC);
    }
}

die(json_encode($return));