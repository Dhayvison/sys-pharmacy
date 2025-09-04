<?php

namespace App\Services;

use App\Http\Clients\DeepSeekAPI;
use App\Models\DTO\PromptDTO;

class DeepSeekService
{
    public function generate(PromptDTO $prompt, float $temperature = 1.0)
    {
        $client = new DeepSeekAPI();

        $response = $client->post(
            [
                [
                    'role'    => 'system',
                    'content' => $prompt->getPersona() . ' ' .  $prompt->getTone(),
                ],
                [
                    'role'    => 'user',
                    'content' => $prompt->getObjective() . ' ' . $prompt->getContext() . ' ' . $prompt->getFormat(),
                ],
            ],
            $temperature
        );

        return $response['choices'][0]['message']['content'] ?? null;
    }
}
