<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Sereu redirigit al lloc web de MangoPay en uns segons.',
            'redirect-button' => 'Feu clic aquí si no sou redirigit en 10 segons...',
            'unavailable' => 'El mètode de pagament MangoPay no està disponible ara mateix. Trieu un altre mètode de pagament o contacteu amb l\'administrador.',
            'canceled' => 'S\'ha cancel·lat el pagament amb MangoPay.',
            'cart-not-found' => 'No s\'ha trobat la cistella de MangoPay. Torneu a provar de fer la comanda.',
            'wallet-not-found' => 'No s\'ha trobat el moneder de MangoPay per a aquesta comanda.',
            'payment-not-confirmed' => 'No s\'ha pogut confirmar el pagament de MangoPay, per tant no s\'ha creat cap comanda.',
            'payment-refunded' => 'S\'ha fet el càrrec a la targeta però no s\'ha pogut crear la comanda, per tant s\'ha reemborsat el pagament.',
        ],

        'mangopay' => [
            'not-a-seller' => 'La configuració de pagaments de MangoPay només està disponible per als venedors.',

            'bank-details' => [
                'title' => 'Dades bancàries',
                'save-btn' => 'Desa les dades bancàries',
                'save-success' => 'Dades bancàries desades correctament.',
            ],

            'kyc' => [
                'title' => 'Documents KYC',
                'create-title' => 'Afegeix un document KYC',
                'create-btn' => 'Afegeix un document',
                'save-btn' => 'Puja el document',
                'save-success' => 'Document KYC pujat correctament.',
                'bank-required' => 'Envieu les vostres dades bancàries abans de pujar documents KYC.',
                'type' => 'Tipus de document',
                'file' => 'Fitxer del document',

                'types' => [
                    'identity-proof' => 'Prova d\'identitat',
                    'registration-proof' => 'Prova de registre',
                    'articles-of-association' => 'Estatuts socials',
                    'shareholder-declaration' => 'Declaració d\'accionistes',
                    'address-proof' => 'Prova de domicili',
                ],
            ],

            'transactions' => [
                'title' => 'Transaccions',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Desa',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'General',
                'description' => 'Descripció',
                'title' => 'Títol',
                'enable' => 'Activa',
                'sandbox' => 'Sandbox',
                'status' => 'Estat',
                'sort-order' => 'Ordre de classificació',
                'client-id' => 'ID del client',
                'passphrase' => 'Contrasenya',
                'logo' => 'Logotip',
                'logo-information' => 'La resolució de la imatge ha de ser de 55px × 45px',
                'production-mode-info' => 'Per al mode de producció, desactiveu Sandbox.',
                'info' => 'Configuració de la passarel·la de pagament MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'ID de Mangopay',
            'wallet-id' => 'ID del moneder',
            'no-of-days' => 'Estableix el nombre de dies després dels quals l’administrador pot alliberar l’import retingut',
            'mangopay-refund' => 'Reemborsament MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'Dades bancàries de MangoPay',
            'type' => 'Tipus',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Nom del propietari',
            'owner-address' => 'Adreça del propietari',
            'owner-city' => 'Ciutat del propietari',
            'owner-region' => 'Regió del propietari',
            'owner-postal-code' => 'Codi postal del propietari',
            'country' => 'País',
            'account-number' => 'Número de compte',
            'sortcode' => 'Codi bancari',
            'aba' => 'ABA',
            'bank-name' => 'Nom del banc',
            'institution-number' => 'Número de la institució',
            'branch-code' => 'Codi de sucursal',
        ],

        'kyc' => [
            'module-name' => 'KYC de MangoPay',
            'type' => 'Tipus',
            'file' => 'Fitxer',
            'status' => 'Estat',
            'id' => 'ID',
            'created-at' => 'Data de creació',
        ],

        'wallet' => [
            'module-name' => 'Credencials del moneder d’administració MangoPay',
            'wallet-id' => 'ID del moneder',
            'mangopay-id' => 'ID de MangoPay',
            'create-wallet' => 'Crear moneder',
        ],

        'transaction' => [
            'module-name' => 'Transacció MangoPay',
            'transaction-id' => 'ID de transacció',
            'amount' => 'Import',
            'message' => 'Missatge',
            'status' => 'Estat',
            'id' => 'ID',
            'success' => 'Correcta',
            'failed' => 'Fallida',
        ],

        'amount' => [
            'module-name' => 'Gestionar l’import en dipòsit',
        ],

        'datagrid' => [
            'order-id' => 'ID de la comanda',
            'wallet-id' => 'ID del moneder',
            'escrowed-amount' => 'Import en dipòsit',
            'created-at' => 'Data de creació',
            'transaction-id' => 'ID de transacció',
            'amount' => 'Import',
            'message' => 'Missatge',
            'status' => 'Estat',
            'pay' => 'Pagar',
            'release-amount' => 'Alliberar import',
            'released' => 'Alliberat',
            'pending' => 'Pendent',
        ],

        'response' => [
            'wallet-not-found' => 'No s\'ha trobat el moneder. Creeu primer un moneder.',
            'wallet-create-success' => 'Moneder i identificador de MangoPay creats correctament.',
            'bank-details-create-success' => 'Dades bancàries desades correctament.',
            'amount-release-success' => 'Import retingut alliberat correctament.',
            'escrow-not-found' => 'No s\'ha trobat el registre de dipòsit.',
            'already-released' => 'Aquest import en dipòsit ja s\'ha alliberat.',
            'buyer-wallet-not-found' => 'No s\'ha trobat el moneder del comprador.',
            'admin-wallet-not-found' => 'No s\'ha trobat el moneder de l\'administrador.',
            'unsupported-bank-type' => 'Tipus de compte bancari no admès: :type',
            'request-in-progress' => 'Hi ha una altra sol·licitud en curs per a aquesta comanda. Torneu-ho a provar d\'aquí a poc.',
            'wallet-exists' => 'La botiga ja té una cartera de MangoPay; no es substitueix.',
            'insufficient-escrow' => 'L\'import en dipòsit no cobreix els pagaments als venedors d\'aquesta comanda.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Nom del producte',
            'qty-ordered' => 'Quantitat demanada',
            'qty-to-refund' => 'Quantitat a Reembossar',
            'update-qty' => 'Actualitza la quantitat',
            'refund-summary' => 'Resum del reemborsament',
            'refund-shipping' => 'Refund Shipping',
            'adjustment-refund' => 'Adjustment Refund',
            'adjustment-fee' => 'Adjustment Fee',
            'subtotal' => 'Subtotal',
            'tax' => 'Impostos',
            'discount' => 'Descompte',
            'grand-total' => 'Total General',
        ],
    ],
];
