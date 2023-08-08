<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$this->session->schoolmis_login_level) {
    redirect(base_url('login'));
}
$uri = $this->session->schoolmis_login_uri;
?>
<!-- Bootstrap 4 -->

<script src="<?= base_url() ?>plugins/ol3/ol.js"></script>
<script src="<?= base_url() ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url() ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?= base_url() ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/responsive/js/dataTables.responsive.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>dist/js/adminlte.min.js"></script>

<script type="text/javascript">
    $(".close-sidebar-btn").click(function() {
        // $(".sidebar").slideToggle();
        // $(".main-sidebar").slideToggle();
    })
    // document.getElementById('closeSidebarBtn').addEventListener('click', function() {
    //     alert('a')
    //     var sidebar = document.getElementById('sidebar');
    //     if (sidebar.style.display === 'none') {
    //         sidebar.style.display = 'block';
    //     } else {
    //         sidebar.style.display = 'none';
    //     }
    // });

    // setInterval(function() {
    //     $.post("<?= base_url('Main/allow') ?>");
    // }, 3000)
    var confirmP = "";
    var rmvP = "";
    var refrmvP = "";
    var stq = "";
    var pwd = "";
    var entryId = 0;
    var addItemId = 0;
    var validatorC = 0;
    var valid = 0;
    var grdlvl = 0;
    var rmid = 0;
    $(function() {
        $('.select2').select2()
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        $('[data-toggle="tooltip"]').tooltip()
    });

    $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

    function clear_form(b) {
        let f1 = "PersonnelInfo";
        let a = "form_save_data" + b;
        $("#" + a)[0].reset();
        $("#" + a).find("input[type='hidden']").each(function() {
            $(this).val("");
        });
        $("#" + a).find("input[type='checkbox']").each(function() {
            $(this).attr("checked", false);
        });
        if (b == f1) {} else {
            $("#" + a).find("select").each(function() {
                $(this).trigger("change");
            });
        }


        $("#" + a + " .submitBtnPrimary").attr("disabled", false);
        $("#" + a + " .submitBtnPrimary").html("Save Data");
        $("#" + a + " .clearBtn").html("Clear");
        $("#" + a + " .submitBtnPrimary").removeClass("btn-info").addClass("btn-primary");
        $("#" + a + " .clearBtn").removeClass("btn-danger");

        defaultImg('pic', 'previewPic', 'imgtargetLink', 'MALE');

        // if (b == f1) {
        //     getFetchList(f1, "RegionList", null, 1, {
        //         v: null
        //     }, 1, 1);
        //     getFetchList(f1, "ProvinceList", null, 1, {
        //         v: 16
        //     }, 1, 1);
        //     getFetchList(f1, "CityMunList", null, 1, {
        //         v: 1602
        //     }, 1, 1);
        //     getFetchList(f1, "BarangayList", null, 1, {
        //         v: 160201
        //     }, 1, 1);
        // }
    }

    function delay(form, a, b) {
        setTimeout(function() {
            $("#form_save_data" + form + " [name='" + b + "']").val(a);
            $("#form_save_data" + form + " [name='" + b + "']").trigger("change");
        }, 1000)
    }

    function getDetails(a, b, c) {
        // hideUpdate();
        // clear_form("form_save_data" + a);
        $("#form_save_data" + a + " .submitBtnPrimary").html(c == 1 ? "Update Data" : "Save Data");
        c == 1 ? $("#form_save_data" + a + " .submitBtnPrimary").removeClass("btn-primary").addClass("btn-info") : $("#form_save_data" + a + " .submitBtnPrimary").removeClass("btn-info").addClass("btn-primary");
        $("#form_save_data" + a + " .clearBtn").html(c == 1 ? "cancel" : "clear");
        c == 1 ? $("#form_save_data" + a + " .clearBtn").removeClass("btn-gray").addClass("btn-danger") : $("#form_save_data" + a + " .clearBtn").removeClass("btn-danger").addClass("btn-gray");

        $.each(b, function(k, v) {
            $("#form_save_data" + a).each(function() {
                $("[name='" + k + "']").prop("checked", v);
                $("[name='" + k + "']").val(v);
                $("[class='" + k + "']").html(v);
                $("[name='" + k + "']").trigger("change");
                if (k == "img_path") {
                    // console.log(v)
                    if (v == null) {
                        defaultImg('pic', 'previewPic', 'imgtargetLink', 'MALE');
                    } else {
                        var reader = new FileReader();
                        $("[name=pic]").val("");
                        // $("[name=previewPic]").attr("src", "<?= base_url() ?>" + v);
                        $("[name=previewPic]").attr("src", v);
                        reader.onload = function(e) {
                            document.getElementById(b).src = e.target.result;
                        };
                    }
                }
            });
        });
    }

    function validate(form_id) {
        let invalid = 0;
        $($("#" + form_id).find("select").get().reverse()).each(function() {
            var name = $(this).attr("name");
            var j = clean($(this).attr("name"));
            var nr = $(this).attr("nr");
            var multiple = $(this).attr("multiple");
            // console.log(j)


            if (nr != 1) {
                if (!$(this).val() || $(this).val() == 'null') {
                    $(this).focus().addClass("is-invalid");
                    $("#" + form_id + " select[name='" + name + "']").focus().next().find('.select2-selection').addClass('has-error');
                    $("#" + form_id + " ." + j).addClass('border-danger');
                    invalid++;
                } else {
                    $(this).removeClass("is-invalid");
                    $("#" + form_id + " select[name='" + name + "']").focus().next().find('.select2-selection').removeClass('has-error');
                    $("#" + form_id + " ." + j).removeClass('border-danger');
                }
            }
        });

        $($("#" + form_id).find("input").get().reverse()).each(function() {
            if ($("#" + form_id + ' input[type="search"]')) {
                // return 0;
            }
            if ($("#" + form_id + ' input[type="text"]')) {
                var name = clean($(this).attr("name"));
                var nr = $(this).attr("nr");

                if (name == null) {} else if (nr != 1) {
                    if (!$(this).val()) {
                        $(this).focus().addClass("is-invalid");
                        $("#" + form_id + " ." + name).addClass('border-danger');
                        invalid++;
                    } else {
                        $(this).removeClass("is-invalid");
                        $("#" + form_id + " ." + name).removeClass('border-danger');
                    }
                }
            }
        });
        valid = invalid;
    }


    function dfltpwdchck(a) {
        if (a == true) {
            $('.pwd, .confirmpwd').val('');
            $('.pwd, .confirmpwd').attr('nr', 1);
            $('.pwd, .confirmpwd').removeClass('is-invalid border-danger');
            $('.fillpwd').slideUp();
            $("#form_save_dataPersonnelAccount .submitBtnPrimary").attr("disabled", false);
        } else {
            $('.pwd, .confirmpwd').attr('nr', 0);
            $('.fillpwd').slideDown();
        }
    }

    function passwordChecker(a, b, c) {
        var f = "form_save_data" + a;
        var g = $("#" + f + " ." + b).val();
        var h = $("#" + f + " ." + c).val();
        if (g.length > 7 && h.length > 7) {
            $("#" + f + " .atleast").hide();
            if (g != h) {
                $("#" + f + " .good").hide();
                $("#" + f + " .bad").show();
                $("#" + f + " .submitBtnPrimary").attr("disabled", true);
                // $(".address_details").removeClass("col-lg-12").addClass("col-lg-5");
            } else if (!g && !h) {
                $("#" + f + " .good").hide();
                $("#" + f + " .bad").hide();
                $("#" + f + " .submitBtnPrimary").attr("disabled", true);
            } else {
                $("#" + f + " .good").show();
                $("#" + f + " .bad").hide();
                $("#" + f + " .submitBtnPrimary").attr("disabled", false);
                // $(".address_details").removeClass("col-lg-5").addClass("col-lg-12");
            }
            // $("#" + f + " .submitBtnPrimary").attr("disabled", false);
        } else {
            $("#" + f + " .atleast").show();
            if (g.length == 0 && h.length == 0) {
                $("#" + f + " .submitBtnPrimary").attr("disabled", false);
            } else {
                $("#" + f + " .submitBtnPrimary").attr("disabled", true);
            }
        }
    }

    function reportForm(formId) {
        $("#form_report_data" + formId + " .submitBtnPrimary").attr("disabled", true);
        $("#form_report_data" + formId + " .submitBtnPrimary").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        var table, table_data = $("#tblReport" + formId).DataTable({
            "iDisplayLength": -1,
            ajax: {
                url: "<?= base_url($uri . '/report/report') ?>" + formId,
                icon: "POST",
                data: function(d) {
                    d.a = $("#form_report_data" + formId).serialize();
                    return table_data;
                }
            },
            "initComplete": function(settings, json) {
                json.data.length == 0 ? failAlert("No Data found!") : $("#modalReport" + formId).modal("show");
                $("#tblReport" + formId).DataTable().destroy();
                $("#form_report_data" + formId + " .submitBtnPrimary").attr("disabled", false);
                $("#form_report_data" + formId + " .submitBtnPrimary").html("Go!");
                if (formId == "InvPO") {
                    $("#headerReport" + formId).text("Inventory & Purchase Order as of " + $("[name='filterInvPOfromDate'").val() + " - " + $("[name='filterInvPOtoDate'").val());
                }
                if (formId == "StckPR") {
                    $("#headerReport" + formId).text("Stocks & Purchase Request as of " + $("[name='filterStckPRfromDate'").val() + " - " + $("[name='filterStckPRtoDate'").val());
                }
            }
        });
    }

    function saveForm(formId, tblId, tbl, dtd, pl) {
        let a = "";
        var saveData = {
            clearForm: false,
            resetForm: false,
            beforeSubmit: function(e) {
                if (formId != 'SbjctAssPrsnnl') {
                    validate("form_save_data" + formId);
                }
                if (valid != 0) {
                    fillIn();
                    return false;
                }
                // a = $("#form_save_data" + formId + " .submitBtnPrimary").text();
                $("#form_save_data" + formId + " .submitBtnPrimary").attr("disabled", true);
                $("#form_save_data" + formId + " .submitBtnPrimary").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
            },
            success: function(data) {
                var d = JSON.parse(data);
                if (d.success == true) {
                    successAlert("Successfully Saved!");
                    clear_form(formId);
                    $("#modal" + formId).modal('hide');
                    for (var i = 0; i < tblId.length; i++) {
                        getTable(tblId[i], dtd, pl);
                    }
                    tbl ? removeAllItemList("tbl" + tbl) : null;
                    tbl ? $("#btn" + tbl).trigger("click") : null;
                } else if (d.success == false && d.exist == true) {
                    existAlert(d.message);
                } else if (d.existCode == true) {
                    existAlert("Code already taken!<br/>by: " + d.existPerson);
                } else {
                    failAlert("Something went wrong!");
                }
                $("#form_save_data" + formId + " .submitBtnPrimary").attr("disabled", false);
                // $("#form_save_data" + formId + " .submitBtnPrimary").html(a);
            }
        };
        $("#form_save_data" + formId).ajaxForm(saveData);
    }

    function getTable(tableId, dtd, pl) {
        var drawCounter = 0;
        $("#tbl" + tableId).DataTable().destroy();
        var table, table_data = $("#tbl" + tableId).DataTable({
            "order": [
                [0, "asc"]
            ],
            dom: 'Bfrtip',
            buttons: [],
            // searching: tableId == 'GradesList' ? false : true,
            "info": pl == -1 ? false : true,
            "paging": pl == -1 ? false : true,
            "ordering": pl == -1 ? false : true,
            "oLanguage": {
                "sSearch": ""
            },
            "processing": true,
            "serverSide": true,
            language: {
                searchPlaceholder: "Search...",
            },
            // pageLength: pl,// Options for records per page
            // lengthMenu: [
            //     [10, 25, 50, 100],
            //     [10, 25, 50, 100]
            // ],
            ajax: {
                url: "<?= base_url($uri . '/getdata/get') ?>" + tableId,
                type: "POST",
                data: function(d) {
                    drawCounter++;
                    d.length = pl;
                    d.draw = drawCounter;
                    d.search.value = $('#tbl' + tableId + '_filter input').val();
                    // if (tableId == "PersonnelInfo") {
                    //     d.a = $("#form_save_dataPersonnelSearch").serialize();
                    // }
                    // if (tableId == "PersonnelInfo") {
                    //     d.search.value = $('#searchTable1').val();
                    // } else if (tableId == "GateInfo") {
                    //     d.search.value = $('#searchTable2').val();
                    // }
                }
            },

            // "lengthMenu": [5, 10, 25, 50, 100], 
            "pageLength": pl,
        });

        $("#tbl" + tableId).on('draw.dt', function() {
            $(".searchBtn").attr("disabled", false);
            $(".searchBtn").html("<span class=\"fa fa-search\"></span>");
            dtd == 1 ? $("#tbl" + tableId).DataTable().destroy() : "";
            $(".collapse" + tableId).trigger('click');
        });
        $("#tbl" + tableId + "_filter").addClass("row");
        $("#tbl" + tableId + "_filter label").css("width", "98.3%");
        $("#tbl" + tableId + "_filter .form-control-sm").css("width", "98.3%");

        if (tableId == "SubjectList") {
            getFetchList('GradeSubject', "SubjectList", "PartyList", 0, {
                v: 17
            }, 0);

            // setTimeout(() => {
            //     arr = [];
            //     $("#form_save_dataGradeSubject .selectSubjectList option").each(function() {
            //         let a = $(this).attr("value");
            //         a != '' ? arr.push($(this).attr("value")) : null;
            //     });
            //     // console.log(arr)
            // }, 3000);

        }
    }

    function imageView(a, b, c) {
        // var reader = new FileReader();
        // var fh = filehandler($('#' + a).val());
        // reader.onload = function(e) {
        //     document.getElementById(b).src = e.target.result;
        // };
        // reader.readAsDataURL(document.getElementById(a).files[0]);

        var fileInput = $("[name=" + a + "]")[0]; // Get the file input element
        var file = fileInput.files[0]; // Get the selected file

        if (file.size > 25 * 1024 * 1024) {
            // Picture size is above 2MB
            alert("Picture must be less than 2MB");
            return; // You can handle this case according to your requirements
        }

        var reader = new FileReader();

        reader.onload = function(e) {
            $("[name=" + b + "]").attr('src', e.target.result); // Set the source of the image element
        };

        reader.readAsDataURL(file);
    }

    function defaultImg(a, b, c, d) {
        var reader = new FileReader();
        $("[name=pic]").val("");
        // img = (d == 'FEMALE' ? 'defaultf.png' : 'defaultm.png');
        $("[name=previewPic]").attr("src", "<?= $system_svg_1x1 ?>");
        reader.onload = function(e) {
            document.getElementById(b).src = e.target.result;
        };
    }

    // function getTablez(tableId, dtd, pl) {
    //     var drawCounter = 0;
    //     $("#tbl" + tableId).DataTable().destroy();
    //     var table_data = $("#tbl" + tableId).DataTable({

    //         "processing": true,
    //         "serverSide": true,
    //         ajax: {
    //             url: "<?= base_url($uri . '/getdata/get') ?>" + tableId,
    //             type: "POST",
    //             data: function(d) {
    //                 // Calculate the offset (start) based on the page number
    //                 // d.start = (d.start / d.length) + 1;
    //                 // d.length = pl; // Set the limit (length) to the desired value
    //                 // d.draw = d.draw || 1; // Set the default value to 1 if not provided

    //                 drawCounter++;
    //                 d.draw = drawCounter;
    //                 // Include the search value in the AJAX request
    //                 d.search.value = $('.dataTables_filter input').val();
    //             }
    //         },
    //         "lengthMenu": [10, 25, 50, 100], // Options for records per page
    //         "pageLength": 10,
    //     });

    //     // Rest of your code...
    // }

    function searchPersonnel() {
        alert('a')
    }

    function tblReload(tableId) {
        $("#tbl" + tableId).DataTable().ajax.reload();
    }

    function getSbjctAssPrsnnlFN(tableId, a, b) {
        grdlvl = a;
        rmid = b;
        tblReload(tableId);
    }

    function getSbjctAssPrsnnl(tableId) {
        $("#tbl" + tableId).DataTable().destroy();
        var table, table_data = $("#tbl" + tableId).DataTable({
            "order": [
                [0, "asc"]
            ],
            dom: 'Bfrtip',
            buttons: [],
            searching: false,
            "info": false,
            "paging": false,
            "ordering": false,
            "oLanguage": {
                "sSearch": ""
            },
            // language: {
            //     searchPlaceholder: "Search...",
            // },
            pageLength: -1,
            lengthMenu: [
                [-1],
                ["Show all rows"]
            ],
            ajax: {
                url: "<?= base_url($uri . '/getdata/get') ?>" + tableId,
                type: "POST",
                data: function(d) {
                    d.grdlvl = grdlvl;
                    d.rmid = rmid;
                }
            }
        });
        $("#tbl" + tableId).on('draw.dt', function() {
            // $("#tbl" + tableId).DataTable().destroy();

            // $(".searchBtn").attr("disabled", false);
            // $(".searchBtn").html("<span class=\"fa fa-search\"></span>");
            $("#form_save_data" + tableId + " .select" + tableId).select2();


            // $(".searchBtn").attr("disabled", false);
            // $(".searchBtn").html("<span class=\"fa fa-search\"></span>");
            // $("#tbl" + tableId).DataTable().destroy();
            // $(".collapse" + tableId).trigger('click');

            grdlvl != 0 ? $("#modal" + tableId).modal('show') : "";
        });
        // $("#tbl"+tableId+"_filter").addClass("row");
        // $("#tbl"+tableId+"_filter label").css("width","99%");
        // $("#tbl"+tableId+"_filter .form-control-sm").css("width","99%");
    }

    function getLocation(a, b, c, e) {
        for (var i = 0; i < a.length; i++) {
            clearLoc(b[i], c);
            let form = 'form_save_data' + c;
            let d = $('#' + form + ' .select' + a[i]).val();
            let ab = d == '' || d == null ? 0 : d;
            getFetchList(c, b[i], null, 1, {
                v: ab
            }, 1, 1);
            // getFetchList(c, b[i], null, 1, e);
        }
    }

    function clearLoc(a, b) {
        let form = 'form_save_data' + b;
        $("#" + form + " .select" + a).empty();
    }

    function getFetchList(formId, getList, getQ, s2, where, sel, e) {
        var q = getQ ? getQ : getList;
        $("#form_save_data" + formId + " .select" + getList).empty();
        $.post("<?= base_url($uri . '/getdata/get') ?>" + q, where,
            function(data) {
                var result = JSON.parse(data);
                (sel == 0 || e == 0) ? $("#form_save_data" + formId + " .select" + getList).append("<option value=''>SELECT</option>"): "";
                for (var i = 0; i < result["data"].length; i++) {
                    $("#form_save_data" + formId + " .select" + getList).append("<option value='" + result["data"][i]['id'] + "'>" + result["data"][i]['item'] + "</option>");
                }
            }
        ).then(function() {
            s2 == 1 ? $("#form_save_data" + formId + " .select" + getList).select2() : "";
        });
    }

    $('#form_save_dataGradeSubject .selectSubjectList').on("select2:select", function(e) {
        // console.log('a')
        var unselected_value = $(this).val();
        // console.log(unselected_value);
    }).trigger('change');


    function getSelectSubject() {
        var where = $("#form_save_dataGradeSubject .selectGradeList").val();
        $.post("<?= base_url($uri . '/getdata/getGradeSubjectList') ?>", {
                v: where
            },
            function(data) {
                var result = JSON.parse(data);
                var data = [];
                if (!result.length) {
                    for (var i = 0; i < result['data'].length; i++) {
                        data.push(result['data'][i]['subject_id']);
                    }
                    $("#form_save_dataGradeSubject .selectSubjectList").val(data);
                    $("#form_save_dataGradeSubject .selectSubjectList").trigger('change');
                }
            }
        ).then(function() {});
    }

    var invalidChars = [
        "-",
        "+",
        "e",
    ];

    function viewRegionProvince() {
        $(".region_province").toggle("slow", function() {
            if ($(".region_province").is(":visible")) {
                $(".address_details").removeClass("col-lg-12").addClass("col-lg-5");
            } else {
                $(".address_details").removeClass("col-lg-5").addClass("col-lg-12");
            }
        });
    }

    function clean(a) {
        var str = a;
        return str === undefined ? null : str.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
    });

    function successAlert(a) {
        Toast.fire({
            icon: 'success',
            title: '  ' + a
        })
    }

    function failAlert(a) {
        Toast.fire({
            icon: 'error',
            title: '  ' + a
        })
    }

    function fillIn() {
        Toast.fire({
            icon: 'error',
            title: '  Please fill in all the required fields.'
        })
    }

    function existAlert(a) {
        Toast.fire({
            icon: 'warning',
            title: '  ' + a
        })
    }

    function noData(a) {
        Toast.fire({
            icon: 'warning',
            title: '  ' + a,
        })
    }

    function printForm(a, b, c, d) {
        var orientation = (b == 'p' ? 'portrait' : 'landscape');
        var margin = (c == 'Legal' ? 'margin:5mm 5mm 5mm 5mm;' : 'margin:5mm 5mm 5mm 5mm;');
        var windowUrl = 'Print Form';
        var uniqueName = new Date();
        var windowName = 'emailSection' + uniqueName.getTime();
        var accompWindow = window.open('height=1500,width=2000');
        accompWindow.document.write('<html>');
        accompWindow.document.write('<head>');
        accompWindow.document.title = d;
        accompWindow.document.write('<link rel="stylesheet" href="<?= base_url() ?>plugins/fontawesome-free/css/all.min.css">' +
            '<link rel="stylesheet" href="<?= base_url() ?>dist/css/adminlte.min.css">');
        accompWindow.document.write('</head>');
        accompWindow.document.write('<style> @page { size: ' + c + ' ' + orientation + ';' + margin + '} .square {height: 100px;width: 100px;border:1px solid black; } </style>');
        accompWindow.document.write('<body>' + $("#print" + a).html() + '</body>');
        accompWindow.document.write('</html>');
        setTimeout(function() {
            accompWindow.print();
            accompWindow.close();
        }, 1000);
    }
</script>