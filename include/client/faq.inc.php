<?php
if(!defined('OSTCLIENTINC') || !$faq  || !$faq->isPublished()) die('Access Denied');

$category=$faq->getCategory();

?>
 <div class="block-header">
    <h2><?php echo __('Frequently Asked Questions');?></h2>
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><i class="material-icons">library_books</i><a href="index.php"> <?php echo __('All Categories');?></a></li>
        <li class="active"><i class="material-icons">archive</i> <a href="faq.php?cid=<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></a></li>
    </ol>
</div>
<div class="row clearfix">
    <?php if ($faq->getLocalAttachments()->all() or $faq->getHelpTopics()->count()){?>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    <?php }else{ ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php }?>
        <div class="card">
            <div class="header">
                <h2>
                    <?php echo $faq->getLocalQuestion() ?>
                </h2>
            </div>
            <div class="body">
                    <?php echo $faq->getLocalAnswerWithImages(); ?>
            </div>
            <div class="header">
                <small><?php echo __('Last Updated').' '. Format::relativeTime(Misc::db2gmtime($category->getUpdateDate())); ?></small>
            </div>
        </div>
    </div>
    <?php if ($faq->getLocalAttachments()->all() or $faq->getHelpTopics()->count()){?>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body">
                <?php if ($attachments = $faq->getLocalAttachments()->all()) {?>
                <div class="panel panel-primary">
                    <div class="panel-heading"><?php echo __('Attachments'); ?></div>
                    <div class="panel-body">
                            <?php foreach ($attachments as $att) { ?>
                                <a href="<?php echo $att->file->getDownloadUrl(); ?>" class="no-pjax">
                                    <i class="icon-file"></i>
                                    <?php echo Format::htmlchars($att->file->name); ?>
                                </a><br>
                            <?php } ?> 
                    </div>
                </div>
                <?php } ?>
                <?php if ($faq->getHelpTopics()->count()) { ?>
                <div class="panel panel-primary">
                    <div class="panel-heading"><?php echo __('Help Topics'); ?></div>
                    <div class="panel-body">
                                <strong><?php echo __('Help Topics'); ?></strong>
                                <?php foreach ($faq->getHelpTopics() as $T) { ?>
                                    <?php echo $T->topic->getFullName(); ?>
                                 <?php }?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
