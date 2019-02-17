<?php

namespace PTH;

/**
 * Class FlushFrontendCacheComponent
 *
 * @package PTH
 */
class FlushFrontendCacheComponent extends Singleton
{
    /**
     * Define frontend cache flush url
     */
    const FRONTEND_FLUSH_URL = 'http://127.0.0.1:3000/flush-ssr-cache/';

    /**
     * FlushFrontendCacheComponent constructor.
     */
    protected function __construct()
    {
        if (is_admin()) {
            add_action('deleted_post', [$this, 'flushFrontendCache']);
            add_action('edit_post', [$this, 'flushFrontendCache']);
            add_action('delete_attachment', [$this, 'flushFrontendCache']);
            add_action('admin_bar_menu', [$this, 'addFlushCacheButton'], 100);
            //TODO flush cache on save setting
        }
    }

    /**
     * Flush frontend application cache
     */
    public static function flushFrontendCache()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::FRONTEND_FLUSH_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST"
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        Log::log([$response, $err]);

    }

    /**
     * Add flush cache button to admin bar
     *
     * @param $wp_admin_bar
     */
    public static function addFlushCacheButton($wp_admin_bar)
    {
        ?>

        <script type="application/javascript">
            function clearFrontendCache() {

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "<?php echo self::FRONTEND_FLUSH_URL; ?>",
                    "method": "POST"
                };

                jQuery.ajax(settings).done(function (response) {
                    alert(response);
                });

                return false;
            }
        </script>

        <?php
        $args = array(
            'id' => 'cache-cleaner',
            'title' => __('Clean frontend cache', Theme::TEXT_DOMAIN),
            'href' => '#',
            'meta' => array(
                'onclick' => 'clearFrontendCache()'
            )
        );

        $wp_admin_bar->add_node($args);
    }
}

?>