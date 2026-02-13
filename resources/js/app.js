import './bootstrap';

const wordCache = {};
let debounceTimer = null;

const input = document.getElementById('word-input');
const display = document.getElementById('word-display');
const statIn = document.getElementById('stat-in');
const statOut = document.getElementById('stat-out');
const gateLeft = document.getElementById('gate-left');
const gateRight = document.getElementById('gate-right');
const gateBg = document.getElementById('gate-background');
const gateLabel = document.getElementById('gate-label');

input.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(processInput, 300);
});

async function processInput() {
    const text = input.value.trim();
    if (!text) {
        resetUI();
        return;
    }

    const rawWords = text.match(/[\p{L}'\u2019-]+/gu) || [];
    const words = rawWords.map(w => w.toLowerCase());

    if (words.length === 0) {
        resetUI();
        return;
    }

    // Find words not yet cached
    const unchecked = [...new Set(words)].filter(w => !(w in wordCache));

    if (unchecked.length > 0) {
        try {
            const response = await axios.post('/check-words', { words: unchecked });
            const results = response.data.results;
            for (const [word, found] of Object.entries(results)) {
                wordCache[word] = found;
            }
        } catch (err) {
            console.error('Erreur lors de la vérification:', err);
            return;
        }
    }

    renderWords(rawWords);
    updateStats(words);
    updateGate(words);
}

function renderWords(rawWords) {
    display.innerHTML = '';
    for (const word of rawWords) {
        const span = document.createElement('span');
        span.textContent = word;
        const lower = word.toLowerCase();
        if (lower in wordCache) {
            span.className = wordCache[lower] ? 'word-bible' : 'word-not-bible';
        }
        display.appendChild(span);

        // Add space between words
        display.appendChild(document.createTextNode(' '));
    }
}

function updateStats(words) {
    let inBible = 0;
    let notInBible = 0;
    for (const w of words) {
        if (w in wordCache) {
            if (wordCache[w]) inBible++;
            else notInBible++;
        }
    }
    statIn.textContent = inBible;
    statOut.textContent = notInBible;
}

function updateGate(words) {
    const total = words.length;
    if (total === 0) {
        closeGate();
        return;
    }

    let inBible = 0;
    for (const w of words) {
        if (wordCache[w]) inBible++;
    }

    const ratio = inBible / total;
    const deviation = Math.abs(ratio - 0.5) * 2;
    const angle = deviation * 75;

    gateLeft.style.transform = `rotateY(${angle}deg)`;
    gateRight.style.transform = `rotateY(-${angle}deg)`;

    // Switch background
    gateBg.classList.remove('bg-neutral-gate', 'bg-heaven', 'bg-hell');
    if (ratio > 0.5) {
        gateBg.classList.add('bg-heaven');
        gateLabel.textContent = `${Math.round(ratio * 100)}% biblique — Les portes du Paradis s'ouvrent`;
        gateLabel.style.color = '#fbbf24';
    } else if (ratio < 0.5) {
        gateBg.classList.add('bg-hell');
        gateLabel.textContent = `${Math.round((1 - ratio) * 100)}% non-biblique — Les portes de l'Enfer s'ouvrent`;
        gateLabel.style.color = '#f87171';
    } else {
        gateBg.classList.add('bg-neutral-gate');
        gateLabel.textContent = 'Équilibre parfait — Les portes hésitent...';
        gateLabel.style.color = '#a8a29e';
    }
}

function closeGate() {
    gateLeft.style.transform = 'rotateY(0deg)';
    gateRight.style.transform = 'rotateY(0deg)';
    gateBg.classList.remove('bg-heaven', 'bg-hell');
    gateBg.classList.add('bg-neutral-gate');
    gateLabel.textContent = 'Les portes attendent vos mots...';
    gateLabel.style.color = '#a8a29e';
}

function resetUI() {
    display.innerHTML = '';
    statIn.textContent = '0';
    statOut.textContent = '0';
    closeGate();
}
