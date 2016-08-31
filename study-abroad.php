<?php

/*
 *
 * Plugin Name: Common - Study Abroad CPT
 * Description: Study Abroad plugin, for use on applicable CAH sites
 * Author: Austin Tindle
 *
 */

// Study Abroad

add_action("admin_init", "study_init");
add_action('save_post', 'save_study');
add_action('init', 'create_study_type');

function create_study_type() {
    $args = array(
        'label' => 'Study Abroad',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'study-abroad'),
        'query_var' => true,
        'supports' => array(
            'title',
            'editor',
            'revisions',
            'thumbnail',
            'categories',
        ),
        'menu_icon' => 'dashicons-book'
    );
 
    register_post_type( 'study-abroad' , $args );
}

function study_init() {
    add_meta_box("study-meta", "Options", "study_meta", "study-abroad", "normal", "low");
}

function study_meta(){
    global $post;
    $custom = get_post_custom($post->ID);
    $studyurl = $custom["studyurl"][0];
    $category = $custom["category"][0];
    $development = $custom["development"][0];
    $start = $custom["start"][0];
    $end = $custom["end"][0];

    ?>
    <table>
        <tr>
            <td style="text-align:left"><label>URL </label></td>
            <td><input placeholder="External URL if any" type="text" name="studyurl" value="<?php echo $studyurl;?>" size="50"></td>
        </tr>
        <tr>
            <td style="text-align:left"><label>Categories: </label></td>
            <td>
                <label class="radio-inline"><input type="radio" name="category" value="Short-Term" <?php if ($category == 'Short-Term') echo "checked"?>>Short-Term</label>
                <label class="radio-inline"><input type="radio" name="category" value="Exchange" <?php if ($category == 'Exchange') echo "checked"?>>Exchange</label>
                <label class="radio-inline"><input type="radio" name="category" value="Internship" <?php if ($category == 'Internship') echo "checked"?>>Internship</label>
            </td>
        </tr>
        <tr>
            <td style="text-align:left"><label>Status: </label></td>
            <td>
                <label class="checkbox-inline"><input type="checkbox" name="development" value="development" <?php if ($development == true) echo "checked"?>>Under Development</label>
            </td>
        </tr>
        <tr>
            <td style="text-align:left"><label>Date Range: </label></td>
            <td>
                <input type="date" name="start" value="<?php echo $start ?>"> to <input type="date" name="end" value="<?php echo $end ?>">
            </td>

        </tr>
    </table>
    <?php
}

function save_study() {
    global $post;
	update_post_meta($post->ID, "studyurl", $_POST["studyurl"]);
    update_post_meta($post->ID, "category", $_POST["category"]);
    update_post_meta($post->ID, "development", $_POST["development"]);
    update_post_meta($post->ID, "start", $_POST["start"]);
    update_post_meta($post->ID, "end", $_POST["end"]);
}

?>
