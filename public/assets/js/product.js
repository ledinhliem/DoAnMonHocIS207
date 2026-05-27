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

      const submitter = e.submitter || document.activeElement;
      const isBuyNow = submitter?.value === "buy_now";
      const maBienThe = variantInput?.value?.trim();

      // Validate: phải chọn variant
      if (!maBienThe) {
        if (variantErr) {
          variantErr.classList.remove("hidden");
          setTimeout(() => variantErr.classList.add("hidden"), 4000);
        }
        return;
      }

      const btn = isBuyNow ? document.getElementById("btn-buy-now") : document.getElementById("btn-add-cart");
      const originalHtml = btn?.innerHTML;
      if (btn) { btn.innerHTML = "Đang thêm..."; btn.disabled = true; }

      try {
        const formData = new FormData(cartForm);
        if (isBuyNow) {
          formData.set("action", "buy_now");
        }

        const actionUrl = cartForm.dataset.cartAddUrl || cartForm.getAttribute("action") || "?url=cart/add";
        const res  = await fetch(actionUrl, {
          method: "POST",
          body: formData,
          credentials: "same-origin",
          headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
          }
        });
        const rawText = await res.text();
        let data = {};
        try {
          data = JSON.parse(rawText);
        } catch {
          throw new Error(rawText || "Server khong tra ve JSON hop le");
        }
        if (!res.ok) {
          throw new Error(data.message || `HTTP ${res.status}`);
        }
        if (data.redirect_url) {
          window.location.href = data.redirect_url;
          return;
        }
        showToast(data.message || "Đã thêm vào giỏ hàng!", data.success ? "success" : "error");
      } catch (error) {
        console.error("Add to cart failed:", error);
        showToast(error?.message || "Khong the them vao gio hang. Vui long thu lai.", "error");
      } finally {
        if (btn) { btn.innerHTML = originalHtml; btn.disabled = false; }
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
  const variantGroupOrder = [];
  document.querySelectorAll(".variant-btn").forEach(btn => {
    const type = btn.dataset.type;
    if (!variantGroups[type]) {
      variantGroups[type] = [];
      variantGroupOrder.push(type);
    }
    variantGroups[type].push(btn);
  });

  const selected = {};

  function normalizeText(value) {
    return String(value ?? "").trim();
  }

  function escapeCssValue(value) {
    if (window.CSS && typeof window.CSS.escape === "function") {
      return window.CSS.escape(value);
    }

    return String(value).replace(/["\\]/g, "\\$&");
  }

  function isNonApplicableValue(value) {
    return normalizeText(value) === "0";
  }

  function getVariantAttributes(variant) {
    return variant && typeof variant.attributes === "object" && variant.attributes !== null
      ? variant.attributes
      : {};
  }

  function getApplicableAttributes(variant) {
    const attrs = getVariantAttributes(variant);
    const applicable = {};

    Object.entries(attrs).forEach(([type, value]) => {
      const normalizedValue = normalizeText(value);
      if (normalizedValue !== "" && !isNonApplicableValue(normalizedValue)) {
        applicable[type] = normalizedValue;
      }
    });

    return applicable;
  }

  function variantMatchesSelection(variant, selection) {
    const attrs = getApplicableAttributes(variant);

    return Object.entries(selection).every(([type, value]) => {
      const selectedValue = normalizeText(value);
      if (selectedValue === "") {
        return true;
      }

      return normalizeText(attrs[type]) === selectedValue;
    });
  }

  function setButtonSelected(btn, isSelected) {
    btn.classList.toggle("border-primary", isSelected);
    btn.classList.toggle("ring-2", isSelected);
    btn.classList.toggle("ring-primary", isSelected);
    btn.classList.toggle("text-primary", isSelected);
    btn.classList.toggle("border-outline-variant", !isSelected);
  }

  function setSelectedLabel(type, value) {
    document.querySelectorAll(".selected-variant-label").forEach(label => {
      if (label.dataset.label === type) {
        label.textContent = value || "";
      }
    });
  }

  function getSelectionBeforeGroup(groupIndex) {
    const scopedSelection = {};

    variantGroupOrder.slice(0, groupIndex).forEach(previousType => {
      if (selected[previousType]) {
        scopedSelection[previousType] = selected[previousType];
      }
    });

    return scopedSelection;
  }

  function getAvailableValues(type, selection) {
    const values = new Set();
    variants.forEach(variant => {
      if (!variantMatchesSelection(variant, selection)) {
        return;
      }

      const attrs = getApplicableAttributes(variant);
      const value = normalizeText(attrs[type]);
      if (value !== "") {
        values.add(value);
      }
    });

    return values;
  }

  function updateVariantOptions() {
    variantGroupOrder.forEach((type, groupIndex) => {
      const availableValues = getAvailableValues(type, getSelectionBeforeGroup(groupIndex));
      const groupWrap = document.querySelector(`[data-variant-group="${escapeCssValue(type)}"]`);
      const shouldShowGroup = availableValues.size > 0;

      if (groupWrap) {
        groupWrap.classList.toggle("hidden", !shouldShowGroup);
      }

      if (!shouldShowGroup) {
        delete selected[type];
        setSelectedLabel(type, "");
      }

      variantGroups[type].forEach(btn => {
        const isAvailable = availableValues.has(normalizeText(btn.dataset.value));
        btn.disabled = !isAvailable;
        btn.classList.toggle("opacity-40", !isAvailable);
        btn.classList.toggle("cursor-not-allowed", !isAvailable);

        if (!isAvailable && selected[type] === btn.dataset.value) {
          delete selected[type];
          setSelectedLabel(type, "");
          setButtonSelected(btn, false);
        }
      });
    });
  }

  function autoSelectRequiredOptions() {
    variantGroupOrder.forEach(type => {
      const groupWrap = document.querySelector(`[data-variant-group="${escapeCssValue(type)}"]`);
      if (groupWrap?.classList.contains("hidden") || selected[type]) {
        return;
      }

      const firstAvailable = variantGroups[type].find(btn => !btn.disabled);
      if (firstAvailable) {
        selectVariantOption(firstAvailable, false);
      }
    });
  }

  function findMatchingVariant() {
    const selectedEntries = Object.entries(selected)
      .filter(([, value]) => normalizeText(value) !== "");

    if (selectedEntries.length === 0) {
      return variants[0] || null;
    }

    const matches = variants.filter(variant => variantMatchesSelection(variant, selected));

    matches.sort((a, b) => {
      const aCount = Object.keys(getApplicableAttributes(a)).length;
      const bCount = Object.keys(getApplicableAttributes(b)).length;
      return bCount - aCount;
    });

    return matches[0] || null;
  }

  function updateVariantInfo(variant) {
    const priceEl = document.getElementById("display-price");
    const variantIdEl = document.getElementById("selected-variant-id");
    const qtyInput = document.getElementById("quantity");
    const stockInfo = document.getElementById("stock-info");
    const stockQty = document.getElementById("stock-qty");

    if (!variant) {
      return;
    }

    if (priceEl) {
      const salePrice = Number(variant.GiaSale || 0);
      const originalPrice = Number(variant.GiaTien || 0);

      if (variant.is_flash_sale && salePrice > 0 && salePrice < originalPrice) {
        priceEl.innerHTML =
          `<span class="block text-base text-outline line-through">${originalPrice.toLocaleString("vi-VN")} ₫</span>` +
          `<span class="text-red-600">${salePrice.toLocaleString("vi-VN")} ₫</span>`;
      } else {
        priceEl.textContent = `${originalPrice.toLocaleString("vi-VN")} ₫`;
      }
    }

    if (variantIdEl) {
      variantIdEl.value = variant.MaBienThe || "";
    }
    const variantAliasEl = document.getElementById("selected-variant-id-alias");
    if (variantAliasEl) {
      variantAliasEl.value = variant.MaBienThe || "";
    }

    if (qtyInput) {
      const stock = Number.parseInt(variant.SoLuongTon, 10) || 0;
      qtyInput.max = stock;

      if ((Number.parseInt(qtyInput.value, 10) || 1) > stock) {
        qtyInput.value = stock > 0 ? stock : 1;
      }
    }

    if (stockInfo && stockQty) {
      const stock = Number.parseInt(variant.SoLuongTon, 10) || 0;
      stockQty.textContent = stock > 0 ? stock : "Hết hàng";
      stockInfo.classList.remove("hidden");
    }
  }

  function refreshMatchedVariant() {
    const match = findMatchingVariant();
    if (match) {
      updateVariantInfo(match);
    } else if (variantInput) {
      variantInput.value = "";
    }
  }

  function selectVariantOption(btn, shouldRefresh = true) {
    const type = btn.dataset.type;

    variantGroups[type].forEach(b => setButtonSelected(b, false));
    setButtonSelected(btn, true);

    selected[type] = btn.dataset.value;
    setSelectedLabel(type, btn.dataset.value);

    updateVariantOptions();

    if (shouldRefresh) {
      autoSelectRequiredOptions();
      refreshMatchedVariant();
    }
  }

  document.querySelectorAll(".variant-btn").forEach(btn => {
    btn.addEventListener("click", function () {
      if (this.disabled) {
        return;
      }

      selectVariantOption(this);
    });
  });

  updateVariantOptions();
  autoSelectRequiredOptions();
  refreshMatchedVariant();

  const firstDirectVariant = document.querySelector(".variant-direct-btn");
  if (firstDirectVariant) {
    firstDirectVariant.click();
  }
});

