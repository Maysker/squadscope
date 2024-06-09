<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Squad Scope</title>
    @vite(['resources/css/welcome.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Squad Scope">
            
        </div>
        <nav>
            <ul>
                <li><a href="#login">LOGIN</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="left-section">
            <div class="content-wrapper">
                
                <div class="flight-board-container">
                    <div class="flight-board">
                        <h2><img src="https://www.svgrepo.com/show/2018/airport-departures.svg" class="departure-icon" alt="Departures Icon"> Departures</h2>
                        <div class="flight-headers">
                            <div class="flight-number">Flight</div>
                            <div class="airline">Airline</div>
                            <div class="destination">Destination</div>
                            <div class="time">Time</div>
                            <div class="check-in">Check-in</div>
                            <div class="gate">Gate</div>
                        </div>
                        <div class="flight">
                            <div class="flight-number">CH123</div>
                            <div class="airline">ChickenAir</div>
                            <div class="destination">Pochinki</div>
                            <div class="time">12:00</div>
                            <div class="check-in"><marquee behavior="scroll" direction="left" scrollamount="2">Check-in A1</marquee></div>
                            <div class="gate">Gate 1</div>
                        </div>
                        <div class="flight">
                            <div class="flight-number">CH124</div>
                            <div class="airline">ChickenAir</div>
                            <div class="destination">Gatka</div>
                            <div class="time">12:30</div>
                            <div class="check-in"><marquee behavior="scroll" direction="left" scrollamount="2">Check-in B2</marquee></div>
                            <div class="gate">Gate 2</div>
                        </div>
                        <div class="flight">
                            <div class="flight-number">CH125</div>
                            <div class="airline">ChickenAir</div>
                            <div class="destination">School</div>
                            <div class="time">13:00</div>
                            <div class="check-in"><marquee behavior="scroll" direction="left" scrollamount="2">Check-in C3</marquee></div>
                            <div class="gate">Gate 3</div>
                        </div>
                        <div class="flight">
                            <div class="flight-number">CH126</div>
                            <div class="airline">ChickenAir</div>
                            <div class="destination">Rozhok</div>
                            <div class="time">13:30</div>
                            <div class="check-in"><marquee behavior="scroll" direction="left" scrollamount="2">Check-in D4</marquee></div>
                            <div class="gate">Gate 4</div>
                        </div>
                        <div class="flight">
                            <div class="flight-number">CH127</div>
                            <div class="airline">ChickenAir</div>
                            <div class="destination">Mylta</div>
                            <div class="time">14:00</div>
                            <div class="check-in"><marquee behavior="scroll" direction="left" scrollamount="2">Check-in E5</marquee></div>
                            <div class="gate">Gate 5</div>
                        </div>
                        <div class="flight">
                            <div class="flight-number">CH128</div>
                            <div class="airline">ChickenAir</div>
                            <div class="destination">Novorep</div>
                            <div class="time">14:30</div>
                            <div class="check-in"><marquee behavior="scroll" direction="left" scrollamount="2">Check-in F6</marquee></div>
                            <div class="gate">Gate 6</div>
                        </div>
                        <div class="flight">
                            <div class="flight-number">CH129</div>
                            <div class="airline">ChickenAir</div>
                            <div class="destination">Primorsk</div>
                            <div class="time">15:00</div>
                            <div class="check-in"><marquee behavior="scroll" direction="left" scrollamount="2">Check-in G7</marquee></div>
                            <div class="gate">Gate 7</div>
                        </div>
                        <div class="flight">
                            <div class="flight-number">CH130</div>
                            <div class="airline">ChickenAir</div>
                            <div class="destination">Stalber</div>
                            <div class="time">15:30</div>
                            <div class="check-in"><marquee behavior="scroll" direction="left" scrollamount="2">Check-in H8</marquee></div>
                            <div class="gate">Gate 8</div>
                        </div>
                        <div class="flight">
                            <div class="flight-number">CH131</div>
                            <div class="airline">ChickenAir</div>
                            <div class="destination">Severny</div>
                            <div class="time">16:00</div>
                            <div class="check-in"><marquee behavior="scroll" direction="left" scrollamount="2">Check-in I9</marquee></div>
                            <div class="gate">Gate 9</div>
                        </div>
                        <div class="flight">
                            <div class="flight-number">CH132</div>
                            <div class="airline">ChickenAir</div>
                            <div class="destination">Lipovka</div>
                            <div class="time">16:30</div>
                            <div class="check-in"><marquee behavior="scroll" direction="left" scrollamount="2">Check-in J10</marquee></div>
                            <div class="gate">Gate 10</div>
                        </div>                        
                    </div>
                </div>
                <div class="team-form-container">
                    <div class="team-form">
                        <h2><img src="https://www.svgrepo.com/show/303582/pubg-1-logo.svg" class="team-form-icon" alt="Check Your Team Icon"> Check Your Team</h2>
                        <div class="player-input">
                            <input type="text" id="player-name-1" placeholder="Player name">
                            <button id="add-player-1">Add</button>
                        </div>
                        <div class="player-input">
                            <input type="text" id="player-name-2" placeholder="Player name">
                            <button id="add-player-2">Add</button>
                        </div>
                        <div class="player-input">
                            <input type="text" id="player-name-3" placeholder="Player name">
                            <button id="add-player-3">Add</button>
                        </div>
                        <div class="player-input">
                            <input type="text" id="player-name-4" placeholder="Player name">
                            <button id="add-player-4">Add</button>
                        </div>
                        <button class="apply-button">Apply</button>
                        <ul id="players-list"></ul>
                    </div>
                </div>
            </div>
            <img src="{{asset ('images/soldier.png') }}" alt="Hero" class="character-image">
            
        </div>
        <div class="right-section">
            <div class="headline">
                Squad Statistics
            </div>
            <div class="description">
                <p>With our squad statistics and analytics app, dive deep into match analysis, individual and team stats, and tactical tools to craft winning strategies. Assess each player's performance, study heatmap movements, and strategize with your team. Increase your chances of victory and become PUBG champions with our app!</p>
            </div>
             <div class="platform-icons">
                <a href="https://store.steampowered.com/" class="platform-icon">
                    <span class="base-svg"><img src="https://www.svgrepo.com/show/342255/steam.svg" alt="Steam"></span>
                    <span class="base-button_text">Steam</span>
                </a>
                <a href="https://www.epicgames.com" class="platform-icon">
                    <span class="base-svg"><img src="https://www.svgrepo.com/show/341792/epic-games.svg" alt="Epic Games"></span>
                    <span class="base-button_text">Epic Games</span>
                </a>
                <a href="https://www.playstation.com" class="platform-icon">
                    <span class="base-svg"><img src="https://www.svgrepo.com/show/473754/playstation.svg" alt="PlayStation"></span>
                    <span class="base-button_text">PlayStation</span>
                </a>
                <a href="https://www.xbox.com" class="platform-icon">
                    <span class="base-svg"><img src="https://www.svgrepo.com/show/473838/xbox.svg" alt="Xbox"></span>
                    <span class="base-button_text">Xbox</span>
                </a>
            </div>
        </div>

    </main>
    
    <script>
        document.addEventListener('mousemove', function(e) {
            const characterImage = document.querySelector('.character-image');
            const moveX = (e.clientX - window.innerWidth / 2) * 0.02;
            const moveY = (e.clientY - window.innerHeight / 2) * 0.02;

            characterImage.style.transform = `translate(-1%, 0) translate(${moveX}px, ${moveY}px)`;
        });

        document.addEventListener('DOMContentLoaded', function() {
            const addButtons = document.querySelectorAll('button[id^="add-player"]');
        addButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const index = button.id.split('-').pop();
            const input = document.getElementById(`player-name-${index}`);
            const playerName = input.value.trim();

            if (playerName === '') return;

            fetch('/check-players', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ playerNames: [playerName] })
            })
            .then(response => response.json())
            .then(data => {
                if (data.players && data.players[playerName]) {
                    const player = data.players[playerName];
                    addPlayerToList(player, index);
                    button.disabled = true;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    function addPlayerToList(player, index) {
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
    }
});
     
    </script>
</body>
</html>
