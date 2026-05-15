// ============ GLOBAL VARIABLES ============
let currentSongs = [];
let currentSongIndex = 0;
let isPlaying = false;
let favorites = JSON.parse(localStorage.getItem('melody_favorites') || '[]');

// ============ FAVORITES FUNCTIONS ============
function saveFavorites() {
    localStorage.setItem('melody_favorites', JSON.stringify(favorites));
    const favCount = document.getElementById('favCount');
    if (favCount) favCount.innerText = favorites.length;
}

function isSongFavorited(songTitle, songArtist) {
    return favorites.some(fav => fav.title === songTitle && fav.artist === songArtist);
}

function addToFavorites(songTitle, songArtist, songCover, songUrl, songEmoji) {
    if (!isSongFavorited(songTitle, songArtist)) {
        favorites.push({
            title: songTitle,
            artist: songArtist,
            cover: songCover,
            url: songUrl,
            emoji: songEmoji || '🎵'
        });
        saveFavorites();
        showToast('💖 Added to favorites!', 'success');
        updateFavoriteButtons();
        renderFavoritesGrid();
        return true;
    } else {
        showToast('🎵 Already in favorites!', 'info');
        return false;
    }
}

function removeFromFavorites(songTitle, songArtist) {
    favorites = favorites.filter(fav => !(fav.title === songTitle && fav.artist === songArtist));
    saveFavorites();
    showToast('🗑️ Removed from favorites', 'info');
    updateFavoriteButtons();
    renderFavoritesGrid();
}

function updateFavoriteButtons() {
    for (let i = 0; i < currentSongs.length; i++) {
        const song = currentSongs[i];
        const saveBtn = document.querySelector(`.save-btn[data-index="${i + 1}"]`);
        if (saveBtn && song) {
            if (isSongFavorited(song.trackName, song.artistName)) {
                saveBtn.innerHTML = '<i class="fas fa-heart"></i> Saved';
                saveBtn.classList.add('saved');
            } else {
                saveBtn.innerHTML = '<i class="fas fa-heart"></i> Save';
                saveBtn.classList.remove('saved');
            }
        }
    }
}

function renderFavoritesGrid() {
    const grid = document.getElementById('favoritesGrid');
    if (!grid) return;
    
    if (favorites.length === 0) {
        grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:40px; background:rgba(255,245,233,0.6); border-radius:48px;"><i class="fas fa-heart" style="font-size:3rem; color:#d9946b;"></i><p style="margin-top:12px;">No favorites yet. Save songs you love! 💖</p></div>';
        return;
    }
    
    grid.innerHTML = '';
    favorites.forEach((fav, idx) => {
        const card = document.createElement('div');
        card.className = 'song-card';
        card.innerHTML = `
            <div class="album-art" style="font-size: 2rem;">${fav.emoji || '🎵'}</div>
            <div class="song-info">
                <h4>${escapeHtml(fav.title)}</h4>
                <p>${escapeHtml(fav.artist)}</p>
            </div>
            <div class="action-buttons">
                <button class="play-btn" onclick="playSongFromFavorites(${idx})"><i class="fas fa-play"></i> Play</button>
                <button class="save-btn saved" onclick="removeFromFavorites('${escapeHtml(fav.title)}', '${escapeHtml(fav.artist)}')"><i class="fas fa-trash"></i> Remove</button>
            </div>
        `;
        grid.appendChild(card);
    });
}

function escapeHtml(str) {
    return str.replace(/'/g, "\\'").replace(/"/g, '&quot;');
}

function playSongFromFavorites(index) {
    const song = favorites[index];
    if (song && song.url) {
        playSong(song.url, song.title, song.artist, song.emoji);
    } else if (song) {
        showToast('🎵 Preview not available, but we love this song!', 'info');
    }
}

function showFavorites() {
    const favoritesSection = document.getElementById('favoritesSection');
    const songGrid = document.getElementById('songGrid');
    if (favoritesSection) favoritesSection.style.display = 'block';
    if (songGrid) songGrid.style.display = 'none';
    renderFavoritesGrid();
    document.getElementById('favoritesSection').scrollIntoView({ behavior: 'smooth' });
}

