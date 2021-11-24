<?php 
/**
 * Customizer Custom Control Class Layout 
*/

if(class_exists( 'WP_Customize_control')):
	/**
   * Repeater Custom Control Function
  */
  class Fitness_Park_Repeater_Controler extends WP_Customize_Control {
    /**
     * The control type.
     *
     * @access public
     * @var string
    */
    public $type = 'repeater';

    public $fp_box_label = '';

    public $fp_box_add_control = '';

    private $cats = '';

    /**
     * The fields that each container row will contain.
     *
     * @access public
     * @var array
    */
    public $fields = array();

    /**
     * Repeater drag and drop controler
     *
     * @since  1.0.0
    */
    public function __construct( $manager, $id, $args = array(), $fields = array() ) {
      $this->fields = $fields;
      $this->fp_box_label = $args['fp_box_label'] ;
      $this->fp_box_add_control = $args['fp_box_add_control'];
      $this->cats = get_categories(array( 'hide_empty' => false ));
      parent::__construct( $manager, $id, $args );
    }

    public function render_content() {
      $values = json_decode($this->value());
      ?>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <?php if($this->description){ ?>
        <span class="description customize-control-description">
        <?php echo wp_kses_post($this->description); ?>
        </span>
      <?php } ?>

      <ul class="fp-repeater-field-control-wrap">
        <?php $this->fp_get_fields(); ?>
      </ul>
      <input type="hidden" <?php esc_attr( $this->link() ); ?> class="fp-repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />
      <button type="button" class="button fp-add-control-field"><?php echo esc_html( $this->fp_box_add_control ); ?></button>
      <?php
    }

    private function fp_get_fields(){
      $fields = $this->fields;
      $values = json_decode($this->value());
      if(is_array($values)){
      foreach($values as $value){    ?>
        <li class="fp-repeater-field-control">
          <h3 class="fp-repeater-field-title accordion-section-title"><?php echo esc_html( $this->fp_box_label ); ?></h3>
          <div class="fp-repeater-fields">
            <?php
              foreach ($fields as $key => $field) {
              $class = isset( $field['class'] ) ? $field['class'] : '';
            ?>
              <div class="fp-fields fp-type-<?php echo esc_attr( $field['type'] ).' '.esc_attr( $class ); ?>">
                <?php
                  $label = isset($field['label']) ? $field['label'] : '';
                  $description = isset($field['description']) ? $field['description'] : '';
                  if($field['type'] != 'checkbox'){ ?>
                    <span class="customize-control-title"><?php echo esc_html( $label ); ?></span>
                    <span class="description customize-control-description"><?php echo esc_html( $description ); ?></span>
                <?php }

                  $new_value = isset($value->$key) ? $value->$key : '';
                  $default = isset($field['default']) ? $field['default'] : '';

                  switch ( $field['type'] ) {
                    case 'text':
                      echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
                      break;

                    case 'select':
                      $options = $field['options'];
                      echo '<select  data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
                            foreach ( $options as $option => $val )
                            {
                                printf('<option value="%s" %s>%s</option>', esc_attr($option), selected($new_value, $option, false), esc_html($val));
                            }
                      echo '</select>';
                      break;

                    case 'icon':
                      echo '<div class="fp-selected-icon">';
                       echo '<img src="'.esc_url(get_template_directory_uri()).'/assets/images/'.esc_attr($new_value).'"/>';
                      echo '<span><i class="fas fa-angle-down"></i></span>';
                      echo '</div>';
                      echo '<ul class="fp-icon-list clearfix">';
                      $fp_icon_array = fp_icon_array();
                      foreach ($fp_icon_array as $fp_icon) {
                        $icon_class = $new_value == $fp_icon ? 'icon-active' : '';
                        echo '<li class='.esc_attr( $icon_class ).'><img src="'.esc_url(get_template_directory_uri()).'/assets/images/'.esc_attr( $fp_icon ).'" /></li>';
                      }
                      echo '</ul>';
                      echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
                      break;

                      case 'url':
                        echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';

                        break;

                      case 'icons':
                        echo '<div class="fp-repeater-selected-icon">';
                        echo '<i class="'.esc_attr($new_value).'"></i>';
                        echo '<span><i class="fa fa-angle-down"></i></span>';
                        echo '</div>';
                        echo '<ul class="fp-repeater-icon-list clearfix">';
                          $fp_awesome_icon_array = fp_awesome_icon_array();

                          foreach ($fp_awesome_icon_array as $fp_awesome_icon) {
                            $icon_class = $new_value == $fp_awesome_icon ? 'icon-active' : '';
                            echo '<li class='.esc_attr( $icon_class ).'><i class="'.esc_attr( $fp_awesome_icon ).'"></i></li>';
                          }
                        echo '</ul>';
                        echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
                        break;

                    default:
                      break;
                  }
                ?>
              </div>
            <?php } ?>
            <div class="clearfix fp-repeater-footer">
              <div class="alignright">
                <a class="fp-repeater-field-remove" href="#remove"><?php esc_html_e('Delete', 'fitness-park') ?></a> |
                <a class="fp-repeater-field-close" href="#close"><?php esc_html_e('Close', 'fitness-park') ?></a>
              </div>
            </div>
          </div>
        </li>
      <?php }
      }
    }
  }

   /**
     * Multiple Gallery Image Upload Custom Control Function
    */
    class Fitness_Park_Gallery_Control extends WP_Customize_Control{
        public $type = 'gallery';         
        public function render_content() { ?>
        <label>
            <span class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
            </span>

            <?php if($this->description){ ?>
                <span class="description customize-control-description">
                <?php echo wp_kses_post( $this->description ); ?>
                </span>
            <?php } ?>

            <div class="gallery-screenshot clearfix">
              <?php
                  {
                  $ids = explode( ',', $this->value() );
                      foreach ( $ids as $attachment_id ) {
                          $img = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
                          echo '<div class="screen-thumb"><img src="' . esc_url( $img[0] ) . '" /></div>';
                      }
                  }
              ?>
            </div>

            <input id="edit-gallery" class="button upload_gallery_button" type="button" value="<?php esc_attr_e('Add/Edit Gallery','fitness-park') ?>" />
            <input id="clear-gallery" class="button upload_gallery_button" type="button" value="<?php esc_attr_e('Clear','fitness-park') ?>" />
            <input type="hidden" class="gallery_values" <?php echo esc_url( $this->link() ); ?> value="<?php echo esc_attr( $this->value() ); ?>">
        </label>
        <?php }
    }

  /**
   * Multiple Check
  */
   class fitness_park_multiple_check_control extends WP_Customize_Control {

       /**
        * The type of customize control being rendered.
        *
        * @since  1.0.0
        * @access public
        * @var    string
        */
       public $type = 'checkbox-multiple';

       /**
        * Displays the control content.
        *
        * @since  1.0.0
        * @access public
        * @return void
        */
       public function render_content() {

           if ( empty( $this->choices ) )
               return; ?>
             
           <?php if ( !empty( $this->label ) ) : ?>
               <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
           <?php endif; ?>

           <?php if ( !empty( $this->description ) ) : ?>
               <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
           <?php endif; ?>

           <?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>
           <ul>
               <?php foreach ( $this->choices as $value => $label ) : ?>
                   <li>
                       <label>
                           <input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> /> 
                           <?php echo esc_html( $label ); ?>
                       </label>
                   </li>
               <?php endforeach; ?>
           </ul>
           <input type="hidden" <?php esc_url( $this->link() ); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
       <?php } 
    }
