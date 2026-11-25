<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'תופנה לאתר MangoPay בעוד מספר שניות.',
            'redirect-button' => 'לחץ כאן אם לא הופנית תוך 10 שניות...',
            'unavailable' => 'אמצעי התשלום MangoPay אינו זמין כרגע. אנא בחר אמצעי תשלום אחר או פנה למנהל המערכת.',
            'canceled' => 'התשלום ב-MangoPay בוטל.',
            'cart-not-found' => 'עגלת MangoPay לא נמצאה. אנא נסה לבצע את ההזמנה שוב.',
            'wallet-not-found' => 'ארנק MangoPay לא נמצא עבור הזמנה זו.',
            'payment-not-confirmed' => 'לא ניתן היה לאשר את התשלום שלך ב-MangoPay, ולכן לא בוצעה הזמנה.',
            'payment-refunded' => 'הכרטיס שלך חויב אך לא ניתן היה ליצור את ההזמנה, ולכן התשלום הוחזר.',
        ],

        'mangopay' => [
            'not-a-seller' => 'הגדרות התשלום של MangoPay זמינות למוכרים בלבד.',

            'bank-details' => [
                'title' => 'פרטי בנק',
                'save-btn' => 'שמור פרטי בנק',
                'save-success' => 'פרטי הבנק נשמרו בהצלחה.',
            ],

            'kyc' => [
                'title' => 'מסמכי KYC',
                'create-title' => 'הוסף מסמך KYC',
                'create-btn' => 'הוסף מסמך',
                'save-btn' => 'העלה מסמך',
                'save-success' => 'מסמך KYC הועלה בהצלחה.',
                'bank-required' => 'אנא שלח את פרטי הבנק שלך לפני העלאת מסמכי KYC.',
                'type' => 'סוג מסמך',
                'file' => 'קובץ מסמך',

                'types' => [
                    'identity-proof' => 'הוכחת זהות',
                    'registration-proof' => 'הוכחת רישום',
                    'articles-of-association' => 'תקנון החברה',
                    'shareholder-declaration' => 'הצהרת בעלי מניות',
                    'address-proof' => 'הוכחת כתובת',
                ],
            ],

            'transactions' => [
                'title' => 'עסקאות',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'שמור',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'כללי',
                'description' => 'תיאור',
                'title' => 'כותרת',
                'enable' => 'הפעל',
                'sandbox' => 'סביבת בדיקות',
                'status' => 'סטטוס',
                'sort-order' => 'סדר מיון',
                'client-id' => 'מזהה לקוח',
                'passphrase' => 'ביטוי סיסמה',
                'logo' => 'לוגו',
                'logo-information' => 'רזולוציית התמונה צריכה להיות 55px × 45px',
                'production-mode-info' => 'למצב ייצור יש להשבית את סביבת הבדיקות.',
                'info' => 'הגדרות שער התשלום MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'מזהה Mangopay',
            'wallet-id' => 'מזהה ארנק',
            'no-of-days' => 'הגדר את מספר הימים שלאחריהם המנהל יכול לשחרר את הסכום המוחזק',
            'mangopay-refund' => 'החזר MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'פרטי בנק MangoPay',
            'type' => 'סוג',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'שם בעל החשבון',
            'owner-address' => 'כתובת בעל החשבון',
            'owner-city' => 'עיר בעל החשבון',
            'owner-region' => 'אזור בעל החשבון',
            'owner-postal-code' => 'מיקוד בעל החשבון',
            'country' => 'מדינה',
            'account-number' => 'מספר חשבון',
            'sortcode' => 'קוד סניף',
            'aba' => 'ABA',
            'bank-name' => 'שם הבנק',
            'institution-number' => 'מספר מוסד',
            'branch-code' => 'קוד סניף',
        ],

        'kyc' => [
            'module-name' => 'אימות זהות MangoPay (KYC)',
            'type' => 'סוג',
            'file' => 'קובץ',
            'status' => 'סטטוס',
            'id' => 'מזהה',
            'created-at' => 'נוצר בתאריך',
        ],

        'wallet' => [
            'module-name' => 'פרטי ארנק מנהל MangoPay',
            'wallet-id' => 'מזהה ארנק',
            'mangopay-id' => 'מזהה MangoPay',
            'create-wallet' => 'צור ארנק',
        ],

        'transaction' => [
            'module-name' => 'עסקת MangoPay',
            'transaction-id' => 'מזהה עסקה',
            'amount' => 'סכום',
            'message' => 'הודעה',
            'status' => 'סטטוס',
            'id' => 'מזהה',
            'success' => 'הצליח',
            'failed' => 'נכשל',
        ],

        'amount' => [
            'module-name' => 'ניהול סכום בנאמנות',
        ],

        'datagrid' => [
            'order-id' => 'מזהה הזמנה',
            'wallet-id' => 'מזהה ארנק',
            'escrowed-amount' => 'סכום בנאמנות',
            'created-at' => 'נוצר בתאריך',
            'transaction-id' => 'מזהה עסקה',
            'amount' => 'סכום',
            'message' => 'הודעה',
            'status' => 'סטטוס',
            'pay' => 'שלם',
            'release-amount' => 'שחרור סכום',
            'released' => 'שוחרר',
            'pending' => 'ממתינה',
        ],

        'response' => [
            'wallet-not-found' => 'הארנק לא נמצא. אנא צור ארנק תחילה.',
            'wallet-create-success' => 'הארנק ומזהה MangoPay נוצרו בהצלחה.',
            'bank-details-create-success' => 'פרטי הבנק נשמרו בהצלחה.',
            'amount-release-success' => 'הסכום בנאמנות שוחרר בהצלחה.',
            'escrow-not-found' => 'רשומת הנאמנות לא נמצאה.',
            'already-released' => 'סכום הנאמנות הזה כבר שוחרר.',
            'buyer-wallet-not-found' => 'ארנק הקונה לא נמצא.',
            'admin-wallet-not-found' => 'ארנק המנהל לא נמצא.',
            'unsupported-bank-type' => 'סוג חשבון בנק לא נתמך: :type',
            'request-in-progress' => 'בקשה אחרת עבור הזמנה זו נמצאת בטיפול. נסה שוב בעוד רגע.',
            'wallet-exists' => 'לחנות כבר יש ארנק MangoPay; הוא אינו מוחלף.',
            'insufficient-escrow' => 'הסכום המוחזק בנאמנות אינו מכסה את התשלומים למוכרים של הזמנה זו.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'שם המוצר',
            'qty-ordered' => 'כמות שהוזמנה',
            'qty-to-refund' => 'כמות להחזר',
            'update-qty' => 'עדכן כמות',
            'refund-summary' => 'סיכום החזר',
            'refund-shipping' => 'החזר משלוח',
            'adjustment-refund' => 'החזר התאמה',
            'adjustment-fee' => 'עמלת התאמה',
            'subtotal' => 'סכום חלקי',
            'tax' => 'מס',
            'discount' => 'הנחה',
            'grand-total' => 'סכום כולל',
        ],
    ],
];
