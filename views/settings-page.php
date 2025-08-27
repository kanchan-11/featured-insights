<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form method="post" id="shortcodeForm" action="">
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Select Posts', 'featured-insights'); ?></th>
                <td>
                    <div id="postCheckboxes" style="max-height:300px; overflow-y:auto; border:1px solid #ccc; padding:10px;">
                        <?php
                        $all_posts = get_posts(array('numberposts' => -1, 'post_type' => 'post'));
                        foreach ($all_posts as $post) {
                            echo '<label style="display:block;margin-bottom:5px;">';
                            echo '<input type="checkbox" class="post-checkbox" value="' . esc_attr($post->ID) . '"> ';
                            echo esc_html($post->post_title) . ' (ID: ' . $post->ID . ')';
                            echo '</label>';
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        <p>
            <button type="button" class="button button-primary" id="generateShortcode">
                <?php esc_html_e('Generate Shortcode', 'featured-insights'); ?>
            </button>
        </p>
    </form>

    <input type="text" id="shortcode" value="" readonly style="width: auto; max-width: 100%;" />
    <p><em><?php esc_html_e('Copy this shortcode and paste it into any page or post.', 'featured-insights'); ?></em></p>
</div>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function () {
    const shortcodeOutput = document.getElementById("shortcode");
    const generateBtn = document.getElementById("generateShortcode");

    function updateShortcode() {
        const checked = document.querySelectorAll(".post-checkbox:checked");
        const selectedIds = Array.from(checked).map(cb => cb.value);

        let shortcode = '[featured_insights';
        if (selectedIds.length > 0) {
            shortcode += ` id='${selectedIds.join(',')}'`;
        }
        shortcode += ']';

        shortcodeOutput.value = shortcode;
        adjustInputWidth();
    }

    function adjustInputWidth() {
        const tempSpan = document.createElement("span");
        tempSpan.style.visibility = "hidden";
        tempSpan.style.whiteSpace = "nowrap";
        tempSpan.style.position = "absolute";
        tempSpan.style.fontSize = window.getComputedStyle(shortcodeOutput).fontSize;
        tempSpan.style.fontFamily = window.getComputedStyle(shortcodeOutput).fontFamily;
        tempSpan.textContent = shortcodeOutput.value;

        document.body.appendChild(tempSpan);
        const width = Math.min(tempSpan.offsetWidth + 20, window.innerWidth - 50); 
        shortcodeOutput.style.width = `${width}px`;
        document.body.removeChild(tempSpan);
    }

    generateBtn.addEventListener("click", updateShortcode);
});
</script>
