<?php

Class Ranking {

    public function prepara_dados($dados)
    {
        // ver($dados);
        $ranking = $this->remove_duplicados($dados);
        // ver($ranking);

        return $ranking;
    }

    public function remove_duplicados($dados)
    {
        $ranking  = [];
        $posicao  = 1;
        $record   = 0;
        
        foreach ( $dados as $k => &$v ) {

            if ( !array_key_exists($v['movement_id'], $ranking) ) {

                // Como o array $dados ja vem ordenado pelo tipo de movimento, reseta a posição.
                $posicao                                   = 1;
                $record                                    = $v['value'];
                $v['posicao']                              = $posicao;
                $ranking[$v['movement_id']][$v['user_id']] = $v;
                $ranking[$v['movement_id']]['descricao']   = $v['movement_name'];

            } else {

                if ( !array_key_exists($v['user_id'], $ranking[$v['movement_id']]) ) {
                    
                    $this->trata_posicao($posicao, $ranking, $v, $record);
                    
                    $ranking[$v['movement_id']][$v['user_id']] = $v;
                }

            }
        }
        
        return $ranking;
    }

    public function trata_posicao(&$posicao, &$ranking, &$v, &$record)
    {
        if ( $v['value'] < $record ) {
            $record = $v['value'];
            $posicao++;
        }
        
        $v['posicao'] = $posicao;
    }

}