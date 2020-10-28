
<div class="row">
    <div class="col-md-12">
        <div class="panel-group" id="accordion">
            <div class="panel panel-accordion">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#employees_details">
                            <i class="fa fa-users"></i> <?php echo is_donor_loggedin()?'Employees For My Projects':'Add Employees To Project'; ?>
                        </a>
                    </h4>
                </div>
                <div id="employees_details" class="accordion-body collapse <?=($this->session->flashdata('employees_tab') == 1 ? 'in' : ''); ?>">
                    <div class="panel-body">
                        <div class="text-right mb-sm">
                        <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                            <a href="javascript:void(0);" onclick="mfp_modal('#addEmployees')" class="btn btn-circle btn-default mb-sm">
                                <i class="fas fa-plus-circle"></i> Add Employees
                            </a>
                        <?php endif; ?>
                        </div>
                        <div class="table-responsive mb-md">
                            <table class="table table-bordered table-hover table-condensed mb-none">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Name</th>
                                    <th>Remarks</th>
                                    <th>Created_at</th>
                                    <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                                    <th>Actions</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                $this->db->select('staffs_projects.*, staff.name as staff_name');
                                $this->db->from('staffs_projects');
                                $this->db->join('staff', 'staff.id = staffs_projects.staff_id');
                                $this->db->where('staffs_projects.project_id', $projectInfo['id']);
                                $result = $this->db->get()->result_array();
                                if (count($result)) {
                                    foreach($result as $row):
                                ?>
                                <tr>
                                    <td><?php echo $count++?></td>
                                    <td><?php echo $row['staff_name']; ?></td>
                                    <td><?php echo $row['remarks']; ?></td>
                                    <td><?php echo _d($row['created_at']); ?></td>
                                    <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                                    <td class="min-w-c">
                                        <a href="javascript:void(0);" class="btn btn-circle icon btn-default" data-toggle="tooltip" data-original-title="Edit" onclick="editEmployee('<?=$row['id']?>', 'projects')">
                                            <i class="fas fa-pen-nib"></i>
                                        </a>
                                        <?php echo btn_delete('projects/employee_delete/' . $row['id']); ?>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                                <?php
                                    endforeach;
                                }else{
                                    echo '<tr> <td colspan="5"> <h5 class="text-danger text-center">' .'No Information Available' . '</h5> </td></tr>';
                                }
                                ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-accordion">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#documents_details">
							<i class="fas fa-folder-open"></i> Documents Details
						</a>
                    </h4>
                </div>
                <div id="documents_details" class="accordion-body collapse <?=($this->session->flashdata('documents_tab') == 1 ? 'in' : ''); ?>">
                    <div class="panel-body">
                        <div class="text-right mb-sm">
                        <?php if (!is_donor_loggedin()): ?>
                            <a href="javascript:void(0);" onclick="mfp_modal('#addStaffDocuments')" class="btn btn-circle btn-default mb-sm">
                                <i class="fas fa-plus-circle"></i> Add Documents
                            </a>
                        <?php endif; ?>
                        </div>
                        <div class="table-responsive mb-md">
                            <table class="table table-bordered table-hover table-condensed mb-none">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>File</th>
                                    <th>Remarks</th>
                                    <th>Created_at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                $this->db->where('p_id', $projectInfo['id']);
                                $documents = $this->db->get('project_document')->result_array();
                                if (count($documents)) {
                                    foreach($documents as $row):
                                ?>
                                <tr>
                                    <td><?php echo $count++?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['file_name']; ?></td>
                                    <td><?php echo $row['remarks']; ?></td>
                                    <td><?php echo _d($row['created_at']); ?></td>
                                    <td class="min-w-c">
                                        <a href="<?php echo base_url('projects/documents_download?file=' . $row['enc_name']); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" data-original-title="Download">
                                            <i class="fas fa-cloud-download-alt"></i>
                                        </a>
                                        <a href="<?php echo base_url('uploads/attachments/project/' . $row['enc_name']); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" target="_blank" data-original-title="View">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                        <?php if (!is_donor_loggedin()): ?>
                                        <a href="javascript:void(0);" class="btn btn-circle icon btn-default" onclick="editDocument('<?=$row['id']?>', 'projects')">
                                            <i class="fas fa-pen-nib"></i>
                                        </a>
                                        <?php echo btn_delete('projects/document_delete/' . $row['id']); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                                    endforeach;
                                }else{
                                    echo '<tr> <td colspan="6"> <h5 class="text-danger text-center">No information available</h5> </td></tr>';
                                }
                                ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div id="addEmployees" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
    <section class="panel">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="fas fa-plus-circle"></i> Add Employee</h4>
        </div>
		<?php echo form_open('projects/employee_add', array('class' => 'form-horizontal frm-submit-data')); ?>
            <div class="panel-body">
                <input type="hidden" name="project_id" value="<?=$projectInfo['id']?>">
                <div class="form-group mt-md">
                    <label class="col-md-3 control-label">Project ID </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="" value="<?=$projectInfo['project_id']?>" disabled="disabled" />
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group mt-md">
                    <label class="col-md-3 control-label">Project Name </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="" value="<?=$projectInfo['project_name']?>" disabled="disabled" />
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Employee <span class="required">*</span></label>
                    <div class="col-md-9">
                        <?php
                            $employee_list = $this->app_lib->getEmployeeList();
                            echo form_dropdown("employee_id", $employee_list, set_value('employee_id'), "class='form-control' data-width='100%' id='employee_id'
                            data-plugin-selectTwo  data-minimum-results-for-search='Infinity'");
                        ?>
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group mb-md">
                    <label class="col-md-3 control-label">Remarks</label>
                    <div class="col-md-9">
                        <textarea class="form-control valid" rows="2" name="remarks"></textarea>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" id="add_employee" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
                            <i class="fas fa-plus-circle"></i> Add
                        </button>
                        <button class="btn btn-default modal-dismiss">Cancel</button>
                    </div>
                </div>
			</footer>
        <?php echo form_close(); ?>
    </section>
</div>

<!-- Edit Employee Modal -->
<div id="editEmpModal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
    <section class="panel">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="fa fa-edit"></i> Update Employee</h4>
        </div>
		<?php echo form_open('projects/employee_update', array('class' => 'form-horizontal frm-submit-data')); ?>
            <div class="panel-body">
                <input type="hidden" name="e_staffs_projects_id" id="e_staffs_projects_id" value="">
                <div class="form-group mt-md">
                    <label class="col-md-3 control-label">Project ID </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="" value="<?=$projectInfo['project_id']?>" disabled="disabled" />
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group mt-md">
                    <label class="col-md-3 control-label">Project Name </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="" value="<?=$projectInfo['project_name']?>" disabled="disabled" />
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Employee <span class="required">*</span></label>
                    <div class="col-md-9">
                        <?php
                            $employee_list = $this->app_lib->getEmployeeList();
                            echo form_dropdown("employee_id", $employee_list, set_value('13'), "class='form-control' data-width='100%' id='e_staffs_projects_employee_id'
                            data-plugin-selectTwo  data-minimum-results-for-search='Infinity'");
                        ?>
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group mb-md">
                    <label class="col-md-3 control-label">Remarks</label>
                    <div class="col-md-9">
                        <textarea class="form-control valid" rows="2" id="e_staffs_projects_remarks" name="remarks"></textarea>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" id="add_employee" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
                            <i class="fas fa-plus-circle"></i> Update
                        </button>
                        <button class="btn btn-default modal-dismiss">Cancel</button>
                    </div>
                </div>
			</footer>
        <?php echo form_close(); ?>
    </section>
</div>

<!-- Documents Details Add Modal -->
<div id="addStaffDocuments" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
    <section class="panel">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="fas fa-plus-circle"></i> Add Document</h4>
        </div>
		<?php echo form_open_multipart('projects/document_create', array('class' => 'form-horizontal frm-submit-data')); ?>
            <div class="panel-body">
                <input type="hidden" name="p_id" value="<?php echo html_escape($projectInfo['id']); ?>">
                <div class="form-group mt-md">
                    <label class="col-md-3 control-label">Ttile <span class="required">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="document_title" id="adocument_title" value="" />
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Document File <span class="required">*</span></label>
                    <div class="col-md-9">
                        <input type="file" name="document_file" class="dropify" data-height="110" data-default-file="" id="adocument_file" />
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group mb-md">
                    <label class="col-md-3 control-label">Remarks</label>
                    <div class="col-md-9">
                        <textarea class="form-control valid" rows="2" name="remarks"></textarea>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" id="docsavebtn" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
                            <i class="fas fa-plus-circle"></i> Save
                        </button>
                        <button class="btn btn-default modal-dismiss">Cancel</button>
                    </div>
                </div>
			</footer>
        <?php echo form_close(); ?>
    </section>
</div>

<!-- Documents Details Edit Modal -->
<div id="editDocModal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
    <section class="panel">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="far fa-edit"></i> Edit Document</h4>
        </div>
		<?php echo form_open_multipart('projects/document_update', array('class' => 'form-horizontal frm-submit-data')); ?>
            <div class="panel-body">
                <input type="hidden" name="document_id" id="edocument_id" value="">
                <div class="form-group mt-md">
                    <label class="col-md-3 control-label">Title <span class="required">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="document_title" id="edocument_title" value="" />
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Document File <span class="required">*</span></label>
                    <div class="col-md-9">
                        <input type="file" name="document_file" class="dropify" data-height="120" data-default-file="">
                        <input type="hidden" name="exist_file_name" id="exist_file_name" value="">
                    </div>
                </div>
                <div class="form-group mb-md">
                    <label class="col-md-3 control-label">Remarks</label>
                    <div class="col-md-9">
                        <textarea class="form-control valid" rows="2" name="remarks" id="edocuments_remarks"></textarea>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-default" id="doceditbtn" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
                            Update
                        </button>
                        <button class="btn btn-default modal-dismiss">Cancel</button>
                    </div>
                </div>
			</footer>
        <?php echo form_close(); ?>
    </section>
</div>



