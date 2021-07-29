<?php
/**
 * Toggle button template - Default button
 *
 * Button responsible for Comparing products
 *
 * @author  Algoritmika Ltd.
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
$id         = get_the_ID();
$action     = $params['btn_data_action'];
$class      = $params['btn_class'];
$label      = $params['btn_label'];
$icon_class = $params['btn_icon_class'];
$href       = $params['btn_href'];
?>

<div class="alg-wc-cp-default-btn-wrapper">
	<a href="<?php echo esc_url( $href ); ?>" data-item_id="<?php echo $id; ?>" data-action="<?php echo esc_attr( $action );?>" class="<?php echo esc_attr( $class );?>">
		<span class="alg-wc-cp-btn-text"><?php echo esc_html( $label ); ?></span>
		<i class="<?php echo esc_attr( $icon_class );?>" aria-hidden="true"></i>
	</a>
</div>
