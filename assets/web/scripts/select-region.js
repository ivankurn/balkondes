$(document).ready(function() {
    var pulau = $("#islands option:selected").data("id");
    var provinsi = 'empty';
    var kota = 'empty';
    var rootURL = $("#root-url").val();

    $("#islands").change(function() {
        pulau = $("#islands option:selected").data("id");
        if(pulau==="any" || pulau === "" || pulau === undefined){
            $("#province").empty();
            $("#province").prop("disabled",true);
            $("#city").empty();
            $("#city").prop("disabled",true);
            return;
        }
        waitingDialog.show('Searching...');
        $("#province").empty();
        $("#province").prop("disabled",false);
        $("#city").empty();
        $("#city").prop("disabled",true);
        console.log(pulau)
        if (pulau) {
            $.ajax({
                url: rootURL + "/ajax/province",
                type: 'POST',
                data:{
                  'id_pulau' : pulau
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status = "success") {
                        $("#provinsi").empty();
                        waitingDialog.hide();

                        data = data.result;
                        content = '';
                        // content += '<select id="nama-provinsi" class="form-control" name="provinsi_outlet">'
                        content += '<option>-</option>';

                        for (var i = 0; i < data.length; i++) {
                            content += '<option value="' + data[i].nama_provinsi + '" data-id="' + data[i].id_provinsi + '">' + data[i].nama_provinsi + '</option>'
                        }

                        console.log(pulau + '-' + provinsi + '-' + kota)
                        $("#province").empty();
                        $("#province").append(content);

                    }

                    else if (data.status == "fail"){
                      waitingDialog.hide();
                      $("#province").empty();
                      $("#province").prop("disabled",true);
                      $("#city").empty();
                      $("#city").prop("disabled",true);
                      alert(data.messages);
                    }

                },
                error: function(xhr) {
                    waitingDialog.hide();
                    alert("Something went wrong! Please re-select.");
                }
            })
        }

        else{
            // toastr.clear();
            pulau     = "empty";
            provinsi  = "empty";
            kota      = "empty";
            // $("#group-provinsi").hide();
            // $("#group-kota").hide();
        }
    });

    $("#province").change(function() {
        provinsi = $("#province option:selected").attr("data-id");
        if(provinsi === "" || provinsi === undefined){
            return;
        }
        $("#city").empty();
        waitingDialog.show('Searching...');
        if (provinsi) {
            $.ajax({
                url: rootURL + "/ajax/city",
                type: 'POST',
                data: {'id_provinsi' : provinsi},
                dataType: 'json',
                success: function(data) {
                    if (data.status == "success") {
                        waitingDialog.hide();
                        data = data.result;
                        content = '';
                        // content += '<select id="nama-kota" class="form-control" name="kota_outlet">'
                        content += '<option>-</option>';

                        for (var i = 0; i < data.length; i++) {
                            content += '<option value="' + data[i].nama_kota + '" data-id="' + data[i].id_kota + '">' + data[i].nama_kota + '</option>'
                        }

                        // content += '</select>';
                        console.log(pulau + '-' + provinsi + '-' + kota)

                        $("#city").append(content);
                        $("#city").show();
                        $("#city").prop("disabled",false);
                    }

                    else if (data.status == "fail"){
                      waitingDialog.hide();
                      alert(data.messages);
                      $("#city").show();
                      $("#city").prop("disabled",true);
                    }

                },
                error: function() {
                  waitingDialog.hide();
                  alert('Something went wrong! Please re-select.');
                }
            })
        } else {
            kota = "empty";
            $("#city").empty();
        }
    });

    $("#provinceAsal").change(function() {
        var provinsi = $("#provinceAsal option:selected").attr("data-id");
        if(provinsi === "" || provinsi === undefined){
            return;
        }
        $("#cityAsal").empty();
        waitingDialog.show('Searching...');
        if (provinsi) {
            $.ajax({
                url: rootURL + "/ajax/city",
                type: 'POST',
                data: {'id_provinsi' : provinsi},
                dataType: 'json',
                success: function(data) {
                    if (data.status == "success") {
                        waitingDialog.hide();
                        data = data.result;
                        content = '';
                        // content += '<select id="nama-kota" class="form-control" name="kota_outlet">'
                        content += '<option>-</option>';

                        for (var i = 0; i < data.length; i++) {
                            content += '<option value="' + data[i].nama_kota + '" data-id="' + data[i].id_kota + '">' + data[i].nama_kota + '</option>'
                        }

                        // content += '</select>';
                        // console.log(pulau + '-' + provinsi + '-' + kota)

                        $("#cityAsal").append(content);
                        $("#cityAsal").show();
                    }

                    else if (data.status == "fail"){
                      waitingDialog.hide();
                      alert(data.messages);
                    }

                },
                error: function() {
                  waitingDialog.hide();
                  alert('Something went wrong! Please re-select.')
;                }
            })
        } else {
            kota = "empty";
            $("#cityAsal").empty();
        }
    });
    //
    // $(document).on('change', "#nama-kota", function() {
    //     kota = $("#nama-kota option:selected").val();
    // });

    // $("#myForm").submit(function(e) {
    //     if (pulau == 'empty' || provinsi == 'empty' || kota == 'empty') {
    //         // toastr.options.timeOut = 5000;
    //         // toastr.error("Kolom pulau, provinsi dan kota wajib diisi!", "Error");
    //         return false;
    //     } else return true;
    //
    // })

})
