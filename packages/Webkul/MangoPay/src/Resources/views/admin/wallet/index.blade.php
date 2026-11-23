<x-admin::layouts>
    <x-slot:title>
        @lang('mangopay::app.admin.wallet.module-name')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="py-3 text-xl font-bold text-gray-800 dark:text-white">
            @lang('mangopay::app.admin.wallet.module-name')
        </p>

        @if (! $data)
            <div class="flex items-center gap-x-2.5">
                <form
                    method="POST"
                    action="{{ route('admin.mangopay.create_wallet') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="primary-button"
                    >
                        @lang('mangopay::app.admin.wallet.create-wallet')
                    </button>
                </form>
            </div>
        @endif
    </div>

    <div class="mt-3.5 box-shadow rounded-sm bg-white p-4 dark:bg-gray-900">
        <div class="grid gap-2.5">
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>
                    @lang('mangopay::app.admin.wallet.wallet-id')
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    name="wallet_id"
                    :value="$data?->wallet_id"
                    readonly
                />
            </x-admin::form.control-group>

            <x-admin::form.control-group>
                <x-admin::form.control-group.label>
                    @lang('mangopay::app.admin.wallet.mangopay-id')
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    name="mangopay_id"
                    :value="$data?->mangopay_id"
                    readonly
                />
            </x-admin::form.control-group>
        </div>
    </div>
</x-admin::layouts>
