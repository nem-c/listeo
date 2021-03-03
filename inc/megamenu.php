<?php

add_action( 'wp_update_nav_menu_item', 'update_menu', 100, 3);
add_filter( 'wp_edit_nav_menu_walker', 'modify_backend_walker' , 100);

# Custom walker class for the wp_nav_menu
class listeo_megamenu_walker extends Walker_Nav_Menu
{
   /**
     * What the class handles.
     *
     * @see Walker::$tree_type
     * @since 3.0.0
     * @var string
     */
    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
   
    /**
     * Database fields to use.
     *
     * @see Walker::$db_fields
     * @since 3.0.0
     * @todo Decouple this.
     * @var array
     */
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

    //save current item so it can be used in start level
    private $curItem;
    private $curLvl;
    private $megamenu;
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
          $indent = str_repeat("\t", $depth);
          
            $megamenu = get_post_meta( $this->curItem->ID, '_menu-item-megamenu', true);
            $megamenu_width = get_post_meta( $this->curItem->ID, '_menu-item-columns', true);

            if($depth === 1) {
                
                $tag = "ul";
            } else {
                $tag = "ul";
            }
   
            if($megamenu) {
                
                $output .= "\n$indent<div class=\"mega-menu mobile-styles ".$megamenu_width." \"><ul>\n";  
            } else {
                $output .= "\n$indent<".$tag." class=\"sub-menu \">\n";
            }
        
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat("\t", $depth);

            $megamenu = get_post_meta( $this->curItem->ID, '_menu-item-megamenu', true);

            if($depth === 1) {
                
                if($megamenu) {

                    $output .= "\n$indent</ul>\n";
                } else {
                    $output .= "\n$indent</ul>\n";
                }
            } else {
               if($megamenu) {
                    $output .= "\n$indent</ul>\n";
                } else {
                    $output .= "\n$indent</ul>\n";
                }
            }

    }

    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        //save current item to private curItem to use it in start_lvl
        $this->curItem = $item;

        $class_names = '';
        $this->megamenu = get_post_meta( $item->ID, '_menu-item-megamenu', true);
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'parentid'.get_post_meta( $item->ID,  '_menu_item_menu_item_parent', true);
        /**
         * Filter the CSS class(es) applied to a menu item's <li>.
         *
         * @since 3.0.0
         *
         * @see wp_nav_menu()
         *
         * @param array  $classes The CSS classes that are applied to the menu item's <li>.
         * @param object $item    The current menu item.
         * @param array  $args    An array of wp_nav_menu() arguments.
         */
        $hiddenstatus = get_post_meta( $item->ID, '_menu-item-hiddenonmobile', true);
        if($hiddenstatus == 'hide') {
            $classes[] = 'hidden-on-mobile';
        }
        $classes[] = 'depth'.$depth;
        if($depth === 0 && $this->megamenu != '') {
            $classes[] = 'has-megamenu';
        } else {
            $classes[] = 'dropdown';
        }

        if($depth === 1) {
            $parent = get_post_meta( $item->ID, '_menu_item_menu_item_parent', true);
            $parent_has_megamenu = get_post_meta( $parent, '_menu-item-megamenu', true);

            if ($parent_has_megamenu == '_blank') {
                
                $widthclass = get_post_meta( $item->ID, '_menu-item-columns', true);
                $classes[] =  $widthclass;
            }

        }
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's <li>.
         *
         * @since 3.0.1
         *
         * @see wp_nav_menu()
         *
         * @param string $menu_id The ID that is applied to the menu item's <li>.
         * @param object $item    The current menu item.
         * @param array  $args    An array of wp_nav_menu() arguments.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';


        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        /**
         * Filter the HTML attributes applied to a menu item's <a>.
         *
         * @since 3.6.0
         *
         * @see wp_nav_menu()
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item The current menu item.
         * @param array  $args An array of wp_nav_menu() arguments.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
        $is_clickable = get_post_meta($item->object_id, 'link_disabled', true);
        $jsarg = ($is_clickable == '1') ? 'onclick="return false;"' : '';
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $linkrole = get_post_meta( $item->ID, '_menu-item-linkrole', true);
        
        $item_output = $args->before;
        $icon = get_post_meta( $item->ID, '_menu-item-icon', true); 
        if(!empty($icon)){
            if(substr($icon,0, 2) == 'ln'){
                $icon = '<i class="'.esc_attr($icon).'"></i> ';
            } else {
                  $icon = '<i class=" sl sl-icon-'.esc_attr($icon).'"></i> ';
            }
            
        }
        if($depth === 1 ) {
            if($linkrole == 'title' ) {
                $item_output .= $args->link_before .'<span class="mega-menu-headline">'.$icon. apply_filters( 'the_title', $item->title, $item->ID ) .'</span>'. $args->link_after;
            } elseif($linkrole == 'paragraph') {
                $content = get_post_meta( $item->ID, '_menu-item-html', true);
                $item_output .= '<p>';
                $item_output .= $args->link_before;
                $item_output .= do_shortcode($content);
                $item_output .= $args->link_after;
                $item_output .= '</p>';
            } elseif($linkrole == 'paragraphtitle') {
                $content = get_post_meta( $item->ID, '_menu-item-html', true);
                $item_output .= '<p>';
                $item_output .= $args->link_before .'<span class="mega-menu-headline"">'.$icon. apply_filters( 'the_title', $item->title, $item->ID ) .'</span>';
                $item_output .= do_shortcode($content);
                $item_output .= $args->link_after;
                $item_output .= '</p>';
            } else if($linkrole == 'hidden') {
             
            } else {
                $item_output .= '<a'. $attributes .' '.$jsarg.'>';
                $item_output .= $args->link_before .$icon. apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</a>';
            }
        } elseif( $depth === 0 ) {
                $item_output .= '<a'. $attributes .' '.$jsarg.'>';
                $item_output .= $args->link_before .$icon. apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</a>';
        } else {
                $item_output .= '<a'. $attributes .' '.$jsarg.'>';
                $item_output .= $args->link_before .$icon. apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</a>';
        }


    /*    if($depth === 0 && $this->megamenu != '') {
            $item_output .= '<div class="mega two-cols">
                            <div class="mega-section">';
        }*/

        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes $args->before, the opening <a>,
         * the menu item's title, the closing </a>, and $args->after. Currently, there is
         * no filter for modifying the opening and closing <li> for a menu item.
         *
         * @since 3.0.0
         *
         * @see wp_nav_menu()
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of wp_nav_menu() arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        
        $this->megamenu = get_post_meta( $item->ID, '_menu-item-megamenu', true);
        if($depth === 0 && $this->megamenu != '') {
            $output .= "</div>\n";
        } else {
         $output .= "</li>\n";
        }
    }

}



