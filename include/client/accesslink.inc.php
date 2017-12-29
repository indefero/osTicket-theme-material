<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['lemail']?$_POST['lemail']:$_GET['e']);
$ticketid=Format::input($_POST['lticket']?$_POST['lticket']:$_GET['t']);

if ($cfg->isClientEmailVerificationRequired())
    $button = __("Email Access Link");
else
    $button = __("View Ticket");
?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
			<div class="header">
                <h1>
					<?php echo __('Check Ticket Status'); ?><br>
                </h1>
				<h2>
					<small><?php
						echo __('Please provide your email address and a ticket number.');
						if ($cfg->isClientEmailVerificationRequired())
							echo ' '.__('An access link will be emailed to you.');
						else
							echo ' '.__('This will sign you in to view your ticket.');
					?></small>
				</h2>
            </div> 
			<div class="body">
				<form class="form-group" action="login.php" method="post" id="clientLogin" class="form-horizontal">
    				<?php csrf_token(); ?>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="body">
								<div>
									<?php echo Format::htmlchars($errors['login']); ?>
								</div>
								<strong><?php echo __('E-Mail Address'); ?></strong>
								<div class="input-group">
                    				<span class="input-group-addon">
                        				<i class="material-icons">email</i>
                   	 				</span>
                					<div class="form-line">
                        				<input id="email" type="text" class="form-control" name="lemail" placeholder="<?php echo __('e.g. john.doe@osticket.com'); ?>" value="<?php echo $email; ?>" >
                    				</div>
                				</div>
								<strong><?php echo __('Ticket Number'); ?></strong>
								<div class="input-group">
                    				<span class="input-group-addon">
                        				<i class="material-icons">loyalty</i>
                   	 				</span>
                					<div class="form-line">
                        				<input id="ticketno" type="text" class="form-control" name="lticket" placeholder="<?php echo __('e.g. 051243'); ?>" value="<?php echo $ticketid; ?>" >
                    				</div>
                				</div>
								<div><p>
									<input class="btn bg-red waves-effect" type="submit" value="<?php echo $button; ?>">
									</p>
								</div>
							</div>
						</div>	
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="instructions">
								<?php if ($cfg && $cfg->getClientRegistrationMode() !== 'disabled') { ?>
									<h3> <?php echo __('Have an account with us?'); ?></h3
									<a href="login.php"><?php echo __('Sign In'); ?></a> <?php
									if ($cfg->isClientRegistrationEnabled()) { ?>
										<?php echo sprintf(__('or %s register for an account %s to access all your tickets.'),
										'<a href="account.php?do=create">','</a>');
									}
								}?>
							</div>
						</div>
					</div>
				</form>
				<p>
					<?php
					if ($cfg->getClientRegistrationMode() != 'disabled'
    				|| !$cfg->isClientLoginRequired()) {
    					echo sprintf(
    					__("If this is your first time contacting us or you've lost the ticket number, please %s open a new ticket %s"),
        				'<a href="open.php">','</a>');
					} ?>
				</p>
			</div>
		</div>
	</div>
</div>

