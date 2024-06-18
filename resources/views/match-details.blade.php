@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Match Statistics</h1>
    <div class="matches">
        @foreach ($matchDetails as $matchDetail)
            <div class="match-card">
                <div class="match-header">
                    <h2>Match ID: {{ $matchDetail['data']['id'] }}</h2>
                </div>
                <div class="match-body">
                    <p><strong>Duration:</strong> {{ $matchDetail['data']['attributes']['duration'] }} seconds</p>
                    <p><strong>Game Mode:</strong> {{ $matchDetail['data']['attributes']['gameMode'] }}</p>
                    <p><strong>Map:</strong> {{ $matchDetail['data']['attributes']['mapName'] }}</p>
                </div>
                <div class="participants">
                    <h3>Participants</h3>
                    @foreach ($matchDetail['included'] as $participant)
                        @if ($participant['type'] === 'participant' && in_array($participant['attributes']['stats']['name'], $teamPlayers))
                            <div class="participant-card">
                                <p><strong>Player:</strong> {{ $participant['attributes']['stats']['name'] }}</p>
                                <p><strong>Kills:</strong> {{ $participant['attributes']['stats']['kills'] }}</p>
                                <p><strong>Damage:</strong> {{ $participant['attributes']['stats']['damageDealt'] }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.matches {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.match-card {
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    flex: 1 1 calc(50% - 40px); /* Two cards per row */
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.match-header {
    border-bottom: 1px solid #ddd;
    margin-bottom: 10px;
}

.match-body, .participants {
    margin-bottom: 10px;
}

.participant-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 10px;
}
</style>