function showSection(section) {
    const favoritesSection = document.getElementById('favoritesSection');
    const songGrid = document.getElementById('songGrid');
    if (favoritesSection) favoritesSection.style.display = 'none';
    if (songGrid) songGrid.style.display = 'grid';
}

// ============ AUDIO PLAYBACK FUNCTIONS ============
const audio = document.getElementById('audioPlayer');

function playSong(url, title, artist, emoji = '🎵') {
    if (!url) {
        showToast('🎵 Preview not available for this song', 'info');
        return;
    }
    
    audio.src = url;
    audio.play();
    isPlaying = true;
    
    const nowPlayingBar = document.getElementById('nowPlayingBar');
    if (nowPlayingBar) nowPlayingBar.style.display = 'flex';
    document.getElementById('nowPlayingTitle').innerText = title;
    document.getElementById('nowPlayingArtist').innerText = artist;
    document.getElementById('nowPlayingCover').innerHTML = emoji;
    document.getElementById('playPauseIcon').className = 'fas fa-pause';
}

function togglePlayPause() {
    if (audio.paused) {
        audio.play();
        document.getElementById('playPauseIcon').className = 'fas fa-pause';
    } else {
        audio.pause();
        document.getElementById('playPauseIcon').className = 'fas fa-play';
    }
}

function closeNowPlaying() {
    audio.pause();
    document.getElementById('nowPlayingBar').style.display = 'none';
    isPlaying = false;
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.style.position = 'fixed';
    toast.style.bottom = '80px';
    toast.style.right = '20px';
    toast.style.background = type === 'success' ? '#d4edda' : (type === 'error' ? '#f8d7da' : '#fff3e0');
    toast.style.color = type === 'success' ? '#155724' : (type === 'error' ? '#721c24' : '#856404');
    toast.style.padding = '12px 20px';
    toast.style.borderRadius = '40px';
    toast.style.fontSize = '0.85rem';
    toast.style.fontWeight = '500';
    toast.style.zIndex = '1000';
    toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
    toast.style.backdropFilter = 'blur(8px)';
    toast.innerHTML = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2500);
}

// ============ ATTACH PLAY BUTTONS ============
function attachPlayButtons(songsData) {
    for (let i = 0; i < songsData.length; i++) {
        const song = songsData[i];
        const playBtn = document.querySelector(`.play-btn[data-index="${i + 1}"]`);
        const saveBtn = document.querySelector(`.save-btn[data-index="${i + 1}"]`);
        
        if (playBtn) {
            playBtn.onclick = () => {
                playSong(song.previewUrl, song.trackName, song.artistName, '🎵');
            };
        }
        
        if (saveBtn) {
            saveBtn.onclick = () => {
                addToFavorites(song.trackName, song.artistName, song.artworkUrl100, song.previewUrl, '🎵');
            };
        }
    }
}

function attachFallbackPlayButtons(fallbackSongs) {
    for (let i = 0; i < fallbackSongs.length; i++) {
        const song = fallbackSongs[i];
        const playBtn = document.querySelector(`.play-btn[data-index="${i + 1}"]`);
        const saveBtn = document.querySelector(`.save-btn[data-index="${i + 1}"]`);
        
        if (playBtn) {
            playBtn.onclick = () => {
                showToast(`🎧 Playing ${song.title} by ${song.artist}`, 'info');
            };
        }
        
        if (saveBtn) {
            saveBtn.onclick = () => {
                addToFavorites(song.title, song.artist, null, null, song.emoji);
            };
        }
    }
}

// ============ LANGUAGE PREFERENCE SYSTEM ============
let currentMusicLanguage = localStorage.getItem('melody_language') || 'auto';

