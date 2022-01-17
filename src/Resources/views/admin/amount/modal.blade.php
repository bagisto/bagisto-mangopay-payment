<script type="text/x-template" id="box-form-template">
    <form method="POST" action="{{ route('admin.mangopay.release-amount') }}" @submit.prevent="onSubmit">

        <div class="page-content">
            <div class="form-container">
                @csrf()

                <input type="hidden" name="id" :value="escrowedId">
            
                <div class="control-group">
                    <textarea name="message" id="message" cols="30" rows="10"
                     class="control"  placeholder="Add a Notify Message....."  ></textarea>              
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-lg btn-primary">
            {{ __('mangopay::app.admin.datagrid.release-amount') }}
        </button>

    </form>
</script>

<script>
    Vue.component('box-form', {
        template: '#box-form-template',

        props:['id'],

        data: function() {
            return {
                escrowedId: 0
            }
        },

        mounted() {
            this.escrowedId = this.id.split('-')[1];
        },

        methods: {
            onSubmit: function(e) {
                var this_this = this;
                e.target.submit();

            }
        }
    });
</script>
