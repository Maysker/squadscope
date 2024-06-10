<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.pubg.com/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.pubg.api_key'),
                'Accept' => 'application/vnd.api+json'
            ],
            'verify' => storage_path('cacert.pem')  // Путь к файлу сертификата
        ]);
    }

    public function checkPlayers(Request $request)
    {
        $playerNames = $request->input('playerNames', []);
        if (empty($playerNames)) {
            return response()->json(['error' => 'No player names provided'], 400);
        }

        $playerDetails = [];
        $playerMatches = [];

        foreach ($playerNames as $name) {
            $response = $this->client->request('GET', 'shards/steam/players', [
                'query' => ['filter[playerNames]' => $name]
            ]);

            if ($response->getStatusCode() != 200) {
                return response()->json(['error' => 'Failed to retrieve data for player: ' . $name], 500);
            }

            $data = json_decode($response->getBody()->getContents(), true);
            if (empty($data['data'])) {
                continue;  // Пропуск если нет данных
            }

            // Сохранение информации о игроке
            $playerInfo = [
                'id' => $data['data'][0]['id'],
                'name' => $data['data'][0]['attributes']['name'],
                'shardId' => $data['data'][0]['attributes']['shardId'],
                // Добавьте другие необходимые атрибуты
            ];
            $playerDetails[$name] = $playerInfo;

            // Сохранение ID матчей
            $playerMatches[$name] = array_column($data['data'][0]['relationships']['matches']['data'], 'id');
        }

        $commonMatches = $this->findCommonMatches($playerMatches);

        return response()->json([
            'players' => $playerDetails,
            'commonMatches' => $commonMatches
        ]);
    }

    private function findCommonMatches($playerMatches)
    {
        if (empty($playerMatches)) {
            return [];
        }

        $firstPlayerMatches = array_shift($playerMatches);
        foreach ($playerMatches as $matches) {
            $firstPlayerMatches = array_intersect($firstPlayerMatches, $matches);
        }
        return $firstPlayerMatches;
    }
}
