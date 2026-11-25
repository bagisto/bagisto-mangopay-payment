<x-admin::layouts>
    <x-slot:title>
        @lang('mangopay::app.admin.bank-details.module-name')
    </x-slot>

    <x-admin::form :action="route('admin.mangopay.save_bank_details.store')">
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="py-3 text-xl font-bold text-gray-800 dark:text-white">
                @lang('mangopay::app.admin.bank-details.module-name')
            </p>

            <div class="flex items-center gap-x-2.5">
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('mangopay::app.admin.mangopay.save-btn-title')
                </button>
            </div>
        </div>

        <div class="mt-3.5 box-shadow rounded-sm bg-white p-4 dark:bg-gray-900">
            <v-mangopay-bank-details></v-mangopay-bank-details>
        </div>
    </x-admin::form>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-mangopay-bank-details-template"
        >
            <div class="grid gap-2.5">
                <!-- Bank Account Type -->
                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">
                        @lang('mangopay::app.admin.bank-details.type')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control
                        type="select"
                        name="type"
                        rules="required"
                        v-model="selectedType"
                        :label="trans('mangopay::app.admin.bank-details.type')"
                    >
                        <option value="IBAN">IBAN</option>
                        <option value="GB">GB</option>
                        <option value="US">US</option>
                        <option value="CA">CA</option>
                        <option value="OTHER">OTHER</option>
                    </x-admin::form.control-group.control>
                </x-admin::form.control-group>

                <!-- IBAN -->
                <template v-if="selectedType === 'IBAN'">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.iban')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="iban" :value="$bankdetail?->iban" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.bic')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="bic" :value="$bankdetail?->bic" />
                    </x-admin::form.control-group>
                </template>

                <!-- GB -->
                <template v-if="selectedType === 'GB'">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.account-number')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="account_number" :value="$bankdetail?->account_number" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.sortcode')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="sortcode" :value="$bankdetail?->sortcode" />
                    </x-admin::form.control-group>
                </template>

                <!-- US -->
                <template v-if="selectedType === 'US'">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.account-number')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="account_number" :value="$bankdetail?->account_number" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.aba')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="aba" :value="$bankdetail?->aba" />
                    </x-admin::form.control-group>
                </template>

                <!-- CA -->
                <template v-if="selectedType === 'CA'">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.bank-name')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="bank_name" :value="$bankdetail?->bank_name" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.institution-number')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="institution_number" :value="$bankdetail?->institution_number" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.branch-code')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="branch_code" :value="$bankdetail?->branch_code" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.account-number')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="account_number" :value="$bankdetail?->account_number" />
                    </x-admin::form.control-group>
                </template>

                <!-- OTHER -->
                <template v-if="selectedType === 'OTHER'">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.account-number')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="account_number" :value="$bankdetail?->account_number" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('mangopay::app.admin.bank-details.bic')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="bic" :value="$bankdetail?->bic" />
                    </x-admin::form.control-group>
                </template>

                <!-- Owner Details -->
                <x-admin::form.control-group>
                    <x-admin::form.control-group.label>
                        @lang('mangopay::app.admin.bank-details.owner-name')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control type="text" name="owner_name" :value="$bankdetail?->owner_name" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label>
                        @lang('mangopay::app.admin.bank-details.owner-address')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control type="text" name="owner_address" :value="$bankdetail?->owner_address" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label>
                        @lang('mangopay::app.admin.bank-details.owner-city')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control type="text" name="owner_city" :value="$bankdetail?->owner_city" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label>
                        @lang('mangopay::app.admin.bank-details.owner-region')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control type="text" name="owner_region" :value="$bankdetail?->owner_region" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label>
                        @lang('mangopay::app.admin.bank-details.owner-postal-code')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control type="text" name="owner_postal_code" :value="$bankdetail?->owner_postal_code" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label>
                        @lang('mangopay::app.admin.bank-details.country')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control
                        type="select"
                        name="country"
                        :label="trans('mangopay::app.admin.bank-details.country')"
                    >
                        @foreach (core()->countries() as $country)
                            <option value="{{ $country->code }}" {{ $bankdetail?->country === $country->code ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </x-admin::form.control-group.control>
                </x-admin::form.control-group>
            </div>
        </script>

        <script type="module">
            app.component('v-mangopay-bank-details', {
                template: '#v-mangopay-bank-details-template',

                data() {
                    return {
                        selectedType: @json($bankdetail?->type ?? 'IBAN'),
                    };
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>
