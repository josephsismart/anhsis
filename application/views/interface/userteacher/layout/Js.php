<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$this->session->schoolmis_login_level) {
    redirect(base_url('login'));
}
$uri = 'userteacher'; //$this->session->schoolmis_login_uri;
$uri_reports = "reports";
$sy_ = $getOnLoad["sy"]; //$getOnLoad["sy_qrtr_e_g"];
$q_ = $getOnLoad["qrtrR"]; //$getOnLoad["sy_qrtr_e_g"];
?>
<!-- Bootstrap 4 -->

<script src="<?= base_url() ?>plugins/ol3/ol.js"></script>
<script src="<?= base_url() ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url() ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/jszip.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/buttons.flash.min.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/buttons.html5.min.js"></script>
<!-- <script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/pdfmake.min.js"></script> -->
<!-- <script src="<?= base_url() ?>plugins/inputmask/jquery.inputmask.min.js"></script> -->
<script src="<?= base_url() ?>plugins/datatables/extensions/buttons/js/vfs_fonts.js"></script>
<script src="<?= base_url() ?>plugins/datatables/extensions/responsive/js/dataTables.responsive.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>dist/js/adminlte.min.js"></script>
<!-- ExportExcel -->
<script src="<?= base_url() ?>plugins/tablexcel/src/jquery.table2excel.js"></script>
<!-- ImportExcel -->
<script src="<?= base_url() ?>plugins/jquery/xlsx.full.min.js"></script>
<script src="<?= base_url() ?>plugins/jquery/jszip.js"></script>
<script src="<?= base_url() ?>plugins/qrcode_generator/qrcode.min.js"></script>
<script src="<?= base_url() ?>plugins/barcode_generator/JsBarcode.all.min.js"></script>

<!-- <script src="<?= base_url() ?>plugins/tablexport/FileSaver.min.js"></script>
<script src="<?= base_url() ?>plugins/tablexport/Blob.min.js"></script>
<script src="<?= base_url() ?>plugins/tablexport/xls.core.min.js"></script>
<script src="<?= base_url() ?>plugins/tablexport/tableexport.js"></script> -->

