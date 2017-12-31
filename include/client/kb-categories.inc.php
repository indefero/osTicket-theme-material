<div class="row clearfix">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="card">
            <?php
                $categories = Category::objects()
                ->exclude(Q::any(array(
                'ispublic'=>Category::VISIBILITY_PRIVATE,
                'faqs__ispublished'=>FAQ::VISIBILITY_PRIVATE,
                )))
                ->annotate(array('faq_count'=>SqlAggregate::COUNT('faqs')))
                ->filter(array('faq_count__gt'=>0));
                if ($categories->exists(true)) { ?>
                    <div class="header">
                        <h2>
                            <?php echo __('Click on the category to browse FAQs.'); ?>
                        </h2>
                    </div>
                    <div class="body">
                        <?php
                        foreach ($categories as $C) { ?>
                            <h1 class="card-inside-title">
                                <?php echo sprintf('<a href="faq.php?cid=%d">%s</a>',
                                    $C->getId(), Format::htmlchars($C->getLocalName())); ?>
                            </h1>
                            <div class="list-group">
                                <div class="list-group-item list-group-bg-red active">
                                    <?php echo Format::safe_html($C->getLocalDescriptionWithImages()); ?>
                                    <span class="badge bg-orange"><?php echo $C->faq_count; ?></span>
                                </div>
                                <?php foreach ($C->faqs
                                        ->exclude(array('ispublished'=>FAQ::VISIBILITY_PRIVATE))
                                        ->limit(5) as $F) { ?>
                                        <div class="list-group-item">
                                            <i class="material-icons">question_answer</i>
                                                <a href="faq.php?id=<?php echo $F->getId(); ?>">
                                                <?php echo $F->getLocalQuestion() ?: $F->getQuestion(); ?>
                                            </a>
                                        </div>
                                <?php } ?>
                            </div>
                        <?php   } ?>
                    </div>
                <?php
                } else { ?>
                    <div class="body">
                        <div class="font-40"><?php  echo __('NO FAQs found'); ?></div>
                    </div>
                <?php }
                ?>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body">
            <form method="get" action="faq.php">
                <input type="hidden" name="a" value="search"/>
                <select class="form-control" name="topicId"
                    onchange="javascript:this.form.submit();">
                    <option value="">— Buscar por Tipo —</option>
<?php
                    $topics = Topic::objects()
                        ->annotate(array('has_faqs'=>SqlAggregate::COUNT('faqs')))
                        ->filter(array('has_faqs__gt'=>0));
                    foreach ($topics as $T) { ?>
                        <option value="<?php echo $T->getId(); ?>"><?php echo $T->getFullName();?></option>
<?php               } ?>
                </select>
            </form>
            <!--Add if you need -->
        <!--<div class="content">
            <div class="panel panel-primary">
                <div class="panel-heading"><?php echo __('Other Resources'); ?></div>
                <div class="panel-body"></div>
            </div>
        </div>-->
            </div>
        </div>
    </div>
</div>
