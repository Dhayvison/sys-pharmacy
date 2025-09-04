<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeepSeekAPI
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $model;

    public function __construct(string $model = 'deepseek-chat')
    {
        $this->baseUrl = config('services.deepseek.base_url');
        $this->apiKey = config('services.deepseek.api_key');
        $this->model = $model;
    }

    public function post(array $messages, float $temperature = 1.0)
    {
        try {
            $url = $this->baseUrl . '/chat/completions';

            $response = Http::withToken($this->apiKey)
                ->post($url, [
                    'model' => $this->model,
                    'messages' => $messages,
                    'temperature' => $temperature,
                    'stream' => false,
                ]);


            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Erro na resposta do DeepSeek: ' . $response->body());
                throw new \Exception('Erro ao consultar DeepSeek API: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Erro ao consultar DeepSeek: ' . $e->getMessage());
            throw $e;
        }
    }

    // /**
    //  * Realiza uma chamada ao endpoint de chat completions do DeepSeek.
    //  *
    //  * @param array $messages — Array de mensagens (system, user, assistant)
    //  * @param string $model — Pode ser 'deepseek-chat' (V3) ou 'deepseek-reasoner' (R1)
    //  * @param bool $stream — Se true, habilita streaming da resposta
    //  * @return \Psr\Http\Message\StreamInterface|\Illuminate\Http\Client\Response
    //  */
    // public function chat(array $messages, string $model = 'deepseek-chat', bool $stream = false)
    // {
    //     $url = $this->baseUrl . '/chat/completions';

    //     $response = Http::withToken($this->apiKey)
    //         ->post($url, [
    //             'model' => $model,
    //             'messages' => $messages,
    //             'stream' => $stream,
    //         ]);

    //     return $stream ? $response->toPsrResponse()->getBody() : $response->json('choices.0.message.content');
    // }
}