/**
 * Walker_Nav_Menu class copied from
 */

class purethemes_walker_nav_edit extends Walker_Nav_Menu {
    /**
     * @see Walker_Nav_Menu::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function start_lvl(&$output, $depth = 0, $args = array()) {}

    /**
     * @see Walker_Nav_Menu::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function end_lvl(&$output, $depth = 0, $args = array()) {
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param object $args
     */
 public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $_wp_nav_menu_max_depth;
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

        ob_start();
        $item_id = esc_attr( $item->ID );
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );


        $original_title = false;
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = get_the_title( $original_object->ID );
        } elseif ( 'post_type_archive' == $item->type ) {
            $original_object = get_post_type_object( $item->object );
            if ( $original_object ) {
                $original_title = $original_object->labels->archives;
            }
        }

        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );

        $title = $item->title;

        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( esc_html__( '%s (Invalid)','listeo' ), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( esc_html__('%s (Pending)','listeo'), $item->title );
        }

        $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

        $submenu_text = '';
        if ( 0 == $depth )
            $submenu_text = 'style="display: none;"';

        ?>
            <li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
            <div class="menu-item-bar">
                <div class="menu-item-handle">
                    <span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo esc_attr($submenu_text); ?>><?php esc_html_e( 'sub item','listeo' ); ?></span></span>
                    <span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-up-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-up" aria-label="<?php esc_attr_e( 'Move up','listeo' ) ?>">&#8593;</a>
                            |
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-down-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-down" aria-label="<?php esc_attr_e( 'Move down','listeo' ) ?>">&#8595;</a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" href="<?php
                            echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                        ?>" aria-label="<?php esc_attr_e( 'Edit menu item','listeo' ); ?>"><?php esc_html_e( 'Edit','listeo' ); ?></a>
                    </span>
                </div>
            </div>

            
            <div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
                <?php if ( 'custom' == $item->type ) : ?>
                    <p class="field-url description description-wide">
                        <label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'URL','listeo' ); ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                        </label>
                    </p>
                <?php endif; ?>
                <p class="description description-wide">
                    <label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
                        <?php esc_html_e( 'Navigation Label','listeo' ); ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="field-title-attribute field-attr-title description description-wide">
                    <label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
                        <?php esc_html_e( 'Title Attribute','listeo' ); ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
                        <?php esc_html_e( 'Open link in a new tab','listeo' ); ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
                        <?php esc_html_e( 'CSS Classes (optional)','listeo' ); ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
                        <?php esc_html_e( 'Link Relationship (XFN)' ,'listeo'); ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                    </label>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
                        <?php esc_html_e( 'Description','listeo' ); ?><br />
                        <textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                        <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.','listeo'); ?></span>
                    </label>
                </p>
                <p class="field-menu-columns description description-thin">
                <?php  $icon = get_post_meta( $item->ID, '_menu-item-icon', true); ?>
                    <label for="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>"><?php esc_html_e( 'Icon','listeo' ); ?>
                        <select id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-icon" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]">
                            <?php  
                           
                            echo get_listeo_icons_dropdown($icon); 
                            ?>
                        </select>
                    </label>
                </p>

                <!-- custom element for columns number -->

                <?php if($depth === 0) { ?>

                <p class="field-megamenu description">
                    <label for="edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>">
                        <?php $statuscheckbox=''; $megamenu = get_post_meta( $item->ID, '_menu-item-megamenu', true); if($megamenu != "") $statuscheckbox = "checked='checked'";?>
                        <input type="checkbox" id="edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-megamenu[<?php echo esc_attr($item_id); ?>]"<?php echo esc_attr($statuscheckbox); ?> />
                        <?php esc_html_e( 'Enable megamenu','listeo' ); ?>
                    </label>
                </p>
                <p class="field-menu-columns description description-thin">
                    <label for="edit-menu-item-colwidth-<?php echo esc_attr($item_id); ?>"><?php esc_html_e( 'Number of columns','listeo' ); ?>
                        <select id="edit-menu-item-colwidth-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-columns" name="menu-item-columns[<?php echo esc_attr($item_id); ?>]">
                            <?php  $col = get_post_meta( $item->ID, '_menu-item-columns', true); ?>
                   
                            <option value="two-columns" <?php if($col == 'two-columns') { echo 'selected'; } ?>><?php esc_html_e('2 columns','listeo'); ?></option>
                            <option value="three-columns" <?php if($col == 'three-columns') { echo 'selected'; } ?>><?php esc_html_e('3 columns','listeo'); ?></option>
                            <option value="four-columns" <?php if($col == 'four-columns') { echo 'selected'; } ?>><?php esc_html_e('4 columns','listeo'); ?></option>
                        </select>
                    </label>
                </p>

                <?php } ?>
                <?php if($depth === 1) { ?>
               
                <p class="field-menu-linkrole description description-thin">
                    <label for="edit-menu-item-linkrole-<?php echo esc_attr($item_id); ?>"><?php esc_html_e( 'Act as link or title','listeo' ); ?>
                        <select id="edit-menu-item-linkrole-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-linkrole" name="menu-item-linkrole[<?php echo esc_attr($item_id); ?>]">
                            <?php  $val = get_post_meta( $item->ID, '_menu-item-linkrole', true); ?>
                            <option value="link" <?php if($val == 'link') { echo 'selected'; } ?>><?php esc_html_e('Link', "listeo"); ?></option>
                            <option value="hidden" <?php if($val == 'hidden') { echo 'selected'; } ?>><?php esc_html_e('Hidden element', "listeo"); ?></option>
                            <option value="title" <?php if($val == 'title') { echo 'selected'; } ?>><?php esc_html_e('Title','listeo'); ?></option>
                            <option value="paragraph" <?php if($val == 'paragraph') { echo 'selected'; } ?>><?php esc_html_e('Text','listeo'); ?></option>
                            <option value="paragraphtitle" <?php if($val == 'paragraphtitle') { echo 'selected'; } ?>><?php esc_html_e('Text with title','listeo'); ?></option>
                        </select>
                    </label>
                </p>
                <p class="field-menu-linkrole description description-wide">
                    <label for="edit-menu-item-html-<?php echo esc_attr($item_id); ?>"><?php esc_html_e( 'Custom html text','listeo' ); ?>
                         <?php $content = get_post_meta( $item->ID, '_menu-item-html', true); ?>
                         <textarea id="edit-menu-item-html-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-html" rows="3" cols="20" name="menu-item-html[<?php echo esc_attr($item_id); ?>]"><?php
                         $allowed_tags = wp_kses_allowed_html( 'post' );
                         echo wp_kses( $content, $allowed_tags );

                          ?></textarea>
                    </label>
                </p>
                <?php } ?>
                <p class="field-hiddenonmobile description description-wide">
                    <label for="edit-menu-item-hiddenonmobile-<?php echo esc_attr($item_id); ?>">
                        <?php $statuscheckbox=''; $mobilestatus = get_post_meta( $item->ID, '_menu-item-hiddenonmobile', true); if($mobilestatus == "hide") $statuscheckbox = "checked='checked'";?>
                        <input type="checkbox" id="edit-menu-item-hiddenonmobile-<?php echo esc_attr($item_id); ?>" value="hide" name="menu-item-hiddenonmobile[<?php echo esc_attr($item_id); ?>]" <?php echo esc_attr($statuscheckbox); ?> />
                        <?php esc_html_e( 'Hide on mobile navigation','listeo' );  ?>
                    </label>
                </p>



                <!-- eof custom element for columns number -->
                <p class="field-move hide-if-no-js description description-wide">
                    <label>
                        <span><?php esc_html_e( 'Move','listeo' ); ?></span>
                        <a href="#" class="menus-move menus-move-up" data-dir="up"><?php esc_html_e( 'Up one','listeo' ); ?></a>
                        <a href="#" class="menus-move menus-move-down" data-dir="down"><?php esc_html_e( 'Down one','listeo' ); ?></a>
                        <a href="#" class="menus-move menus-move-left" data-dir="left"></a>
                        <a href="#" class="menus-move menus-move-right" data-dir="right"></a>
                        <a href="#" class="menus-move menus-move-top" data-dir="top"><?php esc_html_e( 'To the top','listeo' ); ?></a>
                    </label>
                </p>

                <div class="menu-item-actions description-wide submitbox">
                    <?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
                        <p class="link-to-original">
                            <?php printf( esc_html__('Original: %s','listeo'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                        </p>
                    <?php endif; ?>
                    <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'delete-menu-item',
                                'menu-item' => $item_id,
                            ),
                            admin_url( 'nav-menus.php' )
                        ),
                        'delete-menu_item_' . $item_id
                    ); ?>"><?php esc_html_e( 'Remove' ,'listeo'); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
                        ?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel','listeo'); ?></a>
                </div>

                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul>
        <?php
        $output .= ob_get_clean();
    }
}

        function modify_backend_walker($name)
        {
            return 'purethemes_walker_nav_edit';
        }

        /*
         * Save and Update the Custom Navigation Menu Item Properties by checking all $_POST vars with the name of $check
         * @param int $menu_id
         * @param int $menu_item_db
         */
        function update_menu($menu_id, $menu_item_db)
        {
            $check = array('columns','linkrole','megamenu', 'icon','columnscont','pureicon','html','hiddenonmobile','colwidth' );

            foreach ( $check as $key )
            {
                if(!isset($_POST['menu-item-'.$key][$menu_item_db]))
                {
                    $_POST['menu-item-'.$key][$menu_item_db] = "";
                }

                $value = $_POST['menu-item-'.$key][$menu_item_db];
                update_post_meta( $menu_item_db, '_menu-item-'.$key, $value );
            }
        }



