document.addEventListener('DOMContentLoaded', function () {
  var toggle = document.querySelector('[data-nav-toggle]');
  var nav = document.querySelector('[data-nav]');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      nav.classList.toggle('open');
    });
  }
  var search = document.querySelector('[data-event-search]');
  var prodi = document.querySelector('[data-event-prodi]');
  var category = document.querySelector('[data-event-category]');
  var cards = Array.prototype.slice.call(document.querySelectorAll('[data-event-card]'));
  function filterEvents() {
    var q = ((search && search.value) || '').toLowerCase().trim();
    var p = (prodi && prodi.value) || '';
    var c = (category && category.value) || '';
    var visible = 0;
    cards.forEach(function (card) {
      var title = (card.dataset.title || '').toLowerCase();
      var desc = (card.dataset.desc || '').toLowerCase();
      var matchQ = !q || title.indexOf(q) !== -1 || desc.indexOf(q) !== -1;
      var matchP = !p || card.dataset.prodi === p;
      var matchC = !c || card.dataset.category === c;
      var show = matchQ && matchP && matchC;
      card.style.display = show ? '' : 'none';
      if (show) visible++;
    });
    var empty = document.querySelector('[data-empty-events]');
    if (empty) empty.style.display = visible === 0 ? '' : 'none';
  }
  [search, prodi, category].forEach(function (el) {
    if (el) {
      el.addEventListener('input', filterEvents);
      el.addEventListener('change', filterEvents);
    }
  });
  function startCountdownFor(box) {
    if (!box) return;
    var raw = box.dataset.countdown || '';
    if (!raw) {
      box.textContent = 'Tanggal event belum tersedia';
      return;
    }
    var target = new Date(raw.replace(' ', 'T')).getTime();
    if (isNaN(target)) {
      box.textContent = 'Format tanggal tidak valid';
      return;
    }
    function tick() {
      var diff = target - Date.now();
      if (diff <= 0) {
        box.textContent = 'Event sedang berlangsung atau telah selesai';
        return;
      }
      var d = Math.floor(diff / 86400000);
      var h = Math.floor((diff % 86400000) / 3600000);
      var m = Math.floor((diff % 3600000) / 60000);
      var s = Math.floor((diff % 60000) / 1000);
      box.innerHTML = '<div class="countdown-inline">'
        + '<div class="count-item"><strong>' + d + '</strong><span>Hari</span></div>'
        + '<div class="count-item"><strong>' + h + '</strong><span>Jam</span></div>'
        + '<div class="count-item"><strong>' + m + '</strong><span>Menit</span></div>'
        + '<div class="count-item"><strong>' + s + '</strong><span>Detik</span></div>'
        + '</div>';
    }
    tick();
    setInterval(tick, 1000);
  }
  document.querySelectorAll('[data-countdown]').forEach(startCountdownFor);
  var mainCountdown = document.getElementById('main-countdown');
  if (mainCountdown && !mainCountdown.dataset.countdown) {
    var targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + 7);
    mainCountdown.dataset.countdown = targetDate.toISOString();
  }
  if (mainCountdown) startCountdownFor(mainCountdown);
});