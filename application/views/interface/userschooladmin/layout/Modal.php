<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?= base_url() ?>plugins/jquery/jquery.form.min.js"></script>
<?php
if (!$this->session->schoolmis_login_level) {
    redirect(base_url('login'));
}
$uri = $this->session->schoolmis_login_uri;
?>
<div class="modal fade" id="modalSbjctAssPrsnnl" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title p-0 mb-n3 mt-n1">
                    <!-- <label>XII - DURIAN</label> -->
                    <small>Subject Assignment details</small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url($uri . '/Dataentry/saveSbjctAssPrsnnl'), 'id=form_save_dataSbjctAssPrsnnl'); ?>
            <div class="modal-body">
                <input type="text" name="rmsecid" hidden />
                <div class="card-body p-0 mb-n3">
                    <div class="table-responsive table-hover">
                        <table id="tblSbjctAssPrsnnl" style="width:100%;" class="table table-sm table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="300"><i class='fa fa-book'></i> Subject</th>
                                    <th><i class='fa fa-user'></i> Assigned Personnel<i class='fa fa-check float-right'></i></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <!-- <table class="table" id="tblSbjctAssPrsnnl">
                            <thead>
                                <tr>
                                    <th width="1">#</th>
                                    <th width="80"><i class='fa fa-briefcase'></i> Subject</th>
                                    <th><i class='fa fa-user'></i> Personnel</th>
                                    <th width="200"><i class='fa fa-lock'></i> Advisory</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <th style="width:30%;padding-left:0px;font-size:20px;">Araling Panlipunan:</th>
                                    <td>a</td>
                                </tr>
                            </tbody>
                        </table> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-info submitBtnPrimary">Save Data</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <!-- <button type="button" class="btn btn-default float-right" ><i class="fa fa-times"></i> Cancel</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- <div class="modal fade show" id="modalSbjctAssPrsnnl" aria-modal="true" style="padding-right: 16px; display: block;"> -->

