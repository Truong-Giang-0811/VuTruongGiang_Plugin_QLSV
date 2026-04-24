<?php
// Tạo Shortcode
function sm_student_list_shortcode()
{
    // Tham số Query: Lấy tất cả bài viết type = 'student'
    $args = array(
        'post_type'      => 'student',
        'posts_per_page' => -1, // Lấy tất cả
        'post_status'    => 'publish'
    );

    $query = new WP_Query($args);

    // Sử dụng output buffering để gom mã HTML
    ob_start();

    if ($query->have_posts()) : ?>
        <style>
            .student-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .student-table th,
            .student-table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            .student-table th {
                background-color: #f2f2f2;
                font-weight: bold;
            }
        </style>

        <table class="student-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>MSSV</th>
                    <th>Họ tên</th>
                    <th>Lớp</th>
                    <th>Ngày sinh</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stt = 1;
                while ($query->have_posts()) : $query->the_post();
                    // Lấy Meta Data
                    $mssv = get_post_meta(get_the_ID(), '_student_mssv', true);
                    $lop = get_post_meta(get_the_ID(), '_student_lop', true);
                    $ngay_sinh = get_post_meta(get_the_ID(), '_student_ngay_sinh', true);

                    // Format lại ngày sinh sang dd/mm/yyyy cho đẹp (nếu có dữ liệu)
                    $formatted_date = !empty($ngay_sinh) ? date('d/m/Y', strtotime($ngay_sinh)) : '';
                ?>
                    <tr>
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo esc_html($mssv); ?></td>
                        <td><strong><?php echo get_the_title(); ?></strong></td>
                        <td><?php echo esc_html($lop); ?></td>
                        <td><?php echo esc_html($formatted_date); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
<?php
        wp_reset_postdata(); // Đặt lại post data
    else :
        echo '<p>Hiện chưa có sinh viên nào.</p>';
    endif;

    // Trả về HTML
    return ob_get_clean();
}
add_shortcode('danh_sach_sinh_vien', 'sm_student_list_shortcode');
