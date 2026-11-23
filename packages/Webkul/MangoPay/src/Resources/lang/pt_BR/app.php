<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Você será redirecionado para o site da MangoPay em alguns segundos.',
            'redirect-button' => 'Clique aqui se não for redirecionado em 10 segundos...',
            'unavailable' => 'O método de pagamento MangoPay está indisponível no momento. Escolha outro método de pagamento ou entre em contato com o administrador.',
            'canceled' => 'O pagamento MangoPay foi cancelado.',
            'cart-not-found' => 'Carrinho MangoPay não encontrado. Tente fazer o pedido novamente.',
            'wallet-not-found' => 'Carteira MangoPay não encontrada para este pedido.',
            'payment-not-confirmed' => 'Não foi possível confirmar seu pagamento MangoPay, portanto nenhum pedido foi feito.',
            'payment-refunded' => 'Seu cartão foi cobrado, mas o pedido não pôde ser criado, por isso o pagamento foi reembolsado.',
        ],

        'mangopay' => [
            'not-a-seller' => 'As configurações de pagamento da MangoPay estão disponíveis apenas para vendedores.',

            'bank-details' => [
                'title' => 'Detalhes Bancários',
                'save-btn' => 'Salvar dados bancários',
                'save-success' => 'Dados bancários salvos com sucesso.',
            ],

            'kyc' => [
                'title' => 'Documentos KYC',
                'create-title' => 'Adicionar documento KYC',
                'create-btn' => 'Adicionar documento',
                'save-btn' => 'Enviar documento',
                'save-success' => 'Documento KYC enviado com sucesso.',
                'bank-required' => 'Envie seus dados bancários antes de enviar documentos KYC.',
                'type' => 'Tipo de documento',
                'file' => 'Arquivo do documento',

                'types' => [
                    'identity-proof' => 'Comprovante de identidade',
                    'registration-proof' => 'Comprovante de registro',
                    'articles-of-association' => 'Contrato social',
                    'shareholder-declaration' => 'Declaração de acionistas',
                    'address-proof' => 'Comprovante de endereço',
                ],
            ],

            'transactions' => [
                'title' => 'Transações',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Salvar',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'Geral',
                'description' => 'Descrição',
                'title' => 'Título',
                'enable' => 'Ativar',
                'sandbox' => 'Sandbox',
                'status' => 'Status',
                'sort-order' => 'Ordem de classificação',
                'client-id' => 'ID do Cliente',
                'passphrase' => 'Frase Secreta',
                'logo' => 'Logo',
                'logo-information' => 'A resolução da imagem deve ser 55px × 45px',
                'production-mode-info' => 'Para o modo de produção, desative o Sandbox.',
                'info' => 'Configurações do gateway de pagamento MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'ID do Mangopay',
            'wallet-id' => 'ID da Carteira',
            'no-of-days' => 'Defina o número de dias após os quais o administrador poderá liberar o valor retido',
            'mangopay-refund' => 'Reembolso MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'Dados Bancários MangoPay',
            'type' => 'Tipo',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Nome do Titular',
            'owner-address' => 'Endereço do Titular',
            'owner-city' => 'Cidade do Titular',
            'owner-region' => 'Região do Titular',
            'owner-postal-code' => 'Código Postal do Titular',
            'country' => 'País',
            'account-number' => 'Número da Conta',
            'sortcode' => 'Código Bancário',
            'aba' => 'ABA',
            'bank-name' => 'Nome do Banco',
            'institution-number' => 'Número da Instituição',
            'branch-code' => 'Código da Agência',
        ],

        'kyc' => [
            'module-name' => 'KYC MangoPay',
            'type' => 'Tipo',
            'file' => 'Arquivo',
            'status' => 'Status',
            'id' => 'ID',
            'created-at' => 'Criado em',
        ],

        'wallet' => [
            'module-name' => 'Credenciais da Carteira Administrativa MangoPay',
            'wallet-id' => 'ID da Carteira',
            'mangopay-id' => 'ID MangoPay',
            'create-wallet' => 'Criar Carteira',
        ],

        'transaction' => [
            'module-name' => 'Transação MangoPay',
            'transaction-id' => 'ID da Transação',
            'amount' => 'Valor',
            'message' => 'Mensagem',
            'status' => 'Status',
            'id' => 'ID',
            'success' => 'Sucesso',
            'failed' => 'Falhou',
        ],

        'amount' => [
            'module-name' => 'Gerenciar Valor em Custódia',
        ],

        'datagrid' => [
            'order-id' => 'ID do Pedido',
            'wallet-id' => 'ID da Carteira',
            'escrowed-amount' => 'Valor em Custódia',
            'created-at' => 'Criado em',
            'transaction-id' => 'ID da Transação',
            'amount' => 'Valor',
            'message' => 'Mensagem',
            'status' => 'Status',
            'pay' => 'Pagar',
            'release-amount' => 'Liberar Valor',
            'released' => 'Liberado',
            'pending' => 'Pendente',
        ],

        'response' => [
            'wallet-not-found' => 'Carteira não encontrada. Crie uma carteira primeiro.',
            'wallet-create-success' => 'Carteira e ID MangoPay criados com sucesso.',
            'bank-details-create-success' => 'Dados bancários salvos com sucesso.',
            'amount-release-success' => 'Valor retido liberado com sucesso.',
            'escrow-not-found' => 'Registro de custódia não encontrado.',
            'already-released' => 'Este valor em custódia já foi liberado.',
            'buyer-wallet-not-found' => 'Carteira do comprador não encontrada.',
            'admin-wallet-not-found' => 'Carteira do administrador não encontrada.',
            'unsupported-bank-type' => 'Tipo de conta bancária não suportado: :type',
            'request-in-progress' => 'Outra solicitação para este pedido está em andamento. Tente novamente em instantes.',
            'wallet-exists' => 'A loja já possui uma carteira MangoPay; ela não é substituída.',
            'insufficient-escrow' => 'O valor em custódia não cobre os repasses aos vendedores deste pedido.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Nome do Produto',
            'qty-ordered' => 'Quantidade pedida',
            'qty-to-refund' => 'Qtd Para Reembolso',
            'update-qty' => 'Atualizar quantidade',
            'refund-summary' => 'Resumo do reembolso',
            'refund-shipping' => 'Reembolso do Envio',
            'adjustment-refund' => 'Reembolso de Ajuste',
            'adjustment-fee' => 'Taxa de Ajuste',
            'subtotal' => 'Subtotal',
            'tax' => 'Impostos',
            'discount' => 'Desconto',
            'grand-total' => 'Total Geral',
        ],
    ],
];
