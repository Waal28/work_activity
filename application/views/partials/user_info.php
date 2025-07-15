<div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
  <div class="aside-user d-flex align-items-sm-center justify-content-center py-5">
    <div class="symbol symbol-40px border p-3 rounded-circle" style="background-color: rgba(9, 44, 79, 1); border-color: #8fc240 !important;">
      <img src="https://api.iconify.design/solar:user-bold.svg?color=%238fc240" alt="" />
    </div>
    <div class="aside-user-info flex-row-fluid flex-wrap ms-5">
      <div class="d-flex">
        <div class="flex-grow-1 me-2">
          <a href="#" class="text-white text-hover-primary fs-6 fw-bold">
            <?= $this->session->userdata('current_user')['nama'] ?>
          </a>
          <span class="d-flex align-items-center fs-9 mb-2" style="color: #8fc240 !important;">
            <?= $this->session->userdata('role') ?>
          </span>
          <span class="fw-semibold d-block fs-8 mb-1" style="color: rgba(165, 165, 165, 1)"><?= $this->session->userdata('current_user')['nm_unit_kerja'] ?></span>
        </div>
        <div class="me-n2">
          <a href="#" class="btn btn-icon btn-sm mt-n2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
            <i class="ki-duotone ki-setting-2 text-muted fs-1" style="color: #ffff !important">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>
          </a>
          <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
            <div class="menu-item px-3">
              <div class="menu-content d-flex align-items-center px-3">
                <div class="symbol symbol-50px me-5 p-3 rounded-circle" style="background-color: #6b7280">
                  <img alt="Logo" src="https://api.iconify.design/solar:user-bold.svg?color=%23ffffff" />
                </div>
                <div class="d-flex flex-column">
                  <div class="fw-bold d-flex align-items-center fs-5">
                    <?= $this->session->userdata('current_user')['nama'] ?>
                  </div>
                  <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                    <?= $this->session->userdata('current_user')['email'] ?>
                  </a>
                </div>
              </div>
            </div>
            <div class="separator my-2"></div>
            <div class="menu-item px-5">
              <a href="<?= site_url('auth/logout') ?>" class="menu-link px-5">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>