/**
   * Switch Controller ( Enable or Disable )
  */
  class fitness_park_switch_control extends WP_Customize_Control{

      public $type = 'switch';

      public $switch_label = array();

      public function __construct($manager, $id, $args = array() ){
          $this->switch_label = $args['switch_label'];
          parent::__construct( $manager, $id, $args );
      }

      public function render_content(){
      ?>
          <span class="customize-control-title">
              <?php echo esc_html( $this->label ); ?>
          </span>

          <?php if($this->description){ ?>
              <span class="description customize-control-description">
                <?php echo wp_kses_post( $this->description ); ?>
              </span>
          <?php } ?>

          <?php
              $switch_class = ($this->value() == 'enable') ? 'switch-on' : '';
              $switch_label = $this->switch_label;
          ?>
          <div class="onoffswitch <?php echo esc_attr( $switch_class ); ?>">
              <div class="onoffswitch-inner">
                  <div class="onoffswitch-active">
                      <div class="onoffswitch-switch"><?php echo esc_html( $switch_label['enable'] ) ?></div>
                  </div>

                  <div class="onoffswitch-inactive">
                      <div class="onoffswitch-switch"><?php echo esc_html( $switch_label['disable'] ) ?></div>
                  </div>
              </div>  
          </div>
          <input <?php $this->link(); ?> type="hidden" value="<?php echo esc_attr($this->value()); ?>"/>
          <?php
      }
  }

endif;

