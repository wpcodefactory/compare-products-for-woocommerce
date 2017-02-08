<?php
/**
 * Toggle button template - Compare list
 *
 * @author  Algoritmika Ltd.
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
$id                   = get_the_ID();
$the_query            = $params['the_query'];
$show_price           = true;
$show_stock           = true;
$show_add_to_cart_btn = true;
?>

<div class="iziModal" id="iziModal">
    <div class="alg-wc-cp-list responsive">

	<?php if ( $the_query != null && $the_query->have_posts() ) : ?>
        <table>

        <thead>
            <tr>
                <th class="product"><?php _e( 'Product', 'alg-wc-compare-products' ); ?></th>

                <?php // Product price ?>
                <?php if ( $show_price ) : ?>
                    <th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
                <?php endif; ?>

	            <?php // Product Stock ?>
	            <?php if ( $show_stock ) : ?>
                    <th class="product-stock"><?php _e( 'Stock', 'woocommerce' ); ?></th>
	            <?php endif; ?>

	            <?php // Add to cart button ?>
	            <?php if ( $show_add_to_cart_btn ) : ?>
                    <th class="add-to-cart-btn"><?php _e( 'Add to cart', 'woocommerce' ); ?></th>
	            <?php endif; ?>

	            <?php // Remove button ?>
	            <?php if ( $show_add_to_cart_btn ) : ?>
                    <th class="product-remove"></th>
	            <?php endif; ?>
            </tr>
        </thead>


		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<?php $product = wc_get_product( get_the_ID() ); ?>
            <tr>
                <td data-title="<?php _e( 'Product', 'alg-wc-compare-products' ); ?>" class="product">

                    <a class="product-thumbnail" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
						<?php echo $product->get_image() ?>
                    </a>
	                <div class="product-name"><strong><?php echo $product->get_title(); ?></strong></div>
                </td>

	            <?php // Product price ?>
	            <?php if ( $show_price ) : ?>
                    <td data-title="<?php _e( 'Price', 'woocommerce' ); ?>"
                        class="product-price"><?php echo $product->get_price_html(); ?>
                    </td>
	            <?php endif; ?>

	            <?php // Product Stock ?>
	            <?php if ( $show_stock ) : ?>
                    <td data-title="<?php _e( 'Stock', 'woocommerce' ); ?>" class="product-stock">
			            <?php if ( $product->is_in_stock() ) : ?>
				            <?php _e( 'In stock', 'woocommerce' ) ?>
			            <?php else: ?>
				            <?php _e( 'Out of stock', 'woocommerce' ); ?>
			            <?php endif; ?>
                    </td>
	            <?php endif; ?>

	            <?php // Add to cart button ?>
	            <?php if ( $show_add_to_cart_btn ) : ?>
                    <td data-title="<?php _e( 'Add to cart', 'woocommerce' ); ?>"
                        class="add-to-cart-btn"><?php echo do_shortcode('[add_to_cart show_price="false" style="" id="'.get_the_ID().'"]'); ?>
                    </td>
	            <?php endif; ?>

	            <?php // Remove button ?>
                <td data-title="<?php _e( 'Remove', 'alg-wc-compare-products' ); ?>"
                    class="product-remove"><?php echo Alg_WC_CP_Remove_Button::load_remove_button_template(); ?>
                </td>

            </tr>
        <?php endwhile;?>
        </table>
    <?php else: ?>
        <?php _e('The comparison list is empty', 'alg-wc-compare-products'); ?>
    <?php endif; ?>

    </div>
</div>