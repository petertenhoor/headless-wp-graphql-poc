<?php

namespace PTH;

/**
 * Class GraphqlCacheComponent
 *
 * @package PTH
 */
class GraphqlCacheComponent extends Singleton
{
    /**
     * Define cache constants
     */
    const CACHE_DURATION_SECONDS = 0;
    const CACHE_GROUP_NAME = 'wpgraphql_cache';
    const CACHE_HEADER_NAME_SERVER = 'HTTP_X_GRAPHQL_CACHE';
    const CACHE_HEADER_NAME_CLIENT = 'x-graphql-cache';
    const CACHE_STATUS_HEADER_NAME = 'wp-graphql-cache-status:';

    /**
     * GraphqlCacheComponent constructor.
     */
    protected function __construct()
    {
        add_action('do_graphql_request', [$this, 'handleGraphqlRequest']);
        add_action('graphql_return_response', [$this, 'handleGraphqlResponse']);
        add_filter('graphql_access_control_allow_headers', [$this, 'allowCustomHeader']);
    }

    /**
     * Handle graphql request
     */
    public function handleGraphqlRequest()
    {
        //get cache key from headers
        $cacheKey = self::getCacheKey();

        //return if no cache key found in headers
        if ($cacheKey === false) return;

        //get cached data from server
        $cachedData = wp_cache_get($cacheKey, self::CACHE_GROUP_NAME);

        if ($cachedData !== false) {
            header('Content-Type: application/json');
            header(self::CACHE_STATUS_HEADER_NAME . 'hit');
            header('Access-Control-Allow-Headers: Content-Type');
            header("Access-Control-Allow-Origin: *");
            echo $cachedData;
            die();
        }

        //we missed, set header
        header(self::CACHE_STATUS_HEADER_NAME . 'miss');
    }

    /**
     * Handle graphqpl response
     *
     * @param $response
     */
    public function handleGraphqlResponse($response)
    {
        //get cache key from headers
        $cacheKey = self::getCacheKey();

        //return if no cache key found in headers
        if ($cacheKey === false) return;

        //add graphql response to the cache if it has no errors
        if (property_exists($response, "errors") && count($response->errors) === 0) {
            wp_cache_add($cacheKey, wp_json_encode($response->toArray()), self::CACHE_GROUP_NAME, self::CACHE_DURATION_SECONDS);
        }
    }

    /**
     * Add custom header to allowed headers
     *
     * @param $headers
     * @return array
     */
    public static function allowCustomHeader($headers)
    {
        $headers[] = self::CACHE_HEADER_NAME_CLIENT;
        return $headers;
    }

    /**
     * Get cache key
     *
     * @return string|bool
     */
    public static function getCacheKey()
    {
        return isset($_SERVER[self::CACHE_HEADER_NAME_SERVER]) ? $_SERVER[self::CACHE_HEADER_NAME_SERVER] : false;
    }
}