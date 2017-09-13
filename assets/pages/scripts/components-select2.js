var ComponentsSelect2 = function() {

    var handleDemo = function() {

        // Set the "bootstrap" theme as the default theme for all Select2
        // widgets.
        //
        // @see https://github.com/select2/select2/issues/2927
        $.fn.select2.defaults.set("theme", "bootstrap");

        var placeholder = "";

        $(".select2, .select2-multiple").select2({
            placeholder: placeholder,
            width: null
        });

        $(".select2-allow-clear").select2({
            allowClear: true,
            placeholder: placeholder,
            width: null
        });
		
		// @see https://select2.github.io/examples.html#data-ajax
        function formatRepoCustomer(repo) {
            if (repo.loading) return "Mencari Customer. Tunggu sebentar...";

            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.nama_customer + "</div>";

            if (repo.phone_customer) {
                markup += "<div class='select2-result-repository__description'>" + repo.phone_customer + "</div>";
            }

            markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><span class='glyphicon glyphicon-envelope'></span> Phone 2: " + repo.phone_customer_2 + " </div>" +
				"<div class='select2-result-repository__forks'><span class='glyphicon glyphicon-envelope'></span> Email: " + repo.email_customer + " </div>" +
                "<div class='select2-result-repository__stargazers'><span class='glyphicon glyphicon-home'></span> Kota: " + repo.kota_customer + "</div>" +
                "</div></div>";

            return markup;
        }
		
		function formatRepoSupplier(repo) {
            if (repo.loading) return "Mencari Supplier. Tunggu sebentar...";

            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.nama_supplier + "</div>";

            if (repo.phone_customer) {
                markup += "<div class='select2-result-repository__description'>" + repo.phone_supplier + "</div>";
            }

            markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><span class='glyphicon glyphicon-envelope'></span> Phone 2: " + repo.phone_supplier_2 + " </div>" +
				"<div class='select2-result-repository__forks'><span class='glyphicon glyphicon-envelope'></span> Email: " + repo.email_supplier + " </div>" +
                "<div class='select2-result-repository__stargazers'><span class='glyphicon glyphicon-home'></span> Kota: " + repo.kota_supplier + "</div>" +
                "</div></div>";

            return markup;
        }
		
		function formatRepoCustomerSelection(repo) {
            return repo.nama_customer || repo.text;
        }
		
		function formatRepoSupplierSelection(repo) {
            return repo.nama_supplier || repo.text;
        }
		
		$(".js-data-customer-ajax").select2({
            width: "off",
            ajax: {
                url: "http://tosca.ivankp.xyz/ajax/search/customer",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    return {
						
                        results: data.items
                    };
					
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 3,
            templateResult: formatRepoCustomer,
            templateSelection: formatRepoCustomerSelection
        });
		
		$(".js-data-supplier-ajax").select2({
            width: "off",
            ajax: {
                url: "http://tosca.ivankp.xyz/ajax/search/supplier",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    return {
						
                        results: data.items
                    };
					
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 3,
            templateResult: formatRepoSupplier,
            templateSelection: formatRepoSupplierSelection
        });

        $("button[data-select2-open]").click(function() {
            $("#" + $(this).data("select2-open")).select2("open");
        });

        $(":checkbox").on("click", function() {
            $(this).parent().nextAll("select").prop("disabled", !this.checked);
        });

        // copy Bootstrap validation states to Select2 dropdown
        //
        // add .has-waring, .has-error, .has-succes to the Select2 dropdown
        // (was #select2-drop in Select2 v3.x, in Select2 v4 can be selected via
        // body > .select2-container) if _any_ of the opened Select2's parents
        // has one of these forementioned classes (YUCK! ;-))
        $(".select2, .select2-multiple, .select2-allow-clear, .js-data-customer-ajax, .js-data-supplier-ajax").on("select2:open", function() {
            if ($(this).parents("[class*='has-']").length) {
                var classNames = $(this).parents("[class*='has-']")[0].className.split(/\s+/);

                for (var i = 0; i < classNames.length; ++i) {
                    if (classNames[i].match("has-")) {
                        $("body > .select2-container").addClass(classNames[i]);
                    }
                }
            }
        });

        $(".js-btn-set-scaling-classes").on("click", function() {
            $("#select2-multiple-input-sm, #select2-single-input-sm").next(".select2-container--bootstrap").addClass("input-sm");
            $("#select2-multiple-input-lg, #select2-single-input-lg").next(".select2-container--bootstrap").addClass("input-lg");
            $(this).removeClass("btn-primary btn-outline").prop("disabled", true);
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleDemo();
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        ComponentsSelect2.init();
    });
}