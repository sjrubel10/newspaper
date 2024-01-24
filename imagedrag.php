<?php

namespace CTXFeed\V5\Product;

use CTXFeed\V5\Compatibility\WCMLCurrency;
use CTXFeed\V5\Helper\CommonHelper;
use CTXFeed\V5\Helper\ProductHelper;
use CTXFeed\V5\Price\PriceFactory;
use CTXFeed\V5\Shipping\ShippingFactory;
use CTXFeed\V5\Tax\TaxFactory;
use CTXFeed\V5\Utility\Config;
use Exception;
use RankMath\Helper;
use WC_Product;
use WC_Product_External;
use WC_Product_Grouped;
use WC_Product_Variable;
use WC_Product_Variation;
use WPSEO_Meta;
use WPSEO_Option_Titles;
use WPSEO_Primary_Term;
use CTXFeed\V5\Common\Helper as CTX_Helper;

class ProductInfo {
    /**
     * @var WC_Product|WC_Product_Variable|WC_Product_Variation|WC_Product_Grouped|WC_Product_External
     */
    private $product;
    /**
     * @var WC_Product|WC_Product_Variable|WC_Product_Variation|WC_Product_Grouped|WC_Product_External
     */
    private $parent_product;
    /**
     * @var Config
     */
    private $config;

    /**
     *
     * @param WC_Product $product
     * @param Config $config
     */
    public function __construct( $product, $config ) {
        $this->product        = $product;
        $this->parent_product = $product->is_type( 'variation' ) ? wc_get_product( $product->get_parent_id() ) : wc_get_product( $product->get_id() );
        $this->config         = $config;
    }

    /**
     * Get product id.
     *
     * @return mixed|void
     */
    public function id() {
        return apply_filters( 'woo_feed_filter_product_id', $this->product->get_id(), $this->product, $this->config );
    }

    /**
     * Get Wpml product Parent id.
     *
     * @return mixed|void
     */
    public function parent_id() {
        if( is_plugin_active( 'woocommerce-multilingual/wpml-woocommerce.php' ) ){
            $wcmlCurrency  = new WCMLCurrency();

            return $wcmlCurrency->woo_feed_wpml_get_original_post_id( $this->product->get_id() );
        } else {

            return apply_filters( 'woo_feed_filter_product_id', $this->product->get_id(), $this->product, $this->config );
        }
    }

    /**
     * Get product name.
     *
     * @return mixed|void
     */
    public function title() {

        $title = woo_feed_strip_all_tags( CommonHelper::remove_shortcodes( $this->product->get_name() ) );

        // Add all available variation attributes to variation title.
        if ( $this->product->is_type( 'variation' ) && ! empty( $this->product->get_attributes() ) ) {
            $title      = $this->parent_product->get_title();
            /**
             * Translate press plugin support
             */
            $title = apply_filters( 'woo_feed_filter_product_title', $title, $this->product, $this->config );
            $attributes = [];
            foreach ( $this->product->get_attributes() as $slug => $value ) {
                $attribute = $this->product->get_attribute( $slug );
                if ( ! empty( $attribute ) ) {
                    $attributes[ $slug ] = $attribute;
                }
            }

            // set variation attributes with separator.
            $separator            = ',';
            $variation_attributes = implode( $separator, $attributes );

            //get product title with variation attribute
            $get_with_var_attributes = apply_filters( "woo_feed_get_product_title_with_variation_attribute", true, $this->product, $this->config );

            if ( $get_with_var_attributes ) {
                $title .= " - " . $variation_attributes;
            }
        }
        if ( $this->config->get_config()['provider'] == "admarkt" && $this->config->get_config()['feedType'] == 'xml' ) {
            $title = str_replace( '&', '&amp;', $title );
        }


        return apply_filters( 'woo_feed_filter_product_title', $title, $this->product, $this->config );
    }

    /**
     * Get parent product title for variation.
     *
     * @return mixed|void
     */
    public function parent_title() {
        if ( $this->product->is_type( 'variation' ) ) {
            $title = woo_feed_strip_all_tags( CommonHelper::remove_shortcodes( $this->parent_product->get_name() ) );
        } else {
            $title = $this->title();
        }

        return apply_filters( 'woo_feed_filter_product_parent_title', $title, $this->product, $this->config->feed_info );
    }

    /**
     * Get product description.
     *
     * @return mixed|void
     */
    public function description() {
        $description = $this->product->get_description();
        // Get Variation Description
        if ( empty( $description ) && $this->product->is_type( 'variation' ) ) {
            $description = '';
            if ( ! is_null( $this->parent_product ) ) {
                $description = $this->parent_product->get_description();
            }
        }

        if ( empty( $description ) ) {
            $description = $this->product->get_short_description();
        }



        $description = CommonHelper::remove_shortcodes( $description );


        /**
         * Add variations attributes after description to prevent Facebook error
         *
         * @see https://www.facebook.com/business/help/120325381656392?id=725943027795860
         * @see https://www.facebook.com/business/help/2302017289821154?id=725943027795860
         */
        if ( 'facebook' === $this->config->get_feed_template() && $this->product->is_type( 'variation' ) ) {
            $title      = $this->parent_product->get_title();
            $attributes = [];
            foreach ( $this->product->get_attributes() as $slug => $value ) {
                $attribute = $this->product->get_attribute( $slug );
                if ( ! empty( $attribute ) ) {
                    $attributes[ $slug ] = $attribute;
                }
            }

            // set variation attributes with separator.
            $separator            = ',';
            $variation_attributes = implode( $separator, $attributes );

            $description .= ' ' . $variation_attributes;
        }

        //strip tags and spacial characters
        $strip_description = woo_feed_strip_all_tags( wp_specialchars_decode( $description ) );


        $description = ! empty( strlen( $strip_description ) ) && 0 < strlen( $strip_description ) ? $strip_description : $description;

        if ( $this->config->get_config()['provider'] == "admarkt" && $this->config->get_config()['feedType'] == 'xml' ) {
            $description = str_replace( '&', '&amp;', $description );
        }
        /**
         * Remove delimiter and enclosure if feed file type is csv/tsv/txt/xls/xlsx
         * If enclosure/delimiter has in description then, it breaks in multiple column. That's why remove enclosure/delimiter from description.
         */
        if ( in_array( $this->config->get_feed_file_type(), [ 'csv', 'tsv', 'txt', 'xls', 'xlsx' ] ) ) {
            $description = str_replace( $this->config->get_enclosure(), '', $description );
            $description = str_replace( $this->config->get_delimiter(), '', $description );
        }


        /**
         * https://webappick.atlassian.net/browse/CBT-150
         * Facebook Product Description Character limit:  Min 30, Max 9,999;
         *
         * Google Shopping Product Description Character limit: max 5000;
         *
         * Pinterest Product Description Character limit: max 10000;
         */
        $description_limits = apply_filters('ctx_feed_merchant_based_description_limit', [
            'facebook'  => 9999,
            'google'    => 5000,
            'pinterest' => 10000,
        ]);
        if ( in_array( $this->config->get_feed_template(), array_keys( $description_limits ) ) ) {
            $description = substr( $description, 0, $description_limits[ $this->config->get_feed_template() ] );
        }

        return apply_filters( 'woo_feed_filter_product_description', $description, $this->product, $this->config );

    }

