<?php

namespace App\Services;

use App\Http\Clients\DeepSeekAPI;

class DeepSeekService
{
    public function generateCategoryDescriptionByName(string $categoryName)
    {
        $client = new DeepSeekAPI("Você é um especialista em publicidade e marketing digital. Seja criativo e profissional.");

        $response = $client->post("Gere uma frase promocional curta e de fácil leitura para descrição da categoria \"$categoryName\" de um site farmacéutico. Não use o nome da categoria diretamente na frase.");

        return $response['choices'][0]['message']['content'] ?? null;
    }
}
