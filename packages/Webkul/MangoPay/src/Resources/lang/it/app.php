<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Sarai reindirizzato al sito web di MangoPay tra pochi secondi.',
            'redirect-button' => 'Clicca qui se non vieni reindirizzato entro 10 secondi...',
            'unavailable' => 'Il metodo di pagamento MangoPay non è al momento disponibile. Scegli un altro metodo di pagamento o contatta l\'amministratore.',
            'canceled' => 'Il pagamento MangoPay è stato annullato.',
            'cart-not-found' => 'Carrello MangoPay non trovato. Prova a effettuare di nuovo l\'ordine.',
            'wallet-not-found' => 'Portafoglio MangoPay non trovato per questo ordine.',
            'payment-not-confirmed' => 'Non è stato possibile confermare il pagamento MangoPay, quindi non è stato effettuato alcun ordine.',
            'payment-refunded' => 'La tua carta è stata addebitata ma non è stato possibile creare l\'ordine, quindi il pagamento è stato rimborsato.',
        ],

        'mangopay' => [
            'not-a-seller' => 'Le impostazioni di pagamento MangoPay sono disponibili solo per i venditori.',

            'bank-details' => [
                'title' => 'Dettagli Bancari',
                'save-btn' => 'Salva dati bancari',
                'save-success' => 'Dati bancari salvati con successo.',
            ],

            'kyc' => [
                'title' => 'Documenti KYC',
                'create-title' => 'Aggiungi documento KYC',
                'create-btn' => 'Aggiungi documento',
                'save-btn' => 'Carica documento',
                'save-success' => 'Documento KYC caricato con successo.',
                'bank-required' => 'Invia i tuoi dati bancari prima di caricare i documenti KYC.',
                'type' => 'Tipo di documento',
                'file' => 'File del documento',

                'types' => [
                    'identity-proof' => 'Prova di identità',
                    'registration-proof' => 'Prova di registrazione',
                    'articles-of-association' => 'Atto costitutivo',
                    'shareholder-declaration' => 'Dichiarazione degli azionisti',
                    'address-proof' => 'Prova di indirizzo',
                ],
            ],

            'transactions' => [
                'title' => 'Transazioni',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Salva',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'Generale',
                'description' => 'Descrizione',
                'title' => 'Titolo',
                'enable' => 'Abilita',
                'sandbox' => 'Sandbox',
                'status' => 'Stato',
                'sort-order' => 'Ordine di ordinamento',
                'client-id' => 'ID Cliente',
                'passphrase' => 'Passphrase',
                'logo' => 'Logo',
                'logo-information' => 'La risoluzione dell\'immagine deve essere 55px × 45px',
                'production-mode-info' => 'Per la modalità di produzione, disabilitare Sandbox.',
                'info' => 'Impostazioni del gateway di pagamento MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'ID Mangopay',
            'wallet-id' => 'ID Portafoglio',
            'no-of-days' => 'Imposta il numero di giorni dopo i quali l\'amministratore può rilasciare l\'importo trattenuto',
            'mangopay-refund' => 'Rimborso MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'Dettagli Bancari MangoPay',
            'type' => 'Tipo',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Nome del Titolare',
            'owner-address' => 'Indirizzo del Titolare',
            'owner-city' => 'Città del Titolare',
            'owner-region' => 'Regione del Titolare',
            'owner-postal-code' => 'CAP del Titolare',
            'country' => 'Paese',
            'account-number' => 'Numero di Conto',
            'sortcode' => 'Codice Bancario',
            'aba' => 'ABA',
            'bank-name' => 'Nome della Banca',
            'institution-number' => 'Numero dell\'Istituto',
            'branch-code' => 'Codice Filiale',
        ],

        'kyc' => [
            'module-name' => 'KYC MangoPay',
            'type' => 'Tipo',
            'file' => 'File',
            'status' => 'Stato',
            'id' => 'ID',
            'created-at' => 'Creato il',
        ],

        'wallet' => [
            'module-name' => 'Credenziali Portafoglio Admin MangoPay',
            'wallet-id' => 'ID Portafoglio',
            'mangopay-id' => 'ID MangoPay',
            'create-wallet' => 'Crea Portafoglio',
        ],

        'transaction' => [
            'module-name' => 'Transazione MangoPay',
            'transaction-id' => 'ID Transazione',
            'amount' => 'Importo',
            'message' => 'Messaggio',
            'status' => 'Stato',
            'id' => 'ID',
            'success' => 'Riuscito',
            'failed' => 'Fallito',
        ],

        'amount' => [
            'module-name' => 'Gestisci Importo in Deposito',
        ],

        'datagrid' => [
            'order-id' => 'ID Ordine',
            'wallet-id' => 'ID Portafoglio',
            'escrowed-amount' => 'Importo in Deposito',
            'created-at' => 'Creato il',
            'transaction-id' => 'ID Transazione',
            'amount' => 'Importo',
            'message' => 'Messaggio',
            'status' => 'Stato',
            'pay' => 'Paga',
            'release-amount' => 'Rilascia Importo',
            'released' => 'Rilasciato',
            'pending' => 'In Attesa',
        ],

        'response' => [
            'wallet-not-found' => 'Portafoglio non trovato. Crea prima un portafoglio.',
            'wallet-create-success' => 'Portafoglio e ID MangoPay creati con successo.',
            'bank-details-create-success' => 'Dati bancari salvati con successo.',
            'amount-release-success' => 'Importo vincolato rilasciato con successo.',
            'escrow-not-found' => 'Record di deposito a garanzia non trovato.',
            'already-released' => 'Questo importo in deposito è già stato rilasciato.',
            'buyer-wallet-not-found' => 'Portafoglio dell\'acquirente non trovato.',
            'admin-wallet-not-found' => 'Portafoglio dell\'amministratore non trovato.',
            'unsupported-bank-type' => 'Tipo di conto bancario non supportato: :type',
            'request-in-progress' => 'È in corso un\'altra richiesta per questo ordine. Riprova tra poco.',
            'wallet-exists' => 'Il negozio ha già un portafoglio MangoPay; non viene sostituito.',
            'insufficient-escrow' => 'L\'importo in deposito non copre i pagamenti ai venditori di questo ordine.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Nome Prodotto',
            'qty-ordered' => 'Quantità ordinata',
            'qty-to-refund' => 'QTA da rimborsare',
            'update-qty' => 'Aggiorna quantità',
            'refund-summary' => 'Riepilogo del rimborso',
            'refund-shipping' => 'Rimborsa Spedizione',
            'adjustment-refund' => 'Rimborso di Adeguamento',
            'adjustment-fee' => 'Commissione di Adeguamento',
            'subtotal' => 'Subtotale',
            'tax' => 'Tasse',
            'discount' => 'Sconto',
            'grand-total' => 'Totale Generale',
        ],
    ],
];