//responsive walker

class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu{
    var $to_depth = -1;
    private $curItem;
    function start_lvl(&$output, $depth = 0, $args = array()){
             $id = $this->curItem->ID;
             $linkrole = get_post_meta( $id, '_menu-item-linkrole', true);
             $types  = array( 'paragraph', 'title' );
             if(!in_array( $linkrole, $types )) {

              $output .= '</option>';
          }
     }

  function end_lvl(&$output, $depth = 0, $args = array()){
      $indent = str_repeat("\t", $depth); // don't output children closing tag
  }

  function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0){
      $this->curItem = $item;
      $indent = ( $depth ) ? str_repeat( "&nbsp;", $depth * 4 ) : '';
      $class_names = $value = '';
      $classes = empty( $item->classes ) ? array() : (array) $item->classes;
      $classes[] = 'menu-item-' . $item->ID;
      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
      $class_names = ' class="' . esc_attr( $class_names ) . '"';
      $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
      $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
      $value = ' value="'. $item->url .'"';
      $linkrole = get_post_meta( $item->ID, '_menu-item-linkrole', true);
      $types  = array( 'paragraph', 'titleh4', 'titleh5' );
      $args = (object) $args;
      if(!in_array( $linkrole, $types )) {
          $output .= '<option'.$id.$value.$class_names.'>';
          $item_output = $args->before;
    
          $item_output .= $args->link_before.  apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
          $output .= $indent.$item_output;
      }
  }

  function end_el(&$output, $item, $depth = 0, $args = array()){
     $linkrole = get_post_meta( $item->ID, '_menu-item-linkrole', true);
     if($linkrole != 'paragraph' || $linkrole != 'titleh4' || $linkrole != 'titleh5') {
      if(substr($output, -9) != '</option>') {
            $output .= "</option>"; // replace closing </li> with the option tag

        }
        }
    }
}

?>