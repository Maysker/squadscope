@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Match Statistics</h1>
    <div class="matches">
        @php
            // Convert $matchDetails array to a collection and then sort it
            $sortedMatches = collect($matchDetails)->sortByDesc('data.attributes.createdAt');
        @endphp
        @foreach ($sortedMatches as $matchDetail)
            <div class="match-card">
                <h2>Match Date: {{ $matchDetail['data']['attributes']['createdAt'] }}</h2>
                <p>Duration: {{ $matchDetail['data']['attributes']['duration'] }} seconds</p>
                <p>Game Mode: {{ $matchDetail['data']['attributes']['gameMode'] }}</p>
                <p>Map: {{ $matchDetail['data']['attributes']['mapName'] }}</p>
                <p>Match Type: {{ $matchDetail['data']['attributes']['matchType'] }}</p>
                <h3>Participants</h3>
                <div class="participants">
                    @foreach ($matchDetail['included'] as $participant)
                        @if ($participant['type'] === 'participant' && in_array($participant['attributes']['stats']['name'], $teamMembers))
                            <div class="participant-card">
                                <p>Player: {{ $participant['attributes']['stats']['name'] }}</p>
                                <div class="details-hidden">
                                    <p>Kills: {{ $participant['attributes']['stats']['kills'] }}</p>
                                    <p>Damage: {{ $participant['attributes']['stats']['damageDealt'] }}</p>
                                    <p>Assists: {{ $participant['attributes']['stats']['assists'] }}</p>
                                    <p>Revives: {{ $participant['attributes']['stats']['revives'] }}</p>
                                    <p>Heals: {{ $participant['attributes']['stats']['heals'] }}</p>
                                    <p>Boosts: {{ $participant['attributes']['stats']['boosts'] }}</p>
                                    <p>Longest Kill: {{ $participant['attributes']['stats']['longestKill'] }} meters</p>
                                    <p>Headshot Kills: {{ $participant['attributes']['stats']['headshotKills'] }}</p>
                                    <p>Ride Distance: {{ $participant['attributes']['stats']['rideDistance'] }} meters</p>
                                    <p>Walk Distance: {{ $participant['attributes']['stats']['walkDistance'] }} meters</p>
                                    <p>Survived Time: {{ $participant['attributes']['stats']['timeSurvived'] }} seconds</p>
                                    <p>Kill Place: {{ $participant['attributes']['stats']['killPlace'] }}</p>
                                    <p>Win Place: {{ $participant['attributes']['stats']['winPlace'] }}</p>
                                </div>
                                <button class="see-more-btn" onclick="toggleDetails(this)">See More</button>
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
    .details-hidden {
        display: none; /* Initially hide details */
    }
    .see-more-btn {
        margin-top: 10px;
        cursor: pointer;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
    }
</style>

<script>
    function toggleDetails(button) {
        const detailsDiv = button.previousElementSibling;
        if (detailsDiv.style.display === "none") {
            detailsDiv.style.display = "block";
            button.textContent = "See Less";
        } else {
            detailsDiv.style.display = "none";
            button.textContent = "See More";
        }
    }
</script>
@endsection
