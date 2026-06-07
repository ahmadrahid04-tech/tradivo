/**
 * Tradivo — JavaScript Application
 * Handles: Toast, Image Upload Preview, Dropdown, Mobile Nav, Wishlist AJAX, Gallery
 */

document.addEventListener('DOMContentLoaded', function () {

    /* ═══════════════════════════════════════
       TOAST NOTIFICATION SYSTEM
       ═══════════════════════════════════════ */
    const toastContainer = document.getElementById('toast-container');
    if (toastContainer) {
        const toasts = toastContainer.querySelectorAll('.toast');
        toasts.forEach((toast, index) => {
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease-in forwards';
                setTimeout(() => toast.remove(), 300);
            }, 4000 + (index * 500));

            const closeBtn = toast.querySelector('.toast-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    toast.style.animation = 'slideOut 0.3s ease-in forwards';
                    setTimeout(() => toast.remove(), 300);
                });
            }
        });
    }

    /* ═══════════════════════════════════════
       NAVBAR SCROLL EFFECT
       ═══════════════════════════════════════ */
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 10);
        });
    }

    /* ═══════════════════════════════════════
       MOBILE NAVIGATION TOGGLE
       ═══════════════════════════════════════ */
    const navToggle = document.getElementById('navbar-toggle');
    const navMenu = document.getElementById('navbar-menu');
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('show');
        });

        // Close on click outside
        document.addEventListener('click', (e) => {
            if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('show');
            }
        });
    }

    /* ═══════════════════════════════════════
       USER DROPDOWN
       ═══════════════════════════════════════ */
    const dropdownToggle = document.getElementById('user-dropdown-toggle');
    const dropdownMenu = document.getElementById('user-dropdown-menu');
    if (dropdownToggle && dropdownMenu) {
        dropdownToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        document.addEventListener('click', () => {
            dropdownMenu.classList.remove('show');
        });
    }

    /* ═══════════════════════════════════════
       IMAGE UPLOAD PREVIEW
       ═══════════════════════════════════════ */
    const imageInput = document.getElementById('image-upload');
    const previewGrid = document.getElementById('image-preview-grid');
    const uploadArea = document.getElementById('image-upload-area');

    if (imageInput && previewGrid && uploadArea) {
        uploadArea.addEventListener('click', () => imageInput.click());

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                imageInput.files = e.dataTransfer.files;
                showImagePreviews(imageInput.files);
            }
        });

        imageInput.addEventListener('change', () => {
            showImagePreviews(imageInput.files);
        });

        function showImagePreviews(files) {
            previewGrid.innerHTML = '';
            const maxFiles = Math.min(files.length, 5);
            for (let i = 0; i < maxFiles; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${i + 1}">
                    `;
                    previewGrid.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        }
    }

    /* ═══════════════════════════════════════
       IMAGE GALLERY (Listing Detail)
       ═══════════════════════════════════════ */
    const galleryMain = document.getElementById('gallery-main-img');
    const thumbs = document.querySelectorAll('.gallery-thumb');

    if (galleryMain && thumbs.length > 0) {
        thumbs.forEach(thumb => {
            thumb.addEventListener('click', function () {
                galleryMain.src = this.dataset.src;
                galleryMain.alt = this.dataset.alt || '';
                thumbs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }

    /* ═══════════════════════════════════════
       WISHLIST TOGGLE (AJAX)
       ═══════════════════════════════════════ */
    document.querySelectorAll('.wishlist-toggle').forEach(btn => {
        btn.addEventListener('click', async function (e) {
            e.preventDefault();
            e.stopPropagation();
            const url = this.dataset.url;
            const token = document.querySelector('meta[name="csrf-token"]')?.content;

            if (!url || !token) return;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                const data = await response.json();
                this.classList.toggle('active', data.wishlisted);

                // Update icon
                const icon = this.querySelector('span');
                if (icon) {
                    icon.textContent = data.wishlisted ? '♥' : '♡';
                }

                showToast(data.message, 'success');
            } catch (err) {
                showToast('Gagal memproses. Coba lagi.', 'error');
            }
        });
    });

    /* ═══════════════════════════════════════
       REPORT MODAL
       ═══════════════════════════════════════ */
    const reportBtn = document.getElementById('report-btn');
    const reportModal = document.getElementById('report-modal');
    const reportClose = document.getElementById('report-modal-close');

    if (reportBtn && reportModal) {
        reportBtn.addEventListener('click', () => {
            reportModal.classList.add('show');
        });
    }
    if (reportClose && reportModal) {
        reportClose.addEventListener('click', () => {
            reportModal.classList.remove('show');
        });
        reportModal.addEventListener('click', (e) => {
            if (e.target === reportModal) {
                reportModal.classList.remove('show');
            }
        });
    }

    /* ═══════════════════════════════════════
       ADMIN SIDEBAR TOGGLE (Mobile)
       ═══════════════════════════════════════ */
    const adminToggle = document.getElementById('admin-sidebar-toggle');
    const adminSidebar = document.querySelector('.admin-sidebar');
    if (adminToggle && adminSidebar) {
        adminToggle.addEventListener('click', () => {
            adminSidebar.classList.toggle('show');
        });
    }

    /* ═══════════════════════════════════════
       CHAT SCROLL TO BOTTOM
       ═══════════════════════════════════════ */
    const chatMessages = document.querySelector('.chat-messages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    /* ═══════════════════════════════════════
       PRICE FORMATTING
       ═══════════════════════════════════════ */
    const priceInput = document.getElementById('price-input');
    if (priceInput) {
        priceInput.addEventListener('input', function () {
            let val = this.value.replace(/[^\d]/g, '');
            this.value = val;
        });
    }

    /* ═══════════════════════════════════════
       HELPER: Show Toast Programmatically
       ═══════════════════════════════════════ */
    function showToast(message, type = 'success') {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <button class="toast-close" aria-label="Tutup">&times;</button>
        `;
        container.appendChild(toast);

        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => {
            toast.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => toast.remove(), 300);
        });

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    /* ═══════════════════════════════════════
       CONFIRM DELETE
       ═══════════════════════════════════════ */
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', function (e) {
            if (!confirm(this.dataset.confirm || 'Apakah Anda yakin?')) {
                e.preventDefault();
            }
        });
    });

});
