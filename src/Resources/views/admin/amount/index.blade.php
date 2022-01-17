@extends('marketplace::admin.layouts.content')

@section('page_title')
        {{ __('mangopay::app.admin.amount.module-name') }}
@stop

@section('content')

    <transaction-component></transaction-component>

@stop

@push('scripts')
    @include('mangopay::admin.amount.modal')

    <script type="text/x-template" id="transaction-component-template">
        <div>
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h1>
                            {{ __('mangopay::app.admin.amount.module-name') }}
                        </h1>
                    </div>
                </div>

                <div class="page-content">

                    @inject('escrowedAmountDataGrid', 'Webkul\MangoPay\DataGrids\Admin\EscrowedAmountDataGrid')
                    {!! $escrowedAmountDataGrid->render() !!}

                </div>
            </div>
          

            <modal-component :id="showDialogBox" :is-open="showDialogBox">
                <h3 slot="header">Add a Notify Message</h3>
                <div slot="body">
                    <box-form :id="showDialogBox"></box-form>
                </div>
            </modal-component>
        </div>
    </script>

    <script type="text/x-template" id="model-component-template">
        <div>
            <div class="modal-container" v-if="isModalOpen">
                <div class="modal-header">
                    <slot name="header">
                        Default header
                    </slot>
                    <i class="icon remove-icon" @click="closeModal"></i>
                </div>

                <div class="modal-body">
                    <slot name="body">
                        Default body
                    </slot>
                </div>
            </div>
        </div>
    </script>

    <script>
        Vue.component('transaction-component', {

            template: '#transaction-component-template',

            inject: ['$validator'],

            data: function () {
                return {
                    showDialogBox : "",
                }
            },

            mounted() {
                var this_this = this;
                $('.pay').click(function(){
                    this_this.showDialogBox= "showDialogBox-" + $(this).attr('data-id');
                })

                window.eventBus.$on('modalClose', (data) => {
                    this_this.showDialogBox = '';
                })
            },
        });

        Vue.component('modal-component', {

            props: ['id', 'isOpen'],

            template: '#model-component-template',

            inject: ['$validator'],

            computed: {
                isModalOpen () {
                    this.addClassToBody();

                    return this.isOpen;
                }
            },

            methods: {
                closeModal () {                  
                    this.isOpen = false;
                    this.id = '';
                    window.eventBus.$emit('modalClose',true);
                },

                addClassToBody () {
                    var body = document.querySelector("body");
                    if(this.isOpen) {
                        body.classList.add("modal-open");
                    } else {
                        body.classList.remove("modal-open");
                    }
                }
            },
        });

    </script>
@endpush