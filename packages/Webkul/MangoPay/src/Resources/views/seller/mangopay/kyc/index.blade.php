<x-marketplace::seller.layouts>
    <x-slot:title>
        @lang('mangopay::app.shop.mangopay.kyc.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-2xl font-medium">
            @lang('mangopay::app.shop.mangopay.kyc.title')
        </p>

        <a
            href="{{ route('mangopay.shop.kyc.create') }}"
            class="primary-button px-5 py-2.5"
        >
            @lang('mangopay::app.shop.mangopay.kyc.create-btn')
        </a>
    </div>

    <div class="mt-5">
        <x-marketplace::seller.datagrid :src="route('mangopay.shop.kyc')" />
    </div>
</x-marketplace::seller.layouts>
