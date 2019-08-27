require(['common/common', 'vendor/bootstrap/bootstrap-waitingfor', 'vendor/bootstrap/bootstrap.bundle', 'bootstrapTable', 'moment', 'Vue', 'vue!components/confirm', 'sbAdmin', 'jqueryEasing'], function (common, boostrapWaitingFor, bootstrapBundle, bootstrapTable, moment, Vue) {

    waitingDialog.show('Cargando...');

    Vue.config.debug = true;

    var vueApp = new Vue({
        el: '#myVueApp'
    });

    var entity_alias = 'auditoria';
    var route_alias  = 'audits';

    function operateFormatter(value, row, index) {

        var thumbs_icon;

        return [
            '<div class="btn-toolbar">',
            '<a href="#" class="btn btn-link btn-sm btn-edit" role="button" title="Editar ' + entity_alias + '"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>',
            '<a href="#" class="btn btn-link btn-sm btn-remove" role="button" title="Eliminar ' + entity_alias + '"><i class="fa fa-trash" aria-hidden="true"></i></a>',
            '</div>'
        ].join('');
    }

    var operateEvents = {
        'click .btn-edit': function (e, value, row, index) {
            e.preventDefault();
            window.location.href = Routing.generate(route_alias + '_edit', {slug: row.id});

        },
        'click .btn-remove': function (e, value, row, index) {
            e.preventDefault();
            vueApp.$refs.confirmModal.reset();
            vueApp.$refs.confirmModal.title = '¿Deseas eliminar a este ' + entity_alias + '?';
            vueApp.$refs.confirmModal.id = row.id;
            vueApp.$refs.confirmModal.name = row.name;
            vueApp.$refs.confirmModal.action = 'delete';
            vueApp.$refs.confirmModal.route_prefix = 'api_' + route_alias;
            vueApp.$refs.confirmModal.showModal();
        }
    };


    $('#table-container').bootstrapTable({
        url: Routing.generate('api_' + route_alias + '_get'),
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
            field: 'company.name',
            title: 'Empresa',
            sortable: true,
        }, {
            field: 'agent.name',
            title: 'Agente',
            sortable: true
        }, {
            field: 'candidate.name',
            title: 'Candidato',
            sortable: true
        }, {
            field: 'status.name',
            title: 'Estado',
            sortable: true
        }, {
            field: 'start_date',
            title: 'Fecha inicio',
            sortable: true,
            formatter: common.dateFormatter
        }, {
            field: 'end_date',
            title: 'Fecha fin',
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