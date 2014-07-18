<?php
require_once dirname(__DIR__) . '/common/header.php';
?>
<div class="container content">
    <div id="main"><div class="page-header"><h3>Administration</h3></div>
<!--        <h4>System</h4>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td width="200">
                        <a href="#Admin/settings">Settings</a>
                    </td>
                    <td>System settings of application.</td>
                </tr>

                <tr>
                    <td width="200">
                        <a href="#ScheduledJob">Scheduled Jobs</a>
                    </td>
                    <td>Jobs which are executed by cron.</td>
                </tr>

                <tr>
                    <td width="200">
                        <a href="#Admin/upgrade">Upgrade</a>
                    </td>
                    <td>Upgrade EspoCRM.</td>
                </tr>

                <tr>
                    <td width="200">
                        <a href="#Admin/clearCache">Clear Cache</a>
                    </td>
                    <td>Clear all backend cache.</td>
                </tr>

                <tr>
                    <td width="200">
                        <a href="#Admin/rebuild">Rebuild</a>
                    </td>
                    <td>Rebuild backend and clear cache.</td>
                </tr>

            </tbody></table>-->

        <h4>Users</h4>
        <table class="table table-bordered">

            <tbody><tr>
                    <td width="200">
                        <a href="<?php echo BASEPATH?>administration/modules/users/">Users</a>
                    </td>
                    <td>Users management.</td>
                </tr>

                <tr>
                    <td width="200">
                        <a href="<?php echo BASEPATH?>administration/modules/teams/">Teams</a>
                    </td>
                    <td>Teams management.</td>
                </tr>

                <tr>
                    <td width="200">
                        <a href="<?php echo BASEPATH?>administration/modules/roles/">Roles</a>
                    </td>
                    <td>Roles management.</td>
                </tr>

            </tbody></table>

        <h4>Email</h4>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td width="200">
                        <a href="<?php echo ADMINPATH; ?>modules/email">Outbound Emails</a>
                    </td>
                    <td>SMTP settings for outgoing emails.</td>
                </tr>

                <tr>
                    <td width="200">
                        <a href="<?php echo ADMINPATH; ?>modules/email/inbound.php">Inbound Emails</a>
                    </td>
                    <td>Group IMAP email accouts. Email import and Email-to-Case.</td>
                </tr>

                <tr>
                    <td width="200">
                        <a href="<?php echo ADMINPATH; ?>modules/email/template.php">Email Templates</a>
                    </td>
                    <td>Templates for outbound emails.</td>
                </tr>
            </tbody>
        </table>

        <h4>Data</h4>
        <table class="table table-bordered">
            <tr>
                <td width="200">
                    <a href="<?php echo ADMINPATH ?>modules/import/">Import</a>
                </td>
                <td>Import data from CSV file.</td>
            </tr>
            <tr>
                <td width="200">
                    <a href="<?php echo ADMINPATH ?>modules/status/">Lead Status</a>
                </td>
                <td>Manage Lead Status.</td>
            </tr>
            <tr>
                <td width="200">
                    <a href="<?php echo ADMINPATH ?>modules/sources/">Sources</a>
                </td>
                <td>Manage Lead Sources.</td>
            </tr>
            <tr>
                <td width="200">
                    <a href="<?php echo ADMINPATH ?>modules/stages/">Stages</a>
                </td>
                <td>Manage Opportunity Stages.</td>
            </tr>
            <tr>
                <td width="200">
                    <a href="<?php echo ADMINPATH ?>modules/call_status/">Call Status</a>
                </td>
                <td>Call Status Management.</td>
            </tr>
        </table>
    </div>
</div>
<?php
require_once dirname(__DIR__) . '/common/footer.php';
?>