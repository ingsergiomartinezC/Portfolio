<?php
/**
 * Mi Tema Hijo — functions.php
 *
 * Encola los estilos del tema padre y los del tema hijo.
 * Agrega funciones auxiliares y personalizaciones de WordPress.
 *
 * @package MiTemaHijo
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevenir acceso directo
}

// ─────────────────────────────────────────
// 1. ENCOLAR ESTILOS Y SCRIPTS
// ─────────────────────────────────────────

function mi_tema_hijo_enqueue_assets() {

    // Estilo del tema padre (obligatorio en tema hijo)
    wp_enqueue_style(
        'padre-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( get_template() )->get( 'Version' )
    );

    // Estilo del tema hijo (personalizaciones)
    wp_enqueue_style(
        'hijo-main-style',
        get_stylesheet_directory_uri() . '/assets/css/main.css',
        [ 'padre-style' ],
        filemtime( get_stylesheet_directory() . '/assets/css/main.css' ) // Cache busting automático
    );

    // Estilos para bloques Gutenberg personalizados
    wp_enqueue_style(
        'hijo-blocks-style',
        get_stylesheet_directory_uri() . '/assets/css/custom-blocks.css',
        [ 'hijo-main-style' ],
        filemtime( get_stylesheet_directory() . '/assets/css/custom-blocks.css' )
    );

    // Script principal (defer para no bloquear render)
    wp_enqueue_script(
        'hijo-main-script',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        [],
        filemtime( get_stylesheet_directory() . '/assets/js/main.js' ),
        true // Cargar en footer
    );

    // Pasar datos de PHP a JS si es necesario
    wp_localize_script( 'hijo-main-script', 'miTema', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'siteUrl' => get_site_url(),
        'nonce'   => wp_create_nonce( 'mi_tema_nonce' ),
    ]);
}
add_action( 'wp_enqueue_scripts', 'mi_tema_hijo_enqueue_assets' );


// ─────────────────────────────────────────
// 2. SOPORTE DE CARACTERÍSTICAS DEL TEMA
// ─────────────────────────────────────────

function mi_tema_hijo_setup() {
    // Imágenes destacadas
    add_theme_support( 'post-thumbnails' );

    // Tamaños de imagen personalizados
    add_image_size( 'hero-banner', 1440, 600, true );  // Recortar al centro
    add_image_size( 'card-thumb',  480,  320, true );

    // Menús de navegación
    register_nav_menus([
        'primary'   => __( 'Menú Principal', 'mi-tema-hijo' ),
        'footer'    => __( 'Menú Footer',    'mi-tema-hijo' ),
        'mobile'    => __( 'Menú Mobile',    'mi-tema-hijo' ),
    ]);

    // HTML5 para formularios, galerías, etc.
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ]);
}
add_action( 'after_setup_theme', 'mi_tema_hijo_setup' );


// ─────────────────────────────────────────
// 3. CARGAR FUNCIONES AUXILIARES
// ─────────────────────────────────────────

require_once get_stylesheet_directory() . '/inc/helpers.php';


// ─────────────────────────────────────────
// 4. OPTIMIZACIONES BÁSICAS
// ─────────────────────────────────────────

// Eliminar versión de WP del HTML (seguridad básica)
remove_action( 'wp_head', 'wp_generator' );

// Deshabilitar emojis de WordPress (reduce requests)
remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles',     'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles',  'print_emoji_styles' );

// Agregar atributo defer/async a scripts no críticos
function mi_tema_hijo_script_attributes( $tag, $handle ) {
    $defer_scripts = [ 'hijo-main-script' ];
    if ( in_array( $handle, $defer_scripts ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'mi_tema_hijo_script_attributes', 10, 2 );