    /**
     * Get product description with HTML tags.
     *
     * @return mixed|void
     */
    public function description_with_html() {
        $description = $this->product->get_description();

        // Get Variation Description
        if ( empty( $description ) && $this->product->is_type( 'variation' ) ) {
            $description = '';
            if ( ! is_null( $this->parent_product ) ) {
                $description = $this->parent_product->get_description();
            }
        }

        if ( empty( $description ) ) {
            $description = $this->product->get_short_description();
        }

        $description = CommonHelper::remove_shortcodes( $description );

        // Add variations attributes after description to prevent Facebook error
        if ( 'facebook' === $this->config->get_feed_template() && $this->product->is_type( 'variation' ) ) {
            $variationInfo = explode( '-', $this->product->get_name() );
            if ( isset( $variationInfo[1] ) ) {
                $extension = $variationInfo[1];
            } else {
                $extension = $this->product->get_id();
            }
            $description .= ' ' . $extension;
        }

        //remove spacial characters
        $description = wp_check_invalid_utf8( wp_specialchars_decode( $description ), true );

        return apply_filters( 'woo_feed_filter_product_description_with_html', $description, $this->product, $this->config );
    }

    /**
     * Get product short description.
     *
     * @return mixed|void
     */
    public function short_description() {
        $short_description = $this->product->get_short_description();

        // Get Variation Short Description
        if ( empty( $short_description ) && $this->product->is_type( 'variation' ) ) {
            $short_description = $this->parent_product->get_short_description();
        }

        $short_description = CommonHelper::remove_shortcodes( $short_description );

        // Strip tags and spacial characters
        $short_description = woo_feed_strip_all_tags( wp_specialchars_decode( $short_description ) );

        if ( $this->config->get_config()['provider'] == "admarkt" && $this->config->get_config()['feedType'] == 'xml' ) {
            $short_description = str_replace( '&', '&amp;', $short_description );
        }

        return apply_filters( 'woo_feed_filter_product_short_description', $short_description, $this->product, $this->config );
    }

    /**
     * Get product primary category.
     *
     * @return mixed|void
     */
    public function primary_category() {
        $parent_category = "";
        $separator       = apply_filters( 'woo_feed_product_type_separator', ' > ', $this->config );

        $full_category = $this->product_type();
        if ( ! empty( $full_category ) ) {
            $full_category_array = explode( $separator, $full_category );
            $parent_category     = $full_category_array[0];
        }

        return apply_filters( 'woo_feed_filter_product_primary_category', $parent_category, $this->product, $this->config );
    }

    /**
     * Get product primary category id.
     *
     * @return mixed|void
     */
    public function primary_category_id() {
        $parent_category_id = "";
        $separator          = apply_filters( 'woo_feed_product_type_separator', ' > ', $this->config );
        $full_category      = $this->product_type();
        if ( ! empty( $full_category ) ) {
            $full_category_array = explode( $separator, $full_category );
            $parent_category_obj = get_term_by( 'name', $full_category_array[0], 'product_cat' );
            $parent_category_id  = isset( $parent_category_obj->term_id ) ? $parent_category_obj->term_id : "";
        }

        return apply_filters( 'woo_feed_filter_product_primary_category_id', $parent_category_id, $this->product, $this->config );
    }

    /**
     * Get product child category.
     *
     * @return mixed|void
     */
    public function child_category() {
        $child_category = "";
        $separator      = apply_filters( 'woo_feed_product_type_separator', ' > ', $this->config );
        $full_category  = $this->product_type();
        if ( ! empty( $full_category ) ) {
            $full_category_array = explode( $separator, $full_category );
            $child_category      = end( $full_category_array );
        }

        return apply_filters( 'woo_feed_filter_product_child_category', $child_category, $this->product, $this->config );
    }

    /**
     * Get product child category id.
     *
     * @return mixed|void
     */
    public function child_category_id() {
        $child_category_id = "";
        $separator         = apply_filters( 'woo_feed_product_type_separator', ' > ', $this->config );
        $full_category     = $this->product_type();
        if ( ! empty( $full_category ) ) {
            $full_category_array = explode( $separator, $full_category );
            $child_category_obj  = get_term_by( 'name', end( $full_category_array ), 'product_cat' );
            $child_category_id   = isset( $child_category_obj->term_id ) ? $child_category_obj->term_id : "";
        }

        return apply_filters( 'woo_feed_filter_product_child_category_id', $child_category_id, $this->product, $this->config );
    }

    /**
     * Get product type.
     *
     * @return mixed|void
     */
    public function product_type() {
        $id = $this->product->get_id();
        if ( $this->product->is_type( 'variation' ) ) {
            $id = $this->product->get_parent_id();
        }

        $separator          = apply_filters( 'woo_feed_product_type_separator', ' > ', $this->config );
        $product_categories = '';
        $term_list          = get_the_terms( $id, 'product_cat' );

        if ( is_array( $term_list ) ) {
            $col = array_column( $term_list, "term_id" );
            array_multisort( $col, SORT_ASC, $term_list );
            $term_list = array_column( $term_list, "name" );
            //TODO: Remove Manual Separator and add Dynamically with hook. Hook function also need to modified from array to object.
            $product_categories = implode( ' > ', $term_list );
        }

        return apply_filters( 'woo_feed_filter_product_local_category', htmlspecialchars_decode($product_categories), $this->product, $this->config );
    }

    /**
     * @param \WC_Product $product
     *
     * @return void
     */
    public function product_status() {
        $status = $this->product->get_status();

        return apply_filters( 'woo_feed_filter_product_status', $status, $this->product, $this->config );
    }

    /**
     * @param \WC_Product $product
     *
     * @return void
     */
    public function featured_status() {
        $status = $this->product->is_featured() ? 'yes' : 'no';

        return apply_filters( 'woo_feed_filter_featured_status', $status, $this->product, $this->config );
    }

