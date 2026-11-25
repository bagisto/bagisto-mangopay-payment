<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Anda akan dialihkan ke situs web MangoPay dalam beberapa detik.',
            'redirect-button' => 'Klik di sini jika Anda tidak dialihkan dalam 10 detik...',
            'unavailable' => 'Metode pembayaran MangoPay saat ini tidak tersedia. Silakan pilih metode pembayaran lain atau hubungi administrator.',
            'canceled' => 'Pembayaran MangoPay telah dibatalkan.',
            'cart-not-found' => 'Keranjang MangoPay tidak ditemukan. Silakan coba lakukan pemesanan lagi.',
            'wallet-not-found' => 'Dompet MangoPay tidak ditemukan untuk pesanan ini.',
            'payment-not-confirmed' => 'Pembayaran MangoPay Anda tidak dapat dikonfirmasi, sehingga tidak ada pesanan yang dibuat.',
            'payment-refunded' => 'Kartu Anda telah ditagih tetapi pesanan tidak dapat dibuat, sehingga pembayaran telah dikembalikan.',
        ],

        'mangopay' => [
            'not-a-seller' => 'Pengaturan pembayaran MangoPay hanya tersedia untuk penjual.',

            'bank-details' => [
                'title' => 'Detail Bank',
                'save-btn' => 'Simpan Detail Bank',
                'save-success' => 'Detail bank berhasil disimpan.',
            ],

            'kyc' => [
                'title' => 'Dokumen KYC',
                'create-title' => 'Tambah Dokumen KYC',
                'create-btn' => 'Tambah Dokumen',
                'save-btn' => 'Unggah Dokumen',
                'save-success' => 'Dokumen KYC berhasil diunggah.',
                'bank-required' => 'Silakan kirim detail bank Anda sebelum mengunggah dokumen KYC.',
                'type' => 'Jenis Dokumen',
                'file' => 'Berkas Dokumen',

                'types' => [
                    'identity-proof' => 'Bukti Identitas',
                    'registration-proof' => 'Bukti Pendaftaran',
                    'articles-of-association' => 'Anggaran Dasar',
                    'shareholder-declaration' => 'Pernyataan Pemegang Saham',
                    'address-proof' => 'Bukti Alamat',
                ],
            ],

            'transactions' => [
                'title' => 'Transaksi',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Simpan',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'Umum',
                'description' => 'Deskripsi',
                'title' => 'Judul',
                'enable' => 'Aktifkan',
                'sandbox' => 'Sandbox',
                'status' => 'Status',
                'sort-order' => 'Urutan',
                'client-id' => 'ID Klien',
                'passphrase' => 'Frasa Sandi',
                'logo' => 'Logo',
                'logo-information' => 'Resolusi gambar harus 55px × 45px',
                'production-mode-info' => 'Untuk mode produksi, nonaktifkan Sandbox.',
                'info' => 'Pengaturan gateway pembayaran MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'ID Mangopay',
            'wallet-id' => 'ID Dompet',
            'no-of-days' => 'Tetapkan jumlah hari setelah admin dapat melepaskan dana yang ditahan',
            'mangopay-refund' => 'Pengembalian Dana MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'Detail Bank MangoPay',
            'type' => 'Tipe',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Nama Pemilik',
            'owner-address' => 'Alamat Pemilik',
            'owner-city' => 'Kota Pemilik',
            'owner-region' => 'Wilayah Pemilik',
            'owner-postal-code' => 'Kode Pos Pemilik',
            'country' => 'Negara',
            'account-number' => 'Nomor Rekening',
            'sortcode' => 'Kode Bank',
            'aba' => 'ABA',
            'bank-name' => 'Nama Bank',
            'institution-number' => 'Nomor Institusi',
            'branch-code' => 'Kode Cabang',
        ],

        'kyc' => [
            'module-name' => 'KYC MangoPay',
            'type' => 'Tipe',
            'file' => 'File',
            'status' => 'Status',
            'id' => 'ID',
            'created-at' => 'Dibuat Pada',
        ],

        'wallet' => [
            'module-name' => 'Kredensial Dompet Admin MangoPay',
            'wallet-id' => 'ID Dompet',
            'mangopay-id' => 'ID MangoPay',
            'create-wallet' => 'Buat Dompet',
        ],

        'transaction' => [
            'module-name' => 'Transaksi MangoPay',
            'transaction-id' => 'ID Transaksi',
            'amount' => 'Jumlah',
            'message' => 'Pesan',
            'status' => 'Status',
            'id' => 'ID',
            'success' => 'Berhasil',
            'failed' => 'Gagal',
        ],

        'amount' => [
            'module-name' => 'Kelola Dana Escrow',
        ],

        'datagrid' => [
            'order-id' => 'ID Pesanan',
            'wallet-id' => 'ID Dompet',
            'escrowed-amount' => 'Dana Escrow',
            'created-at' => 'Dibuat Pada',
            'transaction-id' => 'ID Transaksi',
            'amount' => 'Jumlah',
            'message' => 'Pesan',
            'status' => 'Status',
            'pay' => 'Bayar',
            'release-amount' => 'Lepaskan Dana',
            'released' => 'Dicairkan',
            'pending' => 'Menunggu',
        ],

        'response' => [
            'wallet-not-found' => 'Dompet tidak ditemukan. Silakan buat dompet terlebih dahulu.',
            'wallet-create-success' => 'Dompet dan ID MangoPay berhasil dibuat.',
            'bank-details-create-success' => 'Detail bank berhasil disimpan.',
            'amount-release-success' => 'Dana escrow berhasil dicairkan.',
            'escrow-not-found' => 'Catatan escrow tidak ditemukan.',
            'already-released' => 'Dana escrow ini sudah dilepaskan.',
            'buyer-wallet-not-found' => 'Dompet pembeli tidak ditemukan.',
            'admin-wallet-not-found' => 'Dompet admin tidak ditemukan.',
            'unsupported-bank-type' => 'Jenis rekening bank tidak didukung: :type',
            'request-in-progress' => 'Permintaan lain untuk pesanan ini sedang diproses. Silakan coba lagi sebentar lagi.',
            'wallet-exists' => 'Toko sudah memiliki dompet MangoPay; dompet tersebut tidak diganti.',
            'insufficient-escrow' => 'Jumlah escrow tidak mencukupi pembayaran penjual untuk pesanan ini.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Nama Produk',
            'qty-ordered' => 'Jumlah Dipesan',
            'qty-to-refund' => 'Jumlah yang Dikembalikan',
            'update-qty' => 'Perbarui Jumlah',
            'refund-summary' => 'Ringkasan Pengembalian Dana',
            'refund-shipping' => 'Pengembalian Biaya Pengiriman',
            'adjustment-refund' => 'Pengembalian Dana Penyesuaian',
            'adjustment-fee' => 'Biaya Penyesuaian',
            'subtotal' => 'Subtotal',
            'tax' => 'Pajak',
            'discount' => 'Diskon',
            'grand-total' => 'Total Keseluruhan',
        ],
    ],
];
