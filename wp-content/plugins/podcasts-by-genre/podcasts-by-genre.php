<?php
/*
Plugin Name: Podcast by Genre
Plugin URI: http://creedcreative.com
Description: Show Podcast by Genre
Version: 1.0
Author: Ing. Alejandro E. González
Author URI: https://www.linkedin.com/in/alejandro-gonz%C3%A1lez-35aa4114/
License: GNU
*/


require_once('admin-panel.php');

/**
 * defines the functionality of the "show_podcast" shortcode. The loop goes through the custom post type and displays them. Use the style of the theme.
 * @author: Alejandro Esteban González
 * @version: 1.0.0
 */

function show_podcast($atts)
{
    //get arguments of short code
    $args = shortcode_atts (
        array (
            'quantity' => 10
        ), $atts);

    //create a new WP_Query with post type Podcast
    $the_query = new WP_Query(array(
        'post_type' => 'podcast',
        'posts_per_page' => $atts['quantity'] 
    ));

    //the html outside the look at the beginning
    $start_html = '<div class="container podcast-container-plugin justify-content-center pt-5 pl-5" >';

    $rows = '';

    // position in the list
    $position = 1;

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {

            //get the post
            $the_query->the_post();

            //get post meta data for the post
            $values = get_post_custom($the_query->post->ID);

            //HTML with the format and style requested in the challenge
            $rows .= '<div class="row podcast-container mb-4 " >   
                        
                        <div class="col-sm-2">
                            <div class="podcast-circle-order">
                                <p class="podcast-order">' . $position . '</p>   
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="row podcast-item">
                                <div class="col-4 col-sm-2"><img class="podcast-image" src=' . $values['podcast_image'][0] . ' alt="' . get_the_title() . '"></div>
                                <div class="col-8 col-sm-5">
                                    <h3 class="podcast-title"> ' . get_the_title() . '</h3>
                                    <p class="podcast-publisher">by <span class="podcast-publisher-color">' . $values['podcast_publisher'][0] . '</span></p>   
                                    <p class="podcast-episodes">' . $values['podcast_total_episodes'][0] . ' episodes</p>
                                    <div class="container podcast-box-links">
                                        <div class="row mb-4">
                                            <div class="col-4 podcast-box-links-individual itunes">
                                                <a href="https://podcasts.apple.com/podcast/id' . $values['podcast_itunes_id'][0] . '" class="podcast-external-links" target="_blank">ITUNES</a>
                                            </div>
                                            <div class="col-4  podcast-box-links-individual web">
                                                <a href="' . $values['podcast_website'][0] . '" class="podcast-external-links" target="_blank">WEB</a>
                                            </div>
                                            <div class="col-4  podcast-box-links-individual rss">
                                                <a href="' . $values['podcast_rss'][0] . '" class="podcast-external-links" target="_blank">RSS</a>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-5">
                                    <p class="podcast-description">' . $values['podcast_description'][0] . '<p>
                                </div>
                            </div>
                        </div>

                        
                     </div>';

            $position++;
            wp_reset_postdata();
        }
    } else {
        $rows = "";
    }

    //the html outside the look at the end
    $close_html = '</div>';

    //concatenates the string with the information to display
    $data = $start_html . $rows . $close_html;

    return $data;
}

// Add shortCode  show_podcast
add_shortcode("show_podcast", "show_podcast");


/**
 * Define the custom post type Podcast.
 * @author: Alejandro Esteban González
 * @version: 1.0.0
 */
