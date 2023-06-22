<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?= base_url() ?>plugins/jquery/jquery.form.min.js"></script>
<?php
if (!$this->session->schoolmis_login_level) {
    redirect(base_url('login'));
}
$uri = 'userteacher'; //$this->session->schoolmis_login_uri;
?>
<style>
    @media (min-width: 992px) {
        .modal-xxl {
            max-width: 90%;
        }
    }
</style>

<!-- <div class="modal fade show" id="modal-default" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalReportConsoGrades" data-backdrop="static">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header no-print">
                <h4 class="modal-title">Consolidated Grades <?= $getOnLoad["sy"]; ?></h4>
                <div class='radioBtn btn-group pull-right content'>
                    <button type="submit" onclick="printForm('ConsoGrades','l','Legal','Inventory details & Purchase Order');" class="btn btn-xs btn-primary submitBtnPrimary btn-xs content"><i class="fa fa-print"></i> Print</button>
                    <button type="submit" onclick="downloadExcel('tblReportConsoGrades','Consolidated Grades');" class="btn btn-xs bg-green submitBtnPrimary"><i class="fas fa-file-excel"></i> Export</button>
                    <button type="button" class="btn btn-xs btn-sm btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="modal-body p-0 content" id="printConsoGrades">
                <div class="table-responsive col-md-12 text-center">
                    <!-- tblReportConsoGradesz -->
                    <table border="1" id="tblReportConsoGrades" width="100%">
                        <!-- <table class="table table-sm table-bordered table-hover table-striped" id="tblReportConsoGrades" width="100%"> -->
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between content">
                <!-- <button type="submit" onclick="printForm('ConsoGrades','l','Legal','Consolidated Grades');" class="btn btn-primary submitBtnPrimary"><i class="fa fa-print"></i> Print</button> -->
                <button type="submit" onclick="downloadExcel('tblReportConsoGrades','Consolidated Grades');" class="btn btn-xs bg-green submitBtnPrimary"><i class="fas fa-file-excel"></i> Export</button>
                <!-- <button type="submit" onclick="downloadExcel('tblReportConsoGrades','Consolidated Grades');" class="btn bg-green submitBtnPrimary"><i class="fas fa-file-excel"></i> Export</button> -->
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
            <div class="overlay">
                <i class="fas fa-spin text-white fa-3x fa-circle-notch"></i>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalGRADE_SLIP">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header no-print">
                <h4 class="modal-title header"></h4>
                <div class='radioBtn btn-group pull-right'>
                    <button type="submit" onclick="printForm('GRADE_SLIP','l','Legal','GRADE_SLIP');" class="btn btn-info submitBtnPrimary btn-xs"><i class="fa fa-print"></i> Print</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="modal-body p-2" id="printGRADE_SLIP">
                <div class="card card-navy p-0 mb-1 table-responsive viewGRADE_SLIP" style="overflow: auto;">

                    <table class="table table-sm table-hover table-striped table-bordered" id="tblGradesList" width="100%">
                        <!-- <thead style="text-align: center;font-weight: bold;">
                            <tr>
                                <td rowspan="2" class="pt-3" width="400">Learing Areas</td>
                                <td colspan="4">Quarter</td>
                                <td rowspan="2" width="1">Final Grade</td>
                                <td rowspan="2" class="pt-3" width="1">Remarks</td>
                                <td rowspan="2" class="pt-3" width="400">Learing Areas</td>
                                <td colspan="4">Quarter</td>
                                <td rowspan="2" width="1">Final Grade</td>
                                <td rowspan="2" class="pt-3" width="1">Remarks</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                        </thead> -->
                        <!-- <tbody>
                             <tr>
                                <td>a</td>
                                <td>a</td>
                                <td>a</td>
                                <td>a</td>
                            </tr> 
                        </tbody> -->
                    </table>

                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" onclick="printForm('GRADE_SLIP','l','Legal','GRADE_SLIP');" class="btn btn-info submitBtnPrimary"><i class="fa fa-print"></i> Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalPreviewID">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header no-print">
                <h4 class="modal-title header"></h4>
                <div class='radioBtn btn-group pull-right'>
                    <button type="submit" onclick="printForm('PreviewID','p','A4','PreviewID');" class="btn btn-info submitBtnPrimary btn-xs"><i class="fa fa-print"></i> Print</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="card card-navy py-2 mb-1 viewPreviewID" style="overflow: auto;padding: 0 4.2rem 0 4.2rem;">
                <div class="modal-body p-2" id="printPreviewID" style="overflow: auto; width:1000px;">
                    <table id="tblPreviewID" class="table-responsive" width="100%">
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" onclick="printForm('PreviewID','p','A4','PreviewID');" class="btn btn-info submitBtnPrimary"><i class="fa fa-print"></i> Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalLearnersSF1" data-backdrop="static">
    <div class="modal-dialog">
        <form id="form_save_">
            <div class="modal-content">
                <div class="modal-header bg-default p-2">
                    <h5 class="modal-title p-0"><span class="fa fa-folder-open"></span> Form 1 </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <h5><strong class='lrn'></strong></h5>
                    <input name="details" hidden />
                    <p class="lead">
                        <strong class="last_fullname"></strong>
                    </p>
                    <input type="password" name="password" class="form-control passwordUnenroll submitBtnPrimary" placeholder="Enter Password" />

                    <div class="alert alert-warning alert-dismissible mt-3 mb-0 pr-3">
                        <h5><i class="icon fas fa-info"></i> Please read!</h5>
                        Inputted <b>GRADES</b> will be <b>DELETED</b> also.
                    </div> -->
                </div>
                <div class="modal-footer p-1">
                    <!-- <button type="button" class="btn btn-default btn-xs btn-block submitBtnPrimary" onclick="unenroll();">Unenroll Student</button> -->
                    <!-- <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                </div>
            </div>
        </form>
    </div>
</div>