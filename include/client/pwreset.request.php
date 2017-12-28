<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$userid=Format::input($_POST['userid']);
?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h1>
                    <?php echo __('Forgot My Password'); ?><br>
                </h1>
                <h2>
                <small><?php echo __(
            'Enter your username or email address in the form below and press the <strong>Send Email</strong> button to have a password reset link sent to your email account on file.');?>
                    </small></h2>
            </div>
            <div class="body">
                <form action="pwreset.php" method="post" id="clientLogin">
                    <?php csrf_token(); ?>
                    <input type="hidden" name="do" value="sendmail"/>
                    <div class="msg">
                        <span class="label label-info">Info</span><strong> <?php echo Format::htmlchars($banner); ?></strong>
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">perm_identity</i>
                        </span>
                        <div class="form-line">
                            <input id="username" type="text" class="form-control" placeholder="<?php echo __('Username'); ?>" name="userid" value="<?php echo $userid; ?>" autofocus>
                        </div>
                    </div>
                    <button class="btn btn-block btn-lg bg-red waves-effect" type="submit"><?php echo __('Send Email'); ?></button>
                    <div class="row m-t-20 m-b--5 align-center">
                        <a href="<?php echo $signin_url; ?>"><?php echo __('Sign In'); ?>!</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