if (!function_exists('create_post_type_podcast')) {

    // Register Custom Post Type
    function create_post_type_podcast()
    {
        // define the array of labels
        $labels = array(
            'name'                  => _x('Podcasts', 'Post Type General Name', 'text_domain'),
            'singular_name'         => _x('Podcast', 'Post Type Singular Name', 'text_domain'),
            'menu_name'             => __('Podcasts', 'menu_podcasts'),
            'name_admin_bar'        => __('Podcast', 'text_domain'),
            'archives'              => __('Podcast Archives', 'text_domain'),
            'attributes'            => __('Podcast Attributes', 'text_domain'),
            'parent_item_colon'     => __('Parent Podcast:', 'text_domain'),
            'all_items'             => __('All Podcasts', 'text_domain'),
            'add_new_item'          => __('Add New Podcast', 'text_domain'),
            'add_new'               => __('Add New', 'text_domain'),
            'new_item'              => __('New Podcast', 'text_domain'),
            'edit_item'             => __('Edit Podcast', 'text_domain'),
            'update_item'           => __('Update Podcast', 'text_domain'),
            'view_item'             => __('View Podcast', 'text_domain'),
            'view_items'            => __('View Podcasts', 'text_domain'),
            'search_items'          => __('Search Podcast', 'text_domain'),
            'not_found'             => __('Not found', 'text_domain'),
            'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
            'featured_image'        => __('Featured Image', 'text_domain'),
            'set_featured_image'    => __('Set featured image', 'text_domain'),
            'remove_featured_image' => __('Remove featured image', 'text_domain'),
            'use_featured_image'    => __('Use as featured image', 'text_domain'),
            'insert_into_item'      => __('Insert into item', 'text_domain'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
            'items_list'            => __('Podcasts list', 'text_domain'),
            'items_list_navigation' => __('Podcasts list navigation', 'text_domain'),
            'filter_items_list'     => __('Filter items list', 'text_domain'),
        );

        // define the array with the parameters of Podcast 
        $args = array(
            'label'                 => __('Podcast', 'text_domain'),
            'description'           => __('Post Type Description', 'text_domain'),
            'labels'                => $labels,
            'supports'              => array('title',),
            'taxonomies'            => array('category', 'post_tag'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => esc_url(plugins_url('assets/images/podcast.png', __FILE__)),
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );

        //register the custom post type "Podcast"
        register_post_type('Podcast', $args);
    }
}
//hook the post creation function to init  
add_action('init', 'create_post_type_podcast', 0);



/**
 * Add wordpress dashboard menu shortcuts to plugin settings menu
 * @author: Alejandro Esteban González
 * @version: 1.0.0
 */
function create_configuration_menu()
{
    // //Create the route "podcast_process_json_file" to call the function import_json_file
    add_submenu_page(
        '',
        'Import podcast from Json file',
        'Import',
        'manage_options',
        'import_podcast_from_json_file',
        'import_json_file'
    );

    //Create an entry inthe desktop menu for access to Plugin Administration
    add_menu_page(
        __('Podcast by Genre - Plugin Administration', 'textdomain'),
        'Podcast by Genre',
        'manage_options',
        'podcast_configuration',
        'show_configuration',
        esc_url(plugins_url('assets/images/podcast-setting.png', __FILE__)),
        6
    );
}

//hook the function "create_configuration_menu" to admin_menu  
add_action('admin_menu', 'create_configuration_menu');






// Create a meta box to custom post type to contain the post meta data
function add_extra_fields_to_podcast()
{
    add_meta_box('meta-box-id', __('Podcast Information', 'textdomain'), 'show_metabox_with_extra_fields', 'Podcast');
}

//hooks the function "add_extra_fields_to_podcast" to add_meta_boxes
add_action('add_meta_boxes', 'add_extra_fields_to_podcast');

/**
 * Display the custom post data to edit
 * @author: Alejandro Esteban González
 * @version: 1.0.0
 */
function show_metabox_with_extra_fields($post)
{
    $values = get_post_custom($post->ID);
    $podcast_id = isset($values['podcast_id']) ? esc_attr($values['podcast_id'][0]) : '';
    $podcast_publisher = isset($values['podcast_publisher']) ? esc_attr($values['podcast_publisher'][0]) : '';
    $podcast_image = isset($values['podcast_image']) ? esc_attr($values['podcast_image'][0]) : '';
    $podcast_thumbnail = isset($values['podcast_thumbnail']) ? esc_attr($values['podcast_thumbnail'][0]) : '';
    $podcast_listennotes_url = isset($values['podcast_listennotes_url']) ? esc_attr($values['podcast_listennotes_url'][0]) : '';
    $podcast_total_episodes = isset($values['podcast_total_episodes']) ? esc_attr($values['podcast_total_episodes'][0]) : '';
    $podcast_description = isset($values['podcast_description']) ? esc_attr($values['podcast_description'][0]) : '';
    $podcast_itunes_id = isset($values['podcast_itunes_id']) ? esc_attr($values['podcast_itunes_id'][0]) : '';
    $podcast_rss = isset($values['podcast_rss']) ? esc_attr($values['podcast_rss'][0]) : '';
    $podcast_language = isset($values['podcast_language']) ? esc_attr($values['podcast_language'][0]) : '';
    $podcast_country = isset($values['podcast_country']) ? esc_attr($values['podcast_country'][0]) : '';
    $podcast_website = isset($values['podcast_website']) ? esc_attr($values['podcast_website'][0]) : '';
    $podcast_explicit_content = isset($values['podcast_explicit_content']) ? esc_attr($values['podcast_explicit_content'][0]) : '';
    $podcast_is_claimed = isset($values['podcast_is_claimed']) ? esc_attr($values['podcast_is_claimed'][0]) : '';

    $podcast_type = isset($values['podcast_type']) ? esc_attr($values['podcast_type'][0]) : '';
    $podcast_genre_ids = isset($values['podcast_genre_ids']) ? esc_attr($values['podcast_genre_ids'][0]) : '';
?>
    <table class="form-table" role="presentation">

        <tbody>
            <tr>
                <th scope="row"><label for="podcast_id">Podcast ID</label></th>
                <td><input type="text" name="podcast_id" id="podcast_id" value="<?php echo $podcast_id; ?> " class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_publisher">Publisher</label></th>
                <td><input type="text" name="podcast_publisher" id="podcast_publisher" value="<?php echo $podcast_publisher; ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_image">Image</label></th>
                <td><input type="text" name="podcast_image" id="podcast_image" value="<?php echo $podcast_image; ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_thumbnail">Thumbnail</label></th>
                <td><input type="text" name="podcast_thumbnail" id="podcast_thumbnail" value="<?php echo $podcast_thumbnail; ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_listennotes_url">Listen notes</label></th>
                <td><input type="text" name="podcast_listennotes_url" id="podcast_listennotes_url" value="<?php echo $podcast_listennotes_url; ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_total_episodes">Total episodes</label></th>
                <td><input type="text" name="podcast_total_episodes" id="podcast_total_episodes" value="<?php echo $podcast_total_episodes; ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_explicit_content">Explicit Content</label></th>
                <td><input type="checkbox" id="podcast_explicit_content" name="podcast_explicit_content" <?php checked($podcast_explicit_content, '1'); ?> class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_description">Description</label></th>
                <td><textarea name="podcast_description" id="podcast_description" rows="10" class="regular-text"><?php echo $podcast_description; ?></textarea></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_itunes_id">Itunes ID</label></th>
                <td><input type="text" name="podcast_itunes_id" id="podcast_itunes_id" value="<?php echo $podcast_itunes_id; ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_rss">Rss</label></th>
                <td><input type="text" name="podcast_rss" id="podcast_rss" value="<?php echo $podcast_rss; ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_language">Language</label></th>
                <td><input type="text" name="podcast_language" id="podcast_language" value="<?php echo $podcast_language; ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_country">Country</label></th>
                <td><input type="text" name="podcast_country" id="podcast_country" value="<?php echo $podcast_country; ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_website">Podcast Website</label></th>
                <td><input type="text" name="podcast_website" id="podcast_website" value="<?php echo $podcast_website; ?>" class="regular-text" /></td>
            </tr>
            <tr>
                <th scope="row"><label for="podcast_is_claimed">Is Claimed</label></th>
                <td><input type="checkbox" id="podcast_is_claimed" name="podcast_is_claimed" <?php checked($podcast_is_claimed, '1'); ?> class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_type">Type</label></th>
                <td><input type="text" name="podcast_type" id="podcast_type" value="<?php echo $podcast_type; ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th scope="row"><label for="podcast_genre_ids">Genre Ids</label></th>
                <td><input type="text" name="podcast_genre_ids" id="podcast_genre_ids" value="<?php echo $podcast_genre_ids; ?>" class="regular-text" /></td>
            </tr>
        </tbody>
    </table>

<?php
}

//hooks the function "save_data_from_extra_fields" to save_post
add_action('save_post', 'save_data_from_extra_fields');

/**
 * Save the data custom post type
 * @author: Alejandro Esteban González
 * @version: 1.0.0
 */
function save_data_from_extra_fields($post_id)
{
    // Verify if we're doing an auto save  
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

       // now we can actually save the data  
    $allowed = array(
        'a' => array( // on allow a tags  
            'href' => array() // and those anchors can only have href attribute  
        )
    );

    //save the post meta data
    if (isset($_POST['podcast_id']))
        update_post_meta($post_id, 'podcast_id', wp_kses($_POST['podcast_id'], $allowed));

    if (isset($_POST['podcast_publisher']))
        update_post_meta($post_id, 'podcast_publisher', esc_attr($_POST['podcast_publisher']));

    if (isset($_POST['podcast_publisher']))
        update_post_meta($post_id, 'podcast_publisher', esc_attr($_POST['podcast_publisher']));

    if (isset($_POST['podcast_image']))
        update_post_meta($post_id, 'podcast_image', esc_attr($_POST['podcast_image']));

    if (isset($_POST['podcast_thumbnail']))
        update_post_meta($post_id, 'podcast_thumbnail', esc_attr($_POST['podcast_thumbnail']));

    if (isset($_POST['podcast_listennotes_url']))
        update_post_meta($post_id, 'podcast_listennotes_url', esc_attr($_POST['podcast_listennotes_url']));

    if (isset($_POST['podcast_total_episodes']))
        update_post_meta($post_id, 'podcast_total_episodes', esc_attr($_POST['podcast_total_episodes']));

    if (isset($_POST['podcast_description']))
        update_post_meta($post_id, 'podcast_description', esc_attr($_POST['podcast_description']));

    if (isset($_POST['podcast_itunes_id']))
        update_post_meta($post_id, 'podcast_itunes_id', esc_attr($_POST['podcast_itunes_id']));

    if (isset($_POST['podcast_rss']))
        update_post_meta($post_id, 'podcast_rss', esc_attr($_POST['podcast_rss']));

    if (isset($_POST['podcast_language']))
        update_post_meta($post_id, 'podcast_language', esc_attr($_POST['podcast_language']));

    if (isset($_POST['podcast_country']))
        update_post_meta($post_id, 'podcast_country', esc_attr($_POST['podcast_country']));

    if (isset($_POST['podcast_website']))
        update_post_meta($post_id, 'podcast_website', esc_attr($_POST['podcast_website']));

    if (isset($_POST['podcast_is_claimed']))
        update_post_meta($post_id, 'podcast_is_claimed', esc_attr($_POST['podcast_is_claimed']));

    if (isset($_POST['podcast_type']))
        update_post_meta($post_id, 'podcast_type', esc_attr($_POST['podcast_type']));

    if (isset($_POST['podcast_genre_ids']))
        update_post_meta($post_id, 'podcast_genre_ids', esc_attr($_POST['podcast_genre_ids']));
}
