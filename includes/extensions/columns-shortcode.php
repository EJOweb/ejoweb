<?php
defined('ABSPATH') or die("Direct access to the script does not allowed");

/**
 * Columns Shortcode
 */
class EJO_Columns_Shortcode
{
    /**
	 * Instance of this class.
	 */
    protected static $instance = null;

    /**
     * Return an instance of this class.
     */
    public static function init() 
    {
        if ( !self::$instance )
            self::$instance = new self;
        return self::$instance;
    }

    /**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 */
    private function __construct() 
    {
        add_shortcode( 'ejo-columns', array($this, 'ejo_columns_shortcode') );
        add_action( 'init', array($this, 'ejo_columns_shortcode_ui') );
    }

    /**
     * Page Link Shortcode
     *
     */
    public function ejo_columns_shortcode( $atts, $content = "" ) 
    {
        $atts = shortcode_atts( array( 
            // 'inner_content' => '',
        ), $atts );
        ob_start();
        ?>


        <div class="columns colums-2">
            <?php //echo esc_html( $atts['inner_content'] ); ?>
            <?php echo esc_html( $content ); ?>
        </div>

        <?php
        return ob_get_clean();
    }
    
    /**
     * Page Link Shortcode UI
     *
     */
    public function ejo_columns_shortcode_ui() 
    {        
        if( ! function_exists( 'shortcode_ui_register_for_shortcode' ) )
            return;
            
        shortcode_ui_register_for_shortcode( 'ejo-columns', array( 
            'label'         => 'Columns',
            'listItemImage' => 'dashicons-editor-table',
            'inner_content' => array(
                'description'   => esc_html( 'REQUIRED. Any content can go inside here.' ),
            ),
            // 'attrs'         => array(
            //     array(
            //         'label'    => 'Pages',
            //         'attr'     => 'ids',
            //         'type'     => 'post_select',
            //         'query'    => array( 'post_type' => 'page'),
            //         'multiple' => true,
            //     )
            // )
        ) );
    }
    

  
}

EJO_Columns_Shortcode::init();

 /**
 * Register your shortcode as you would normally.
 * This is a simple example for a pullquote with a citation.
 */
add_shortcode( 'pullquote', function( $attr, $content = '' ) {
    $attr = wp_parse_args( $attr, array(
        'source' => ''
    ) );
    ob_start();
    ?>

    <section class="pullquote">
        <?php echo esc_html( $content ); ?><br/>
        <?php if ( ! empty( $attr['source'] ) ) : ?>
            <cite><em><?php echo esc_html( $attr['source'] ); ?></em></cite>
        <?php endif; ?>
    </section>

    <?php
    return ob_get_clean();
} );
/**
 * Register a UI for the Shortcode.
 * Pass the shortcode tag (string)
 * and an array or args.
 */
shortcode_ui_register_for_shortcode(
    'pullquote',
    array(
        // Display label. String. Required.
        'label' => 'Pullquote',
        // Icon/image for shortcode. Optional. src or dashicons-$icon. Defaults to carrot.
        'listItemImage' => 'dashicons-editor-quote',
        // Available shortcode attributes and default values. Required. Array.
        // Attribute model expects 'attr', 'type' and 'label'
        // Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
        'attrs' => array(
            array(
                'label' => 'Quote',
                'attr'  => 'content',
                'type'  => 'textarea',
            ),
            array(
                'label'       => 'Cite',
                'attr'        => 'source',
                'type'        => 'text',
                'placeholder' => 'Firstname Lastname',
                'description' => 'Optional',
            ),
        ),
    )
);