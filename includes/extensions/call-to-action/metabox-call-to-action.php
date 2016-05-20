<?php
defined('ABSPATH') or die("Direct access to the script does not allowed");

EJO_Call_To_Action_Metabox::init();

/**
 * Call To Action 
 */
class EJO_Call_To_Action_Metabox
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
        /* Add Metabox */
        add_action( 'add_meta_boxes', array($this, 'add_metabox') ); 

        /* Save Metabox */
        add_action( 'save_post', array($this, 'save_metabox'), 1, 1 ); 
    }

    /* Add Intro Metabox */
    public function add_metabox() 
    {
        /* Get post types from theme-support arguments. If none, then use posts and pages. */
        $post_types = get_post_types( array( 'public' => true ) );

        /* Add metabox for every give post_type */
        foreach ($post_types as $post_type) {
            add_meta_box( 
                'metabox',          // ID
                'Call To Action',   // Title
                array($this, 'render_metabox'),   // Function that will fill the box
                $post_type,         // Screen (a post type, 'link' or 'comment')
                'side',             // Location (normal/side/advanced)
                'low'              // Priority (high/low/default)
            );
        }
    }

    /* The post scripts metabox */
    public function render_metabox( $post ) 
    {
        /* Noncename needed to verify where the data originated */
        wp_nonce_field( 'ejo-call-to-action-metabox-' . $post->ID, 'ejo-call-to-action-meta-nonce' );

        /* Get Call To Action Data */
        $ejo_call_to_action = get_post_meta( $post->ID, '_ejo-call-to-action', true ); 

        /** 
         * Combine $ejo_call_to_action data with defaults
         * Then extract variables of this array
         */
        extract( wp_parse_args( $ejo_call_to_action, array( 
            'enabled' => '1',
            'title' => '',
            'text' => '',
            'post_id' => '',
            'link_text' => '',
        )));

        ?>
        <p>
            <label for="ejo-call-to-action-title"><?php _e('Title:') ?></label>
            <input type="text" class="widefat" id="ejo-call-to-action-title" name="ejo-call-to-action[title]" value="<?php echo $title; ?>" placeholder="Default" />
        </p>

        <p>
            <label for="ejo-call-to-action-text"><?php _e('Text:') ?></label>
            <input type="text" class="widefat" id="ejo-call-to-action-text" name="ejo-call-to-action[text]" value="<?php echo $text; ?>" placeholder="Default" />
        </p>

        <?php

        //* Get all pages
        $all_pages = get_pages();

        ?>
        <p>
            <label for="ejo-call-to-action-link">Link naar pagina:</label>
            <select id="ejo-call-to-action-link" class="widefat" name="ejo-call-to-action[post_id]">
                <option value=''>Default</option>
                <?php
                //* Show all pages as an option
                foreach ($all_pages as $page) {
                    printf( 
                        '<option value="%s" %s>%s</option>',
                        $page->ID,
                        selected($post_id, $page->ID, false),
                        $page->post_title
                    );
                } 
                ?>
            </select>
        </p>

        <p>
            <label for="ejo-call-to-action-link-text"><?php _e('Link text:') ?></label>
            <input type="text" class="widefat" id="ejo-call-to-action-link-text" name="ejo-call-to-action[link_text]" value="<?php echo $link_text; ?>" placeholder="Default" />
        </p>

        <p class="description" style="border:1px solid #ddd; padding:8px 10px; background-color:#fafafa;">Niks invullen = standaard content</p>

        <p>
            <label for="ejo-call-to-action-enabled">Status</label>
            <select id="ejo-call-to-action-enabled" class="widefat" name="ejo-call-to-action[enabled]">
                <option value='1'>Ingeschakeld</option>
                <option value='0' <?php selected($enabled, '0') ?>>Uitgeschakeld</option>
            </select>
        </p>

        <?php
    }

    /* Manage saving Metabox Data */
    public function save_metabox($post_id) 
    {
        /* Don't try to save the data under autosave, ajax, or future post. */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
            return;
        if ( defined( 'DOING_CRON' ) && DOING_CRON )
            return;

        /* Don't save if WP is creating a revision (same as DOING_AUTOSAVE?) */
        if ( wp_is_post_revision( $post_id ) )
            return;

        /* Check that the user is allowed to edit the post */
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;

        /* Verify where the data originated */
        if ( !isset($_POST['ejo-call-to-action-meta-nonce']) || !wp_verify_nonce( $_POST['ejo-call-to-action-meta-nonce'], 'ejo-call-to-action-metabox-' . $post_id ) )
            return;

        /* Save */
        if ( isset( $_POST['ejo-call-to-action'] ) )
            update_post_meta( $post_id, '_ejo-call-to-action', $_POST['ejo-call-to-action'] );
    }
}