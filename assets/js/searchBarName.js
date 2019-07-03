const $ = require('jquery');
const autocomplete = require('jquery-ui/ui/widgets/autocomplete');
require('jquery-ui/themes/base/all.css');

$('#form_info').autocomplete({
    source : function (request, response) {
        $.ajax({
            url: "/product/all/json",
            dataType: "json",
            data: {
                name: $('#form_info').val()
            },
            success: function (data) {
                response(data);
            }
        });
    },
    minLength: 2
});