<?php
$courseId = $post->ID;
$shortcode = '[ld_course_materials course_id="' . $courseId . '"]';
$visibility = get_post_meta( $courseId, '_ld_course_materials_show_to', true ) ?: 'enrolled';
?>
<p>
	<label for="ld_course_materials_show_to">Show Course Materials to:</label><br>
	<select id="ld_course_materials_show_to" name="ld_course_materials_show_to">
		<option value="all" <?php selected( $visibility, 'all' ); ?>>All Users</option>
		<option value="enrolled" <?php selected( $visibility, 'enrolled' ); ?>>Enrolled Users Only</option>
	</select>
</p>

<p>
	<label for="ld_course_materials_shortcode">Click to Copy Shortcode:</label><br>
	<input type="text" id="ld_course_materials_shortcode" value="<?php echo esc_attr( $shortcode ); ?>"
		readonly="readonly" style="width: 100%; cursor: pointer;">
</p>