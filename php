/*
* Adding extra field on New product popup/without popup form
*/
add_action( 'dokan_new_product_after_product_tags','new_product_field',10 );
function new_product_field(){ ?>
<div class="dokan-form-group">
<input type="text" class="dokan-form-control" name="new_field" placeholder="<?php esc_attr_e( 'Product Code', 'dokan-lite' ); ?>">
</div>
<?php
}
/*
* Saving product field data for edit and update
*/
add_action( 'dokan_new_product_added','save_add_product_meta', 10, 2 );
add_action( 'dokan_product_updated', 'save_add_product_meta', 10, 2 );
function save_add_product_meta($product_id, $postdata){
if ( ! dokan_is_user_seller( get_current_user_id() ) ) {
return;
        }
if ( ! empty( $postdata['new_field'] ) ) {
update_post_meta( $product_id, 'new_field', $postdata['new_field'] );
        }
}
/*
* Showing field data on product edit page
*/
add_action('dokan_product_edit_after_product_tags','show_on_edit_page',99,2);
function show_on_edit_page($post, $post_id){
$new_field         = get_post_meta( $post_id, 'new_field', true );
?>
<div class="dokan-form-group">
<input type="hidden" name="new_field" id="dokan-edit-product-id" value="<?php echo esc_attr( $post_id ); ?>"/>
<label for="new_field" class="form-label"><?php esc_html_e( 'Product Code', 'dokan-lite' ); ?></label>
<?php dokan_post_input_box( $post_id, 'new_field', array( 'placeholder' => __( 'product code', 'dokan-lite' ), 'value' => $new_field ) ); ?>
<div class="dokan-product-title-alert dokan-hide">
<?php esc_html_e( 'Please enter product code!', 'dokan-lite' ); ?>
</div>
</div> <?php
    }
// showing on single product page
add_action('woocommerce_single_product_summary','show_product_code',13);
function show_product_code(){
global $product;
if ( empty( $product ) ) {
return;
        }
$new_field = get_post_meta( $product->get_id(), 'new_field', true );
if ( ! empty( $new_field ) ) {
?>
<span class="details"><?php echo esc_attr__( 'Product Code:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $new_field ); ?></strong></span>
<?php
        }
}
