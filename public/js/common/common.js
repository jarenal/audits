define(['moment'], function (moment) {
    return {
        dateFormatter: function (value, row, index) {
            if(value)
            {
                return moment(value, moment.ISO_8601).format("DD/MM/YYYY HH:mm");
            }
            else
            {
                return "N/A";
            }
        },
        prettyStatus: function (value, row, index) {
            if (value) {
                return 'Si';
            } else {
                return 'No'
            }
        }
    }
});