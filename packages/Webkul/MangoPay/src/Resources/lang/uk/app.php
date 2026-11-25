<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'За кілька секунд вас буде перенаправлено на сайт MangoPay.',
            'redirect-button' => 'Натисніть тут, якщо перенаправлення не відбулося протягом 10 секунд...',
            'unavailable' => 'Спосіб оплати MangoPay зараз недоступний. Виберіть інший спосіб оплати або зверніться до адміністратора.',
            'canceled' => 'Платіж MangoPay скасовано.',
            'cart-not-found' => 'Кошик MangoPay не знайдено. Спробуйте оформити замовлення ще раз.',
            'wallet-not-found' => 'Гаманець MangoPay для цього замовлення не знайдено.',
            'payment-not-confirmed' => 'Не вдалося підтвердити ваш платіж MangoPay, тому замовлення не було оформлено.',
            'payment-refunded' => 'З вашої картки списано кошти, але замовлення не вдалося оформити, тому платіж повернено.',
        ],

        'mangopay' => [
            'not-a-seller' => 'Налаштування виплат MangoPay доступні лише продавцям.',

            'bank-details' => [
                'title' => 'Банківські реквізити',
                'save-btn' => 'Зберегти банківські реквізити',
                'save-success' => 'Банківські реквізити успішно збережено.',
            ],

            'kyc' => [
                'title' => 'Документи KYC',
                'create-title' => 'Додати документ KYC',
                'create-btn' => 'Додати документ',
                'save-btn' => 'Завантажити документ',
                'save-success' => 'Документ KYC успішно завантажено.',
                'bank-required' => 'Будь ласка, надішліть банківські реквізити перед завантаженням документів KYC.',
                'type' => 'Тип документа',
                'file' => 'Файл документа',

                'types' => [
                    'identity-proof' => 'Підтвердження особи',
                    'registration-proof' => 'Свідоцтво про реєстрацію',
                    'articles-of-association' => 'Статут організації',
                    'shareholder-declaration' => 'Заява акціонерів',
                    'address-proof' => 'Підтвердження адреси',
                ],
            ],

            'transactions' => [
                'title' => 'Транзакції',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Зберегти',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'Загальні',
                'description' => 'Опис',
                'title' => 'Назва',
                'enable' => 'Увімкнути',
                'sandbox' => 'Пісочниця',
                'status' => 'Статус',
                'sort-order' => 'Порядок сортування',
                'client-id' => 'Ідентифікатор клієнта',
                'passphrase' => 'Парольна фраза',
                'logo' => 'Логотип',
                'logo-information' => 'Роздільна здатність зображення має бути 55px × 45px',
                'production-mode-info' => 'Для робочого режиму вимкніть пісочницю.',
                'info' => 'Налаштування платіжного шлюзу MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'Ідентифікатор Mangopay',
            'wallet-id' => 'Ідентифікатор гаманця',
            'no-of-days' => 'Вкажіть кількість днів, після яких адміністратор може звільнити утриману суму',
            'mangopay-refund' => 'Повернення MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'Банківські реквізити MangoPay',
            'type' => 'Тип',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Ім’я власника',
            'owner-address' => 'Адреса власника',
            'owner-city' => 'Місто власника',
            'owner-region' => 'Регіон власника',
            'owner-postal-code' => 'Поштовий індекс власника',
            'country' => 'Країна',
            'account-number' => 'Номер рахунку',
            'sortcode' => 'Банківський код',
            'aba' => 'ABA',
            'bank-name' => 'Назва банку',
            'institution-number' => 'Номер установи',
            'branch-code' => 'Код відділення',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => 'Тип',
            'file' => 'Файл',
            'status' => 'Статус',
            'id' => 'ID',
            'created-at' => 'Дата створення',
        ],

        'wallet' => [
            'module-name' => 'Облікові дані гаманця адміністратора MangoPay',
            'wallet-id' => 'Ідентифікатор гаманця',
            'mangopay-id' => 'Ідентифікатор MangoPay',
            'create-wallet' => 'Створити гаманець',
        ],

        'transaction' => [
            'module-name' => 'Транзакція MangoPay',
            'transaction-id' => 'Ідентифікатор транзакції',
            'amount' => 'Сума',
            'message' => 'Повідомлення',
            'status' => 'Статус',
            'id' => 'ID',
            'success' => 'Успішно',
            'failed' => 'Невдало',
        ],

        'amount' => [
            'module-name' => 'Керування сумою ескроу',
        ],

        'datagrid' => [
            'order-id' => 'Ідентифікатор замовлення',
            'wallet-id' => 'Ідентифікатор гаманця',
            'escrowed-amount' => 'Сума ескроу',
            'created-at' => 'Дата створення',
            'transaction-id' => 'Ідентифікатор транзакції',
            'amount' => 'Сума',
            'message' => 'Повідомлення',
            'status' => 'Статус',
            'pay' => 'Сплатити',
            'release-amount' => 'Звільнити суму',
            'released' => 'Перераховано',
            'pending' => 'В очікуванні',
        ],

        'response' => [
            'wallet-not-found' => 'Гаманець не знайдено. Спочатку створіть гаманець.',
            'wallet-create-success' => 'Гаманець та ідентифікатор MangoPay успішно створено.',
            'bank-details-create-success' => 'Банківські реквізити успішно збережено.',
            'amount-release-success' => 'Депоновану суму успішно перераховано.',
            'escrow-not-found' => 'Запис ескроу не знайдено.',
            'already-released' => 'Цю суму ескроу вже виплачено.',
            'buyer-wallet-not-found' => 'Гаманець покупця не знайдено.',
            'admin-wallet-not-found' => 'Гаманець адміністратора не знайдено.',
            'unsupported-bank-type' => 'Непідтримуваний тип банківського рахунку: :type',
            'request-in-progress' => 'Для цього замовлення вже виконується інший запит. Будь ласка, спробуйте ще раз трохи згодом.',
            'wallet-exists' => 'Магазин уже має гаманець MangoPay; його не буде замінено.',
            'insufficient-escrow' => 'Сума на ескроу не покриває виплати продавцям за цим замовленням.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Назва продукту',
            'qty-ordered' => 'Замовлена кількість',
            'qty-to-refund' => 'Кількість для повернення',
            'update-qty' => 'Оновити кількість',
            'refund-summary' => 'Підсумок повернення',
            'refund-shipping' => 'Повернення доставки',
            'adjustment-refund' => 'Виправлення повернення',
            'adjustment-fee' => 'Виправлення комісії',
            'subtotal' => 'Підсумок',
            'tax' => 'Податок',
            'discount' => 'Знижка',
            'grand-total' => 'Загальна сума',
        ],
    ],
];
