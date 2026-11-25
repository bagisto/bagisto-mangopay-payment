<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Через несколько секунд вы будете перенаправлены на сайт MangoPay.',
            'redirect-button' => 'Нажмите здесь, если перенаправление не произошло в течение 10 секунд...',
            'unavailable' => 'Способ оплаты MangoPay сейчас недоступен. Выберите другой способ оплаты или обратитесь к администратору.',
            'canceled' => 'Платёж MangoPay отменён.',
            'cart-not-found' => 'Корзина MangoPay не найдена. Попробуйте оформить заказ ещё раз.',
            'wallet-not-found' => 'Кошелёк MangoPay для этого заказа не найден.',
            'payment-not-confirmed' => 'Не удалось подтвердить ваш платёж MangoPay, поэтому заказ не был оформлен.',
            'payment-refunded' => 'С вашей карты списаны средства, но заказ не удалось оформить, поэтому платёж возвращён.',
        ],

        'mangopay' => [
            'not-a-seller' => 'Настройки выплат MangoPay доступны только продавцам.',

            'bank-details' => [
                'title' => 'Банковские реквизиты',
                'save-btn' => 'Сохранить банковские реквизиты',
                'save-success' => 'Банковские реквизиты успешно сохранены.',
            ],

            'kyc' => [
                'title' => 'Документы KYC',
                'create-title' => 'Добавить документ KYC',
                'create-btn' => 'Добавить документ',
                'save-btn' => 'Загрузить документ',
                'save-success' => 'Документ KYC успешно загружен.',
                'bank-required' => 'Пожалуйста, отправьте банковские реквизиты перед загрузкой документов KYC.',
                'type' => 'Тип документа',
                'file' => 'Файл документа',

                'types' => [
                    'identity-proof' => 'Подтверждение личности',
                    'registration-proof' => 'Свидетельство о регистрации',
                    'articles-of-association' => 'Устав организации',
                    'shareholder-declaration' => 'Заявление акционеров',
                    'address-proof' => 'Подтверждение адреса',
                ],
            ],

            'transactions' => [
                'title' => 'Транзакции',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Сохранить',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'Общие',
                'description' => 'Описание',
                'title' => 'Название',
                'enable' => 'Включить',
                'sandbox' => 'Песочница',
                'status' => 'Статус',
                'sort-order' => 'Порядок сортировки',
                'client-id' => 'ID клиента',
                'passphrase' => 'Парольная фраза',
                'logo' => 'Логотип',
                'logo-information' => 'Разрешение изображения должно быть 55px × 45px',
                'production-mode-info' => 'Для рабочего режима отключите песочницу.',
                'info' => 'Настройки платёжного шлюза MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'ID Mangopay',
            'wallet-id' => 'ID кошелька',
            'no-of-days' => 'Укажите количество дней, после которых администратор сможет освободить удерживаемую сумму',
            'mangopay-refund' => 'Возврат MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'Банковские реквизиты MangoPay',
            'type' => 'Тип',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Имя владельца',
            'owner-address' => 'Адрес владельца',
            'owner-city' => 'Город владельца',
            'owner-region' => 'Регион владельца',
            'owner-postal-code' => 'Почтовый индекс владельца',
            'country' => 'Страна',
            'account-number' => 'Номер счета',
            'sortcode' => 'Код банка',
            'aba' => 'ABA',
            'bank-name' => 'Название банка',
            'institution-number' => 'Номер учреждения',
            'branch-code' => 'Код филиала',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => 'Тип',
            'file' => 'Файл',
            'status' => 'Статус',
            'id' => 'ID',
            'created-at' => 'Дата создания',
        ],

        'wallet' => [
            'module-name' => 'Данные кошелька администратора MangoPay',
            'wallet-id' => 'ID кошелька',
            'mangopay-id' => 'ID MangoPay',
            'create-wallet' => 'Создать кошелек',
        ],

        'transaction' => [
            'module-name' => 'Транзакция MangoPay',
            'transaction-id' => 'ID транзакции',
            'amount' => 'Сумма',
            'message' => 'Сообщение',
            'status' => 'Статус',
            'id' => 'ID',
            'success' => 'Успешно',
            'failed' => 'Неудачно',
        ],

        'amount' => [
            'module-name' => 'Управление средствами условного депонирования',
        ],

        'datagrid' => [
            'order-id' => 'ID заказа',
            'wallet-id' => 'ID кошелька',
            'escrowed-amount' => 'Сумма условного депонирования',
            'created-at' => 'Дата создания',
            'transaction-id' => 'ID транзакции',
            'amount' => 'Сумма',
            'message' => 'Сообщение',
            'status' => 'Статус',
            'pay' => 'Оплатить',
            'release-amount' => 'Освободить сумму',
            'released' => 'Перечислено',
            'pending' => 'В ожидании',
        ],

        'response' => [
            'wallet-not-found' => 'Кошелек не найден. Сначала создайте кошелек.',
            'wallet-create-success' => 'Кошелек и идентификатор MangoPay успешно созданы.',
            'bank-details-create-success' => 'Банковские реквизиты успешно сохранены.',
            'amount-release-success' => 'Депонированная сумма успешно перечислена.',
            'escrow-not-found' => 'Запись эскроу не найдена.',
            'already-released' => 'Эта сумма эскроу уже выплачена.',
            'buyer-wallet-not-found' => 'Кошелёк покупателя не найден.',
            'admin-wallet-not-found' => 'Кошелёк администратора не найден.',
            'unsupported-bank-type' => 'Неподдерживаемый тип банковского счёта: :type',
            'request-in-progress' => 'По этому заказу уже выполняется другой запрос. Пожалуйста, повторите попытку чуть позже.',
            'wallet-exists' => 'У магазина уже есть кошелёк MangoPay; он не заменяется.',
            'insufficient-escrow' => 'Сумма на эскроу не покрывает выплаты продавцам по этому заказу.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Название продукта',
            'qty-ordered' => 'Заказанное количество',
            'qty-to-refund' => 'Количество для возврата',
            'update-qty' => 'Обновить количество',
            'refund-summary' => 'Сводка по возврату',
            'refund-shipping' => 'Возврат стоимости доставки',
            'adjustment-refund' => 'Возврат корректировки',
            'adjustment-fee' => 'Комиссия за корректировку',
            'subtotal' => 'Подытог',
            'tax' => 'Налоги',
            'discount' => 'Скидка',
            'grand-total' => 'Общая сумма',
        ],
    ],
];
