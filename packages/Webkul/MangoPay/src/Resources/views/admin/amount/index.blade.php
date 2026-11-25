<x-admin::layouts>
    <x-slot:title>
        @lang('mangopay::app.admin.amount.module-name')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="py-3 text-xl font-bold text-gray-800 dark:text-white">
            @lang('mangopay::app.admin.amount.module-name')
        </p>
    </div>

    <x-admin::datagrid :src="route('admin.mangopay.amount')" />
</x-admin::layouts>
