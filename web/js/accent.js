function applyAccent(hex) {
    console.log("Trying to apply accent color.")
    const root = document.documentElement;
    root.style.setProperty('--accent', hex);
    root.style.setProperty('--accent-hover', darkenHex(hex, 10));
    root.style.setProperty('--accent-muted', hex + '20');
    root.style.setProperty('--accent-text', getLuminance(hex) > 0.4 ? '#111' : '#fff');
    localStorage.setItem('accent', hex);
}

function darkenHex(hex, amount) {
    let [r, g, b] = hex.match(/\w\w/g).map(x => parseInt(x, 16));
    r = Math.max(0, r - amount);
    g = Math.max(0, g - amount);
    b = Math.max(0, b - amount);
    return '#' + [r, g, b].map(x => x.toString(16).padStart(2, '0')).join('');
}

function getLuminance(hex) {
    const [r, g, b] = hex.match(/\w\w/g).map(x => parseInt(x, 16) / 255);
    return 0.2126 * r + 0.7152 * g + 0.0722 * b;
}

// Apply saved accent on page load
const saved = window.__savedAccent || localStorage.getItem('accent');
console.log(saved);
if (saved) applyAccent(saved);