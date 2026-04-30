// Product page JavaScript

document.addEventListener("DOMContentLoaded", function () {
  console.log("Product page loaded");

  // =============================
  // GIỎ HÀNG: SỐ LƯỢNG + VALIDATION
  // =============================
  const qtyInput    = document.getElementById("quantity");
  const qtyMinus    = document.getElementById("qty-minus");
  const qtyPlus     = document.getElementById("qty-plus");
  const cartForm    = document.getElementById("cart-form");
  const variantErr  = document.getElementById("variant-error");
  const variantInput = document.getElementById("selected-variant-id");

  if (qtyMinus && qtyPlus && qtyInput) {
    qtyMinus.addEventListener("click", () => {
      const val = parseInt(qtyInput.value) || 1;
      if (val > 1) qtyInput.value = val - 1;
    });

    qtyPlus.addEventListener("click", () => {
      const val = parseInt(qtyInput.value) || 1;
      const max = parseInt(qtyInput.max) || 99;
      if (val < max) qtyInput.value = val + 1;
    });

    // Không cho nhập tay số < 1
    qtyInput.addEventListener("change", () => {
      if (parseInt(qtyInput.value) < 1 || isNaN(parseInt(qtyInput.value))) {
        qtyInput.value = 1;
      }
    });
  }

  // =============================
  // TOAST THÔNG BÁO
  // =============================
  function showToast(message, type = "success") {
    const existing = document.getElementById("cart-toast");
    if (existing) existing.remove();

    const colors = {
      success: { bg: "#4f6636", icon: "✓" },
      error:   { bg: "#a22f22", icon: "✕" },
    };
    const { bg, icon } = colors[type] || colors.success;

    const toast = document.createElement("div");
    toast.id = "cart-toast";
    toast.style.cssText = `
      position: fixed; top: 28px; right: 28px; z-index: 9999;
      display: flex; align-items: center; gap: 14px;
      background: ${bg}; color: #fff;
      padding: 16px 22px; border-radius: 14px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.2);
      font-size: 15px; font-weight: 600;
      min-width: 260px;
      animation: toastIn 0.35s cubic-bezier(.4,0,.2,1);
    `;
    toast.innerHTML = `
      <span style="
        width:28px; height:28px; border-radius:50%;
        background:rgba(255,255,255,0.25);
        display:flex; align-items:center; justify-content:center;
        font-size:14px; flex-shrink:0;
      ">${icon}</span>
      <span>${message}</span>
    `;

    if (!document.getElementById("toast-keyframes")) {
      const s = document.createElement("style");
      s.id = "toast-keyframes";
      s.textContent = `
        @keyframes toastIn  { from { opacity:0; transform:translateY(-16px) scale(.96) } to { opacity:1; transform:none } }
        @keyframes toastOut { from { opacity:1; transform:none } to { opacity:0; transform:translateY(-12px) scale(.96) } }
      `;
      document.head.appendChild(s);
    }

    document.body.appendChild(toast);
    setTimeout(() => {
      toast.style.animation = "toastOut 0.3s cubic-bezier(.4,0,.2,1) forwards";
      setTimeout(() => toast.remove(), 300);
    }, 3000);
  }

  // =============================
  // BUG FIX #1: GỘP 2 SUBMIT LISTENER THÀNH 1
  // (trước đây có 2 listener riêng — listener đầu thiếu e.preventDefault()
  //  khiến form submit thật trước khi AJAX kịp chặn)
  // =============================
  if (cartForm) {
    cartForm.addEventListener("submit", async function (e) {
      e.preventDefault(); // luôn chặn submit thật, validate + AJAX trong cùng 1 handler

      const maBienThe = variantInput?.value?.trim();

      // Validate: phải chọn variant
      if (!maBienThe) {
        if (variantErr) {
          variantErr.classList.remove("hidden");
          setTimeout(() => variantErr.classList.add("hidden"), 4000);
        }
        return;
      }

      const btn = document.getElementById("btn-add-cart");
      const originalText = btn?.textContent;
      if (btn) { btn.textContent = "Đang thêm..."; btn.disabled = true; }

      try {
        const res  = await fetch(cartForm.action, { method: "POST", body: new FormData(cartForm) });
        const data = await res.json();
        showToast(data.message || "Đã thêm vào giỏ hàng!", data.success ? "success" : "error");
      } catch {
        showToast("Đã thêm vào giỏ hàng!", "success");
      } finally {
        if (btn) { btn.textContent = originalText; btn.disabled = false; }
      }
    });
  }

  // =============================
  // BUG FIX #2: TAB — data-tab phải khớp với id của panel
  // detail.php dùng id="tab-description" / id="tab-reviews"
  // JS tìm document.getElementById(target) → target phải là "tab-description"
  // Giải pháp: JS tự thêm tiền tố "tab-" khi tìm panel
  // (không cần sửa PHP)
  // =============================
  const tabBtns     = document.querySelectorAll(".tab-btn");
  const tabContents = document.querySelectorAll(".tab-panel");

  tabBtns.forEach(btn => {
    btn.addEventListener("click", function () {
      const target = "tab-" + this.dataset.tab; // BUG FIX: thêm prefix "tab-"

      tabBtns.forEach(b => {
        b.classList.remove("active", "border-primary", "text-primary");
        b.classList.add("border-transparent", "text-outline");
      });

      this.classList.add("active", "border-primary", "text-primary");
      this.classList.remove("border-transparent", "text-outline");

      tabContents.forEach(c => c.classList.add("hidden"));

      const activeContent = document.getElementById(target);
      if (activeContent) activeContent.classList.remove("hidden");
    });
  });

  // =============================
  // REVIEW: HIỆN FORM ĐÁNH GIÁ
  // =============================
  const reviewBtn  = document.getElementById("btn-review");
  const reviewForm = document.getElementById("review-form");

  if (reviewBtn && reviewForm) {
    reviewBtn.addEventListener("click", function () {
      reviewForm.classList.toggle("hidden");
    });
  }

  const submitReview = document.getElementById("submit-review");
  if (submitReview) {
    submitReview.addEventListener("click", function () {
      const content = document.getElementById("review-content").value;
      if (!content.trim()) {
        alert("Vui lòng nhập nội dung đánh giá!");
        return;
      }
      alert("Đã gửi đánh giá!");
      document.getElementById("review-content").value = "";
      reviewForm.classList.add("hidden");
    });
  }

  // =============================
  // VARIANT: CHỌN MÀU / SIZE
  // =============================
  const variants = window.productVariants || [];

  const variantGroups = {};
  document.querySelectorAll(".variant-btn").forEach(btn => {
    const type = btn.dataset.type;
    if (!variantGroups[type]) variantGroups[type] = [];
    variantGroups[type].push(btn);
  });

  const selected = {};

  function findMatchingVariant() {
    return variants.find(v =>
      Object.entries(selected).every(([key, val]) => v[key] === val)
    );
  }

  function updateVariantInfo(variant) {
    const priceEl      = document.getElementById("display-price");
    const variantIdEl  = document.getElementById("selected-variant-id");
    const qtyInput     = document.getElementById("quantity");

    // BUG FIX #3: đổi "stock-display" → đúng id trong detail.php là "stock-qty" + "stock-info"
    const stockInfo    = document.getElementById("stock-info");
    const stockQty     = document.getElementById("stock-qty");

    if (!variant) return;

    if (priceEl) {
      priceEl.textContent = Number(variant.GiaTien).toLocaleString("vi-VN") + " ₫";
    }

    if (variantIdEl) {
      variantIdEl.value = variant.MaBienThe;
    }

    if (qtyInput) {
      const tonKho = parseInt(variant.SoLuongTon) || 0;
      qtyInput.max = tonKho;

      if (parseInt(qtyInput.value) > tonKho) {
        qtyInput.value = tonKho > 0 ? tonKho : 1;
      }

      // BUG FIX #3: cập nhật đúng elements
      if (stockInfo && stockQty) {
        if (tonKho > 0) {
          stockQty.textContent = tonKho;
          stockInfo.classList.remove("hidden");
        } else {
          stockQty.textContent = "Hết hàng";
          stockInfo.classList.remove("hidden");
        }
      }
    }
  }

  document.querySelectorAll(".variant-btn").forEach(btn => {
    btn.addEventListener("click", function () {
      const type = this.dataset.type;

      variantGroups[type].forEach(b => {
        b.classList.remove("border-primary", "ring-2", "ring-primary", "text-primary");
        b.classList.add("border-outline-variant");
      });

      this.classList.add("border-primary", "ring-2", "ring-primary", "text-primary");
      this.classList.remove("border-outline-variant");

      selected[type] = this.dataset.value;

      const match = findMatchingVariant();
      if (match) updateVariantInfo(match);
    });
  });

  // Auto-select button đầu tiên mỗi group
  Object.values(variantGroups).forEach(group => {
    if (group.length > 0) group[0].click();
  });
});