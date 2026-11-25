<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'U wordt over enkele seconden doorgestuurd naar de MangoPay-website.',
            'redirect-button' => 'Klik hier als u niet binnen 10 seconden wordt doorgestuurd...',
            'unavailable' => 'De betaalmethode MangoPay is momenteel niet beschikbaar. Kies een andere betaalmethode of neem contact op met de beheerder.',
            'canceled' => 'De MangoPay-betaling is geannuleerd.',
            'cart-not-found' => 'MangoPay-winkelwagen niet gevonden. Probeer de bestelling opnieuw te plaatsen.',
            'wallet-not-found' => 'Geen MangoPay-wallet gevonden voor deze bestelling.',
            'payment-not-confirmed' => 'Uw MangoPay-betaling kon niet worden bevestigd, daarom is er geen bestelling geplaatst.',
            'payment-refunded' => 'Uw kaart is belast maar de bestelling kon niet worden geplaatst; de betaling is daarom terugbetaald.',
        ],

        'mangopay' => [
            'not-a-seller' => 'MangoPay-uitbetalingsinstellingen zijn alleen beschikbaar voor verkopers.',

            'bank-details' => [
                'title' => 'Bankgegevens',
                'save-btn' => 'Bankgegevens opslaan',
                'save-success' => 'Bankgegevens succesvol opgeslagen.',
            ],

            'kyc' => [
                'title' => 'KYC-documenten',
                'create-title' => 'KYC-document toevoegen',
                'create-btn' => 'Document toevoegen',
                'save-btn' => 'Document uploaden',
                'save-success' => 'KYC-document succesvol geüpload.',
                'bank-required' => 'Dien uw bankgegevens in voordat u KYC-documenten uploadt.',
                'type' => 'Documenttype',
                'file' => 'Documentbestand',

                'types' => [
                    'identity-proof' => 'Identiteitsbewijs',
                    'registration-proof' => 'Registratiebewijs',
                    'articles-of-association' => 'Statuten',
                    'shareholder-declaration' => 'Aandeelhoudersverklaring',
                    'address-proof' => 'Adresbewijs',
                ],
            ],

            'transactions' => [
                'title' => 'Transacties',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Opslaan',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'Algemeen',
                'description' => 'Beschrijving',
                'title' => 'Titel',
                'enable' => 'Inschakelen',
                'sandbox' => 'Sandbox',
                'status' => 'Status',
                'sort-order' => 'Sorteervolgorde',
                'client-id' => 'Client-ID',
                'passphrase' => 'Wachtwoordzin',
                'logo' => 'Logo',
                'logo-information' => 'De afbeeldingsresolutie moet 55px × 45px zijn',
                'production-mode-info' => 'Schakel Sandbox uit voor de productieomgeving.',
                'info' => 'Instellingen van de MangoPay-betaalgateway',
            ],
        ],

        'system' => [
            'mangopay-id' => 'Mangopay-ID',
            'wallet-id' => 'Wallet-ID',
            'no-of-days' => 'Stel het aantal dagen in waarna de beheerder het vastgehouden bedrag kan vrijgeven',
            'mangopay-refund' => 'MangoPay-terugbetaling',
        ],

        'bank-details' => [
            'module-name' => 'MangoPay Bankgegevens',
            'type' => 'Type',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Naam rekeninghouder',
            'owner-address' => 'Adres rekeninghouder',
            'owner-city' => 'Plaats rekeninghouder',
            'owner-region' => 'Regio rekeninghouder',
            'owner-postal-code' => 'Postcode rekeninghouder',
            'country' => 'Land',
            'account-number' => 'Rekeningnummer',
            'sortcode' => 'Bankcode',
            'aba' => 'ABA',
            'bank-name' => 'Banknaam',
            'institution-number' => 'Instellingsnummer',
            'branch-code' => 'Filiaalcode',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => 'Type',
            'file' => 'Bestand',
            'status' => 'Status',
            'id' => 'ID',
            'created-at' => 'Aangemaakt op',
        ],

        'wallet' => [
            'module-name' => 'MangoPay Admin Wallet-gegevens',
            'wallet-id' => 'Wallet-ID',
            'mangopay-id' => 'MangoPay-ID',
            'create-wallet' => 'Wallet aanmaken',
        ],

        'transaction' => [
            'module-name' => 'MangoPay Transactie',
            'transaction-id' => 'Transactie-ID',
            'amount' => 'Bedrag',
            'message' => 'Bericht',
            'status' => 'Status',
            'id' => 'ID',
            'success' => 'Geslaagd',
            'failed' => 'Mislukt',
        ],

        'amount' => [
            'module-name' => 'Beheer Escrow-bedrag',
        ],

        'datagrid' => [
            'order-id' => 'Bestel-ID',
            'wallet-id' => 'Wallet-ID',
            'escrowed-amount' => 'Escrow-bedrag',
            'created-at' => 'Aangemaakt op',
            'transaction-id' => 'Transactie-ID',
            'amount' => 'Bedrag',
            'message' => 'Bericht',
            'status' => 'Status',
            'pay' => 'Betalen',
            'release-amount' => 'Bedrag vrijgeven',
            'released' => 'Vrijgegeven',
            'pending' => 'Wachtend',
        ],

        'response' => [
            'wallet-not-found' => 'Wallet niet gevonden. Maak eerst een wallet aan.',
            'wallet-create-success' => 'Wallet en MangoPay-ID succesvol aangemaakt.',
            'bank-details-create-success' => 'Bankgegevens succesvol opgeslagen.',
            'amount-release-success' => 'Geblokkeerd bedrag succesvol vrijgegeven.',
            'escrow-not-found' => 'Escrow-record niet gevonden.',
            'already-released' => 'Dit bedrag in escrow is al vrijgegeven.',
            'buyer-wallet-not-found' => 'Wallet van de koper niet gevonden.',
            'admin-wallet-not-found' => 'Beheerderswallet niet gevonden.',
            'unsupported-bank-type' => 'Niet-ondersteund type bankrekening: :type',
            'request-in-progress' => 'Er loopt al een ander verzoek voor deze bestelling. Probeer het zo meteen opnieuw.',
            'wallet-exists' => 'De winkel heeft al een MangoPay-wallet; deze wordt niet vervangen.',
            'insufficient-escrow' => 'Het in escrow gehouden bedrag dekt de uitbetalingen aan de verkopers van deze bestelling niet.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Productnaam',
            'qty-ordered' => 'Bestelde hoeveelheid',
            'qty-to-refund' => 'Aantal om terug te betalen',
            'update-qty' => 'Hoeveelheid bijwerken',
            'refund-summary' => 'Overzicht terugbetaling',
            'refund-shipping' => 'Verzendkosten terugbetalen',
            'adjustment-refund' => 'Aanpassing Terugbetaling',
            'adjustment-fee' => 'Aanpassingskosten',
            'subtotal' => 'Subtotaal',
            'tax' => 'BTW',
            'discount' => 'Korting',
            'grand-total' => 'Totaalbedrag',
        ],
    ],
];
