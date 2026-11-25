<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.sales.refunds.create.title')
    </x-slot>

    <v-mangopay-refund></v-mangopay-refund>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-mangopay-refund-template"
        >
            <x-admin::form :action="route('admin.mangopay.refund.store', $order->id)">
                <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                    <div class="flex items-center gap-2.5">
                        <a
                            href="{{ route('admin.sales.orders.view', $order->id) }}"
                            class="icon-arrow-left rtl:icon-arrow-right text-2xl"
                        ></a>

                        <p class="py-3 text-xl font-bold text-gray-800 dark:text-white">
                            @lang('admin::app.sales.refunds.create.title') #{{ $order->increment_id }}
                        </p>
                    </div>

                    <div class="flex items-center gap-x-2.5">
                        <button
                            type="submit"
                            class="primary-button"
                        >
                            @lang('mangopay::app.admin.mangopay.save-btn-title')
                        </button>
                    </div>
                </div>

                <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
                    <!-- Refund Items -->
                    <div class="flex flex-1 flex-col gap-2 overflow-auto rounded-sm box-shadow bg-white p-4 dark:bg-gray-900">
                        <x-admin::table>
                            <x-admin::table.thead>
                                <x-admin::table.thead.tr>
                                    <x-admin::table.th>@lang('mangopay::app.admin.refunds.sku')</x-admin::table.th>
                                    <x-admin::table.th>@lang('mangopay::app.admin.refunds.product-name')</x-admin::table.th>
                                    <x-admin::table.th>@lang('mangopay::app.admin.refunds.qty-ordered')</x-admin::table.th>
                                    <x-admin::table.th>@lang('mangopay::app.admin.refunds.qty-to-refund')</x-admin::table.th>
                                </x-admin::table.thead.tr>
                            </x-admin::table.thead>

                            <x-admin::table.tbody>
                                @foreach ($order->items as $item)
                                    <x-admin::table.tbody.tr>
                                        <x-admin::table.td>
                                            {{ $item->getTypeInstance()->getOrderedItem($item)->sku ?? $item->sku }}
                                        </x-admin::table.td>

                                        <x-admin::table.td>{{ $item->name }}</x-admin::table.td>

                                        <x-admin::table.td>{{ $item->qty_ordered }}</x-admin::table.td>

                                        <x-admin::table.td>
                                            <x-admin::form.control-group class="mb-0! w-24">
                                                <x-admin::form.control-group.control
                                                    type="text"
                                                    name="refund[items][{{ $item->id }}]"
                                                    rules="required|numeric|min:0"
                                                    v-model="refund.items[{{ $item->id }}]"
                                                    :label="trans('mangopay::app.admin.refunds.qty-to-refund')"
                                                />

                                                <x-admin::form.control-group.error control-name="refund[items][{{ $item->id }}]" />
                                            </x-admin::form.control-group>
                                        </x-admin::table.td>
                                    </x-admin::table.tbody.tr>
                                @endforeach
                            </x-admin::table.tbody>
                        </x-admin::table>

                        <div class="flex justify-end">
                            <div
                                class="secondary-button"
                                @click="updateTotals"
                            >
                                @lang('mangopay::app.admin.refunds.update-qty')
                            </div>
                        </div>
                    </div>

                    <!-- Refund Summary -->
                    <div class="flex w-[360px] max-w-full flex-col gap-2 rounded-sm box-shadow bg-white p-4 dark:bg-gray-900 max-lg:w-full">
                        <p class="text-base font-semibold text-gray-800 dark:text-white">
                            @lang('mangopay::app.admin.refunds.refund-summary')
                        </p>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                @lang('mangopay::app.admin.refunds.refund-shipping')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="refund[shipping]"
                                rules="required|numeric|min:0"
                                v-model="refund.shipping"
                                :label="trans('mangopay::app.admin.refunds.refund-shipping')"
                            />

                            <x-admin::form.control-group.error control-name="refund[shipping]" />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                @lang('mangopay::app.admin.refunds.adjustment-refund')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="refund[adjustment_refund]"
                                rules="required|numeric|min:0"
                                v-model="refund.adjustment_refund"
                                :label="trans('mangopay::app.admin.refunds.adjustment-refund')"
                            />

                            <x-admin::form.control-group.error control-name="refund[adjustment_refund]" />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                @lang('mangopay::app.admin.refunds.adjustment-fee')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="refund[adjustment_fee]"
                                rules="required|numeric|min:0"
                                v-model="refund.adjustment_fee"
                                :label="trans('mangopay::app.admin.refunds.adjustment-fee')"
                            />

                            <x-admin::form.control-group.error control-name="refund[adjustment_fee]" />
                        </x-admin::form.control-group>

                        <template v-if="totals">
                            <div class="flex justify-between border-t pt-2 text-sm text-gray-600 dark:text-gray-300">
                                <span>@lang('mangopay::app.admin.refunds.subtotal')</span>
                                <span>@{{ totals.subtotal.formatted_price }}</span>
                            </div>

                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300">
                                <span>@lang('mangopay::app.admin.refunds.tax')</span>
                                <span>@{{ totals.tax.formatted_price }}</span>
                            </div>

                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300">
                                <span>@lang('mangopay::app.admin.refunds.discount')</span>
                                <span>@{{ totals.discount.formatted_price }}</span>
                            </div>

                            <div class="flex justify-between border-t pt-2 text-base font-semibold text-gray-800 dark:text-white">
                                <span>@lang('mangopay::app.admin.refunds.grand-total')</span>
                                <span>@{{ totals.grand_total.formatted_price }}</span>
                            </div>
                        </template>
                    </div>
                </div>
            </x-admin::form>
        </script>

        <script type="module">
            app.component('v-mangopay-refund', {
                template: '#v-mangopay-refund-template',

                data() {
                    return {
                        refund: {
                            items: {},

                            shipping: "{{ $order->base_shipping_invoiced - $order->base_shipping_refunded }}",

                            adjustment_refund: 0,

                            adjustment_fee: 0,
                        },

                        totals: null,
                    };
                },

                mounted() {
                    @foreach ($order->items as $item)
                        this.refund.items[{{ $item->id }}] = {{ $item->qty_to_refund }};
                    @endforeach

                    this.updateTotals();
                },

                methods: {
                    updateTotals() {
                        var self = this;

                        this.$axios.post("{{ route('admin.sales.refunds.update_totals', $order->id) }}", this.refund)
                            .then((response) => {
                                this.totals = response.data;
                            })
                            .catch((error) => {
                                self.$emitter.emit('add-flash', { type: 'warning', message: error.response?.data?.message });
                            });
                    },
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>
