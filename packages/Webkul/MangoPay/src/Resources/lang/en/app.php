<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'You will be redirected to the MangoPay website in a few seconds.',
            'redirect-button' => 'Click here if you are not redirected within 10 seconds...',
            'unavailable' => 'MangoPay payment method is currently unavailable. Please choose another payment method or contact the administrator.',
            'canceled' => 'MangoPay payment has been canceled.',
            'cart-not-found' => 'MangoPay cart not found. Please try placing the order again.',
            'wallet-not-found' => 'MangoPay wallet not found for this order.',
            'payment-not-confirmed' => 'Your MangoPay payment could not be confirmed, so no order was placed.',
            'payment-refunded' => 'Your card was charged but the order could not be placed, so the payment has been refunded.',
        ],

        'mangopay' => [
            'not-a-seller' => 'MangoPay payout settings are available to sellers only.',

            'bank-details' => [
                'title' => 'Bank Details',
                'save-btn' => 'Save Bank Details',
                'save-success' => 'Bank details saved successfully.',
            ],

            'kyc' => [
                'title' => 'KYC Documents',
                'create-title' => 'Add KYC Document',
                'create-btn' => 'Add Document',
                'save-btn' => 'Upload Document',
                'save-success' => 'KYC document uploaded successfully.',
                'bank-required' => 'Please submit your bank details before uploading KYC documents.',
                'type' => 'Document Type',
                'file' => 'Document File',

                'types' => [
                    'identity-proof' => 'Identity Proof',
                    'registration-proof' => 'Registration Proof',
                    'articles-of-association' => 'Articles of Association',
                    'shareholder-declaration' => 'Shareholder Declaration',
                    'address-proof' => 'Address Proof',
                ],
            ],

            'transactions' => [
                'title' => 'Transactions',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Save',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'General',
                'description' => 'Description',
                'title' => 'Title',
                'enable' => 'Enable',
                'sandbox' => 'Sandbox',
                'status' => 'Status',
                'sort-order' => 'Sort Order',
                'client-id' => 'Client ID',
                'passphrase' => 'Passphrase',
                'logo' => 'Logo',
                'logo-information' => 'Image resolution should be like 55px X 45px',
                'production-mode-info' => 'For production mode disable the Sandbox.',
                'info' => 'MangoPay payment gateway settings',
            ],
        ],

        'system' => [
            'mangopay-id' => 'Mangopay ID',
            'wallet-id' => 'Wallet ID',
            'no-of-days' => 'Set No of days after which admin can release hold amount',
            'mangopay-refund' => 'MangoPay Refund',
        ],

        'bank-details' => [
            'module-name' => 'Bank Details',
            'type' => 'Type',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Owner Name',
            'owner-address' => 'Owner Address',
            'owner-city' => 'Owner City',
            'owner-region' => 'Owner Region',
            'owner-postal-code' => 'Owner Postal Code',
            'country' => 'Country',
            'account-number' => 'Account Number',
            'sortcode' => 'Sort Code',
            'aba' => 'ABA',
            'bank-name' => 'Bank Name',
            'institution-number' => 'Institution Number',
            'branch-code' => 'Branch Code',
        ],

        'kyc' => [
            'module-name' => 'KYC',
            'type' => 'Type',
            'file' => 'File',
            'status' => 'Status',
            'id' => 'ID',
            'created-at' => 'Created At',
        ],

        'wallet' => [
            'module-name' => 'MangoPay Admin Wallet Credentials ',
            'wallet-id' => 'Wallet Id',
            'mangopay-id' => 'MangoPay Id',
            'create-wallet' => 'Create Wallet',
        ],

        'transaction' => [
            'module-name' => ' Transaction',
            'transaction-id' => 'Transaction Id',
            'amount' => 'Amount',
            'message' => 'message',
            'status' => 'Status',
            'id' => 'ID',
            'success' => 'Success',
            'failed' => 'Failed',
        ],

        'amount' => [
            'module-name' => 'Manage Escrowed Amount',
        ],

        'datagrid' => [
            'order-id' => 'Order ID',
            'wallet-id' => 'Wallet ID',
            'escrowed-amount' => 'Escrowed Amount',
            'created-at' => 'Created At',
            'transaction-id' => 'Transaction ID',
            'amount' => 'Amount',
            'message' => 'Message',
            'status' => 'Status',
            'pay' => 'Pay',
            'release-amount' => 'Release Amount',
            'released' => 'Released',
            'pending' => 'Pending',
        ],

        'response' => [
            'wallet-not-found' => 'Wallet not found. Please create a wallet first.',
            'wallet-create-success' => 'Wallet and MangoPay ID created successfully.',
            'bank-details-create-success' => 'Bank details saved successfully.',
            'amount-release-success' => 'Escrowed amount released successfully.',
            'escrow-not-found' => 'Escrow record not found.',
            'already-released' => 'This escrowed amount has already been released.',
            'buyer-wallet-not-found' => 'Buyer wallet not found.',
            'admin-wallet-not-found' => 'Admin wallet not found.',
            'unsupported-bank-type' => 'Unsupported bank account type: :type',
            'request-in-progress' => 'Another request for this order is in progress. Please try again shortly.',
            'wallet-exists' => 'The store already has a MangoPay wallet; it is not replaced.',
            'insufficient-escrow' => 'The escrowed amount does not cover the seller payouts of this order.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Product Name',
            'qty-ordered' => 'Qty Ordered',
            'qty-to-refund' => 'Qty to Refund',
            'update-qty' => 'Update Qty',
            'refund-summary' => 'Refund Summary',
            'refund-shipping' => 'Refund Shipping',
            'adjustment-refund' => 'Adjustment Refund',
            'adjustment-fee' => 'Adjustment Fee',
            'subtotal' => 'Subtotal',
            'tax' => 'Tax',
            'discount' => 'Discount',
            'grand-total' => 'Grand Total',
        ],
    ],
];
