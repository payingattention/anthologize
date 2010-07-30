<?php

if ( !class_exists( 'Anthologize_Ajax_Handlers' ) ) :

class Anthologize_Ajax_Handlers {

	function anthologize_ajax_handlers() {
		add_action( 'wp_ajax_get_tags', array( $this, 'get_tags' ) );
		add_action( 'wp_ajax_get_cats', array( $this, 'get_cats' ) );
		add_action( 'wp_ajax_get_posts_by', array( $this, 'get_posts_by' ) );
		add_action( 'wp_ajax_place_item', array( $this, 'place_item' ) );
		add_action( 'wp_ajax_merge_items', array( $this, 'merge_items' ) );
		add_action( 'wp_ajax_update_post_metadata', array( $this, 'update_post_metadata' ) );
		add_action( 'wp_ajax_remove_item_part', array( $this, 'remove_item_part' ) );
		add_action( 'wp_ajax_insert_new_item', array( $this, 'insert_new_item' ) );
		add_action( 'wp_ajax_insert_new_part', array( $this, 'insert_new_part' ) );
	}

    function resequence_items($item_seq_array) {
        // Update item sequence from associate array
    }

	function get_tags() {
		$tags = get_tags();

		$the_tags = '';
		foreach( $tags as $tag ) {
			$the_tags .= $tag->term_id . ':' . $tag->name . ',';
		}

		print_r($the_tags);
		die();
	}

	function get_cats() {
		$cats = get_categories();

		$the_cats = '';
		foreach( $cats as $cat ) {
			$the_cats .= $cat->term_id . ':' . $cat->name . ',';
		}

		print_r($the_cats);
		die();
	}

	function get_posts_by() {
		$term = $_POST['term'];
		$tagorcat = $_POST['tagorcat'];

		// Blech
		$t_or_c = ( $tagorcat == 'tag' ) ? 'tag_id' : 'cat';

		$args = array(
			'post_type' => array('post', 'page', 'imported_items' ),
			$t_or_c => $term,
			'posts_per_page' => -1
		);


		query_posts( $args );

		$response = '';

		while ( have_posts() ) {
			the_post();
			$response .= get_the_ID() . ':' . get_the_title() . ',';
		}

		print_r($response);

		die();
	}

    function place_item() {
        $project_id = $_POST['project_id'];
        $post_id = $_POST['post_id'];
        $dest_id = $_POST['dest_id'];
        $dest_seq = $_POST['dest_seq'];

        if ('true' != $_POST['new_item']) {
            $src_part_id = $_POST['src_id'];
            $src_seq = $_POST['src_seq'];
        } else {
            $src_seq_array = false;
            // TODO: We need to import an item
            // Set $post_id to new post ID
        }

        // TODO: Update the post_id part to dest_id


        $dest_seq_array = json_decode($dest_seq);
        // TODO: error check
        $this->resequence_items($dest_seq_array); 


        $src_seq_array = json_decode($src_seq);
        // TODO: error check
        $this->resequence_items($src_seq_array); 

        print "{post_id:$post_id}";

        die();
    }

    function merge_items() {
        $project_id = $_POST['project_id'];
        $post_id = $_POST['post_id'];

        if (is_array($_POST['child_post_ids'])) {
            $child_post_ids = $_POST['child_post_ids'];
        } else {
            $child_post_ids = Array($_POST['child_post_ids']);
        }

        $new_seq = $_POST['new_seq'];

        $new_seq_array = json_decode($new_seq);
        // TODO: error check
        
        // TODO: merge the posts
        //

        $this->resequence_items($new_seq_array); 

        die();
    }

    function update_post_metadata() {
        $project_id = $_POST['project_id'];
        $post_id = $_POST['post_id'];

        // TODO: What metadata do we expect?
        //
        // TODO: update metadata

        die();
    }

    function remove_item_part() {
        $project_id = $_POST['project_id'];
        $post_id = $_POST['post_id'];
        $new_seq = $_POST['new_seq'];

        // TODO: Remove the post

        $new_seq_array = json_decode($new_seq);
        // TODO: error check
        $this->resequence_items($new_seq_array); 

        die();
    }

    function insert_new_item() {
        $project_id = $_POST['project_id'];
        $part_id = $_POST['part_id'];
        $new_seq = $_POST['new_seq'];

        // TODO: Create a new bare item

        $new_seq_array = json_decode($new_seq);
        // TODO: error check
        $this->resequence_items($new_seq_array); 

        // TODO: What is all of the metadata we need to return?
        print "{post_id:$post_id,seq_num:$seq_num}";

        die();
    }
    
    function insert_new_part() {
        $project_id = $_POST['project_id'];
        $new_seq = $_POST['new_seq'];

        // TODO: what metadata do we expect?
        
        
        // TODO: Create a new bare part

        $new_seq_array = json_decode($new_seq);
        // TODO: error check
        $this->resequence_items($new_seq_array); 

        // TODO: What is all of the metadata we need to return?
        print "{part_id:$part_id,seq_num:$seq_num}";

        die();
    }
}

endif;

?>
