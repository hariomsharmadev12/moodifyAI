<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cdefs%3E%3ClinearGradient id='grad' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23f7cfb0'/%3E%3Cstop offset='100%25' stop-color='%23e87a4a'/%3E%3C/linearGradient%3E%3Cfilter id='glow' x='-50%25' y='-50%25' width='200%25' height='200%25'%3E%3CfeGaussianBlur stdDeviation='2.5' result='blur'/%3E%3CfeMerge%3E%3CfeMergeNode in='blur'/%3E%3CfeMergeNode in='SourceGraphic'/%3E%3C/feMerge%3E%3C/filter%3E%3C/defs%3E%3Ctext x='50' y='72' font-size='60' fill='url(%23grad)' filter='url(%23glow)' text-anchor='middle' font-family='Arial' font-weight='bold'%3E♪%3C/text%3E%3Ctext x='28' y='48' font-size='22' fill='%23f5bc91' filter='url(%23glow)' text-anchor='middle' font-family='Arial'%3E♫%3C/text%3E%3Ctext x='72' y='85' font-size='16' fill='%23ffd4a8' opacity='0.8'%3E♩%3C/text%3E%3C/svg%3E">


    <title>Moodify Register | Join the happy melody</title>
    <!-- Google Fonts & simple styling (no JavaScript) -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 (free icons for extra emoji-like feel) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
</head>
<body>

    <!-- SOFT NATURE BACKGROUND (right corner dominance) + additional nature accents -->
    <div class="soft-nature-bg"></div>
    <div class="nature-accent"></div>
    <div class="petal-float">
        🌸🍃🌼
    </div>
    <div class="petal-float" style="top: auto; bottom: 12%; right: 3%; font-size: 2.5rem; animation-duration: 14s; opacity: 0.3;">
        🍂✨
    </div>

    <div class="register-container">
        <!-- LEFT PANEL: images, text, emojis, gf/bf kdrama feel, spotify/jiosaavn icons -->
        <div class="left-joy-panel">
            <!-- joyful emoji rain / happy bubbles -->
            <div class="emoji-cloud">
                <span class="big-emoji">🌸</span>
                <span class="big-emoji">💖</span>
                <span class="big-emoji">🎧</span>
                <span class="big-emoji">🍒</span>
                <span class="big-emoji">☁️</span>
                <span class="big-emoji">🫧</span>
                <span class="big-emoji">🌼</span>
            </div>

            <!-- image links: happy kdrama couple / gf bf vibe (pure free stock images) -->

            <!-- romantic couple text / kdrama line -->
            <div class="romantic-couple">
                <i class="fas fa-heart" style="color:#ffa07a; font-size: 1.2rem;"></i>
                <span style="font-weight: 600;"> 🎀 our mood, our story 🎀 </span>
                <i class="fas fa-heart" style="color:#ffa07a; font-size: 1.2rem;"></i>
            </div>

            <!-- kdrama + music platforms visual (Spotify & JioSaavn) -->
            <div class="music-platform-badge">
                <i class="fab fa-spotify" style="color:#1DB954; text-shadow: 0 2px 6px rgba(0,0,0,0.1);"></i>
                <span style="font-weight: bold;"> + </span>
                <i class="fas fa-music" style="color:#E8762E;"></i>
                <span style="font-family: monospace;">JioSaavn</span>
                <i class="fas fa-headphones" style="color:#af7f57;"></i>
            </div>

            <!-- heartwarming quote (feel good) -->
            <div class="inspiring-quote">
                “ every face tells a song — let AI find yours ✨ <br>
                <span style="font-size: 0.9rem;">like a Dreamy moment, your playlist awaits 🌸”</span>
            </div>

            <!-- extra cute gf/bf emoji row -->
            <div class="floating-heart-emojis">
                <span>🧸</span> <span>💞</span> <span>👫</span> <span>🎶</span> <span>🍃</span>
            </div>
            <div class="korean-drama-text">
                <i class="fas fa-cloud-sun"></i> "사랑과 음악" — love & music always together
            </div>
        </div>

        <!-- RIGHT PANEL: REGISTRATION / SIGNUP FORM -->
        <div class="right-form-panel">
            <div class="form-header">
                <h2>create your account ✨</h2>
                <p>join the happiest music family · get song recs that match your vibe</p>
            </div>

            <form action="{{ route('signup.post') }}" method="post" id="signupForm">
                @csrf
                <div class="input-group">
                    <label><i class="far fa-user"></i> Full name</label>
                    <input type="text" name="name" placeholder="e.g., softie, or your lovely name" required>
                </div>
                <div class="input-group">
                    <label><i class="far fa-envelope"></i> Email address</label>
                    <input type="email" name="email" placeholder="hello@melody.com/gmail.com" required>
                </div>
                <div class="input-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" placeholder="create a sweet password" required>
                </div>
                <div class="input-group">
                    <label><i class="fas fa-lock"></i> Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="retype your password" required>
                </div>
                <div class="input-group checkbox-group">
                    <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
                    <label for="agreeTerms" style="font-weight: 500;"> I agree to the <a href="{{ route('terms') }}" style="text-decoration: none; color:#cf875b;">wonderful terms</a> & receive happy melodies 💌</label>
                </div>

                <a href="{{ route('otp_verification') }}">
                    <button type="submit" class="register-btn"><i class="fas fa-magic"></i> Sign up & start my journey</button>
                </a>
                <!-- SIGN UP WITH GOOGLE - soft nature style -->

                <div class="login-redirect">
                    already have an account? <a href="{{ route('login') }}" style="text-decoration: none; color:#cf875b;">log in →</a>
                    <span style="display: inline-block; margin-left: 6px;">🍰</span>
                </div>
            </form>

            <!-- Additional warmth note: no js, but we add simple "demo" note because it's pure html/css, not backend -->
            <div style="font-size: 0.7rem; text-align: center; margin-top: 20px; color: #c89a78;">
                <i class="fas fa-leaf"></i> AI mood detection + Spotify/JioSaavn recommendations after signup
            </div>
        </div>
    </div>

    <!-- no javascript — just a delightful static register page with soft nature and feel-good imagery -->
</body>
</html>
