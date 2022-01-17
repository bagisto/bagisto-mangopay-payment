<?php

namespace Webkul\MangoPay\Database\Seeders;

use  Webkul\Core\Models\CoreConfig;
use Illuminate\Database\Seeder;

class MangoPayConfiguration extends Seeder
{
    public function run()
    {
        CoreConfig::create([
            'code'         => 'mangopay.general.general.active',
            'value'        => '1',
            'channel_code' => 'default',
            'locale_code'  => 'en'
        ]);
        CoreConfig::create([
            'code'         => 'mangopay.general.general.active',
            'value'        => '1',
            'channel_code' => 'default',
            'locale_code'  => 'fr'
        ]);
        CoreConfig::create([
            'code'         => 'mangopay.general.general.active',
            'value'        => '1',
            'channel_code' => 'default',
            'locale_code'  => 'nl'
        ]);
        CoreConfig::create([
            'code'         => 'mangopay.general.general.active',
            'value'        => '1',
            'channel_code' => 'default',
            'locale_code'  => 'tr'
        ]);
    }
}