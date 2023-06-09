<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Glossário IAB</title>

        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }

            /* Estilos para o formulário de busca */
            .search-form {
                margin-top: 20px;
            }

            .search-form h1 {
                font-size: 24px;
                margin-bottom: 10px;
            }

            .search-form label {
                display: block;
                margin-bottom: 5px;
            }

            .search-form .form-group {
                margin-bottom: 15px;
            }

            .search-form select,
            .search-form input[type="text"] {
                width: 100%;
                padding: 5px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }

            .search-form button {
                padding: 10px 20px;
                background-color: #333;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            /* Estilos para a área de resultados da busca */
            .search-results {
                margin-top: 20px;
                border-top: 1px solid #ccc;
                padding-top: 20px;
            }

            .search-results h2 {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .search-results ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .search-results li {
                margin-bottom: 10px;
            }

            .tb_result {
                width: 100%;
                border-collapse: collapse;
            }

            .tb_result th, .tb_result td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            .tb_result th {
                background-color: #f2f2f2;
            }

            .sticky-header {
                position: sticky;
                top: 0;
                background-color: #f2f2f2;
            }

            .loading-message {
                text-align: center;
                padding: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="search-form">
                <h1>Realizar Busca</h1>
                <form method="GET">
                    <div class="form-group">
                        <label for="metricas">Métricas:</label>
                        <select id="metricas" name="metric">
                            <option value=""></option>
                            <option value="1">01. Métricas para anúncios</option>
                            <option value="2">02. Métricas para avaliação de resultados</option>
                            <option value="3">03. Metricas para canais próprios</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="topicos">Tópicos:</label>
                        <input type="text" id="topicos" name="topic">
                    </div>

                    <div class="form-group">
                        <label for="subtopicos">Subtópicos:</label>
                        <select id="subtopicos" name="subtopic">
                            <option value=""></option>
                            <option value="Ad Verification">Ad Verification</option>
                            <option value="Ads">Ads</option>
                            <option value="Atribuição">Atribuição</option>
                            <option value="Campanha">Campanha</option>
                            <option value="CRM">CRM</option>
                            <option value="Local">Local</option>
                            <option value="Marketplace">Marketplace</option>
                            <option value="Mobile Ads">Mobile Ads</option>
                            <option value="Pesquisa">Pesquisa</option>
                            <option value="Pesquisa Brand Lif">Pesquisa Brand Lif</option>
                            <option value="Pesquisa Brand Lift">Pesquisa Brand Lift</option>
                            <option value="Redes Sociais">Redes Sociais</option>
                            <option value="Search">Search</option>
                            <option value="Social Ads">Social Ads</option>
                            <option value="TV Digital">TV Digital</option>
                            <option value="Vídeo Digital">Vídeo Digital</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="conteudo">Conteúdo:</label>
                        <input type="text" id="conteudo" name="content">
                    </div>

                    <button type="submit">Buscar</button>
                </form>
            </div>

            <div class="search-results">
                <div class="loading-message"></div>
                <!-- Resultados da busca -->
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.search-form form').submit(function(event) {
                    event.preventDefault();

                    var formData = $(this).serialize();
                    var searchResults = $('.search-results');
                    // Exibir mensagem "Buscando..."
                    searchResults.text("Buscando...");

                    $.ajax({
                        url: "/api/v1/search",
                        type: "GET",
                        data: formData,
                        dataType: "json",
                        success: function(response) {
                            // Lógica para lidar com a resposta da busca
                            var searchResults = $('.search-results');
                            searchResults.empty(); // Limpar o conteúdo atual da div

                            // Criação da tabela
                            var table = $('<table class="tb_result">').addClass('tb_result');
                            var tableHead = $('<thead>').addClass('sticky-header');;
                            var tableBody = $('<tbody>');

                            // Criação do cabeçalho da tabela
                            var tableHeadRow = $('<tr>');
                            tableHeadRow.append($('<th>').text('Tópico'));
                            tableHeadRow.append($('<th>').text('Subtopico'));
                            tableHeadRow.append($('<th>').text('Conteúdo'));
                            // Continue adicionando mais colunas de acordo com a quantidade necessária

                            tableHead.append(tableHeadRow);
                            table.append(tableHead);

                            // Iteração sobre os resultados para criar as linhas da tabela
                            $.each(response.data, function(index, result) {
                                var tableRow = $('<tr>');
                                tableRow.append($('<td>').text(result.topic));
                                tableRow.append($('<td>').text(result.subtopic));
                                tableRow.append($('<td>').text(result.content));
                                // Continue adicionando mais colunas de acordo com a quantidade necessária

                                tableBody.append(tableRow);
                            });

                            table.append(tableBody);
                            searchResults.append(table);
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Lógica para lidar com erros
                            console.error(error);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
