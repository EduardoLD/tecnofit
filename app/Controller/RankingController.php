<?php

Class RankingController {

    public function index()
    {
        $dados_ranking = $this->get_dados_ranking();
        // ver($dados_ranking);
        $dados_ranking = (new Ranking)->prepara_dados($dados_ranking);
        // ver($dados_ranking);
        carrega_twig('ranking.twig', [
            'dados' => $dados_ranking
        ]);
    }

    public function get_dados_ranking()
    {
        // URL da API
        $url = 'http://localhost/tecnofit/app/Api/api.php?action=getRanking';

        // Busca o conteúdo da API usando file_get_contents
        $response = file_get_contents($url);
        
        // Converte o JSON retornado para um array PHP
        $dados_ranking = json_decode($response, true);

        // Retorna os dados
        return $dados_ranking;
    }

    public function mostra_ranking()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        // Verifica se 'dados' existe e é um array
        if (isset($post['dados']) && is_array($post['dados'])) {
            // Separa a descrição (último elemento) dos dados
            $descricao = array_pop($post['dados']);
            
            // Ordena o array com base na chave 'posicao'
            usort($post['dados'], function ($a, $b) {
                return $a['posicao'] <=> $b['posicao'];
            });

            // Reanexa a descrição ao final do array
            // $post['dados'][] = $descricao;
        }

        // Carrega o template com os dados ordenados
        carrega_twig('ranking_table.twig', [
            'movement_id'   => $post['movement_id'],
            'dados'         => $post['dados'],
            'movement_desc' => $descricao
        ]);
    }


}