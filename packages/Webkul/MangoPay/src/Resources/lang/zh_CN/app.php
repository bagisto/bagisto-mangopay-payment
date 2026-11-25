<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => '您将在几秒钟后被重定向到 MangoPay 网站。',
            'redirect-button' => '如果 10 秒内未跳转，请点击此处...',
            'unavailable' => 'MangoPay 支付方式当前不可用。请选择其他支付方式或联系管理员。',
            'canceled' => 'MangoPay 支付已取消。',
            'cart-not-found' => '未找到 MangoPay 购物车。请重新尝试下单。',
            'wallet-not-found' => '未找到此订单的 MangoPay 钱包。',
            'payment-not-confirmed' => '无法确认您的 MangoPay 付款，因此未创建订单。',
            'payment-refunded' => '您的银行卡已被扣款，但订单无法创建，因此款项已退还。',
        ],

        'mangopay' => [
            'not-a-seller' => 'MangoPay 付款设置仅对卖家开放。',

            'bank-details' => [
                'title' => '银行详细信息',
                'save-btn' => '保存银行信息',
                'save-success' => '银行信息保存成功。',
            ],

            'kyc' => [
                'title' => 'KYC 文件',
                'create-title' => '添加 KYC 文件',
                'create-btn' => '添加文件',
                'save-btn' => '上传文件',
                'save-success' => 'KYC 文件上传成功。',
                'bank-required' => '请在上传 KYC 文件前提交您的银行信息。',
                'type' => '文件类型',
                'file' => '文件',

                'types' => [
                    'identity-proof' => '身份证明',
                    'registration-proof' => '注册证明',
                    'articles-of-association' => '公司章程',
                    'shareholder-declaration' => '股东声明',
                    'address-proof' => '地址证明',
                ],
            ],

            'transactions' => [
                'title' => '交易',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => '保存',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => '常规',
                'description' => '描述',
                'title' => '标题',
                'enable' => '启用',
                'sandbox' => '沙盒',
                'status' => '状态',
                'sort-order' => '排序顺序',
                'client-id' => '客户 ID',
                'passphrase' => '密码短语',
                'logo' => '徽标',
                'logo-information' => '图片分辨率应为 55px × 45px',
                'production-mode-info' => '在生产模式下请禁用沙盒模式。',
                'info' => 'MangoPay 支付网关设置',
            ],
        ],

        'system' => [
            'mangopay-id' => 'Mangopay ID',
            'wallet-id' => '钱包 ID',
            'no-of-days' => '设置管理员可以释放托管金额前需要等待的天数',
            'mangopay-refund' => 'MangoPay 退款',
        ],

        'bank-details' => [
            'module-name' => 'MangoPay 银行信息',
            'type' => '类型',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => '账户持有人姓名',
            'owner-address' => '账户持有人地址',
            'owner-city' => '账户持有人城市',
            'owner-region' => '账户持有人地区',
            'owner-postal-code' => '账户持有人邮政编码',
            'country' => '国家',
            'account-number' => '账号',
            'sortcode' => '银行代码',
            'aba' => 'ABA',
            'bank-name' => '银行名称',
            'institution-number' => '机构编号',
            'branch-code' => '分行代码',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => '类型',
            'file' => '文件',
            'status' => '状态',
            'id' => 'ID',
            'created-at' => '创建时间',
        ],

        'wallet' => [
            'module-name' => 'MangoPay 管理员钱包凭据',
            'wallet-id' => '钱包 ID',
            'mangopay-id' => 'MangoPay ID',
            'create-wallet' => '创建钱包',
        ],

        'transaction' => [
            'module-name' => 'MangoPay 交易',
            'transaction-id' => '交易 ID',
            'amount' => '金额',
            'message' => '消息',
            'status' => '状态',
            'id' => 'ID',
            'success' => '成功',
            'failed' => '失败',
        ],

        'amount' => [
            'module-name' => '管理托管金额',
        ],

        'datagrid' => [
            'order-id' => '订单 ID',
            'wallet-id' => '钱包 ID',
            'escrowed-amount' => '托管金额',
            'created-at' => '创建时间',
            'transaction-id' => '交易 ID',
            'amount' => '金额',
            'message' => '消息',
            'status' => '状态',
            'pay' => '支付',
            'release-amount' => '释放金额',
            'released' => '已释放',
            'pending' => '待处理',
        ],

        'response' => [
            'wallet-not-found' => '未找到钱包。请先创建钱包。',
            'wallet-create-success' => '钱包和 MangoPay ID 创建成功。',
            'bank-details-create-success' => '银行信息保存成功。',
            'amount-release-success' => '托管金额已成功释放。',
            'escrow-not-found' => '未找到托管记录。',
            'already-released' => '此托管金额已被释放。',
            'buyer-wallet-not-found' => '未找到买家钱包。',
            'admin-wallet-not-found' => '未找到管理员钱包。',
            'unsupported-bank-type' => '不支持的银行账户类型：:type',
            'request-in-progress' => '此订单的另一个请求正在处理中，请稍后重试。',
            'wallet-exists' => '商店已有一个 MangoPay 钱包，不会被替换。',
            'insufficient-escrow' => '托管金额不足以支付此订单的卖家款项。',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => '产品名称',
            'qty-ordered' => '订购数量',
            'qty-to-refund' => '待退款数量',
            'update-qty' => '更新数量',
            'refund-summary' => '退款摘要',
            'refund-shipping' => '退款运费',
            'adjustment-refund' => '调整退款',
            'adjustment-fee' => '调整费用',
            'subtotal' => '小计',
            'tax' => '税费',
            'discount' => '折扣',
            'grand-total' => '总计',
        ],
    ],
];
