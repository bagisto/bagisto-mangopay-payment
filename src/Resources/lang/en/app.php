<?php

return [
    'admin'         => [
        "mangopay" => [
            "save-btn-title" => "Save",
            "module-name" => "MangoPay"
        ],

        'system'    => [
            'module-name' => "MangoPay",
            'general' => "General",
             'title' => "Title",
             'enable' => 'Enable',
             'sandbox' => 'Sandbox',
             'status' => 'Status',
             'client-id' => "Client ID",
             'passphrase' => "Passphrase",
             'mangopay-id' => "Mangopay ID",
             'wallet-id' => "Wallet ID",
             'no-of-days' => "Set No of days after which admin can release hold amount",
             'sort_order' => "Sort Order",
             'mangopay_refund' => "MangoPay Refund"      
        ],

        'bank-details' => [
            "module-name" => "MangoPay Bank Details",
            "type" => "Type",
            "iban" => "IBAN",
            "bic" => "BIC",
            "owner-name" => "Owner Name",
            "owner-address"=> "Owner Address",
            "owner-city" => "Owner City",
            "owner-region" => "Owner Region",
            "owner-postal-code" => "Owner Postal Code",
            "country" => "Country",
            "account-number" => "Account Number",
            "sortcode" => "Sort Code",
            "aba" => "ABA",
            "bank-name" => "Bank Name",
            "institution-number" => "Institution Number",
            "branch-code" => "Branch Code",
            "bic" => "BIC",
        ],

        'kyc' => [
            "module-name" => "MangoPay KYC",
            "type" => "Type",
            "file" => "File",
            "status" => "Status",
            "id" => "ID",
            "created-at" => "Created At"
        ],

        'wallet' => [
            "module-name" => "MangoPay Admin Wallet Credentials ",
            "wallet-id" => "Wallet Id",
            "mangopay-id" => "MangoPay Id",
            "create-wallet" => "Create Wallet"
        ],
        
        'transaction' => [
            "module-name" => "MangoPay Transaction",
            "transaction-id" => "Transaction Id",
            "amount" => "Amount",
            "message" => "message",
            "status" => "Status",
            "id" => "ID"
        ],

        'amount' => [
            "module-name" => "Manage Escrowed Amount"
        ],

        "datagrid" => [
            "order_id" => "Order ID",
            "wallet_id" => "Wallet ID",
            "escrowed_amount" => "Escrowed Amount",
            "created_at" => "Created At",
            "transaction_id" => "Transaction ID",
            "amount" => "Amount",
            "message"=> "Message",
            "status" => "Status",
            "pay" => "Pay",
            "release-amount" => "Release Amount"
        ]
    ],
   
]

?>
