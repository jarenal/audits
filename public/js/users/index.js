require(['common/common', 'vendor/bootstrap/bootstrap-waitingfor', 'vendor/bootstrap/bootstrap.bundle', 'bootstrapTable', 'moment', 'Vue', 'vue!components/confirm', 'sbAdmin', 'jqueryEasing'], function (common, boostrapWaitingFor, bootstrapBundle, bootstrapTable, moment, Vue) {

    waitingDialog.show('Cargando...');

    Vue.config.debug = true;

    var vueApp = new Vue({
        el: '#myVueApp'
    });

    var entity_alias = 'usuario';
    var route_alias  = 'users';

    function operateFormatter(value, row, index) {

        var thumbs_icon;

        if (row.is_active) {
            thumbs_icon = 'fa-toggle-on';
            thumbs_title = 'Click para desactivar';
        } else {
            thumbs_icon = 'fa-toggle-off';
            thumbs_title = 'Click para activar';
        }
        return [
            '<div class="btn-toolbar">',
            '<a href="#" class="btn btn-link btn-sm btn-edit" role="button" title="Editar ' + entity_alias + '"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>',
            '<a href="#" class="btn btn-link btn-sm btn-enable" role="button" title="' + thumbs_title + '"><i class="fa ' + thumbs_icon + '" aria-hidden="true"></i></a>',
            '<a href="#" class="btn btn-link btn-sm btn-remove" role="button" title="Eliminar ' + entity_alias + '"><i class="fa fa-trash" aria-hidden="true"></i></a>',
            '</div>'
        ].join('');
    }

    var operateEvents = {
        'click .btn-edit': function (e, value, row, index) {
            e.preventDefault();
            window.location.href = Routing.generate(route_alias + '_edit', {slug: row.id, company_id: companyData.id});

        },
        'click .btn-remove': function (e, value, row, index) {
            e.preventDefault();
            vueApp.$refs.confirmModal.reset();
            vueApp.$refs.confirmModal.title = '¿Deseas eliminar a este ' + entity_alias + '?';
            vueApp.$refs.confirmModal.id = row.id;
            vueApp.$refs.confirmModal.name = row.name;
            vueApp.$refs.confirmModal.action = 'delete';
            vueApp.$refs.confirmModal.route_prefix = 'api_' + route_alias;
            vueApp.$refs.confirmModal.company_id = companyData.id;
            vueApp.$refs.confirmModal.showModal();
        },
        'click .btn-enable': function (e, value, row, index) {
            e.preventDefault();
            vueApp.$refs.confirmModal.reset();

            if (row.is_active) {
                vueApp.$refs.confirmModal.title = '¿Deseas deshabilitar a este ' + entity_alias + '?';
            } else {
                vueApp.$refs.confirmModal.title = '¿Deseas habilitar a este ' + entity_alias + '?';
            }

            vueApp.$refs.confirmModal.id = row.id;
            vueApp.$refs.confirmModal.name = row.name;
            vueApp.$refs.confirmModal.action = 'enabled';
            vueApp.$refs.confirmModal.route_prefix = 'api_' + route_alias;
            vueApp.$refs.confirmModal.company_id = companyData.id;
            vueApp.$refs.confirmModal.showModal();
        }
    };


    $('#table-container').bootstrapTable({
        url: Routing.generate('api_' + route_alias + '_get', {company_id: companyData.id}),
        method: 'get',
        cache: false,
        height: 'auto',
        striped: true,
        pagination: true,
        pageSize: 10,
        pageList: [10, 20, 50, 100, 200],
        search: true,
        showColumns: true,
        showRefresh: true,
        minimumCountColumns: 2,
        sortable: true,
        columns: [{
            field: 'id',
            title: 'ID',
            sortable: true
        }, {
            field: 'is_active',
            title: 'Activo',
            sortable: true,
            formatter: common.prettyStatus
        }, {
            field: 'name',
            title: 'Nombre',
            sortable: true,
        }, {
            field: 'phone',
            title: 'Teléfono',
            sortable: true
        }, {
            field: 'email',
            title: 'Email',
            sortable: true
        }, {
            field: 'created_at',
            title: 'Fecha creación',
            sortable: true,
            formatter: common.dateFormatter
        }, {
            field: 'operate',
            title: 'Acciones',
            align: 'center',
            valign: 'middle',
            clickToSelect: false,
            formatter: operateFormatter,
            events: operateEvents
        }],
        responseHandler: function (res) {
            return res.data;
        },
        onLoadSuccess: function () {
            console.log('onLoadSuccess');
            waitingDialog.hide();
        }
    });
});