<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Será redirigido al sitio web de MangoPay en unos segundos.',
            'redirect-button' => 'Haga clic aquí si no es redirigido en 10 segundos...',
            'unavailable' => 'El método de pago MangoPay no está disponible en este momento. Elija otro método de pago o contacte con el administrador.',
            'canceled' => 'Se ha cancelado el pago con MangoPay.',
            'cart-not-found' => 'No se encontró el carrito de MangoPay. Intente realizar el pedido de nuevo.',
            'wallet-not-found' => 'No se encontró la billetera de MangoPay para este pedido.',
            'payment-not-confirmed' => 'No se pudo confirmar su pago de MangoPay, por lo que no se realizó ningún pedido.',
            'payment-refunded' => 'Se realizó el cargo en su tarjeta pero no se pudo crear el pedido, por lo que el pago ha sido reembolsado.',
        ],

        'mangopay' => [
            'not-a-seller' => 'La configuración de pagos de MangoPay solo está disponible para vendedores.',

            'bank-details' => [
                'title' => 'Detalles Bancarios',
                'save-btn' => 'Guardar datos bancarios',
                'save-success' => 'Datos bancarios guardados correctamente.',
            ],

            'kyc' => [
                'title' => 'Documentos KYC',
                'create-title' => 'Añadir documento KYC',
                'create-btn' => 'Añadir documento',
                'save-btn' => 'Subir documento',
                'save-success' => 'Documento KYC subido correctamente.',
                'bank-required' => 'Por favor, envíe sus datos bancarios antes de subir documentos KYC.',
                'type' => 'Tipo de documento',
                'file' => 'Archivo del documento',

                'types' => [
                    'identity-proof' => 'Prueba de identidad',
                    'registration-proof' => 'Prueba de registro',
                    'articles-of-association' => 'Estatutos sociales',
                    'shareholder-declaration' => 'Declaración de accionistas',
                    'address-proof' => 'Prueba de domicilio',
                ],
            ],

            'transactions' => [
                'title' => 'Transacciones',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Guardar',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'General',
                'description' => 'Descripción',
                'title' => 'Título',
                'enable' => 'Habilitar',
                'sandbox' => 'Sandbox',
                'status' => 'Estado',
                'sort-order' => 'Orden de clasificación',
                'client-id' => 'ID de cliente',
                'passphrase' => 'Frase de contraseña',
                'logo' => 'Logotipo',
                'logo-information' => 'La resolución de la imagen debe ser de 55px × 45px',
                'production-mode-info' => 'Para el modo de producción, desactive Sandbox.',
                'info' => 'Configuración de la pasarela de pago MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'ID de Mangopay',
            'wallet-id' => 'ID de billetera',
            'no-of-days' => 'Establezca el número de días después de los cuales el administrador puede liberar el importe retenido',
            'mangopay-refund' => 'Reembolso de MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'Detalles bancarios de MangoPay',
            'type' => 'Tipo',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Nombre del titular',
            'owner-address' => 'Dirección del titular',
            'owner-city' => 'Ciudad del titular',
            'owner-region' => 'Región del titular',
            'owner-postal-code' => 'Código postal del titular',
            'country' => 'País',
            'account-number' => 'Número de cuenta',
            'sortcode' => 'Código bancario',
            'aba' => 'ABA',
            'bank-name' => 'Nombre del banco',
            'institution-number' => 'Número de institución',
            'branch-code' => 'Código de sucursal',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => 'Tipo',
            'file' => 'Archivo',
            'status' => 'Estado',
            'id' => 'ID',
            'created-at' => 'Creado el',
        ],

        'wallet' => [
            'module-name' => 'Credenciales de billetera de administrador MangoPay',
            'wallet-id' => 'ID de billetera',
            'mangopay-id' => 'ID de MangoPay',
            'create-wallet' => 'Crear billetera',
        ],

        'transaction' => [
            'module-name' => 'Transacción MangoPay',
            'transaction-id' => 'ID de transacción',
            'amount' => 'Importe',
            'message' => 'Mensaje',
            'status' => 'Estado',
            'id' => 'ID',
            'success' => 'Correcta',
            'failed' => 'Fallida',
        ],

        'amount' => [
            'module-name' => 'Gestionar importe en depósito',
        ],

        'datagrid' => [
            'order-id' => 'ID de pedido',
            'wallet-id' => 'ID de billetera',
            'escrowed-amount' => 'Importe retenido',
            'created-at' => 'Creado el',
            'transaction-id' => 'ID de transacción',
            'amount' => 'Importe',
            'message' => 'Mensaje',
            'status' => 'Estado',
            'pay' => 'Pagar',
            'release-amount' => 'Liberar importe',
            'released' => 'Liberado',
            'pending' => 'Pendiente',
        ],

        'response' => [
            'wallet-not-found' => 'Monedero no encontrado. Por favor, cree primero un monedero.',
            'wallet-create-success' => 'Monedero e ID de MangoPay creados correctamente.',
            'bank-details-create-success' => 'Datos bancarios guardados correctamente.',
            'amount-release-success' => 'Importe retenido liberado correctamente.',
            'escrow-not-found' => 'No se encontró el registro de depósito.',
            'already-released' => 'Este importe en depósito ya ha sido liberado.',
            'buyer-wallet-not-found' => 'No se encontró la billetera del comprador.',
            'admin-wallet-not-found' => 'No se encontró la billetera del administrador.',
            'unsupported-bank-type' => 'Tipo de cuenta bancaria no admitido: :type',
            'request-in-progress' => 'Hay otra solicitud en curso para este pedido. Inténtelo de nuevo en breve.',
            'wallet-exists' => 'La tienda ya tiene una billetera de MangoPay; no se reemplaza.',
            'insufficient-escrow' => 'El importe en custodia no cubre los pagos a los vendedores de este pedido.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Nombre del producto',
            'qty-ordered' => 'Cantidad pedida',
            'qty-to-refund' => 'Cantidad a Reembolsar',
            'update-qty' => 'Actualizar cantidad',
            'refund-summary' => 'Resumen del reembolso',
            'refund-shipping' => 'Reembolso de Envío',
            'adjustment-refund' => 'Reembolso de Ajuste',
            'adjustment-fee' => 'Tarifa de Ajuste',
            'subtotal' => 'Subtotal',
            'tax' => 'Impuestos',
            'discount' => 'Descuento',
            'grand-total' => 'Total General',
        ],
    ],
];
