<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'ستتم إعادة توجيهك إلى موقع MangoPay خلال بضع ثوان.',
            'redirect-button' => 'انقر هنا إذا لم تتم إعادة توجيهك خلال 10 ثوان...',
            'unavailable' => 'طريقة الدفع MangoPay غير متاحة حاليًا. يرجى اختيار طريقة دفع أخرى أو التواصل مع المسؤول.',
            'canceled' => 'تم إلغاء الدفع عبر MangoPay.',
            'cart-not-found' => 'لم يتم العثور على سلة MangoPay. يرجى محاولة تقديم الطلب مرة أخرى.',
            'wallet-not-found' => 'لم يتم العثور على محفظة MangoPay لهذا الطلب.',
            'payment-not-confirmed' => 'تعذر تأكيد دفعتك عبر MangoPay، لذلك لم يتم إنشاء أي طلب.',
            'payment-refunded' => 'تم خصم المبلغ من بطاقتك لكن تعذر إنشاء الطلب، لذلك تم استرداد الدفعة.',
        ],

        'mangopay' => [
            'not-a-seller' => 'إعدادات الدفع في MangoPay متاحة للبائعين فقط.',

            'bank-details' => [
                'title' => 'تفاصيل البنك',
                'save-btn' => 'حفظ التفاصيل المصرفية',
                'save-success' => 'تم حفظ التفاصيل المصرفية بنجاح.',
            ],

            'kyc' => [
                'title' => 'مستندات اعرف عميلك',
                'create-title' => 'إضافة مستند KYC',
                'create-btn' => 'إضافة مستند',
                'save-btn' => 'رفع المستند',
                'save-success' => 'تم رفع مستند KYC بنجاح.',
                'bank-required' => 'يرجى إرسال تفاصيلك المصرفية قبل رفع مستندات KYC.',
                'type' => 'نوع المستند',
                'file' => 'ملف المستند',

                'types' => [
                    'identity-proof' => 'إثبات الهوية',
                    'registration-proof' => 'إثبات التسجيل',
                    'articles-of-association' => 'عقد التأسيس',
                    'shareholder-declaration' => 'إقرار المساهمين',
                    'address-proof' => 'إثبات العنوان',
                ],
            ],

            'transactions' => [
                'title' => 'العمليات',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'حفظ',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'عام',
                'description' => 'الوصف',
                'title' => 'العنوان',
                'enable' => 'تمكين',
                'sandbox' => 'بيئة الاختبار',
                'status' => 'الحالة',
                'sort-order' => 'ترتيب الفرز',
                'client-id' => 'معرّف العميل',
                'passphrase' => 'عبارة المرور',
                'logo' => 'الشعار',
                'logo-information' => 'يجب أن تكون دقة الصورة 55 بكسل × 45 بكسل',
                'production-mode-info' => 'للوضع الإنتاجي، قم بتعطيل بيئة الاختبار.',
                'info' => 'إعدادات بوابة الدفع MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'معرّف Mangopay',
            'wallet-id' => 'معرّف المحفظة',
            'no-of-days' => 'حدد عدد الأيام التي يمكن بعدها للمشرف تحرير المبلغ المحتجز',
            'mangopay-refund' => 'استرداد MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'تفاصيل بنك MangoPay',
            'type' => 'النوع',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'اسم المالك',
            'owner-address' => 'عنوان المالك',
            'owner-city' => 'مدينة المالك',
            'owner-region' => 'منطقة المالك',
            'owner-postal-code' => 'الرمز البريدي للمالك',
            'country' => 'الدولة',
            'account-number' => 'رقم الحساب',
            'sortcode' => 'رمز الفرع',
            'aba' => 'ABA',
            'bank-name' => 'اسم البنك',
            'institution-number' => 'رقم المؤسسة',
            'branch-code' => 'رمز الفرع',
        ],

        'kyc' => [
            'module-name' => 'التحقق من الهوية MangoPay (KYC)',
            'type' => 'النوع',
            'file' => 'الملف',
            'status' => 'الحالة',
            'id' => 'المعرّف',
            'created-at' => 'تاريخ الإنشاء',
        ],

        'wallet' => [
            'module-name' => 'بيانات اعتماد محفظة MangoPay للمشرف',
            'wallet-id' => 'معرّف المحفظة',
            'mangopay-id' => 'معرّف MangoPay',
            'create-wallet' => 'إنشاء محفظة',
        ],

        'transaction' => [
            'module-name' => 'معاملة MangoPay',
            'transaction-id' => 'معرّف المعاملة',
            'amount' => 'المبلغ',
            'message' => 'الرسالة',
            'status' => 'الحالة',
            'id' => 'المعرّف',
            'success' => 'نجحت',
            'failed' => 'فشلت',
        ],

        'amount' => [
            'module-name' => 'إدارة المبلغ المحتجز',
        ],

        'datagrid' => [
            'order-id' => 'معرّف الطلب',
            'wallet-id' => 'معرّف المحفظة',
            'escrowed-amount' => 'المبلغ المحتجز',
            'created-at' => 'تاريخ الإنشاء',
            'transaction-id' => 'معرّف المعاملة',
            'amount' => 'المبلغ',
            'message' => 'الرسالة',
            'status' => 'الحالة',
            'pay' => 'دفع',
            'release-amount' => 'تحرير المبلغ',
            'released' => 'تم التحرير',
            'pending' => 'قيد الانتظار',
        ],

        'response' => [
            'wallet-not-found' => 'لم يتم العثور على المحفظة. يرجى إنشاء محفظة أولا.',
            'wallet-create-success' => 'تم إنشاء المحفظة ومعرف MangoPay بنجاح.',
            'bank-details-create-success' => 'تم حفظ التفاصيل المصرفية بنجاح.',
            'amount-release-success' => 'تم تحرير المبلغ المحتجز بنجاح.',
            'escrow-not-found' => 'لم يتم العثور على سجل الضمان.',
            'already-released' => 'تم تحرير هذا المبلغ المحتجز بالفعل.',
            'buyer-wallet-not-found' => 'لم يتم العثور على محفظة المشتري.',
            'admin-wallet-not-found' => 'لم يتم العثور على محفظة المسؤول.',
            'unsupported-bank-type' => 'نوع الحساب المصرفي غير مدعوم: :type',
            'request-in-progress' => 'يوجد طلب آخر قيد المعالجة لهذا الطلب. يرجى المحاولة مرة أخرى بعد قليل.',
            'wallet-exists' => 'يمتلك المتجر محفظة MangoPay بالفعل؛ ولن يتم استبدالها.',
            'insufficient-escrow' => 'المبلغ المحتجز لا يغطي مستحقات البائعين لهذا الطلب.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'اسم المنتج',
            'qty-ordered' => 'الكمية المطلوبة',
            'qty-to-refund' => 'الكمية المراد استردادها',
            'update-qty' => 'تحديث الكمية',
            'refund-summary' => 'ملخص الاسترداد',
            'refund-shipping' => 'استرداد تكلفة الشحن',
            'adjustment-refund' => 'استرداد التعديل',
            'adjustment-fee' => 'رسوم التعديل',
            'subtotal' => 'المجموع الفرعي',
            'tax' => 'الضريبة',
            'discount' => 'الخصم',
            'grand-total' => 'الإجمالي الكلي',
        ],
    ],
];
