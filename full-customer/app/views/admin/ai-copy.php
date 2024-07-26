<?php $quota = get_option('full/ai/quota', null) ?>

<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

<div class="full-templates-admin-body">
  <div class="templately-wrapper">
    <div class="templately-header">
      <div class="templately-logo">
        <img src="<?= fullGetImageUrl('logo-novo.png') ?>" alt="Logo FULL">
      </div>
    </div>

    <div class="templately-container templately-pages-container">
      <div class="templately-container-row" id="endpoint-viewport">
        <div class="templately-contents">

          <div class="templately-contents-header" style="flex-direction: column;">
            <div class="templately-contents-header-inner">
              <div class="templately-header-title full-widget-title">
                <h3>FULL.ai</h3>
                <p>
                  Uso de palavras <span data-quota="used"><?= $quota ? $quota->used : '0' ?></span> de <span data-quota="granted"><?= $quota ? $quota->granted : '0' ?></span>
                </p>
              </div>
            </div>
          </div>

          <div class="full-page-content">
            <form method="POST" id="copywrite-generator" class="full-widget-form">
              <?php wp_nonce_field('full/ai/copywrite-generator'); ?>
              <input type="hidden" name="action" value="full/ai/copywrite-generator">

              <h3 style="margin-top: 0">Criar novo blog</h3>

              <h4>Selecione uma fonte</h4>
              <p>Para começar a criar seu blog, vamos primeiro selecionar como você deseja gerar um blog.</p>

              <ul class="segment-menu">
                <li><a href="#model-video"><i class="tio-video-horizontal-outlined"></i> Vídeo</a></li>
                <li><a href="#model-audio"><i class="tio-mic-outlined"></i> Áudio</a></li>
                <li><a href="#model-text"><i class="tio-document-text-outlined"></i> Documento ou texto</a></li>
                <li><a href="#model-url"><i class="tio-link"></i> Link da web</a></li>
              </ul>

              <div class="segment-panel" id="model-video">

                <div class="provider-grid">
                  <?php for ($i = 0; $i < 6; $i++) : ?>
                    <div class="provider-card">
                      <img src="https://placehold.co/600x400" alt="logo">

                      <h4>Título <?= $i ?></h4>
                      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Necessitatibus ex aspernatur, maiores facilis quidem veritatis.</p>

                      <a href="#" class="provider-button">Gerar</a>
                    </div>
                  <?php endfor; ?>
                </div>

              </div>
              <div class="segment-panel" id="model-audio">
                #model-audio
              </div>
              <div class="segment-panel" id="model-text">
                #model-text
              </div>
              <div class="segment-panel" id="model-url">
                #model-url
              </div>


              <br>
              <br>
              <br>
              <br>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<style>
  #copywrite-generator {
    padding: 1em;
  }

  .segment-menu {
    position: relative;
    box-sizing: border-box;
    display: flex;
    flex-wrap: wrap;
    margin: 0px;
    margin-bottom: 30px;
    padding: 4px;
    font-size: 14px;
    font-weight: 400;
    background-color: rgb(248, 250, 253);
    border-radius: 8px;
    max-width: max(60%, 800px);
  }

  .segment-menu li {
    flex: 1;
    margin: 0;
  }

  .segment-menu li a {
    padding: 8px 13px;
    cursor: pointer;
    border-radius: 8px;
    text-decoration: none;
    color: rgb(103, 119, 136);
    line-height: 1;
    display: block;
    text-align: center;
    transition: all 150ms ease;
  }

  .segment-menu li a.active {
    color: rgb(30, 32, 34);
    background-color: rgb(255, 255, 255);
    box-shadow: rgba(140, 152, 164, 0.25) 0px 3px 6px 0px;
  }

  .segment-panel {
    display: none;
  }

  .provider-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
  }

  .provider-card {
    border: .0625rem solid rgba(231, 234, 243, .7);
    border-radius: 12px;
    padding: 20px;
    background: #fff;
    transition: box-shadow 150ms ease;
    cursor: pointer;
  }

  .provider-card:hover {
    box-shadow: 0 .1875rem .75rem rgba(140, 152, 164, .25) !important
  }

  .provider-card img {
    max-width: 100px;
    object-fit: cover;
  }

  .provider-card h4 {
    margin: 10px 0 5px;
  }

  .provider-card p {
    margin-top: 0;
  }

  .provider-button {
    text-decoration: none;
  }
</style>

<script>
  jQuery(function($) {
    const $segments = $('.segment-menu a');
    const $segmentPanels = $('.segment-panel');

    $segments.on('click', function() {
      $segments.removeClass('active');
      $(this).addClass('active');
      $segmentPanels.hide();
      $segmentPanels.filter($(this).attr('href')).show();
    });

    $segments.first().trigger('click');
  });
</script>