    /**
     * Get product full category.
     *
     * @return mixed|void
     */
    public function product_full_cat() {

        $id = $this->product->get_id();
        if ( $this->product->is_type( 'variation' ) ) {
            $id = $this->product->get_parent_id();
        }

        $separator = apply_filters( 'woo_feed_product_type_separator', ' > ', $this->config, $this->product );

        $product_type = wp_strip_all_tags( wc_get_product_category_list( $id, $separator ) );

        return apply_filters( 'woo_feed_filter_product_local_category', htmlspecialchars_decode($product_type), $this->product, $this->config );
    }

    /**
     * Get product URL.
     *
     * @return mixed|void
     */
    public function link() {
        $link = $this->product->get_permalink();

        if ( $this->config->get_campaign_parameters() ) {
            $link = CommonHelper::add_utm_parameter( $this->config->get_campaign_parameters(), $link );
        }
        $feedRules = $this->config->get_config();

        return apply_filters( 'woo_feed_filter_product_link', $link, $this->product, $feedRules, $this->config );
    }

    /**
     * Get product parent URL.
     *
     * @return mixed|void
     */
    public function parent_link() {
        $link = $this->product->get_permalink();
        if ( $this->product->is_type( 'variation' ) ) {
            $link = $this->parent_product->get_permalink();
        }

        if ( $this->config->get_campaign_parameters() ) {
            $link = CommonHelper::add_utm_parameter( $this->config->get_campaign_parameters(), $link );
        }

        return apply_filters( 'woo_feed_filter_product_parent_link', $link, $this->product, $this->config );
    }

    /**
     * Get product Canonical URL.
     *
     * @return mixed|void
     */
    public function canonical_link() {
        //TODO: check if SEO plugin installed then return SEO canonical URL
        $canonical_link = $this->parent_link();

        return apply_filters( 'woo_feed_filter_product_canonical_link', $canonical_link, $this->product, $this->config );
    }

    /**
     * Get external product URL.
     *
     * @return mixed|void
     */
    public function ex_link() {
        $ex_link = '';
        if ( $this->product->is_type( 'external' ) ) {
            $ex_link = $this->product->get_product_url();
            if ( $this->config->get_campaign_parameters() ) {
                $ex_link = CommonHelper::add_utm_parameter( $this->config->get_campaign_parameters(), $ex_link );
            }
        }

        return apply_filters( 'woo_feed_filter_product_ex_link', $ex_link, $this->product, $this->config );
    }

    /**
     * Get product image URL.
     *
     * @return mixed|void
     */
    public function image() {
        $image = '';
        if ( $this->product->is_type( 'variation' ) ) {
            // Variation product type
            if ( has_post_thumbnail( $this->product->get_id() ) ) {
                $getImage = wp_get_attachment_image_src( get_post_thumbnail_id( $this->product->get_id() ), 'single-post-thumbnail' );
                $image    = CTX_Helper::woo_feed_get_formatted_url( $getImage[0] );
            } elseif ( has_post_thumbnail( $this->product->get_parent_id() ) ) {
                $getImage = wp_get_attachment_image_src( get_post_thumbnail_id( $this->product->get_parent_id() ), 'single-post-thumbnail' );
                $image    = CTX_Helper::woo_feed_get_formatted_url( $getImage[0] );
            }
        } elseif ( has_post_thumbnail( $this->product->get_id() ) ) { // All product type except variation
            $getImage = wp_get_attachment_image_src( get_post_thumbnail_id( $this->product->get_id() ), 'single-post-thumbnail' );
            $image    = isset( $getImage[0] ) ? CTX_Helper::woo_feed_get_formatted_url( $getImage[0] ) : '';
        }

        return apply_filters( 'woo_feed_filter_product_image', $image, $this->product, $this->config );
    }

    /**
     * Get product featured image URL.
     *
     * @return mixed|void
     */
    public function feature_image() {
        $id = $this->product->get_id();
        if ( $this->product->is_type( 'variation' ) ) {
            $id = $this->product->get_parent_id();
        }

        $getImage = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'single-post-thumbnail' );
        $image    = isset( $getImage[0] ) ? CTX_Helper::woo_feed_get_formatted_url( $getImage[0] ) : '';

