<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GitHub Profile</title>
</head>
<body>
    <h1>GitHub Profile</h1>
    <img src="{{ $user->avatar }}" alt="Profile Picture" width="100">
    <p><strong>Username:</strong> {{ $user->nickname }}</p>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Profile URL:</strong> <a href="{{ $user->user['html_url'] }}" target="_blank">View GitHub Profile</a></p>

    <!-- Add more info like public repositories in future steps -->

    <h2>Public Repositories</h2>
    <ul>
        @foreach ($repositories as $repo)
            <li>
                <strong>{{ $repo->name }}</strong><br>
                {{ $repo->description }}<br>
                Stars: {{ $repo->stargazers_count }}, Forks: {{ $repo->forks_count }}<br>
                Language: {{ $repo->language }}
            </li>
        @endforeach
    </ul>

</body>
</html>
