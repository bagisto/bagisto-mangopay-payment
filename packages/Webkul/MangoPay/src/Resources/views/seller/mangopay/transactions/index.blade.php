<x-marketplace::seller.layouts>
    <x-slot:title>
        @lang('mangopay::app.shop.mangopay.transactions.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-2xl font-medium">
            @lang('mangopay::app.shop.mangopay.transactions.title')
        </p>
    </div>

    <div class="mt-5">
        <x-marketplace::seller.datagrid :src="route('mangopay.shop.transactions')" />
    </div>
</x-marketplace::seller.layouts>
