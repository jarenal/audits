require(['Vue', 'VeeValidate', 'dictionaryES', 'vendor/bootstrap/bootstrap.bundle', 'sbAdmin'], function (Vue, VeeValidate, dictionaryES) {

    console.log(window, 'window');
    console.log(document, 'document');
    //VeeValidate.Validator.localize('es', dictionary);
    Vue.use(VeeValidate, {locale: 'es', dictionary: {es: dictionaryES}});
    Vue.config.debug = true;

    var formCompanies = new Vue({
        el: '#form-companies',
        delimiters: ['[[',']]'],
        data: {
            id: '',
            name: '',
            phone: '',
            email: '',
            rfc: '',
            address: '',
            contact: '',
            is_active: true,
            is_sending: false
        },
        methods: {
            populate: function (data) {
                this.id = data.id;
                this.name = data.name;
                this.phone = data.phone;
                this.email = data.email;
                this.rfc = data.rfc;
                this.address = data.address;
                this.contact = data.contact;
                this.is_active = data.is_active;

                this.$validator.reset();
            },
            reset: function () {

                this.id = '';
                this.name = '';
                this.phone = '';
                this.email = '';
                this.rfc = '';
                this.address = '';
                this.contact = '';
                this.is_active = true;

                this.$validator.reset();
            },
            hasErrors: function () {
                if(this.name &&
                    this.phone &&
                    this.email &&
                    this.rfc &&
                    this.address &&
                    this.contact) {
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

                data.is_active = data.is_active ? 1 : 0;

                if (data.id) {
                    var parameters = { company: data };

                    $.ajax({
                        url: Routing.generate('api_companies_put', {slug: data.id}),
                        method: 'PUT',
                        data: parameters,
                        cache: false,
                        error: function (jqXHR, textStatus, errorThrown) {
                            // TODO Handle exception
                        },
                        success: function (response, textStatus, jqXHR) {
                            console.log('success!', response);
                            window.location.href = Routing.generate('companies_list');
                        },
                        beforeSend: function () {
                            self.is_sending = true;
                        }

                    });
                } else {
                    delete data.id;
                    var parameters = { company: data };

                    $.ajax({
                        url: Routing.generate('api_companies_post'),
                        method: 'POST',
                        data: parameters,
                        cache: false,
                        error: function (jqXHR, textStatus, errorThrown) {
                            // TODO Handle exception
                            console.error('Error on request to api_companies_post', errorThrown)
                        },
                        success: function (response, textStatus, jqXHR) {
                            console.log('success!', response);
                            window.location.href = Routing.generate('companies_list');
                        },
                        beforeSend: function () {
                            self.is_sending = true;
                        }

                    });
                }
            }
        }
    });

    if (companyData) {
        formCompanies.populate(companyData);
    }
});
