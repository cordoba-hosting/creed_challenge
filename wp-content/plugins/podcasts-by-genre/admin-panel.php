<?php

/**
 * Show Plugin Panel Control
 * @author: Alejandro Esteban González
 * @version: 1.0.0
 */
function show_configuration()
{

?>
    <div class="wrap">
        <h1>Podcast by Genre Plugin Configuration</h1>

        <h3>Import podcast</h3>
        <form action="<?php menu_page_url( 'import_podcast_from_json_file' ) ?>" method="post" enctype="multipart/form-data">
            <table class="form-table" role="presentation">

                <tbody>
                    <tr>
                        <th scope="row"><label for="file_json">Please select a json file with podscast information</label></th>
                        <td><input type="file" id="file_json" name="file_json" accept=".json"></td>

                    </tr>
                    <tr>
                        <th scope="row"><input type="submit" value="Import Podcast from json"></th>
                    </tr>
                </tbody>
            </table>

            <hr>
        </form>
    </div>


<?php

}


/**
 * Receive a json file with podcast information and store it in the Custom Post Type created for this purpose
 * @author: Alejandro Esteban González
 * @version: 1.0.0
 */

function import_json_file()
{

    // Check if file has a name.
    if (basename($_FILES["file_json"]["name"]) != "") {

        $upload_dir   = wp_upload_dir();
        $target_file = $upload_dir['path'] . '/' . basename($_FILES["file_json"]["name"]);

        //// Move the json file to /wp-upload
        if (move_uploaded_file($_FILES["file_json"]["tmp_name"], $target_file)) {

            //get the contents of json file
            $json = file_get_contents($target_file);

            // Decode the JSON file content into an array
            $json_data = json_decode($json, true);

            //podcast record counter
            $counter = 0;

            // Loop through the array inserting the custom posts type
            foreach ($json_data as $category) {

                foreach ($category['podcasts'] as $podcast) {
                    $post_data = array(
                        'post_title' => wp_strip_all_tags($podcast['title']),
                        'post_content ' => '',
                        'post_type' => 'podcast',
                        'post_status' => 'publish',
                        'post_author' => 1,
                    );

                    //insert custom post type
                    $post_id = wp_insert_post($post_data);
                    
                    //insert post meta
                    update_post_meta($post_id, 'podcast_id', $podcast['id']);
                    update_post_meta($post_id, 'podcast_publisher', $podcast['publisher']);
                    update_post_meta($post_id, 'podcast_image', $podcast['image']);
                    update_post_meta($post_id, 'podcast_thumbnail', $podcast['thumbnail']);
                    update_post_meta($post_id, 'podcast_listennotes_url', $podcast['listennotes_url']);
                    update_post_meta($post_id, 'podcast_total_episodes', $podcast['total_episodes']);
                    update_post_meta($post_id, 'podcast_description', wp_strip_all_tags($podcast['description']));
                    $explicit_content = (array_key_exists('explicit_content', $podcast)) ? $podcast['explicit_content'] : null;
                    update_post_meta($post_id, 'podcast_explicit_content', $explicit_content);
                    update_post_meta($post_id, 'podcast_itunes_id', $podcast['itunes_id']);
                    update_post_meta($post_id, 'podcast_rss', $podcast['rss']);
                    update_post_meta($post_id, 'podcast_language', $podcast['language']);
                    update_post_meta($post_id, 'podcast_country', $podcast['country']);
                    update_post_meta($post_id, 'podcast_website', $podcast['website']);
                    update_post_meta($post_id, 'podcast_is_claimed', $podcast['is_claimed']);
                    update_post_meta($post_id, 'podcast_type', $podcast['type']);
                    update_post_meta($post_id, 'podcast_genre_ids', $podcast['genre_ids']);

                    $counter++;
                    
                }

                
            }
            echo "<h1>".$counter." records were imported from JSON file</h1>";
        } else {
            echo "<h1>Error!</h1>";
        }
    }
}


?>