/**
* repeater icons function
*/
if(!function_exists('fp_icon_array') ){
  function fp_icon_array(){
    return array("icon-1.png","icon-2.png","icon-3.png","icon-4.png","icon-5.png","icon-6.png","icon-7.png","icon-8.png");
  }
}

/**
* repeater Social icons function.
*/
if(!function_exists('fp_awesome_icon_array') ){
  function fp_awesome_icon_array(){
    return array("fab fa-facebook","fab fa-youtube","fab fa-instagram","fab fa-twitter","fab fa-google","fab fa-linkedin","fab fa-pinterest","fab fa-dribbble");
  }
}

/**
 * Repeat Fields Sanitization
*/
	function fitness_park_sanitize_repeater($input){        
	  $input_decoded = json_decode( $input, true );
	  $allowed_html = array(
	    'br' => array(),
	    'em' => array(),
	    'strong' => array(),
	    'a' => array(
	      'href' => array(),
	      'class' => array(),
	      'id' => array(),
	      'target' => array()
	    ),
	    'button' => array(
	      'class' => array(),
	      'id' => array()
	    )
	  ); 

	  if(!empty($input_decoded)) {
	    foreach ($input_decoded as $boxes => $box ){
	      foreach ($box as $key => $value){
	        $input_decoded[$boxes][$key] = sanitize_text_field( $value );
	      }
	    }
	    return json_encode($input_decoded);
	  }      
	  return $input;
	}

/**
* select sanitization
*/
function fitness_park_sanitize_select( $input, $setting ){
   //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
  $input = sanitize_key($input);
  //get the list of possible select options 
  $choices = $setting->manager->get_control( $setting->id )->choices;
  //return input if valid or return default option
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );  
}

/**
 * Switch Sanitization Function.
 *
 * @since 1.1
 */
function fitness_park_sanitize_switch($input) {
   $valid_keys = array(
        'enable'  => esc_html__( 'Enable', 'fitness-park' ),
        'disable' => esc_html__( 'Disable', 'fitness-park' )
   );
   if ( array_key_exists( $input, $valid_keys ) ) {
      return $input;
   } else {
      return '';
   }
}

/**
 * Sanitize checkbox.
 *
 * @param  $input Whether the checkbox is input.
 */
function fitness_park_sanitize_checkbox( $input ) {
  return ( ( isset( $input ) && true === $input ) ? true : false );
}


if ( class_exists( 'WP_Customize_Control' ) ) {
  if ( !class_exists( 'Fitness_Park_Upgrade_Text' ) ) {
    class Fitness_Park_Upgrade_Text extends WP_Customize_Control {

        public $type = 'fitness-park-upgrade-text';

        public function render_content() {
            ?>
            <label>
                <span class="dashicons dashicons-info"></span>

                <?php if ($this->label) { ?>
                    <span>
                        <?php echo wp_kses_post($this->label); ?>
                    </span>
                <?php } ?>

                <a href="<?php echo esc_url('https://sparklewpthemes.com/wordpress-themes/fitnessparkpro/'); ?>" target="_blank"> <strong><?php echo esc_html__('Upgrade to PRO', 'fitness-park'); ?></strong></a>
            </label>

            <?php if ($this->description) { ?>
                <span class="description customize-control-description">
                    <?php echo wp_kses_post($this->description); ?>
                </span>
                <?php
            }

            $choices = $this->choices;
            if ($choices) {
                echo '<ul>';
                foreach ($choices as $choice) {
                    echo '<li>' . esc_html($choice) . '</li>';
                }
                echo '</ul>';
            }
        }

    }
  }
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  if ( !class_exists( 'Fitness_Park_Upgrade_Section' ) ) {
    class Fitness_Park_Upgrade_Section extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'fitness-park-upgrade-section';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $text = '';
        public $options = array();

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();

            $json['text'] = $this->text;
            $json['options'] = $this->options;

            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() {
            ?>
            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <label>
                    <# if ( data.title ) { #>
                    {{ data.title }}
                    <# } #>
                </label>

                <# if ( data.text ) { #>
                {{ data.text }}
                <# } #>

                <# _.each( data.options, function(key, value) { #>
                {{ key }}<br/>
                <# }) #>

                <a href="<?php echo esc_url('https://sparklewpthemes.com/wordpress-themes/fitnessparkpro/'); ?>" class="button button-primary" target="_blank"><?php echo esc_html__('Upgrade to Pro', 'fitness-park'); ?></a>
            </li>
            <?php
        }
    }
  }
}