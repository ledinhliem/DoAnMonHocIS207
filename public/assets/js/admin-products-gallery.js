(function () {
    'use strict';

    const fileInput = document.getElementById('image-input');
    const uploadLabel = document.getElementById('upload-label');
    const previewBox = document.getElementById('upload-preview');
    const previewName = document.getElementById('preview-name');
    const previewSize = document.getElementById('preview-size');
    const uploadForm = document.getElementById('upload-form');
    const dropZone = uploadForm ? uploadForm.querySelector('label') : null;

    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
    }

    if (dropZone && fileInput && !fileInput.disabled) {
        ['dragenter', 'dragover'].forEach((eventName) => {
            dropZone.addEventListener(eventName, (event) => {
                event.preventDefault();
                dropZone.classList.add('border-[#384e21]', 'bg-[#d0ecaf]/20');
            });
        });

        ['dragleave', 'drop'].forEach((eventName) => {
            dropZone.addEventListener(eventName, (event) => {
                event.preventDefault();
                dropZone.classList.remove('border-[#384e21]', 'bg-[#d0ecaf]/20');
            });
        });

        dropZone.addEventListener('drop', (event) => {
            const files = Array.from(event.dataTransfer.files || []);
            if (!files.length) return;

            const dt = new DataTransfer();
            files.forEach((file) => dt.items.add(file));
            fileInput.files = dt.files;
            fileInput.dispatchEvent(new Event('change'));
        });
    }

    function handleFileSelect(event) {
        const files = Array.from(event.target.files || []);
        if (!files.length) return;

        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const invalid = files.find((file) => !allowedTypes.includes(file.type));

        if (invalid) {
            showAlert('Ảnh chi tiết chỉ nhận JPG, JPEG, PNG hoặc WEBP.', 'error');
            fileInput.value = '';
            return;
        }

        Promise.all(files.map(readImageSize)).then((sizes) => {
            const wrongSize = sizes.find((size) => size.width !== 2400 || size.height !== 2700);
            if (wrongSize) {
                showAlert('Ảnh sản phẩm phải đúng kích thước 2400 x 2700 px.', 'error');
                fileInput.value = '';
                return;
            }

            if (previewName) {
                previewName.textContent = files.length === 1
                    ? files[0].name
                    : `Đã chọn ${files.length} ảnh`;
            }
            if (previewSize) {
                previewSize.textContent = formatBytes(files.reduce((total, file) => total + file.size, 0));
            }
            if (previewBox) {
                previewBox.classList.remove('hidden');
            }
            if (uploadLabel) {
                uploadLabel.textContent = files.length === 1 ? 'Đã chọn 1 ảnh' : `Đã chọn ${files.length} ảnh`;
            }
        }).catch(() => {
            showAlert('Không đọc được kích thước ảnh.', 'error');
            fileInput.value = '';
        });
    }

    function readImageSize(file) {
        return new Promise((resolve, reject) => {
            const url = URL.createObjectURL(file);
            const image = new Image();
            image.onload = () => {
                URL.revokeObjectURL(url);
                resolve({ width: image.naturalWidth, height: image.naturalHeight });
            };
            image.onerror = () => {
                URL.revokeObjectURL(url);
                reject(new Error('Invalid image'));
            };
            image.src = url;
        });
    }

    function formatBytes(bytes) {
        if (bytes < 1024) return `${bytes} B`;
        if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
        return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
    }

    function showAlert(message, type) {
        const div = document.createElement('div');
        div.className = [
            'fixed top-6 right-6 z-50 px-5 py-4 rounded-2xl shadow-lg text-sm font-semibold',
            type === 'error'
                ? 'bg-[#ffdad6] text-[#ba1a1a] border border-[#ba1a1a]/20'
                : 'bg-[#d0ecaf] text-[#384e21] border border-[#384e21]/20',
        ].join(' ');
        div.textContent = message;
        document.body.appendChild(div);
        setTimeout(() => {
            div.style.transition = 'opacity 0.4s';
            div.style.opacity = '0';
            setTimeout(() => div.remove(), 400);
        }, 3500);
    }
})();
