<div class="block-header">
  <?php echo __('Frequently Asked Questions');?>
</div>
<div class="row clearfix">
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h3><?php echo __('Search Results'); ?></h3>
      </div>
      <div class="body">
        <?php
        if ($faqs->exists(true)) { ?>
          <ul class="list-group">
            <li class="list-group-item">
              <?php echo __('FAQs que coinciden con tu criterio de busqueda.'); ?> 
              <span class="badge bg-pink"><?php echo $faqs->count(); ?></span>
            </li>  
          <?php foreach ($faqs as $F) {
              echo sprintf(
                  '<li class="list-group-item"><a href="faq.php?id=%d" class="previewfaq">%s</a></li>',
                  $F->getId(), $F->getLocalQuestion(), $F->getVisibilityDescription());
            }
          echo '</ul>';
        } else {
          echo __('The search did not match any FAQs.');
        }?>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="card">
      <!--<div class="searchbar">
        <form method="get" action="faq.php">
          <input type="hidden" name="a" value="search"/>
          <input class="form-control" type="text" name="q" class="search" placeholder="<?php
              echo __('Search our knowledge base'); ?>"/>
          <input type="submit" style="display:none" value="search"/>
        </form>
      </div>
      <br/>-->
      <div class="body">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo __('Help Topics'); ?></h3>
          </div>
          <ul class="list-group">
            <?php
            foreach (Topic::objects()
              ->annotate(array('faqs_count'=>SqlAggregate::count('faqs')))
              ->filter(array('faqs_count__gt'=>0))
              as $t) { ?>
              <li class="list-group-item">
                <a href="?topicId=<?php echo urlencode($t->getId()); ?>">
                  <?php echo $t->getFullName(); ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo __('Categories'); ?></h3>
          </div>
          <ul class="list-group">
            <?php
            foreach (Category::objects()
              ->annotate(array('faqs_count'=>SqlAggregate::count('faqs')))
              ->filter(array('faqs_count__gt'=>0)) as $C) {
              ?>
              <li class="list-group-item">
                <a href="?cid=<?php echo urlencode($C->getId()); ?>">
                  <?php echo $C->getLocalName(); ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
