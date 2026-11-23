<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Sie werden in wenigen Sekunden zur MangoPay-Website weitergeleitet.',
            'redirect-button' => 'Klicken Sie hier, wenn Sie nicht innerhalb von 10 Sekunden weitergeleitet werden...',
            'unavailable' => 'Die Zahlungsmethode MangoPay ist derzeit nicht verfügbar. Bitte wählen Sie eine andere Zahlungsmethode oder wenden Sie sich an den Administrator.',
            'canceled' => 'Die MangoPay-Zahlung wurde abgebrochen.',
            'cart-not-found' => 'MangoPay-Warenkorb nicht gefunden. Bitte versuchen Sie erneut, die Bestellung aufzugeben.',
            'wallet-not-found' => 'Für diese Bestellung wurde keine MangoPay-Wallet gefunden.',
            'payment-not-confirmed' => 'Ihre MangoPay-Zahlung konnte nicht bestätigt werden, daher wurde keine Bestellung aufgegeben.',
            'payment-refunded' => 'Ihre Karte wurde belastet, die Bestellung konnte jedoch nicht aufgegeben werden; die Zahlung wurde daher erstattet.',
        ],

        'mangopay' => [
            'not-a-seller' => 'MangoPay-Auszahlungseinstellungen sind nur für Verkäufer verfügbar.',

            'bank-details' => [
                'title' => 'Bankdaten',
                'save-btn' => 'Bankdaten speichern',
                'save-success' => 'Bankdaten erfolgreich gespeichert.',
            ],

            'kyc' => [
                'title' => 'KYC-Dokumente',
                'create-title' => 'KYC-Dokument hinzufügen',
                'create-btn' => 'Dokument hinzufügen',
                'save-btn' => 'Dokument hochladen',
                'save-success' => 'KYC-Dokument erfolgreich hochgeladen.',
                'bank-required' => 'Bitte reichen Sie Ihre Bankdaten ein, bevor Sie KYC-Dokumente hochladen.',
                'type' => 'Dokumenttyp',
                'file' => 'Dokumentdatei',

                'types' => [
                    'identity-proof' => 'Identitätsnachweis',
                    'registration-proof' => 'Registrierungsnachweis',
                    'articles-of-association' => 'Satzung',
                    'shareholder-declaration' => 'Gesellschaftererklärung',
                    'address-proof' => 'Adressnachweis',
                ],
            ],

            'transactions' => [
                'title' => 'Transaktionen',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Speichern',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'Allgemein',
                'description' => 'Beschreibung',
                'title' => 'Titel',
                'enable' => 'Aktivieren',
                'sandbox' => 'Sandbox',
                'status' => 'Status',
                'sort-order' => 'Sortierreihenfolge',
                'client-id' => 'Client-ID',
                'passphrase' => 'Passphrase',
                'logo' => 'Logo',
                'logo-information' => 'Die Bildauflösung sollte 55px × 45px betragen',
                'production-mode-info' => 'Deaktivieren Sie den Sandbox-Modus für den Produktivbetrieb.',
                'info' => 'Einstellungen des MangoPay-Zahlungsgateways',
            ],
        ],

        'system' => [
            'mangopay-id' => 'Mangopay-ID',
            'wallet-id' => 'Wallet-ID',
            'no-of-days' => 'Legen Sie die Anzahl der Tage fest, nach denen der Administrator den zurückgehaltenen Betrag freigeben kann',
            'mangopay-refund' => 'MangoPay-Rückerstattung',
        ],

        'bank-details' => [
            'module-name' => 'MangoPay Bankdaten',
            'type' => 'Typ',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Name des Kontoinhabers',
            'owner-address' => 'Adresse des Kontoinhabers',
            'owner-city' => 'Stadt des Kontoinhabers',
            'owner-region' => 'Region des Kontoinhabers',
            'owner-postal-code' => 'Postleitzahl des Kontoinhabers',
            'country' => 'Land',
            'account-number' => 'Kontonummer',
            'sortcode' => 'Bankleitzahl',
            'aba' => 'ABA',
            'bank-name' => 'Bankname',
            'institution-number' => 'Institutionsnummer',
            'branch-code' => 'Filialcode',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => 'Typ',
            'file' => 'Datei',
            'status' => 'Status',
            'id' => 'ID',
            'created-at' => 'Erstellt am',
        ],

        'wallet' => [
            'module-name' => 'MangoPay Admin-Wallet-Zugangsdaten',
            'wallet-id' => 'Wallet-ID',
            'mangopay-id' => 'MangoPay-ID',
            'create-wallet' => 'Wallet erstellen',
        ],

        'transaction' => [
            'module-name' => 'MangoPay Transaktion',
            'transaction-id' => 'Transaktions-ID',
            'amount' => 'Betrag',
            'message' => 'Nachricht',
            'status' => 'Status',
            'id' => 'ID',
            'success' => 'Erfolgreich',
            'failed' => 'Fehlgeschlagen',
        ],

        'amount' => [
            'module-name' => 'Treuhandbetrag verwalten',
        ],

        'datagrid' => [
            'order-id' => 'Bestell-ID',
            'wallet-id' => 'Wallet-ID',
            'escrowed-amount' => 'Treuhandbetrag',
            'created-at' => 'Erstellt am',
            'transaction-id' => 'Transaktions-ID',
            'amount' => 'Betrag',
            'message' => 'Nachricht',
            'status' => 'Status',
            'pay' => 'Bezahlen',
            'release-amount' => 'Betrag freigeben',
            'released' => 'Freigegeben',
            'pending' => 'Ausstehend',
        ],

        'response' => [
            'wallet-not-found' => 'Wallet nicht gefunden. Bitte erstellen Sie zuerst ein Wallet.',
            'wallet-create-success' => 'Wallet und MangoPay-ID erfolgreich erstellt.',
            'bank-details-create-success' => 'Bankdaten erfolgreich gespeichert.',
            'amount-release-success' => 'Treuhandbetrag erfolgreich freigegeben.',
            'escrow-not-found' => 'Treuhand-Datensatz nicht gefunden.',
            'already-released' => 'Dieser treuhänderisch verwahrte Betrag wurde bereits freigegeben.',
            'buyer-wallet-not-found' => 'Wallet des Käufers nicht gefunden.',
            'admin-wallet-not-found' => 'Admin-Wallet nicht gefunden.',
            'unsupported-bank-type' => 'Nicht unterstützter Bankkontotyp: :type',
            'request-in-progress' => 'Für diese Bestellung läuft bereits eine andere Anfrage. Bitte versuchen Sie es in Kürze erneut.',
            'wallet-exists' => 'Der Shop hat bereits eine MangoPay-Wallet; sie wird nicht ersetzt.',
            'insufficient-escrow' => 'Der treuhänderisch gehaltene Betrag deckt die Verkäuferauszahlungen dieser Bestellung nicht.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Produktname',
            'qty-ordered' => 'Bestellte Menge',
            'qty-to-refund' => 'Menge zur Rückerstattung',
            'update-qty' => 'Menge aktualisieren',
            'refund-summary' => 'Rückerstattungsübersicht',
            'refund-shipping' => 'Versandkosten zurückerstatten',
            'adjustment-refund' => 'Anpassung Rückerstattung',
            'adjustment-fee' => 'Anpassungsgebühr',
            'subtotal' => 'Zwischensumme',
            'tax' => 'Steuer',
            'discount' => 'Rabatt',
            'grand-total' => 'Gesamtsumme',
        ],
    ],
];
