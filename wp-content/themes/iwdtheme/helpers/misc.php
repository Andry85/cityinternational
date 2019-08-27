<?php
namespace IllicitWeb;

function definedtrue($const)
{
    return defined($const) && constant($const);
}

function output_json($data, $prettyprint=false)
{
    json_headers();

    $opt = $prettyprint ? JSON_PRETTY_PRINT : 0;
    
    echo json_encode($data, $opt);
    
    die;
}

// Warning: Will only flush rewrite rules when WP_DEBUG is defined true.
// Intended for use during development of plugins which make use of custom post
// types/taxonomies.
function flush_rewrite_rules()
{
    global $wp_rewrite;
    
    if (WP_DEBUG)
    {
        $wp_rewrite->flush_rules();
    }
}

// Detects any mobile device (phones or tablets).
function on_mobile()
{
    $detect = new Mobile_Detect;
    
    return $detect->isMobile();
}

function print_social_links_font_table()
{
    $chars = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,./;\'#[]<>?:@~{}-=_+!"£$%^&*()\\|`¬');
    ?>
    <table class="social-links-table" style="margin: 20px auto; font-size: 40px; line-height: normal; ">
        <?php foreach ($chars as $char): ?>
        <tr>
            <td style="font-weight:bold; padding: 15px; "><?= $char ?></td>
            <td style="font-family: si; padding: 15px; "><?= $char ?></td>
        </tr>
        <?php endforeach ?>
    </table>
    <?php
}
