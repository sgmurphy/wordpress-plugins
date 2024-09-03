<?php
/**
 * A telmplate frame
 * php version 5.6
 *
 * @category Wordpress-plugin
 * @package  Aruba-HiSpeed-Cache
 * @author   Aruba Developer <hispeedcache.developer@aruba.it>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     none
 */

// phpcs:disable
foreach ( $this->fields['sections']['general'] as $sections_key => $sections ) : ?>

	<?php if ( ! isset( $sections['ids'] ) ) : ?>
		<h2 class="ahsc-title <?php echo esc_html( $sections['class'] ); ?>"><?php echo esc_html( $sections['title'] ); ?></h2>
		<?php continue; ?>
	<?php endif; //phpcs:ignore Squiz.PHP.NonExecutableCode.Unreachable ?>

	<table class="form-table ahsc-table-<?php echo esc_html( $sections_key ); ?> <?php echo esc_html( $sections['class'] ); ?>">
        <thead>
        <tr class="<?php echo esc_html( $sections_key ); ?>">
            <th scope="row">
                <div style="float:left">
		        <?php echo esc_html( $sections['name'] ); ?>
                <label><?php echo ( isset( $sections['legend'] ) ) ? esc_html( $sections['legend'] ) : ''; ?></label>
                </div>
                <div class="chevron chevron-arrow-up"></div>
            </th>
        </tr>
        </thead>
		<tbody>
			<tr class="<?php echo esc_html( $sections_key ); ?>">

				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php echo esc_html( $sections['name'] ); ?></span>
						</legend>
						<?php foreach ( $sections['ids'] as $filedkey ) : ?>
                        <?php
                        if($this->fields[ $filedkey ]['type']==="checkbox"){?>
							<label
							for="<?php echo esc_html( $this->fields[ $filedkey ]['id'] ); ?>" >
                                <label class="switch">
								<input
								type="<?php echo esc_html( $this->fields[ $filedkey ]['type'] ); ?>"
								value="1"
								name="<?php echo esc_html( $this->fields[ $filedkey ]['id'] ); ?>"
								id="<?php echo esc_html( $this->fields[ $filedkey ]['id'] ); ?>"
								<?php echo esc_html( $this->fields[ $filedkey ]['checked'] ); ?>
								/>

                                <span class="slider round"></span>
                                </label>
                                <span style="padding-left: 10px">
								<?php
								// phpcs:disable
								_e( $this->fields[ $filedkey ]['name'] );
								// phpcs:enable
								?>
                                </span>
							</label>
                            <small><?php
                                //phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
								echo ( isset( $this->fields[ $filedkey ]['legend'] ) ) ? esc_html( __( $this->fields[ $filedkey ]['legend'] ,'aruba-hispeed-cache')) : '';
								?></small>
                         <?php }elseif($this->fields[ $filedkey ]['type']==="textarea"){

                               ?>
                                <div id="<?php echo esc_html($this->fields[ $filedkey ]['id']."_contenitor") ?>"  class="<?php echo esc_html( $this->fields[ $filedkey ]['class'] ); ?>" style="padding-top:10px;padding-bottom:10px">
	                                <?php echo $this->fields[ $filedkey ]['name'] ; ?>
                        <label for="<?php echo esc_html( $this->fields[ $filedkey ]['id'] ); ?>">
                            <textarea id="<?php echo esc_html( $this->fields[ $filedkey ]['id'] ); ?>"
                            name="<?php echo esc_html( $this->fields[ $filedkey ]['id'] ); ?>" rows="5" cols="60"><?php
                                if(isset($this->fields[ $filedkey ]['value'])){
                                    foreach($this->fields[ $filedkey ]['value'] as $ahsc_preconnect_domain){
                                        echo esc_url($ahsc_preconnect_domain,array(
		                                        'https'
	                                        ))."\n";
                                    }
                                }

                               // echo trim(esc_html( $this->fields[ $filedkey ]['value'] ));  ?>
                            </textarea>
                        </label>
                            <small><?php
		                        echo ( isset( $this->fields[ $filedkey ]['legend'] ) ) ? __( $this->fields[ $filedkey ]['legend'] ,'aruba-hispeed-cache') : '';

		                        ?></small>
                                </div>
                                <?php
                            }  ?>
						<?php endforeach; ?>
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
<?php endforeach; // phpcs:enable ?>

<?php // phpcs:disable
 foreach ( $this->fields['sections']['cache_warmer'] as $sections_key => $sections ) : ?>

	<?php if ( ! isset( $sections['ids'] ) ) : ?>
		<!--h2 class="ahsc-title <?php echo esc_html( $sections['class'] ); ?>"><?php echo esc_html( $sections['title'] ); ?></h2-->
		<?php continue; ?>
	<?php endif; //phpcs:ignore Squiz.PHP.NonExecutableCode.Unreachable ?>

	<table class="form-table ahsc-table-<?php echo esc_html( $sections_key ); ?> <?php echo esc_html( $sections['class'] ); ?>">
        <thead>
        <tr class="<?php echo esc_html( $sections_key ); ?>">
            <th scope="row">
                <div style="float:left">
		        <?php echo esc_html( $sections['name'] ); ?>
                </div>
                <div class="chevron chevron-arrow-up"></div>
            </th>
        </tr>
        </thead>
		<tbody>
			<tr class="<?php echo esc_html( $sections_key ); ?>">
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php echo esc_html( $sections['name'] ); ?></span>
						</legend>
						<?php foreach ( $sections['ids'] as $filedkey ) : ?>
							<label  for="<?php echo esc_html( $this->fields[ $filedkey ]['id'] ); ?>" >
                                <label class="switch">
								<input
								type="<?php echo esc_html( $this->fields[ $filedkey ]['type'] ); ?>"
								value="1"
								name="<?php echo esc_html( $this->fields[ $filedkey ]['id'] ); ?>"
								id="<?php echo esc_html( $this->fields[ $filedkey ]['id'] ); ?>"
								<?php echo esc_html( $this->fields[ $filedkey ]['checked'] ); ?>
								/>

                                <span class="slider round"></span>
                                </label>
                                <span style="padding-left: 10px">
								<?php

								 _e( $this->fields[ $filedkey ]['name'] );

								?>
                                </span>
							</label>
							<small><?php
                                echo ( isset( $this->fields[ $filedkey ]['legend'] ) ) ? __( $this->fields[ $filedkey ]['legend'] ,'aruba-hispeed-cache') : '';

                                ?></small>
						<?php endforeach;
						// phpcs:enable?>
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
<?php endforeach; ?>