        return apply_filters( 'woo_feed_filter_product_feature_image', $image, $this->product, $this->config );
    }

    /**
     * Get product images (comma separated URLs).
     *
     * @return mixed|void
     */
    public function images( $additionalImg = '' ) {
        $imgUrls   = ProductHelper::get_product_gallery( $this->product );
        $separator = apply_filters( 'woo_feed_filter_category_separator', ' , ', $this->product, $this->config );

        // Return Specific Additional Image URL
        if ( '' !== $additionalImg ) {
            if ( array_key_exists( $additionalImg, $imgUrls ) ) {
                $images = $imgUrls[ $additionalImg ];
            } else {
                $images = '';
            }
        } else {
            if ( "idealo" === $this->config->get_feed_template() ) {
                $separator = ';';
            }

            $images = implode( $separator, array_filter( $imgUrls ) );
        }

        return apply_filters( 'woo_feed_filter_product_images', $images, $this->product, $this->config );
    }

    public function condition() {
        return apply_filters( 'woo_feed_product_condition', 'new', $this->product, $this->config );
    }

    public function type() {
        return apply_filters( 'woo_feed_filter_product_type', $this->product->get_type(), $this->product, $this->config );
    }

    public function is_bundle() {
        $is_bundle = 'no';
        if ( $this->product->is_type( 'bundle' ) || $this->product->is_type( 'yith_bundle' ) || $this->product->is_type( 'yith_bundle' ) || $this->product->is_type( 'woosb' ) ) {
            $is_bundle = 'yes';
        }

        return apply_filters( 'woo_feed_filter_product_is_bundle', $is_bundle, $this->product, $this->config );
    }

    public function multipack() {
        $multi_pack = '';
        if ( $this->product->is_type( 'grouped' ) ) {
            $multi_pack = ( ! empty( $this->product->get_children() ) ) ? count( $this->product->get_children() ) : '';
        }

        return apply_filters( 'woo_feed_filter_product_is_multipack', $multi_pack, $this->product, $this->config );
    }

    public function visibility() {
        return apply_filters( 'woo_feed_filter_product_visibility', $this->product->get_catalog_visibility(), $this->product, $this->config );
    }

    public function rating_total() {
        return apply_filters( 'woo_feed_filter_product_rating_total', $this->product->get_rating_count(), $this->product, $this->config );
    }

    public function rating_average() {
        return apply_filters( 'woo_feed_filter_product_rating_average', $this->product->get_average_rating(), $this->product, $this->config );
    }

    public function total_sold() {
    } //TODO: Implement this

    public function tags() {
        $id = $this->product->get_id();
        if ( $this->product->is_type( 'variation' ) ) {
            $id = $this->product->get_parent_id();
        }

        /**
         * Separator for multiple tags
         *
         * @param string $separator
         * @param array $config
         * @param WC_Abstract_Legacy_Product $product
         *
         * @since 3.4.3
         */
        $separator = apply_filters( 'woo_feed_tags_separator', ',', $this->product, $this->config );

        $tags = woo_feed_strip_all_tags( get_the_term_list( $id, 'product_tag', '', $separator, '' ) );

        return apply_filters( 'woo_feed_filter_product_tags', $tags, $this->product, $this->config );
    }

    public function item_group_id() {
        $id = $this->product->get_id();
        if ( $this->product->is_type( 'variation' ) ) {
            $id = $this->product->get_parent_id();
        }

        return apply_filters( 'woo_feed_filter_product_item_group_id', $id, $this->product, $this->config );
    }

    public function sku() {
        return apply_filters( 'woo_feed_filter_product_sku', $this->product->get_sku(), $this->product, $this->config );
    }

    public function sku_id() {
        $sku    = ! empty( $this->product->get_sku() ) ? $this->product->get_sku() . '_' : '';
        $sku_id = $sku . $this->product->get_id();

        return apply_filters( 'woo_feed_filter_product_sku_id', $sku_id, $this->product, $this->config );
    }

    public function parent_sku() {
        $parent_sku = $this->product->get_sku();
        if ( $this->product->is_type( 'variation' ) ) {
            $parent_sku = $this->parent_product->get_sku();
        }

        return apply_filters( 'woo_feed_filter_product_parent_sku', $parent_sku, $this->product, $this->config );
    }

    public function availability() {
        $status = $this->product->get_stock_status();
        if ( 'instock' === $status ) {
            $status = 'in stock';
        } elseif ( 'outofstock' === $status ) {
            $status = 'out of stock';
        } elseif ( 'onbackorder' === $status ) {
            $status = 'backorder';
        }

        // set (_) as separator for google merchant
        if ( 'google' === $this->config->get_feed_template() ) {
            $status = explode( ' ', $status );
            $status = implode( '_', $status );
        }

        return apply_filters( 'woo_feed_filter_product_availability', $status, $this->product, $this->config );
    }

    public function availability_date() {

        $feed_settings = get_option( 'woo_feed_settings' );

        $availability_date_settings = isset( $feed_settings['woo_feed_identifier']['availability_date'] )
            ? $feed_settings['woo_feed_identifier']['availability_date']
            : 'enable';

        if ( $this->product->get_stock_status() !== 'onbackorder' || $availability_date_settings === 'disable' ) {
            return '';
        }

        $meta_field_name = 'woo_feed_availability_date';

        if ( $this->product->is_type( 'variation' ) ) {
            $meta_field_name .= '_var';
        }

        $availability_date = get_post_meta( $this->product->get_id(), $meta_field_name, true );

        if ( '' !== $availability_date && in_array( $this->config->get_feed_template(), [
                'google',
                'facebook',
                'pinterest',
                'bing',
                'snapchat',
            ], true ) ) {
            $availability_date = gmdate( 'c', strtotime( $availability_date ) );
        }

        return apply_filters( 'woo_feed_filter_product_availability_date', $availability_date, $this->product, $this->config );
    }

    public function add_to_cart_link() {
        $url    = $this->link();
        $suffix = 'add-to-cart=' . $this->product->get_id();

        $add_to_cart_link = woo_feed_make_url_with_parameter( $url, $suffix );

        return apply_filters( 'woo_feed_filter_product_add_to_cart_link', $add_to_cart_link, $this->product, $this->config );
    }

    public function quantity() {
        $quantity = $this->product->get_stock_quantity();
        $status   = $this->product->get_stock_status();

        $variableConfig = $this->config->get_variable_config();


        //when product is outofstock , and it's quantity is empty, set quantity to 0
        if ( 'outofstock' === $status && $quantity === null ) {
            $quantity = 0;
        }

        if ( $this->product->is_type( 'variable' ) && $this->product->has_child() ) {
            $visible_children = $this->product->get_visible_children();
            $qty              = array();
            foreach ( $visible_children as $child ) {
                $childQty = get_post_meta( $child, '_stock', true );
                $qty[]    = (int) $childQty + 0;
            }

            if ( isset( $variableConfig['variable_quantity'] ) ) {
                $vaQty = $variableConfig['variable_quantity'];
                if ( 'max' === $vaQty ) {
                    $quantity = max( $qty );
                } elseif ( 'min' === $vaQty ) {
                    $quantity = min( $qty );
                } elseif ( 'sum' === $vaQty ) {
                    $quantity = array_sum( $qty );
                } elseif ( 'first' === $vaQty ) {
                    $quantity = isset( $qty[0] ) ? ( (int) $qty[0] ) : $quantity;
                } else {
                    $quantity = array_sum( $qty );
                }
            }
        }

        return apply_filters( 'woo_feed_filter_product_quantity', $quantity, $this->product, $this->config );
    }

    /**
     * Get Store Currency.
     *
     * @return mixed|void
     */
    public function currency() {
        $quantity = get_option( 'woocommerce_currency' );

        return apply_filters( 'woo_feed_filter_product_currency', $quantity, $this->product, $this->config );
    }

    /**
     * Get Product Sale Price start date.
     *
     * @return mixed|void
     */
    public function sale_price_sdate() {
        $startDate = $this->product->get_date_on_sale_from();
        if ( is_object( $startDate ) ) {
            $sale_price_sdate = $startDate->date_i18n();
        } else {
            $sale_price_sdate = '';
        }

        return apply_filters( 'woo_feed_filter_product_sale_price_sdate', $sale_price_sdate, $this->product, $this->config );
    }

    /**
     * Get Product Sale Price End Date.
     *
     * @return mixed|void
     */
    public function sale_price_edate() {
        $endDate = $this->product->get_date_on_sale_to();
        if ( is_object( $endDate ) ) {
            $sale_price_edate = $endDate->date_i18n();
        } else {
            $sale_price_edate = "";
        }

        return apply_filters( 'woo_feed_filter_product_sale_price_edate', $sale_price_edate, $this->product, $this->config );
    }

    public function price() {
        $regular_price = PriceFactory::get( $this->product, $this->config )->regular_price();

        return apply_filters( 'woo_feed_filter_product_regular_price', $regular_price, $this->product, $this->config, false, 'regular_price' );
    }

    public function current_price() {
        $price = PriceFactory::get( $this->product, $this->config )->price();

        return apply_filters( 'woo_feed_filter_product_price', $price, $this->product, $this->config, false, 'price' );
    }

    public function sale_price() {
        $sale_price = PriceFactory::get( $this->product, $this->config )->sale_price();

        return apply_filters( 'woo_feed_filter_product_sale_price', $sale_price, $this->product, $this->config, false, 'sale_price' );
    }

    public function price_with_tax() {
        $regular_price = PriceFactory::get( $this->product, $this->config )->regular_price( true );

        return apply_filters( 'woo_feed_filter_product_regular_price_with_tax', $regular_price, $this->product, $this->config, true, 'price' );
    }

    public function current_price_with_tax() {
        $price = PriceFactory::get( $this->product, $this->config )->price( true );

        return apply_filters( 'woo_feed_filter_product_price_with_tax', $price, $this->product, $this->config, true, 'price' );
    }

    public function sale_price_with_tax() {
        $sale_price = PriceFactory::get( $this->product, $this->config )->sale_price( true );

        return apply_filters( 'woo_feed_filter_product_sale_price_with_tax', $sale_price, $this->product, $this->config, true, 'sale_price' );
    }

    /**
     * Get Product Weight.
     *
     * @return mixed|void
     */
    public function weight() {

        $weight_unit = get_option( 'woocommerce_weight_unit' );
        if( $this->product->get_weight() ){
            $weight = $this->product->get_weight()." ".$weight_unit;
        }else{
            $weight = "";
        }
        return apply_filters( 'woo_feed_filter_product_weight', $weight, $this->product, $this->config );
    }

    /**
     * Get Weight Unit.
     *
     * @return mixed|void
     */
    public function weight_unit() {
        return apply_filters( 'woo_feed_filter_product_weight_unit', get_option( 'woocommerce_weight_unit' ), $this->product, $this->config );
    }

    /**
     * Get Product Width.
     *
     * @return mixed|void
     */
    public function width() {
        $dimension_unit = get_option( 'woocommerce_dimension_unit' );
        if( $this->product->get_width() ){
            $width = $this->product->get_width()." $dimension_unit";
        }else{
            $width = "";
        }
        return apply_filters( 'woo_feed_filter_product_width', $width, $this->product, $this->config );
    }

    /**
     * Get Product Height.
     *
     * @return mixed|void
     */
    public function height() {
        if( $this->product->get_height() ){
            $dimension_unit = get_option( 'woocommerce_dimension_unit' );
            $height = $this->product->get_height()." $dimension_unit";
        }else{
            $height = "";
        }
        return apply_filters( 'woo_feed_filter_product_height', $height, $this->product, $this->config );
    }

    /**
     * Get Product Length.
     *
     * @return mixed|void
     */
    public function length() {
        $dimension_unit = get_option( 'woocommerce_dimension_unit' );
        if( $this->product->get_length() ){
            $length = $this->product->get_length()." $dimension_unit";
        }else{
            $length = "";
        }
        return apply_filters( 'woo_feed_filter_product_length', $length, $this->product, $this->config );
    }

    /**
     * Get Product checkout template URL.
     *
     * @return mixed|void
     */
    public function checkout_link_template(){
        if( $this->config->get_feed_file_type() === 'xml'){
            $checkout_link_url = wc_get_checkout_url().$this->product->get_id();
        }else{
            $checkout_link_url = wc_get_page_permalink( 'cart' )."?productId=".$this->product->get_id();
        }

        return apply_filters( 'woo_feed_filter_product_checkout_link_url', $checkout_link_url, $this->product, $this->config );
    }

    /** Google Formatted Shipping info
     *
     * @return string
     * @throws \Exception
     */
    public function shipping( $key = '' ) {
        try {
            return ( ShippingFactory::get( $this->product, $this->config ) )->get_shipping( $key );
//			return apply_filters( 'woo_feed_filter_product_shipping', $shipping, $this->product, $this->config );
        } catch ( Exception $e ) {

        }
    }


    /**
     * Get Shipping Cost.
     *
     * @throws \Exception
     */
    public function shipping_cost() {
        // Get config to which shipping price to return (first, highest or lowest)
        $shipping = ( ShippingFactory::get( $this->product, $this->config ) )->get_shipping_info();

        $price = "0";
        if ( ! empty( $shipping ) ) {
            if ( isset( $this->config->shipping_price ) ) {
                if ( 'highest' === $this->config->shipping_price ) {
                    $price = max( wp_list_pluck( $shipping, 'price' ) );
                } elseif ( 'lowest' === $this->config->shipping_price ) {
                    $price = min( wp_list_pluck( $shipping, 'price' ) );
                } else {
                    $shipping_prices = wp_list_pluck( $shipping, 'price' );
                    $price           = reset( $shipping_prices );
                }
            } else {
                $shipping_prices = wp_list_pluck( $shipping, 'price' );
                $price           = reset( $shipping_prices );
            }
        }

        return apply_filters( 'woo_feed_filter_product_shipping_cost', $price, $this->product, $this->config );
    }


    /**
     * Get Product Shipping Class
     *
     * @return mixed
     * @since 3.2.0
     *
     */
    public function shipping_class() {
        return apply_filters( 'woo_feed_filter_product_shipping_class', $this->product->get_shipping_class(), $this->product, $this->config );
    }

    /**
     * Get author name.
     *
     * @return string
     */
    public function author_name() {
        $post = get_post( $this->product->get_id() );

        return get_the_author_meta( 'user_login', $post->post_author );
    }

    /**
     * Get Author Email.
     *
     * @return string
     */
    public function author_email() {
        $post = get_post( $this->product->get_id() );

        return get_the_author_meta( 'user_email', $post->post_author );
    }

    /**
     * Get Date Created.
     *
     * @return mixed|void
     */
    public function date_created() {
        $date_created = gmdate( 'Y-m-d', strtotime( $this->product->get_date_created() ) );

        return apply_filters( 'woo_feed_filter_product_date_created', $date_created, $this->product, $this->config );
    }

    /**
     * Get Date updated.
     *
     * @return mixed|void
     */
    public function date_updated() {
        $date_updated = gmdate( 'Y-m-d', strtotime( $this->product->get_date_modified() ) );

        return apply_filters( 'woo_feed_filter_product_date_updated', $date_updated, $this->product, $this->config );
    }

    /** Get Google Sale Price effective date.
     *
     * @return string
     */
    public function sale_price_effective_date() {
        $effective_date = '';
        $from           = $this->sale_price_sdate();
        $to             = $this->sale_price_edate();
        if ( ! empty( $from ) && ! empty( $to ) ) {
            $from = gmdate( 'c', strtotime( $from ) );
            $to   = gmdate( 'c', strtotime( $to ) );

            $effective_date = $from . '/' . $to;
        }

        return $effective_date;
    }

    public function subscription_period() {
        if ( class_exists( 'WC_Subscriptions' ) ) {
            return ProductHelper::get_product_meta( '_subscription_period', $this->product, $this->config );
        }

        return '';
    }

    public function subscription_period_interval() {
        if ( class_exists( 'WC_Subscriptions' ) ) {
            return ProductHelper::get_product_meta( '_subscription_period_interval', $this->product, $this->config );
        }

        return '';
    }

    public function subscription_amount() {
//	    return $this->price($product);
    }

    public function installment_amount() {
//	    return $this->price($product);
    }

    public function installment_months() {
        if ( class_exists( 'WC_Subscriptions' ) ) {
            return ProductHelper::get_product_meta( '_subscription_length', $this->product, $this->config );
        }

        return '';
    }

    public function unit_price_measure() {
        $unit_price_measure = '';
        $identifiers        = woo_feed_get_options( 'woo_feed_identifier' );
        if ( 'enable' === $identifiers['unit_pricing_base_measure']
            && 'enable' === $identifiers['unit_pricing_measure']
            && 'enable' === $identifiers['unit']
        ) {
            $unit               = ProductHelper::get_custom_filed( 'woo_feed_unit', $this->product, $this->config );
            $unit_price_measure = ProductHelper::get_custom_filed( 'woo_feed_unit_pricing_measure', $this->product, $this->config );

            $unit_price_measure .= " " . $unit;
        }

        if ( empty( $unit_price_measure ) && class_exists( 'WooCommerce_Germanized' ) ) { // For WooCommerce Germanized Plugin
            $unit               = ProductHelper::get_product_meta( '_unit', $this->product, $this->config );
            $unit_price_measure = ProductHelper::get_product_meta( '_unit_product', $this->product, $this->config );

            $unit_price_measure .= " " . $unit;
        }

        return apply_filters( 'woo_feed_filter_unit_price_measure', $unit_price_measure, $this->product, $this->config );
    }

    public function unit_price_base_measure() {
        $unit_price_base_measure = '';
        $identifiers             = woo_feed_get_options( 'woo_feed_identifier' );
        if ( 'enable' === $identifiers['unit_pricing_base_measure']
            && 'enable' === $identifiers['unit_pricing_measure']
            && 'enable' === $identifiers['unit']
        ) {
            $unit                    = ProductHelper::get_custom_filed( 'woo_feed_unit', $this->product, $this->config );
            $unit_price_base_measure = ProductHelper::get_custom_filed( 'woo_feed_unit_pricing_base_measure', $this->product, $this->config );
            $unit_price_base_measure .= " " . $unit;
        }

        if ( empty( $unit_price_base_measure ) && class_exists( 'WooCommerce_Germanized' ) ) { // For WooCommerce Germanized Plugin
            $unit                    = ProductHelper::get_product_meta( '_unit', $this->product, $this->config );
            $unit_price_base_measure = ProductHelper::get_product_meta( '_unit_base', $this->product, $this->config );
            $unit_price_base_measure .= " " . $unit;
        }

        return apply_filters( 'woo_feed_filter_unit_price_base_measure', $unit_price_base_measure, $this->product, $this->config );
    }

    public function wc_germanized_gtin() {
        $wc_germanized_gtin = '';
        if ( class_exists( 'WooCommerce_Germanized' ) ) { // For WooCommerce Germanized Plugin
            $wc_germanized_gtin = ProductHelper::get_product_meta( '_ts_gtin', $this->product, $this->config );
        }

        return apply_filters( 'woo_feed_filter_wc_germanized_gtin', $wc_germanized_gtin, $this->product, $this->config );
    }

    public function wc_germanized_mpn() {
        $wc_germanized_mpn = '';
        if ( class_exists( 'WooCommerce_Germanized' ) ) { // For WooCommerce Germanized Plugin
            $wc_germanized_mpn = ProductHelper::get_product_meta( '_ts_mpn', $this->product, $this->config );
        }

        return apply_filters( 'woo_feed_filter_wc_germanized_mpn', $wc_germanized_mpn, $this->product, $this->config );
    }

    # SEO Plugins

    public function yoast_primary_category() {
        $primary_category = '';
        $product_id  = CommonHelper::woo_feed_parent_product_id( $this->product );
        $primary_term_id = yoast_get_primary_term_id( 'product_cat', $product_id );
        $term = get_term( $primary_term_id );
        if ( ! is_wp_error( $term ) && ! empty( $term ) ) {
            $primary_category = $term->name;
        }

        return apply_filters( 'woo_feed_filter_product_yoast_primary_category', $primary_category, $this->product, $this->config );
    }

    public function yoast_wpseo_title() {
        $product_id  = woo_feed_parent_product_id( $this->product );
        $yoast_title = get_post_meta( $product_id, '_yoast_wpseo_title', true );
        if ( strpos( $yoast_title, '%%' ) !== false ) {
            $title = strstr( $yoast_title, '%%', true );
            if ( empty( $title ) ) {
                $title = get_the_title( $product_id );
            }
            $wpseo_titles = get_option( 'wpseo_titles' );

            $sep_options = WPSEO_Option_Titles::get_instance()->get_separator_options();
            if ( isset( $wpseo_titles['separator'], $sep_options[ $wpseo_titles['separator'] ] ) ) {
                $sep = $sep_options[ $wpseo_titles['separator'] ];
            } else {
                $sep = '-'; //setting default separator if Admin didn't set it from backed
            }

            $site_title = get_bloginfo( 'name' );

            $meta_title = $title . ' ' . $sep . ' ' . $site_title;

            if ( ! empty( $meta_title ) ) {
                $title = $meta_title;
            }
        } elseif ( ! empty( $yoast_title ) ) {
            $title = $yoast_title;
        } else {
            $title = $this->title();
        }

        return apply_filters( 'woo_feed_filter_product_yoast_wpseo_title', $title, $this->product, $this->config );
    }

    public function yoast_wpseo_metadesc() {
        $product_id  = woo_feed_parent_product_id( $this->product );
        $description = '';
        if ( class_exists( 'WPSEO_Frontend' ) ) {
            $description = wpseo_replace_vars( WPSEO_Meta::get_value( 'metadesc', $product_id ),
                get_post( $this->product->get_id() ) );
        } else {
            $description = YoastSEO()->meta->for_post( $product_id )->description;
        }

        if ( empty( $description ) ) {
            $description = $this->description();
        }

        return apply_filters( 'woo_feed_filter_product_yoast_wpseo_metadesc', $description, $this->product, $this->config );
    }

    public function yoast_canonical_url() {
        $product_id          = woo_feed_parent_product_id( $this->product );
        $yoast_canonical_url = get_post_meta( $product_id, '_yoast_wpseo_canonical', true );

        return apply_filters( 'woo_feed_filter_product_yoast_canonical_url', $yoast_canonical_url, $this->product, $this->config );
    }

    public function yoast_gtin8() {
        $yoast_gtin8_value = woo_feed_get_yoast_identifiers_value( 'gtin8', $this->product );

        return apply_filters( 'yoast_gtin8_attribute_value', $yoast_gtin8_value, $this->product );
    }

    public function yoast_gtin12() {
        $yoast_gtin8_value = woo_feed_get_yoast_identifiers_value( 'gtin12', $this->product );

        return apply_filters( 'yoast_gtin12_attribute_value', $yoast_gtin8_value, $this->product );
    }

    public function yoast_gtin13() {
        $yoast_gtin8_value = woo_feed_get_yoast_identifiers_value( 'gtin13', $this->product );

        return apply_filters( 'yoast_gtin13_attribute_value', $yoast_gtin8_value, $this->product );
    }

    public function yoast_gtin14() {
        $yoast_gtin8_value = woo_feed_get_yoast_identifiers_value( 'gtin14', $this->product );

        return apply_filters( 'yoast_gtin14_attribute_value', $yoast_gtin8_value, $this->product );
    }

    public function yoast_isbn() {
        $yoast_gtin8_value = woo_feed_get_yoast_identifiers_value( 'isbn', $this->product );

        return apply_filters( 'yoast_isbn_attribute_value', $yoast_gtin8_value, $this->product );
    }

    public function yoast_mpn() {
        $yoast_gtin8_value = woo_feed_get_yoast_identifiers_value( 'mpn', $this->product );

        return apply_filters( 'yoast_mpn_attribute_value', $yoast_gtin8_value, $this->product );
    }

    public function rank_math_title() {
        $rank_title = '';
        if ( class_exists( 'RankMath' ) ) {
            $title = get_post_meta( $this->product->get_id(), 'rank_math_title', true );
            if ( empty( $title ) ) {
                $title_format = Helper::get_settings( "titles.pt_product_title" );
                $title_format = $title_format ? $title_format : '%title%';
                $sep          = Helper::get_settings( 'titles.title_separator' );

                $rank_title = str_replace( '%title%', $this->product->get_title(), $title_format );
                $rank_title = str_replace( '%sep%', $sep, $rank_title );
                $rank_title = str_replace( '%page%', '', $rank_title );
                $rank_title = str_replace( '%sitename%', get_bloginfo( 'name' ), $rank_title );
            } else {
                $rank_title = $title;
            }
        }

        return apply_filters( 'woo_feed_filter_product_rank_math_title', $rank_title, $this->product, $this->config );
    }

    public function rank_math_description() {
        $description = '';
        if ( class_exists( 'RankMath' ) ) {
            $description = get_post_meta( $this->product->get_id(), 'rank_math_description' );
            $desc_format = \RankMath\Helper::get_settings( "titles.pt_post_description" );

            if ( empty( $description ) ) {
                if ( ! empty( $desc_format ) && strpos( (string) $desc_format, 'excerpt' ) !== false ) {
                    $description = str_replace( '%excerpt%', get_the_excerpt( $this->product->get_id() ), $desc_format );
                }

                // Get Variation Description
                if ( empty( $description ) && $this->product->is_type( 'variation' ) ) {
                    $description = $this->parent_product->get_description();
                }
            }

            if ( is_array( $description ) ) {
                $description = reset( $description );
            }

            $description = CommonHelper::remove_shortcodes( $description );

            //strip tags and spacial characters
            $strip_description = woo_feed_strip_all_tags( wp_specialchars_decode( $description ) );

            $description = ! empty( strlen( $strip_description ) ) && 0 < strlen( $strip_description ) ? $strip_description : $description;
        }

        return apply_filters( 'woo_feed_filter_product_rank_math_description', $description, $this->product, $this->config );
    }

    public function rank_math_canonical_url() {
        $canonical_url = '';

        if ( class_exists( 'RankMath' ) ) {
            $post_canonical_url = get_post_meta( $this->product->get_id(), 'rank_math_canonical_url' );

            if ( empty( $post_canonical_url ) ) {
                $canonical_url = get_the_permalink( $this->product->get_id() );
            } else {
                $canonical_url = $post_canonical_url;
            }

            if ( is_array( $canonical_url ) ) {
                $canonical_url = reset( $canonical_url );
            }
        }

        return apply_filters( 'woo_feed_filter_product_rank_math_canonical_url', $canonical_url, $this->product, $this->config );
    }

    public function rank_math_gtin() {
        $product_id          = woo_feed_parent_product_id( $this->product );
        $rankmath_gtin_value = get_post_meta( $product_id, '_rank_math_gtin_code' );
        $rankmath_gtin_value = ! empty( $rankmath_gtin_value ) && is_array( $rankmath_gtin_value ) ? $rankmath_gtin_value[0] : '';

        return apply_filters( 'rankmath_gtin_attribute_value', $rankmath_gtin_value, $this->product, $this->config );
    }

    public function _aioseop_title() {
        $title = '';
        if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) && class_exists( 'AIOSEO\Plugin\Common\Models\Post' ) ) {

            $post  = AIOSEO\Plugin\Common\Models\Post::getPost( $this->product->get_id() );
            $title = ! empty( $post->title ) ? $post->title : aioseo()->meta->title->getPostTypeTitle( 'product' );
        }

        $title = ! empty( $title ) ? $title : $this->title();

        return apply_filters( 'woo_feed_filter_product_aioseop_title', $title, $this->product, $this->config );
    }

    public function _aioseop_description() {
        $description = '';

        if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) && class_exists( 'AIOSEO\Plugin\Common\Models\Post' ) ) {

            $post        = AIOSEO\Plugin\Common\Models\Post::getPost( $this->product->get_id() );
            $description = ! empty( $post->description ) ? $post->description : aioseo()->meta->description->getPostTypeDescription( 'product' );
        }

        if ( empty( $description ) ) {
            $description = $this->description();
        }

        return apply_filters( 'woo_feed_filter_product_aioseop_description', $description, $this->product, $this->config );
    }

    public function _aioseop_canonical_url() {
        $aioseop_canonical_url = '';
        if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) && class_exists( 'AIOSEO\Plugin\Common\Models\Post' ) ) {
            $post                  = AIOSEO\Plugin\Common\Models\Post::getPost( $this->product->get_id() );
            $aioseop_canonical_url = $post->canonical_url;
        }

        return apply_filters( 'woo_feed_filter_product_aioseop_canonical_url', $aioseop_canonical_url, $this->product, $this->config );
    }

    ############# TAX #############

    public function tax( $key = '' ) {


        $taxes = TaxFactory::get( $this->product, $this->config )->get_taxes();
        $tax   = TaxFactory::get( $this->product, $this->config )->merchant_formatted_tax( $key );

        // GoogleTax and CustomTax class is available.
        // For others merchant use filter hook to modify value.
        return apply_filters( 'woo_feed_filter_product_tax', $tax, $this->product, $this->config, $taxes );
    }

    public function tax_class() {
        return apply_filters( 'woo_feed_filter_product_tax_class', $this->product->get_tax_class(), $this->product, $this->config );
    }

    public function tax_status() {
        return apply_filters( 'woo_feed_filter_product_tax_status', $this->product->get_tax_status(), $this->product, $this->config );
    }

    public function tax_country() {
        $taxes    = TaxFactory::get( $this->product, $this->config )->get_taxes();
        $taxClass = empty( $this->product->get_tax_class() ) ? 'standard-rate' : $this->product->get_tax_class();
        $country  = "";
        if ( isset( $taxes[ $taxClass ] ) && ! empty( $taxes[ $taxClass ] ) ) {
            $rates   = array_values( $taxes[ $taxClass ] );
            $country = $rates[0]['country'];
        }

        return apply_filters( 'woo_feed_filter_product_tax_country', $country, $this->product, $this->config, $taxes );
    }

    public function tax_state() {
        $taxes    = TaxFactory::get( $this->product, $this->config )->get_taxes();
        $taxClass = empty( $this->product->get_tax_class() ) ? 'standard-rate' : $this->product->get_tax_class();
        $state    = "";
        if ( isset( $taxes[ $taxClass ] ) && ! empty( $taxes[ $taxClass ] ) ) {
            $rates = array_values( $taxes[ $taxClass ] );
            $state = $rates[0]['state'];
        }

        return apply_filters( 'woo_feed_filter_product_tax_state', $state, $this->product, $this->config, $taxes );
    }

    public function tax_postcode() {
        $taxes    = TaxFactory::get( $this->product, $this->config )->get_taxes();
        $taxClass = empty( $this->product->get_tax_class() ) ? 'standard-rate' : $this->product->get_tax_class();
        $postcode = "";
        if ( isset( $taxes[ $taxClass ] ) && ! empty( $taxes[ $taxClass ] ) ) {
            $rates    = array_values( $taxes[ $taxClass ] );
            $postcode = $rates[0]['postcode'];
        }

        return apply_filters( 'woo_feed_filter_product_tax_postcode', $postcode, $this->product, $this->config, $taxes );
    }

    public function tax_city() {
        $taxes    = TaxFactory::get( $this->product, $this->config )->get_taxes();
        $taxClass = empty( $this->product->get_tax_class() ) ? 'standard-rate' : $this->product->get_tax_class();
        $city     = "";
        if ( isset( $taxes[ $taxClass ] ) && ! empty( $taxes[ $taxClass ] ) ) {
            $rates = array_values( $taxes[ $taxClass ] );
            $city  = $rates[0]['city'];
        }

        return apply_filters( 'woo_feed_filter_product_tax_city', $city, $this->product, $this->config, $taxes );
    }

    public function tax_rate() {
        $taxes    = TaxFactory::get( $this->product, $this->config )->get_taxes();
        $taxClass = empty( $this->product->get_tax_class() ) ? 'standard-rate' : $this->product->get_tax_class();
        $rate     = "";
        if ( isset( $taxes[ $taxClass ] ) && ! empty( $taxes[ $taxClass ] ) ) {
            $rates = array_values( $taxes[ $taxClass ] );
            $rate  = $rates[0]['rate'];
        }

        return apply_filters( 'woo_feed_filter_product_tax_rate', $rate, $this->product, $this->config, $taxes );
    }

    public function tax_label() {
        $taxes    = TaxFactory::get( $this->product, $this->config )->get_taxes();
        $taxClass = empty( $this->product->get_tax_class() ) ? 'standard-rate' : $this->product->get_tax_class();
        $label    = "";
        if ( isset( $taxes[ $taxClass ] ) && ! empty( $taxes[ $taxClass ] ) ) {
            $rates = array_values( $taxes[ $taxClass ] );
            $label = $rates[0]['label'];
        }

        return apply_filters( 'woo_feed_filter_product_tax_label', $label, $this->product, $this->config, $taxes );
    }

    # Custom XML Template

    /**
     * Custom Template 2 images loop
     *
     * @return array
     */
    public function custom_xml_images() {
        $images    = $this->images();
        $separator = apply_filters( 'woo_feed_filter_category_separator', ' > ', $this->product, $this->config );

        return explode( $separator, $images );
    }

    /**
     * Custom Template 2 attributes loop
     *
     * @return array
     */
    public function custom_xml_attributes() {
        $getAttributes = $this->product->get_attributes();
        $attributes    = [];
        if ( ! empty( $getAttributes ) ) {
            foreach ( $getAttributes as $key => $attribute ) {
                $attributes[ $key ]['name']  = wc_attribute_label( $key );
                $attributes[ $key ]['value'] = $this->product->get_attribute( wc_attribute_label( $key ) );
            }
        }

        return $attributes;
    }

    public function custom_xml_shipping() {
    }

    public function custom_xml_tax() {
    }

    public function custom_xml_categories() {
        $output   = []; // Initialising
        $taxonomy = 'product_cat'; // Taxonomy for product category

        // Get the product categories terms ids in the product:
        $terms_ids = wp_get_post_terms( $this->product->get_id(), $taxonomy, array( 'fields' => 'ids' ) );

        // Loop though terms ids (product categories)
        foreach ( $terms_ids as $term_id ) {
            $term_names = []; // Initialising category array

            // Loop through product category ancestors
            foreach ( get_ancestors( $term_id, $taxonomy ) as $ancestor_id ) {
                // Add the ancestor's term names to the category array
                $term_names[] = get_term( $ancestor_id, $taxonomy )->name;
            }
            // Add the product category term name to the category array
            $term_names[] = get_term( $term_id, $taxonomy )->name;

            // Get category separator
            $separator = apply_filters( 'woo_feed_filter_category_separator', ' > ', $this->product, $this->config );

            // Add the formatted ancestors with the product category to main array
            $output[] = implode( $separator, $term_names );
        }

        return $output;
    }


}
