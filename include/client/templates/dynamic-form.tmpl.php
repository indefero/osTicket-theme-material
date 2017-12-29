<?php
    // Form headline and deck with a horizontal divider above and an extra
    // space below.
    // XXX: Would be nice to handle the decoration with a CSS class
	//echo "Panel:" . $form->getTitle() . "-" . $form->getid();
   /*     $defaultform ='';
    foreach (DynamicForm::objects()
               ->order_by('id', 'title') as $form) {
                // echo $form->get('id') . $form->get('title');
                if ($form->get('id') == 2) $defaultform = $form->get('title');
    }*/ 
    ?>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
		html: true, 
        placement : 'top',
        trigger : 'hover'
    });
	
	//$("input").each(function () {
    //$(this).addClass("form-control");
	//$(':input,:checkbox,:radio').addClass('YOUR_CLASSNAME');
    $('input[type=text]').addClass('form-control');
    $('input[type=email]').addClass('form-control');
    $('input[type=tel]').addClass('form-control');
});
/*$("[data-toggle=popover]").popover({
    html: true, 
	content: function() {
          return $('#popover-content').html();
        }
});*/
</script>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php print ($form instanceof DynamicFormEntry) 
            ? $form->getForm()->getMedia() : $form->getMedia(); ?>
        <h2 class="card-inside-title">
            <?php echo Format::htmlchars($form->getTitle()); ?>
        </h2>
        <em>
            <?php echo Format::display($form->getInstructions()); ?>
        </em><br>
    </div>
    <?php // Form fields, each with corresponding errors follows. Fields marked
        // 'private' are not included in the output for clients
        global $thisclient;
        foreach ($form->getFields() as $field) {?>
                <div class="col-sm-12">
                    <div class="form-group">
                        <?php 
                        if ($form->getTitle() == 'Additional Details' || $form->getTitle() == 'Contact Details'){
                            echo '<div class="form">';
                        } else {
                            echo '<div class="form-line">';
                        }
                            if (isset($options['mode']) && $options['mode'] == 'create') {
                                if (!$field->isVisibleToUsers() && !$field->isRequiredForUsers())
                                    continue;
                            }
                            elseif (!$field->isVisibleToUsers() && !$field->isEditableToUsers()) {
                                continue;
                            }?>
                        <?php if (!$field->isBlockLevel()) { ?>
                            <label data-toggle="popover" title="<?php if ($field->get('hint')) echo Format::htmlchars($field->getLocal('label')); ?>" data-content="<?php echo ($field->getLocal('hint'))?>" for="<?php echo $field->getFormName(); ?>">
                                <span class="<?php
                                    if ($field->isRequiredForUsers()) echo 'required'; ?>">
                                    <?php echo Format::htmlchars($field->getLocal('label')); ?>
                                    <?php if ($field->isRequiredForUsers()) { ?>
                                        <span class="error">*</span>
                                    <?php }?>
                                </span>
			                </label>
                            <br>
                            <?php
                            //if ($field->get('hint')) { ?>
                                <!--em style="color:gray;display:inline-block"><?php
                                //echo Format::viewableImages($field->getLocal('hint')); ?></em>-->
						
                                <?php   // } ?>
                        <?php   }   
                        //Renders Forms?>
                        <?php
                            $field->render(array('client'=>true));?>
                        </div>
                    </div>
                    <?php $field->renderExtras(array('client'=>true)); ?>
                    <?php
                            foreach ($field->errors() as $e) { ?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $e; ?>
                                </div>
                            <?php } ?>
                </div>
        <?php } ?>
</div>
