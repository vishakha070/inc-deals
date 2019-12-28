<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/vishakha07/
 * @since      1.0.0
 *
 * @package    Inc_Deals
 * @subpackage Inc_Deals/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Inc_Deals
 * @subpackage Inc_Deals/admin
 * @author     Vishakha Gupta <vishakhagupta0706@gmail.com>
 */
class Inc_Deals_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name       The name of this plugin.
	 * @param    string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function enqueue_styles() {
		if ( ! wp_style_is( 'jquery-ui-css', 'enqueued' ) ) {
			wp_enqueue_style( 'jquery-ui-css', INC_PLUGIN_URL . 'lib/assets/css/jquery-ui.min.css', array(), $this->version, 'all' );
		}
		if ( ! wp_style_is( 'selectize-css', 'enqueued' ) ) {
			wp_enqueue_style( 'selectize-css', INC_PLUGIN_URL . 'lib/assets/css/selectize.css', array(), $this->version, 'all' );
		}
		if ( ! wp_style_is( $this->plugin_name, 'enqueued' ) ) {
			wp_enqueue_style( $this->plugin_name, INC_PLUGIN_URL . 'admin/assets/css/inc-deals-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function enqueue_scripts() {
		if ( ! wp_script_is( 'jquery-ui-datepicker', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery-ui-datepicker' );
		}
		if ( ! wp_script_is( 'selectize-js', 'enqueued' ) ) {
			wp_enqueue_script( 'selectize-js', INC_PLUGIN_URL . 'lib/assets/js/selectize.min.js', array( 'jquery' ), time(), false );
		}
		if ( ! wp_script_is( $this->plugin_name, 'enqueued' ) ) {
			wp_enqueue_script( $this->plugin_name, INC_PLUGIN_URL . 'admin/assets/js/inc-deals-admin.js', array( 'jquery' ), time(), false );
		}
	}

	/**
	 * Create custom post type.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function create_inc_deals_cpt() {
		$post_types = get_post_types();
		if ( ! in_array( 'deals', $post_types ) ) {
			$labels = array(
				'name'                  => esc_html__( 'Deals', 'inc-deals' ),
				'singular_name'         => esc_html__( 'Deal', 'inc-deals' ),
				'menu_name'             => esc_html__( 'Deals', 'inc-deals' ),
				'name_admin_bar'        => esc_html__( 'Deals', 'inc-deals' ),
				'add_new'               => esc_html__( 'Add New Deal', 'inc-deals' ),
				'add_new_item'          => esc_html__( 'Add New Deal', 'inc-deals' ),
				'new_item'              => esc_html__( 'New Deal', 'inc-deals' ),
				'view_item'             => esc_html__( 'View Deals', 'inc-deals' ),
				'all_items'             => esc_html__( 'All Deals', 'inc-deals' ),
				'search_items'          => esc_html__( 'Search Deals', 'inc-deals' ),
				'parent_item_colon'     => esc_html__( 'Parent Deal', 'inc-deals' ),
				'not_found'             => esc_html__( 'No Deal Found', 'inc-deals' ),
				'not_found_in_trash'    => esc_html__( 'No Deal Found In Trash', 'inc-deals' ),
				'featured_image'        => esc_html__( 'Logo', 'inc-deals' ),
				'set_featured_image'    => esc_html__( 'Set Logo', 'inc-deals' ),
				'remove_featured_image' => esc_html__( 'Remove Logo', 'inc-deals' ),
				'use_featured_image'    => esc_html__( 'Use as Logo', 'inc-deals' ),
			);

			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'menu_icon'          => 'dashicons-edit',
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'has_archive'        => true,
				'hierarchical'       => true,
				'supports'           => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail' ),
			);

			register_post_type( 'deals', $args );
		}
	}

	/**
	 * Add meta box for deal information.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function add_inc_deals_meta_boxes() {
		add_meta_box( 'inc_deals_info', esc_html__( 'Deal Information', 'inc-deals' ), [ $this, 'inc_deals_meta_box' ], 'deals', 'normal', 'core' );
	}

	/**
	 * Add meta box for deal information.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 * @param  object $post The post object.
	 */
	public function inc_deals_meta_box( $post ) {
		// make sure the form request comes from WordPress.
		wp_nonce_field( basename( __FILE__ ), 'inc_deals_meta_box_nonce' );

		// retrieve the meta values.
		$company_name   = get_post_meta( $post->ID, 'deal_info_company_name', true );
		$sector         = get_post_meta( $post->ID, 'deal_info_sectors', true );
		$launch_year    = get_post_meta( $post->ID, 'deal_info_launch_year', true );
		$founders       = get_post_meta( $post->ID, 'deal_info_founders', true );
		$stage          = get_post_meta( $post->ID, 'deal_info_stage', true );
		$funding_amount = get_post_meta( $post->ID, 'deal_info_funding_amount', true );
		$investors      = get_post_meta( $post->ID, 'deal_info_investors', true );
		$article_title  = get_post_meta( $post->ID, 'deal_info_article_title', true );
		$article_link   = get_post_meta( $post->ID, 'deal_info_article_link', true );
		?>
		<table class="form-table deals-info">
			<tbody>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Company Name', 'inc-deals' ); ?>
						</label>
					</th>
					<td>
						<input type="text" name="deal_info_company_name" value="<?php echo esc_attr( $company_name ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Sector', 'inc-deals' ); ?>
						</label>
					</th>
					<td>
						<select name="deal_info_sectors" class="inc-select-field">
							<option value="E-commerce" <?php selected( esc_attr( $sector ), 'E-commerce' ); ?>><?php esc_html_e( 'E-commerce', 'inc-deals' ); ?></option>
							<option value="FinTech" <?php selected( esc_attr( $sector ), 'FinTech' ); ?>><?php esc_html_e( 'FinTech', 'inc-deals' ); ?></option>
							<option value="Consumer Services" <?php selected( esc_attr( $sector ), 'Consumer Services' ); ?>><?php esc_html_e( 'Consumer Services', 'inc-deals' ); ?></option>
							<option value="HealthTech" <?php selected( esc_attr( $sector ), 'HealthTech' ); ?>><?php esc_html_e( 'HealthTech', 'inc-deals' ); ?></option>
							<option value="EdTech" <?php selected( esc_attr( $sector ), 'EdTech' ); ?>><?php esc_html_e( 'EdTech', 'inc-deals' ); ?></option>
							<option value="AgriTech" <?php selected( esc_attr( $sector ), 'AgriTech' ); ?>><?php esc_html_e( 'AgriTech', 'inc-deals' ); ?></option>
							<option value="Logistics" <?php selected( esc_attr( $sector ), 'Logistics' ); ?>><?php esc_html_e( 'Logistics', 'inc-deals' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Launch Year', 'inc-deals' ); ?>
						</label>
					</th>
					<td>
						<input type="year" name="deal_info_launch_year" value="<?php echo esc_attr( $launch_year ); ?>" id="deal_info_launch_year" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Founders', 'inc-deals' ); ?>
						</label>
					</th>
					<td>
						<input type="text" name="deal_info_founders" value="<?php echo esc_attr( $founders ); ?>" />
						<p class="description">
							<?php esc_html_e( 'Use comma( , ) to add multiple founders.', 'inc-deals' ); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Deal Stage', 'inc-deals' ); ?>
						</label>
					</th>
					<td>
						<select name="deal_info_stage" class="inc-select-field">
							<option value="Seed" <?php selected( esc_attr( $stage ), 'Seed' ); ?>>
								<?php esc_html_e( 'Seed', 'inc-deals' ); ?>
							</option>
							<option value="Pre-Series A" <?php selected( esc_attr( $stage ), 'Pre-Series A' ); ?>>
								<?php esc_html_e( 'Pre-Series A', 'inc-deals' ); ?>
							</option>
							<option value="Series A" <?php selected( esc_attr( $stage ), 'Series A' ); ?>>
								<?php esc_html_e( 'Series A', 'inc-deals' ); ?>
							</option>
							<option value="Pre-Series B" <?php selected( esc_attr( $stage ), 'Pre-Series B' ); ?>>
								<?php esc_html_e( 'Pre-Series B', 'inc-deals' ); ?>
							</option>
							<option value="Series B" <?php selected( esc_attr( $stage ), 'Series B' ); ?>>
								<?php esc_html_e( 'Series B', 'inc-deals' ); ?>
							</option>
							<option value="Series C" <?php selected( esc_attr( $stage ), 'Series C' ); ?>>
								<?php esc_html_e( 'Series C', 'inc-deals' ); ?>
							</option>
							<option value="Series D" <?php selected( esc_attr( $stage ), 'Series D' ); ?>>
								<?php esc_html_e( 'Series D', 'inc-deals' ); ?>
							</option>
							<option value="Series E" <?php selected( esc_attr( $stage ), 'Series E' ); ?>>
								<?php esc_html_e( 'Series E', 'inc-deals' ); ?>
							</option>
							<option value="Series F" <?php selected( esc_attr( $stage ), 'Series F' ); ?>>
								<?php esc_html_e( 'Series F', 'inc-deals' ); ?>
							</option>
							<option value="Late Stage" <?php selected( esc_attr( $stage ), 'Late Stage' ); ?>>
								<?php esc_html_e( 'Late Stage', 'inc-deals' ); ?>
							</option>
							<option value="Debt Financing" <?php selected( esc_attr( $stage ), 'Debt Financing' ); ?>>
								<?php esc_html_e( 'Debt Financing', 'inc-deals' ); ?>
							</option>
							<option value="Acquisition" <?php selected( esc_attr( $stage ), 'Acquisition' ); ?>>
								<?php esc_html_e( 'Acquisition', 'inc-deals' ); ?>
							</option>
							<option value="IPO" <?php selected( esc_attr( $stage ), 'IPO' ); ?>>
								<?php esc_html_e( 'IPO', 'inc-deals' ); ?>
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Funding Amount', 'inc-deals' ); ?>
						</label>
					</th>
					<td>
						<input type="number" min="0" name="deal_info_funding_amount" value="<?php echo esc_attr( $funding_amount ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Investors', 'inc-deals' ); ?>
						</label>
					</th>
					<td>
						<input type="text" name="deal_info_investors" value="<?php echo esc_attr( $investors ); ?>" />
						<p class="description">
							<?php esc_html_e( 'Use comma( , ) to add multiple investors.', 'inc-deals' ); ?>
						</p>	
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Article Title', 'inc-deals' ); ?>
						</label>
					</th>
					<td>
						<input type="text" name="deal_info_article_title" value="<?php echo esc_attr( $article_title ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Link to Article', 'inc-deals' ); ?>
						</label>
					</th>
					<td>
						<input type="url" name="deal_info_article_link" value="<?php echo esc_url( $article_link ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Add Deal information meta fields.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 * @param  int $post_id The post id.
	 */
	public function save_deals_meta_boxes_data( $post_id ) {

		$deal_info = wp_unslash( $_POST );
		if ( ! empty( $deal_info['inc_deals_meta_box_nonce'] ) ) {
			$nonce = sanitize_text_field( $deal_info['inc_deals_meta_box_nonce'] );
		}

		// verify taxonomies meta box nonce.
		if ( ! isset( $nonce ) || ! wp_verify_nonce( $nonce, basename( __FILE__ ) ) ) {
			return;
		}
		// return if autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save meta values.

		if ( isset( $deal_info['deal_info_company_name'] ) ) {
			update_post_meta( $post_id, 'deal_info_company_name', sanitize_text_field( $deal_info['deal_info_company_name'] ) );
		}

		if ( isset( $deal_info['deal_info_sectors'] ) ) {
			update_post_meta( $post_id, 'deal_info_sectors', sanitize_text_field( $deal_info['deal_info_sectors'] ) );
		}

		if ( isset( $deal_info['deal_info_launch_year'] ) ) {
			update_post_meta( $post_id, 'deal_info_launch_year', sanitize_text_field( $deal_info['deal_info_launch_year'] ) );
		}

		if ( isset( $deal_info['deal_info_founders'] ) ) {
			update_post_meta( $post_id, 'deal_info_founders', sanitize_text_field( $deal_info['deal_info_founders'] ) );
		}

		if ( isset( $deal_info['deal_info_stage'] ) ) {
			update_post_meta( $post_id, 'deal_info_stage', sanitize_text_field( $deal_info['deal_info_stage'] ) );
		}

		if ( isset( $deal_info['deal_info_funding_amount'] ) ) {
			update_post_meta( $post_id, 'deal_info_funding_amount', sanitize_text_field( $deal_info['deal_info_funding_amount'] ) );
		}

		if ( isset( $deal_info['deal_info_investors'] ) ) {
			update_post_meta( $post_id, 'deal_info_investors', sanitize_text_field( $deal_info['deal_info_investors'] ) );
		}

		if ( isset( $deal_info['deal_info_article_title'] ) ) {
			update_post_meta( $post_id, 'deal_info_article_title', sanitize_text_field( $deal_info['deal_info_article_title'] ) );
		}

		if ( isset( $deal_info['deal_info_article_link'] ) ) {
			update_post_meta( $post_id, 'deal_info_article_link', sanitize_text_field( $deal_info['deal_info_article_link'] ) );
		}

	}

}
