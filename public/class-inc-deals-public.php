<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/vishakha07/
 * @since      1.0.0
 *
 * @package    Inc_Deals
 * @subpackage Inc_Deals/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Inc_Deals
 * @subpackage Inc_Deals/public
 * @author     Vishakha Gupta <vishakhagupta0706@gmail.com>
 */
class Inc_Deals_Public {

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
	 * @param    string $plugin_name       The name of the plugin.
	 * @param    string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function enqueue_styles() {
		if ( ! wp_style_is( 'datepicker-css', 'enqueued' ) ) {
			wp_enqueue_style( 'datepicker-css', INC_PLUGIN_URL . 'lib/assets/css/datepicker.css', array(), $this->version, 'all' );
		}
		if ( ! wp_style_is( 'bootstrap-css', 'enqueued' ) ) {
			wp_enqueue_style( 'bootstrap-css', INC_PLUGIN_URL . 'lib/assets/css/bootstrap.min.css', array(), $this->version, 'all' );
		}
		if ( ! wp_style_is( $this->plugin_name, 'enqueued' ) ) {
			wp_enqueue_style( $this->plugin_name, INC_PLUGIN_URL . 'public/assets/css/inc-deals-public.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function enqueue_scripts() {
		if ( ! wp_script_is( 'datepicker-js', 'enqueued' ) ) {
			wp_enqueue_script( 'datepicker-js', INC_PLUGIN_URL . 'lib/assets/js/datepicker.js', array( 'jquery' ), $this->version, false );
		}
		if ( ! wp_script_is( 'bootstrap-js', 'enqueued' ) ) {
			wp_enqueue_script( 'bootstrap-js', INC_PLUGIN_URL . 'lib/assets/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		}
		if ( ! wp_script_is( $this->plugin_name, 'enqueued' ) ) {
			wp_enqueue_script( $this->plugin_name, INC_PLUGIN_URL . 'public/assets/js/inc-deals-public.js', array( 'jquery' ), $this->version, false );
		}
		wp_localize_script(
			$this->plugin_name,
			'inc_deal',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	/**
	 * Display all deals.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 * @param  array $atts Shortcode includes a parameter for show deals accordingly.
	 */
	public function display_all_deals( $atts = array() ) {
		global $post;
		$atts  = shortcode_atts(
			array(
				'posts_per_page' => -1,
			),
			$atts
		);
		$args  = array(
			'post_type'      => 'deals',
			'posts_per_page' => $atts['posts_per_page'],
			'post_status'    => 'publish',
		);
		$query = new WP_Query( $args );
		ob_start();
		if ( $query->have_posts() ) : ?>
			<div class="container">
				<div class="inc_deal_filters col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-1" >
					<form id="inc_deal_filter" method="post">
						<div class="form-group col-lg-3 col-xs-12">
						  	<label for="inc-sectors"><?php esc_html_e( 'Sector', 'inc-deals' ); ?></label>
						  	<select class="form-control" id="inc-sectors">
						  		<option value=""></option>
								<option value="E-commerce"><?php esc_html_e( 'E-commerce', 'inc-deals' ); ?></option>
								<option value="FinTech"><?php esc_html_e( 'FinTech', 'inc-deals' ); ?></option>
								<option value="Consumer Services"><?php esc_html_e( 'Consumer Services', 'inc-deals' ); ?></option>
								<option value="HealthTech"><?php esc_html_e( 'HealthTech', 'inc-deals' ); ?></option>
								<option value="EdTech"><?php esc_html_e( 'EdTech', 'inc-deals' ); ?></option>
								<option value="AgriTech"><?php esc_html_e( 'AgriTech', 'inc-deals' ); ?></option>
								<option value="Logistics"><?php esc_html_e( 'Logistics', 'inc-deals' ); ?></option>
							</select>
						</div>
						<div class="form-group col-lg-2 col-xs-12">
						   <label for="inc-launch-year"><?php esc_html_e( 'Launch Year', 'inc-deals' ); ?></label>
						   <input type="text" class="form-control" id="inc-launch-year">
						</div>
						<div class="form-group col-lg-3 col-xs-12">
						  	<label for="inc-deal-stage"><?php esc_html_e( 'Deal Stage', 'inc-deals' ); ?></label>
						  	<select class="form-control" id="inc-deal-stage">
						  		<option value=""></option>
								<option value="Seed">
									<?php esc_html_e( 'Seed', 'inc-deals' ); ?>
								</option>
								<option value="Pre-Series A">
									<?php esc_html_e( 'Pre-Series A', 'inc-deals' ); ?>
								</option>
								<option value="Series A">
									<?php esc_html_e( 'Series A', 'inc-deals' ); ?>
								</option>
								<option value="Pre-Series B">
									<?php esc_html_e( 'Pre-Series B', 'inc-deals' ); ?>
								</option>
								<option value="Series B">
									<?php esc_html_e( 'Series B', 'inc-deals' ); ?>
								</option>
								<option value="Series C">
									<?php esc_html_e( 'Series C', 'inc-deals' ); ?>
								</option>
								<option value="Series D">
									<?php esc_html_e( 'Series D', 'inc-deals' ); ?>
								</option>
								<option value="Series E">
									<?php esc_html_e( 'Series E', 'inc-deals' ); ?>
								</option>
								<option value="Series F">
									<?php esc_html_e( 'Series F', 'inc-deals' ); ?>
								</option>
								<option value="Late Stage">
									<?php esc_html_e( 'Late Stage', 'inc-deals' ); ?>
								</option>
								<option value="Debt Financing">
									<?php esc_html_e( 'Debt Financing', 'inc-deals' ); ?>
								</option>
								<option value="Acquisition">
									<?php esc_html_e( 'Acquisition', 'inc-deals' ); ?>
								</option>
								<option value="IPO">
									<?php esc_html_e( 'IPO', 'inc-deals' ); ?>
								</option>
							</select>
						</div>
						<div class="form-group col-lg-2 col-xs-12">
						  <label for="inc-funding-amount"><?php esc_html_e( 'Funding Amount', 'inc-deals' ); ?></label>
						  <input type="range" class="form-control" id="inc-funding-amount" min="0" step="1000" max="10000000">
						  <span class="funding-amount"></span>
						</div>
						<div class="form-group col-lg-2 col-xs-12">
							<input type="hidden" name="_nonce" id="inc_deals_filter_nonce" value="<?php echo esc_attr( wp_create_nonce( 'inc_deals_filter_nonce' ) ); ?>">
							<input type="hidden" class="inc_posts_per_page" value="<?php echo esc_attr( $atts['posts_per_page'] ); ?>">
						  <button id="inc_deal_filter_submit" class="btn btn-primary"><?php esc_html_e( 'Search', 'inc-deals' ); ?></button>
						</div>
					</form>
				</div>
				<div id="inc_deals_wrapper" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$postid        = get_the_ID();
					$sectors       = get_post_meta( $postid, 'deal_info_sectors', true );
					$launch_year   = get_post_meta( $postid, 'deal_info_launch_year', true );
					$founders      = get_post_meta( $postid, 'deal_info_founders', true );
					$investors     = get_post_meta( $postid, 'deal_info_investors', true );
					$article_title = get_post_meta( $postid, 'deal_info_article_title', true );
					$article_link  = get_post_meta( $postid, 'deal_info_article_link', true );
					?>
					<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
						<div class="card">
							<div class="card-header">
								<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12"><?php the_post_thumbnail( 'thumbnail' ); ?></div>
								<div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
									<h4 class="card-title">
										<?php the_title(); ?>
									</h4>
									<div class="d-flex justify-content-between align-items-center">
										<label><?php echo esc_html__( 'Sector', 'inc-deals' ); ?> : </label>
										<?php echo esc_html( $sectors ); ?>
									</div>
								</div>
							</div>
							<div class="card-body">
								  <div class="card-text col-lg-12 col-md-12 col-sm-12 col-xs-12">
									  <div class="d-flex justify-content-between align-items-center">
										  <label><?php echo esc_html__( 'Launch', 'inc-deals' ); ?> : </label>
										<?php echo esc_html( $launch_year ); ?>
									  </div>
									  <div class="d-flex justify-content-between align-items-center">
										  <label><?php esc_html_e( 'Founders', 'inc-deals' ); ?> : </label>
										<?php echo esc_html( $founders ); ?>
									  </div>
									  <div class="d-flex justify-content-between align-items-center">
										  <label><?php esc_html_e( 'Investors', 'inc-deals' ); ?> : </label>
										<?php echo esc_html( $investors ); ?>
									  </div>
									  <div class="d-flex justify-content-between align-items-center">
										  	<label><?php esc_html_e( 'News', 'inc-deals' ); ?> : </label>
											<a href="<?php echo esc_url( $article_link ); ?>" target="popup" onclick="window.open( '<?php echo esc_url( $article_link ); ?>','popup','width=600,height=600,scrollbars=no,resizable=no'); return false;" >
											<?php echo esc_html( $article_title ); ?>
										  </a>
									  </div>
								  </div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		else :
			esc_html_e( 'No Deal found.', 'inc-deals' );
		endif;
		return ob_get_clean();
	}

	/**
	 * Display single deal.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 * @param  array $atts Shortcode includes a parameter for show deal according to post id.
	 */
	public function display_single_deal( $atts = array() ) {
		global $post;
		$atts  = shortcode_atts(
			array(
				'post_id' => '',
			),
			$atts
		);
		$args  = array(
			'post_type'   => 'deals',
			'post__in'    => array( $atts['post_id'] ),
			'post_status' => 'publish',
		);
		$query = new WP_Query( $args );
		ob_start();
		if ( $query->have_posts() ) :
			?>
			<div class="container">
				<div id="inc_single_deal_wrapper">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$postid      = get_the_ID();
					$sectors     = get_post_meta( $postid, 'deal_info_sectors', true );
					$launch_year = get_post_meta( $postid, 'deal_info_launch_year', true );
					$founders    = get_post_meta( $postid, 'deal_info_founders', true );
					if ( ! empty( $founders ) ) {
						$founders_arr   = explode( ',', $founders );
						$total_founders = count( $founders_arr );
						if ( $total_founders > 1 ) {
							$founders = $founders_arr[0] . ' +' . ( $total_founders - 1 );
						} else {
							$founders = $founders;
						}
					}
					$investors = get_post_meta( $postid, 'deal_info_investors', true );
					if ( ! empty( $investors ) ) {
						$investors_arr   = explode( ',', $investors );
						$total_investors = count( $investors_arr );
						if ( $total_investors > 2 ) {
							$investors = $investors_arr[0] . ', ' . $investors_arr[1] . ' +' . ( $total_investors - 2 );
						} else {
							$investors = $investors;
						}
					}
					$article_title = get_post_meta( $postid, 'deal_info_article_title', true );
					$article_link  = get_post_meta( $postid, 'deal_info_article_link', true );
					?>

					<div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 col-lg-offset-3">
						<div class="card">
							<div class="card-header">
								<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12"><?php the_post_thumbnail( 'thumbnail' ); ?></div>
								<div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
									<h4 class="card-title">
										<?php the_title(); ?>
									</h4>
									<div class="d-flex justify-content-between align-items-center">
										<label><?php echo esc_html__( 'Sector', 'inc-deals' ); ?> : </label>
										<?php echo esc_html( $sectors ); ?>
									</div>
								</div>
							</div>
							<div class="card-body">
								  <div class="card-text col-lg-12 col-md-12 col-sm-12 col-xs-12">
									  <div class="d-flex justify-content-between align-items-center">
										  <label><?php echo esc_html__( 'Launch', 'inc-deals' ); ?> : </label>
										<?php echo esc_html( $launch_year ); ?>
									  </div>
									  <div class="d-flex justify-content-between align-items-center">
										  <label><?php esc_html_e( 'Founders', 'inc-deals' ); ?> : </label>
										<?php echo esc_html( $founders ); ?>
									  </div>
									  <div class="d-flex justify-content-between align-items-center">
										  <label><?php esc_html_e( 'Investors', 'inc-deals' ); ?> : </label>
										<?php echo esc_html( $investors ); ?>
									  </div>
									  <div class="d-flex justify-content-between align-items-center">
										  <label><?php esc_html_e( 'News', 'inc-deals' ); ?> : </label>
										  <a href="<?php echo esc_url( $article_link ); ?>" target="popup" onclick="window.open( '<?php echo esc_url( $article_link ); ?>','popup','width=600,height=600,scrollbars=no,resizable=no'); return false;" >
											<?php echo esc_html( $article_title ); ?>
										  </a>
									  </div>
								  </div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		else :
			esc_html_e( 'No Deal found.', 'inc-deals' );
		endif;
		return ob_get_clean();
	}

	/**
	 * Get filtered deals.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function inc_filter_deals_ajax() {
		global $post;
		$filter_params = wp_unslash( $_POST );
		if ( ! empty( $filter_params['nonce'] ) ) {
			$nonce = sanitize_text_field( $filter_params['nonce'] );
			if ( isset( $nonce ) && wp_verify_nonce( $nonce, 'inc_deals_filter_nonce' ) ) {
				if ( isset( $filter_params['action'] ) ) {
					$action = sanitize_text_field( $filter_params['action'] );
				} else {
					$action = '';
				}
				if ( isset( $filter_params['funding_amount'] ) ) {
					$funding_amount = sanitize_text_field( $filter_params['funding_amount'] );
				} else {
					$funding_amount = '';
				}
				if ( isset( $filter_params['sector'] ) ) {
					$sector = sanitize_text_field( $filter_params['sector'] );
				} else {
					$sector = '';
				}
				if ( isset( $filter_params['launch_year'] ) ) {
					$launch_year = sanitize_text_field( $filter_params['launch_year'] );
				} else {
					$launch_year = '';
				}
				if ( isset( $filter_params['deal_stage'] ) ) {
					$deal_stage = sanitize_text_field( $filter_params['deal_stage'] );
				} else {
					$deal_stage = '';
				}
				if ( isset( $filter_params['posts_per_page'] ) ) {
					$posts_per_page = sanitize_text_field( $filter_params['posts_per_page'] );
				} else {
					$posts_per_page = '';
				}

				if ( 'inc_filter_deals' === $action ) {
					$meta_query = array( 'relation' => 'AND' );
					if ( ! empty( $funding_amount ) ) {
						$funding_meta = array(
							'key'     => 'deal_info_funding_amount',
							'value'   => $funding_amount,
							'compare' => '<=',
							'type'    => 'DECIMAL',
						);
						array_push( $meta_query, $funding_meta );
					}
					if ( ! empty( $sector ) ) {
						$sector_meta = array(
							'key'     => 'deal_info_sectors',
							'value'   => $sector,
							'compare' => '=',
						);
						array_push( $meta_query, $sector_meta );
					}
					if ( ! empty( $launch_year ) ) {
						$launch_year_meta = array(
							'key'     => 'deal_info_launch_year',
							'value'   => $launch_year,
							'compare' => '=',
						);
						array_push( $meta_query, $launch_year_meta );
					}
					if ( ! empty( $deal_stage ) ) {
						$deal_stage_meta = array(
							'key'     => 'deal_info_stage',
							'value'   => $deal_stage,
							'compare' => '=',
						);
						array_push( $meta_query, $deal_stage_meta );
					}
					$args = array(
						'post_type'      => 'deals',
						'posts_per_page' => $posts_per_page,
						'post_status'    => 'publish',
						'meta_query'     => array(
							'relation' => 'AND',
							$meta_query,
						),
					);

					$query = new WP_Query( $args );
					if ( $query->have_posts() ) :
						?>
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();
							$postid        = get_the_ID();
							$sectors       = get_post_meta( $postid, 'deal_info_sectors', true );
							$launch_year   = get_post_meta( $postid, 'deal_info_launch_year', true );
							$founders      = get_post_meta( $postid, 'deal_info_founders', true );
							$investors     = get_post_meta( $postid, 'deal_info_investors', true );
							$article_title = get_post_meta( $postid, 'deal_info_article_title', true );
							$article_link  = get_post_meta( $postid, 'deal_info_article_link', true );
							?>
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
								<div class="card">
									<div class="card-header">
										<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12"><?php the_post_thumbnail( 'thumbnail' ); ?></div>
										<div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
											<h4 class="card-title">
												<?php the_title(); ?>
											</h4>
											<div class="d-flex justify-content-between align-items-center">
												<label><?php echo esc_html__( 'Sector', 'inc-deals' ); ?> : </label>
												<?php echo esc_html( $sectors ); ?>
											</div>
										</div>
									</div>
									<div class="card-body">
										  <div class="card-text col-lg-12 col-md-12 col-sm-12 col-xs-12">
											  <div class="d-flex justify-content-between align-items-center">
												  <label><?php echo esc_html__( 'Launch', 'inc-deals' ); ?> : </label>
												<?php echo esc_html( $launch_year ); ?>
											  </div>
											  <div class="d-flex justify-content-between align-items-center">
												  <label><?php esc_html_e( 'Founders', 'inc-deals' ); ?> : </label>
												<?php echo esc_html( $founders ); ?>
											  </div>
											  <div class="d-flex justify-content-between align-items-center">
												  <label><?php esc_html_e( 'Investors', 'inc-deals' ); ?> : </label>
												<?php echo esc_html( $investors ); ?>
											  </div>
											  <div class="d-flex justify-content-between align-items-center">
												  <label><?php esc_html_e( 'News', 'inc-deals' ); ?> : </label>
												  <a href="<?php echo esc_url( $article_link ); ?>" target="popup" onclick="window.open( '<?php echo esc_url( $article_link ); ?>','popup','width=600,height=600,scrollbars=no,resizable=no'); return false;" >
													<?php echo esc_html( $article_title ); ?>
												  </a>
											  </div>
										  </div>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
						<?php
						wp_reset_postdata();
					else :
						?>
						<p>
							<?php esc_html_e( 'No Deal found.', 'inc-deals' ); ?>
						</p>
						<?php
					endif;
				}
			}
		}
		die();
	}

}
