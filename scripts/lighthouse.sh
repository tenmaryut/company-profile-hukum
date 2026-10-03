#!/usr/bin/env bash
# Lighthouse (mobile, bawaan) untuk beranda dan satu artikel. Laporan HTML+JSON ke docs/lighthouse/.
#   scripts/lighthouse.sh [BASE_URL]   (bawaan: HUKUM_URL dari domain.env)
set -euo pipefail
cd "$(dirname "$0")/.."

DOMAIN_ENV="${DOMAIN_ENV:-/root/tenma-ws/portofolio/domain.env}"
BASE="${1:-$(grep -E '^HUKUM_URL=' "$DOMAIN_ENV" | cut -d= -f2-)}"
[[ -n "$BASE" ]] || { echo "HUKUM_URL tidak ditemukan di $DOMAIN_ENV" >&2; exit 1; }
OUT=docs/lighthouse
mkdir -p "$OUT"
export CHROME_PATH="${CHROME_PATH:-$HOME/.cache/ms-playwright/chromium-1243/chrome-linux64/chrome}"

article="$(curl -fsS "$BASE/sitemap.xml" | grep -o '<loc>[^<]*/artikel/[^<]*</loc>' | grep -v '/kategori/' | head -1 | sed 's#</\?loc>##g')"

run() {
    local name="$1" url="$2"
    npx lighthouse "$url" --quiet \
        --chrome-flags="--headless=new --no-sandbox" \
        --only-categories=performance,accessibility,best-practices,seo \
        --output=json --output=html --output-path="$OUT/$name" >/dev/null
    node -e '
        const r = require(process.argv[1]);
        const s = Object.fromEntries(Object.entries(r.categories).map(([k, v]) => [k, Math.round(v.score * 100)]));
        const m = ["first-contentful-paint", "largest-contentful-paint", "total-blocking-time", "cumulative-layout-shift", "speed-index"]
            .map((k) => `${k}=${r.audits[k].displayValue}`).join(" ");
        console.log(`${process.argv[2]}  ${r.finalDisplayedUrl}\n  ${JSON.stringify(s)}\n  ${m}  (formFactor=${r.configSettings.formFactor}, lighthouse ${r.lighthouseVersion})`);
    ' "$PWD/$OUT/$name.report.json" "$name"
}

run beranda "$BASE/"
run artikel "$article"
