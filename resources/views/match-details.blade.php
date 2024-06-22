@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title">Match Statistics</h1>
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
                                    <button id="showHeatmapBtn" class="heatmap-btn">Show Heatmap</button>
                                </div>
                            </div>

                        @endif
                    @endforeach
                </div>
                <button class="see-more-btn" onclick="toggleDetails(this)">Show Details</button>
            </div>
        @endforeach
    </div>
    <div class="pagination">
        {{ $matches->links() }}
    </div>
    <div id="heatmapModal" class="modal">
        <div class="modal-content">
            <span id="closeHeatmapBtn">&times;</span>
            <h2>Heatmap</h2>
            <!-- Heatmap will be displayed here -->
        </div>
    </div>
    
</div>

<style>
    .container {
        background-color: #595858;
    }

    .page-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 36px;
        text-align: center;
        color: #ffc107;
        margin-bottom: 30px;
    }
    .matches {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    .match-card {
        background: rgba(0, 0, 0, 0.8);
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        padding: 20px;
        width: calc(33.333% - 20px);
        margin-bottom: 20px;
    }
    .match-card h2, .match-card h3 {
        color: #ffc107;
    }
    .match-card p {
        color: #fff;
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
        background-color: #ffc107;
        color: rgb(10, 0, 0);
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
    }
    .see-more-btn:hover {
        background-color: #e6b006;
    }
    .heatmap-btn {
        margin-top: 10px;
        cursor: pointer;
        background-color: #ffc107;
        color: rgb(10, 0, 0);
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
    }
    .heatmap-btn:hover {
        background-color: #e6b006;
    }
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
    }

</style>

<script>
    function toggleDetails(button) {
        const participantCards = button.previousElementSibling.querySelectorAll('.details-hidden');
        const isDetailsVisible = Array.from(participantCards).some(detailsDiv => detailsDiv.style.display === "block");
        participantCards.forEach(detailsDiv => {
            detailsDiv.style.display = isDetailsVisible ? "none" : "block";
        });
        button.textContent = isDetailsVisible ? "Show Details" : "Hide Details";
    }
    document.getElementById("showHeatmapBtn").onclick = function() {
        document.getElementById("heatmapModal").style.display = "block";
    }

    document.getElementById("closeHeatmapBtn").onclick = function() {
        document.getElementById("heatmapModal").style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == document.getElementById("heatmapModal")) {
            document.getElementById("heatmapModal").style.display = "none";
        }
    }

</script>
@endsection
