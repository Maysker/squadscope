<x-app-layout>
    <!-- Navigation Panel -->
    @php
        $teamId = optional(auth()->user()->teams()->first())->id;
    @endphp
    <div class="bg-white shadow mb-4">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <nav class="flex space-x-4">
            <a href="{{ route('team.management') }}" class="nav-link-custom px-3 py-2 rounded-md text-sm font-medium">Team</a>
            @if ($teamId)
                <a href="{{ route('team.statistics', ['teamId' => $teamId]) }}" class="nav-link-custom px-3 py-2 rounded-md text-sm font-medium">Statistics</a>
                <a href="{{ route('team.matches', ['teamId' => $teamId]) }}" class="nav-link-custom px-3 py-2 rounded-md text-sm font-medium">Matches</a>
            @endif
        </nav>
    </div>
    </div>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12 custom-container">
    @if (auth()->user()->teams->isEmpty())
        <div class="shadow-sm sm:rounded-lg p-6">
            <p class="mt-4">
                To start using the application, first create a team. Go to the <a href="{{ route('team.management') }}" class="text-blue-500 underline">Team Management</a> page.
            </p>
        </div>
    @endif
    <div class="shadow-sm sm:rounded-lg p-6 mt-6">
        <h2 class="text-xl font-semibold">Welcome to Squad Scope!</h2>
        <p class="mt-4">
            With our squad statistics and analytics app, dive deep into match analysis, individual and team stats, and tactical tools to craft winning strategies. Assess each player's performance and strategize with your team. Increase your chances of victory and become PUBG champions with our app!
        </p>
        <p class="text-white-custom mt-4">
            This application was created as a graduation thesis by students of the Full Stack Developer course at Syntra PXL. Developers: <a href="https://github.com/Maysker" class="text-link-custom">Adam Gazdiev</a> and <a href="https://github.com/AntonioMaggi" class="text-link-custom">Antonio Maggi</a>.
        </p>
    </div>
</div>

</x-app-layout>
