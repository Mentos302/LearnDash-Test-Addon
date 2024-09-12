<?php

class LearndashCourseMaterials {

	public static function init() {
		add_shortcode( 'ld_course_materials', [ self::class, 'renderCourseMaterials' ] );
		add_action( 'save_post', [ self::class, 'saveCourseMaterialsSettings' ] );
		add_action( 'add_meta_boxes', [ self::class, 'addCourseMaterialsMetaBox' ] );
		add_action( 'admin_enqueue_scripts', [ self::class, 'enqueueAdminScripts' ] );
	}

	public static function renderCourseMaterials( $attributes ) {
    $attributes = shortcode_atts( [ 'course_id' => '' ], $attributes );
    $courseId = intval( $attributes['course_id'] );

    if ( ! $courseId ) {
        return "Course ID is missing.";
    }

    $materials = get_post_meta( $courseId, '_ld_course_materials', true );
    $visibility = get_post_meta( $courseId, '_ld_course_materials_show_to', true ) ?: 'enrolled';
    $userId = get_current_user_id();

    if ( $visibility === 'enrolled' && ! sfwd_lms_has_access( $courseId, $userId ) ) {
        return "You must be enrolled in this course to view the materials.";
    }

    // Ensure $materials is a string
    if ( is_array( $materials ) ) {
        $materials = implode( ', ', $materials );
    }

    if ( ! empty( $materials ) ) {
        return '<div class="ld-course-materials">' . wp_kses_post( $materials ) . '</div>';
    }

    return "No materials available for this course.";
}


	public static function addCourseMaterialsMetaBox() {
		add_meta_box(
			'ld_course_materials_settings',
			'Course Materials Settings',
			[ self::class, 'renderCourseMaterialsMetaBox' ],
			'sfwd-courses',
			'side',
			'high'
		);
	}

	public static function renderCourseMaterialsMetaBox( $post ) {
		include plugin_dir_path( __FILE__ ) . '../admin/templates/course-materials-meta-box.php';
	}

	public static function enqueueAdminScripts() {
		wp_enqueue_script( 'course-materials-js', plugin_dir_url( __FILE__ ) . '../admin/js/course-materials.js', [ 'jquery' ], '1.0.0', true );
	}

	public static function saveCourseMaterialsSettings( $postId ) {
		if ( ! isset( $_POST['ld_course_materials_nonce'] ) || ! wp_verify_nonce( $_POST['ld_course_materials_nonce'], 'save_ld_course_materials_settings' ) ) {
			return $postId;
		}

		if ( ! current_user_can( 'edit_post', $postId ) ) {
			return $postId;
		}

		if ( isset( $_POST['ld_course_materials_show_to'] ) ) {
			$visibility = sanitize_text_field( $_POST['ld_course_materials_show_to'] );
			update_post_meta( $postId, '_ld_course_materials_show_to', $visibility );
		}
	}
}

