<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class MatchReportController extends Controller
{
    public function generateReport(Request $request)
    {
        try {
            Log::info('Claude API Key', ['key' => substr(config('services.claude.api_key'), 0, 5) . '...']);

            $matchData = $request->input('match_statistics');
    
            // Create a summary of the match data
            $summary = $this->createMatchSummary($matchData);
    
            $prompt = "Generate a detailed match report based on the following PUBG match summary:\n" . $summary;
    
            $client = new Client([
                'base_uri' => 'https://api.anthropic.com/',
                'headers' => [
                    'x-api-key' => config('services.claude.api_key'),
                    'Content-Type' => 'application/json',
                    'anthropic-version' => '2023-06-01'
                ]
            ]);
    
            $response = $client->post('v1/messages', [
                'json' => [
                    'model' => 'claude-3-opus-20240229',
                    'max_tokens' => 1024,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ]
                ]
            ]);
    
            $responseBody = json_decode($response->getBody(), true);
    
            Log::info('Claude AI API Response', ['response' => $responseBody]);
    
            if ($response->getStatusCode() == 200 && isset($responseBody['content'][0]['text'])) {
                $generatedText = $responseBody['content'][0]['text'];
                return response()->json(['report' => $generatedText]);
            } else {
                Log::error('Claude AI API returned an error', [
                    'status_code' => $response->getStatusCode(),
                    'body' => $responseBody
                ]);
                return response()->json(['error' => 'Failed to generate report: Unexpected API response'], 500);
            }
        } catch (RequestException $e) {
            Log::error('RequestException', [
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ]);
            return response()->json(['error' => 'Failed to generate report: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to generate report: ' . $e->getMessage()], 500);
        }
    }
    
    private function createMatchSummary($matchData)
    {
        $summary = "Match ID: " . $matchData['data']['id'] . "\n";
        $summary .= "Date: " . $matchData['data']['attributes']['createdAt'] . "\n";
        $summary .= "Duration: " . $matchData['data']['attributes']['duration'] . " seconds\n";
        $summary .= "Game Mode: " . $matchData['data']['attributes']['gameMode'] . "\n";
        $summary .= "Map: " . $matchData['data']['attributes']['mapName'] . "\n";
    
        $summary .= "\nParticipants:\n";
        foreach ($matchData['included'] as $participant) {
            if ($participant['type'] === 'participant') {
                $summary .= "Player: " . $participant['attributes']['stats']['name'] . "\n";
                $summary .= "  Kills: " . $participant['attributes']['stats']['kills'] . "\n";
                $summary .= "  Damage: " . $participant['attributes']['stats']['damageDealt'] . "\n";
                $summary .= "  Survived Time: " . $participant['attributes']['stats']['timeSurvived'] . " seconds\n";
                $summary .= "  Win Place: " . $participant['attributes']['stats']['winPlace'] . "\n\n";
            }
        }
    
        return $summary;
    }
}
