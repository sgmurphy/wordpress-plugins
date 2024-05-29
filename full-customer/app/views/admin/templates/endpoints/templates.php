<?php

use Full\Customer\Elementor\TemplateManager;

$maxVisibleItens = 4;
$index = 0;
?>


<div class="templately-sidebar templately-templates-sidebar">
  <div class="templately-collapse">
    <div class="tc-panel-item ts-single tc-panel-active">
      <div class="tc-panel-header tc-panel-header-active">
        <h4>Filtrar por categoria</h4>
      </div>
      <div class="tc-panel-body tc-content-active">
        <div class="templately-template-types">
          <ul id="full-template-category-filter">
            <?php foreach (TemplateManager::instance()->getCategories() as $index => $category) : ?>
              <li class="<?= $index >= $maxVisibleItens ? 'hidden' : '' ?>">
                <label class="toggle-switch toggle-switch-sm" for="category-<?= $category->id ?>" style="margin-top: .5rem">
                  <input type="checkbox" value="<?= $category->id ?>" class="toggle-switch-input" id="category-<?= $category->id ?>">
                  <span class="toggle-switch-label">
                    <span class="toggle-switch-indicator"></span>
                  </span>
                  <span class="toggle-switch-content">
                    <span style="display: block;"><?= $category->name ?></span>
                  </span>
                </label>
              </li>
            <?php endforeach; ?>
          </ul>
          <?php if ($index >= $maxVisibleItens) : ?>
            <span class="view-more-filters" data-visible_items="<?= $maxVisibleItens ?>">Ver mais</span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="tc-panel-item ts-single tc-panel-active">
      <div class="tc-panel-header tc-panel-header-active">
        <h4>Filtrar por tipo</h4>
      </div>
      <div class="tc-panel-body tc-content-active">
        <div class="templately-template-types">
          <ul id="full-template-type-filter">
            <?php foreach (TemplateManager::instance()->getTypes() as $index => $type) : ?>
              <li class="<?= $index > $maxVisibleItens ? 'hidden' : '' ?>">
                <label class="toggle-switch toggle-switch-sm" for="type-<?= $type->id ?>" style="margin-top: .5rem">
                  <input type="checkbox" value="<?= $type->id ?>" class="toggle-switch-input" id="type-<?= $type->id ?>">
                  <span class="toggle-switch-label">
                    <span class="toggle-switch-indicator"></span>
                  </span>
                  <span class="toggle-switch-content">
                    <span style="display: block;"><?= $type->name ?></span>
                  </span>
                </label>
              </li>
            <?php endforeach; ?>
          </ul>

          <?php if ($index > $maxVisibleItens) : ?>
            <span class="view-more-filters" data-visible_items="<?= $maxVisibleItens ?>">Ver mais</span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="tc-panel-item ts-single tc-panel-active">
      <div class="tc-panel-header tc-panel-header-active">
        <h4>Filtrar por segmento</h4>
      </div>
      <div class="tc-panel-body tc-content-active">
        <div class="templately-template-types">
          <ul id="full-template-segment-filter">
            <?php foreach (TemplateManager::instance()->getSegments() as $index => $type) : ?>
              <li class="<?= $index > $maxVisibleItens ? 'hidden' : '' ?>">
                <label class="toggle-switch toggle-switch-sm" for="type-<?= sanitize_title($type) ?>" style="margin-top: .5rem">
                  <input type="checkbox" value="<?= $type ?>" class="toggle-switch-input" id="type-<?= sanitize_title($type) ?>">
                  <span class="toggle-switch-label">
                    <span class="toggle-switch-indicator"></span>
                  </span>
                  <span class="toggle-switch-content">
                    <span style="display: block;"><?= $type ?></span>
                  </span>
                </label>
              </li>
            <?php endforeach; ?>
          </ul>

          <?php if ($index > $maxVisibleItens) : ?>
            <span class="view-more-filters" data-visible_items="<?= $maxVisibleItens ?>">Ver mais</span>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="templately-contents">

  <div class="templately-contents-header">
    <div class="templately-contents-header-inner">
      <div class="templately-header-title">
        <h3>Todas as Páginas</h3>
      </div>

      <div class="templately-plan-switcher" id="template-searcher">
        <input type="search" placeholder="Digite e aperte enter">
        <button>
          <i class="tio-search"></i>
        </button>
      </div>

      <div class="templately-plan-switcher">
        <button data-plan="" class="components-button active">Todos</button>
        <button data-plan="free" class="components-button">Grátis</button>
        <button data-plan="pro" class="components-button">Premium</button>
      </div>
    </div>
  </div>

  <div class="templately-items" id="response-container" data-page="1" data-type="page">
    <!-- JS -->
  </div>

  <div id="full-templates-loader" style="display: none"></div>

  <ul id="full-templates-pagination" style="display: none">
    <li class="page-item" data-js="previous-page">Página anterior</li>
    <li>Página <span data-js="current-page">1</span> de <span data-js="total-pages">5</span></li>
    <li class="page-item" data-js="next-page">Próxima página</li>
  </ul>

  <div class="templately-my-clouds templately-has-no-items" id="no-items">
    <div class="templately-no-items">
      <div class="templately-no-items-inner">
        <img src="<?php echo esc_url(fullGetImageUrl('sorry.svg')) ?>" alt="" style="max-width: min(10rem, 80%);">
        <h3>Ops, nada encontrado</h3>
      </div>
    </div>
  </div>
</div>

<?php if (isset($templateAsScript)) : ?>
  _SCRIPTS_DIVIDER_
<?php endif; ?>

<script type="text/template" id="tpl-templately-item">
  <div class="templately-item templately-page-item" data-filter="{priceTag}" data-item='{json}'>
    <div class="templately-item-inner">
      <a class="templately-item-image-hover-wrapper " href="<?= fullGetTemplatesUrl('single') ?>&item={id}">
        <div class="templately-item-image-container ">
          <div class="templately-item-image-wrapper thumbnail-0">
            <div class="templately-badge templately-{priceTag}">
              <span>{priceTagLabel}</span>
            </div>
            <img class="templately-item-image" width="100%" src="{thumbnailUrl}" alt="{title}">
          </div>
        </div>
      </a>
      <div class="templately-item-details">
        <a class="templately-title" href="<?= fullGetTemplatesUrl('single') ?>&item={id}" style="font-size: 15px; display: block; margin-bottom: 10px;">
          <h4 style="margin: 0">
            {title}
          </h4>
        </a>
          
        <div class="templately-item-meta">
          {button}
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/template" id="tpl-button-insert-item">
  <button class="templately-button templately-item-meta-single tt-top tb-item-insert" data-js="insert-item" data-item='{json}'>
    <i class="tio-download-to" style="margin-right: 5px;"></i>
    <span>Inserir</span>
  </button>
</script>

<script type="text/template" id="tpl-button-purchase-item">
  <button data-js="buy-item" class="templately-button templately-item-meta-single tt-top tb-item-insert" data-href='{purchaseUrl}'>
    <i class="tio-shopping-icon" style="margin-right: 5px;"></i>
    Comprar
  </button>
</script>