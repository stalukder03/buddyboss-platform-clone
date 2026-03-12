<?php

/**
 * The template for member courses for tutorlms.
 *
 * This template can be overridden by copying it to yourtheme/buddypress/members/single/tutor/courses.php.
 *
 * @since 2.4.40
 *
 * @package BuddyBoss\TutorLMS
 *
 * @version 1.0.0
 */

$current_course_subtab = 'enrolled-courses';
if (class_exists('BB_TutorLMS_Profile')) {
    $bb_tutorlms_profile = BB_TutorLMS_Profile::get_instance();
    $current_course_subtab = $bb_tutorlms_profile->profile_course_subtab;
}

$group_id = bp_get_group_id();
if (! $group_id) {
    return;
}

$bb_tutorlms_groups = bb_load_tutorlms_group()->get(
    array(
        'group_id' => $group_id,
        'fields'   => 'course_id',
        'per_page' => false,
    ),
);

?>

<!-- <div class="bb-rl-screen-content"> -->
<?php
if (! function_exists('bb_enable_content_counts') || bb_enable_content_counts()) {
    $count = count($bb_tutorlms_groups['courses']);
?>
    <div class="bb-item-count" style="margin-top:40px;margin-bottom:-32px;">
        <?php
        /* translators: %d is the courses count */
        printf(
            wp_kses(_n('<span class="bb-count">%d</span> Course', '<span class="bb-count">%d</span> Courses', $count, 'buddyboss-pro'), array('span' => array('class' => true))),
            $count
        );
        ?>
    </div>
<?php
    unset($count);
}

if (! empty($bb_tutorlms_groups['courses']) && tutor_utils()->count($bb_tutorlms_groups['courses'])) {
    $course_ids_string = implode(',', $bb_tutorlms_groups['courses']);
    echo tutor_lms()->shortcode->tutor_course(array('id' => $course_ids_string, 'show_pagination' => 'on'));
} else {
    if ('instructor-courses' === $current_course_subtab) {
        bp_nouveau_user_feedback('tutorlms-created-courses-loop-none');
    } else {
        bp_nouveau_user_feedback('tutorlms-courses-loop-none');
    }
}
?>
<!-- </div> -->