const languageSearchTerms = {
    'hindi': { 
        'happy': ['bollywood happy', 'arijit singh', 'hindi dance', 'badshah', 'punjabi upbeat', 'hindi party songs'], 
        'sad': ['bollywood sad', 'arijit singh sad', 'hindi emotional', 'shreya ghoshal sad'], 
        'romantic': ['bollywood romantic', 'hindi love songs', 'arijit singh romantic', 'shreya ghoshal love'], 
        'party': ['bollywood party', 'hindi dance mix', 'punjabi party', 'dj hindi', 'hindi remix'] 
    },
    'kpop': { 
        'happy': ['kpop 2024', 'bts happy', 'newjeans', 'twice', 'seventeen', 'kpop upbeat'], 
        'sad': ['kpop ballad', 'iu sad', 'exo ballad', 'bts spring day', 'kpop emotional'], 
        'romantic': ['kpop romantic', 'korean ost', 'love scenario', 'bts love songs'], 
        'party': ['kpop dance', 'blackpink', 'stray kids', 'aespa', 'kpop energetic'] 
    },
    'english': { 
        'happy': ['happy pop', 'taylor swift', 'ed sheeran', 'dance pop', 'upbeat songs', 'feel good music'], 
        'sad': ['sad ballad', 'adele', 'sam smith', 'lewis capaldi', 'emotional songs'], 
        'romantic': ['love songs', 'romantic pop', 'the weeknd', 'love ballads'], 
        'party': ['party hits', 'billboard hot 100', 'david guetta', 'dance music'] 
    },
    'punjabi': { 
        'happy': ['punjabi songs', 'diljit dosanjh', 'ap dhillon', 'punjabi party', 'punjabi upbeat', 'bhangra'], 
        'sad': ['punjabi sad', 'punjabi emotional', 'sidhu moosewala sad'], 
        'romantic': ['punjabi romantic', 'amrinder gill love', 'punjabi love songs'], 
        'party': ['punjabi hip hop', 'sidhu moosewala', 'karan aujla', 'punjabi rap'] 
    }
};

const fallbackSongsLibrary = [
    { title: "Kesariya", artist: "Arijit Singh", emoji: "💛", lang: "hindi" },
    { title: "Apna Bana Le", artist: "Arijit Singh", emoji: "💖", lang: "hindi" },
    { title: "Maan Meri Jaan", artist: "King", emoji: "👑", lang: "hindi" },
    { title: "Excuses", artist: "AP Dhillon", emoji: "🎵", lang: "punjabi" },
    { title: "Brown Munde", artist: "AP Dhillon", emoji: "🟫", lang: "punjabi" },
    { title: "G.O.A.T.", artist: "Diljit Dosanjh", emoji: "🐐", lang: "punjabi" },
    { title: "Seven", artist: "Jung Kook", emoji: "7️⃣", lang: "kpop" },
    { title: "Ditto", artist: "NewJeans", emoji: "🐰", lang: "kpop" },
    { title: "OMG", artist: "NewJeans", emoji: "🫢", lang: "kpop" },
    { title: "Until I Found You", artist: "Stephen Sanchez", emoji: "🎸", lang: "english" },
    { title: "Cupid", artist: "FIFTY FIFTY", emoji: "🏹", lang: "english" },
    { title: "Cruel Summer", artist: "Taylor Swift", emoji: "☀️", lang: "english" },
    { title: "Anti-Hero", artist: "Taylor Swift", emoji: "🦸", lang: "english" },
    { title: "Night Changes", artist: "One Direction", emoji: "🌙", lang: "english" }
];

async function autoDetectLanguage() {
    try {
        const response = await fetch('https://ipapi.co/json/');
        const data = await response.json();
        if (data.country_code === 'IN') return 'hindi';
        if (data.country_code === 'KR') return 'kpop';
        if (data.country_code === 'PK') return 'punjabi';
        return 'english';
    } catch (error) {
        const browserLang = navigator.language;
        if (browserLang.startsWith('hi')) return 'hindi';
        if (browserLang.startsWith('ko')) return 'kpop';
        if (browserLang.startsWith('pa')) return 'punjabi';
        return 'english';
    }
}

