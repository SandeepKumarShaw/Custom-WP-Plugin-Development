<?php
$plans = MM_WPFS::getInstance()->get_plans();
$role_plans = MM_WPFS_Members::getInstance()->get_role_plans();
$roleNames = MM_WPFS_Members::getInstance()->get_wp_role_names();
$options = get_option('fullstripe_options');

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'members';
?>
<div class="wrap">
    <h2> <?php echo __('Full Stripe Members', 'wp-full-stripe-members'); ?> </h2>

    <div id="updateDiv"><p><strong id="updateMessage"></strong></p></div>
    <h2 class="nav-tab-wrapper">
        <a href="?page=fullstripe-members&tab=members" class="nav-tab <?php echo $active_tab == 'members' ? 'nav-tab-active' : ''; ?>">Members</a>
        <a href="?page=fullstripe-members&tab=roles" class="nav-tab <?php echo $active_tab == 'roles' ? 'nav-tab-active' : ''; ?>">Roles</a>
        <a href="?page=fullstripe-members&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
        <a href="?page=fullstripe-members&tab=help" class="nav-tab <?php echo $active_tab == 'help' ? 'nav-tab-active' : ''; ?>">Help</a>
    </h2>

    <div class="tab-content">
        <?php if ($active_tab == 'members'): ?>
        <p>
            <a class="button button-primary" href="<?php echo admin_url("admin.php?page=wpfs-members-create"); ?>">Create
                Member</a>
            <span class="alignright"><button id="wpfsm-import-button" class="button button-primary" data-toggle="modal" data-target="#wpfsm-import-wizard">
                    Import subscribers from Stripe
                </button></span>
        </p>
    </div>

    <div id="wpfsm-import-wizard" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="wpfsm-import-button">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="js-title-step"></h4>
                </div>
                <div class="modal-body">
                    <div class="row hide" data-step="1" data-title="Gathering data from Stripe">
                        <div class="col-md-12">
                            <div id="spinner1"></div>
                            <div class="well text-center" style="min-height: 250px; overflow: auto">
                                <div style="margin-top: 170px;">Gathering data from Stripe, please wait...</div>
                            </div>
                        </div>
                    </div>
                    <div class="row hide" data-step="2" data-title="Welcome">
                        <div class="col-md-12">
                            <div class="well" style="min-height: 250px; overflow: auto">
                                <p>Welcome to the WP Full Stripe Members import wizard!</p>

                                <p id="pre_import_summary"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row hide" data-step="3" data-title="Import in progress">
                        <div class="col-md-12">
                            <div id="spinner3"></div>
                            <div class="well text-center" style="min-height: 250px; overflow: auto">
                                <div style="margin-top: 170px;">Importing subscribers, please wait...</div>
                            </div>
                        </div>
                    </div>
                    <div class="row hide" data-step="4" data-title="Import feedback and reviewing conflicting subscribers">
                        <div class="col-md-12">
                            <div class="well" style="min-height: 250px; overflow: auto">
                                <p id="post_import_summary_imported_successfully"></p>

                                <p id="post_import_summary_cannot_import_count"></p>

                                <div class="collapse" id="post_import_summary_cannot_import_collapse">
                                    <table id="post_import_summary_cannot_import" class="table table-condensed table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Name and email</th>
                                            <th>Reason</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <p id="post_import_summary_can_import_manually_count"></p>

                                <form id="plan_selector_form">
                                    <table id="post_import_summary_can_import_manually" class="table table-condensed table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Membership level</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row hide" data-step="5" data-title="Import in progress">
                        <div class="col-md-12">
                            <div id="spinner5"></div>
                            <div class="well text-center" style="min-height: 250px; overflow: auto">
                                <div style="margin-top: 170px;">Importing subscribers, please wait...</div>
                            </div>
                        </div>
                    </div>
                    <div class="row hide" data-step="6" data-title="Import finished">
                        <div class="col-md-12">
                            <div class="well" style="min-height: 250px; overflow: auto">
                                <p id="post_manual_import_summary_imported_successfully"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default js-btn-step pull-left" data-orientation="cancel" data-dismiss="modal"></button>
                    <button type="button" class="btn btn-primary js-btn-step" data-orientation="next"></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <?php $membersTable->display(); ?>
    <?php elseif ($active_tab == 'roles'): ?>
        <h2>Roles</h2>
        <p>Roles are how you limit access to your content. We link roles to subscription plans so you can set what plan
            allows access to which role.
            For example, you could create a Gold subscription plan for $29.99/month and link it to the Gold role here.
            Then all subscribers of the Gold plan would
            gain access to content you have marked as Gold access or below.</p>
        <?php if (count($plans) == 0): ?>
            <div class="error"><p>No plans defined! Please create subscription plans first & make sure your Stripe API
                    keys are set in WP Full Stripe Settings.</p></div>
        <?php else: ?>
            <form action="" method="POST" id="wpfs-members-role-plans-form">
                <p class="tips"></p>
                <input type="hidden" name="action" value="wpfs_members_set_role_plans"/>
                <table class="form-table">
                    <?php foreach ($role_plans as $role => $plan): ?>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php echo $roleNames[$role]; ?></label>
                            </th>
                            <td>
                                <select name="<?php echo $role; ?>">
                                    <option value="none">Not Used</option>
                                    <?php foreach ($plans['data'] as $p): ?>
                                        <option value="<?php echo $p->id; ?>" <?php echo ($plan === $p->id) ? 'selected="selected"' : '' ?> ><?php echo $p->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <p class="submit">
                    <button class="button button-primary" type="submit">Save Roles</button>
                    <img src="<?php echo plugins_url('/img/loader.gif', dirname(__FILE__)); ?>" alt="Loading..." class="showLoading"/>
                </p>
            </form>
        <?php endif; ?>
    <?php elseif ($active_tab == 'settings'): ?>
        <h2>Settings</h2>
        <form action="" method="post" id="wpfs-members-settings-form">
            <p class="tips"></p>
            <input type="hidden" name="action" value="wpfs_members_update_settings"/>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label>Create members in test mode?</label>
                    </th>
                    <td>
                        <label class="radio">
                            <input type="radio" name="wpfs_members_create_test_members" id="createTestMembersYes" value="0" <?php echo ($options['wpfs_members_create_test_members'] == '0') ? 'checked' : '' ?> >
                            No
                        </label> <label class="radio">
                            <input type="radio" name="wpfs_members_create_test_members" id="createTestMembersNo" value="1" <?php echo ($options['wpfs_members_create_test_members'] == '1') ? 'checked' : '' ?>>
                            Yes
                        </label>

                        <p class="description">Create members for test mode subscriptions. This is useful for
                            testing. </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label>Use default password for new members?</label>
                    </th>
                    <td>
                        <label class="radio">
                            <input type="radio" name="wpfs_members_default_password" id="defaultPasswordNo" value="0" <?php echo ($options['wpfs_members_default_password'] == '0') ? 'checked' : '' ?> >
                            No
                        </label> <label class="radio">
                            <input type="radio" name="wpfs_members_default_password" id="defaultPasswordYes" value="1" <?php echo ($options['wpfs_members_default_password'] == '1') ? 'checked' : '' ?>>
                            Yes
                        </label>

                        <p class="description">Use a default password instead of generating a random one for new
                            members. The default password is: NewMember123</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label>Block members who are past due?</label>
                    </th>
                    <td>
                        <label class="radio">
                            <input type="radio" name="wpfs_members_block_past_due" value="0" <?php echo ($options['wpfs_members_block_past_due'] == '0') ? 'checked' : '' ?> >
                            No
                        </label> <label class="radio">
                            <input type="radio" name="wpfs_members_block_past_due" value="1" <?php echo ($options['wpfs_members_block_past_due'] == '1') ? 'checked' : '' ?>>
                            Yes
                        </label>

                        <p class="description">You can choose to block members considered "past due" on their
                            subscription payments. Stripe usually allows for several retries (see your Stripe dashboard)
                            before marking
                            payments as "unpaid" or "canceled". NOTE: we'll always block unpaid and canceled
                            members.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label>Allow members change membership level?</label>
                    </th>
                    <td>
                        <label class="radio">
                            <input type="radio" name="wpfs_members_allow_change_level" value="0" <?php echo ($options['wpfs_members_allow_change_level'] == '0') ? 'checked' : '' ?> >
                            No
                        </label> <label class="radio">
                            <input type="radio" name="wpfs_members_allow_change_level" value="1" <?php echo ($options['wpfs_members_allow_change_level'] == '1') ? 'checked' : '' ?>>
                            Yes
                        </label>

                        <p class="description">This allows members to upgrade/downgrade their membership level (and
                            therefore related subscription plan) on their "My Account" page.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label>Allow members to cancel membership?</label>
                    </th>
                    <td>
                        <label class="radio">
                            <input type="radio" name="wpfs_members_allow_cancel_membership" value="0" <?php echo ($options['wpfs_members_allow_cancel_membership'] == '0') ? 'checked' : '' ?> >
                            No
                        </label> <label class="radio">
                            <input type="radio" name="wpfs_members_allow_cancel_membership" value="1" <?php echo ($options['wpfs_members_allow_cancel_membership'] == '1') ? 'checked' : '' ?>>
                            Yes
                        </label>

                        <p class="description">This allows members to cancel their membership level (and therefore
                            related subscription plan) on their "My Account" page.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label>Turn on member status cron job?</label>
                    </th>
                    <td>
                        <label class="radio">
                            <input type="radio" name="wpfs_members_member_status_cron" value="0" <?php echo ($options['wpfs_members_member_status_cron'] == '0') ? 'checked' : '' ?> >
                            No
                        </label> <label class="radio">
                            <input type="radio" name="wpfs_members_member_status_cron" value="1" <?php echo ($options['wpfs_members_member_status_cron'] == '1') ? 'checked' : '' ?>>
                            Yes
                        </label>

                        <p class="description">Turn on a cron job that goes through all members daily and checks &
                            updates their subscription status. </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label>Member login cookie timeout:</label>
                    </th>
                    <td>
                        <input type="text" name="wpfs_members_cookie_expiration" value="<?php echo $options['wpfs_members_cookie_expiration']; ?>" class="regular-text code">

                        <p class="description">The amount of time (in seconds) a member can be logged in before having
                            to re-log again. Default is 2 days.</p>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <button class="button button-primary" type="submit">Update Settings</button>
                <img src="<?php echo plugins_url('/img/loader.gif', dirname(__FILE__)); ?>" alt="Loading..." class="showLoading"/>
            </p>
        </form>
    <?php
    elseif ($active_tab == 'help'): ?>
        <h2><?php echo sprintf(
            /* translators: 1: current version */
                __('Full Stripe Members Help (v%s)', 'wp-full-stripe-members'), MM_WPFS_Members::VERSION); ?></h2>
        <?php include 'help.php'; ?>
    <?php endif; ?>
</div>
</div>