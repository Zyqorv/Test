const TITLE = "PREDICTIO";
const TILE_STATES = ["green", "gray", "gray", "amber", "gray", "green", "gray", "gray", "amber"];
const TILE_STAGGER_MS = 70;

function renderTitleTiles() {
  const container = document.getElementById("tiles");
  if (!container) return;

  TITLE.split("").forEach((letter, index) => {
    const tile = document.createElement("div");
    tile.className = `tile ${TILE_STATES[index]}`;
    tile.textContent = letter;
    container.appendChild(tile);

    setTimeout(() => {
      tile.classList.add("revealed");
    }, index * TILE_STAGGER_MS);
  });
}

function showError(message) {
  const errorEl = document.getElementById("error-message");
  if (!errorEl) return;
  errorEl.textContent = message;
  errorEl.hidden = false;
}

function clearError() {
  const errorEl = document.getElementById("error-message");
  if (!errorEl) return;
  errorEl.hidden = true;
  errorEl.textContent = "";
}

document.addEventListener("DOMContentLoaded", renderTitleTiles);