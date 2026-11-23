<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => '数秒後に MangoPay のウェブサイトにリダイレクトされます。',
            'redirect-button' => '10秒以内にリダイレクトされない場合はこちらをクリックしてください...',
            'unavailable' => 'MangoPay 決済方法は現在ご利用いただけません。別の決済方法を選択するか、管理者にお問い合わせください。',
            'canceled' => 'MangoPay の支払いはキャンセルされました。',
            'cart-not-found' => 'MangoPay のカートが見つかりません。もう一度注文してください。',
            'wallet-not-found' => 'この注文の MangoPay ウォレットが見つかりません。',
            'payment-not-confirmed' => 'MangoPay の支払いを確認できなかったため、注文は作成されませんでした。',
            'payment-refunded' => 'カードに請求されましたが注文を作成できなかったため、支払いは返金されました。',
        ],

        'mangopay' => [
            'not-a-seller' => 'MangoPay の支払い設定は販売者のみ利用できます。',

            'bank-details' => [
                'title' => '銀行詳細',
                'save-btn' => '銀行口座情報を保存',
                'save-success' => '銀行口座情報が正常に保存されました。',
            ],

            'kyc' => [
                'title' => 'KYC書類',
                'create-title' => 'KYC書類を追加',
                'create-btn' => '書類を追加',
                'save-btn' => '書類をアップロード',
                'save-success' => 'KYC書類が正常にアップロードされました。',
                'bank-required' => 'KYC書類をアップロードする前に銀行口座情報を送信してください。',
                'type' => '書類の種類',
                'file' => '書類ファイル',

                'types' => [
                    'identity-proof' => '本人確認書類',
                    'registration-proof' => '登記事項証明書',
                    'articles-of-association' => '定款',
                    'shareholder-declaration' => '株主宣言書',
                    'address-proof' => '住所証明書',
                ],
            ],

            'transactions' => [
                'title' => '取引',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => '保存',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => '一般',
                'description' => '説明',
                'title' => 'タイトル',
                'enable' => '有効化',
                'sandbox' => 'サンドボックス',
                'status' => 'ステータス',
                'sort-order' => '並び順',
                'client-id' => 'クライアントID',
                'passphrase' => 'パスフレーズ',
                'logo' => 'ロゴ',
                'logo-information' => '画像解像度は55px × 45pxにしてください',
                'production-mode-info' => '本番環境ではサンドボックスを無効にしてください。',
                'info' => 'MangoPay 決済ゲートウェイの設定',
            ],
        ],

        'system' => [
            'mangopay-id' => 'Mangopay ID',
            'wallet-id' => 'ウォレットID',
            'no-of-days' => '管理者が保留中の金額を解放できるまでの日数を設定します',
            'mangopay-refund' => 'MangoPay返金',
        ],

        'bank-details' => [
            'module-name' => 'MangoPay銀行情報',
            'type' => '種類',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => '口座名義人',
            'owner-address' => '口座名義人の住所',
            'owner-city' => '口座名義人の市区町村',
            'owner-region' => '口座名義人の地域',
            'owner-postal-code' => '口座名義人の郵便番号',
            'country' => '国',
            'account-number' => '口座番号',
            'sortcode' => 'ソートコード',
            'aba' => 'ABA',
            'bank-name' => '銀行名',
            'institution-number' => '金融機関番号',
            'branch-code' => '支店コード',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => '種類',
            'file' => 'ファイル',
            'status' => 'ステータス',
            'id' => 'ID',
            'created-at' => '作成日',
        ],

        'wallet' => [
            'module-name' => 'MangoPay管理者ウォレット認証情報',
            'wallet-id' => 'ウォレットID',
            'mangopay-id' => 'MangoPay ID',
            'create-wallet' => 'ウォレット作成',
        ],

        'transaction' => [
            'module-name' => 'MangoPay取引',
            'transaction-id' => '取引ID',
            'amount' => '金額',
            'message' => 'メッセージ',
            'status' => 'ステータス',
            'id' => 'ID',
            'success' => '成功',
            'failed' => '失敗',
        ],

        'amount' => [
            'module-name' => 'エスクロー金額管理',
        ],

        'datagrid' => [
            'order-id' => '注文ID',
            'wallet-id' => 'ウォレットID',
            'escrowed-amount' => 'エスクロー金額',
            'created-at' => '作成日',
            'transaction-id' => '取引ID',
            'amount' => '金額',
            'message' => 'メッセージ',
            'status' => 'ステータス',
            'pay' => '支払う',
            'release-amount' => '金額を解放',
            'released' => '解放済み',
            'pending' => '保留中',
        ],

        'response' => [
            'wallet-not-found' => 'ウォレットが見つかりません。先にウォレットを作成してください。',
            'wallet-create-success' => 'ウォレットと MangoPay ID が正常に作成されました。',
            'bank-details-create-success' => '銀行口座情報が正常に保存されました。',
            'amount-release-success' => 'エスクロー金額が正常に解放されました。',
            'escrow-not-found' => 'エスクローの記録が見つかりません。',
            'already-released' => 'このエスクロー金額はすでにリリースされています。',
            'buyer-wallet-not-found' => '購入者のウォレットが見つかりません。',
            'admin-wallet-not-found' => '管理者のウォレットが見つかりません。',
            'unsupported-bank-type' => 'サポートされていない銀行口座の種類です: :type',
            'request-in-progress' => 'この注文に対する別のリクエストを処理中です。しばらくしてから再度お試しください。',
            'wallet-exists' => 'ストアには既に MangoPay ウォレットがあります。置き換えられることはありません。',
            'insufficient-escrow' => 'エスクロー金額がこの注文の販売者への支払いを賄えません。',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => '製品名',
            'qty-ordered' => '注文数量',
            'qty-to-refund' => '返金数量',
            'update-qty' => '数量を更新',
            'refund-summary' => '返金の概要',
            'refund-shipping' => '送料を返金',
            'adjustment-refund' => '調整返金',
            'adjustment-fee' => '調整手数料',
            'subtotal' => '小計',
            'tax' => '税金',
            'discount' => '割引',
            'grand-total' => '総合計',
        ],
    ],
];
