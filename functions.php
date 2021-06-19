/**
 * @snippet       Move Order Notes on WooCommerce Checkout
 * @author        Codeithub
 */
 
// 1. Hide default notes
 
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
 
// 2. Create new billing field
 
add_filter( 'woocommerce_checkout_fields' , 'codeithub_custom_order_notes' );
 
function codeithub_custom_order_notes( $fields ) {
   $fields['billing']['new_order_notes'] = array(
      'type' => 'textarea',
      'label' => 'New Order Notes',
      'class' => array('form-row-wide'),
      'clear' => true,
      'priority' => 999,
   );
   return $fields;
}
 
// 3. Save to existing order notes
 
add_action( 'woocommerce_checkout_update_order_meta', 'codeithub_custom_field_value_to_order_notes', 10, 2 );
 
function codeithub_custom_field_value_to_order_notes( $order_id, $data ) {
   if ( ! is_object( $order_id ) ) {
      $order = wc_get_order( $order_id );
   }
   $order->set_customer_note( isset( $data['new_order_notes'] ) ? $data['new_order_notes'] : '' );
   wc_create_order_note( $order_id, $data['new_order_notes'], true, true );
   $order->save();
}

