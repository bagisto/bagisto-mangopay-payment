<x-marketplace::seller.layouts>
    <x-slot:title>
        @lang('mangopay::app.shop.mangopay.bank-details.title')
    </x-slot>

    <v-mangopay-seller-bank-details></v-mangopay-seller-bank-details>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-mangopay-seller-bank-details-template"
        >
            <x-marketplace::seller.form :action="route('mangopay.shop.bankdetails.store')">
                <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                    <p class="text-2xl font-medium">
                        @lang('mangopay::app.shop.mangopay.bank-details.title')
                    </p>

                    <button
                        type="submit"
                        class="primary-button px-5 py-2.5"
                    >
                        @lang('mangopay::app.shop.mangopay.bank-details.save-btn')
                    </button>
                </div>

                <div class="mt-3.5 rounded-xl border bg-white p-5 dark:bg-[#1a1a2e] dark:border-gray-700">
                    <div class="grid max-w-[595px] gap-4">
                        <!-- Bank Account Type -->
                        <x-marketplace::seller.form.control-group>
                            <x-marketplace::seller.form.control-group.label class="required">
                                @lang('mangopay::app.admin.bank-details.type')
                            </x-marketplace::seller.form.control-group.label>

                            <x-marketplace::seller.form.control-group.control
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
                            </x-marketplace::seller.form.control-group.control>

                            <x-marketplace::seller.form.control-group.error control-name="type" />
                        </x-marketplace::seller.form.control-group>

                        <!-- IBAN -->
                        <template v-if="selectedType === 'IBAN'">
                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.iban')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="iban" :value="$data?->iban" />
                            </x-marketplace::seller.form.control-group>

                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.bic')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="bic" :value="$data?->bic" />
                            </x-marketplace::seller.form.control-group>
                        </template>

                        <!-- GB -->
                        <template v-if="selectedType === 'GB'">
                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.account-number')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="account_number" :value="$data?->account_number" />
                            </x-marketplace::seller.form.control-group>

                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.sortcode')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="sortcode" :value="$data?->sortcode" />
                            </x-marketplace::seller.form.control-group>
                        </template>

                        <!-- US -->
                        <template v-if="selectedType === 'US'">
                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.account-number')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="account_number" :value="$data?->account_number" />
                            </x-marketplace::seller.form.control-group>

                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.aba')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="aba" :value="$data?->aba" />
                            </x-marketplace::seller.form.control-group>
                        </template>

                        <!-- CA -->
                        <template v-if="selectedType === 'CA'">
                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.bank-name')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="bank_name" :value="$data?->bank_name" />
                            </x-marketplace::seller.form.control-group>

                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.institution-number')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="institution_number" :value="$data?->institution_number" />
                            </x-marketplace::seller.form.control-group>

                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.branch-code')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="branch_code" :value="$data?->branch_code" />
                            </x-marketplace::seller.form.control-group>

                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.account-number')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="account_number" :value="$data?->account_number" />
                            </x-marketplace::seller.form.control-group>
                        </template>

                        <!-- OTHER -->
                        <template v-if="selectedType === 'OTHER'">
                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.account-number')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="account_number" :value="$data?->account_number" />
                            </x-marketplace::seller.form.control-group>

                            <x-marketplace::seller.form.control-group>
                                <x-marketplace::seller.form.control-group.label>
                                    @lang('mangopay::app.admin.bank-details.bic')
                                </x-marketplace::seller.form.control-group.label>

                                <x-marketplace::seller.form.control-group.control type="text" name="bic" :value="$data?->bic" />
                            </x-marketplace::seller.form.control-group>
                        </template>

                        <!-- Owner Details -->
                        <x-marketplace::seller.form.control-group>
                            <x-marketplace::seller.form.control-group.label>
                                @lang('mangopay::app.admin.bank-details.owner-name')
                            </x-marketplace::seller.form.control-group.label>

                            <x-marketplace::seller.form.control-group.control type="text" name="owner_name" :value="$data?->owner_name" />
                        </x-marketplace::seller.form.control-group>

                        <x-marketplace::seller.form.control-group>
                            <x-marketplace::seller.form.control-group.label>
                                @lang('mangopay::app.admin.bank-details.owner-address')
                            </x-marketplace::seller.form.control-group.label>

                            <x-marketplace::seller.form.control-group.control type="text" name="owner_address" :value="$data?->owner_address" />
                        </x-marketplace::seller.form.control-group>

                        <x-marketplace::seller.form.control-group>
                            <x-marketplace::seller.form.control-group.label>
                                @lang('mangopay::app.admin.bank-details.owner-city')
                            </x-marketplace::seller.form.control-group.label>

                            <x-marketplace::seller.form.control-group.control type="text" name="owner_city" :value="$data?->owner_city" />
                        </x-marketplace::seller.form.control-group>

                        <x-marketplace::seller.form.control-group>
                            <x-marketplace::seller.form.control-group.label>
                                @lang('mangopay::app.admin.bank-details.owner-region')
                            </x-marketplace::seller.form.control-group.label>

                            <x-marketplace::seller.form.control-group.control type="text" name="owner_region" :value="$data?->owner_region" />
                        </x-marketplace::seller.form.control-group>

                        <x-marketplace::seller.form.control-group>
                            <x-marketplace::seller.form.control-group.label>
                                @lang('mangopay::app.admin.bank-details.owner-postal-code')
                            </x-marketplace::seller.form.control-group.label>

                            <x-marketplace::seller.form.control-group.control type="text" name="owner_postal_code" :value="$data?->owner_postal_code" />
                        </x-marketplace::seller.form.control-group>

                        <x-marketplace::seller.form.control-group>
                            <x-marketplace::seller.form.control-group.label>
                                @lang('mangopay::app.admin.bank-details.country')
                            </x-marketplace::seller.form.control-group.label>

                            <x-marketplace::seller.form.control-group.control
                                type="select"
                                name="country"
                                :label="trans('mangopay::app.admin.bank-details.country')"
                            >
                                @foreach (core()->countries() as $country)
                                    <option value="{{ $country->code }}" {{ $data?->country === $country->code ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </x-marketplace::seller.form.control-group.control>
                        </x-marketplace::seller.form.control-group>
                    </div>
                </div>
            </x-marketplace::seller.form>
        </script>

        <script type="module">
            app.component('v-mangopay-seller-bank-details', {
                template: '#v-mangopay-seller-bank-details-template',

                data() {
                    return {
                        selectedType: @json($data?->type ?? 'IBAN'),
                    };
                },
            });
        </script>
    @endPushOnce
</x-marketplace::seller.layouts>
