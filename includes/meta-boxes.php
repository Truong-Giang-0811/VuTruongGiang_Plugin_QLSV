<?php
// 1. Khởi tạo Meta Box
function sm_add_student_meta_boxes()
{
    add_meta_box(
        'student_info_meta_box',       // ID của meta box
        'Thông tin chi tiết Sinh viên', // Tiêu đề
        'sm_render_student_meta_box',  // Hàm callback hiển thị HTML
        'student',                     // Post type hiển thị
        'normal',                      // Vị trí hiển thị (normal/side)
        'default'
    );
}
add_action('add_meta_boxes', 'sm_add_student_meta_boxes');

// 2. Hiển thị form nhập liệu (HTML)
function sm_render_student_meta_box($post)
{
    // Tạo Nonce field để bảo mật
    wp_nonce_field('sm_save_student_data', 'sm_student_meta_box_nonce');

    // Lấy dữ liệu cũ nếu đã có
    $mssv = get_post_meta($post->ID, '_student_mssv', true);
    $lop = get_post_meta($post->ID, '_student_lop', true);
    $ngay_sinh = get_post_meta($post->ID, '_student_ngay_sinh', true);

    // Giao diện nhập liệu
?>
    <table class="form-table">
        <tr>
            <th><label for="sm_mssv">Mã số sinh viên (MSSV)</label></th>
            <td><input type="text" id="sm_mssv" name="sm_mssv" value="<?php echo esc_attr($mssv); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="sm_lop">Lớp/Chuyên ngành</label></th>
            <td>
                <select id="sm_lop" name="sm_lop">
                    <option value="">-- Chọn chuyên ngành --</option>
                    <option value="CNTT" <?php selected($lop, 'CNTT'); ?>>Công nghệ thông tin</option>
                    <option value="Kinh tế" <?php selected($lop, 'Kinh tế'); ?>>Kinh tế</option>
                    <option value="Marketing" <?php selected($lop, 'Marketing'); ?>>Marketing</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="sm_ngay_sinh">Ngày sinh</label></th>
            <td><input type="date" id="sm_ngay_sinh" name="sm_ngay_sinh" value="<?php echo esc_attr($ngay_sinh); ?>" /></td>
        </tr>
    </table>
<?php
}

// 3. Xử lý lưu dữ liệu
function sm_save_student_meta_box_data($post_id)
{
    // Kiểm tra Nonce
    if (! isset($_POST['sm_student_meta_box_nonce']) || ! wp_verify_nonce($_POST['sm_student_meta_box_nonce'], 'sm_save_student_data')) {
        return;
    }

    // Tránh autosave ghi đè dữ liệu
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Kiểm tra quyền của người dùng
    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sanitize và lưu MSSV
    if (isset($_POST['sm_mssv'])) {
        update_post_meta($post_id, '_student_mssv', sanitize_text_field($_POST['sm_mssv']));
    }

    // Sanitize và lưu Lớp/Chuyên ngành
    if (isset($_POST['sm_lop'])) {
        update_post_meta($post_id, '_student_lop', sanitize_text_field($_POST['sm_lop']));
    }

    // Sanitize và lưu Ngày sinh
    if (isset($_POST['sm_ngay_sinh'])) {
        update_post_meta($post_id, '_student_ngay_sinh', sanitize_text_field($_POST['sm_ngay_sinh']));
    }
}
add_action('save_post', 'sm_save_student_meta_box_data');
