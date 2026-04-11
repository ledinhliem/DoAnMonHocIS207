// Product page JavaScript

let allProducts = [];

document.addEventListener("DOMContentLoaded", function () {
  console.log("Product page loaded");

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