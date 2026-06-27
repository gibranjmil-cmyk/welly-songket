const sizeTemplates = {
    pakaian: 'Tinggi badan: \nBerat badan: \nLebar bahu: \nLingkar dada: \nPanjang baju: \nPanjang lengan: \nPanjang bawahan / rok songket: \nUkuran tambahan:',
    alas_kaki: 'Ukuran kaki: \nPanjang telapak kaki: \nLebar telapak kaki: \nCatatan kenyamanan:',
    aksesoris_cm: 'Panjang (cm): \nLebar (cm): \nTinggi (cm): \nTali / handle (cm): \nCatatan bentuk:',
    kain: 'Panjang kain / selendang: \nLebar kain / selendang: \nCatatan pemakaian:',
    custom: 'Tulis semua ukuran yang diperlukan agar produk songket fit dan nyaman:'
};

const orderItems = document.querySelector('#orderItems');
const addItemButton = document.querySelector('#addItem');
const orderForm = document.querySelector('#orderForm');

function refreshItemLabels() {
    document.querySelectorAll('[data-item]').forEach((item, index) => {
        item.querySelector('.item-head strong').textContent = `Produk ${index + 1}`;
        item.querySelector('[data-remove-item]').style.display = index === 0 ? 'none' : 'inline-flex';
    });
}

function updateSizeTemplate(select) {
    const item = select.closest('[data-item]');
    const selected = select.selectedOptions[0];
    const category = selected?.dataset.category || 'custom';
    const textarea = item.querySelector('textarea[name="sizes[]"]');

    if (textarea && textarea.value.trim() === '') {
        textarea.value = sizeTemplates[category] || sizeTemplates.custom;
    }
}

function bindItem(item) {
    const select = item.querySelector('[data-product-select]');
    select.addEventListener('change', () => updateSizeTemplate(select));
    item.querySelector('[data-remove-item]').addEventListener('click', () => {
        item.remove();
        refreshItemLabels();
    });
}

if (orderItems && addItemButton) {
    bindItem(orderItems.querySelector('[data-item]'));
    refreshItemLabels();

    addItemButton.addEventListener('click', () => {
        const clone = orderItems.querySelector('[data-item]').cloneNode(true);
        clone.querySelectorAll('input, textarea, select').forEach((field) => {
            field.value = '';
        });
        orderItems.appendChild(clone);
        bindItem(clone);
        refreshItemLabels();
    });
}

if (orderForm) {
    orderForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const data = new FormData(orderForm);
        const products = data.getAll('product[]');
        const motifs = data.getAll('motif[]');
        const sizes = data.getAll('sizes[]');
        const notes = data.getAll('notes[]');

        const lines = [
            'Halo Admin Welly Songket, saya ingin preorder.',
            '',
            `Nama: ${data.get('customer_name')}`,
            `WhatsApp: ${data.get('customer_whatsapp')}`,
            `Alamat: ${data.get('customer_address')}`,
            '',
            'Detail pesanan:'
        ];

        products.forEach((product, index) => {
            if (!product) return;
            lines.push('');
            lines.push(`${index + 1}. Produk: ${product}`);
            lines.push(`Motif: ${motifs[index] || 'Bebas / diskusi dengan admin'}`);
            lines.push(`Ukuran: ${sizes[index] || '-'}`);
            lines.push(`Catatan produk: ${notes[index] || '-'}`);
        });

        if (data.get('reference')) {
            lines.push('');
            lines.push(`Foto referensi: ${data.get('reference')}`);
        }

        if (data.get('customer_note')) {
            lines.push(`Catatan customer: ${data.get('customer_note')}`);
        }

        lines.push('');
        lines.push('Saya paham pembayaran dilakukan setelah terjadi kesepakatan dan estimasi pengerjaan akan didiskusikan sesuai pesanan.');

        window.open(`https://wa.me/${orderForm.dataset.whatsapp}?text=${encodeURIComponent(lines.join('\n'))}`, '_blank');
    });
}
