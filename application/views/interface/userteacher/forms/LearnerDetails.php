<input name="details" nr="1" hidden />
<input id="ersid" hidden name="rsId" />
<div class="card-body p-2">
    <div class="row">
        <div class="col-xl-2 col-md-12">
            <center>
                <div class="form-group">
                    <img name="previewPic" src="<?= $system_svg_1x1 ?>" onclick="$('[name=pic]').trigger('click')" style="border:3px solid #63a4ca;cursor:pointer" width="120" height="120" class="" alt="User Image">
                </div>
                <div class="form-group">
                    <input name="pic" type="file" accept="image/*" onchange="imageView('pic','previewPic','imgtargetLink')" nr="1" hidden />
                    <!-- <input name="personId" type="text" nr="1" > -->
                    <input name="img_path" type="text" nr="1" hidden />
                </div>
            </center>
        </div>

        <div class="col-xl-10 col-md-12 mt-4">
            <div class="row">
                <div class="col-lg-2 col-md-12 col-sm-12">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-bold text-success text-xs">LRN</span>
                        </div>
                        <input type="number" class="form-control form-control-sm text-uppercase" name="lrn" placeholder="LEARNER'S REFERENCE NUMBER (LRN)" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text firstName text-primary"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm text-uppercase" name="firstName" placeholder="FIRST NAME" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                    <input type="text" class="form-control form-control-sm text-uppercase" name="middleName" placeholder="MIDDLE NAME" autocomplete="off" nr="1">
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12 mb-2">
                    <input type="text" class="form-control form-control-sm text-uppercase" name="lastName" placeholder="LAST NAME" autocomplete="off">
                </div>
                <div class="col-lg-1 col-md-12 col-sm-12 mb-2">
                    <input type="text" class="form-control form-control-sm text-uppercase" name="extName" placeholder="EXTN" autocomplete="off" nr="1">
                </div>
                <div class="col-lg-1 col-md-12 col-sm-12">
                    <!-- <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            </div> -->
                    <select class="form-control form-control-sm" name="sex">
                        <option value="t">MALE</option>
                        <option value="f">FEMALE</option>
                    </select>
                    <!-- </div> -->
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text birthdate"><i class="fas fa-birthday-cake"></i></span>
                        </div>
                        <input type="date" class="form-control form-control-sm" name="birthdate" value="<?= date('Y-m-d'); ?>">
                    </div>
                </div>

                <div class="col-lg-2 col-md-12 col-sm-12">
                    <div class="input-group mb-2">
                        <select class="form-control form-control-sm select2 selectBarangayList" data-placeholder="SELECT BARANGAY" onchange="getLocation('BarangayList','PurokList','PersonnelInfo')" type="select" name="brgy" style="width:100%;">
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text homeAddress"><i class="fas fa-home"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm text-uppercase" name="homeAddress" placeholder="ADDRESS DETAILS" autocomplete="off" nr="1">
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-xs text-bold">STATUS</span>
                        </div>
                        <div class="input-group-prepend">
                            <select class="form-control form-control-sm selectLearnerStatus" name="status">
                            </select>
                        </div>
                        <input type="date" class="form-control form-control-sm" name="enrollDate" autocomplete="off">
                        <div class="input-group-append">
                            <!-- <span class="input-group-text"><i class="fas fa-edit text-primary"></i></span> -->
                            <button type="submit" class="btn btn-info btn-sm submitBtnPrimary"><i class="fa fa-check"></i> Update Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>