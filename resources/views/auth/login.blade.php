<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
   
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cdefs%3E%3ClinearGradient id='grad' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23f7cfb0'/%3E%3Cstop offset='100%25' stop-color='%23e87a4a'/%3E%3C/linearGradient%3E%3Cfilter id='glow' x='-50%25' y='-50%25' width='200%25' height='200%25'%3E%3CfeGaussianBlur stdDeviation='2.5' result='blur'/%3E%3CfeMerge%3E%3CfeMergeNode in='blur'/%3E%3CfeMergeNode in='SourceGraphic'/%3E%3C/feMerge%3E%3C/filter%3E%3C/defs%3E%3Ctext x='50' y='72' font-size='60' fill='url(%23grad)' filter='url(%23glow)' text-anchor='middle' font-family='Arial' font-weight='bold'%3E♪%3C/text%3E%3Ctext x='28' y='48' font-size='22' fill='%23f5bc91' filter='url(%23glow)' text-anchor='middle' font-family='Arial'%3E♫%3C/text%3E%3Ctext x='72' y='85' font-size='16' fill='%23ffd4a8' opacity='0.8'%3E♩%3C/text%3E%3C/svg%3E">

    <title>Login · Moodify | welcome back to happy tunes</title>
    <!-- Google Fonts + soft styling (no JS required for design) -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 (free icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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

    <div class="login-container">
        <!-- LEFT PANEL: images, text, emojis, gf/bf kdrama feel, spotify/jiosaavn icons (same joyful theme) -->
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

            <!-- image links: happy kdrama couple / gf bf vibe (free stock images) -->


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
                “ welcome back! your playlist misses you ✨ <br>
                <span style="font-size: 0.9rem;">log in and let the music find your heart again 🌸”</span>
            </div>

            <!-- extra cute gf/bf emoji row -->
            <div class="floating-heart-emojis">
                <span>🧸</span> <span>💞</span> <span>👫</span> <span>🎶</span> <span>🍃</span>
            </div>
            <div class="korean-drama-text">
                <i class="fas fa-cloud-sun"></i> "다시 만나서 반가워요" — so glad to see you again
            </div>
        </div>

        <!-- RIGHT PANEL: LOGIN FORM (no Google sign-in, only email/password) -->
        <div class="right-form-panel">
            <div class="form-header">
                <h2>welcome back 💖</h2>
                <p>log in to continue your happy music journey & get AI song recommendations</p>
            </div>

            <form action="{{ route('login.post') }}" method="post" id="loginForm">
                @csrf
                <div class="input-group">
                    <label><i class="far fa-envelope"></i> Email address</label>
                    <input type="email" placeholder="your@gmail.com" name="email" required>
                </div>
                <div class="input-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" placeholder="••••••••" name="password" required>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="rememberMe" name="remember">
                    <label for="rememberMe" style="font-weight: 500;"> keep me signed in on this device 🍃</label>
                </div>
                <div class="forgot-password">
                    <a href="#"><i class="fas fa-question-circle"></i> forgot password?</a>
                </div>
                <button type="submit" class="login-btn"><i class="fas fa-music"></i> log in & feel the vibe</button>
                <div class="signup-redirect">
                    don't have an account yet? <a href="{{ route('signup') }}" style="text-decoration: none; color:#cf875b;">create one for free →</a>
                    <span style="display: inline-block; margin-left: 6px;">🌸</span>
                </div>
            </form>

            <!-- Additional warmth note: no google login, just pure email login matching your request -->
            <div class="demo-note">
                <i class="fas fa-leaf"></i> after login, upload your photo & let AI recommend songs from Spotify + JioSaavn
            </div>
        </div>
    </div>

    <!-- simple demo note: no real backend, purely frontend (just matching theme) -->
</body>
</html>
