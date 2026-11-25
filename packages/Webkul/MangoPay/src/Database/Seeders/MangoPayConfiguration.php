<?php

namespace Webkul\MangoPay\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Locale;

class MangoPayConfiguration extends Seeder
{
    /**
     * Config code switched on by the seeder.
     */
    const CODE = 'sales.payment_methods.mangopay_standard.active';

    /**
     * Enable the payment method for every locale that has no value yet.
     */
    public function run(): void
    {
        $now = now();

        foreach (Locale::query()->pluck('code') as $locale) {
            $exists = DB::table('core_config')
                ->where('code', self::CODE)
                ->where('locale_code', $locale)
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('core_config')->insert([
                'code' => self::CODE,
                'value' => '1',
                'channel_code' => null,
                'locale_code' => $locale,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
