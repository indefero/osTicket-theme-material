	</div>
</section>	
	<!-- Acerca de -->
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Acerca de...</h4>
                </div>
                <div class="modal-body">
                    Esta web esta basada en el template html AdminBSB que puedes encontrar aqui: <a href="https://github.com/gurayyarar/AdminBSBMaterialDesign" target="_blank">AdminBSB</a> y 
					el sistema base de tickets es gracias a <a href="http://www.osticket.com" target="_blank">OsTicket </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Acerca de -->
    
    <!-- Bootstrap Core Js -->
    <script src="<?php echo ROOT_PATH; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo ROOT_PATH; ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo ROOT_PATH; ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?php echo ROOT_PATH; ?>plugins/bootstrap-notify/bootstrap-notify.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo ROOT_PATH; ?>plugins/node-waves/waves.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo ROOT_PATH; ?>js/admin.js"></script>
    <script src="<?php echo ROOT_PATH; ?>js/script.js"></script>

    <!-- Demo Js -->
    <script src="<?php echo ROOT_PATH; ?>js/demo.js"></script>				
<?php
if (($lang = Internationalization::getCurrentLanguage()) && $lang != 'en_US') { ?>
    <script type="text/javascript" src="ajax.php/i18n/<?php
        echo $lang; ?>/js"></script>
<?php } ?>
<script type="text/javascript">
    getConfig().resolve(<?php
        include INCLUDE_DIR . 'ajax.config.php';
        $api = new ConfigAjaxAPI();
        print $api->client(false);
    ?>);
</script>

    <!-- Jquery Core Js -->
    <!--<script src="<?php echo ROOT_PATH; ?>plugins/jquery/jquery.min.js"></script>-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->



</body>
</html>