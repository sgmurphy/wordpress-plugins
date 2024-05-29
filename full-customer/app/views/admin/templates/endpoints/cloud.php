<?php $section = filter_input(INPUT_GET, 'section') ? filter_input(INPUT_GET, 'section') : 'cloud'; ?>

<div class="templately-sidebar templately-clouds-sidebar">
  <div class="templately-nav-wrapper templately-clouds-menu templately-nav-sidebar">
    <ul class="">
      <li class="tn-item nav-item-clouds <?= 'cloud' === $section  ? 'nav-item-active' : '' ?>">
        <a href="<?= add_query_arg(['section' => 'cloud']) ?>">
          <i class="tio-cloud-outlined"></i>
          Meu Cloud
        </a>
      </li>
      <li class="tn-item nav-item-clouds">
        <a href="#!" data-js="sync-cloud-template">
          <i class="tio-sync"></i>
          Sincronizar cloud
        </a>
      </li>
    </ul>
  </div>

  <div class="templately-clouds-size">
    <a>
      <p>Status do Cloud</p>
      <p>Operacional</p>
    </a>
  </div>
</div>

<div class="templately-contents">
  <?php require_once FULL_CUSTOMER_APP . '/views/admin/templates/cloud/' . $section . '.php'; ?>
</div>

<?php if (isset($templateAsScript)) : ?>
  _SCRIPTS_DIVIDER_
<?php endif; ?>

<script type="text/template" id="tpl-templately-cloud-item">
  <div class="templately-table-row single-cloud-item" data-item='{json}'>
    <div class="templately-table-column ">
      <div class="templatey-cloud-header">
        <p>
          {title}
        </p>
      </div>
    </div>
    <div class="templately-table-column ">
      <div class="templatey-cloud-header">
        <p>
          {typeLabel}
        </p>
      </div>
    </div>
    <div class="templately-table-column ">
      <p>{formattedDate}</p>
    </div>
    <div class="templately-table-column" style=" display: flex; justify-content: space-between;">
      <button class="cloud-button" title="Inserir template" data-js="insert-item">
        <i class="tio-download-to"></i>
        Inserir
      </button>
      <button class="cloud-button" title="Abrir menu" data-js="toggle-template-dropdown">
        <i class="tio-menu-hamburger"></i>
      </button>

      <div class="cloud-segment">
        <button class="cloud-button" title="Excluir template" data-js="delete-from-cloud">
          <i class="tio-delete-outlined"></i>
          Excluir
        </button>
        <a href="{fileUrl}" class="cloud-button" title="Exportar template" data-js="export-template">
          <i class="tio-download-from-cloud"></i>
          Exportar
        </a>
      </div>
    </div>
  </div>
</script>