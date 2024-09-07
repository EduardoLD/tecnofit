<?php

Class Model
{
    protected $insert_id;

    public function __construct() {
        // echo "Classe Model instanciada.";
    }

    public function execQuery($sql='', $insert=false, $fetchAll=true)
    {
        if ( !empty($sql) ) {
            $con = Connection::getConn();
            $sql = $con->prepare($sql);

            $sql->execute();

            if ( $insert ) {
                $_SESSION['insert_id'] = $con->lastInsertId();
            }

            if ( $fetchAll ) {
                return $sql->fetchAll();
            } else {
                return $sql->fetch();
            }
        }
    }

    public function insert($tab, $dados, $ignore=0)
    {
        $sql = 'insert ' . ($ignore ? ' ignore ' : '') . 'into ' . $tab . ' (' . implode(",", array_keys($dados)) . ') values (' . "'" . implode("','", $dados) . "'" . ')';

        $this->execQuery($sql, true);
    }

    public function update($tab, $dados, $where='')
    {
        $cpos_upd = '';

        foreach ($dados as $key => $value) {
            if ($key != 'str_logo') {
                if ($cpos_upd != '') {
                    $cpos_upd .= ', ';
                }

                if (is_numeric($value)) {
                    $cpos_upd .= "$key = $value";
                } else {
                    $cpos_upd .= "$key = '$value'";
                }
            }
        }
        
        if ( !empty($where) ) {
            $sql = "UPDATE $tab SET $cpos_upd WHERE $where";
            $this->execQuery($sql, false);
        }
    }

    public function delete($tab, $where='')
    {
        if ( !empty($where) ) {
            $sql = "DELETE FROM $tab WHERE $where";
            $this->execQuery($sql, false);
        }
    }
}