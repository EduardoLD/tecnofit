function mostra_ranking(movement_id, dados) {
    // Mostra o indicador de loading
    $('#ranking-table-container').hide();
    $('#loading-indicator').show();

    // Define um atraso de 5 segundos (5000 milissegundos)
    setTimeout(function() {
        $.ajax({
            url: '?p=ranking&op=mostra_ranking',
            method: 'POST',
            data: { movement_id: movement_id, dados: dados },
            success: function(ranking) {
                // Insere o HTML retornado dentro da div com id="ranking-table-container"
                $('#ranking-table-container').html(ranking);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erro ao carregar o ranking:', textStatus, errorThrown);
            },
            complete: function() {
                // Esconde o indicador de loading
                $('#loading-indicator').hide();
                $('#ranking-table-container').show();
            }
        });
    }, 500);
}
