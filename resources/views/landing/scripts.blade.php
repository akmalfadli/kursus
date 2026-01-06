<script>
function scrollToSection(sectionId) {
    document.getElementById(sectionId)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

document.addEventListener('DOMContentLoaded', () => {
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
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Promo popup
    const promoPopup = document.getElementById('promo-popup');
    const closePromoPopup = document.getElementById('close-promo-popup');
    const promoDaftarBtn = document.getElementById('promo-daftar-btn');
    let promoShown = false;

    window.addEventListener('scroll', () => {
        if (promoShown || !promoPopup) return;
        const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        const clientHeight = document.documentElement.clientHeight;
        const scrollHeight = document.documentElement.scrollHeight;
        const maxScrollable = scrollHeight - clientHeight;
        const halfwayPoint = (maxScrollable * 0.5) + 300;
        if (scrollTop >= halfwayPoint) {
            promoPopup.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            promoShown = true;
        }
    });

    closePromoPopup?.addEventListener('click', () => {
        promoPopup?.classList.add('hidden');
        document.body.style.overflow = '';
    });

    promoPopup?.addEventListener('click', (e) => {
        if (e.target === promoPopup) {
            promoPopup.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });

    promoDaftarBtn?.addEventListener('click', () => {
        promoPopup?.classList.add('hidden');
        document.body.style.overflow = '';
        scrollToSection('pricing');
        setTimeout(() => {
            const nameInput = document.querySelector('input[name="name"]');
            nameInput?.focus();
            nameInput?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 800);
    });

    // Referral UI elements
    const referralInput = document.getElementById('referral-code-input');
    const checkReferralBtn = document.getElementById('check-referral-btn');
    const referralStatusChip = document.getElementById('referral-status-chip');
    const referralFeedback = document.getElementById('referral-feedback');
    const pricingAmountEl = document.getElementById('pricing-current-amount');
    const pricingNoteEl = document.getElementById('pricing-referral-note');
    const pricingDiscountEl = document.getElementById('pricing-discount-amount');
    const pricingCodeEl = document.getElementById('pricing-referral-code');
    const promoAmountEl = document.getElementById('promo-current-amount');
    const promoNoteEl = document.getElementById('promo-referral-note');
    const promoDiscountEl = document.getElementById('promo-discount-amount');
    const promoCodeEl = document.getElementById('promo-referral-code');
    const modalReferralNote = document.getElementById('modal-referral-note');
    const modalDiscountAmount = document.getElementById('modal-discount-amount');
    const modalReferralCode = document.getElementById('modal-referral-code');

    const basePrice = pricingAmountEl ? parseInt(pricingAmountEl.dataset.basePrice || '0', 10) : 0;
    let currentPricing = {
        base_amount: basePrice,
        final_amount: basePrice,
        discount_amount: 0,
        commission_amount: 0,
        referral: null,
        formatted: {
            base: formatCurrency(basePrice),
            final: formatCurrency(basePrice),
            discount: formatCurrency(0),
        }
    };

    let currentUserData = null;
    let currentPaymentMethods = null;
    let selectedPaymentMethod = null;
    let referralDebounce = null;

    if (referralFeedback) {
        setReferralFeedback('Masukkan kode referral untuk mendapatkan diskon khusus', 'info');
    }

    initReferralUI();

    const phoneInput = document.querySelector('input[name="phone"]');
    phoneInput?.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.startsWith('62')) value = '+' + value;
        else if (value.startsWith('0')) value = value;
        else if (value.length > 0) value = '0' + value;
        e.target.value = value;
    });

    customerForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(customerForm);
        const referralCode = (formData.get('referral_code') || '').toString().trim().toUpperCase();
        const customerData = {
            name: formData.get('name').trim(),
            email: formData.get('email').trim(),
            phone: formData.get('phone').trim(),
            referral_code: referralCode || currentPricing.referral?.code || null,
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

    function initReferralUI() {
        if (!referralInput) return;
        referralInput.addEventListener('input', () => {
            clearTimeout(referralDebounce);
            referralInput.value = referralInput.value.toUpperCase();
            const code = referralInput.value.trim();
            if (!code) {
                resetReferralState();
                return;
            }
            referralDebounce = setTimeout(() => validateReferral(code), 600);
        });

        checkReferralBtn?.addEventListener('click', () => {
            const code = referralInput.value.trim();
            if (!code) {
                resetReferralState();
                return;
            }
            validateReferral(code, true);
        });
    }

    function validateReferral(code, showFeedback = false) {
        if (!csrfToken) return;
        setReferralLoading(true);
        setReferralInputState('loading');
        fetch('{{ route('api.referrals.validate') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ referral_code: code.toUpperCase() })
        })
        .then(async (response) => {
            const payload = await response.json();
            if (!response.ok || payload.status !== 'success') {
                throw new Error(payload.message || 'Kode referral tidak valid');
            }
            applyPricingFromServer(payload.data);
            setReferralSuccess(payload.data.code);
            if (showFeedback) {
                setReferralFeedback('Kode referal ditemukan', 'success');
            }
        })
        .catch((error) => {
            resetReferralState();
            setReferralFeedback(error.message || 'Kode referral tidak valid', 'error');
            setReferralInputState('error');
        })
        .finally(() => {
            setReferralLoading(false);
            if (!referralInput.value.trim()) {
                setReferralInputState('neutral');
            }
        });
    }

    function applyPricingFromServer(serverPricing) {
        currentPricing = {
            base_amount: serverPricing.base_amount,
            final_amount: serverPricing.final_amount,
            discount_amount: serverPricing.discount_amount,
            commission_amount: serverPricing.commission_amount,
            referral: serverPricing.code ? {
                code: serverPricing.code,
                discount_percentage: serverPricing.discount_percentage,
            } : null,
            formatted: serverPricing.formatted,
        };
        updatePricingDisplays();
    }

    function updatePricingDisplays() {
        const hasDiscount = currentPricing.discount_amount > 0 && currentPricing.referral;

        if (pricingAmountEl) {
            pricingAmountEl.dataset.basePrice = currentPricing.base_amount;
            pricingAmountEl.textContent = formatCurrency(currentPricing.final_amount);
        }
        if (promoAmountEl) {
            promoAmountEl.textContent = formatCurrency(currentPricing.final_amount);
        }

        if (hasDiscount && currentPricing.referral) {
            setReferralSuccess(currentPricing.referral.code);
        } else if (!hasDiscount) {
            setReferralInputState('neutral');
        }

        if (pricingNoteEl && pricingDiscountEl && pricingCodeEl) {
            pricingNoteEl.classList.toggle('hidden', !hasDiscount);
            if (hasDiscount) {
                pricingDiscountEl.textContent = formatCurrency(currentPricing.discount_amount);
                pricingCodeEl.textContent = currentPricing.referral.code;
            }
        }

        if (promoNoteEl && promoDiscountEl && promoCodeEl) {
            promoNoteEl.classList.toggle('hidden', !hasDiscount);
            if (hasDiscount) {
                promoDiscountEl.textContent = formatCurrency(currentPricing.discount_amount);
                promoCodeEl.textContent = currentPricing.referral.code;
            }
        }

        if (modalReferralNote && modalDiscountAmount && modalReferralCode) {
            modalReferralNote.classList.toggle('hidden', !hasDiscount);
            if (hasDiscount) {
                modalDiscountAmount.textContent = formatCurrency(currentPricing.discount_amount);
                modalReferralCode.textContent = currentPricing.referral.code;
            }
        }

        if (!hasDiscount) {
            setReferralFeedback('Masukkan kode referral untuk mendapatkan diskon khusus', 'info');
        }
    }

    function resetReferralState() {
        currentPricing = {
            base_amount: basePrice,
            final_amount: basePrice,
            discount_amount: 0,
            commission_amount: 0,
            referral: null,
            formatted: {
                base: formatCurrency(basePrice),
                final: formatCurrency(basePrice),
                discount: formatCurrency(0),
            }
        };
        referralStatusChip?.classList.add('hidden');
        setReferralInputState('neutral');
        updatePricingDisplays();
    }

    function setReferralLoading(isLoading) {
        if (!checkReferralBtn) return;
        checkReferralBtn.disabled = isLoading;
        checkReferralBtn.textContent = isLoading ? 'Memproses...' : 'Cek Kode';
    }

    function setReferralFeedback(message, type = 'info') {
        if (!referralFeedback) return;
        referralFeedback.textContent = message;
        referralFeedback.classList.remove('text-green-600', 'text-red-600', 'text-slate-500');
        if (type === 'success') referralFeedback.classList.add('text-green-600');
        else if (type === 'error') referralFeedback.classList.add('text-red-600');
        else referralFeedback.classList.add('text-slate-500');
    }

    function setReferralSuccess(code) {
        if (!referralStatusChip) return;
        referralStatusChip.classList.remove('hidden');
        referralStatusChip.classList.remove('bg-red-100', 'text-red-700');
        referralStatusChip.classList.add('bg-green-100', 'text-green-700');
        referralStatusChip.textContent = `Aktif (${code})`;
        setReferralFeedback('Kode referal ditemukan', 'success');
        setReferralInputState('success');
    }

    function setReferralInputState(state) {
        if (!referralInput) return;
        referralInput.classList.remove('border-red-500', 'border-green-500', 'focus:border-red-500', 'focus:border-green-500');

        if (state === 'success') {
            referralInput.classList.add('border-green-500', 'focus:border-green-500');
        } else if (state === 'error') {
            referralInput.classList.add('border-red-500', 'focus:border-red-500');
        }
    }


    function fetchPaymentMethods(customerData) {
        if (!csrfToken) return;
        setButtonLoading(true);
        fetch('{{ route('payment.methods') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(customerData)
        })
        .then(response => response.json())
        .then(data => {
            setButtonLoading(false);
            if (data.status === 'success') {
                currentPaymentMethods = data.data.payment_methods;
                if (data.data.pricing) {
                    applyPricingFromServer({
                        ...data.data.pricing,
                        code: data.data.pricing?.referral?.code ?? null,
                        discount_percentage: data.data.pricing?.referral?.discount_percentage ?? null,
                    });
                }
                if (currentUserData) {
                    currentUserData.referral_code = currentPricing.referral?.code ?? currentUserData.referral_code ?? null;
                }
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
        if (data.pricing) {
            applyPricingFromServer({
                ...data.pricing,
                code: data.pricing?.referral?.code ?? null,
                discount_percentage: data.pricing?.referral?.discount_percentage ?? null,
            });
            if (currentUserData) {
                currentUserData.referral_code = currentPricing.referral?.code ?? currentUserData.referral_code ?? null;
            }
        }
        paymentModal?.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        loadPaymentMethods(data.payment_methods);
    }

    function loadPaymentMethods(paymentMethods) {
        paymentMethodsLoading?.classList.remove('hidden');
        paymentMethodsContainer?.classList.add('hidden');
        paymentMethodsError?.classList.add('hidden');

        if (!paymentMethods || paymentMethods.length === 0) {
            showPaymentMethodsError();
            return;
        }

        paymentMethodsList.innerHTML = '';
        paymentMethods.forEach(method => {
            paymentMethodsList.appendChild(createPaymentMethodElement(method));
        });

        setTimeout(() => {
            paymentMethodsLoading?.classList.add('hidden');
            paymentMethodsContainer?.classList.remove('hidden');
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
                            onerror="this.style.display='none'; this.parentElement.innerHTML='<span class=\"text-xs text-slate-500\">${method.paymentMethod}</span>'">
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">${method.paymentName}</h4>
                        <p class="text-xs text-slate-500">${method.paymentMethod}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    ${method.totalFee === '0' || method.totalFee === 0
                        ? '<span class="text-green-600 text-sm font-bold">Gratis</span>'
                        : `<span class="text-slate-600 text-xs">+Rp ${parseInt(method.totalFee).toLocaleString('id-ID')}</span>`}
                    <div class="w-6 h-6 border-2 border-slate-300 rounded-full payment-radio transition-all"></div>
                </div>
            </div>`;

        div.addEventListener('click', () => selectPaymentMethod(method, div));
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
        paymentMethodsLoading?.classList.add('hidden');
        paymentMethodsContainer?.classList.add('hidden');
        paymentMethodsError?.classList.remove('hidden');
    }

    proceedPaymentBtn?.addEventListener('click', () => {
        if (!selectedPaymentMethod) return;
        createTransaction();
    });

    function createTransaction() {
        if (!csrfToken) return;
        const proceedText = document.getElementById('proceed-text');
        const proceedLoading = document.getElementById('proceed-loading');

        proceedPaymentBtn.disabled = true;
        proceedText.classList.add('hidden');
        proceedLoading.classList.remove('hidden');

        const transactionData = {
            ...currentUserData,
            referral_code: currentUserData?.referral_code || currentPricing.referral?.code || null,
            payment_method: selectedPaymentMethod.paymentMethod,
        };

        fetch('{{ route('payment.initiate') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(transactionData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                if (data.data.pricing) {
                    applyPricingFromServer({
                        ...data.data.pricing,
                        code: data.data.pricing?.referral?.code ?? null,
                        discount_percentage: data.data.pricing?.referral?.discount_percentage ?? null,
                    });
                }
                localStorage.setItem('payment_form_data', JSON.stringify({
                    name: currentUserData.name,
                    email: currentUserData.email,
                    invoice_id: data.data.invoice_id,
                    timestamp: Date.now(),
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

    closeModal?.addEventListener('click', hidePaymentMethodModal);
    retryBtn?.addEventListener('click', () => {
        if (currentUserData) fetchPaymentMethods(currentUserData);
    });

    paymentModal?.addEventListener('click', (e) => {
        if (e.target === paymentModal) hidePaymentMethodModal();
    });

    function hidePaymentMethodModal() {
        paymentModal?.classList.add('hidden');
        document.body.style.overflow = '';
        selectedPaymentMethod = null;
        proceedPaymentBtn.disabled = true;
        document.getElementById('proceed-text').textContent = 'Pilih Metode Pembayaran';
    }

    function setButtonLoading(loading) {
        if (!choosePaymentBtn) return;
        choosePaymentBtn.disabled = loading;
        if (loading) {
            buttonText?.classList.add('hidden');
            buttonLoading?.classList.remove('hidden');
        } else {
            buttonText?.classList.remove('hidden');
            buttonLoading?.classList.add('hidden');
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function formatCurrency(amount) {
        return 'Rp ' + Number(amount || 0).toLocaleString('id-ID');
    }

    function showError(message) {
        document.querySelectorAll('.notification-error').forEach(node => node.remove());
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
            </div>`;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 5000);
    }
});
</script>
