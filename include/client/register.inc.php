<?php
$info = $_POST;
if (!isset($info['timezone']))
    $info += array(
        'backend' => null,
    );
if (isset($user) && $user instanceof ClientCreateRequest) {
    $bk = $user->getBackend();
    $info = array_merge($info, array(
        'backend' => $bk::$id,
        'username' => $user->getUsername(),
    ));
}
$info = Format::htmlchars(($errors && $_POST)?$_POST:$info);
?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h1>
                    <?php echo __('Account Registration'); ?>
                </h1>
                <h2>
                    <small><?php echo __(
	                    'Use the forms below to create or update the information we have on file for your account'
	                    ); ?>
                    </small>
                </h2> 
            </div>
            <div class="body">
                <form class="form-group" action="account.php" method="post">
                    <?php csrf_token(); ?>
                    <input type="hidden" name="do" value="<?php echo Format::htmlchars($_REQUEST['do']
                        ?: ($info['backend'] ? 'import' :'create')); ?>" />
                    <?php
                        $cf = $user_form ?: UserForm::getInstance();
                        $cf->render(false, false, array('mode' => 'create'));
                    ?>
                    <h1 class="card-inside-title"><?php echo __('Preferences'); ?></h1>
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <label> <?php echo __('Time Zone');?>:</label><br>
                            <?php
                                $TZ_NAME = 'timezone';
                                $TZ_TIMEZONE = $info['timezone'];
                                include INCLUDE_DIR.'staff/templates/timezone.tmpl.php'; ?>
                                <!--<div class="error"><?php echo $errors['timezone']; ?></div>-->
                        </div>
                    </div>
                    <h1 class="card-inside-title"><?php echo __('Access Credentials'); ?></h1>
                    <?php if ($info['backend']) { ?>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <?php echo __('Login With'); ?>:
                                <input type="hidden" name="backend" value="<?php echo $info['backend']; ?>"/>
                                <input type="hidden" name="username" value="<?php echo $info['username']; ?>"/>
                                <?php foreach (UserAuthenticationBackend::allRegistered() as $bk) {
                                        if ($bk::$id == $info['backend']) {
                                            echo $bk->getName();
                                            break;
                                        }
                                } ?>
                            </div>
                        </div>       
                    <?php } else { ?>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <label> <?php echo __('Create a Password'); ?>:</label>
                                    <input class="form-control" type="password" size="18" name="passwd1" value="<?php echo $info['passwd1']; ?>">
                                </div>
                            </div>
                            <?php if (!empty($errors['passwd1'])) {?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $errors['passwd1']; ?>
                                </div>
                            <?php } ?>
	                    </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <label><?php echo __('Confirm New Password'); ?>:</label>
                                    <input class="form-control" type="password" size="18" name="passwd2" value="<?php echo $info['passwd2']; ?>">
                                </div>
                            </div>
                            <?php if (!empty($errors['passwd2'])) {?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $errors['passwd2']; ?>
                                </div>
                            <?php } ?>
	                    </div>	
                    </div>
                    <?php } ?>
                    <p>
                        <input class="btn bg-red waves-effect" type="submit" value="Registrar"/>
                        <input class="btn btn-default waves-effect" type="button" value="Cancelar" onclick="javascript:
                            window.location.href='index.php';"/>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

