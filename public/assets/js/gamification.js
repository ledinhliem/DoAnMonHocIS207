(function () {
  const fallbackRewards = [
    { key: 'none_1', label: 'Không trúng' },
    { key: 'percent_5_a', label: '-5%' },
    { key: 'none_2', label: 'Ngày mai' },
    { key: 'percent_10_a', label: '-10%' },
    { key: 'free_ship_a', label: 'Freeship' },
    { key: 'none_3', label: 'Gần trúng' },
    { key: 'percent_5_b', label: '-5%' },
    { key: 'none_4', label: 'May mắn' },
    { key: 'percent_10_b', label: '-10%' },
    { key: 'free_ship_b', label: 'Freeship' },
  ];

  const palette = ['#f7d774', '#dff0c8', '#f7a7a0', '#b7d7f2', '#f3c1e1', '#d7d0ff', '#c8ecd9', '#ffe1a8', '#ffc6b8', '#c8e0ff'];
  let rewards = fallbackRewards;
  let rewardsLoaded = false;
  let styleMounted = false;

  function mountStyles() {
    if (styleMounted) return;
    styleMounted = true;

    const style = document.createElement('style');
    style.textContent = `
      .game-modal.hidden, .game-result-modal.hidden { display: none; }
      .game-modal, .game-result-modal { position: fixed; inset: 0; z-index: 99999; display: grid; place-items: center; padding: 20px; }
      .game-backdrop, .game-result-backdrop { position: absolute; inset: 0; background: rgba(20, 28, 18, .58); backdrop-filter: blur(4px); }
      .game-panel, .game-result-panel { position: relative; width: min(460px, 100%); background: #fffdf7; border: 1px solid rgba(47,81,42,.12); border-radius: 26px; padding: 28px; text-align: center; box-shadow: 0 28px 90px rgba(0,0,0,.25); animation: gameScaleIn .28s ease-out both; overflow: hidden; }
      .game-close, .game-result-close { position: absolute; top: 14px; right: 16px; width: 34px; height: 34px; border: 0; background: #eef1e7; color: #2F512A; border-radius: 50%; font-size: 19px; font-weight: 900; cursor: pointer; }
      .game-kicker, .game-result-kicker { margin: 0 0 6px; color: #8B5E34; font-size: 12px; font-weight: 900; letter-spacing: .12em; text-transform: uppercase; }
      .game-panel h2, .game-result-panel h2 { margin: 0 0 20px; color: #2F512A; font-size: 28px; font-weight: 900; line-height: 1.15; }
      .game-wheel-wrap { position: relative; width: min(280px, 72vw); height: min(280px, 72vw); margin: 0 auto 20px; }
      .game-pointer { position: absolute; top: -8px; left: 50%; transform: translateX(-50%); z-index: 2; width: 0; height: 0; border-left: 16px solid transparent; border-right: 16px solid transparent; border-top: 28px solid #2F512A; filter: drop-shadow(0 3px 4px rgba(0,0,0,.18)); }
      .game-wheel { position: absolute; inset: 0; border-radius: 50%; border: 8px solid #2F512A; transition: transform 3s cubic-bezier(.12,.78,.18,1); box-shadow: inset 0 0 0 4px #fff, 0 18px 40px rgba(47,81,42,.18); }
      .game-label { position: absolute; top: 50%; left: 50%; width: 86px; margin-left: -43px; margin-top: -11px; transform-origin: 43px 11px; font-weight: 900; color: #1f2d1c; font-size: 12px; text-align: center; line-height: 1.1; }
      .game-result { min-height: 44px; margin: 0 0 18px; color: #4d5b48; font-weight: 700; }
      .game-spin-btn, .game-result-primary, .game-result-secondary { border: 0; border-radius: 14px; padding: 14px 18px; font-weight: 900; cursor: pointer; text-decoration: none; display: inline-flex; justify-content: center; align-items: center; }
      .game-spin-btn { width: 100%; background: #2F512A; color: #fff; }
      .game-spin-btn:disabled { opacity: .65; cursor: wait; }
      .game-result-sticker { width: 104px; height: 104px; margin: 4px auto 14px; border-radius: 50%; display: grid; place-items: center; background: #eef7e8; font-size: 56px; box-shadow: inset 0 0 0 8px rgba(255,255,255,.75); }
      .game-result-panel.is-win .game-result-sticker { background: #fff3c4; animation: gameBounce 1.1s ease-in-out infinite; }
      .game-result-panel.is-lose .game-result-sticker { background: #edf4e7; animation: gameShake 1.8s ease-in-out infinite; }
      .game-result-panel.is-already_played .game-result-sticker { background: #eaf1ff; animation: gameFloat 2s ease-in-out infinite; }
      .game-result-message { margin: 0 auto 22px; color: #45513f; font-size: 16px; line-height: 1.55; font-weight: 700; max-width: 340px; }
      .game-result-code { display: inline-flex; margin: 0 auto 14px; padding: 8px 14px; border-radius: 999px; background: #2F512A; color: #fff; font-weight: 900; letter-spacing: .08em; }
      .game-result-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
      .game-result-primary { background: #2F512A; color: #fff; }
      .game-result-secondary { background: #eef1e7; color: #2F512A; }
      .game-confetti { position: absolute; top: -16px; left: var(--x); width: 9px; height: 14px; border-radius: 3px; background: var(--c); transform: rotate(var(--r)); animation: gameConfettiFall var(--d) ease-out forwards; pointer-events: none; }
      @keyframes gameScaleIn { from { opacity: 0; transform: scale(.92) translateY(12px); } to { opacity: 1; transform: scale(1) translateY(0); } }
      @keyframes gameBounce { 0%, 100% { transform: translateY(0) rotate(-4deg); } 50% { transform: translateY(-8px) rotate(5deg); } }
      @keyframes gameShake { 0%, 100% { transform: translateX(0); } 20% { transform: translateX(-3px) rotate(-3deg); } 40% { transform: translateX(3px) rotate(3deg); } 60% { transform: translateX(-2px); } }
      @keyframes gameFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-7px); } }
      @keyframes gameConfettiFall { to { top: 112%; transform: translateX(var(--dx)) rotate(720deg); opacity: 0; } }
      @media (max-width: 520px) { .game-panel, .game-result-panel { padding: 24px 18px; border-radius: 22px; } .game-panel h2, .game-result-panel h2 { font-size: 24px; } .game-result-actions { grid-template-columns: 1fr; } .game-label { font-size: 11px; } }
    `;
    document.head.appendChild(style);
  }

  function segmentAngle(index) {
    return ((index + 0.5) * 360) / rewards.length;
  }

  async function loadRewards() {
    if (rewardsLoaded) return;
    rewardsLoaded = true;

    try {
      const res = await fetch('?url=game/rewards', {
        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      });
      const data = await res.json();
      if (data.success && Array.isArray(data.rewards) && data.rewards.length) {
        rewards = data.rewards.filter((reward) => reward.key && reward.label);
      }
    } catch (err) {
      rewards = fallbackRewards;
    }
  }

  function renderWheel(wheel) {
    wheel.innerHTML = '';

    const segmentSize = 360 / rewards.length;
    const gradientParts = rewards.map((reward, index) => {
      const color = palette[index % palette.length];
      return `${color} ${index * segmentSize}deg ${(index + 1) * segmentSize}deg`;
    });
    wheel.style.background = `conic-gradient(${gradientParts.join(', ')})`;

    rewards.forEach((reward, index) => {
      const label = document.createElement('div');
      label.className = 'game-label';
      label.textContent = reward.label;
      label.style.transform = `rotate(${segmentAngle(index)}deg) translateY(-94px) rotate(90deg)`;
      wheel.appendChild(label);
    });
  }

  function ensureWheelModal() {
    mountStyles();
    let modal = document.getElementById('game-modal');
    if (modal) return modal;

    modal = document.createElement('div');
    modal.id = 'game-modal';
    modal.className = 'game-modal hidden';
    modal.innerHTML = `
      <div class="game-backdrop" data-game-close></div>
      <div class="game-panel" role="dialog" aria-modal="true" aria-labelledby="game-title">
        <button type="button" class="game-close" data-game-close aria-label="Đóng">×</button>
        <p class="game-kicker">Vòng quay xanh</p>
        <h2 id="game-title">Quay để nhận voucher</h2>
        <div class="game-wheel-wrap">
          <div class="game-pointer"></div>
          <div class="game-wheel" id="game-wheel"></div>
        </div>
        <p class="game-result" id="game-result">Mỗi tài khoản được chơi 1 lần mỗi ngày.</p>
        <button type="button" class="game-spin-btn" id="game-spin-btn">Quay ngay</button>
      </div>
    `;
    document.body.appendChild(modal);

    renderWheel(modal.querySelector('#game-wheel'));
    modal.querySelectorAll('[data-game-close]').forEach((node) => {
      node.addEventListener('click', () => modal.classList.add('hidden'));
    });
    modal.querySelector('#game-spin-btn').addEventListener('click', spin);
    return modal;
  }

  function targetAngle(rewardKey) {
    const index = rewards.findIndex((item) => item.key === rewardKey);
    return segmentAngle(index >= 0 ? index : 0);
  }

  function normalizedPopup(data) {
    const popup = data.popup || {};
    if (popup.status) return popup;

    if (!data.success) {
      return {
        status: 'already_played',
        title: 'Bạn đã quay hôm nay rồi',
        message: data.message || 'Mai quay lại thử vận may nhé!',
        code: data.voucher_code || null,
        redirect_url: data.voucher_code ? '?url=cart' : '',
      };
    }

    if (data.voucher_code) {
      return {
        status: 'win',
        title: 'Chúc mừng bạn!',
        message: `Bạn đã trúng voucher ${data.voucher_code}.`,
        code: data.voucher_code,
        redirect_url: '?url=cart',
      };
    }

    return {
      status: 'lose',
      title: 'Tiếc quá!',
      message: 'Hôm nay bạn chưa trúng voucher. Mai quay lại thử vận may nhé!',
      code: null,
      redirect_url: '',
    };
  }

  function showResultPopup(popup) {
    mountStyles();
    document.getElementById('game-result-modal')?.remove();

    const status = popup.status || 'lose';
    const isWin = status === 'win';
    const isAlready = status === 'already_played';
    const sticker = isWin ? '🎁' : (isAlready ? '⏰' : '🍃');
    const primaryText = isWin || (isAlready && popup.redirect_url) ? 'Dùng ngay trong giỏ hàng' : 'Mai quay lại';

    const modal = document.createElement('div');
    modal.id = 'game-result-modal';
    modal.className = 'game-result-modal';
    modal.innerHTML = `
      <div class="game-result-backdrop" data-game-result-close></div>
      <div class="game-result-panel is-${status}" role="dialog" aria-modal="true" aria-labelledby="game-result-title">
        <button type="button" class="game-result-close" data-game-result-close aria-label="Đóng">×</button>
        <p class="game-result-kicker">Vòng quay xanh</p>
        <div class="game-result-sticker">${sticker}</div>
        <h2 id="game-result-title">${escapeHtml(popup.title || 'Kết quả vòng quay')}</h2>
        ${popup.code ? `<div class="game-result-code">${escapeHtml(popup.code)}</div>` : ''}
        <p class="game-result-message">${escapeHtml(popup.message || '')}</p>
        <div class="game-result-actions">
          ${popup.redirect_url ? `<a class="game-result-primary" href="${escapeAttribute(popup.redirect_url)}">${primaryText}</a>` : `<button type="button" class="game-result-primary" data-game-result-close>${primaryText}</button>`}
          <button type="button" class="game-result-secondary" data-game-result-close>Đóng</button>
        </div>
      </div>
    `;
    document.body.appendChild(modal);
    modal.querySelectorAll('[data-game-result-close]').forEach((node) => {
      node.addEventListener('click', () => modal.remove());
    });

    if (isWin) {
      launchConfetti(modal.querySelector('.game-result-panel'));
    }
  }

  function launchConfetti(container) {
    const colors = ['#2F512A', '#8B5E34', '#f7d774', '#f7a7a0', '#b7d7f2', '#c8ecd9'];
    for (let i = 0; i < 42; i++) {
      const piece = document.createElement('span');
      piece.className = 'game-confetti';
      piece.style.setProperty('--x', `${Math.random() * 100}%`);
      piece.style.setProperty('--dx', `${Math.random() * 180 - 90}px`);
      piece.style.setProperty('--r', `${Math.random() * 180}deg`);
      piece.style.setProperty('--d', `${1.5 + Math.random() * 1.1}s`);
      piece.style.setProperty('--c', colors[i % colors.length]);
      container.appendChild(piece);
      setTimeout(() => piece.remove(), 2700);
    }
  }

  function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = String(value ?? '');
    return div.innerHTML;
  }

  function escapeAttribute(value) {
    return String(value ?? '').replace(/"/g, '&quot;');
  }

  async function spin() {
    const wheel = document.getElementById('game-wheel');
    const result = document.getElementById('game-result');
    const button = document.getElementById('game-spin-btn');

    button.disabled = true;
    result.textContent = 'Đang quay...';

    let data;
    try {
      const res = await fetch('?url=game/spin', {
        method: 'POST',
        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      });
      data = await res.json();
    } catch (err) {
      result.textContent = 'Không thể kết nối trò chơi. Vui lòng thử lại.';
      button.disabled = false;
      return;
    }

    if (!data.success && data.login_url) {
      window.location.href = data.login_url;
      return;
    }

    const popup = normalizedPopup(data);

    if (!data.success) {
      result.textContent = data.message || 'Hôm nay bạn đã chơi rồi.';
      button.textContent = 'Đã quay hôm nay';
      button.disabled = true;
      showResultPopup(popup);
      return;
    }

    const stopAt = targetAngle(data.reward);
    const rotation = 360 * 6 + (360 - stopAt);
    wheel.style.transform = `rotate(${rotation}deg)`;

    setTimeout(() => {
      result.textContent = data.message || 'Đã quay xong.';
      button.textContent = 'Đã quay hôm nay';
      button.disabled = true;
      showResultPopup(popup);
    }, 3100);
  }

  document.querySelectorAll('[data-game-open]').forEach((button) => {
    button.addEventListener('click', async () => {
      const modal = ensureWheelModal();
      modal.classList.remove('hidden');
      await loadRewards();
      const wheel = modal.querySelector('#game-wheel');
      wheel.style.transform = 'rotate(0deg)';
      renderWheel(wheel);
    });
  });

  const sessionPopup = document.getElementById('game-result-popup-data');
  if (sessionPopup) {
    try {
      showResultPopup(JSON.parse(sessionPopup.textContent || '{}'));
    } catch (err) {
      sessionPopup.remove();
    }
  }
})();
