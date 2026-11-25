<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Vous serez redirigé vers le site MangoPay dans quelques secondes.',
            'redirect-button' => 'Cliquez ici si la redirection ne se fait pas dans les 10 secondes...',
            'unavailable' => 'Le mode de paiement MangoPay est actuellement indisponible. Veuillez choisir un autre mode de paiement ou contacter l\'administrateur.',
            'canceled' => 'Le paiement MangoPay a été annulé.',
            'cart-not-found' => 'Panier MangoPay introuvable. Veuillez réessayer de passer la commande.',
            'wallet-not-found' => 'Portefeuille MangoPay introuvable pour cette commande.',
            'payment-not-confirmed' => 'Votre paiement MangoPay n\'a pas pu être confirmé, aucune commande n\'a donc été passée.',
            'payment-refunded' => 'Votre carte a été débitée mais la commande n\'a pas pu être passée ; le paiement a donc été remboursé.',
        ],

        'mangopay' => [
            'not-a-seller' => 'Les paramètres de versement MangoPay sont réservés aux vendeurs.',

            'bank-details' => [
                'title' => 'Coordonnées bancaires',
                'save-btn' => 'Enregistrer les coordonnées bancaires',
                'save-success' => 'Coordonnées bancaires enregistrées avec succès.',
            ],

            'kyc' => [
                'title' => 'Documents KYC',
                'create-title' => 'Ajouter un document KYC',
                'create-btn' => 'Ajouter un document',
                'save-btn' => 'Téléverser le document',
                'save-success' => 'Document KYC téléversé avec succès.',
                'bank-required' => 'Veuillez soumettre vos coordonnées bancaires avant de téléverser des documents KYC.',
                'type' => 'Type de document',
                'file' => 'Fichier du document',

                'types' => [
                    'identity-proof' => 'Justificatif d\'identité',
                    'registration-proof' => 'Justificatif d\'immatriculation',
                    'articles-of-association' => 'Statuts de la société',
                    'shareholder-declaration' => 'Déclaration des actionnaires',
                    'address-proof' => 'Justificatif de domicile',
                ],
            ],

            'transactions' => [
                'title' => 'Transactions',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Enregistrer',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'Général',
                'description' => 'Description',
                'title' => 'Titre',
                'enable' => 'Activer',
                'sandbox' => 'Bac à sable',
                'status' => 'Statut',
                'sort-order' => 'Ordre de tri',
                'client-id' => 'ID Client',
                'passphrase' => 'Phrase secrète',
                'logo' => 'Logo',
                'logo-information' => 'La résolution de l’image doit être de 55px × 45px',
                'production-mode-info' => 'Pour le mode production, désactivez le bac à sable.',
                'info' => 'Paramètres de la passerelle de paiement MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'ID Mangopay',
            'wallet-id' => 'ID du portefeuille',
            'no-of-days' => 'Définissez le nombre de jours après lesquels l’administrateur peut libérer le montant retenu',
            'mangopay-refund' => 'Remboursement MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'Informations bancaires MangoPay',
            'type' => 'Type',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Nom du titulaire',
            'owner-address' => 'Adresse du titulaire',
            'owner-city' => 'Ville du titulaire',
            'owner-region' => 'Région du titulaire',
            'owner-postal-code' => 'Code postal du titulaire',
            'country' => 'Pays',
            'account-number' => 'Numéro de compte',
            'sortcode' => 'Code bancaire',
            'aba' => 'ABA',
            'bank-name' => 'Nom de la banque',
            'institution-number' => 'Numéro de l’institution',
            'branch-code' => 'Code de l’agence',
        ],

        'kyc' => [
            'module-name' => 'KYC MangoPay',
            'type' => 'Type',
            'file' => 'Fichier',
            'status' => 'Statut',
            'id' => 'ID',
            'created-at' => 'Créé le',
        ],

        'wallet' => [
            'module-name' => 'Identifiants du portefeuille administrateur MangoPay',
            'wallet-id' => 'ID du portefeuille',
            'mangopay-id' => 'ID MangoPay',
            'create-wallet' => 'Créer un portefeuille',
        ],

        'transaction' => [
            'module-name' => 'Transaction MangoPay',
            'transaction-id' => 'ID de transaction',
            'amount' => 'Montant',
            'message' => 'Message',
            'status' => 'Statut',
            'id' => 'ID',
            'success' => 'Réussi',
            'failed' => 'Échoué',
        ],

        'amount' => [
            'module-name' => 'Gérer le montant sous séquestre',
        ],

        'datagrid' => [
            'order-id' => 'ID de commande',
            'wallet-id' => 'ID du portefeuille',
            'escrowed-amount' => 'Montant sous séquestre',
            'created-at' => 'Créé le',
            'transaction-id' => 'ID de transaction',
            'amount' => 'Montant',
            'message' => 'Message',
            'status' => 'Statut',
            'pay' => 'Payer',
            'release-amount' => 'Libérer le montant',
            'released' => 'Libéré',
            'pending' => 'En attente',
        ],

        'response' => [
            'wallet-not-found' => 'Portefeuille introuvable. Veuillez d\'abord créer un portefeuille.',
            'wallet-create-success' => 'Portefeuille et identifiant MangoPay créés avec succès.',
            'bank-details-create-success' => 'Coordonnées bancaires enregistrées avec succès.',
            'amount-release-success' => 'Montant sous séquestre libéré avec succès.',
            'escrow-not-found' => 'Enregistrement de séquestre introuvable.',
            'already-released' => 'Ce montant séquestré a déjà été libéré.',
            'buyer-wallet-not-found' => 'Portefeuille de l\'acheteur introuvable.',
            'admin-wallet-not-found' => 'Portefeuille de l\'administrateur introuvable.',
            'unsupported-bank-type' => 'Type de compte bancaire non pris en charge : :type',
            'request-in-progress' => 'Une autre demande est en cours pour cette commande. Veuillez réessayer dans un instant.',
            'wallet-exists' => 'La boutique possède déjà un portefeuille MangoPay ; il n\'est pas remplacé.',
            'insufficient-escrow' => 'Le montant sous séquestre ne couvre pas les versements aux vendeurs de cette commande.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Nom du produit',
            'qty-ordered' => 'Quantité commandée',
            'qty-to-refund' => 'Quantité à rembourser',
            'update-qty' => 'Mettre à jour la quantité',
            'refund-summary' => 'Récapitulatif du remboursement',
            'refund-shipping' => 'Remboursement de l’expédition',
            'adjustment-refund' => 'Remboursement d’ajustement',
            'adjustment-fee' => 'Frais d’ajustement',
            'subtotal' => 'Sous-total',
            'tax' => 'Taxe',
            'discount' => 'Remise',
            'grand-total' => 'Total général',
        ],
    ],
];
