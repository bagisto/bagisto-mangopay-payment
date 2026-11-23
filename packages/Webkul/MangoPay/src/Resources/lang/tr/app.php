<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Birkaç saniye içinde MangoPay web sitesine yönlendirileceksiniz.',
            'redirect-button' => '10 saniye içinde yönlendirilmezseniz buraya tıklayın...',
            'unavailable' => 'MangoPay ödeme yöntemi şu anda kullanılamıyor. Lütfen başka bir ödeme yöntemi seçin veya yöneticiyle iletişime geçin.',
            'canceled' => 'MangoPay ödemesi iptal edildi.',
            'cart-not-found' => 'MangoPay sepeti bulunamadı. Lütfen siparişi yeniden vermeyi deneyin.',
            'wallet-not-found' => 'Bu sipariş için MangoPay cüzdanı bulunamadı.',
            'payment-not-confirmed' => 'MangoPay ödemeniz doğrulanamadı, bu nedenle sipariş oluşturulmadı.',
            'payment-refunded' => 'Kartınızdan ödeme alındı ancak sipariş oluşturulamadı, bu nedenle ödeme iade edildi.',
        ],

        'mangopay' => [
            'not-a-seller' => 'MangoPay ödeme ayarları yalnızca satıcılar için kullanılabilir.',

            'bank-details' => [
                'title' => 'Banka Bilgileri',
                'save-btn' => 'Banka bilgilerini kaydet',
                'save-success' => 'Banka bilgileri başarıyla kaydedildi.',
            ],

            'kyc' => [
                'title' => 'KYC Belgeleri',
                'create-title' => 'KYC Belgesi Ekle',
                'create-btn' => 'Belge Ekle',
                'save-btn' => 'Belge Yükle',
                'save-success' => 'KYC belgesi başarıyla yüklendi.',
                'bank-required' => 'KYC belgelerini yüklemeden önce lütfen banka bilgilerinizi gönderin.',
                'type' => 'Belge Türü',
                'file' => 'Belge Dosyası',

                'types' => [
                    'identity-proof' => 'Kimlik Belgesi',
                    'registration-proof' => 'Kayıt Belgesi',
                    'articles-of-association' => 'Ana Sözleşme',
                    'shareholder-declaration' => 'Hissedar Beyanı',
                    'address-proof' => 'Adres Belgesi',
                ],
            ],

            'transactions' => [
                'title' => 'İşlemler',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Kaydet',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'Genel',
                'description' => 'Açıklama',
                'title' => 'Başlık',
                'enable' => 'Etkinleştir',
                'sandbox' => 'Sandbox',
                'status' => 'Durum',
                'sort-order' => 'Sıralama Düzeni',
                'client-id' => 'Müşteri Kimliği',
                'passphrase' => 'Parola İfadesi',
                'logo' => 'Logo',
                'logo-information' => 'Görsel çözünürlüğü 55px × 45px olmalıdır',
                'production-mode-info' => 'Canlı kullanım için Sandbox\'ı devre dışı bırakın.',
                'info' => 'MangoPay ödeme ağ geçidi ayarları',
            ],
        ],

        'system' => [
            'mangopay-id' => 'Mangopay Kimliği',
            'wallet-id' => 'Cüzdan Kimliği',
            'no-of-days' => 'Yöneticinin bekletilen tutarı serbest bırakabileceği gün sayısını belirleyin',
            'mangopay-refund' => 'MangoPay İadesi',
        ],

        'bank-details' => [
            'module-name' => 'MangoPay Banka Bilgileri',
            'type' => 'Tür',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Hesap Sahibi Adı',
            'owner-address' => 'Hesap Sahibi Adresi',
            'owner-city' => 'Hesap Sahibi Şehri',
            'owner-region' => 'Hesap Sahibi Bölgesi',
            'owner-postal-code' => 'Hesap Sahibi Posta Kodu',
            'country' => 'Ülke',
            'account-number' => 'Hesap Numarası',
            'sortcode' => 'Banka Kodu',
            'aba' => 'ABA',
            'bank-name' => 'Banka Adı',
            'institution-number' => 'Kurum Numarası',
            'branch-code' => 'Şube Kodu',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => 'Tür',
            'file' => 'Dosya',
            'status' => 'Durum',
            'id' => 'Kimlik',
            'created-at' => 'Oluşturulma Tarihi',
        ],

        'wallet' => [
            'module-name' => 'MangoPay Yönetici Cüzdan Bilgileri',
            'wallet-id' => 'Cüzdan Kimliği',
            'mangopay-id' => 'MangoPay Kimliği',
            'create-wallet' => 'Cüzdan Oluştur',
        ],

        'transaction' => [
            'module-name' => 'MangoPay İşlemi',
            'transaction-id' => 'İşlem Kimliği',
            'amount' => 'Tutar',
            'message' => 'Mesaj',
            'status' => 'Durum',
            'id' => 'Kimlik',
            'success' => 'Başarılı',
            'failed' => 'Başarısız',
        ],

        'amount' => [
            'module-name' => 'Emanet Tutarını Yönet',
        ],

        'datagrid' => [
            'order-id' => 'Sipariş Kimliği',
            'wallet-id' => 'Cüzdan Kimliği',
            'escrowed-amount' => 'Emanet Tutarı',
            'created-at' => 'Oluşturulma Tarihi',
            'transaction-id' => 'İşlem Kimliği',
            'amount' => 'Tutar',
            'message' => 'Mesaj',
            'status' => 'Durum',
            'pay' => 'Öde',
            'release-amount' => 'Tutarı Serbest Bırak',
            'released' => 'Serbest Bırakıldı',
            'pending' => 'Bekliyor',
        ],

        'response' => [
            'wallet-not-found' => 'Cüzdan bulunamadı. Lütfen önce bir cüzdan oluşturun.',
            'wallet-create-success' => 'Cüzdan ve MangoPay kimliği başarıyla oluşturuldu.',
            'bank-details-create-success' => 'Banka bilgileri başarıyla kaydedildi.',
            'amount-release-success' => 'Emanetteki tutar başarıyla serbest bırakıldı.',
            'escrow-not-found' => 'Emanet kaydı bulunamadı.',
            'already-released' => 'Bu emanet tutarı zaten serbest bırakıldı.',
            'buyer-wallet-not-found' => 'Alıcı cüzdanı bulunamadı.',
            'admin-wallet-not-found' => 'Yönetici cüzdanı bulunamadı.',
            'unsupported-bank-type' => 'Desteklenmeyen banka hesabı türü: :type',
            'request-in-progress' => 'Bu sipariş için başka bir istek işleniyor. Lütfen kısa süre sonra tekrar deneyin.',
            'wallet-exists' => 'Mağazanın zaten bir MangoPay cüzdanı var; değiştirilmez.',
            'insufficient-escrow' => 'Emanetteki tutar bu siparişin satıcı ödemelerini karşılamıyor.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Ürün Adı',
            'qty-ordered' => 'Sipariş Edilen Miktar',
            'qty-to-refund' => 'İade Edilecek Miktar',
            'update-qty' => 'Miktarı Güncelle',
            'refund-summary' => 'İade Özeti',
            'refund-shipping' => 'Kargo İadesi',
            'adjustment-refund' => 'Düzenleme İadesi',
            'adjustment-fee' => 'Düzenleme Ücreti',
            'subtotal' => 'Ara Toplam',
            'tax' => 'KDV',
            'discount' => 'İndirim',
            'grand-total' => 'Genel Toplam',
        ],
    ],
];
