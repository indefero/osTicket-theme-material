<?php
$title=($cfg && is_object($cfg) && $cfg->getTitle())
    ? $cfg->getTitle() : 'osTicket :: '.__('Support Ticket System');
$signin_url = ROOT_PATH . "login.php"
    . ($thisclient ? "?e=".urlencode($thisclient->getEmail()) : "");
$signout_url = ROOT_PATH . "logout.php?auth=".$ost->getLinkToken();
	$checkldap = 'SELECT * FROM '.PLUGIN_TABLE
                .' WHERE name LIKE "%ldap%" AND `isactive` = "1"';
header("Content-Type: text/html; charset=UTF-8");
if (($lang = Internationalization::getCurrentLanguage())) {
    $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
    $langs = Internationalization::rfc1766($langs);
    header("Content-Language: ".implode(', ', $langs));
}
?>
<!DOCTYPE html>
<html<?php
if ($lang
        && ($info = Internationalization::getLanguageInfo($lang))
        && (@$info['direction'] == 'rtl'))
    echo ' dir="rtl" class="rtl"';
if ($lang) {
    echo ' lang="' . $lang . '"';
}
?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo Format::htmlchars($title); ?></title>
    <meta name="description" content="customer support platform">
    <meta name="keywords" content="osTicket, Customer support system, support ticket system">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<!-- Favicon-->
	<link rel="icon" href="<?php echo ROOT_PATH; ?>favicon.ico" type="image/x-icon">

    <!--Bootstrap loading via CDN until we can load assets during packaging-->

    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>plugins/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/osticket.css" media="screen">
	<!--<link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/bootstrap-theme.css" media="screen">-->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/print.css" media="print">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>scp/css/typeahead.css" media="screen" />

    <!---Uncomment the following line to try another theme-->
    <!--<link rel="stylesheet" href="https://bootswatch.com/cyborg/bootstrap.min.css" media="screen">-->
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css"
        rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/thread.css" media="screen">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css" media="screen">
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css">
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css">
	<!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Waves Effect Css -->
	<link href="<?php echo ROOT_PATH; ?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo ROOT_PATH; ?>plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo ROOT_PATH; ?>css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo ROOT_PATH; ?>css/themes/all-themes.css" rel="stylesheet" />

    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.11.2.min.js"></script>
	<!--<script type="text/javascript" src="<?php echo ASSETS_PATH; ?>js/bootstrap.min.js"></script>-->
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo ROOT_PATH; ?>js/osticket.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js"></script>
    <script src="<?php echo ROOT_PATH; ?>scp/js/bootstrap-typeahead.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/select2.min.js"></script>
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
    if($ost && ($headers=$ost->getExtraHeaders())) {
        echo "\n\t".implode("\n\t", $headers)."\n";
    }

    // Offer alternate links for search engines
    // @see https://support.google.com/webmasters/answer/189077?hl=en
    if (($all_langs = Internationalization::getConfiguredSystemLanguages())
        && (count($all_langs) > 1)
    ) {
        $langs = Internationalization::rfc1766(array_keys($all_langs));
        $qs = array();
        parse_str($_SERVER['QUERY_STRING'], $qs);
        foreach ($langs as $L) {
            $qs['lang'] = $L; ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>?<?php
            echo http_build_query($qs); ?>" hreflang="<?php echo $L; ?>" />
    <?php
        } ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
            hreflang="x-default";>
<?php
    } 
    ?>
