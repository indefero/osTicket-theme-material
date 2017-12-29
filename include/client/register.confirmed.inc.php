<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <?php if ($content) {
                list($title, $body) = $ost->replaceTemplateVariables(
                array($content->getName(), $content->getBody())); ?>
                <div class="header">
                    <h1>
                        <?php echo Format::display($title); ?>
                    </h1>
                </div>
                <div class="body">
                    <?php echo Format::display($body); ?>
                </div>
            <?php } else { ?>
                <div class="header">
                    <h1>
                        <?php echo __('Account Registration'); ?>
                    </h1>
                    <h2><small><?php echo __('Thanks for registering for an account.'); ?></small></h2>
                </div>
                <div class="body">
                    <p><?php echo __(
                        "You've confirmed your email address and successfully activated your account.  You may proceed to check on previously opened tickets or open a new ticket."
                        ); ?>
                    </p>
                    <p><em><?php echo __('Your friendly support center'); ?></em></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
