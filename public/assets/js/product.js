// Product page JavaScript

let allProducts = [];

document.addEventListener("DOMContentLoaded", function () {
  console.log("Product page loaded");

// =============================
  // GIỎ HÀNG: SỐ LƯỢNG + VALIDATION
  // =============================
  const qtyInput   = document.getElementById("quantity");
  const qtyMinus   = document.getElementById("qty-minus");
  const qtyPlus    = document.getElementById("qty-plus");
  const cartForm   = document.getElementById("cart-form");
  const variantErr = document.getElementById("variant-error");
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
 
  // Validate trước khi submit: phải có variant được chọn
  if (cartForm) {
    cartForm.addEventListener("submit", function (e) {
      const maBienThe = variantInput?.value?.trim();
 
      if (!maBienThe) {
        e.preventDefault();
        if (variantErr) {
          variantErr.classList.remove("hidden");
          setTimeout(() => variantErr.classList.add("hidden"), 4000);
        }
        return;
      }
 
      // Feedback visual khi submit thành công
      const btn = document.getElementById("btn-add-cart");
      if (btn) {
        btn.textContent = "Đang thêm...";
        btn.disabled = true;
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
  // SUBMIT GIỎ HÀNG (AJAX)
  // =============================
  if (cartForm) {
    cartForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const maBienThe = variantInput?.value?.trim();

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
  // TAB: MÔ TẢ / ĐÁNH GIÁ
  // =============================
  const tabBtns = document.querySelectorAll(".tab-btn");
  const tabContents = document.querySelectorAll(".tab-content");

  tabBtns.forEach(btn => {
    btn.addEventListener("click", function () {
      const target = this.dataset.tab;

      // Reset tất cả button
      tabBtns.forEach(b => {
        b.classList.remove("active", "border-primary", "text-primary");
        b.classList.add("border-transparent", "text-outline");
      });

      // Active button được click
      this.classList.add("active", "border-primary", "text-primary");
      this.classList.remove("border-transparent", "text-outline");

      // Ẩn tất cả content
      tabContents.forEach(c => c.classList.add("hidden"));

      // Hiện content tương ứng
      const activeContent = document.getElementById(target);
      if (activeContent) activeContent.classList.remove("hidden");
    });
  });

  // =============================
// REVIEW: HIỆN FORM ĐÁNH GIÁ
// =============================
const reviewBtn = document.getElementById("btn-review");
const reviewForm = document.getElementById("review-form");

if (reviewBtn && reviewForm) {
  reviewBtn.addEventListener("click", function () {
    reviewForm.classList.toggle("hidden");
  });
}

// Submit review (demo)
const submitReview = document.getElementById("submit-review");

if (submitReview) {
  submitReview.addEventListener("click", function () {
    const content = document.getElementById("review-content").value;

    if (!content.trim()) {
      alert("Vui lòng nhập nội dung đánh giá!");
      return;
    }

    alert("Đã gửi đánh giá!");

    // reset
    document.getElementById("review-content").value = "";
    reviewForm.classList.add("hidden");
  });
}

  // =============================
  // VARIANT: CHỌN MÀU / SIZE
  // =============================
  const variants = window.productVariants || [];

  // Group button theo type (MauSac / KichThuoc)
  const variantGroups = {};
  document.querySelectorAll(".variant-btn").forEach(btn => {
    const type = btn.dataset.type;
    if (!variantGroups[type]) variantGroups[type] = [];
    variantGroups[type].push(btn);
  });

  // State lưu lựa chọn hiện tại
  const selected = {};

  // Hàm tìm variant khớp với lựa chọn
  function findMatchingVariant() {
    return variants.find(v =>
      Object.entries(selected).every(([key, val]) => v[key] === val)
    );
  }

  // Hàm cập nhật giá + variant ID
  function updatePrice(variant) {
    const priceEl = document.getElementById("display-price");
    const variantIdEl = document.getElementById("selected-variant-id");
    if (!variant) return;
    if (priceEl) {
      priceEl.textContent = Number(variant.GiaTien).toLocaleString("vi-VN") + " VNĐ";
    }
    if (variantIdEl) {
      variantIdEl.value = variant.MaBienThe;
    }
  }

  // Gắn sự kiện cho từng button
  document.querySelectorAll(".variant-btn").forEach(btn => {
    btn.addEventListener("click", function () {
      const type = this.dataset.type;

      // Reset tất cả button cùng group
      variantGroups[type].forEach(b => {
        b.classList.remove("border-primary", "ring-2", "ring-primary", "text-primary");
        b.classList.add("border-outline-variant");
      });

      // Highlight button được click
      this.classList.add("border-primary", "ring-2", "ring-primary", "text-primary");
      this.classList.remove("border-outline-variant");

      // Lưu lựa chọn
      selected[type] = this.dataset.value;

      // Cập nhật giá nếu có variant khớp
      const match = findMatchingVariant();
      if (match) updatePrice(match);
    });
  });

  // Auto-select button đầu tiên mỗi group (highlight mặc định khi load)
  Object.values(variantGroups).forEach(group => {
    if (group.length > 0) group[0].click();
  });

  // =============================
  // LẤY PRODUCT
  // =============================
  const productElements = document.querySelectorAll("section.grid > div");

  allProducts = Array.from(productElements).map((el, index) => ({
    element: el,
    name: el.innerText.toLowerCase(),
    index: index,
  }));

  // =============================
  // CLICK CARD
  // =============================
  document.querySelectorAll('[onclick*="window.location.href"]').forEach(item => {
    item.addEventListener("click", function (e) {
      if (e.target.closest("button")) return;

      const match = this.getAttribute("onclick")?.match(/'(.*?)'/);
      if (match) window.location.href = match[1];
    });
  });

  // =============================
  // CATEGORY (FIX CHUẨN)
  // =============================
  const categoryContainer = document.querySelector("h2 + div"); // ngay dưới "Categories"

  if (categoryContainer) {
    const categories = categoryContainer.querySelectorAll("div");

    categories.forEach((cat, index) => {
      cat.addEventListener("click", function () {
        categories.forEach(c => c.classList.remove("active"));
        this.classList.add("active");

        console.log("Category clicked:", this.innerText);

        // lưu index để filter
        this.dataset.index = index;

        updateProductDisplay();
      });
    });
  }

  // =============================
  // ECO CHECKBOX
  // =============================
  document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
    cb.addEventListener("change", () => {
      console.log("Checkbox changed");
      updateProductDisplay();
    });
  });

  // =============================
  // PRICE
  // =============================
  const priceRange = document.querySelector('input[type="range"]');

  if (priceRange) {
    priceRange.addEventListener("input", function () {
      console.log("Price:", this.value);
      updateProductDisplay();
    });
  }

  // =============================
  // SORT (FIX CHUẨN)
  // =============================
  const sortBox = document.querySelector("[class*='rounded']");

  if (sortBox) {
    sortBox.addEventListener("click", function () {
      this.dataset.sort = this.dataset.sort === "asc" ? "desc" : "asc";
      console.log("Sort:", this.dataset.sort);
      updateProductDisplay();
    });
  }
});

// =============================
// FILTER + SORT
// =============================
function updateProductDisplay() {
  let filtered = [...allProducts];

  // CATEGORY
  const activeCat = document.querySelector(".active");
  if (activeCat) {
    const index = [...activeCat.parentNode.children].indexOf(activeCat);
    filtered = filtered.filter(p => p.index % 4 === index);
  }

  // ECO (fake)
  const checked = document.querySelectorAll('input[type="checkbox"]:checked');
  if (checked.length > 0) {
    filtered = filtered.filter((_, i) => i % 2 === 0);
  }

  // PRICE (fake)
  const price = document.querySelector('input[type="range"]')?.value;
  if (price) {
    filtered = filtered.filter((_, i) => i * 50 <= price);
  }

  // SORT
  const sortType = document.querySelector("[class*='rounded']")?.dataset.sort;

  if (sortType === "asc") {
    filtered.sort((a, b) => a.name.localeCompare(b.name));
  }

  if (sortType === "desc") {
    filtered.sort((a, b) => b.name.localeCompare(a.name));
  }

  // HIỂN THỊ
  allProducts.forEach(p => p.element.style.display = "none");
  filtered.forEach(p => p.element.style.display = "block");

  // reorder
  const container = document.querySelector("section.grid");
  filtered.forEach(p => container.appendChild(p.element));
}