<script type="text/javascript">
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
    var rsid = 0;
    var sec_name = "";
    var rssaid = 0;
    var logsHS = 0;
    var adviser = 0;
    var bTmp = 0;
    var cTmp = 0;
    var filename = "";

    var vars = {};
    $(function() {
        $('.select2').select2()
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });

    function check_all(a) {
        if ($("#" + a).prop('checked') == true) {
            $("#tblLearnersList").find("input[type='checkbox']").each(function() {
                $("." + a).prop("checked", true);
            });
        } else {
            $("#tblLearnersList").find("input[type='checkbox']").each(function() {
                $("." + a).prop("checked", false);
            });
        }
    }

    function clear_form1() {
        clear_form("form_save_dataEnrollmentInfo");
        $("#form_save_dataEnrollmentInfo #ersid").val(rsid)
    }

    function clear_form(form_id) {
        $("#" + form_id)[0].reset();
        $("#" + form_id).find("input[type='hidden']").each(function() {
            $(this).val("");
        });
        $("#" + form_id).find("input[type='checkbox']").each(function() {
            $(this).attr("checked", false);
        });
        $("#" + form_id).find("select").each(function() {
            $(this).trigger("change");
        });

        $("#" + form_id + " .submitBtnPrimary").attr("disabled", false);
        $("#" + form_id + " .submitBtnPrimary").html("Save Data");
    }

    function getDetails(a, b, c, d) {
        $.each(b, function(k, v) {
            $(d + "form_save_data" + a).each(function() {
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
                        $("[name=previewPic]").attr("src", "<?= base_url() ?>" + v);
                        reader.onload = function(e) {
                            document.getElementById(b).src = e.target.result;
                        };
                    }
                }
            });
        });
    }

    function unenroll() {
        validate("form_save_dataUnenrollConfirm");
        if (valid != 0) {
            fillIn();
            return false;
        }
        // a = $("#form_save_dataUnenrollConfirm .submitBtnPrimary").text();
        // $("#form_save_dataUnenrollConfirm .submitBtnPrimary").attr("disabled", true);
        // $("#form_save_dataUnenrollConfirm .submitBtnPrimary").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        s = $("#form_save_dataUnenrollConfirm").serialize();
        $.post("<?= base_url($uri . '/Dataentry/learnerUnenroll') ?>", s,
            function(data) {
                var result = JSON.parse(data);
                if (result.success == true) {
                    successAlert(result.message);
                    // getTable("LearnersList", 0, -1);
                    $("#modalLearnersUnenroll").modal('hide');
                    // getTable("LearnersList", 0, -1);
                    getTable("AssignedSectionList", 0, -1);
                    // setTimeout(function() {
                    //     $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                    // }, 1500);
                } else if (result.success == false) {
                    failAlert(result.message);
                    // getTable("LearnersList", 0, -1);
                }
            }
        ).then(function() {
            // s2 == 1 ? $("#form_save_data" + formId + " .select" + getList).select2() : "";
        });
    }

    function transfer() {
        validate("form_save_dataTransferConfirm");
        if (valid != 0) {
            fillIn();
            return false;
        }
        // a = $("#form_save_dataTransferConfirm .submitBtnPrimary").text();
        // $("#form_save_dataTransferConfirm .submitBtnPrimary").attr("disabled", true);
        // $("#form_save_dataTransferConfirm .submitBtnPrimary").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        s = $("#form_save_dataTransferConfirm").serialize();
        $.post("<?= base_url($uri . '/Dataentry/learnerTransfer') ?>", s,
            function(data) {
                var result = JSON.parse(data);
                if (result.success == true) {
                    successAlert(result.message);
                    // getTable("LearnersList", 0, -1);
                    $("#modalLearnersTransfer").modal('hide');
                    // getTable("LearnersList", 0, -1);
                    getTable("AssignedSectionList", 0, -1);
                    // setTimeout(function() {
                    //     $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                    // }, 1500);
                } else if (result.success == false) {
                    failAlert(result.message);
                    // getTable("LearnersList", 0, -1);
                }
            }
        ).then(function() {
            // s2 == 1 ? $("#form_save_data" + formId + " .select" + getList).select2() : "";
        });
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

        if (file.size > 2 * 1024 * 1024) {
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

    function filehandler(item) {
        var ext = item.split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            item = 1;
        } else {
            item = 0;
        }
        return item;
    }

    function validate(form_id) {
        let invalid = 0;
        $($("#" + form_id).find("select").get().reverse()).each(function() {
            var name = $(this).attr("name");
            var j = clean($(this).attr("name"));
            var nr = $(this).attr("nr");
            var multiple = $(this).attr("multiple");

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
        var saveData = {
            clearForm: false,
            resetForm: false,
            beforeSubmit: function(e) {
                validate("form_save_data" + formId);
                if (valid != 0) {
                    fillIn();
                    return false;
                }
                // $("#modal" + formId + " .tab-content").hide();
                // $("#modal" + formId + " .overlay").show();
                a = $("#form_save_data" + formId + " .submitBtnPrimary").text();
                // if (formId != "GradesList") {
                //     $("#form_save_data" + formId + " .submitBtnPrimary").attr("disabled", true);
                //     $("#form_save_data" + formId + " .submitBtnPrimary").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
                // }
            },
            success: function(data) {
                var d = JSON.parse(data);
                if (d.success == true) {
                    successAlert("Successfully Saved!");
                    if ((formId == "GradesList") || (formId == "GradesPSList")) {} else {
                        $("#modal" + formId).modal('hide');
                        clear_form("form_save_data" + formId);
                    }

                    if (formId == "GradesList") {
                        getGradesListFN();
                    }

                    if (formId == "GradesPSList") {
                        getGradesPSListFN();
                    }

                    if (tblId.length > 1) {
                        for (var i = 0; i < tblId.length; i++) {
                            getTable(tblId[i], dtd, pl);
                        }
                    }
                    tbl ? removeAllItemList("tbl" + tbl) : null;
                    tbl ? $("#btn" + tbl).trigger("click") : null;

                    // if (formId == 'EnrollmentInfo') {
                    //     $('#modalEnrollment').modal('hide');
                    // }
                } else if (d.exist == true) {
                    existAlert("Person already exist!<br/>You can search and add TEST RESULT");
                } else if (d.existCode == true) {
                    existAlert("Code already taken!<br/>by: " + d.existPerson);
                } else if (d.message) {
                    failAlert(d.message);
                } else {
                    failAlert("Something went wrong!");
                }
                // $("#modal" + formId + " .overlay").hide();
                $("#modal" + formId + " .tab-content").show();
                $("#form_save_data" + formId + " .submitBtnPrimary").attr("disabled", false);
                $("#form_save_data" + formId + " .submitBtnPrimary").html(a);
                // getTable("LearnersList", 0, -1);
                getTable("AssignedSectionList", 0, -1);
                // setTimeout(function() {
                // $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                // }, 1500);

            }
        };
        $("#form_save_data" + formId).ajaxForm(saveData);
    }

    function getTable(tableId, dtd, pl, search) {
        $("#modal" + tableId + " .content").hide();
        $("#modal" + tableId + " .overlay").show();
        setTimeout(() => {
            $("#tbl" + tableId).DataTable().destroy();
            var table, table_data = $("#tbl" + tableId).DataTable({
                // "order": [
                //     [0, "asc"]
                // ],
                dom: 'Bfrtip',
                buttons: tableId == 'SearchEnrollLearnersList' ? [{
                        text: "<i class='fa fa-check text-success'></i> Enroll",
                        action: function(e, dt, node, config) {
                            validateTable(tableId);
                        }
                    }] : [] &&
                    tableId == 'LearnersList' ? [{
                        text: "<i class='fa fa-cog'></i> Account",
                        action: function(e, dt, node, config) {
                            validateTable(tableId);
                        }
                    }, {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        header: "_excel"

                    }] : [] &&
                    tableId == 'AllStudentLogs' ? [{
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        header: "_excel"

                    }, {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel"></i> Export Excel',
                        header: "_excel"

                    }] : [],

                searching: ((tableId == "GradesList" || tableId == "GradesPSList") ? false : true),
                // scrollX: true,
                // scrollY: "500px",
                // scrollY: tableId == 'GradesList' ? "500px" : null,
                // scrollCollapse: true,
                "search": {
                    "search": search ?? "",
                },
                "info": pl == -1 ? false : true,
                "paging": pl == -1 ? false : true,
                "ordering": pl == -1 ? false : true,
                "oLanguage": {
                    "sSearch": ""
                },
                language: {
                    searchPlaceholder: "Search...",
                },
                pageLength: pl,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                ajax: {
                    url: "<?= base_url($uri . '/getdata/get') ?>" + tableId,
                    type: "POST",
                    cache: true,
                    data: function(d) {
                        d.rsid = rsid;
                        d.rssaid = rssaid;
                        d.by = $("#searchby").val();
                        d.key = $("#keyword").val();
                    }
                },

                fnInitComplete: function(oSettings, json) {
                    if (tableId == "Honors") {
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                    if (tableId == "AssignedSectionList") {
                        if (rssaid != 0) {
                            $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                        } else {
                            $(".form_save_dataSectionList .slctdRadioAdvisory").attr("checked", true).trigger("click");
                        }
                    }

                    if (tableId == "GradesList") {
                        $("#modal" + tableId + " .q1c").empty();
                        $("#modal" + tableId + " .q2c").empty();
                        $("#modal" + tableId + " .q3c").empty();
                        $("#modal" + tableId + " .q4c").empty();
                        if (json && json["details"]) {
                            if (json["details"]["q1c"]) {
                                $("#modal" + tableId + " .q1c").html(json["details"]["q1c"])
                            }
                            if (json["details"]["q2c"]) {
                                $("#modal" + tableId + " .q2c").html(json["details"]["q2c"])
                            }
                            if (json["details"]["q3c"]) {
                                $("#modal" + tableId + " .q3c").html(json["details"]["q3c"])
                            }
                            if (json["details"]["q4c"]) {
                                $("#modal" + tableId + " .q4c").html(json["details"]["q4c"])
                            }
                        }
                        $('[data-toggle="tooltip"]').tooltip()
                    }

                    if (tableId == "GradesPSList") {
                        $('[data-toggle="tooltip"]').tooltip()
                    }

                    if (tableId == "GradesSMEAList") {
                        // $("#modalDLLearnerGradesSP").modal("show");
                        downloadExcel('tbl' + tableId, filename);

                        $(".downloadform").attr("disabled", false);
                        $(".downloadform").html("<span class=\"fa fa-download\"></span> Download form");
                    }
                    $("#modal" + tableId + " .content").show();
                    $("#modal" + tableId + " .overlay").hide();
                }
            });

            $("#tbl" + tableId).on('draw.dt', function() {
                $(".searchBtn").attr("disabled", false);
                $(".searchBtn").html("<span class=\"fa fa-search\"></span>");
                dtd == 1 ? $("#tbl" + tableId).DataTable().destroy() : "";
                $(".collapse" + tableId).trigger('click');
            });
            $("#tbl" + tableId + "_filter").addClass("row");
            $("#tbl" + tableId + "_filter label").css("width", "99.3%");
            $("#tbl" + tableId + "_filter .form-control-sm").css("width", "99.3%");
        }, 100);
    }

    function validateTable(table_id) {
        var c = $("#tbl" + table_id + ' input:checkbox:checked').length;
        if (c < 1) {
            existAlert("Please Select Person!");
        } else {
            if (table_id == 'SearchEnrollLearnersList') {
                searchBatchEnroll(table_id);
            } else if (table_id == 'LearnersList') {
                $("#modal" + table_id).modal('show');
            }
        }
    }

    function batchUpdateAccount(a) {
        var b = $("#form" + a).serialize();
        var d = $("[name='accountSettings']").val();
        $.post("<?= base_url($uri . "/Dataentry/saveBatchUpdateAccount") ?>", {
                c: b,
                e: d,
            },
            function(data) {
                logsHideShow()
                var d = JSON.parse(data);
                if (d.success == true) {
                    successAlert(d.message);
                    tblReload(a);
                    $("#modalLearnersList").modal('hide');
                    setTimeout(function() {
                        logsHideShow()
                        $("#learnerCheckBox").prop("checked", false);
                    }, 1500);
                    // tblReload('LearnersList');
                    // // tblReload('AssignedSectionList');
                    // // getTable("LearnersList", 0, -1);
                    // getTable("AssignedSectionList", 0, -1);
                    // setTimeout(function() {
                    //     $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                    // }, 1500);
                } else {
                    failAlert(d.message);
                }
            }).done(function() {});
    }

    function searchBatchEnroll(a) {
        var b = $("#form" + a).serialize();
        $.post("<?= base_url($uri . "/Dataentry/saveSearchBatchEnroll") ?>", {
                c: b,
                d: rsid,
            },
            function(data) {
                var d = JSON.parse(data);
                if (d.success == true) {
                    successAlert("Successfully Saved!");
                    tblReload(a);
                    tblReload('LearnersList');
                    // tblReload('AssignedSectionList');
                    // getTable("LearnersList", 0, -1);
                    getTable("AssignedSectionList", 0, -1);
                    setTimeout(function() {
                        $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                    }, 1500);
                } else {
                    failAlert("Something went wrong!");
                }
            }).done(function() {});
    }



    function tblReload(tableId) {
        $("#tbl" + tableId).DataTable().ajax.reload(function() {
            $("." + tableId).hide();
        });
    }

    function getSbjctAssPrsnnlFN(tableId, a, b) {
        grdlvl = a;
        rmid = b;
        tblReload(tableId);
    }

    function getLearnersListFN(tableId, a, b, c, d) {
        rsid = a;
        rssaid = b;
        adviser = c;
        sec_name = d;
        $("." + tableId).show();
        $("#tbl" + tableId + " tbody").empty();
        $("#form_save_dataEnrollmentInfo #ersid").val(a)
        resetHide(tableId);
        tblReload(tableId, c);

        if (adviser == "t") {
            getTable("Honors", 0, -1);
            $(".header1").show();
            // $(".header2").removeClass("col-lg-12");
            // $(".header2").addClass("col-lg-12");
        } else {
            $(".header1").hide();
            // $(".header2").removeClass("col-lg-12");
            // $(".header2").addClass("col-lg-12");
        }
        tblDT = $('#tbl' + tableId).DataTable();
        if (adviser === "t") {
            getTable("LearnersList", 0, -1);
        } else if (tblDT.button().length == 1) {
            tblDT.button(0).destroy();
        }
    }

    function getGradesListFN() {
        $("#form_save_dataGradesList .submitBtnPrimary").attr("disabled", false);
        $("#form_save_dataGradesList .submitBtnPrimary").html("Save Grades");
        getTable("GradesList", 0, -1);
    }

    function getGradesPSListFN() {
        $("#form_save_dataGradesPSList .submitBtnPrimary").attr("disabled", false);
        $("#form_save_dataGradesPSList .submitBtnPrimary").html("Save Grades");
        getTable("GradesPSList", 0, -1);
    }

    function getSbjctAssPrsnnl(tableId) {
        var table, table_data = $("#tbl" + tableId).DataTable({
            "order": [
                [0, "asc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'pageLength',

            ],
            "oLanguage": {
                "sSearch": ""
            },
            language: {
                searchPlaceholder: "Search...",
            },
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
            $("#form_save_data" + tableId + " .select" + tableId).select2();
            grdlvl != 0 ? $("#modal" + tableId).modal('show') : "";
        });
    }

    function allStudentLogs(a) {
        search = a ?? "";
        getTable("AllStudentLogs", 0, 10, search);
        $("#modalAllStudentLogs").modal("show");
    }

    function logsHideShow() {
        $("#tblLearnersList .logs_account").toggle("slow", function() {
            if ($("#tblLearnersList .logs_account").is(":visible")) {
                logsHS = 1
            } else {
                $("#tblLearnersList .normal_view").is(":visible")
                logsHS = 0
            }
        });
        $("#tblLearnersList .normal_view").toggle("slow", function() {
            if ($("#tblLearnersList .normal_view").is(":visible")) {} else {
                $("#tblLearnersList .logs_account").is(":visible")
            }
        });
    }

    function resetHide(t) {
        if (logsHS == 1) {
            logsHideShow();
        }
    }

    function learnerAccnt(a, b) {
        $.post("<?= base_url($uri . '/Dataentry/learnerAccount') ?>", {
                a: a,
                b: b,
            },
            function(data) {
                var result = JSON.parse(data);
                if (result.success == true) {
                    successAlert("Successfully Saved!");
                    getTable("LearnersList", 0, -1);
                    setTimeout(function() {
                        logsHideShow()
                    }, 1500);
                }
            }
        ).then(function() {
            // s2 == 1 ? $("#form_save_data" + formId + " .select" + getList).select2() : "";
        });
    }

    function getLocation(a, b, c) {
        clearLoc(b, c);
        let form = 'form_save_data' + c;
        let d = $('#' + form + ' .select' + a).val();
        let ab = d == '' || d == null ? 0 : d;
        getFetchList(c, b, null, 1, {
            v: ab
        });
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

    $('#import_form').on('submit', function(event) {

        let formData = new FormData(this);
        formData.append('rsid', rsid);

        event.preventDefault();
        // $(".submitBtnUpload").attr("disabled", true);
        $.ajax({
            url: "<?= base_url($uri . '/Dataentry/saveImportEnrollmentInfo'); ?>",
            // method:"POST",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                // getTable("LearnersList", 0, -1);
                getTable("AssignedSectionList", 0, -1);
                // setTimeout(function() {
                //     $(".form_save_dataSectionList #slctRmRadio" + rsid + rssaid).attr("checked", true).trigger("click");
                // }, 1500);
                $('#file').val('');
                successAlert("Successfully Saved!");
            },
            error: function(data) {}
        })
    });

    function customTabViewAllGrades() {
        $("#modalAllGrades .overlay").show();
        $("#modalAllGrades .viewAllGrades").empty();
        if (vars['viewAllGrades' + rsid] != undefined) {
            $("#modalAllGrades .viewAllGrades").html(vars['viewAllGrades' + rsid]);
            $("#modalAllGrades .overlay").hide();
        } else {
            $.get("<?= base_url($uri . "/Getdata/getViewAllGrades") ?>", {
                    a: rsid
                },
                function(data) {
                    var d = JSON.parse(data);
                    vars['viewAllGrades' + rsid] = d;
                    $("#modalAllGrades .viewAllGrades").html(d);
                    $("#modalAllGrades .overlay").hide();
                }).done(function() {});
        }
    }

    function preSbmitGrades(a, b, c) {
        bTmp = b;
        cTmp = c;
        $("#modalLearnersSubmitGrades #qrssa").val(a);
        $("#modalLearnersSubmitGrades").modal("show");
    }

    function submitGrades() {
        validate("form_save_dataSubmitGradesConfirm");
        if (valid != 0) {
            fillIn();
            return false;
        }
        var s = $("#form_save_dataSubmitGradesConfirm").serialize();
        $.post("<?= base_url($uri . '/Dataentry/submitGrades') ?>", {
                c: s,
                e: rssaid
            },
            function(data) {
                var result = JSON.parse(data);
                if (result.success == true) {
                    successAlert(result.message);
                    var rm = $("#modalLearnersSubmitGrades .remarks").val();
                    $("#modalGradesList .q" + bTmp + "c").html('<span ' +
                        " class='badge w-100 text-sm bg-navy' data-toggle='tooltip' data-placement='bottom' data-html='true' title='<em>Message:</em> <b>" + rm + "</b>'>" +
                        "<b>FOR APPROVAL Q" + bTmp + " - " + cTmp + "%</b>" +
                        (rm ? '<i class="fa fa-envelope float-right text-yellow"></i>' : '') +
                        "</span>");
                    $("#modalLearnersSubmitGrades").modal('hide');
                    $("#modalLearnersSubmitGrades .remarks").val("");
                    $('[data-toggle="tooltip"]').tooltip();
                } else if (result.success == false) {
                    failAlert(result.message);
                }
            }
        ).then(function() {});
    }

    function maxInput(a, c) {
        var b = $("#" + a).val();
        if (b > 100 || b == 0) {
            $("#" + a).val("");
        } else {

        }
    }

    // function autoavg(a) {
    //     console.log('a')
    //     $(this).text("zz")
    // }

    $("[type='number']").keydown(function(e) {
        e = e || window.event;
        d = e.keyCode;
        if (d == '38' || d == '40' || d == '189' || d == '187' || d == '69') {
            e.preventDefault();
        }
    });

    function showTableHonors(a) {
        let i;
        let cc = 1;
        $("#tblHonorsList tbody").empty();
        if (a.length > 0) {
            for (i = 0; i < a.length; i++) {
                $("#tblHonorsList tbody").append('<tr>' +
                    '<td>' + cc++ + '.   ' + a[i]["l"] + '</td>' +
                    '<td><center>' + a[i]["g"] + '</center></td>' +
                    '</tr>');
            }
        }
    }

    $(".submitBtnGRADE_SLIP").click(function() {
        // alert(rsid)
        var q = $("#form_report_dataGRADE_SLIP #qrtr").val();
        // console.log(q)
        // console.log("aaaaa")
        var g = "";
        var g = "";
        var c = [];
        var e = "";
        var ee = "";
        var grd_q = "";

        for (m = 0; m < q.length; m++) {
            var qqq = "Q" + q[m];
            grd_q += '<td style="padding:0px;" width="1">' + qqq + '</td>';
        }


        $("#modalGRADE_SLIP #tblGradesList").empty();
        // $(".submitBtnGRADE_SLIP").attr("disabled", true);
        // $(".submitBtnGRADE_SLIP").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        $.get("<?= base_url($uri_reports . "/reports/getGRADE_SLIP") ?>", {
                // sy: $("#form_report_dataGRADE_SLIP [name='sy']").val(),
                // qrtr: q,
                rmsid: rsid,
                // report: $("#form_report_dataGRADE_SLIP [name='report']").val(),
            },
            function(data) {
                var d = JSON.parse(data);
                let z = 0;
                let x = 0;
                for (let i = 0; i < d.length; i++) {
                    x = i;


                    $("#modalGRADE_SLIP #tblGradesList").append('<tr>');
                    for (let j = 1; j <= 7; j++) {
                        y = JSON.parse(d[i]["grades"]);
                        let ga = 0;
                        let cga = 0;
                        for (let k = 0; k < y.length; k++) {
                            if (y[k]["q1"] != null) {
                                for (m = 0; m < q.length; m++) {
                                    var qq = "q" + q[m];
                                    ga += y[k][qq];
                                    cga += 1;
                                    e += '<td style="padding:0px 3px 0px 0px;" align="right">' + y[k][qq] + '</td>'; //y[k][qq];
                                    ee += '<td style="padding:0px 3px 0px 0px;" align="right"><b>' + Math.round((ga / cga), 0) + '</b></td>';
                                }

                                p = y[k]["parent_party_id"]; //$value->parent_party_id;
                                t = (p ? '&emsp;' : "");
                                g += ('<tr><td style="padding:0px 0px 0px 3px;">' + t + y[k]["subject_abbr"] + '</td>' + e + '</tr>');
                                if (k == (y.length - 1)) {
                                    g += ('<tr><td style="padding:0px 0px 0px 3px;"><b> AVERAGE </b></td>' + ee + '</tr>');
                                }
                                e = "";
                                ee = "";
                            }
                        }
                        i++;
                        // console.log(i)
                        g_s = d[i - 1]["grade"] + ' - ' + d[i - 1]["sctn_nm"];
                        if (d.length <= i) {
                            break;
                        } else {
                            $("#modalGRADE_SLIP #tblGradesList").append(
                                '<td>' +
                                '<table width="100%" cellspacing="0" style="font-size:10px;border:1.5px dashed #B2B5B8;">' +
                                '<tr><td style="padding:0px;font-size:8px;" colspan="5">' +
                                '<div class="row">' +
                                '<div class="col-2 pl-2" align="center"><img src="<?= $system_svg_1x1 ?>" width="23" height="23"/></div>' +
                                '<div class="col-10">Republic of the Philippines<br>' +
                                '<strong>Agusan National High School</strong><br>' +
                                'Butuan City' +
                                '</div></div>' +
                                '</td></tr>' +
                                '<tr><td style="padding:1px;font-size:8px;" colspan="5">' + g_s + '  |  <?= $sy_; ?>  - Q-' + q + '<br/><b>' + d[i - 1]["lrn"] + '</b></td></tr>' +
                                '<tr><td style="padding:1px;" colspan="5"><b>' + d[i - 1]["last_fullname"] + '</b></td></tr>' +
                                '<tr><td style="padding:0px;">Learing Areas</td>' + grd_q + '</tr>' + g +
                                '</table>' +
                                '</td>');
                            g = "";
                        }
                    }
                    g = "";

                    i--;
                    $("#modalGRADE_SLIP #tblGradesList").append('</tr>');

                }
                // console.log(d[0])
                // console.log(d)
                // JHS GRADE_SLIP DATA FOR THE 4th QUARTER S.Y 2021 - 2022
                $("#modalGRADE_SLIP .header").html("GRADES SLIP AS OF SY: 2020-2019 Q:" + q)
                $("#modalGRADE_SLIP").modal("show");
                // $("#modalGRADE_SLIP .viewGRADE_SLIP").html(d);
                $(".submitBtnGRADE_SLIP").attr("disabled", false);
                $(".submitBtnGRADE_SLIP").html("<span class='fa fa-search'></span>");
            }).done(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

    });


    $(".submitBtnPreviewID").click(function() {
        // alert(rsid)
        var q = $("#form_report_dataGRADE_SLIP #qrtr").val();
        var g = "";
        var g = "";
        var c = [];
        var e = "";
        var ee = "";
        var grd_q = "";

        for (m = 0; m < q.length; m++) {
            var qqq = "Q" + q[m];
            grd_q += '<td style="padding:0px;" width="1">' + qqq + '</td>';
        }

        $("#modalPreviewID #tblPreviewID").empty();
        // $(".submitBtnPreviewID").attr("disabled", true);
        // $(".submitBtnPreviewID").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        $.get("<?= base_url($uri_reports . "/reports/getPreviewID") ?>", {
                // sy: $("#form_report_dataGRADE_SLIP [name='sy']").val(),
                // qrtr: q,
                rmsid: rsid,
                // report: $("#form_report_dataGRADE_SLIP [name='report']").val(),
            },
            function(data) {
                var d = JSON.parse(data);
                let z = 0;
                let x = 0;
                for (let i = 0; i < d.length; i++) {
                    x = i;


                    $("#modalPreviewID #tblPreviewID").append('<tr>');
                    for (let j = 1; j <= 1; j++) {
                        // y = JSON.parse(d[i]["grades"]);
                        // let ga = 0;
                        // let cga = 0;
                        // for (let k = 0; k < y.length; k++) {
                        //     if (y[k]["q1"] != null) {
                        //         for (m = 0; m < q.length; m++) {
                        //             var qq = "q" + q[m];
                        //             ga += y[k][qq];
                        //             cga += 1;
                        //             e += '<td style="padding:0px 3px 0px 0px;" align="right">' + y[k][qq] + '</td>'; //y[k][qq];
                        //             ee += '<td style="padding:0px 3px 0px 0px;" align="right"><b>' + Math.round((ga / cga), 0) + '</b></td>';
                        //         }

                        //         p = y[k]["parent_party_id"]; //$value->parent_party_id;
                        //         t = (p ? '&emsp;' : "");
                        //         g += ('<tr><td style="padding:0px 0px 0px 3px;">' + t + y[k]["subject_abbr"] + '</td>' + e + '</tr>');
                        //         if (k == (y.length - 1)) {
                        //             g += ('<tr><td style="padding:0px 0px 0px 3px;"><b> AVERAGE </b></td>' + ee + '</tr>');
                        //         }
                        //         e = "";
                        //         ee = "";
                        //     }
                        // }
                        // alert(i)
                        // i++;
                        let ji = i;
                        // console.log(i)
                        g_s = d[ji]["grade"] + ' - ' + d[ji]["sctn_nm"];
                        let lrn = d[ji]["lrn"];
                        let img_path = d[ji]["img_path"];
                        let full_name = d[ji]["full_name"];
                        let birthdate = d[ji]["birthdate"];
                        let g_sec = d[ji]["grade"] +' - '+ d[ji]["sctn_nm"];
                        let advisory = d[ji]["advisory"];
                        let add_details = d[ji]["address_details"];
                        let other_details = d[ji]["other_details"];
                        let od = JSON.parse(other_details);
                        // console.log(od)
                        // alert(i)
                        // if (d.length <= i) {
                        //     break;
                        // } else {
                            $("#modalPreviewID #tblPreviewID").append(
                                '<td align="left" width="50%" class="p-2" style="border: 1px dashed #000;">' +
                                    '<table width="100%" cellspacing="0" style="font-size:10px;border:2.5px solid #3786A3;background-image: url(<?= $system_bg_id ?>);background-repeat: no-repeat;background-size: cover;">' +
                                        '<tr align="center" style="font-size:12px;color: rgba(0, 0, 0, 0);">' +
                                            '<td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="4" rowspan="6" style="vertical-align: middle; text-align: center;"><img src="<?= $system_deped_1x1 ?>" width="65" height="65"/></td>' +
                                            '<td colspan="12" style="padding:0px;font-weight:bold;font-family:Old English Text MT;font-size:15px;">Republic of the Philippines</td>' +
                                            '<td colspan="4" rowspan="6" style="vertical-align: middle; text-align: center;"><img src="<?= $system_depeddiv_1x1 ?>" width="65" height="65"/></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="12" style="padding:0px;font-weight:bold;font-family:Open Sans;font-size:14px;">DEPARTMENT OF EDUCATION</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="12" style="padding:0px;font-weight:bold;font-family:Calibri;font-size:14px;">Division of Butuan City</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="12" style="padding:0px;font-weight:bold;font-family:Book Antiqua;font-size:17px;">AGUSAN NATIONAL HIGH SCHOOL</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="12" style="padding:0px;font-family:Open Sans;font-size:14px;">A.D. Curato St., Butuan City, 8600 Philippines</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="12" style="padding:0px;font-family:Calibri;font-size:14px;">School ID: <b>304756</b></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="20" style="padding:2px;"> </td>' +
                                        '</tr>' +

                                        
                                        
                                        //PICTURE
                                        '<tr>'+
                                            '<td colspan="20">'+
                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td colspan="8" rowspan="11" style="border:3px solid #000;height:14.3rem; width:10rem; padding:0px; vertical-align: middle; text-align: center;">'+
                                                        '<img style="width:100%;height:100%;" src="'+img_path+'" alt="Image" />'+
                                                    '</td>' +
                                                    '<td> </td>' +
                                                    '<td> </td>' +
                                                    '<td colspan="8"> </td>' +
                                                '</tr>' +
                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td> </td>' +
                                                    '<td> </td>' +
                                                    '<td colspan="7" rowspan="8" style="padding:0px; vertical-align: middle; text-align: center;">' +
                                                        '<img style="width:125px;height:125px;" src="<?= $system_svg_1x1 ?>" alt="Image" />'+
                                                    '</td>' +
                                                    '<td></td>' +
                                                '</tr>' +
                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                '</tr>' +
                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                '</tr>' +
                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                '</tr>' +
                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                '</tr>' +
                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                '</tr>' +
                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                '</tr>' +
                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                '</tr>' +

                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td colspan="7" style="border:1px solid #000;padding:0px;vertical-align:middle;font-size:18px;background-color:#fff;">'+lrn+'</td>' +
                                                    '<td> </td>' +
                                                '</tr>' +
                                                '<tr align="center">' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    '<td></td>' +
                                                    // '<td colspan="6" style="padding:0px"><svg class="bbbb' + i + '" style="width:2rem;height:2rem;padding:0px;"></svg></td>' +
                                                    // '<td colspan="7" style="padding:0px"><canvas class="barcode" class="bbbb' + i + '" style="width:100%;height:1.2rem;padding:0px;"></canvas></td>' +
                                                    '<td colspan="7" style="padding:1px"><img id="bbbb1' + i + '" alt="Barcode Image" width="100%" height="25"></td>' +
                                                    '<td> </td>' +
                                                '</tr>' +
                                            '</td>' +
                                        '</tr>' +
                                        //PICTURE

                                        '<tr">' +
                                            '<td colspan="20"> </td>' +
                                        '</tr>' +
                                        '<tr align="left">' +
                                            '<td></td>' +
                                            '<td colspan="18" style="padding:0px;font-weight:bold;font-family:Open Sans;font-size:25px;">'+full_name+'</td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="left">' +
                                            '<td colspan="14"></td>' +
                                            '<td rowspan="3" colspan="5" style="border:1px solid #000;background-color: #fff;"></td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="left">' +
                                            '<td></td>' +
                                            '<td colspan="13" style="padding:0px;font-family:Open Sans;font-size:19px;">Birthdate: <u>&nbsp;'+birthdate+'&nbsp;</u></td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="left">' +
                                            '<td colspan="14"></td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="left">' +
                                            '<td></td>' +
                                            '<td colspan="13" style="padding:0px;font-family:Open Sans;font-size:19px;">Grade & Section: <u>&nbsp;'+g_sec+'&nbsp;</u></td>' +
                                            '<td colspan="5" style="vertical-align: top; text-align: center;padding:0px;">Signature</td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="left">' +
                                            '<td colspan="14"></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="left">' +
                                            '<td></td>' +
                                            '<td colspan="13" style="padding:0px;font-family:Open Sans;font-size:19px;">Program: <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u></td>' +
                                            '<td colspan="5" style="border:1px solid #000; vertical-align: middle; text-align: center;padding:0px;background-color:#0062A7;color:#fff;">SCHOOL YEAR<br/>VALIDATION</td>' +
                                            // '<td colspan="5" style="border:1px solid #000; vertical-align: middle; text-align: center;padding:0px;">SCHOOL YEAR<br/>VALIDATION</td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                            '<td colspan="14"></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="left">' +
                                            '<td></td>' +
                                            '<td colspan="13" style="padding:0px;font-family:Open Sans;font-size:19px;" height="20">Adviser: <u>&emsp;'+advisory+'&emsp;</u></td>' +
                                            '<td colspan="5" style="border: 1px solid #000;text-align:center;">|</td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="14"></td>' +
                                            '<td colspan="5" style="border: 1px solid #000;text-align:center;" height="20">|</td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="20"> </td>' +
                                        '<tr align="center">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="8" class="image-cell" style="border-bottom:1px solid #000;position:relative;"> '+
                                                '<img style="width:120;height:50px;position: absolute;left:25%;top:-5px;" src="<?= $system_esig ?>" alt="Image" />'+
                                            '</td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="8" style="padding:0px;font-size:19px;">'+
                                                'DENNIS R. ROA, DPA'+
                                            '</td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="8" style="padding-top:0px;font-size:12px;">PRINCIPAL IV</td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr style="font-size:15px;">' +
                                            '<td colspan="20"> </td>' +
                                        '</tr>' +
                                    '</table>' +
                                '</td>' +

                                '<td align="right" width="50%" class="p-2" style="border: 1px dashed #000;">' +
                                    '<table width="100%" cellspacing="0" style="font-size:10px;border:2.5px solid #3786A3;background-image: url(<?= $system_bg_id ?>);background-repeat: no-repeat;background-size: cover;">' +
                                        '<tr align="center" style="font-size:12px;color: rgba(0, 0, 0, 0);">' +
                                            '<td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td><td>aa</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="4" rowspan="6" style="vertical-align: middle; text-align: center;"><img src="<?= $system_deped_1x1 ?>" width="65" height="65"/></td>' +
                                            '<td colspan="12" style="padding:0px;font-weight:bold;font-family:Old English Text MT;font-size:15px;">Republic of the Philippines</td>' +
                                            '<td colspan="4" rowspan="6" style="vertical-align: middle; text-align: center;"><img src="<?= $system_depeddiv_1x1 ?>" width="65" height="65"/></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="12" style="padding:0px;font-weight:bold;font-family:Open Sans;font-size:14px;">DEPARTMENT OF EDUCATION</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="12" style="padding:0px;font-weight:bold;font-family:Calibri;font-size:14px;">Division of Butuan City</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="12" style="padding:0px;font-weight:bold;font-family:Book Antiqua;font-size:17px;">AGUSAN NATIONAL HIGH SCHOOL</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="12" style="padding:0px;font-family:Open Sans;font-size:14px;">A.D. Curato St., Butuan City, 8600 Philippines</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="12" style="padding:0px;font-family:Calibri;font-size:14px;">School ID: <b>304756</b></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="20" style="padding:2px;"> </td>' +
                                        '</tr>' +



                                        '<tr align="center">' +
                                            '<td colspan="6"></td>' +
                                            // '<td colspan="8" rowspan="11" style="height:12rem; text-align: center;padding-left:7.5%;"><div id="qqqq'+i+'" style="text-align:center;width:100%;height:100%;"></div></td>' +
                                            '<td colspan="8" rowspan="11" style="height:12rem; text-align: center;padding-left:7.5%;"><img id="bbbb0' + i + '" alt="Barcode Image" width="100%" height="100%"></td>' +
                                            
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr">' +
                                            '<td colspan="20"> </td>' +
                                        '</tr>' +
                                        '<tr align="left">' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td colspan="18" style="font-weight:bold;font-family:Open Sans;font-size:12px;">IN CASE OF EMERGENCY, PLEASE NOTIFY:</td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td></td>' +
                                            '<td colspan="18" style="border:1px solid black;">'+
                                                '<p class="my-n1" style="padding:0px;font-weight:bold;font-family:Open Sans;font-size:25px;">'+od['incase_emergency']+'</p>'+
                                                '<p class="my-n1" style="padding:0px;font-weight:bold;font-family:Open Sans;font-size:20px;">'+od['relation']+'</p>'+
                                                '<p class="my-n1" style="padding:0px;font-weight:bold;font-family:Open Sans;font-size:20px;">'+od['contact_number']+'</p>'+
                                                '<p class="my-n1" style="padding:0px;font-weight:bold;font-family:Open Sans;font-size:19px;">'+add_details+'</p>'+
                                            '</td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="20"> </td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td></td>' +
                                            '<td colspan="18" style="padding:0px;font-weight:bold;font-family:Open Sans;font-size:12px;">'+
                                                '<p>THIS CERTIFIES THAT THE PERSON WHOSE PHOTO APPEARS ON<br/>'+
                                                 'THIS IDENTIFICATION CARD IS A BONAFIDE STUDENT OF<br/>'+
                                                 'AGUSAN NATIONAL HIGH SCHOOL. THE CARD IS  VALID</br>'+
                                                 'FOR THE SCHOOL YEAR REFLECTED IN THE CARD.</p>'+
                                            '</td>' +
                                            '<td></td>' +
                                        '</tr>' +
                                        '<tr align="left">' +
                                            '<td colspan="20" style="font-weight:bold;font-family:Open Sans;font-size:6px;"> </td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="8" class="image-cell" style="border-bottom:1px solid #000;position:relative;"> '+
                                                '<img style="width:120;height:50px;position: absolute;left:25%;top:-5px;" src="<?= $system_esig ?>" alt="Image" />'+
                                            '</td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="8" style="padding:0px;font-size:19px;">DENNIS R. ROA, DPA</td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr align="center">' +
                                            '<td colspan="6"></td>' +
                                            '<td colspan="8" style="padding-top:0px;font-size:12px;">PRINCIPAL IV</td>' +
                                            '<td colspan="6"></td>' +
                                        '</tr>' +
                                        '<tr style="font-size:15px;">' +
                                            '<td colspan="20"> </td>' +
                                        '</tr>' +
                                    '</table>' +
                                '</td>');
                            g = "";
                        // }
                        QR_BAR_Generator(i,od['learner_uuid'],lrn)
                    }
                    g = "";

                    // i--;
                    $("#modalPreviewID #tblPreviewID").append('</tr>');

                }
                // console.log(d[0])
                // console.log(d)
                // JHS PreviewID DATA FOR THE 4th QUARTER S.Y 2021 - 2022
                $("#modalPreviewID .header").html("STUDENT ID AS OF SY:  <?= $sy_; ?>  Q:" + q)
                $("#modalPreviewID").modal("show");
                // $("#modalPreviewID .viewPreviewID").html(d);
                $(".submitBtnPreviewID").attr("disabled", false);
                $(".submitBtnPreviewID").html("<span class='fa fa-search'></span>");                
            }).done(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

    });

    function QR_BAR_Generator(a,b,c) {
        // var qrcode = new QRCode(document.getElementById("qqqq"+a), {
        //     text: b,
        //     height: 185,
        //     width: 187,
        // });
        JsBarcode("#bbbb1"+a, '1'+c, { pixelRatio: 100 ,displayValue: false});
        JsBarcode("#bbbb0"+a, '0'+c, { pixelRatio: 100 ,displayValue: false});
        // JsBarcode("#bbbb"+a, c,{displayValue: false});
        // $("#bbbb"+a).attr('src', z);
    }

    var invalidChars = [
        "-",
        "+",
        "e",
    ];

    function clean(a) {
        var str = a;
        return str.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
    }

    function cleanInt(a) {
        var str = a;
        return str.replace(/\D/g, '');
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
        // var table = $("#tblPreviewID").DataTable();
        var orientation = (b == 'p' ? 'portrait' : 'landscape');
        var margin = (c == 'Legal' ? 'margin:3mm 3mm 3mm 3mm;' : 'margin:3mm 3mm 3mm 3mm;');
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
        accompWindow.document.write('<style> @page { size: ' + c + ' ' + orientation + ';' + margin + '} </style>');
        accompWindow.document.write('<body>' + $("#print" + a).html() + '</body>');
        accompWindow.document.write('</html>');
        setTimeout(function() {
            accompWindow.print();
            accompWindow.close();
        }, 1000);
        // table.draw();
        // window.print();
    }

    function downloadExcel(a, b) {
        // var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
        $('#' + a).table2excel({
            //exclude: ".noExl",
            name: b,
            filename: b + new Date().toISOString().replace(/[\-\:\.]/g, ""),
            fileext: ".xls",
            exclude_img: false,
            exclude_links: false,
            exclude_inputs: false,
            preserveColors: true
        });
    }

    function generatePDF() {
        // var docDefinition = {
        //     content: [{
        //         table: {
        //             // headers are automatically repeated if the table spans over multiple pages
        //             // you can declare how many rows should be treated as headers
        //             headerRows: 1,
        //             widths: ['*', 'auto', 100, '*'],

        //             body: $("#tblLearnersList tbody").html()
        //         }
        //     }]
        // };
        // open the PDF in a new window
        // pdfMake.createPdf(docDefinition).open();

        // // print the PDF
        // pdfMake.createPdf(docDefinition).print();

        // download the PDF
        // pdfMake.createPdf(docDefinition).download('optionalName.pdf');
    }

    //ranking

    function changeArr(input, N) {
        // Copy input array into newArray
        var newArray = JSON.parse(JSON.stringify(input));

        // Sort newArray[] in ascending order
        newArray.sort((a, b) => a - b);

        var i;

        // Map to store the rank of
        // the array element
        var ranks = new Map();

        var rank = 1;

        for (var index = 0; index < N; index++) {

            var element = newArray[index];

            // Update rank of element
            if (!ranks.has(element)) {
                ranks.set(element, rank);
                rank++;
            }
        }

        // Assign ranks to elements
        for (var index = 0; index < N; index++) {
            var element = input[index];
            input[index] = ranks.get(input[index]);
        }
        return input;
    }


    //reports
    function reportsConsoGrades() {
        mdl = 'modalReportConsoGrades';
        $("#" + mdl + " .content").hide();
        $("#" + mdl + " .overlay").show();
        $("#tblReportConsoGrades tbody").empty();
        $.post("<?= base_url($uri . '/reports/getReportConsoGrades') ?>", {
                rsid: rsid
            },
            function(data) {
                var result = JSON.parse(data);
                $("#tblReportConsoGrades tbody").append("<tr>" + result["thead"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr>" + result["thead2"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr>" + result["tbody"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr width='100%'>" + result["signatory1"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr width='100%'>" + result["signatory2"] + "</tr>");
                $("#tblReportConsoGrades tbody").append("<tr width='100%'>" + result["signatory3"] + "</tr>");
            }
        ).then(function() {
            var arr1 = [],
                arr2 = [],
                arr3 = [],
                arr4 = [],
                avg = [];
            $("#tblReportConsoGrades .q1TBRank").each(function() {
                arr1.push((parseInt($(this).html())) * -1);
            });

            $("#tblReportConsoGrades .q2TBRank").each(function() {
                arr2.push((parseInt($(this).html())) * -1);
            });

            $("#tblReportConsoGrades .q3TBRank").each(function() {
                arr3.push((parseInt($(this).html())) * -1);
            });

            $("#tblReportConsoGrades .q4TBRank").each(function() {
                arr4.push((parseInt($(this).html())) * -1);
            });

            $("#tblReportConsoGrades .avgTBRank").each(function() {
                avg.push((parseInt($(this).html())) * -1);
            });

            var N1 = arr1.length,
                N2 = arr2.length,
                N3 = arr3.length,
                N4 = arr4.length,
                N5 = arr4.length;
            arr1 = changeArr(arr1, N1);
            arr2 = changeArr(arr2, N2);
            arr3 = changeArr(arr3, N3);
            arr4 = changeArr(arr4, N4);
            avg = changeArr(avg, N5);
            var i1 = 0,
                i2 = 0,
                i3 = 0,
                i4 = 0,
                i5 = 0;
            $("#tblReportConsoGrades .q1Rank").each(function() {
                $(this).html(arr1[i1++]);
            });
            $("#tblReportConsoGrades .q2Rank").each(function() {
                $(this).html(arr2[i2++]);
            });
            $("#tblReportConsoGrades .q3Rank").each(function() {
                $(this).html(arr3[i3++]);
            });
            $("#tblReportConsoGrades .q4Rank").each(function() {
                $(this).html(arr4[i4++]);
            });
            $("#tblReportConsoGrades .avgRank").each(function() {
                $(this).html(avg[i5++]);
            });

            $("#" + mdl + " .content").show();
            $("#" + mdl + " .overlay").hide();


            // $('#tblReportConsoGrades').DataTable({
            //     dom: 'Bfrtip',
            //     buttons: [{
            //         extend: 'pdfHtml5',
            //         orientation: 'landscape',
            //         pageSize: 'LEGAL'
            //     }]
            // });
        });
        $("#" + mdl).modal("show");
    }


    function uploadFile(a, b, c) {
        //Reference the FileUpload element.
        var fileUpload = $("#" + a + " #" + b)[0];

        //Validate whether File is valid Excel file.
        var regex = /(.xls|.xlsx)$/;
        // console.log(fileUpload)
        // console.log(regex.test(fileUpload.value.toLowerCase()))
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof(FileReader) != "undefined") {
                var reader = new FileReader();

                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function(e) {
                        ProcessExcel(e.target.result, c);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function(e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 1; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        ProcessExcel(data, c);
                    };
                    reader.readAsText(fileUpload.files[0]);
                }
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid Excel file.");
        }
        // console.log($("#" + c).html())

        // $('#' + c + ' #gradeLearner1320261403231').val(1)
        // $('#' + c + ' #gradeLearner1320231300522').val(1)


        // var tb = $('#' + c + ':eq(0) tbody');
        // var size = tb.find("tr").length;
        // console.log("Number of rows : " + size);
        // tb.find("tr").each(function(index, element) {
        //     var colSize = $(element).find('td').length;
        //     console.log("  Number of cols in row " + (index + 1) + " : " + colSize);
        //     $(element).find('td center input').each(function(index, element) {
        //         var colVal = $(element).text();
        //         // console.log(element.val())
        //         console.log(element)
        //         console.log(element.value = 1)
        //         // console.log("    Value in col " + (index + 1) + " : " + colVal.trim());
        //     });
        // });
        fileUpload = null;
        $("#" + a + " #" + b).val("");
        $("#" + a + " ." + b).text("Choose file");
        customFile
    }

    function ProcessExcel(data, c) {
        //Read the Excel File data.
        var workbook = XLSX.read(data, {
            type: 'binary'
        });


        // //Fetch the name of First Sheet.
        var firstSheet = workbook.SheetNames[0];
        // //Read all rows from First Sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
        // //Create a HTML Table element.
        // var table = $("<table />");
        // table[0].border = "1";

        // //Add the header row.
        // var row = $(table[0].insertRow(-1));

        // //Add the header cells.
        // var headerCell = $("<th />");
        // headerCell.html("No");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("LRN");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("Name");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("Q1");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("Q2");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("Q3");
        // row.append(headerCell);

        // var headerCell = $("<th />");
        // headerCell.html("Q4");
        // row.append(headerCell);

        //Add the data rows from Excel file.
        // console.log('zzzz')
        // console.log(excelRows)
        // console.log(excelRows.length)
        for (var i = 1; i < excelRows.length; i++) {
            //Add the data row.
            // var row = $(table[0].insertRow(-1));

            //Add the data cells.
            // var cell = $("<td />");
            // cell.html(excelRows[i].No);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Lrn);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Name);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Q1);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Q2);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Q3);
            // row.append(cell);

            // cell = $("<td />");
            // cell.html(excelRows[i].Q4);
            // row.append(cell);

            // __EMPTY: "No"
            // __EMPTY_1: "Lrn"
            // __EMPTY_2: "Name"
            // __EMPTY_3: "Q1"
            // __EMPTY_4: "Q2"
            // __EMPTY_5: "Q3"
            // __EMPTY_6: "Q4"
            // __EMPTY_7: "|"
            // __EMPTY_8: " Q1 "
            // __EMPTY_9: " Q2 "
            // __EMPTY_10: " Q3 "
            // __EMPTY_11: " Q4 "

            // console.log(excelRows[i].Lrn)
            var lrn = cleanInt(excelRows[i].Lrn);
            $('#tblGradesList #gradeLearner' + lrn + '1').val(excelRows[i].Grades_Entry_Data)
            $('#tblGradesList #gradeLearner' + lrn + '2').val(excelRows[i].__EMPTY)
            $('#tblGradesList #gradeLearner' + lrn + '3').val(excelRows[i].__EMPTY_1)
            $('#tblGradesList #gradeLearner' + lrn + '4').val(excelRows[i].__EMPTY_2)

            $('#tblGradesPSList #gradeLearner' + lrn + '1').val(excelRows[i].Percentage_Score_Data)
            $('#tblGradesPSList #gradeLearner' + lrn + '2').val(excelRows[i].__EMPTY_3)
            $('#tblGradesPSList #gradeLearner' + lrn + '3').val(excelRows[i].__EMPTY_4)
            $('#tblGradesPSList #gradeLearner' + lrn + '4').val(excelRows[i].__EMPTY_5)
        }

        // var dvExcel = $("#dvExcel");
        // dvExcel.html("");
        // dvExcel.append(table);
    };
</script>