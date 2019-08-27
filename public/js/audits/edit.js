require(['Vue', 'VeeValidate', 'dictionaryES', 'VueSelect', 'underscore', 'vendor/bootstrap/bootstrap.bundle', 'sbAdmin'], function (Vue, VeeValidate, dictionaryES, VueSelect, _) {

    console.log(window, 'window');
    console.log(document, 'document');
    //VeeValidate.Validator.localize('es', dictionary);
    Vue.use(VeeValidate, {locale: 'es', dictionary: {es: dictionaryES}});
    Vue.config.debug = true;
    Vue.component('v-select', VueSelect.VueSelect);

    var formAudits = new Vue({
        el: '#form-audits',
        delimiters: ['[[',']]'],
        data: {
            id: '',
            company: null,
            candidate: null,
            agent: null,
            required_position: '',
            start_date: '',
            end_date: '',
            status: '',
            is_sending: false,
            companies: [],
            candidates: [],
            agents: [],
        },
        methods: {
            populate: function (data) {
                this.id = data.id;
                this.company = data.company;
                this.candidate = data.candidate;
                this.agent = data.agent;
                this.required_position = data.required_position;
                this.start_date = data.start_date;
                this.end_date = data.end_date;
                this.status = data.status.id;

                this.$validator.reset();
            },
            reset: function () {

                this.id = '';
                this.company = '';
                this.candidate = '';
                this.agent = '';
                this.required_position = '';
                this.start_date = '';
                this.end_date = '';
                this.status = '';

                this.$validator.reset();
            },
            hasErrors: function () {
                if(this.company &&
                    this.candidate &&
                    this.agent &&
                    this.required_position &&
                    this.start_date &&
                    this.end_date &&
                    this.status) {
                    return this.$validator.errors.count() ? true : false;
                } else {
                    return true;
                }
            },
            save: function(event) {
                var self = this;
                event.stopPropagation();

                var data = JSON.parse(JSON.stringify(self.$data));

                console.log('this.is_sending', self.is_sending);

                if (data.id) {
                    var parameters = { audit: {
                        id: data.id,
                        company: data.company.id,
                        candidate: data.candidate.id,
                        agent: data.agent.id,
                        required_position: data.required_position,
                        start_date: data.start_date,
                        end_date: data.end_date,
                        status: data.status
                    } };

                    $.ajax({
                        url: Routing.generate('api_audits_put', {slug: data.id}),
                        method: 'PUT',
                        data: parameters,
                        cache: false,
                        error: function (jqXHR, textStatus, errorThrown) {
                            // TODO Handle exception
                        },
                        success: function (response, textStatus, jqXHR) {
                            console.log('success!', response);
                            window.location.href = Routing.generate('audits_list');
                        },
                        beforeSend: function () {
                            self.is_sending = true;
                        }

                    });
                } else {
                    delete data.id;
                    var parameters = { audit: {
                        company: data.company.id,
                        candidate: data.candidate.id,
                        agent: data.agent.id,
                        required_position: data.required_position,
                        start_date: data.start_date,
                        end_date: data.end_date,
                        status: data.status
                    } };

                    $.ajax({
                        url: Routing.generate('api_audits_post'),
                        method: 'POST',
                        data: parameters,
                        cache: false,
                        error: function (jqXHR, textStatus, errorThrown) {
                            // TODO Handle exception
                            console.error('Error on request to api_audits_post', errorThrown)
                        },
                        success: function (response, textStatus, jqXHR) {
                            console.log('success!', response);
                            window.location.href = Routing.generate('audits_list');
                        },
                        beforeSend: function () {
                            self.is_sending = true;
                        }

                    });
                }
            },
            onSearchCompanies: function(search, loading) {
                this.search('companies', loading, search, this);
            },
            onSearchCandidates: function(search, loading) {
                this.search('candidates', loading, search, this);
            },
            onSearchAgents: function(search, loading) {
                this.search('agents', loading, search, this);
            },
            search: _.debounce(function(entity, loading, search, vm) {
                this.getRemoteData(entity, loading, search, vm);
            }, 350),
            getRemoteData: function (entity, loading, search, vm) {
                $.ajax({
                    url: Routing.generate('api_'+entity+'_get'),
                    method: 'GET',
                    data: {dropdown: true, search: search},
                    cache: false,
                    error: function (jqXHR, textStatus, errorThrown) {
                        // TODO Handle exception
                    },
                    success: function (response, textStatus, jqXHR) {
                        console.log('success!', response);
                        vm[entity] = response.data;
                        loading(false);
                    },
                    beforeSend: function () {
                        vm[entity] = [];
                        loading(true);
                    }
                });
            },
            preLoadRemoteData: function (vm) {
                vm.getRemoteData('companies', function () {}, '', vm);
                vm.getRemoteData('candidates', function () {}, '', vm);
                vm.getRemoteData('agents', function () {}, '', vm);
            }
        }
    });

    if (!_.isEmpty(auditData)) {
        formAudits.populate(auditData);
    }

    formAudits.preLoadRemoteData(formAudits);
});
