
(function () {
  'use strict';

  // ─── Cấu hình ────────────────────────────────────────────────
  const POLL_ENDPOINT     = '?url=order/pending-notification';
  const MARK_ENDPOINT     = '?url=order/mark-notified';
  const FEEDBACK_BASE_URL = '?url=order/feedback';

  // Thời gian chờ trước khi hiện pop-up (ms) để tránh giật giao diện
  const SHOW_DELAY_MS = 1200;

  // ─── Hàm chính ───────────────────────────────────────────────
  async function init() {
    try {
      const res  = await fetch(POLL_ENDPOINT, { credentials: 'same-origin' });
      const data = await res.json();

      if (!data.order) return; // không có đơn pending → dừng

      const { MaDonHang, MaSanPham } = data.order;

      // Đánh dấu đã thông báo ngay lập tức (không chờ user nhấn)
      // để reload trang không hiện lại
      await markAsNotified(MaDonHang);

      // Hiện pop-up sau một chút delay
      setTimeout(() => renderPopup(MaDonHang, MaSanPham), SHOW_DELAY_MS);
    } catch (err) {
      // Lỗi mạng / parse JSON → silent fail, không ảnh hưởng UX
      console.warn('[OrderNotification] Không thể kiểm tra thông báo:', err);
    }
  }

  async function markAsNotified(orderId) {
    try {
      const form = new FormData();
      form.append('MaDonHang', orderId);
      await fetch(MARK_ENDPOINT, {
        method: 'POST',
        body: form,
        credentials: 'same-origin',
      });
    } catch (err) {
      console.warn('[OrderNotification] Không thể mark notified:', err);
    }
  }

  // ─── Render pop-up ───────────────────────────────────────────
  function renderPopup(orderId, productId) {
    // Tránh tạo trùng nếu hàm được gọi nhiều lần
    if (document.getElementById('order-notif-popup')) return;

    injectStyles();

    // URL không qua escapeHtml (escapeHtml biến & thành &amp; làm hỏng href)
    // encodeURIComponent đã xử lý an toàn cho từng tham số
    const feedbackUrl =
      FEEDBACK_BASE_URL +
      '&id=' + encodeURIComponent(orderId) +
      '&product=' + encodeURIComponent(productId);

    // ── Tạo markup ──
    const popup = document.createElement('div');
    popup.id = 'order-notif-popup';
    popup.setAttribute('role', 'alert');
    popup.setAttribute('aria-live', 'polite');

    // Tạo phần tử từng bước thay vì innerHTML để tránh XSS và lỗi URL
    popup.innerHTML = `
      <button class="order-notif-close" id="order-notif-close" aria-label="Đóng thông báo">✕</button>

      <div class="order-notif-icon-wrap">
        <svg class="order-notif-icon" viewBox="0 0 24 24" fill="none"
             xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77
                   L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"
                fill="currentColor"/>
        </svg>
      </div>

      <div class="order-notif-body">
        <p class="order-notif-title">Đơn hàng đã được giao!</p>
        <p class="order-notif-desc">
          Đơn <strong>#${escapeHtml(orderId)}</strong> đã hoàn thành.<br>
          Hãy để lại đánh giá của bạn nhé.
        </p>
        <a class="order-notif-btn">Đánh giá ngay →</a>
      </div>
    `;

    // Gán href bằng DOM API — trình duyệt tự xử lý encode đúng cách
    popup.querySelector('.order-notif-btn').href = feedbackUrl;

    document.body.appendChild(popup);

    // Kích hoạt animation vào
    requestAnimationFrame(() => {
      requestAnimationFrame(() => popup.classList.add('order-notif-visible'));
    });

    // Nút đóng
    document.getElementById('order-notif-close').addEventListener('click', () => {
      closePopup(popup);
    });

    // Tự đóng sau 12 giây (tuỳ chọn)
    setTimeout(() => closePopup(popup), 12000);
  }

  function closePopup(popup) {
    popup.classList.remove('order-notif-visible');
    popup.classList.add('order-notif-hidden');
    // Xoá khỏi DOM sau khi animation kết thúc
    popup.addEventListener('transitionend', () => popup.remove(), { once: true });
  }

  // ─── Styles (inject một lần) ─────────────────────────────────
  function injectStyles() {
    if (document.getElementById('order-notif-styles')) return;

    const css = `
      #order-notif-popup {
        /* Layout */
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        width: 320px;
        max-width: calc(100vw - 32px);

        /* Appearance — dùng lại CSS variables của Zentro nếu có,
           fallback về giá trị cụ thể nếu không */
        background: var(--color-surface-container, #ffffff);
        color: var(--color-primary, #2d6a4f);
        border: 1px solid var(--color-outline-variant, #d0e4d7);
        border-radius: 16px;
        padding: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);

        /* Transition */
        opacity: 0;
        transform: translateY(16px) scale(0.97);
        transition: opacity 0.35s ease, transform 0.35s cubic-bezier(0.34,1.56,0.64,1);
        pointer-events: none;
      }

      #order-notif-popup.order-notif-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
      }

      #order-notif-popup.order-notif-hidden {
        opacity: 0;
        transform: translateY(16px) scale(0.97);
        pointer-events: none;
      }

      .order-notif-close {
        position: absolute;
        top: 10px;
        right: 12px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 13px;
        line-height: 1;
        color: var(--color-on-surface-variant, #6b7c74);
        opacity: 0.6;
        padding: 2px 4px;
        border-radius: 4px;
        transition: opacity 0.2s;
      }
      .order-notif-close:hover { opacity: 1; }

      .order-notif-icon-wrap {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--color-primary, #2d6a4f);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 2px;
      }

      .order-notif-icon {
        width: 18px;
        height: 18px;
        color: #ffffff;
      }

      .order-notif-body {
        flex: 1;
        min-width: 0;
        padding-right: 16px; /* space for close btn */
      }

      .order-notif-title {
        margin: 0 0 4px;
        font-size: 14px;
        font-weight: 700;
        color: var(--color-primary, #2d6a4f);
        line-height: 1.3;
      }

      .order-notif-desc {
        margin: 0 0 12px;
        font-size: 13px;
        color: var(--color-on-surface-variant, #4a5e55);
        line-height: 1.5;
      }

      .order-notif-btn {
        display: inline-block;
        padding: 7px 14px;
        border-radius: 8px;
        background: var(--color-primary, #2d6a4f);
        color: #ffffff !important;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none !important;
        transition: opacity 0.2s, transform 0.15s;
      }
      .order-notif-btn:hover {
        opacity: 0.88;
        transform: translateY(-1px);
      }

      @media (max-width: 480px) {
        #order-notif-popup {
          bottom: 16px;
          right: 16px;
          left: 16px;
          width: auto;
        }
      }
    `;

    const style = document.createElement('style');
    style.id = 'order-notif-styles';
    style.textContent = css;
    document.head.appendChild(style);
  }

  // ─── Tiện ích ─────────────────────────────────────────────────
  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  // ─── Khởi chạy sau khi DOM sẵn sàng ─────────────────────────
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();