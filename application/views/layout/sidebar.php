<aside id="sidebar-left" class="sidebar-left">
	<div class="sidebar-header">
		<div class="sidebar-title">
			Main
		</div>
	</div>

	<div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <!-- dashboard -->
        
                    <li class="<?php if ($main_menu == 'dashboard') echo 'nav-active'; ?>">
                        <a href="<?=base_url('dashboard')?>">
                            <i class="icons icon-grid"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <!-- donors -->
                    <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                    <li class="nav-parent <?php if ($main_menu == 'donors') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-user-follow"></i><span>Donors</span>
                        </a>
                        <ul class="nav nav-children">

                            <li class="<?php if ($sub_page == 'donors/view' || $sub_page == 'donors/edit') echo 'nav-active';?>">
                                <a href="<?=base_url('donors/view')?>">
                                    <span><i class="fas fa-caret-right"></i>Donors List</span>
                                </a>
                            </li>

                            <li class="<?php if ($sub_page == 'donors/add') echo 'nav-active';?>">
                                <a href="<?=base_url('donors/add')?>">
                                    <span><i class="fas fa-caret-right"></i>Add Donor</span>
                                </a>
                            </li>

                            <li class="<?php if ($sub_page == 'donors/disable_authentication') echo 'nav-active';?>">
                                <a href="<?=base_url('donors/disable_authentication')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Login Deactivate</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                    <!-- administrators -->
                    <li class="nav-parent <?php if ($main_menu == 'administrators') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-user-follow"></i><span>Administrators</span>
                        </a>
                        <ul class="nav nav-children">

                            <li class="<?php if ($sub_page == 'administrators/view' || $sub_page == 'administrators/edit') echo 'nav-active';?>">
                                <a href="<?=base_url('administrators/view')?>">
                                    <span><i class="fas fa-caret-right"></i>Administrators List</span>
                                </a>
                            </li>

                            <li class="<?php if ($sub_page == 'administrators/add') echo 'nav-active';?>">
                                <a href="<?=base_url('administrators/add')?>">
                                    <span><i class="fas fa-caret-right"></i>Add Administrator</span>
                                </a>
                            </li>

                            <li class="<?php if ($sub_page == 'administrators/disable_authentication') echo 'nav-active';?>">
                                <a href="<?=base_url('administrators/disable_authentication')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Login Deactivate</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                    <!-- supervisors -->
                    <li class="nav-parent <?php if ($main_menu == 'supervisors') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-user-follow"></i><span>Supervisors</span>
                        </a>
                        <ul class="nav nav-children">

                            <li class="<?php if ($sub_page == 'supervisors/view' || $sub_page == 'supervisors/edit') echo 'nav-active';?>">
                                <a href="<?=base_url('supervisors/view')?>">
                                    <span><i class="fas fa-caret-right"></i>Supervisors List</span>
                                </a>
                            </li>

                            <li class="<?php if ($sub_page == 'supervisors/add') echo 'nav-active';?>">
                                <a href="<?=base_url('supervisors/add')?>">
                                    <span><i class="fas fa-caret-right"></i>Add Supervisor</span>
                                </a>
                            </li>

                            <li class="<?php if ($sub_page == 'supervisors/disable_authentication') echo 'nav-active';?>">
                                <a href="<?=base_url('supervisors/disable_authentication')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Login Deactivate</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if (is_superadmin_loggedin() || is_admin_loggedin() || is_donor_loggedin()): ?>
                    <!-- Employees -->
                    <li class="nav-parent <?php if ($main_menu == 'employee') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-users"></i><span>Employee</span></a>
                        <ul class="nav nav-children">
                            <li class="<?php if ($sub_page == 'employee/view' ||  $sub_page == 'employee/profile' ) echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('employee/view'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Employee List</span>
                                </a>
                            </li>
                            <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                            <li class="<?php if ($sub_page == 'employee/add') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('employee/add'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Add Employee</span>
                                </a>
                            </li>
                            <li class="<?php if ($sub_page == 'employee/salary_type') echo 'nav-active';?>">
                                <a href="<?=base_url('salary_types')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Salary Type</span>
                                </a>
                            </li>
                            <li class="<?php if ($sub_page == 'employee/staff_type') echo 'nav-active';?>">
                                <a href="<?=base_url('staff_types')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Staff Type</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <!-- Project -->
                    <?php if (is_superadmin_loggedin() || is_admin_loggedin() || is_donor_loggedin()): ?>
                    <li class="nav-parent <?php if ($main_menu == 'project') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-crown"></i><span>Project</span></a>
                        <ul class="nav nav-children">
                            <li class="<?php if ($sub_page == 'projects/view' ||  $sub_page == 'project/profile' ) echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('projects/view'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Project List</span>
                                </a>
                            </li>
                            <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                            <li class="<?php if ($sub_page == 'projects/phase') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('projects/phase'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>New Phase</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <li class="<?php if ($sub_page == 'projects/phase_list') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('projects/phase_list'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Phase List</span>
                                </a>
                            </li>
                            <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                            <li class="<?php if ($sub_page == 'projects/create') echo 'nav-active'; ?>">
                                <a href="<?php echo base_url('projects/create'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Create Project</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if (is_superadmin_loggedin() || is_admin_loggedin() || is_supervisor_loggedin()): ?>
                    <li class="<?php if ($main_menu == 'payroll') echo 'nav-active';?>">
                        <a href="<?=base_url('payroll')?>">
                            <i class="far fa-address-card"></i><span>Payroll</span>
                        </a>
                    </li>
                    <?php endif ;?>
                    <li class="<?php if ($main_menu == 'payroll_search_report') echo 'nav-active';?>">
                        <a href="<?=base_url('payroll/search_report')?>">
                            <i class="icons icon-pie-chart icons"></i><span>Payroll Search Report</span>
                        </a>
                    </li>
                    <?php if (is_superadmin_loggedin() || is_admin_loggedin() || is_supervisor_loggedin()): ?>
                    <li class="<?php if ($main_menu == 'expense') echo 'nav-active';?>">
                        <a href="<?=base_url('expense')?>">
                            <i class="icon-credit-card icons"></i><span>Expense</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="<?php if ($main_menu == 'expense_search_report') echo 'nav-active';?>">
                        <a href="<?=base_url('expense/transitions_reports')?>">
                            <i class="icons icon-pie-chart icons"></i><span>Expense Search Report</span>
                        </a>
                    </li>
                    <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                    <li class="<?php if ($main_menu == 'receive_funds') echo 'nav-active';?>">
                        <a href="<?=base_url('receive_funds')?>">
                            <i class="fas fa-money-check-alt"></i><span>Receive Funds</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="<?php if ($main_menu == 'receive_funds_search_report') echo 'nav-active';?>">
                        <a href="<?=base_url('receive_funds/search_reports')?>">
                            <i class="icons icon-pie-chart icons"></i><span>Receive Funds Report</span>
                        </a>
                    </li>
                    <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                    <li class="<?php if ($main_menu == 'accounting' || $sub_page == 'accounting/edit') echo 'nav-active'; ?>">
                        <a href="<?php echo base_url('accounting'); ?>">
                            <span><i class="icons icon-social-spotify" aria-hidden="true"></i>Account</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
                    <!-- setting -->
                    <li class="nav-parent <?php if ($main_menu == 'settings') echo 'nav-expanded nav-active';?>">
                        <a>
                            <i class="icons icon-briefcase"></i><span>Settings</span>
                        </a>
                        <ul class="nav nav-children">
                            <?php if (is_superadmin_loggedin()): ?>
                            <li class="<?php if($sub_page == 'settings/universal') echo 'nav-active';?>">
                                <a href="<?=base_url('settings/universal')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Global Settings</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <li class="<?php if ($sub_page == 'country_list/index') echo 'nav-active';?>">
                                <a href="<?=base_url('country_list')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Country List</span>
                                </a>
                            </li>
                            <?php if (is_superadmin_loggedin()): ?>
                            <li class="<?php if ($sub_page == 'database_backup/index') echo 'nav-active';?>">
                                <a href="<?=base_url('backup')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Database Backup</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
	</div>
</aside>
<!-- end sidebar -->