<div class="modal fade" id="modalPersonnelAccount" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-info py-1 px-2">
                <h5 class="modal-title">
                    <small><i class='fa fa-user'></i> User Account details</small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url($uri . '/Dataentry/savePersonnelAccount'), 'id=form_save_dataPersonnelAccount'); ?>
            <div class="modal-body p-2">
                <input type="text" name="userId" nr="1" hidden />
                <input type="text" name="basicInfoId" hidden />
                <input type="text" name="personnelId" hidden />
                <div class="card-body p-0">
                    <div class="table-responsive table-hover">
                        <div class="col-12">
                            <span class='badge bg-navy personName'></span>
                            <div class="input-group mt-2 mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text firstName"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="email" placeholder="EMAIL ADDRESS" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-2">
                                <!-- <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                </div> -->
                                <select class="form-control form-control-sm select2 selectRoleList" data-placeholder="SELECT ROLE" name="role" style="width:100%;" onchange="($(this).val()==4||$(this).val()==6)?$('.selectDepartmentListV').slideUp():$('.selectDepartmentListV').slideDown();">
                                </select>
                            </div>
                        </div>

                        <div class="col-12 selectDepartmentListV">
                            <!-- <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                </div> -->

                            <select class="form-control form-control-sm select2 selectDepartmentList" nr="1" data-placeholder="SELECT DEPARTMENT" name="department">
                            </select>
                        </div>

                        <div class="col-12">
                            <div class="input-group mb-2">
                                <span class="badge bg-success good" style="display:none;"><i class="fa fa-check-circle"></i> PASSWORD MATCH</span>
                                <span class="badge bg-danger bad" style="display:none;"><i class="fa fa-times-circle"></i> PASSWORD MISMATCH</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="dfltpwd" class="custom-control-input" checked id="dfltpwd" onclick="dfltpwdchck($(this).is(':checked'))">
                                    <label class="custom-control-label" for="dfltpwd">Default Password.</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 fillpwd">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text firstName"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control form-control-sm pwd" name="pwd" onkeyup="passwordChecker('PersonnelAccount','pwd','confirmpwd');" placeholder="PASSWORD" autocomplete="off" nr="0">
                            </div>
                        </div>
                        <div class="col-12 fillpwd">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text firstName"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control form-control-sm confirmpwd" name="confirmpwd" onkeyup="passwordChecker('PersonnelAccount','confirmpwd','pwd');" placeholder="CONFIRM" autocomplete="off" nr="0">
                            </div>
                        </div>
                        <div class="col-12 fillpwd">
                            <div class="input-group mb-2">
                                <span class="badge bg-primary atleast" style="display:none;">PASSWORD MUST BE AT LEAST `8` CHARACTERS</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between p-1">
                <button type="submit" class="btn btn-sm btn-info submitBtnPrimary">Save Account</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <!-- <button type="button" class="btn btn-default float-right" ><i class="fa fa-times"></i> Cancel</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- <div class="modal fade show" id="modalSbjctAssPrsnnl" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalQuarterInfo" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-info p-2">
                <h5 class="modal-title p-0 mb-n3 mt-n1">
                    <small><i class='fa fa-calendar'></i> Quarter Information</small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url($uri . '/Dataentry/saveQuarterInfo'), 'id=form_save_dataQuarterInfo'); ?>
            <div class="modal-body p-2">
                <input type="text" name="qrtrid" hidden />
                <div class="card-body p-0">
                    <div class="table-responsive table-hover">
                        <div class="col-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <small class="input-group-text text-xs text-bold p-1">QUARTER</small>
                                </div>
                                <select class="form-control form-control-sm" name="quarter">
                                    <option value="1">1st</option>
                                    <option value="2">2nd</option>
                                    <option value="3">3rd</option>
                                    <option value="4">4th</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-light mt-3">
                                <div class="card-header p-1">
                                    <h3 class="card-title"><b>Enrollment</b></h3>
                                </div>
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="checkbox" name="enrollment" checked data-bootstrap-switch data-off-color="gray" data-on-color="success">
                                                <input type="date" class="form-control form-control-sm" name="enrolldl" nr="1">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-light">
                                <div class="card-header p-1">
                                    <h3 class="card-title"><b>Entering of Grades</b></h3>
                                </div>
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="checkbox" name="grading" checked data-bootstrap-switch data-off-color="gray" data-on-color="success">
                                                <input type="date" class="form-control form-control-sm" name="gradingdl" nr="1">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="customQ1" name="customQ1">
                                                <label for="customQ1" class="custom-control-label">Q1</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="customQ2" name="customQ2">
                                                <label for="customQ2" class="custom-control-label">Q2</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="customQ3" name="customQ3">
                                                <label for="customQ3" class="custom-control-label">Q3</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="customQ4" name="customQ4">
                                                <label for="customQ4" class="custom-control-label">Q4</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-light">
                                <div class="card-header p-1">
                                    <h3 class="card-title"><b>Viewing of Grades</b></h3>
                                </div>
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="checkbox" name="viewing" checked data-bootstrap-switch data-off-color="gray" data-on-color="success">
                                                <input type="date" class="form-control form-control-sm" name="viewing_date" nr="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card card-light">
                                        <div class="card-header p-1">
                                            <h3 class="card-title"><b><span class="fa fa-pen text-primary"></span> Edit</b></h3>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <input type="checkbox" name="edit" checked data-bootstrap-switch data-off-color="gray" data-on-color="success">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="card card-light">
                                        <div class="card-header p-1">
                                            <h3 class="card-title"><b><span class="fa fa-trash-alt text-danger"></span> Unenroll</b></h3>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <input type="checkbox" name="unenroll" checked data-bootstrap-switch data-off-color="gray" data-on-color="success">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between p-1">
                <button type="submit" class="btn btn-sm btn-info submitBtnPrimary">Save Details</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <!-- <button type="button" class="btn btn-default float-right" ><i class="fa fa-times"></i> Cancel</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- <div class="modal fade show" id="modalSbjctAssPrsnnl" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalSubjectList" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info py-1">
                <h5 class="modal-title">
                    <small><i class='fa fa-book'></i> Subject details</small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-2">
                <div class="card-body p-0">
                    <div class="table-responsive table-hover">
                        <div class="col-12">
                            <?= form_open(base_url($uri . '/Dataentry/saveSubject'), 'id=form_save_dataSubject'); ?>
                            <span class='badge bg-navy personName'></span>
                            <div class="input-group mt-2 mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text firstName"><i class="fas fa-book-open"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="sbjctnm" placeholder="SUBJECT NAME" autocomplete="off">
                            </div>
                            <div class="input-group mt-2 mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text firstName"><i class="fas fa-font"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-sm mr-2" name="abbr" placeholder="ABREVIATION" autocomplete="off">

                                <div class="input-group-prepend">
                                    <span class="input-group-text firstName"><i class="fas fa-sort-numeric-down"></i></span>
                                </div>
                                <input type="number" class="form-control form-control-sm" name="ordr" placeholder="SEQUENCE" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-sm submitBtnPrimary">SAVE</button>
                                </div>
                            </div>
                            </form>
                            <table id="tblSubjectList" style="width:100%;" class="table-sm table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Abbr</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

<!-- <div class="modal fade show" id="modalSbjctAssPrsnnl" aria-modal="true" style="padding-right: 16px; display: block;"> -->
<div class="modal fade" id="modalProgramList" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary py-1">
                <h5 class="modal-title">
                    <small><i class='fa fa-book'></i> Program/Strand details</small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-2">
                <div class="card-body p-0">
                    <div class="table-responsive table-hover">
                        <div class="col-12">
                            <?= form_open(base_url($uri . '/Dataentry/saveProgram'), 'id=form_save_dataProgram'); ?>
                            <span class='badge bg-navy personName'></span>
                            <div class="input-group mt-2 mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text firstName"><i class="fas fa-book-open"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="sbjctnm" placeholder="PROGRAM NAME" autocomplete="off">
                            </div>
                            <div class="input-group mt-2 mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text firstName"><i class="fas fa-font"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-sm mr-2" name="abbr" placeholder="ABREVIATION" autocomplete="off">

                                <div class="input-group-prepend">
                                    <span class="input-group-text firstName"><i class="fas fa-sort-numeric-down"></i></span>
                                </div>
                                <input type="number" class="form-control form-control-sm" name="ordr" placeholder="SEQUENCE" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-sm submitBtnPrimary">SAVE</button>
                                </div>
                            </div>
                            </form>
                            <table id="tblProgramList" style="width:100%;" class="table-sm table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Abbr</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<!-- </div> -->
<!-- /.modal -->


<div class="modal fade" id="modalMapSexGraph" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header p-1">
                <h5 class="modal-title">
                    <!-- <label>XII - DURIAN</label> -->
                    <label id="label"></label>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body p-0 mb-n3 d-flex justify-content-center" id="containerGraph">

                </div>
            </div>
            <div class=" modal-footer justify-content-between p-1">
                <button type="button" class="btn btn-default w-100" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>