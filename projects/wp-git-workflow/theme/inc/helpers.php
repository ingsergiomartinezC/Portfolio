<?php
/**
 * Mi Tema Hijo — inc/helpers.php
 * Funciones auxiliares reutilizables en templates.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Mostrar imagen destacada con tamaño personalizado y lazy load.
 *
 * @param int    $post_id  ID del post (default: post actual)
 * @param string $size     Tamaño registrado ('card-thumb', 'hero-banner', etc.)
 * @param string $class    Clases CSS adicionales
 */
function mi_tema_featured_image( $post_id = null, $size = 'card-thumb', $class = '' ) {
    $post_id = $post_id ?: get_the_ID();
    if ( ! has_post_thumbnail( $post_id ) ) return;

    echo get_the_post_thumbnail( $post_id, $size, [
        'class'   => "img-lazy {$class}",
        'loading' => 'lazy',
        'decoding'=> 'async',
    ]);
}

/**
 * Obtener tiempo estimado de lectura.
 *
 * @param  int $post_id
 * @return string  Ej: "5 min de lectura"
 */
function mi_tema_reading_time( $post_id = null ) {
    $post_id  = $post_id ?: get_the_ID();
    $content  = get_post_field( 'post_content', $post_id );
    $words    = str_word_count( wp_strip_all_tags( $content ) );
    $minutes  = max( 1, (int) ceil( $words / 200 ) );
    return "{$minutes} min de lectura";
}

/**
 * Breadcrumbs simples sin plugin.
 */
function mi_tema_breadcrumbs() {
    if ( is_front_page() ) return;

    echo '<nav class="breadcrumbs" aria-label="Breadcrumb"><ol>';
    echo '<li><a href="' . esc_url( home_url() ) . '">Inicio</a></li>';

    if ( is_category() || is_single() ) {
        $cat = get_the_category();
        if ( $cat ) {
            echo '<li><a href="' . esc_url( get_category_link( $cat[0]->term_id ) ) . '">'
                 . esc_html( $cat[0]->name ) . '</a></li>';
        }
        if ( is_single() ) {
            echo '<li aria-current="page">' . esc_html( get_the_title() ) . '</li>';
        }
    } elseif ( is_page() ) {
        echo '<li aria-current="page">' . esc_html( get_the_title() ) . '</li>';
    }

    echo '</ol></nav>';
}

/**
 * Truncar texto manteniendo palabras completas.
 *
 * @param  string $text
 * @param  int    $limit  Número de palabras
 * @return string
 */
function mi_tema_truncate( $text, $limit = 20 ) {
    $words = explode( ' ', wp_strip_all_tags( $text ) );
    if ( count( $words ) <= $limit ) return $text;
    return implode( ' ', array_slice( $words, 0, $limit ) ) . '…';
}
