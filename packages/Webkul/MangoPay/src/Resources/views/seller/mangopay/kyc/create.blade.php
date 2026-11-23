<x-marketplace::seller.layouts>
    <x-slot:title>
        @lang('mangopay::app.shop.mangopay.kyc.create-title')
    </x-slot>

    <x-marketplace::seller.form
        :action="route('mangopay.shop.kyc.store')"
        enctype="multipart/form-data"
    >
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-2xl font-medium">
                @lang('mangopay::app.shop.mangopay.kyc.create-title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <a
                    href="{{ route('mangopay.shop.kyc') }}"
                    class="transparent-button font-semibold"
                >
                    @lang('mangopay::app.admin.mangopay.save-btn-title')
                </a>

                <button
                    type="submit"
                    class="primary-button px-5 py-2.5"
                >
                    @lang('mangopay::app.shop.mangopay.kyc.save-btn')
                </button>
            </div>
        </div>

        <div class="mt-3.5 rounded-xl border bg-white p-5 dark:bg-[#1a1a2e] dark:border-gray-700">
            <div class="grid max-w-[595px] gap-4">
                <!-- Document Type -->
                <x-marketplace::seller.form.control-group>
                    <x-marketplace::seller.form.control-group.label class="required">
                        @lang('mangopay::app.shop.mangopay.kyc.type')
                    </x-marketplace::seller.form.control-group.label>

                    <x-marketplace::seller.form.control-group.control
                        type="select"
                        name="type"
                        rules="required"
                        :label="trans('mangopay::app.shop.mangopay.kyc.type')"
                    >
                        <option value="IDENTITY_PROOF">@lang('mangopay::app.shop.mangopay.kyc.types.identity-proof')</option>
                        <option value="REGISTRATION_PROOF">@lang('mangopay::app.shop.mangopay.kyc.types.registration-proof')</option>
                        <option value="ARTICLES_OF_ASSOCIATION">@lang('mangopay::app.shop.mangopay.kyc.types.articles-of-association')</option>
                        <option value="SHAREHOLDER_DECLARATION">@lang('mangopay::app.shop.mangopay.kyc.types.shareholder-declaration')</option>
                        <option value="ADDRESS_PROOF">@lang('mangopay::app.shop.mangopay.kyc.types.address-proof')</option>
                    </x-marketplace::seller.form.control-group.control>

                    <x-marketplace::seller.form.control-group.error control-name="type" />
                </x-marketplace::seller.form.control-group>

                <!-- Document File -->
                <x-marketplace::seller.form.control-group>
                    <x-marketplace::seller.form.control-group.label class="required">
                        @lang('mangopay::app.shop.mangopay.kyc.file')
                    </x-marketplace::seller.form.control-group.label>

                    <x-marketplace::seller.form.control-group.control
                        type="file"
                        name="file"
                        rules="required"
                        :label="trans('mangopay::app.shop.mangopay.kyc.file')"
                    />

                    <x-marketplace::seller.form.control-group.error control-name="file" />
                </x-marketplace::seller.form.control-group>
            </div>
        </div>
    </x-marketplace::seller.form>
</x-marketplace::seller.layouts>
