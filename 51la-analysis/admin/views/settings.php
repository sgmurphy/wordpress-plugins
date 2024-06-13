<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php if (isset($_GET['settings-updated'])) {
    $qid = trim(get_option(YAOLA_PRODUCT_ID));
    if ($qid == '') { ?>
        <div id="message" class="notice notice-warning is-dismissible">
            <p><strong><?php _e('您未填写应用ID, 51LA网站统计将无法使用!', YAOLA_PRODUCT); ?></strong></p>
        </div>
    <?php } else { ?>
        <div id="message" class="notice notice-success is-dismissible">
            <p><strong>保存成功，
                    <a href="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' ? 'https://v6.51.la/user/application' : 'https://web.51.la/user/site/index';?>" target="_blank">点此查看数据报表</a>
                </strong></p>
        </div>
    <?php }
} ?>

<div id="business-info-wrap" class="wrap"
     style="width: 710px; font-size: 13px; background: #fff; border: 1px solid #ccc; padding: 15px 20px;">
    <div class="wp-header">
        <a href="https://v6.51.la?cc=YWEGU5" target="_blank"
           style="display: inline-block;width: 100px;height: 50px;">
            <img src="<?php echo plugins_url('../static/logo.svg', __FILE__); ?>"
                 style="width: 100px;"></a>
    </div>
    <form method="post" action="options.php">
        <?php settings_fields(YAOLA_PRODUCT);
        do_settings_sections(YAOLA_PRODUCT_ID); ?>
        <div>
            <p style="color: #333"><b>51LA网站统计 WordPress 版本插件，快速引入到您的网站或博客中，用于统计网站访客、来路、事件分析和搜索引擎蜘蛛分析等，插件直接引入，支持 <a href="https://web.51.la" target="_blank">v5</a> / <a href="https://v6.51.la?cc=YWEGU5" target="_blank">v6</a> 新旧版本网站统计，无需修改主题文件。</b></p>
            <div>
                <a class="info-button" target="_blank" href="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' ? 'https://v6.51.la/user/application' : 'https://web.51.la/user/site/index';?>">查看数据报表</a>
            </div>
            <h3>选择统计版本：<span style="color: #999; font-size: 12px;">(请选择您需要使用的统计版本)</span></h3>
            <input id = 'v5' type="radio" name="<?php echo YAOLA_PRODUCT_VERSION; ?>" value="v5" <?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v5' ? 'checked' : '';?>>
            <label for = 'v5'><img src="<?php echo plugins_url('../static/v5-label.png', __FILE__); ?>" style="width: 300px;"></a></label> &nbsp;
            <input id = 'v6' type="radio" name="<?php echo YAOLA_PRODUCT_VERSION; ?>" value="v6" <?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' ? 'checked' : '';?>>
            <label for = 'v6'><img src="<?php echo plugins_url('../static/v6-label.png', __FILE__); ?>" style="width: 300px;"></label>
            <p style="font-weight:600;">两个统计版本ID互不相同，如切换版本请按步骤修改</p>
            <h3>安装步骤：<span style="color: #999; font-size: 12px;">(如已有账号并创建应用请跳过直接查看第二步)</span></h3>
            <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v5" style="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v5' ? 'display:block;' : 'display:none;';?>">
                <h4>第一步：注册51LA账号</h4>
                <p>前往 <a href="https://web.51.la" target="_blank">51LA网站统计（v5）</a> 注册账号，创建您的网站应用，获取应用ID。</p>
                <h4>第二步：前往 <a href="https://web.51.la/user/site/index" target="_blank" >站点管理页</a> 复制站点ID</h4>
                <p>
                    <img src="<?php echo plugins_url('../static/v5-id.png', __FILE__); ?>" style="width: 300px;"></a>
                </p>
            </div>
            <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v6" style="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' ? 'display:block;' : 'display:none;';?>">
                <h4>第一步：注册51LA账号</h4>
                <p>前往 <a href="https://v6.51.la?cc=YWEGU5" target="_blank">51LA网站统计（v6）</a> 注册账号，创建您的网站应用，获取应用ID。</p>
                <h4>第二步：前往 <a href="https://v6.51.la/user/application" target="_blank" >站点管理页</a> 复制统计掩码ID</h4>
                <p>
                    <img src="<?php echo plugins_url('../static/v6-id.png', __FILE__); ?>" style="width: 350px;"></a>
                </p>
            </div>
            <h4>第三步：添加保存ID</h4>
            <table class="form-table">
                <p class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v5"  style="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v5' ? 'display:block;' : 'display:none;';?>">把复制到的应用 ID 粘贴到下方文本框并保存，提示安装成功后即可使用 51LA 网站统计，不填写不生效。</p>
                <p class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v6"  style="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' ? 'display:block;' : 'display:none;';?>">把复制到的掩码 ID 粘贴到下方文本框并保存，提示安装成功后即可使用 51LA 网站统计，不填写不生效。</p>
                <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v5"  style="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v5' ? 'display:block;' : 'display:none;';?>">
                    <input
                        style="width: 180px; border: 1px solid #ccc; text-align: left; padding: 10px;
                        margin: 10px 0; line-height: 1; height: 40px;"
                        name="<?php echo YAOLA_PRODUCT_ID; ?>"
                        id="<?php echo YAOLA_PRODUCT_ID; ?>"
                        placeholder="请填写您的应用ID"
                        value="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_ID))); ?>"/>
                </div>
                <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v6"  style="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' ? 'display:block;' : 'display:none;';?>">
                    <input
                        style="width: 180px; border: 1px solid #ccc; text-align: left; padding: 10px;
                        margin: 10px 0; line-height: 1; height: 40px;"
                        name="<?php echo YAOLA_PRODUCT_ID; ?>"
                        id="<?php echo YAOLA_PRODUCT_ID; ?>"
                        placeholder="请填写您的掩码ID"
                        value="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_ID))); ?>"/>
                </div>
                <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v6" style="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' ? 'display:block;' : 'display:none;';?>">
                    <h4>代码引入方式：</h4>
                    <input id = 'sync' type="radio" name="<?php echo YAOLA_PRODUCT_IMPORT_TYPE; ?>" value="sync" <?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_IMPORT_TYPE))) == 'sync' ? 'checked' : '';?>>
                    <label for = 'sync'>同步引入</label> &nbsp;
                    <input id = 'async' type="radio" name="<?php echo YAOLA_PRODUCT_IMPORT_TYPE; ?>" value="async" <?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_IMPORT_TYPE))) == 'async' ? 'checked' : '';?>>
                    <label for = 'async'>异步引入</label>
                </div>
                <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v6" style="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' ? 'display:block;' : 'display:none;';?>">
                    <h4>开启事件分析：</h4>
                    <input id = 'event_open' type="radio" name="<?php echo YAOLA_PRODUCT_V6_EVENT; ?>" value="1" <?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_V6_EVENT))) == '1' ? 'checked' : '';?>>
                    <label for = 'event_open'>开启</label> &nbsp;
                    <input id = 'event_close' type="radio" name="<?php echo YAOLA_PRODUCT_V6_EVENT; ?>" value="0" <?php echo (esc_attr(trim(get_option(YAOLA_PRODUCT_V6_EVENT))) == '0' || !esc_attr(trim(get_option(YAOLA_PRODUCT_V6_EVENT)))) ? 'checked' : '';?>>
                    <label for = 'event_close'>关闭</label>
                </div>
                <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v6" style="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' ? 'display:block;' : 'display:none;';?>">
                    <h4>单页面(SPA)统计支持：</h4>
                    <input id = 'spa_open' type="radio" name="<?php echo YAOLA_PRODUCT_V6_SPA; ?>" value="1" <?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_V6_SPA))) == '1' ? 'checked' : '';?>>
                    <label for = 'spa_open'>开启</label> &nbsp;
                    <input id = 'spa_close' type="radio" name="<?php echo YAOLA_PRODUCT_V6_SPA; ?>" value="0" <?php echo (esc_attr(trim(get_option(YAOLA_PRODUCT_V6_SPA))) == '0' || !esc_attr(trim(get_option(YAOLA_PRODUCT_V6_SPA)))) ? 'checked' : '';?>>
                    <label for = 'spa_close'>关闭</label>
                </div>
                <div style="border:1px dashed #999;margin-top:20px;padding:0 20px 20px 20px;background:#eee;">
                    <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v6" style="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' ? 'display:block;' : 'display:none;';?>">
                        <h4><svg t="1660558583842" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2426" width="24" height="24"><path d="M816.49 909H211.21c-1.1 0-2-0.9-2-2v-68.18c0-1.1 0.9-2 2-2h605.28c1.1 0 2 0.9 2 2V907c0 1.1-0.9 2-2 2z" fill="#FFAA22" p-id="2427"></path><path d="M910.24 316.23c-27.11 0-49.1 22.52-49.1 50.31 0 7.28 1.58 14.16 4.3 20.4l-176.13 80.21-147.2-258.57c14.56-8.73 24.46-24.74 24.46-43.28 0-27.79-21.98-50.31-49.1-50.31s-49.1 22.52-49.1 50.31c0 17.99 9.29 33.66 23.15 42.55l-158.16 259.3-176.13-80.21c2.71-6.25 4.3-13.12 4.3-20.4 0-27.78-21.98-50.31-49.1-50.31s-49.1 22.52-49.1 50.31c0 27.78 21.98 50.31 49.1 50.31 3.99 0 7.82-0.62 11.53-1.54l86.65 366.28h601.43l86.65-366.28c3.71 0.92 7.54 1.54 11.53 1.54 27.12 0 49.1-22.52 49.1-50.31 0.01-27.78-21.97-50.31-49.08-50.31z" fill="#FFD68D" p-id="2428"></path></svg> 开启数据集成功能（注意：开启使用前需在 <a href="https://v6.51.la/user/vendors?tab=intro" target="_blank">数据集成产品页</a> 中开通该服务）：</h4>
                        <p>此功能开启后可将数据统计报表页集成到 WordPress 【仪表盘】- <a href="index.php?page=51la-analysis-vendors">【51LA统计数据】</a> 中查看，无需登录网站查看数据。</p>
                        <p style="font-size:12px;color:#999;">密钥加密和解密的算法基于 AES 256 GCM，仅支持 PHP7.1 及以上版本开启使用，请打开 php 的 openssl 扩展支持。</p>
                        <input id = 'vendors_open' type="radio" name="<?php echo YAOLA_PRODUCT_VENDORS; ?>" value="1" <?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS))) == '1' ? 'checked' : '';?>>
                        <label for = 'vendors_open'>开启</label> &nbsp;
                        <input id = 'vendors_close' type="radio" name="<?php echo YAOLA_PRODUCT_VENDORS; ?>" value="0" <?php echo (esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS))) == '0' || !esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS)))) ? 'checked' : '';?>>
                        <label for = 'vendors_close'>关闭</label>
                    </div>
                    <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v6 vendors_options"  style="<?php echo (esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' && esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS))) == '1') ? 'display:block;' : 'display:none;';?>">
                        <h4>系统集成<a href="https://v6.51.la/user/vendors?tab=setup" target="_blank">AccessKey</a>：</h4> 
                        <input
                            style="width: 180px; border: 1px solid #ccc; text-align: left; padding: 10px;
                            line-height: 1; height: 40px;"
                            name="<?php echo YAOLA_PRODUCT_VENDORS_AK; ?>"
                            id="<?php echo YAOLA_PRODUCT_VENDORS_AK; ?>"
                            placeholder="请填写您的AccessKey"
                            value="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS_AK))); ?>"/>
                    </div>
                    <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v6 vendors_options"  style="<?php echo (esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' && esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS))) == '1') ? 'display:block;' : 'display:none;';?>">
                        <h4>系统集成<a href="https://v6.51.la/user/vendors?tab=setup" target="_blank">SecretKey</a>：</h4>
                        <input
                            style="width: 180px; border: 1px solid #ccc; text-align: left; padding: 10px;
                            line-height: 1; height: 40px;"
                            name="<?php echo YAOLA_PRODUCT_VENDORS_SK; ?>"
                            id="<?php echo YAOLA_PRODUCT_VENDORS_SK; ?>"
                            placeholder="请填写您的SecretKey"
                            value="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS_SK))); ?>"/>
                    </div>
                    <div class="<?php echo YAOLA_PRODUCT_VERSION; ?>_v6 vendors_options"  style="<?php echo (esc_attr(trim(get_option(YAOLA_PRODUCT_VERSION))) == 'v6' && esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS))) == '1') ? 'display:block;' : 'display:none;';?>">
                        <h4>系统集成<a href="https://v6.51.la/user/vendors?tab=setup" target="_blank">权限模式ID</a>：</h4>
                        <input
                            style="width: 180px; border: 1px solid #ccc; text-align: left; padding: 10px;
                            line-height: 1; height: 40px;"
                            name="<?php echo YAOLA_PRODUCT_VENDORS_MODULE_ID; ?>"
                            id="<?php echo YAOLA_PRODUCT_VENDORS_MODULE_ID; ?>"
                            placeholder="请填写您的权限模式ID"
                            value="<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS_MODULE_ID))); ?>"/>
                    </div>
                </div>
                <br />
            </table>
        </div>
        <script>
            jQuery('input[type=radio][name=<?php echo YAOLA_PRODUCT_VERSION; ?>]').change(function () {
                var myvalue = jQuery(this).val();
                if (myvalue == 'v5') {
                    jQuery('.<?php echo YAOLA_PRODUCT_VERSION; ?>_v6').hide();
                    jQuery('.<?php echo YAOLA_PRODUCT_VERSION; ?>_' + myvalue).show();
                }
                if (myvalue == 'v6') {
                    jQuery('.<?php echo YAOLA_PRODUCT_VERSION; ?>_v5').hide();
                    jQuery('.<?php echo YAOLA_PRODUCT_VERSION; ?>_' + myvalue).show();
                }
            });
            jQuery('input[type=radio][name=<?php echo YAOLA_PRODUCT_VENDORS; ?>]').change(function () {
                var myvalue = jQuery(this).val();
                if (myvalue == '0') {
                    jQuery('.vendors_options').hide();
                }
                if (myvalue == '1') {
                    jQuery('.vendors_options').show();
                }
            });
        </script>
        <style>
            a.info-button {
                margin: 5px 20px 5px 0;
                cursor: pointer;
                color: #fff;
                background-color: #1690ff;
                border-color: #1690ff;
                display: inline-block;
                font-weight: 400;
                line-height: 1.2;
                text-align: center;
                text-decoration: none;
                vertical-align: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
                padding: 8px 15px;
                font-size: 14px;
                border-radius: .25rem;
            }

            p.submit {
                display: inline-block;
                margin-top: -10px;
            }
        </style>
        <?php submit_button(); ?>
    </form>
    <img src="//ia.51.la/go1?id=21261191&pvFlag=1" style="border:none;height:1px;width:1px;" />
</div>
