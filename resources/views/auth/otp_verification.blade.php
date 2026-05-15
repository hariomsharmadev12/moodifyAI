<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
   
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cdefs%3E%3ClinearGradient id='grad' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23f7cfb0'/%3E%3Cstop offset='100%25' stop-color='%23e87a4a'/%3E%3C/linearGradient%3E%3Cfilter id='glow' x='-50%25' y='-50%25' width='200%25' height='200%25'%3E%3CfeGaussianBlur stdDeviation='2.5' result='blur'/%3E%3CfeMerge%3E%3CfeMergeNode in='blur'/%3E%3CfeMergeNode in='SourceGraphic'/%3E%3C/feMerge%3E%3C/filter%3E%3C/defs%3E%3Ctext x='50' y='72' font-size='60' fill='url(%23grad)' filter='url(%23glow)' text-anchor='middle' font-family='Arial' font-weight='bold'%3E♪%3C/text%3E%3Ctext x='28' y='48' font-size='22' fill='%23f5bc91' filter='url(%23glow)' text-anchor='middle' font-family='Arial'%3E♫%3C/text%3E%3Ctext x='72' y='85' font-size='16' fill='%23ffd4a8' opacity='0.8'%3E♩%3C/text%3E%3C/svg%3E">

    <title>Email OTP · Moodify | verify your happy account</title>
    <!-- Google Fonts + soft styling -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/otp_verification.css') }}">
</head>
<body>

    <!-- SOFT NATURE BACKGROUND -->
    <div class="soft-nature-bg"></div>
    <div class="nature-accent"></div>
    <div class="petal-float">
        🌸🍃🌼
    </div>
    <div class="petal-float" style="top: auto; bottom: 12%; right: 3%; font-size: 2.5rem; animation-duration: 14s; opacity: 0.3;">
        🍂✨💌
    </div>

    <div class="otp-container">
        <div class="otp-badge">
            <i class="fas fa-envelope-open-text"></i> email verification
        </div>

        <h1>one time password ✨</h1>
        <div class="sub-message">
            we've sent a magical 6-digit code to your email<br>
            to keep your melody journey safe & happy
        </div>

        <!-- Display email (demo) -->
        <div class="email-display">
            <i class="fas fa-envelope"></i>
            <span id="userEmailDisplay">{{ session('otp_email') }}</span>
        </div>

        <!-- OTP Input Fields (6 digits) -->




        <!-- Verify Button -->
        <form action="{{ route('otp_verification.submit') }}" method="POST">
            @csrf
            <div class="otp-inputs">
                <div class="otp-fields">
                    <input type="text" name="otp" maxlength="6" class="otp-digit" placeholder="Enter OTP" required>
                </div>
            </div>
            <button class="verify-btn" id="verifyBtn">
                <i class="fas fa-check-circle"></i> verify & continue
            </button>
        </form>


        <!-- Message display -->
        <div id="messageBox" class="message-box"></div>

        <!-- Back to login link -->
        <a href="{{ route('login') }}" class="back-link" id="backLink">
            <i class="fas fa-arrow-left"></i> back to login
        </a>

        <!-- Emoji row for happy vibes -->
        <div class="emoji-row">
            <span>🎵</span>
            <span>💖</span>
            <span>🌸</span>
            <span>🎧</span>
            <span>🍃</span>
        </div>
        <div style="font-size: 0.7rem; margin-top: 12px; color: #c89a78;">
            <i class="fas fa-shield-alt"></i> for demo, OTP can be: 123456
        </div>
    </div>


</body>
</html>
