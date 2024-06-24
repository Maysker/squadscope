@extends('layouts.app')

@section('content')
    @php
        $teamId = optional(auth()->user()->teams()->first())->id;
    @endphp
    <div class="bg-white shadow mb-4">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <nav class="flex space-x-4">
            <a href="{{ route('team.management') }}" class="text-gray-600 hover:text-gray-800 px-3 py-2 rounded-md text-sm font-medium">Team</a>
            @if ($teamId)
                <a href="{{ route('team.statistics', ['teamId' => $teamId]) }}" class="text-gray-600 hover:text-gray-800 px-3 py-2 rounded-md text-sm font-medium">Statistics</a>
                <a href="{{ route('team.matches', ['teamId' => $teamId]) }}" class="text-gray-600 hover:text-gray-800 px-3 py-2 rounded-md text-sm font-medium">Matches</a>
            @endif
        </nav>
        </div>
    </div>
    <div class="row team-management-container">
        <div class="team-form-container">
            <div class="team-form">
                <h2>
                    <img src="https://www.svgrepo.com/show/303582/pubg-1-logo.svg" class="team-form-icon" alt="Check Your Team Icon">
                    Create Your Squad
                </h2>
                
                <div class="team-name-input">
                    <input type="text" id="team-name" placeholder="Team name" required>
                </div>
                
                @for ($i = 1; $i <= 4; $i++)
                    <div class="player-input">
                        <input type="text" id="player-name-{{ $i }}" placeholder="Player name">
                        <button id="add-player-{{ $i }}">Add</button>
                    </div>
                @endfor
                
                <button class="save-button" id="save-team">Save Team</button>
                <ul id="players-list"></ul>
            </div>
        </div>

        <div class="your-teams-container">
            <div class="your-teams">
                <h2>
                    <img src="https://www.svgrepo.com/show/303582/pubg-1-logo.svg" class="team-form-icon" alt="Your Squads Icon">Your Squads</h2>
                <ul>
                    @foreach($userTeams as $team)
                    <li>
                        <strong>{{ $team->name }}</strong>
                        <ul>
                            @foreach($team->players as $player)
                            <li>{{ $player->name }}</li>
                            @endforeach
                        </ul>
                        <!-- Button to see statistics -->
                        <a href="{{ route('team.matches', $team->id) }}" class="statistics-button">See Match Details</a>
        
                        <!-- Delete form -->
                        <form action="{{ route('teams.destroy', $team) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Delete Squad</button>
                        </form>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Document loaded");

            const addButtons = document.querySelectorAll('button[id^="add-player"]');
            const playerNames = [];
            const saveButton = document.getElementById('save-team');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log("CSRF Token:", csrfToken);  // Проверка токена

            addButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log("Add button clicked");

                    const index = button.id.split('-').pop();
                    const input = document.getElementById(`player-name-${index}`);
                    const playerName = input.value.trim();

                    if (playerName === '') {
                        console.log("Player name is empty");
                        return;
                    }

                    fetch('{{ route('team.checkPlayers') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ playerNames: [playerName] })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.players && data.players[playerName]) {
                            const player = data.players[playerName];
                            player.matches = data.commonMatches;
                            addPlayerToList(player, index);
                            playerNames.push(player);
                            button.disabled = true;
                        } else {
                            console.log("Player data not found in response");
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });

            saveButton.addEventListener('click', function(e) {
                e.preventDefault();
                console.log("Save button clicked");

                const teamName = document.getElementById('team-name').value.trim();

                if (teamName === '' || playerNames.length < 2) {
                    alert('Please enter a team name and add at least two players.');
                    return;
                }

                fetch('{{ route('team.save') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ teamName, players: playerNames })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Team saved successfully!');
                    } else {
                        alert('Error saving team.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });

            function addPlayerToList(player, index) {
                console.log("Adding player to list", player);

                const listElement = document.createElement('li');
                listElement.innerHTML = `
                    <div class="player-details">
                        <strong>${player.name}</strong> (${player.shardId})
                        <button class="remove-player" data-index="${index}">Remove</button>
                    </div>
                `;
                document.getElementById('players-list').appendChild(listElement);

                listElement.querySelector('.remove-player').addEventListener('click', function() {
                    removePlayerFromList(this);
                });
            }

            function removePlayerFromList(button) {
                const index = button.getAttribute('data-index');
                const listItem = button.closest('li');
                listItem.remove();
                document.getElementById(`add-player-${index}`).disabled = false;
                document.getElementById(`player-name-${index}`).value = '';
                playerNames.splice(index - 1, 1);
            }
        });
    </script>
@endsection
