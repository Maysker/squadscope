<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Team;
use App\Models\Player;
use App\Models\PlayerMatch;

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
            'verify' => storage_path('cacert.pem')
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
                continue;
            }

            $playerInfo = [
                'id' => $data['data'][0]['id'],
                'name' => $data['data'][0]['attributes']['name'],
                'shardId' => $data['data'][0]['attributes']['shardId'],
            ];
            $playerDetails[$name] = $playerInfo;

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

    public function saveTeam(Request $request)
    {
        $validated = $request->validate([
            'teamName' => 'required|string|max:255',
            'players' => 'required|array|min:2',
            'players.*.id' => 'required|string',
            'players.*.name' => 'required|string',
            'players.*.shardId' => 'required|string',
            'players.*.matches' => 'required|array',
            'players.*.matches.*' => 'required|string',
        ]);

        // Creating a team
        $team = Team::create([
            'name' => $validated['teamName'],
            'owner_id' => auth()->id(),
        ]);

        // Adding Players and their Matches to a Team
        foreach ($validated['players'] as $player) {
            $newPlayer = Player::create([
                'name' => $player['name'],
                'team_id' => $team->id,
            ]);

            foreach ($player['matches'] as $matchId) {
                PlayerMatch::create([
                    'player_id' => $newPlayer->id,
                    'match_id' => $matchId,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
