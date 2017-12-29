<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');
$email=Format::input($_POST['luser']?:$_GET['e']);
$passwd=Format::input($_POST['lpasswd']?:$_GET['t']);
$content = Page::lookupByType('banner-client');	
$checkldap = 'SELECT * FROM '.PLUGIN_TABLE.' WHERE name LIKE "%ldap%" AND `isactive` = "1"';
if ($content) {
    list($title, $body) = $ost->replaceTemplateVariables(
        array($content->getName(), $content->getBody()));
} else {
    $title = __('Iniciar sesion');
	$body = __('Para brindarle un mejor servicio, alentamos a nuestros clientes a registrarse para una cuenta y verificar la dirección de correo electrónico que tenemos registrada.');	
}

?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h1>
					<?php echo Format::display($title); ?><br>
                </h1>
				<h2>
					<small><?php echo Format::display($body); ?></small>
				</h2>
			</div>
			<div class="body">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="body">
							<form class="form-group" action="login.php" method="post" id="clientLogin">
    							<?php csrf_token(); ?>
								<div>
									<?php echo Format::htmlchars($errors['login']); ?>
								</div>
								<div class="msg">Iniciar sesion</div>
								<div class="input-group">
                    				<span class="input-group-addon">
                        				<i class="material-icons">person</i>
                   	 				</span>
                					<div class="form-line">
                        				<input id="username" type="text" class="form-control" name="luser" placeholder="<?php echo __('Email or Username'); ?>" value="<?php echo $email; ?>" required autofocus>
                    				</div>
                				</div>	
								<div class="input-group">
                    				<span class="input-group-addon">
                        				<i class="material-icons">lock</i>
                    				</span>
                					<div class="form-line">
                    					<input id="passwd" type="password" class="form-control" name="lpasswd" placeholder="<?php echo __('Password'); ?>" value="<?php echo $passwd; ?>">
                    				</div>
                				</div>
								<div class="row">
									<div class="col-xs-6">
                       				 	<button class="btn btn-block bg-red waves-effect" type="submit"><?php echo __('Sign In'); ?>
											</button>
                    				</div>
								</div>
								<?php if ($suggest_pwreset) { ?>
									<div class="row m-t-15 m-b--20">
                        				<div class="col-xs-6 align-right">
                            				<a href="pwreset.php"><?php echo __('Forgot My Password'); ?></a>
                        				</div>
                    				</div>
								<?php } ?>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="body">
							<?php
								$ext_bks = array();
								foreach (UserAuthenticationBackend::allRegistered() as $bk)
    							if ($bk instanceof ExternalAuthentication) $ext_bks[] = $bk;
								if (count($ext_bks)) {
    								foreach ($ext_bks as $bk) { ?>
										<div class="external-auth"><?php $bk->renderExternalLink(); ?></div><?php
    								}
								}
								if ($cfg && $cfg->isClientRegistrationEnabled()) {
    								if (count($ext_bks)) echo '<hr style="width:70%"/>'; 
									if (!db_query($checkldap)){?>
   										<div>
    										<h3> <?php echo __('Not yet registered?'); ?></h3> <a href="account.php?do=create"><?php echo __('Create an account'); ?></a>
    									</div>
									<?php }
								} ?>
    							<div>
    								<h3><?php echo __("I'm an agent"); ?></h3>
    								<a href="<?php echo ROOT_PATH; ?>scp/"><?php echo __('Inicia Sesion Aqui'); ?></a>
    							</div>
							</form>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="body">
							<?php
								if ($cfg->getClientRegistrationMode() != 'disabled' || !$cfg->isClientLoginRequired()) {
   		 							echo sprintf(__('If this is your first time contacting us or you\'ve lost the ticket number, please %s open a new ticket %s'),
        							'<a href="open.php">', '</a>');
								} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>