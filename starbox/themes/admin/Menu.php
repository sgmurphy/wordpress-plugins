<?php defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' ); ?>
<div id="abh_settings">
    <form id="abh_settings_form" name="settings" action="" method="post" enctype="multipart/form-data">
        <div id="abh_settings_title"><?php echo esc_html__( 'StarBox Settings', _ABH_PLUGIN_NAME_ ); ?></div>

        <div style="display:flex;margin-top:2vw;margin-left:10px;background-image:radial-gradient(at 59% 100%, hsla(180,100%,10%,1) 0px, transparent 50%),radial-gradient(at 0% 42%, hsla(180,100%,11%,1) 0px, transparent 50%),
                    radial-gradient(at 100% 4%, hsla(180,100%,17%,1) 0px, transparent 50%);background-color:hsla(180,0%,0%,1);
                    width:83.4vw;height:7vw;">
            <img style="width:45vw;margin-top:-0.8vw;height:7vw;margin-left:0.8vw;" src="<?php echo esc_url( _ABH_THEME_URL_ . '/img/promo.gif' ) ?>" alt="">
            <div>
                <div style="color:white;width:18vw;align-items: flex-start;margin-left:30px;flex-direction:column;">
                    <div style="font-weight:400;color:#FFFFFF;font-size:0.85vw;margin-top:15px;">Premium WordPress
                        Plugin
                    </div>
                    <div style="red;width:10vw;font-weight:bold;line-height:20px;color:#FFFFFF;font-size:0.9vw;margin-top:15px;letter-spacing:2px;display:flex;text-align: left;flex-wrap:wrap;">
                        DARE TO BE DIFFERENT.
                    </div>
                </div>

            </div>
            <a class="discover-pro" style="color:#333333;background-color:#FBCC34;text-decoration:none;text-align:left;padding:7px;border-radius:5px;height:25px;margin-top:35px;margin-left:-20px;" href="https://starbox.squirrly.co/" target="_blank">
                <span style="text-decoration:none;font-weight:800;font-size:1.1vw;position:relative;top:5px;">Discover Starbox PRO</span>
            </a>
        </div>

        <div id="abh_settings_body">
            <div id="abh_settings_left">

                <fieldset>
                    <div class="abh_option_content">
                        <div class="abh_title"><?php echo esc_html__( 'Visibility settings', _ABH_PLUGIN_NAME_ ); ?>:
                        </div>

                        <div class="abh_switch">
                            <input id="abh_inposts_on" type="radio" class="abh_switch-input" name="abh_inposts" value="1" <?php echo( ( ABH_Classes_Tools::getOption( 'abh_inposts' ) == 1 ) ? "checked" : '' ) ?> />
                            <label for="abh_inposts_on" class="abh_switch-label abh_switch-label-off"><?php echo esc_html__( 'Yes', _ABH_PLUGIN_NAME_ ); ?></label>
                            <input id="abh_inposts_off" type="radio" class="abh_switch-input" name="abh_inposts" value="0" <?php echo( ( ! ABH_Classes_Tools::getOption( 'abh_inposts' ) ) ? "checked" : '' ) ?> />
                            <label for="abh_inposts_off" class="abh_switch-label abh_switch-label-on"><?php echo esc_html__( 'No', _ABH_PLUGIN_NAME_ ); ?></label>
                            <span class="abh_switch-selection"></span>
                        </div>
                        <span><?php echo sprintf( esc_html__( 'Visible in %s posts %s', _ABH_PLUGIN_NAME_ ), '<strong>', '</strong>' ); ?></span>
                        <div class="abh_option_strictposts">
                            <input name="abh_strictposts" type="checkbox" value="1" <?php echo( ( ABH_Classes_Tools::getOption( 'abh_strictposts' ) == 1 ) ? "checked" : '' ) ?> />
                            <label for="abh_strictposts" style="position:relative;top:3px;"><?php echo esc_html__( 'Hide Author Box from custom posts types', _ABH_PLUGIN_NAME_ ); ?></label>
                        </div>

                    </div>

                    <div class="abh_option_content">
                        <div class="abh_switch">
                            <input id="abh_inpages_on" type="radio" class="abh_switch-input" name="abh_inpages" value="1" <?php echo( ( ABH_Classes_Tools::getOption( 'abh_inpages' ) == 1 ) ? "checked" : '' ) ?> />
                            <label for="abh_inpages_on" class="abh_switch-label abh_switch-label-off"><?php echo esc_html__( 'Yes', _ABH_PLUGIN_NAME_ ); ?></label>
                            <input id="abh_inpages_off" type="radio" class="abh_switch-input" name="abh_inpages" value="0" <?php echo( ( ! ABH_Classes_Tools::getOption( 'abh_inpages' ) ) ? "checked" : '' ) ?> />
                            <label for="abh_inpages_off" class="abh_switch-label abh_switch-label-on"><?php echo esc_html__( 'No', _ABH_PLUGIN_NAME_ ); ?></label>
                            <span class="abh_switch-selection"></span>
                        </div>
                        <span><?php echo sprintf( esc_html__( 'Visible in %s pages %s', _ABH_PLUGIN_NAME_ ), '<strong>', '</strong>' ); ?></span>
                    </div>

                    <div class="abh_option_content">
                        <div class="abh_switch">
                            <input id="abh_ineachpost_on" type="radio" class="abh_switch-input" name="abh_ineachpost" value="1" <?php echo( ( ABH_Classes_Tools::getOption( 'abh_ineachpost' ) == 1 ) ? "checked" : '' ) ?> />
                            <label for="abh_ineachpost_on" class="abh_switch-label abh_switch-label-off"><?php echo esc_html__( 'Yes', _ABH_PLUGIN_NAME_ ); ?></label>
                            <input id="abh_ineachpost_off" type="radio" class="abh_switch-input" name="abh_ineachpost" value="0" <?php echo( ( ! ABH_Classes_Tools::getOption( 'abh_ineachpost' ) ) ? "checked" : '' ) ?> />
                            <label for="abh_ineachpost_off" class="abh_switch-label abh_switch-label-on"><?php echo esc_html__( 'No', _ABH_PLUGIN_NAME_ ); ?></label>
                            <span class="abh_switch-selection"></span>
                        </div>
                        <span><?php echo sprintf( esc_html__( 'Show the Starbox with Top Star theme %s in the global feed of your blog %s (e.g. "/blog" page) under each title of every post', _ABH_PLUGIN_NAME_ ), '<strong>', '</strong>' ); ?></span>
                    </div>

                    <div class="abh_option_content">
                        <div class="abh_switch">
                            <input id="abh_showopengraph_on" type="radio" class="abh_switch-input" name="abh_showopengraph" value="1" <?php echo( ( ABH_Classes_Tools::getOption( 'abh_showopengraph' ) == 1 ) ? "checked" : '' ) ?> />
                            <label for="abh_showopengraph_on" class="abh_switch-label abh_switch-label-off"><?php echo esc_html__( 'Yes', _ABH_PLUGIN_NAME_ ); ?></label>
                            <input id="abh_showopengraph_off" type="radio" class="abh_switch-input" name="abh_showopengraph" value="0" <?php echo( ( ! ABH_Classes_Tools::getOption( 'abh_showopengraph' ) ) ? "checked" : '' ) ?> />
                            <label for="abh_showopengraph_off" class="abh_switch-label abh_switch-label-on"><?php echo esc_html__( 'No', _ABH_PLUGIN_NAME_ ); ?></label>
                            <span class="abh_switch-selection"></span>
                        </div>
                        <span><?php echo sprintf( esc_html__( 'Show the %s Open Graph %s Profile in meta for each author %s details %s (useful for rich snippets)', _ABH_PLUGIN_NAME_ ), '<strong>', '</strong>', '<a href="http://ogp.me/#type_profile" target="_blank">', '</a>' ); ?></span>
                    </div>
                </fieldset>
                <fieldset>

                    <div class="abh_option_content">
                        <div class="abh_title"><?php echo esc_html__( 'Theme settings', _ABH_PLUGIN_NAME_ ); ?>:</div>

                        <div class="abh_select">
                            <select name="abh_position">
                                <option value="up" <?php echo( ( ABH_Classes_Tools::getOption( 'abh_position' ) == 'up' ) ? 'selected="selected"' : '' ) ?>>
                                    Up
                                </option>
                                <option value="down" <?php echo( ( ABH_Classes_Tools::getOption( 'abh_position' ) == 'down' ) ? 'selected="selected"' : '' ) ?>>
                                    Down
                                </option>
                            </select>
                        </div>
                        <span><?php echo sprintf( esc_html__( 'The Author Box %s position %s (Topstar and Topstar-round are always on shown on top)', _ABH_PLUGIN_NAME_ ), '<strong>', '</strong>'); ?></span>
                    </div>

                    <div class="abh_option_content">
                        <div class="abh_select">
                            <select id="abh_theme_select" name="abh_theme">
								<?php
								foreach ( ABH_Classes_Tools::getOption( 'abh_themes' ) as $name ) {
									echo '<option value="' . esc_attr( $name ) . '" ' . ( ( ABH_Classes_Tools::getOption( 'abh_theme' ) == $name ) ? 'selected="selected"' : '' ) . ' >' . esc_html( ucfirst( $name ) ) . '</option>';
								}
								?>
                            </select>
                        </div>
                        <span><?php echo sprintf( esc_html__( 'Choose the default theme to be displayed %s inside each blog article %s', _ABH_PLUGIN_NAME_ ), '<strong>', '</strong>'); ?></span>
                    </div>

                    <div class="abh_option_content">
                        <div class="abh_select">
                            <select id="abh_titlefontsize_select" name="abh_titlefontsize">
								<?php
								foreach ( ABH_Classes_Tools::getOption( 'abh_titlefontsizes' ) as $name ) {
									echo '<option value="' . esc_attr( $name ) . '" ' . ( ( ABH_Classes_Tools::getOption( 'abh_titlefontsize' ) == $name ) ? 'selected="selected"' : '' ) . ' >' . esc_html( $name ) . '</option>';
								}
								?>
                            </select>
                        </div>
                        <span><?php echo esc_html__( 'Choose the size of the name', _ABH_PLUGIN_NAME_ ); ?></span>
                    </div>
                    <div class="abh_option_content">
                        <div class="abh_select">
                            <select id="abh_descfontsize_select" name="abh_descfontsize">
								<?php
								foreach ( ABH_Classes_Tools::getOption( 'abh_descfontsizes' ) as $name ) {
									echo '<option value="' . esc_attr( $name ) . '" ' . ( ( ABH_Classes_Tools::getOption( 'abh_descfontsize' ) == $name ) ? 'selected="selected"' : '' ) . ' >' . esc_html( $name ) . '</option>';
								}
								?>
                            </select>
                        </div>
                        <span><?php echo esc_html__( 'Choose the size of the description', _ABH_PLUGIN_NAME_ ); ?></span>
                    </div>


                    <div id="abh_box_preview_title"><?php echo esc_html__( 'Preview mode for the default theme', _ABH_PLUGIN_NAME_ ); ?></div>
                    <div id="abh_box_preview"><?php
						if ( file_exists( _ABH_ALL_THEMES_DIR_ . ABH_Classes_Tools::getOption( 'abh_theme' ) . '/js/frontend.js' ) ) {
							echo '<script type="text/javascript" src="' . esc_url( _ABH_ALL_THEMES_URL_ . ABH_Classes_Tools::getOption( 'abh_theme' ) . '/js/frontend.js?ver=' . ABH_VERSION ) . '"></script>';
						}
						echo '<link rel="stylesheet"  href="' . esc_url( _ABH_ALL_THEMES_URL_ . ABH_Classes_Tools::getOption( 'abh_theme' ) . '/css/frontend.css?ver=' . ABH_VERSION ) . '" type="text/css" media="all" />';
						global $current_user;
						echo ABH_Classes_ObjController::getController( 'ABH_Controllers_Frontend' )->showBox( $current_user->ID );
						?>
                    </div>
                    <input type="text" style="display: none;" value="<?php echo esc_attr( $current_user->ID ) ?>" size="1" id="user_id">
                    <br/><br/>
                    <div class="abh_option_content">
                        <div class="abh_select">
                            <select name="abh_achposttheme">
								<?php
								foreach ( ABH_Classes_Tools::getOption( 'abh_achpostthemes' ) as $name ) {
									echo '<option value="' . esc_attr( $name ) . '" ' . ( ( ABH_Classes_Tools::getOption( 'abh_achposttheme' ) == $name ) ? 'selected="selected"' : '' ) . ' >' . esc_html( ucfirst( $name ) ) . '</option>';
								}
								?>
                            </select>
                        </div>
                        <span><?php echo sprintf( esc_html__( 'Choose the theme to be displayed in your %s global list of posts %s (e.g. /blog)', _ABH_PLUGIN_NAME_ ), '<strong>', '</strong>' ); ?></span>
                    </div>


                    <div>
                        <br/><br/><?php echo sprintf( esc_html__( 'Add Starbox in the post content or widgets with the shortcode %s [starbox] %s or %s [starbox id=USER_ID] %s', _ABH_PLUGIN_NAME_ ), '<strong>', '</strong>', '<strong>', '</strong>' ); ?>
                    </div>
                    <div class="abh_option_content">
                        <div class="abh_switch">
                            <input id="abh_shortcode_on" type="radio" class="abh_switch-input" name="abh_shortcode" value="1" <?php echo( ( ABH_Classes_Tools::getOption( 'abh_shortcode' ) == 1 ) ? "checked" : '' ) ?> />
                            <label for="abh_shortcode_on" class="abh_switch-label abh_switch-label-off"><?php echo esc_html__( 'Yes', _ABH_PLUGIN_NAME_ ); ?></label>
                            <input id="abh_shortcode_off" type="radio" class="abh_switch-input" name="abh_shortcode" value="0" <?php echo( ( ! ABH_Classes_Tools::getOption( 'abh_shortcode' ) ) ? "checked" : '' ) ?> />
                            <label for="abh_shortcode_off" class="abh_switch-label abh_switch-label-on"><?php echo esc_html__( 'No', _ABH_PLUGIN_NAME_ ); ?></label>
                            <span class="abh_switch-selection"></span>
                        </div>
                        <span><?php echo sprintf( esc_html__( 'Check for %s [starbox] %s shortcode in my blog. %sRead more >>%s', _ABH_PLUGIN_NAME_ ), '<strong>', '</strong>', '<a href="http://wordpress.org/plugins/starbox/faq/" target="_blank">', '</a>' ); ?> </span>
                    </div>
                </fieldset>

            </div>
            <div id="abh_settings_submit">
                <p><?php echo esc_html__( 'Click "go to user settings" to setup the author box for each author you have ( including per author Google Authorship)', _ABH_PLUGIN_NAME_ ); ?></p>
				<?php wp_nonce_field( 'abh_settings_update', 'abh_nonce' ); ?>
                <input type="hidden" name="action" value="abh_settings_update"/>
                <input type="submit" class="abh_button" value="<?php echo esc_attr__( 'Save settings', _ABH_PLUGIN_NAME_ ) ?> &raquo;"/>
                <a href="profile.php#abh_settings" class="abh_button"><?php echo esc_html__( 'Go to user settings', _ABH_PLUGIN_NAME_ ) ?></a>
            </div>

            <div>
                <br/><br/><?php echo sprintf( esc_html__( 'Use the Google Tool to check rich snippets %s click here %s', _ABH_PLUGIN_NAME_ ), '<a href="https://www.google.com/webmasters/tools/richsnippets?url=' . esc_url(get_bloginfo( 'url' )) . '" target="_blank">', '</a>' ); ?>
            </div>

        </div>
    </form>
</div>