/**
 * products-gallery.js
 * Xử lý UI cho trang Thư viện ảnh sản phẩm (admin/products/gallery)
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

    // ── 2. Preview ảnh trước khi upload ───────────────────
    const fileInput   = document.getElementById('image-input');
    const uploadLabel = document.getElementById('upload-label');
    const previewBox  = document.getElementById('upload-preview');
    const previewImg  = document.getElementById('preview-img');
    const previewName = document.getElementById('preview-name');
    const previewSize = document.getElementById('preview-size');

    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
    }

    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Kiểm tra định dạng
        const allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowed.includes(file.type)) {
            showAlert('Định dạng không hỗ trợ. Vui lòng chọn JPG, PNG hoặc WEBP.', 'error');
            fileInput.value = '';
            return;
        }

        // Kiểm tra kích thước (10MB)
        if (file.size > 10 * 1024 * 1024) {
            showAlert('File quá lớn. Tối đa 10MB.', 'error');
            fileInput.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (ev) {
            if (previewImg)  previewImg.src        = ev.target.result;
            if (previewName) previewName.textContent = file.name;
            if (previewSize) previewSize.textContent = formatBytes(file.size);
            if (previewBox)  previewBox.classList.remove('hidden');
            if (uploadLabel) uploadLabel.textContent = 'Đã chọn: ' + file.name;
        };
        reader.readAsDataURL(file);
    }

    // ── 3. Drag & Drop lên label upload ───────────────────
    const uploadForm = document.getElementById('upload-form');
    const dropZone   = uploadForm ? uploadForm.querySelector('label') : null;

    if (dropZone) {
        ['dragenter', 'dragover'].forEach(ev =>
            dropZone.addEventListener(ev, e => {
                e.preventDefault();
                dropZone.classList.add('border-[#384e21]', 'bg-[#d0ecaf]/20');
            })
        );

        ['dragleave', 'drop'].forEach(ev =>
            dropZone.addEventListener(ev, e => {
                e.preventDefault();
                dropZone.classList.remove('border-[#384e21]', 'bg-[#d0ecaf]/20');
            })
        );

        dropZone.addEventListener('drop', e => {
            const file = e.dataTransfer.files[0];
            if (!file || !fileInput) return;

            // Gán file vào input (DataTransfer trick)
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            fileInput.dispatchEvent(new Event('change'));
        });
    }

    // ── 4. Helpers ─────────────────────────────────────────
    function formatBytes(bytes) {
        if (bytes < 1024)        return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function showAlert(msg, type) {
        const div = document.createElement('div');
        div.className = [
            'fixed top-6 right-6 z-50 px-5 py-4 rounded-2xl shadow-lg text-sm font-semibold',
            type === 'error'
                ? 'bg-[#ffdad6] text-[#ba1a1a] border border-[#ba1a1a]/20'
                : 'bg-[#d0ecaf] text-[#384e21] border border-[#384e21]/20',
        ].join(' ');
        div.textContent = msg;
        document.body.appendChild(div);
        setTimeout(() => {
            div.style.transition = 'opacity 0.4s';
            div.style.opacity    = '0';
            setTimeout(() => div.remove(), 400);
        }, 3500);
    }
})();