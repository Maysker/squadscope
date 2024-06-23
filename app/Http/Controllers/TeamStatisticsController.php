<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use App\Models\Team;

class TeamStatisticsController extends Controller
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
            'verify' => storage_path('cacert.pem')  // Использование локального сертификата
        ]);
    }

    public function getTeamStatistics($teamId)
    {
        $team = Team::with('players.matches')->findOrFail($teamId);
        $matchIds = $this->findCommonMatches($team);

        $teamPlayers = $team->players->pluck('name')->toArray(); // Используем имена игроков

        $matchData = [];
        foreach ($matchIds as $matchId) {
            $cacheKey = "match_data_{$matchId}";
            $data = Cache::get($cacheKey);
            if (!$data) {
                $matchDataFromAPI = $this->fetchMatchData($matchId);
                $data = $matchDataFromAPI['data'];
                Cache::put($cacheKey, $data, now()->addMinutes(10));
            }
            $matchData[] = $data;
        }

        $teamStatistics = $this->aggregateTeamStatistics($matchData, $teamPlayers);
        $playerStatistics = $this->extractPlayerData($matchData, $teamPlayers);

        return view('statistics', compact('team', 'teamStatistics', 'playerStatistics'));
    }

    private function fetchMatchData($matchId)
    {
        $response = $this->client->request('GET', "shards/steam/matches/{$matchId}");
        $matchData = json_decode($response->getBody()->getContents(), true);

        // Найти URL телеметрии
        $telemetryUrl = '';
        foreach ($matchData['included'] as $item) {
            if ($item['type'] === 'asset' && isset($item['attributes']['URL'])) {
                $telemetryUrl = $item['attributes']['URL'];
                break;
            }
        }

        return ['data' => $matchData, 'telemetry_url' => $telemetryUrl];
    }

    private function findCommonMatches($team)
    {
        $playerMatches = [];

        foreach ($team->players as $player) {
            $matches = $player->matches->pluck('match_id')->toArray();
            $playerMatches[] = $matches;
        }

        if (empty($playerMatches)) {
            return [];
        }

        $firstPlayerMatches = array_shift($playerMatches);
        foreach ($playerMatches as $matches) {
            $firstPlayerMatches = array_intersect($firstPlayerMatches, $matches);
        }

        return array_slice($firstPlayerMatches, 0, 3); // Ограничиваем до 3 матчей
    }

    private function aggregateTeamStatistics($matchData, $teamPlayers)
    {
        $totalKills = 0;
        $totalDamage = 0;
        $totalSurvivalTime = 0;
        $totalAssists = 0;
        $totalHeals = 0;
        $totalWalkDistance = 0;
        $totalRideDistance = 0;

        foreach ($matchData as $data) {
            foreach ($data['included'] as $participant) {
                if ($participant['type'] === 'participant') {
                    $stats = $participant['attributes']['stats'];
                    $playerName = $stats['name'];
                    if (in_array($playerName, $teamPlayers)) {
                        $totalKills += $stats['kills'];
                        $totalDamage += $stats['damageDealt'];
                        $totalSurvivalTime += $stats['timeSurvived'];
                        $totalAssists += $stats['assists'];
                        $totalHeals += $stats['heals'];
                        $totalWalkDistance += $stats['walkDistance'];
                        $totalRideDistance += $stats['rideDistance'];
                    }
                }
            }
        }

        return [
            'total_kills' => $totalKills,
            'total_damage' => $totalDamage,
            'total_survival_time' => $totalSurvivalTime,
            'total_assists' => $totalAssists,
            'total_heals' => $totalHeals,
            'total_walk_distance' => $totalWalkDistance,
            'total_ride_distance' => $totalRideDistance,
        ];
    }

    private function extractPlayerData($matchData, $teamPlayers)
    {
        $playerStatistics = [];

        foreach ($matchData as $data) {
            foreach ($data['included'] as $participant) {
                if ($participant['type'] === 'participant') {
                    $stats = $participant['attributes']['stats'];
                    $playerName = $stats['name'];

                    if (in_array($playerName, $teamPlayers)) {
                        if (!isset($playerStatistics[$playerName])) {
                            $playerStatistics[$playerName] = [
                                'kills' => 0,
                                'damageDealt' => 0,
                                'timeSurvived' => 0,
                                'assists' => 0,
                                'heals' => 0,
                                'walkDistance' => 0,
                                'rideDistance' => 0,
                            ];
                        }

                        $playerStatistics[$playerName]['kills'] += $stats['kills'];
                        $playerStatistics[$playerName]['damageDealt'] += $stats['damageDealt'];
                        $playerStatistics[$playerName]['timeSurvived'] += $stats['timeSurvived'];
                        $playerStatistics[$playerName]['assists'] += $stats['assists'];
                        $playerStatistics[$playerName]['heals'] += $stats['heals'];
                        $playerStatistics[$playerName]['walkDistance'] += $stats['walkDistance'];
                        $playerStatistics[$playerName]['rideDistance'] += $stats['rideDistance'];
                    }
                }
            }
        }

        return $playerStatistics;
    }
}
