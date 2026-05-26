(function () {
  const nodes = document.querySelectorAll('[data-flash-countdown]');
  if (!nodes.length) return;

  function pad(value) {
    return String(value).padStart(2, '0');
  }

  function render() {
    nodes.forEach((node) => {
      const endTime = new Date(node.dataset.endTime || '').getTime();
      if (!endTime) {
        node.textContent = '';
        return;
      }

      const remaining = Math.max(0, endTime - Date.now());
      if (remaining <= 0) {
        node.textContent = 'Đã hết thời gian sale';
        return;
      }

      const totalSeconds = Math.floor(remaining / 1000);
      const days = Math.floor(totalSeconds / 86400);
      const hours = Math.floor((totalSeconds % 86400) / 3600);
      const minutes = Math.floor((totalSeconds % 3600) / 60);
      const seconds = totalSeconds % 60;

      node.textContent = days > 0
        ? `${days} ngày ${pad(hours)}:${pad(minutes)}:${pad(seconds)}`
        : `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
    });
  }

  render();
  setInterval(render, 1000);
})();
