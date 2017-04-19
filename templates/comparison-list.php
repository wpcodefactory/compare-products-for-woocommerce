<?php
/**
 * Compare products for WooCommerce - Comparison list template
 *
 * @author  Algoritmika Ltd.
 * @version 1.1.4
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php
$id                   = get_the_ID();
$fields               = isset( $params['fields'] ) ? $params['fields'] : array();
$show_title           = $params['show_title'];
$show_image           = $params['show_image'];
$the_query            = $params['the_query'];
$show_price           = isset( $fields['price'] ) ? true : false;
$show_stock           = isset( $fields['stock'] ) ? true : false;
$show_add_to_cart_btn = isset( $fields['add-to-cart'] ) ? true : false;
$show_description     = isset( $fields['description'] ) ? true : false;
$is_modal             = $params['use_modal'];
$list_class           = $params['list_class'];
?>

<?php if($is_modal): ?>
    <div class="iziModal" id="iziModal">
<?php endif; ?>

    <div class="<?php echo esc_attr(implode(" ", $list_class)); ?>">

		<?php if ( $the_query != null && $the_query->have_posts() ) : ?>
            <table>

                <thead>
                <tr>
	                <?php foreach ( $fields as $key => $field ): ?>
		                <?php // Product ?>
		                <?php if ( $key == 'the-product' ) : ?>
                            <th class="the-product"><?php _e( 'Product', 'compare-products-for-woocommerce' ); ?></th>
		                <?php endif; ?>

		                <?php // Product description ?>
		                <?php if ( $key == 'description' ) : ?>
                            <th class="product-description"><?php _e( 'Description', 'compare-products-for-woocommerce' ); ?></th>
		                <?php endif; ?>

		                <?php // Product price ?>
		                <?php if ( $key == 'price' ) : ?>
                            <th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
		                <?php endif; ?>

		                <?php // Product Stock ?>
		                <?php if ( $key == 'stock' ) : ?>
                            <th class="product-stock"><?php _e( 'Stock', 'woocommerce' ); ?></th>
		                <?php endif; ?>

		                <?php // Add to cart button ?>
		                <?php if ( $key == 'add-to-cart' ) : ?>
                            <th class="add-to-cart-btn"><?php _e( 'Add to cart', 'woocommerce' ); ?></th>
		                <?php endif; ?>

		                <?php // Weight ?>
		                <?php if ( $key == 'weight' ) : ?>
                            <th class="product-weight"><?php _e( 'Weight', 'woocommerce' ); ?></th>
		                <?php endif; ?>

		                <?php // Dimensions ?>
		                <?php if ( $key == 'dimensions' ) : ?>
                            <th class="product-dimensions"><?php _e( 'Dimensions', 'woocommerce' ); ?></th>
		                <?php endif; ?>

		                <?php // Dynamic attribute ?>
		                <?php if ( strpos( $key, 'pa_' ) !== false ): ?>
                            <th class="dynamic-attribute"><?php echo esc_html( get_taxonomy( $key )->labels->singular_name ); ?></th>
		                <?php endif; ?>
	                <?php endforeach; ?>

					<?php // Remove button ?>
                    <th class="product-remove"></th>

                </tr>
                </thead>

                <?php get_the_excerpt() ?>

				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<?php $product = wc_get_product( get_the_ID() ); ?>
                    <tr>
	                    <?php foreach ( $fields as $key => $field ): ?>
		                    <?php // Product ?>
		                    <?php if ( $key == 'the-product' ) : ?>
                                <td data-title="<?php _e( 'Product', 'compare-products-for-woocommerce' ); ?>" class="the-product">
				                    <?php // Product Image ?>
				                    <?php if($show_image): ?>
                                        <a class="product-thumbnail" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
						                    <?php echo $product->get_image() ?>
                                        </a>
				                    <?php endif; ?>

	                                <?php if($show_title): ?>
                                        <div class="product-name"><strong><?php echo $product->get_title(); ?></strong></div>
	                                <?php endif; ?>
                                </td>
		                    <?php endif; ?>

		                    <?php // Product description ?>
							<?php if ( $key == 'description' ) : ?>
								<td data-title="<?php _e( 'Description', 'compare-products-for-woocommerce' ); ?>"
								    class="product-description <?php echo esc_attr($key) ?>"><?php the_excerpt(); ?>
								</td>
							<?php endif; ?>

		                    <?php // Product price ?>
		                    <?php if ( $key == 'price' ) : ?>
                                <td data-title="<?php _e( 'Price', 'woocommerce' ); ?>"
                                    class="product-price"><?php echo $product->get_price_html(); ?>
                                </td>
		                    <?php endif; ?>

		                    <?php // Product Stock ?>
		                    <?php if ( $key == 'stock' ) : ?>
                                <td data-title="<?php _e( 'Stock', 'woocommerce' ); ?>" class="product-stock">
				                    <?php if ( $product->is_in_stock() ) : ?>
					                    <?php _e( 'In stock', 'woocommerce' ) ?>
				                    <?php else: ?>
					                    <?php _e( 'Out of stock', 'woocommerce' ); ?>
				                    <?php endif; ?>
                                </td>
		                    <?php endif; ?>

		                    <?php // Add to cart button ?>
		                    <?php if ( $key == 'add-to-cart' ) : ?>
                                <td data-title="<?php _e( 'Add to cart', 'woocommerce' ); ?>"
                                    class="add-to-cart-btn"><?php echo do_shortcode( '[add_to_cart show_price="false" style="" id="' . get_the_ID() . '"]' ); ?>
                                </td>
		                    <?php endif; ?>

		                    <?php // Weight ?>
		                    <?php if ( $key == 'weight' ) : ?>
                                <td data-title="<?php _e( 'Weight', 'woocommerce' ); ?>"
                                    class="product-weight">
	                                <?php
	                                if ( $product->get_weight() != '' ) {
		                                echo wc_format_localized_decimal( $product->get_weight() ) . ' ' . esc_attr( get_option( 'woocommerce_weight_unit' ) );
	                                } else {
		                                echo ' - ';
	                                }
	                                ?>
                                </td>
		                    <?php endif; ?>

		                    <?php // Dimensions ?>
		                    <?php if ( $key == 'dimensions' ) : ?>
                                <td data-title="<?php _e( 'Dimensions', 'woocommerce' ); ?>"
                                    class="product-dimensions <?php echo esc_attr( $key ) ?>">
									<?php
                                    if(Alg_WC_CP_Woocommerce::version_check('3.0')){
	                                    if ( ! empty( wc_format_dimensions( $product->get_dimensions( false ) ) ) ) {
		                                    echo wc_format_dimensions( $product->get_dimensions( false ) );
	                                    } else {
		                                    echo ' - ';
	                                    }
                                    }else{
                                        if ( $product->get_dimensions() != '' ) {
                                            echo $product->get_dimensions();
                                        } else {
                                            echo ' - ';
                                        }
                                    }
									?>
                                </td>
		                    <?php endif; ?>

		                    <?php // Dynamic attribute ?>
		                    <?php if ( strpos( $key, 'pa_' ) !== false ): ?>
                                <td data-title="<?php echo esc_html( get_taxonomy( $key )->label ); ?>"
                                    class="dynamic-attribute <?php echo esc_attr( $key ) ?>">
				                    <?php
				                    $terms = wc_get_product_terms( $product->get_id(), $key );
				                    echo count( $terms ) > 0 ? implode( ", ", $terms ) : ' - ';
				                    ?>
                                </td>
		                    <?php endif; ?>
                        <?php endforeach; ?>

						<?php // Remove button ?>
                        <td data-title="<?php _e( 'Remove', 'compare-products-for-woocommerce' ); ?>"
                            class="product-remove"><?php echo Alg_WC_CP_Remove_Button::load_remove_button_template(); ?>
                        </td>
                    </tr>
				<?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </table>
		<?php else: ?>
			<?php _e( 'The comparison list is empty', 'compare-products-for-woocommerce' ); ?>
		<?php endif; ?>

<?php if($is_modal): ?>
    </div>
<?php endif; ?>

</div>
