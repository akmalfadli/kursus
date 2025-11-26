<script>
// Smooth scrolling
function scrollToSection(sectionId) {
    document.getElementById(sectionId)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Payment flow
document.addEventListener('DOMContentLoaded', function() {
    const customerForm = document.getElementById('customer-form');
    const choosePaymentBtn = document.getElementById('choose-payment-btn');
    const buttonText = document.getElementById('button-text');
    const buttonLoading = document.getElementById('button-loading');
    const paymentModal = document.getElementById('payment-method-modal');
    const closeModal = document.getElementById('close-modal');
    const paymentMethodsLoading = document.getElementById('payment-methods-loading');
    const paymentMethodsContainer = document.getElementById('payment-methods-container');
    const paymentMethodsError = document.getElementById('payment-methods-error');
    const paymentMethodsList = document.getElementById('payment-methods-list');
    const proceedPaymentBtn = document.getElementById('proceed-payment-btn');
    const retryBtn = document.getElementById('retry-payment-methods');

    // Promo Popup Elements
    const promoPopup = document.getElementById('promo-popup');
    const closePromoPopup = document.getElementById('close-promo-popup');
    const promoDaftarBtn = document.getElementById('promo-daftar-btn');
    let promoShown = false;

    // Detect scroll halfway down
    window.addEventListener('scroll', function() {
        if (promoShown) return;

        const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        const clientHeight = document.documentElement.clientHeight;
        const scrollHeight = document.documentElement.scrollHeight;

        const maxScrollable = scrollHeight - clientHeight;
        const halfwayPoint = (maxScrollable * 0.5) + 300;

        if (scrollTop >= halfwayPoint) {
            showPromoPopup();
            promoShown = true;
        }
    });


    // Show promo popup
    function showPromoPopup() {
        promoPopup.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Close promo popup
    function closePromoPopupFunc() {
        promoPopup.classList.add('hidden');
        document.body.style.overflow = '';
    }

    closePromoPopup.addEventListener('click', closePromoPopupFunc);

    // Click outside to close
    promoPopup.addEventListener('click', function(e) {
        if (e.target === promoPopup) {
            closePromoPopupFunc();
        }
    });

    // Promo Daftar button triggers scroll to pricing and close popup
    promoDaftarBtn.addEventListener('click', function() {
        closePromoPopupFunc();
        scrollToSection('pricing');
        // Wait for scroll then focus on form
        setTimeout(() => {
            const nameInput = document.querySelector('input[name="name"]');
            if (nameInput) {
                nameInput.focus();
                nameInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 800);
    });

    let currentUserData = null;
    let currentPaymentMethods = null;
    let selectedPaymentMethod = null;

    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) value = '+' + value;
            else if (value.startsWith('0')) value = value;
            else if (value.length > 0) value = '0' + value;
            e.target.value = value;
        });
    }

    customerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(customerForm);
        const customerData = {
            name: formData.get('name').trim(),
            email: formData.get('email').trim(),
            phone: formData.get('phone').trim()
        };

        if (customerData.name.length < 2) {
            showError('Nama harus minimal 2 karakter');
            return;
        }
        if (!isValidEmail(customerData.email)) {
            showError('Format email tidak valid');
            return;
        }

        currentUserData = customerData;
        fetchPaymentMethods(customerData);
    });

    function fetchPaymentMethods(customerData) {
        setButtonLoading(true);
        fetch('{{ route("payment.methods") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(customerData)
        })
        .then(response => response.json())
        .then(data => {
            setButtonLoading(false);
            if (data.status === 'success') {
                currentPaymentMethods = data.data.payment_methods;
                showPaymentMethodModal(data.data);
            } else {
                showError(data.message || 'Gagal mengambil metode pembayaran');
            }
        })
        .catch(error => {
            setButtonLoading(false);
            console.error('Error:', error);
            showError('Terjadi kesalahan. Silakan coba lagi.');
        });
    }

    function showPaymentMethodModal(data) {
        document.getElementById('modal-amount').textContent = data.formatted_amount;
        paymentModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        loadPaymentMethods(data.payment_methods);
    }

    function loadPaymentMethods(paymentMethods) {
        paymentMethodsLoading.classList.remove('hidden');
        paymentMethodsContainer.classList.add('hidden');
        paymentMethodsError.classList.add('hidden');

        if (!paymentMethods || paymentMethods.length === 0) {
            showPaymentMethodsError();
            return;
        }

        paymentMethodsList.innerHTML = '';
        paymentMethods.forEach(method => {
            const methodElement = createPaymentMethodElement(method);
            paymentMethodsList.appendChild(methodElement);
        });

        setTimeout(() => {
            paymentMethodsLoading.classList.add('hidden');
            paymentMethodsContainer.classList.remove('hidden');
        }, 500);
    }

    function createPaymentMethodElement(method) {
        const div = document.createElement('div');
        div.className = 'payment-method-option border-2 border-slate-200 p-4 cursor-pointer hover:border-orange-500 hover:bg-orange-50 transition-all duration-200 rounded-xl';
        div.dataset.paymentMethod = method.paymentMethod;

        div.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden rounded-lg">
                        <img src="${method.paymentImage}" alt="${method.paymentName}" class="max-w-full max-h-full object-contain"
                             onerror="this.style.display='none'; this.parentElement.innerHTML='<span class=\\"text-xs text-slate-500\\">${method.paymentMethod}</span>'">
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">${method.paymentName}</h4>
                        <p class="text-xs text-slate-500">${method.paymentMethod}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    ${method.totalFee === '0' || method.totalFee === 0 ?
                        '<span class="text-green-600 text-sm font-bold">Gratis</span>' :
                        `<span class="text-slate-600 text-xs">+Rp ${parseInt(method.totalFee).toLocaleString('id-ID')}</span>`
                    }
                    <div class="w-6 h-6 border-2 border-slate-300 rounded-full payment-radio transition-all"></div>
                </div>
            </div>
        `;

        div.addEventListener('click', function() {
            selectPaymentMethod(method, div);
        });

        return div;
    }

    function selectPaymentMethod(method, element) {
        document.querySelectorAll('.payment-method-option').forEach(el => {
            el.classList.remove('border-orange-500', 'bg-orange-50');
            const radio = el.querySelector('.payment-radio');
            radio.classList.remove('border-orange-500', 'bg-orange-500');
            radio.innerHTML = '';
        });

        element.classList.add('border-orange-500', 'bg-orange-50');
        const radio = element.querySelector('.payment-radio');
        radio.classList.add('border-orange-500', 'bg-orange-500');
        radio.innerHTML = '<div class="w-3 h-3 bg-white rounded-full mx-auto"></div>';

        selectedPaymentMethod = method;
        proceedPaymentBtn.disabled = false;
        document.getElementById('proceed-text').textContent = `Bayar ${method.paymentName}`;
    }

    function showPaymentMethodsError() {
        paymentMethodsLoading.classList.add('hidden');
        paymentMethodsContainer.classList.add('hidden');
        paymentMethodsError.classList.remove('hidden');
    }

    proceedPaymentBtn.addEventListener('click', function() {
        if (!selectedPaymentMethod) return;
        createTransaction();
    });

    function createTransaction() {
        const proceedText = document.getElementById('proceed-text');
        const proceedLoading = document.getElementById('proceed-loading');

        proceedPaymentBtn.disabled = true;
        proceedText.classList.add('hidden');
        proceedLoading.classList.remove('hidden');

        const transactionData = {
            ...currentUserData,
            payment_method: selectedPaymentMethod.paymentMethod
        };

        fetch('{{ route("payment.initiate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(transactionData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                localStorage.setItem('payment_form_data', JSON.stringify({
                    name: currentUserData.name,
                    email: currentUserData.email,
                    invoice_id: data.data.invoice_id,
                    timestamp: Date.now()
                }));
                window.location.href = data.data.payment_url;
            } else {
                showError(data.message || 'Gagal membuat pembayaran');
                resetProceedButton();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Terjadi kesalahan. Silakan coba lagi.');
            resetProceedButton();
        });
    }

    function resetProceedButton() {
        const proceedText = document.getElementById('proceed-text');
        const proceedLoading = document.getElementById('proceed-loading');
        proceedPaymentBtn.disabled = false;
        proceedText.classList.remove('hidden');
        proceedLoading.classList.add('hidden');
    }

    closeModal.addEventListener('click', hidePaymentMethodModal);
    retryBtn.addEventListener('click', function() {
        if (currentUserData) fetchPaymentMethods(currentUserData);
    });

    paymentModal.addEventListener('click', function(e) {
        if (e.target === paymentModal) hidePaymentMethodModal();
    });

    function hidePaymentMethodModal() {
        paymentModal.classList.add('hidden');
        document.body.style.overflow = '';
        selectedPaymentMethod = null;
        proceedPaymentBtn.disabled = true;
        document.getElementById('proceed-text').textContent = 'Pilih Metode Pembayaran';
    }

    function setButtonLoading(loading) {
        choosePaymentBtn.disabled = loading;
        if (loading) {
            buttonText.classList.add('hidden');
            buttonLoading.classList.remove('hidden');
        } else {
            buttonText.classList.remove('hidden');
            buttonLoading.classList.add('hidden');
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showError(message) {
        const existingNotifications = document.querySelectorAll('.notification-error');
        existingNotifications.forEach(notif => notif.remove());

        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-red-500 text-white p-4 rounded-xl shadow-2xl z-50 max-w-sm notification-error';
        notification.innerHTML = `
            <div class="flex items-center justify-between">
                <span class="text-sm">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 5000);
    }
});
</script>
