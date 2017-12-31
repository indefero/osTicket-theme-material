<?php
if(!defined('OSTCLIENTINC')) die('Access Denied!');
$info=array();
if($thisclient && $thisclient->isValid()) {
    $info=array('name'=>$thisclient->getName(),
                'email'=>$thisclient->getEmail(),
                'phone'=>$thisclient->getPhoneNumber());
}

$info=($_POST && $errors)?Format::htmlchars($_POST):$info;

$form = null;
if (!$info['topicId'])
    $info['topicId'] = $cfg->getDefaultTopicId();

$forms = array();
if ($info['topicId'] && ($topic=Topic::lookup($info['topicId']))) {
    foreach ($topic->getForms() as $F) {
        if (!$F->hasAnyVisibleFields())
            continue;
        if ($_POST) {
            $F = $F->instanciate();
            $F->isValidForClient();
        }
        $forms[] = $F;
    }
}

?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h1><?php echo __('Open a New Ticket');?></h1>
	            <h2><small><?php echo __('Please fill in the form below to open a new ticket.');?></small></h2>
            </div>
            <div class="body">
                <form id="ticketForm" method="post" action="open.php" enctype="multipart/form-data">
                    <?php csrf_token(); ?>
                    <input type="hidden" name="a" value="open">
                    <div class="panel panel-default">
                        <div class="panel-heading">
			                <div class="form-header" style="margin-bottom:0.5em">
                                <h3 class="panel-title"> <?php echo __('Help Topic');?> </h3>
				            </div>
                            <em>  <?php echo __('Select a Help Topic');?>  </em>
                        </div>
                        <div class="panel-body">
                            <select class="form-control" id="topicId" name="topicId" onchange="javascript:
                                var data = $(':input[name]', '#dynamic-form').serialize();
                                $.ajax(
                                'ajax.php/form/help-topic/' + this.value,
                                {
                                    data: data,
                                    dataType: 'json',
                                    success: function(json) {
                                    $('#dynamic-form').empty().append(json.html);
                                    $(document.head).append(json.media);
                                }
                                });">
                                <option value="" selected="selected">&mdash; <?php echo __('Select a Help Topic');?> &mdash;</option>
                                <?php
                                if($topics=Topic::getPublicHelpTopics()) {
                                    foreach($topics as $id =>$name) {
                                        echo sprintf('<option value="%d" %s>%s</option>',
                                        $id, ($info['topicId']==$id)?'selected="selected"':'', $name);
                                    }
                                } else { ?>
                                <option value="0" ><?php echo __('General Inquiry');?></option>
                                <?php
                                } ?>
                            </select>
                            <?php if ($_POST && $errors && $errors['topicId']){ ?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $errors['topicId']; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div id="dynamic-form">
                        <?php foreach ($forms as $form) {
                            include(CLIENTINC_DIR . 'templates/dynamic-form.tmpl.php');
                        } ?>
                    </div>
                    <table class="table">
                    <tbody>
                        <?php
                        if($cfg && $cfg->isCaptchaEnabled() && (!$thisclient || !$thisclient->isValid())) {
                            if($_POST && $errors && !$errors['captcha'])
                                $errors['captcha']=__('Please re-enter the text again');
                            ?>
                            <tr class="captchaRow">
                                <td class="required"><?php echo __('CAPTCHA Text');?>:</td>
                                <td>
                                    <span class="captcha"><img src="captcha.php" border="0" align="left"></span>
                                    &nbsp;&nbsp;
                                    <input id="captcha" type="text" name="captcha" size="6" autocomplete="off">
                                    <em><?php echo __('Enter the text shown on the image.');?></em>
                                    <?php if ($_POST && $errors && $errors['captcha']){ ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <?php echo $errors['captcha']; ?>
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                    </table>
                    <p>
                        <input class="btn bg-red waves-effect" type="submit" value="<?php echo __('Create Ticket');?>">
                        <input class="btn btn-warning waves-effect" type="reset" name="reset" value="<?php echo __('Reset');?>">
                        <input class="btn btn-default waves-effect" type="button" name="cancel" value="<?php echo __('Cancel'); ?>" onclick="javascript:
                            $('.richtext').each(function() {
                            var redactor = $(this).data('redactor');
                            if (redactor && redactor.opts.draftDelete)
                                redactor.draft.deleteDraft();
                            });
                            window.location.href='index.php';">
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
