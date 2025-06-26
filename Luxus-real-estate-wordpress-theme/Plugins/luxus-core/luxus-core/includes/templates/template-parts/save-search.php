
<!-- Save Search -->
<div class="save-search">
    <?php if( !is_user_logged_in() ) {
        echo "<a class='sl-ajax-login'>". esc_html__('Save this search?', 'luxus-core') ." <i class='sl-icon  sl-star-t'></i></a>";
    } else {
        echo "<a id='save-searches-submit' data-bs-toggle='modal' data-bs-target='#saveSearchesModel'>". esc_html__('Save this search?', 'luxus-core') ." <i class='sl-icon  sl-star-t'></i></a>";
    } ?>
</div>

<!-- Save Search Model -->
<div class="modal fade" id="saveSearchesModel" tabindex="-1" aria-labelledby="<?php esc_attr_e('Save Search:', 'luxus-core'); ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="saveSearchesModelLabel"><?php esc_html_e('Name your search:', 'luxus-core'); ?></h5>
        <span type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'luxus-core'); ?>"></span>
      </div>
      <div class="modal-body">
        <form class="name-your-search" method="post">
          <div class="form-group">
            <div class="err_msg"></div>
            <input type="text" class="form-control" id="search_name" name="search_name" placeholder="<?php esc_attr_e('Eg. Best Duplex in New York.', 'luxus-core'); ?>" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e('Close', 'luxus-core'); ?></button>
        <button type="button" id="save-search" class="btn btn-primary"><?php esc_html_e('Save Search', 'luxus-core'); ?></button>
      </div>
    </div>
  </div>
</div>
