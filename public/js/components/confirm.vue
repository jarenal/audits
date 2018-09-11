<template>
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{title}}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">{{name}}</div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" data-dismiss="modal">No</button>
                    <a class="btn btn-danger" href="#" v-on:click.prevent="save($event)">Si</a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    define(["Vue"], function(Vue) {
        Vue.component("confirm", {
            template: template,
            data: function () {
                return {
                    title: '',
                    name: '',
                    id: '',
                    route_prefix: '',
                    company_id: ''
                };
            },
            methods: {
                showModal: function () {
                    $(this.$el).modal('show');
                },
                reset: function () {
                    this.title = '';
                    this.fullname = '';
                    this.id = '';
                    this.route_prefix = '';
                    this.company_id = '';
                },
                save: function (event) {
                    event.stopPropagation();

                    let self = this;
                    let routeParameters = {};
                    routeParameters.slug = self.id;
                    if (this.company_id) {
                        routeParameters.company_id = self.company_id;
                    }

                    switch (this.action) {
                        case 'delete':
                            $.ajax({
                                url: Routing.generate(self.route_prefix + '_delete', routeParameters),
                                method: 'DELETE',
                                data: {},
                                cache: false,
                                error: function (jqXHR, textStatus, errorThrown) {
                                    // TODO Handle exception
                                },
                                success: function (response, textStatus, jqXHR) {
                                    $('#table-container').bootstrapTable('refresh');
                                    $(self.$el).modal('hide');
                                }
                            });
                            break;
                        case 'enabled':
                            let parameters = {};
                            parameters.op = 'toggle';
                            parameters.field = 'active';
                            parameters.value = '';

                            $.ajax({
                                url: Routing.generate(self.route_prefix + '_patch', routeParameters),
                                method: 'PATCH',
                                data: parameters,
                                cache: false,
                                error: function (jqXHR, textStatus, errorThrown) {
                                    // TODO Handle exception
                                },
                                success: function (response, textStatus, jqXHR) {
                                    $('#table-container').bootstrapTable('refresh');
                                    $(self.$el).modal('hide');
                                }
                            });
                            break;
                        default:
                            return false;
                            break;
                    }
                }
            }
        });
    });
</script>