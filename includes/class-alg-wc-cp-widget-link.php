<?php
/**
 * Compare products for WooCommerce - Link Widget
 *
 * @version 2.0.0
 * @since   1.1.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Widget_Link' ) ) :

class Alg_WC_CP_Widget_Link extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @todo    [fix] when no comparison list "Page" is set
	 */
	function __construct() {
		parent::__construct(
			'alg_wc_cp_widget_link', // Base ID
			esc_html__( 'Comparison list link', 'compare-products-for-woocommerce' ), // Name
			array( 'description' => esc_html__( 'A link pointing to the comparison list', 'compare-products-for-woocommerce' ) ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @version 1.1.3
	 * @since   1.1.0
	 * @see     WP_Widget::widget()
	 * @param   array $args     Widget arguments.
	 * @param   array $instance Saved values from database.
	 */
	function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		$link_label        = ! empty( $instance['link_label'] ) ? $instance['link_label'] : '';
		$compare_list_link = Alg_WC_CP_Comparison_List::create_comparison_list_link( array( 'link_label' => $link_label ) );
		echo $compare_list_link;
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see     WP_Widget::form()
	 * @version 2.0.0
	 * @since   1.1.0
	 * @param   array $instance Previously saved values from database.
	 * @todo    [dev] (maybe) `placeholder="<?php echo esc_html__( 'Comparison List', 'compare-products-for-woocommerce' ); ?>"`
	 * @todo    [dev] (maybe) `placeholder="<?php echo esc_html__( 'View comparison list', 'compare-products-for-woocommerce' ); ?>"`
	 */
	function form( $instance ) {
		$title      = ! empty( $instance['title'] )      ? $instance['title']      : '';
		$link_label = ! empty( $instance['link_label'] ) ? $instance['link_label'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'compare-products-for-woocommerce' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				 name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link_label' ) ); ?>"><?php esc_attr_e( 'Link label:', 'compare-products-for-woocommerce' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link_label' ) ); ?>"
				 name="<?php echo esc_attr( $this->get_field_name( 'link_label' ) ); ?>" type="text" value="<?php echo esc_attr( $link_label ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see     WP_Widget::update()
	 * @version 1.1.0
	 * @since   1.1.0
	 * @param   array $new_instance Values just sent to be saved.
	 * @param   array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance               = array();
		$instance['title']      = ( ! empty( $new_instance['title'] ) )      ? strip_tags( $new_instance['title'] )      : '';
		$instance['link_label'] = ( ! empty( $new_instance['link_label'] ) ) ? strip_tags( $new_instance['link_label'] ) : '';
		return $instance;
	}

}

endif;
