
<div class="row">
    <div class="col-md-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
						<i class="fas fa-folder-open"></i> Phase Documents
                    </h4>
                </div>
                <div class="accordion-body">
                    <div class="panel-body">
                        <div class="text-right mb-sm">
                            <a href="javascript:void(0);" onclick="mfp_modal('#addPhaseDocuments')" class="btn btn-circle btn-default mb-sm">
                                <i class="fas fa-plus-circle"></i> Add Documents
                            </a>
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
                                $this->db->where('phase_id', $phase_id);
                                $documents = $this->db->get('phase_document')->result_array();
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
                                        <a href="<?php echo base_url('projects/phase_documents_download?file=' . $row['enc_name']); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" data-original-title="Download">
                                            <i class="fas fa-cloud-download-alt"></i>
                                        </a>
                                        <a href="<?php echo base_url('uploads/attachments/project/phase/' . $row['enc_name']); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" target="_blank" data-original-title="View">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-circle icon btn-default" onclick="editPhaseDocument('<?=$row['id']?>', 'projects')">
                                            <i class="fas fa-pen-nib"></i>
                                        </a>
                                        <?php echo btn_delete('projects/phase_document_delete/' . $row['id']); ?>
                                    </td>
                                </tr>
                                <?php
                                    endforeach;
                                }else{
                                    echo '<tr> <td colspan="6"> <h5 class="text-danger text-center">' . 'No information available' . '</h5> </td></tr>';
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

<!-- Documents Phase Add Modal -->
<div id="addPhaseDocuments" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
    <section class="panel">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="fas fa-plus-circle"></i> Add Document</h4>
        </div>
		<?php echo form_open_multipart('projects/phase_document_add', array('class' => 'form-horizontal frm-submit-data')); ?>
            <div class="panel-body">
                <input type="hidden" name="phase_id" value="<?php echo $phase_id; ?>">
                <div class="form-group mt-md">
                    <label class="col-md-3 control-label">Ttile <span class="required">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="phase_document_title" id="aphase_document_title" value="" />
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Document File <span class="required">*</span></label>
                    <div class="col-md-9">
                        <input type="file" name="phase_document_file" class="dropify" data-height="110" data-default-file="" id="aphase_document_file" />
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
<div id="editPhaseModal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
    <section class="panel">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="far fa-edit"></i> Edit Document</h4>
        </div>
		<?php echo form_open_multipart('projects/phase_document_update', array('class' => 'form-horizontal frm-submit-data')); ?>
            <div class="panel-body">
                <input type="hidden" name="phase_document_id" id="phase_document_id" value="">
                <div class="form-group mt-md">
                    <label class="col-md-3 control-label">Title <span class="required">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="phase_document_title" id="ephase_document_title" value="" />
                        <span class="error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Document File <span class="required">*</span></label>
                    <div class="col-md-9">
                        <input type="file" name="phase_document_file" class="dropify" data-height="120" data-default-file="">
                        <input type="hidden" name="exist_file_name" id="exist_file_name" value="">
                    </div>
                </div>
                <div class="form-group mb-md">
                    <label class="col-md-3 control-label">Remarks</label>
                    <div class="col-md-9">
                        <textarea class="form-control valid" rows="2" name="remarks" id="ephase_documents_remarks"></textarea>
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



