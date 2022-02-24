<?php defined('ABSPATH') or die("Bye bye");
//check option elkinet_tools_api_token
$option_elkinet_tools_api_token = get_option('elkinet_tools_api_token');
$option_elkinet_tools_api_url = get_option('elkinet_tools_api_url');

/** Funciones relacionadas con el menu de administracion */
function elkinet_tools_menu_admin() {
    add_menu_page(
        'Elkinet Tools',
        'Elkinet Tools',
        'manage_options',
        'elkinet_tools',
        'admin_page_html'
    );
    /*
    add_submenu_page(
        elkinet_tools_PLUGIN_DIR.'/modulos/general/general.php',
        'Planes',
        'Planes',
        'manage_options',
        'elkinet_tools',
        'admin_page_html'
    );
    */
}
add_action( 'admin_menu', 'elkinet_tools_menu_admin' );

function admin_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
      return;
    }
 
    //Get the active tab from the $_GET param
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
    ?>
    <!-- Our admin page content should all be inside .wrap -->
    <div class="wrap">
        <!-- Print the page title -->
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <!-- Here are our tabs -->
        <nav class="nav-tab-wrapper">
            <a href="?page=elkinet_tools" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">General</a>
            <a href="?page=elkinet_tools&tab=planes" class="nav-tab <?php if($tab==='planes'):?>nav-tab-active<?php endif; ?>">Planes</a>
                <?php if(!$option_elkinet_tools_api_token || !$option_elkinet_tools_api_url){ 
                    ?> <a href="?page=elkinet_tools&tab=clientes" class="nav-tab <?php if($tab==='clientes'):?>nav-tab-active<?php endif; ?>">Clientes</a><?php
                } ?>
            <a href="?page=elkinet_tools&tab=config" class="nav-tab <?php if($tab==='config'):?>nav-tab-active<?php endif; ?>">Configuracion</a>
        </nav>
    
        <div class="tab-content">
            </br>
            <?php switch($tab) :
                case 'planes':
                    include elkinet_tools_PLUGIN_DIR.'/modulos/planes/planes.php';
                    break;
                case 'config':
                    include  elkinet_tools_PLUGIN_DIR.'/modulos/configuracion/configuracion.php';
                    break;
                case 'clientes':
                    include elkinet_tools_PLUGIN_DIR.'/modulos/clientes/clientes.php';
                    break;
                default:
                    include elkinet_tools_PLUGIN_DIR.'/modulos/general/general.php';
                    break;
            endswitch; ?>
        </div>
    </div>
    <?php
  }