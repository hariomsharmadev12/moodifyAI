@php
use App\Models\User;
$user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cdefs%3E%3ClinearGradient id='grad' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23f7cfb0'/%3E%3Cstop offset='100%25' stop-color='%23e87a4a'/%3E%3C/linearGradient%3E%3Cfilter id='glow' x='-50%25' y='-50%25' width='200%25' height='200%25'%3E%3CfeGaussianBlur stdDeviation='2.5' result='blur'/%3E%3CfeMerge%3E%3CfeMergeNode in='blur'/%3E%3CfeMergeNode in='SourceGraphic'/%3E%3C/feMerge%3E%3C/filter%3E%3C/defs%3E%3Ctext x='50' y='72' font-size='60' fill='url(%23grad)' filter='url(%23glow)' text-anchor='middle' font-family='Arial' font-weight='bold'%3E♪%3C/text%3E%3Ctext x='28' y='48' font-size='22' fill='%23f5bc91' filter='url(%23glow)' text-anchor='middle' font-family='Arial'%3E♫%3C/text%3E%3Ctext x='72' y='85' font-size='16' fill='%23ffd4a8' opacity='0.8'%3E♩%3C/text%3E%3C/svg%3E">


    <title>Moodify · cozy dashboard | pure HTML/CSS</title>
    <!-- Google Fonts + soft aesthetic -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="logo-area">
                <div class="logo-icon" style="background: transparent; box-shadow: none; width: auto; height: auto;">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 120'%3E%3Cdefs%3E%3ClinearGradient id='grad' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23f7cfb0'/%3E%3Cstop offset='100%25' stop-color='%23e87a4a'/%3E%3C/linearGradient%3E%3Cfilter id='glow' x='-50%25' y='-50%25' width='200%25' height='200%25'%3E%3CfeGaussianBlur stdDeviation='3.5' result='blur'/%3E%3CfeMerge%3E%3CfeMergeNode in='blur'/%3E%3CfeMergeNode in='SourceGraphic'/%3E%3C/feMerge%3E%3C/filter%3E%3C/defs%3E%3Ctext x='60' y='82' font-size='72' fill='url(%23grad)' filter='url(%23glow)' text-anchor='middle' font-family='Arial' font-weight='bold'%3E♪%3C/text%3E%3Ctext x='30' y='48' font-size='26' fill='%23f5bc91' filter='url(%23glow)' text-anchor='middle' font-family='Arial'%3E♫%3C/text%3E%3Ctext x='88' y='98' font-size='20' fill='%23ffd4a8' opacity='0.8'%3E♩%3C/text%3E%3C/svg%3E" width="55" height="55" alt="Moodify" style="border-radius: 0;">
                </div>
                <div class="logo-text">Moodify</div>
            </div>
            <div class="nav-menu">
                <div class="nav-item active" onclick="showSection('home')"><i class="fas fa-home"></i> Home</div>
                <div class="nav-item" onclick="showFavorites()"><i class="fas fa-heart"></i> Favorites <span id="favCount" class="favorites-count">0</span></div>
                <div class="nav-item"><i class="fas fa-music"></i> Playlists <span style="font-size: 0.9rem; color: #d8aa88;">coming soon</span></div>
                <div class="nav-item"><i class="fas fa-chart-line"></i> Mood History <span style="font-size: 0.9rem; color: #d8aa88;">coming soon</span></div>
                <div class="nav-item"><i class="fas fa-crown"></i> Subscription <span style="font-size: 0.9rem; color: #d8aa88;">coming soon</span></div>
                <div class="nav-item"><i class="fas fa-bell"></i> More Updates <span style="font-size: 0.9rem; color: #d8aa88;">stay tuned</span></div>
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
            <div style="margin-top: 48px; text-align: center; font-size: 0.7rem; color: #d8aa88;">✨ @2026 Moodify ✨</div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content" id="mainContent">
            <!-- WELCOME HERO -->
            <div class="welcome-hero">
                <div class="greeting">
                    <h2>Hello, {{ $user->name }} 🌸</h2>
                    <p><i class="fas fa-sparkle"></i> your vibe today feels dreamy & happy ✨ <i class="fas fa-cloud-moon"></i></p>
                </div>
                <div class="profile-area">
                    <div class="profile-pic">💖</div>
                    <div><strong>{{ $user->name }} ✨</strong><br><span style="font-size: 0.7rem;">your melody heart</span></div>
                </div>
            </div>

            <!-- Language Selector -->
            <div class="language-selector" style="background: rgba(255, 245, 233, 0.7); backdrop-filter: blur(10px); border-radius: 60px; padding: 10px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-headphones" style="color: #d9946b;"></i>
                    <span style="font-weight: 600; color: #784f32;">🎵 music language</span>
                </div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <button class="lang-btn" data-lang="english" onclick="changeLanguage('english')" style="padding: 6px 18px; border-radius: 40px; border: none; cursor: pointer; font-family: 'Quicksand'; font-weight: 500;">🌎 English</button>
                    <button class="lang-btn" data-lang="hindi" onclick="changeLanguage('hindi')" style="padding: 6px 18px; border-radius: 40px; border: none; cursor: pointer; font-family: 'Quicksand'; font-weight: 500;">🇮🇳 Hindi / Bollywood</button>
                    <button class="lang-btn" data-lang="kpop" onclick="changeLanguage('kpop')" style="padding: 6px 18px; border-radius: 40px; border: none; cursor: pointer; font-family: 'Quicksand'; font-weight: 500;">🇰🇷 K-pop / Korean</button>
                    <button class="lang-btn" data-lang="punjabi" onclick="changeLanguage('punjabi')" style="padding: 6px 18px; border-radius: 40px; border: none; cursor: pointer; font-family: 'Quicksand'; font-weight: 500;">🟫 Punjabi Beats</button>
                </div>
            </div>

            <!-- UPLOAD CARD -->
            <div class="upload-card">
                <div class="upload-title"><i class="fas fa-camera-retro"></i> AI mood whisperer 🎧</div>
                <div class="drop-zone">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #d9946b;"></i>
                    <p style="margin-top: 8px;">upload your photo — AI will read your aura ✨</p>
                    <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="imageUploadStatic" name="image" accept="image/*">
                        <label class="file-label" for="imageUploadStatic"><i class="fas fa-image"></i> choose a photo</label>
                        <button type="submit" class="file-label">Upload</button>
                    </form>
                    <div class="static-preview">
                        @if(Auth::user()->profile_image)
                        <img src="{{ asset(Auth::user()->profile_image) }}" class="uploaded-image" id="uploadedImage" alt="Uploaded Image">
                        @else
                        <i class="fas fa-heart" style="color:#d9946b;"></i>
                        <span style="font-size:0.75rem;">your uploaded photo will appear here ✨</span>
                        @endif
                    </div>
                </div>
                <div class="mood-result">
                    <div><strong>Detected Mood:</strong> <span id="detectedMood">✨ Waiting for photo ✨</span></div>
                    <div><strong>Confidence:</strong> <span id="confidenceLevel">--%</span></div>
                    <div style="background:#ffe1cf; border-radius:30px; padding:5px 12px;">✨ AI match ✨</div>
                </div>
            </div>

            <!-- RECOMMENDED SONGS -->
            <div class="section-title"><i class="fas fa-headphones"></i> recommended for your vibe 🎀</div>
            <div class="song-grid" id="songGrid">
                @for($i = 1; $i <= 8; $i++) <div class="song-card" data-song-index="{{ $i }}">
                    <div class="album-art">
                        <img id="song{{ $i }}Cover" class="song-cover" style="display: none;" />
                        <div id="song{{ $i }}Fallback" style="font-size: 2rem;">🎵</div>
                    </div>
                    <div class="song-info">
                        <h4 id="song{{ $i }}Title">Loading...</h4>
                        <p id="song{{ $i }}Artist">--</p>
                    </div>
                    <div class="action-buttons">
                        <button class="play-btn" data-index="{{ $i }}"><i class="fas fa-play"></i> Play</button>
                        <button class="save-btn" data-index="{{ $i }}"><i class="fas fa-heart"></i> Save</button>
                    </div>
            </div>
            @endfor
    </div>

    <!-- FAVORITES SECTION (hidden by default) -->
    <div id="favoritesSection" style="display: none;">
        <div class="section-title"><i class="fas fa-heart" style="color: #f28b6e;"></i> your favorite songs 💖</div>
        <div class="song-grid" id="favoritesGrid"></div>
    </div>


    <!-- NOW PLAYING BAR -->
    <div class="now-playing-bar" id="nowPlayingBar" style="display: none;">
        <div class="now-playing-info">
            <div class="now-playing-cover" id="nowPlayingCover">🎵</div>
            <div class="now-playing-details">
                <h4 id="nowPlayingTitle">Select a song</h4>
                <p id="nowPlayingArtist">--</p>
            </div>
        </div>
        <div class="now-playing-controls">
            <button class="control-btn" onclick="togglePlayPause()"><i class="fas fa-play" id="playPauseIcon"></i></button>
            <button class="control-btn" onclick="closeNowPlaying()"><i class="fas fa-times"></i></button>
        </div>
    </div>

    <audio id="audioPlayer"></audio>

    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
