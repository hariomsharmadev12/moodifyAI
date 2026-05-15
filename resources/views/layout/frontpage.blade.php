@php
    use App\Models\User;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="icon" type="image/svg+xml">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cdefs%3E%3ClinearGradient id='grad' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23f7cfb0'/%3E%3Cstop offset='100%25' stop-color='%23e87a4a'/%3E%3C/linearGradient%3E%3Cfilter id='glow' x='-50%25' y='-50%25' width='200%25' height='200%25'%3E%3CfeGaussianBlur stdDeviation='2.5' result='blur'/%3E%3CfeMerge%3E%3CfeMergeNode in='blur'/%3E%3CfeMergeNode in='SourceGraphic'/%3E%3C/feMerge%3E%3C/filter%3E%3C/defs%3E%3Ctext x='50' y='72' font-size='60' fill='url(%23grad)' filter='url(%23glow)' text-anchor='middle' font-family='Arial' font-weight='bold'%3E♪%3C/text%3E%3Ctext x='28' y='48' font-size='22' fill='%23f5bc91' filter='url(%23glow)' text-anchor='middle' font-family='Arial'%3E♫%3C/text%3E%3Ctext x='72' y='85' font-size='16' fill='%23ffd4a8' opacity='0.8'%3E♩%3C/text%3E%3C/svg%3E">
    <title>Moodify · AI Mood Song Recommender</title>
    <!-- Google Fonts & smooth fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 (free icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/frontpage.css') }}">
</head>
<body>

    <div class="bg-soft-nature"></div>
    <div class="floating-flower" style="width: 250px; height: 250px; top: -50px; left: -70px; background: #ffe1cf; opacity:0.3;"></div>
    <div class="floating-flower" style="width: 350px; height: 350px; bottom: -80px; right: -100px; background: #d9e6cf; opacity:0.2; border-radius: 70% 30% 60% 40%;"></div>
    <div class="floating-flower" style="width: 180px; height: 180px; top: 30%; right: 5%; background: #ffd9c2; opacity:0.25;"></div>

    <!-- Header with Login & Sign up buttons at right corner -->
    <div class="navbar">
        <div class="auth-buttons">
            <a href="{{ route('login') }}" style="text-decoration: none;">
                <button class="btn-login" id="loginBtn"><i class="fas fa-heart" style="margin-right: 8px;"></i> Log in</button>
            </a>
            <a href="{{ route('signup') }}" style="text-decoration: none;">
                <button class="btn-sign" id="signupBtn"><i class="fas fa-user-plus" style="margin-right: 6px;"></i> Sign up</button>
            </a>
        </div>
    </div>

    <main class="hero">
        <div class="title-badge">
            <i class="fas fa-music"></i> AI Mood DJ · feel the melody
        </div>
        <div class="title-badge">
            <i class="fas fa-users"></i> {{ $users }} user(s) and counting
        </div>
        <h1>music from your <br>✨ aura & smile ✨</h1>
        <div class="subhead">Upload a photo & our AI reads your emotion — get a playlist that hugs your heart ❤️</div>

        <!-- Spotify & JioSaavn images / icons with happy vibe -->
        <div class="platform-row">
            <div class="platform-card">
                <i class="fab fa-spotify spotify"></i>
                <span>Spotify</span>
            </div>
            <div class="platform-card">
                <i class="fas fa-music jiosaavn"></i>
                <span>JioSaavn</span>
            </div>
            <div class="platform-card">
                <i class="fab fa-apple"></i>
                <span>Apple Music</span>
            </div>
        </div>

        <!-- K-Drama couple + GF/BF happy imagery (sweet kdrama feel) -->
        <div class="kdrama-love">
            <div class="kdrama-avatars">
                <div class="avatar-icon">🌸</div>
                <div class="avatar-icon">🐻‍❄️</div>
            </div>
            <i class="fas fa-heart heart-icon"></i>
            <div class="kdrama-avatars">
                <div class="avatar-icon">🧸</div>
                <div class="avatar-icon">🍒</div>
            </div>
            <div class="kdrama-text">✨ Our mood AI feels like a Dreamy moment ✨<br> "Your smile, your song" </div>
        </div>




        <!-- dynamic results -->

    </main>

    <footer>
        🌸 let the music bloom like spring 🌸 — 2026
    </footer>

</body>
</html>
