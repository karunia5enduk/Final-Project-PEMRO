document.addEventListener('DOMContentLoaded', function () {
  var toggle = document.querySelector('[data-nav-toggle]');
  var nav = document.querySelector('[data-nav]');
  if (toggle && nav) toggle.addEventListener('click', function () { nav.classList.toggle('open'); });

  var search = document.querySelector('[data-event-search]');
  var prodi = document.querySelector('[data-event-prodi]');
  var category = document.querySelector('[data-event-category]');
  var cards = Array.prototype.slice.call(document.querySelectorAll('[data-event-card]'));
  function filterEvents() {
    var q = (search && search.value || '').toLowerCase();
    var p = prodi && prodi.value || '';
    var c = category && category.value || '';
    cards.forEach(function (card) {
      var matchQ = !q || card.dataset.title.indexOf(q) !== -1;
      var matchP = !p || card.dataset.prodi === p;
      var matchC = !c || card.dataset.category === c;
      card.style.display = matchQ && matchP && matchC ? '' : 'none';
    });
  }
  [search, prodi, category].forEach(function (el) { if (el) el.addEventListener('input', filterEvents); });

  document.querySelectorAll('[data-countdown]').forEach(function (box) {
    var target = new Date(box.dataset.countdown).getTime();
    function tick() {
      var diff = target - Date.now();
      if (diff <= 0) { box.textContent = 'Event sedang berlangsung atau telah selesai'; return; }
      var d = Math.floor(diff / 86400000);
      var h = Math.floor(diff % 86400000 / 3600000);
      var m = Math.floor(diff % 3600000 / 60000);
      box.textContent = d + ' hari ' + h + ' jam ' + m + ' menit lagi';
    }
    tick(); setInterval(tick, 60000);
  });
});