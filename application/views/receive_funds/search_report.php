<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title">Receive Funds Search Report</h4>
            </header>
            <?php echo form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
                <div class="panel-body">
                    <div class="row mb-sm">
                        <div class="col-md-6 mb-sm">
                            <div class="form-group">
                                <label class="control-label">Project </label>
                                <?php
                                    $arrayProjectID = $this->app_lib->getProjectList();
                                    echo form_dropdown("project_id", $arrayProjectID, set_value('project_id'), "class='form-control'
                                    data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-sm">
                            <div class="form-group">
                                <label class="control-label">Date <span class="required">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-calendar-check"></i></span>
                                    <input type="text" class="form-control daterange" name="daterange" value="<?php echo set_value('daterange', date("Y/m/d") . ' - ' . date("Y/m/d")); ?>" required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-offset-10 col-md-2">
                            <button type="submit" name="search" value="1" class="btn btn-default btn-block"><i class="fas fa-filter"></i> Filter</button>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </section>

        <?php if(isset($receivefunds)): ?>
            <section class="panel" data-appear-animation-delay="100">
                <header class="panel-heading">
                    <h4 class="panel-title">Receive Funds List</h4>
                </header>
                <div class="panel-body">
                    <div class="mb-sm mt-xs">
                        <table class="table table-bordered table-hover table-condensed table_default">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Account / Bank</th>
                                    <th>Amount</th>
                                    <th>Transaction No</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; foreach ($receivefunds as $row): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?=$row->project_name . $row->project_no?></td>
                                    <td><?=$row->account_name?></td>
                                    <td><?=$row->amount?></td>
                                    <td><?=$row->transaction_no?></td>
                                    <td><?=$row->date?></td>
                                    <td><?=$row->description?></td>
                                    <td class="min-w-xs">
                                        <a href="<?php echo base_url('receive_funds/edit/' . $row->id); ?>" class="btn btn-circle btn-default icon"
                                        data-toggle="tooltip" data-original-title="Edit"> 
                                            <i class="fas fa-pen-nib"></i>
                                        </a>
                                        <a href="<?php echo base_url('uploads/attachments/receive_funds/' . $row->attachments); ?>" class="btn btn-circle btn-default icon"
                                        data-toggle="tooltip" data-original-title="View Document"> 
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php echo btn_delete('receive_funds/delete/' . $row->id); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
</div>