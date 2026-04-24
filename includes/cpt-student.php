<?php
// Đăng ký Custom Post Type 'Sinh viên'
function sm_register_student_cpt()
{
    $labels = array(
        'name'               => 'Sinh viên',
        'singular_name'      => 'Sinh viên',
        'menu_name'          => 'Sinh viên',
        'add_new'            => 'Thêm mới',
        'add_new_item'       => 'Thêm Sinh viên mới',
        'edit_item'          => 'Sửa thông tin',
        'all_items'          => 'Tất cả Sinh viên',
        'search_items'       => 'Tìm kiếm',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-welcome-learn-more', // Icon cái mũ cử nhân
        'supports'           => array('title', 'editor'), // Hỗ trợ Họ tên (title) và Tiểu sử (editor)
        'has_archive'        => true,
    );

    register_post_type('student', $args);
}
add_action('init', 'sm_register_student_cpt');
