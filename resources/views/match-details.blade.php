@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Match Statistics</h1>
    <div class="matches">
        @foreach ($matchDetails as $matchDetail)
            <div class="match-card">
                <h2>Match ID: {{ $matchDetail['data']['id'] }}</h2>
                <p>Duration: {{ $matchDetail['data']['attributes']['duration'] }} seconds</p>
                <p>Game Mode: {{ $matchDetail['data']['attributes']['gameMode'] }}</p>
                <p>Map: {{ $matchDetail['data']['attributes']['mapName'] }}</p>
                <h3>Participants</h3>
                <div class="participants">
                    @foreach ($matchDetail['included'] as $participant)
                        @if ($participant['type'] === 'participant' && in_array($participant['attributes']['stats']['name'], $teamMembers))
                            <div class="participant-card">
                                <p>Player: {{ $participant['attributes']['stats']['name'] }}</p>
                                <p>Kills: {{ $participant['attributes']['stats']['kills'] }}</p>
                                <p>Damage: {{ $participant['attributes']['stats']['damageDealt'] }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <div class="pagination">
        {{ $matches->links() }}
    </div>
</div>

<style>
    .matches {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .match-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 16px;
        width: calc(33.333% - 20px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .participants {
        margin-top: 10px;
    }
    .participant-card {
        border-top: 1px solid #eee;
        padding-top: 10px;
        margin-top: 10px;
    }
    .pagination {
        margin-top: 20px;
        text-align: center;
    }
    .pagination .page-link {
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-decoration: none;
    }
    .pagination .page-link:hover {
        background-color: #f0f0f0;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
</style>
@endsection
