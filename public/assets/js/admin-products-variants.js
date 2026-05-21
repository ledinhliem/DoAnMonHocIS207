/**
 * products-variant.js
 * Xử lý UI cho trang Biến thể sản phẩm (admin/products/variants)
 */

(function () {
    'use strict';

    // ── 1. Tự động ẩn flash message sau 4 giây ────────────
    const flash = document.getElementById('flash-msg');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity 0.5s ease';
            flash.style.opacity    = '0';
            setTimeout(() => flash.remove(), 500);
        }, 4000);
    }

    // ── 2. Modal helpers (dùng chung) ─────────────────────
    /**
     * Mở modal theo ID
     * @param {string} id
     */
    window.openModal = function (id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    };

    /**
     * Đóng modal theo ID
     * @param {string} id
     */
    window.closeModal = function (id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    };

    // Đóng modal khi click backdrop
    document.querySelectorAll('#modal-add, #modal-edit').forEach(modal => {
        modal.addEventListener('click', e => {
            if (e.target === modal) closeModal(modal.id);
        });
    });

    // Đóng modal bằng phím Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeModal('modal-add');
            closeModal('modal-edit');
        }
    });

    // ── 3. Populate modal Sửa biến thể ────────────────────
    /**
     * Mở modal chỉnh sửa và điền dữ liệu vào form.
     * Được gọi từ inline onclick trong PHP:
     *   onclick='openEditModal({ma, mau, size, gia, sl})'
     *
     * @param {{ ma: string, mau: string, size: string, gia: number|string, sl: number|string }} data
     */
    window.openEditModal = function (data) {
        const setVal = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.value = val ?? '';
        };
        const setText = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.textContent = val ?? '';
        };

        setVal ('edit-ma',   data.ma   ?? '');
        setVal ('edit-mau',  data.mau  ?? '');
        setVal ('edit-size', data.size ?? '');
        setVal ('edit-gia',  data.gia  ?? '');
        setVal ('edit-sl',   data.sl   ?? '');
        setText('edit-ma-display', data.ma ?? '');

        openModal('modal-edit');
    };

    // ── 4. Validate form thêm biến thể ────────────────────
    const formAdd = document.querySelector('#modal-add form');
    if (formAdd) {
        formAdd.addEventListener('submit', e => {
            const gia = parseFloat(formAdd.querySelector('[name="gia_tien"]')?.value ?? 0);
            const sl  = parseInt(formAdd.querySelector('[name="so_luong_ton"]')?.value ?? -1, 10);

            if (isNaN(gia) || gia < 0) {
                e.preventDefault();
                highlightField(formAdd, 'gia_tien', 'Giá bán phải lớn hơn hoặc bằng 0');
                return;
            }
            if (isNaN(sl) || sl < 0) {
                e.preventDefault();
                highlightField(formAdd, 'so_luong_ton', 'Số lượng phải lớn hơn hoặc bằng 0');
                return;
            }
        });
    }

    // ── 5. Validate form sửa biến thể ─────────────────────
    const formEdit = document.getElementById('form-edit');
    if (formEdit) {
        formEdit.addEventListener('submit', e => {
            const gia = parseFloat(formEdit.querySelector('[name="gia_tien"]')?.value ?? 0);
            const sl  = parseInt(formEdit.querySelector('[name="so_luong_ton"]')?.value ?? -1, 10);

            if (isNaN(gia) || gia < 0) {
                e.preventDefault();
                highlightField(formEdit, 'gia_tien', 'Giá bán phải lớn hơn hoặc bằng 0');
                return;
            }
            if (isNaN(sl) || sl < 0) {
                e.preventDefault();
                highlightField(formEdit, 'so_luong_ton', 'Số lượng phải lớn hơn hoặc bằng 0');
                return;
            }
        });
    }

    // ── 6. Helper: highlight lỗi field ────────────────────
    function highlightField(form, name, msg) {
        const field = form.querySelector(`[name="${name}"]`);
        if (!field) return;
        field.classList.add('ring-2', 'ring-red-400');
        field.focus();

        let hint = field.nextElementSibling;
        if (!hint || !hint.classList.contains('field-error')) {
            hint = document.createElement('p');
            hint.className    = 'field-error text-red-500 text-xs mt-1';
            hint.textContent  = msg;
            field.insertAdjacentElement('afterend', hint);
        }

        field.addEventListener('input', () => {
            field.classList.remove('ring-2', 'ring-red-400');
            hint.remove();
        }, { once: true });
    }
})();