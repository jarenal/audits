(function () {

    function operateFormatter(value, row, index) {

        var thumbs_icon;

        if (row.enabled) {
            thumbs_icon = 'fa-thumbs-up';
            thumbs_title = 'Click para desactivar';
        } else {
            thumbs_icon = 'fa-thumbs-down';
            thumbs_title = 'Click para activar';
        }
        return [
            '<div class="btn-toolbar">',
            '<a href="#" class="btn btn-link btn-sm btn-company-edit" role="button" title="Editar empresa"><i class="fa fa-pencil" aria-hidden="true"></i></a>',
            '<a href="#" class="btn btn-link btn-sm btn-company-enable" role="button" title="'+thumbs_title+'"><i class="fa '+thumbs_icon+'" aria-hidden="true"></i></a>',
            '<a href="#" class="btn btn-link btn-sm btn-company-remove" role="button" title="Eliminar empresa"><i class="fa fa-trash" aria-hidden="true"></i></a>',
            '<a href="#" class="btn btn-link btn-sm btn-company-users" role="button" title="Gestionar usuarios"><i class="fa fa-ban" aria-hidden="true"></i></a>',
            '</div>'
        ].join('');
    }

    window.operateEvents = {
        'click .btn-company-remove': function (e, value, row, index) {
            e.preventDefault();
            confirmModal.reset();
            confirmModal.title = '¿Deseas eliminar esta empresa?';
            confirmModal.id = row.id;
            confirmModal.name = row.name;
            confirmModal.action = 'delete';
            $('#confirmModal').modal('show');
        },
        'click .btn-company-enable': function (e, value, row, index) {
            e.preventDefault();
            confirmModal.reset();

            if (row.enabled) {
                confirmModal.title = '¿Deseas deshabilitar esta empresa?';
            } else {
                confirmModal.title = '¿Deseas habilitar esta empresa?';
            }

            confirmModal.id = row.id;
            confirmModal.name = row.name;
            confirmModal.action = 'enabled';
            $('#confirmModal').modal('show');
        }
    };

    function dateFormatter(value, row, index){
        if(value)
        {
            return moment(value, moment.ISO_8601).format("DD/MM/YYYY HH:mm");
        }
        else
        {
            return "N/A";
        }
    }

    function prettyStatus(value, row, index) {
        if (value) {
            return 'Si';
        } else {
            return 'No'
        }
    }

    $('#users').bootstrapTable({
        url: Routing.generate('get_companies'),
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
            field: 'enabled',
            title: 'Enabled',
            sortable: true,
            formatter: prettyStatus
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
            formatter: dateFormatter
        }, {
            field: 'operate',
            title: 'Actions',
            align: 'center',
            valign: 'middle',
            clickToSelect: false,
            formatter: operateFormatter,
            events: operateEvents
        }],
        responseHandler: function(res) {
            return res.data;
        }
    });
})();