</head>
<body class="theme-red">
	<!-- Page Loader-->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Espere un momento...</p>
        </div>
    </div>
	<!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <form method="get" action="kb/faq.php" class="search-form">
            <input type="text" name="q" placeholder="Buscar en nuestra base de datos...">
        </form>
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo ROOT_PATH; ?>index.php"><?php echo $ost->getConfig()->getTitle(); ?></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Knowledgebase -->
                    <?php if ($cfg && $cfg->isKnowledgebaseEnabled()) { ?>
                     <!-- Call Search -->
                     <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                     <!-- #END# Call Search -->
                     <?php } ?> 
                    <!-- #END# Knowledgebase -->
					<?php if ($thisclient && is_object($thisclient) && $thisclient->isValid()
										&& !$thisclient->isGuest()) { ?>
										<?php if (!db_query($checkldap)){?>
										<li><a href="<?php echo ROOT_PATH; ?>profile.php">
											<?php echo __('<span class="glyphicon glyphicon-user"></span> Profile'); ?>
										</a></li>
										<?php } ?>					
										<li><a href="<?php echo $signout_url; ?>">
											<span class="glyphicon glyphicon-log-out" ></span> <?php echo __('Sign Out'); ?>
										</a></li>
										<li><a href="javascript:void(0);"><i class="material-icons">verified_user</i><span class="align-middle"><?php echo Format::htmlchars($thisclient->getName()); ?><span></a></li>
									<?php } elseif($nav) {
										if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) { ?>
											<li><a href="<?php echo $signout_url; ?>"><i class="material-icons">input</i><span> <?php echo __('Sign Out'); ?></span></a></li><?php
										} elseif ($cfg->getClientRegistrationMode() != 'disabled') { ?>
											<li><a href="<?php echo $signin_url; ?>"><i class="material-icons">assignment_ind</i><span> <?php echo __('Sign In'); ?></span></a></li>
										<?php }
										if ($cfg->getClientRegistrationMode() == 'public') { ?>
											<li><a href="javascript:void(0);"><i class="material-icons">verified_user</i><span class="align-middle"> <?php echo __('Guest'); ?><span></a></li>
										  <?php }
									} ?>
					<?php
								if (($all_langs = Internationalization::getConfiguredSystemLanguages()) && (($cuenta= count($all_langs)) > 1)) { ?>
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            				<i class="material-icons">g_translate</i>
											<span class="label-count"><?php echo $cuenta ?></span>
										</a>
										<ul class="dropdown-menu">
											<li class="header">IDIOMAS</li>
											<li class="body">
                                				<ul class="menu">
													<?php
														$qs = array();
														parse_str($_SERVER['QUERY_STRING'], $qs);
														foreach ($all_langs as $code=>$info) {
															list($lang, $locale) = explode('_', $code);
															$qs['lang'] = $code; ?>
															<li>
																<a href="?<?php echo http_build_query($qs);?>">
                                                					<span class="flag flag-<?php echo strtolower($locale ?: $info['flag'] ?: $lang); ?>"></span>
                                            						<div class="menu-info">
                                                						<h4><?php echo Internationalization::getLanguageDescription($code); ?></h4>
                                                						<p>
                                                    						<i class="material-icons">access_time</i> <?php echo $locale ?: $info['flag'] ?: $lang; ?>
                                               							</p>
                                            						</div>
                                        						</a>
															</li>
														<?php } ?>
												</ul>
											</li>
										</ul>
									</li>
								<?php } ?>
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #END# Top Bar -->
	<section>
	<!-- Left Sidebar -->
	<aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="images/home-logo.png" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">RedHawk Lab</div>
                <div class="email">Creando soluciones</div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">Navegacion Principal</li>
                    <?php
						if($nav && ($navs=$nav->getNavLinks()) && is_array($navs)){
							foreach($navs as $name =>$nav) {
								$icon= 'memory';
								$var= 'index.php';
								$var2= 'view.php';
								$var3= 'open.php';
								if (strcmp($nav['href'], $var) === 0){
									$icon= 'home';
								}
								if (strcmp($nav['href'], $var2) === 0){
									$icon= 'near_me';
								}
								if (strcmp($nav['href'], $var3) === 0){
									$icon= 'label';
								}
								echo sprintf('<li class="%s"><a href="%s"><i class="material-icons">%s</i><span>%s</span></a></li>%s',
								$nav['active']?'active':'',(ROOT_PATH.$nav['href']),$icon,$nav['desc'],"\n");
							}
						}												
					?>
					<li>
						<a href="<?php echo ROOT_PATH; ?>account.php?do=create">
                            <i class="material-icons">account_circle</i>
                            <span>Registrarse</span>
                        </a>
					</li>
				<li class="header"></li>
                <li>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#defaultModal">
                        <i class="material-icons">info</i>
                        <span>Acerca de...</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- #END# Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2017 - 2018 <a href="javascript:void(0);">Soporte - RedHawk</a>.
            </div>
            <div class="version">
                <b>Version: </b> 0.5
            </div>
        </div>
        <!-- #END# Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
	<!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                <ul class="demo-choose-skin">
                    <li data-theme="red" class="active">
                        <div class="red"></div>
                        <span>Rojo</span>
                    </li>
                    <li data-theme="pink">
                        <div class="pink"></div>
                        <span>Rosa</span>
                    </li>
                    <li data-theme="purple">
                        <div class="purple"></div>
                        <span>Purpura</span>
                    </li>
                    <li data-theme="deep-purple">
                        <div class="deep-purple"></div>
                        <span>Morado</span>
                    </li>
                    <li data-theme="indigo">
                        <div class="indigo"></div>
                        <span>Indigo</span>
                    </li>
                    <li data-theme="blue">
                        <div class="blue"></div>
                        <span>Azul</span>
                    </li>
                    <li data-theme="light-blue">
                        <div class="light-blue"></div>
                        <span>Azul Claro</span>
                    </li>
                    <li data-theme="cyan">
                        <div class="cyan"></div>
                        <span>Cyan</span>
                    </li>
                    <li data-theme="teal">
                        <div class="teal"></div>
                        <span>Teal</span>
                    </li>
                    <li data-theme="green">
                        <div class="green"></div>
                        <span>Verde</span>
                    </li>
                    <li data-theme="light-green">
                        <div class="light-green"></div>
                        <span>Verde Claro</span>
                    </li>
                    <li data-theme="lime">
                        <div class="lime"></div>
                        <span>Lima</span>
                    </li>
                    <li data-theme="yellow">
                        <div class="yellow"></div>
                        <span>Amarillo</span>
                    </li>
                    <li data-theme="amber">
                        <div class="amber"></div>
                        <span>Amber</span>
                    </li>
                    <li data-theme="orange">
                        <div class="orange"></div>
                        <span>Naranja</span>
                    </li>
                    <li data-theme="deep-orange">
                        <div class="deep-orange"></div>
                        <span>Naranjado</span>
                    </li>
                    <li data-theme="brown">
                        <div class="brown"></div>
                        <span>Cafe</span>
                    </li>
                    <li data-theme="grey">
                        <div class="grey"></div>
                        <span>Gris</span>
                    </li>
                    <li data-theme="blue-grey">
                        <div class="blue-grey"></div>
                        <span>Azul gris</span>
                    </li>
                    <li data-theme="black">
                        <div class="black"></div>
                        <span>Negro</span>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
    <!-- #END# Right Sidebar -->
	</section>
    <section class="content">
        <div class="container-fluid">
			<?php if($errors['err']) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $errors['err'] ?>
                </div>
			<?php }elseif($msg) { ?>
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $msg; ?>
                </div>
			<?php }elseif($warn) { ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $warn; ?>
                </div>
			<?php } ?>
		<!--End of header-->

	