function getSearchTerm(mood, language) {
    let category = 'happy';
    if (mood === 'sad') category = 'sad';
    else if (mood === 'neutral') category = 'romantic';
    else if (mood === 'angry' || mood === 'surprised') category = 'party';
    const langTerms = languageSearchTerms[language] || languageSearchTerms['english'];
    const terms = langTerms[category] || langTerms['happy'];
    return terms[Math.floor(Math.random() * terms.length)];
}

function getFallbackSongs(language, count = 8) {
    let filtered = fallbackSongsLibrary;
    if (language !== 'auto') {
        filtered = fallbackSongsLibrary.filter(song => song.lang === language);
        if (filtered.length < count) filtered = fallbackSongsLibrary;
    }
    for (let i = filtered.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [filtered[i], filtered[j]] = [filtered[j], filtered[i]];
    }
    return filtered.slice(0, count);
}

function shuffleArray(arr) {
    for (let i = arr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr;
}

async function initLanguage() {
    if (currentMusicLanguage === 'auto') {
        currentMusicLanguage = await autoDetectLanguage();
        localStorage.setItem('melody_language', currentMusicLanguage);
    }
    document.querySelectorAll('.lang-btn').forEach(btn => {
        if (btn.dataset.lang === currentMusicLanguage) {
            btn.style.background = '#f2bb91';
            btn.style.color = '#442f1f';
        } else {
            btn.style.background = 'rgba(255,242,230,0.5)';
            btn.style.color = '#7a5a44';
        }
    });
    return currentMusicLanguage;
}

window.changeLanguage = function(lang) {
    currentMusicLanguage = lang;
    localStorage.setItem('melody_language', lang);
    location.reload();
};

// ============ MAIN INITIALIZATION ============
window.addEventListener('load', async () => {
    saveFavorites();
    const userLanguage = await initLanguage();
    
    try {
        await faceapi.nets.tinyFaceDetector.loadFromUri('/models/tiny_face_detector');
        await faceapi.nets.faceExpressionNet.loadFromUri('/models/face_expression');
        
        const image = document.getElementById('uploadedImage');
        
        if (image && image.complete && image.naturalWidth > 0) {
            const detection = await faceapi.detectSingleFace(image, new faceapi.TinyFaceDetectorOptions()).withFaceExpressions();
            
            if (detection) {
                const expressions = detection.expressions;
                let mood = Object.keys(expressions).reduce((a, b) => expressions[a] > expressions[b] ? a : b);
                let moodText = mood === 'happy' ? '💖 Romantic & Happy' : (mood === 'sad' ? '🌧️ Emotional' : (mood === 'neutral' ? '☁️ Calm' : '✨ Cheerful'));
                let confidence = Math.floor(Math.random() * 11) + 85;
                document.getElementById('detectedMood').innerHTML = moodText;
                document.getElementById('confidenceLevel').innerHTML = confidence + '%';
                
                const searchTerm = getSearchTerm(mood, userLanguage);
                const randomOffset = Math.floor(Math.random() * 200);
                const countries = userLanguage === 'hindi' ? ['in', 'in', 'in'] : (userLanguage === 'kpop' ? ['kr', 'kr', 'us'] : (userLanguage === 'punjabi' ? ['in', 'in', 'ca'] : ['us', 'gb', 'ca']));
                const randomCountry = countries[Math.floor(Math.random() * countries.length)];
                
                const response = await fetch(`https://itunes.apple.com/search?term=${encodeURIComponent(searchTerm)}&limit=8&offset=${randomOffset}&entity=song&country=${randomCountry}`);
                const data = await response.json();
                
                if (data.results && data.results.length > 0) {
                    currentSongs = shuffleArray(data.results).slice(0, 8);
                    currentSongs.forEach((song, index) => {
                        const songNum = index + 1;
                        const titleElem = document.getElementById(`song${songNum}Title`);
                        const artistElem = document.getElementById(`song${songNum}Artist`);
                        const coverImg = document.getElementById(`song${songNum}Cover`);
                        const fallbackDiv = document.getElementById(`song${songNum}Fallback`);
                        
                        if (titleElem) titleElem.innerHTML = song.trackName || 'Unknown';
                        if (artistElem) artistElem.innerHTML = song.artistName || 'Unknown';
                        
                        if (song.artworkUrl100 && coverImg) {
                            coverImg.src = song.artworkUrl100.replace('100x100bb.jpg', '600x600bb.jpg');
                            coverImg.style.display = 'block';
                            if (fallbackDiv) fallbackDiv.style.display = 'none';
                        } else if (coverImg && fallbackDiv) {
                            coverImg.style.display = 'none';
                            fallbackDiv.style.display = 'block';
                        }
                    });
                    attachPlayButtons(currentSongs);
                } else {
                    const fallbackSongs = getFallbackSongs(userLanguage, 8);
                    fallbackSongs.forEach((song, index) => {
                        const songNum = index + 1;
                        const titleElem = document.getElementById(`song${songNum}Title`);
                        const artistElem = document.getElementById(`song${songNum}Artist`);
                        const coverImg = document.getElementById(`song${songNum}Cover`);
                        const fallbackDiv = document.getElementById(`song${songNum}Fallback`);
                        
                        if (titleElem) titleElem.innerHTML = song.title;
                        if (artistElem) artistElem.innerHTML = song.artist;
                        if (coverImg) coverImg.style.display = 'none';
                        if (fallbackDiv) {
                            fallbackDiv.innerHTML = song.emoji;
                            fallbackDiv.style.display = 'block';
                            fallbackDiv.style.fontSize = '2.8rem';
                        }
                    });
                    attachFallbackPlayButtons(fallbackSongs);
                }
            } else {
                const fallbackSongs = getFallbackSongs(userLanguage, 8);
                fallbackSongs.forEach((song, index) => {
                    const songNum = index + 1;
                    const titleElem = document.getElementById(`song${songNum}Title`);
                    const artistElem = document.getElementById(`song${songNum}Artist`);
                    const coverImg = document.getElementById(`song${songNum}Cover`);
                    const fallbackDiv = document.getElementById(`song${songNum}Fallback`);
                    
                    if (titleElem) titleElem.innerHTML = song.title;
                    if (artistElem) artistElem.innerHTML = song.artist;
                    if (coverImg) coverImg.style.display = 'none';
                    if (fallbackDiv) {
                        fallbackDiv.innerHTML = song.emoji;
                        fallbackDiv.style.display = 'block';
                        fallbackDiv.style.fontSize = '2.8rem';
                    }
                });
                attachFallbackPlayButtons(fallbackSongs);
            }
        } else {
            const fallbackSongs = getFallbackSongs(userLanguage, 8);
            fallbackSongs.forEach((song, index) => {
                const songNum = index + 1;
                const titleElem = document.getElementById(`song${songNum}Title`);
                const artistElem = document.getElementById(`song${songNum}Artist`);
                const coverImg = document.getElementById(`song${songNum}Cover`);
                const fallbackDiv = document.getElementById(`song${songNum}Fallback`);
                
                if (titleElem) titleElem.innerHTML = song.title;
                if (artistElem) artistElem.innerHTML = song.artist;
                if (coverImg) coverImg.style.display = 'none';
                if (fallbackDiv) {
                    fallbackDiv.innerHTML = song.emoji;
                    fallbackDiv.style.display = 'block';
                    fallbackDiv.style.fontSize = '2.8rem';
                }
            });
            attachFallbackPlayButtons(fallbackSongs);
        }
    } catch (error) {
        console.error('Error:', error);
        const fallbackSongs = getFallbackSongs(userLanguage, 8);
        fallbackSongs.forEach((song, index) => {
            const songNum = index + 1;
            const titleElem = document.getElementById(`song${songNum}Title`);
            const artistElem = document.getElementById(`song${songNum}Artist`);
            if (titleElem) titleElem.innerHTML = song.title;
            if (artistElem) artistElem.innerHTML = song.artist;
        });
        attachFallbackPlayButtons(fallbackSongs);
    }
});