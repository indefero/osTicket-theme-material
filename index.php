<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');

require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');
?>

<!-- Quienes somos -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <?php if($cfg && ($page = $cfg->getLandingPage())) {
                echo '<div class="body">'; 
                echo $page->getBodyWithImages();
                echo '<div>';
                 }else{ ?>
                <div class="header">
                    <h1>
                        Bienvenido al Centro de soporte
                    </h1>
                </div>
                <div class="body">
                    <p class="lead">
                        Este panel esta hecho para la atención de parte del team RedHawk con sus seguidores. Brindandoles a su alcance herramientas que les ayuden en lo que buscan mejorar en sus moviles.
                    </p>
                    <p>
                        RedHawkLab pretende ser una plataforma para gestionar mejor las peticiones de soporte que diariamente llegan a nuestra web en facebook, obteniendo mejoras tales como un mejor orden en la forma de atencion e informar como van las peticiones realizadas. Este proyecto es gratis y no contiene ningun tipo de ganancia para el team.
                    </p>
                    <p>
                        Nosotros simplemente ofrecemos este tipo de ayuda, soporte, para nuestra propia mejora de conocimientos por eso a su vez se pide la paciencia por la atención de sus peticiones, tambien queda claro que nosotros no pertenecemos a ninguna compañia ni provedora de servicios y deja en claro que al hacer cualquier modificación a su movil esta pierda la garantia de compañia y/o fabrica, todo esto solo sabiendo que es bajo su propia voluntad ajustar dichos cambios.
                    </p>
                </div>
            <?php } ?>
        </div>
     </div>
</div>
<!-- #END# Quienes somos -->
<!-- Check Enable-->
        <?php
            $BUTTONS = isset($BUTTONS) ? $BUTTONS : true;
        ?>	
        <?php
            $faqs = FAQ::getFeatured()->select_related('category')->limit(5); 
            if ($faqs->all()) { ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo __('Featured Questions'); ?>
                        </h3>
                    </div>
                    <ul class="list-group">
                        <?php foreach ($faqs as $F) { ?>
                            <li class="list-group-item">
                                <a href="<?php echo ROOT_PATH; ?>kb/faq.php?id=<?php echo $F->getId(); ?>">
                                    <?php echo $F->getLocalQuestion(); ?>
                                </a>
                            </li>
                        <?php } ?>
                     </ul>
                </div>
            <?php }
            $resources = Page::getActivePages()->filter(array('type'=>'other'));
            if ($resources->all()) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo __('Other Resources'); ?>
                    </div>
                    <ul class="list-group">
                        <?php foreach ($resources as $page) { ?>
                            <li class="list-group-item">
                                <a href="<?php echo ROOT_PATH; ?>pages/<?php echo $page->getNameAsSlug(); ?>">
                                    <?php echo $page->getLocalName(); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } 
            if ($BUTTONS) { ?>
            <div class="row clearfix">
                <?php if ($cfg && !$cfg->isKnowledgebaseEnabled()) { ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?php }else { ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php } ?>
                    <div class="card">
                        <div class="header bg-red">
                            <h2>
                                Abre un nuevo ticket
                            </h2>
                        </div>
                        <div class="body">
                                Proporcione tantos detalles como sea posible para que podamos ayudarlo mejor. Para actualizar un ticket enviado previamente, por favor inicie sesión.
                                <br>
                                <br>
                                <div class="align-center">               
                                    <a href="open.php" class="btn bg-red waves-effect">
                                        <i class="material-icons">loyalty</i>
                                        <span><?php echo __('Open a New Ticket');?></span>
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
                <?php if ($cfg && !$cfg->isKnowledgebaseEnabled()) { ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header bg-light-green">
                                <h2>
                                    Checa el estado de un ticket
                                </h2>
                            </div>
                            <div class="body">
                                Proporcionamos archivos e historial de todas sus solicitudes de soporte actuales y pasadas con respuestas completas.
                                <br>
                                <br>
                                <div class="align-center">
                                    <a href="view.php" class="btn bg-light-green waves-effect">
                                        <i class="material-icons">explore</i>
                                        <span><?php echo __('Check Ticket Status');?></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
            <?php } ?>
<!--END# Enable-->
<!-- Categorias -->
<?php
    $cats = Category::getFeatured();
    if ($cats->all()) { ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Preguntas frecuentes
                            <small>Antes de crear un ticket fijate en nuestro kb haber si ya se encuentra resuelta tu duda.</small>
                        </h2> 
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                        <?php
                            $valor=0;
                            foreach ($cats as $C) { 
                                $valor=$valor+1; 
                                $question_val=0;?>
                                <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                    <h3>
                                        <i class="material-icons">folder_open</i>
                                        &nbsp;<?php echo $C->getName(); ?>
                                    </h3>
                                    <div class="panel-group" id="cats_<?php echo $valor; ?>" role="tablist" aria-multiselectable="true">
                                        <?php foreach ($C->getTopArticles() as $F) { 
                                            $question_val=$question_val+1; ?>
                                            <div class="panel panel-primary">
                                                <div class="panel-heading" role="tab" id="article_<?php echo $valor; ?>_<?php echo $question_val; ?>">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#cats_<?php echo $valor; ?>" href="#question_<?php echo $valor; ?>_<?php echo $question_val; ?>" aria-expanded="false" aria-controls="question_<?php echo $valor; ?>_<?php echo $question_val; ?>">
                                                            <i class="material-icons">question_answer</i>&nbsp;<?php echo $F->getQuestion(); ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="question_<?php echo $valor; ?>_<?php echo $question_val; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="article_<?php echo $valor; ?>_<?php echo $question_val; ?>">
                                                    <div class="panel-body">
                                                        <?php echo $F->getTeaser(); ?>
                                                        <a href="<?php echo ROOT_PATH; ?>kb/faq.php?id=<?php echo $F->getId(); ?>">
                                                            Leer mas...
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php }?>
<!-- #END# Categorias -->
<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
