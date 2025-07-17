<div class="modal fade" id="modalTambahRapat" role="dialog" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered mw-650px">
    <div class="modal-content rounded">
      <div class="modal-header pb-0 border-0 justify-content-end">
        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal" onclick="handleClearForm()">
          <i class="ki-duotone ki-cross fs-1">
            <span class="path1"></span>
            <span class="path2"></span>
          </i>
        </div>
      </div>
      <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
        <!-- form pekerjaan -->
        <form id="kt_modal_new_target_form" class="form form_tambah_rapat" action="" method="POST">
          <div class="mb-13 text-center">
            <h1 class="mb-3 form_tambah_rapat_title title-form-data">Tambah Rapat</h1>
          </div>
          <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
              <span class="required">Judul Rapat</span>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="Judul Rapat" name="nama_rapat" form-field="nama_rapat" />
          </div>
          <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
              <span class="required">Tanggal</span>
            </label>
            <input type="date" class="form-control form-control-solid" name="tanggal_rapat" form-field="tanggal_rapat" />
          </div>
          <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
              <span class="required">Waktu Mulai</span>
            </label>
            <input type="time" class="form-control form-control-solid" name="waktu_mulai" form-field="waktu_mulai" />
          </div>
          <div class="d-flex flex-column mb-8 fv-row">
            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
              <span class="required">Waktu Selesai</span>
            </label>
            <input type="time" class="form-control form-control-solid" name="waktu_selesai" form-field="waktu_selesai" />
          </div>
          <div class="d-flex flex-column mb-8 fv-row">
            <label class="required fs-6 fw-semibold mb-2">Peserta Rapat</label>
            <select class="form-select form-select-solid" style="border: 1px solid red;" multiple data-control="select2" data-hide-search="true" data-placeholder="Pilih Pegawai" name="id_pegawai[]" form-field="id_pegawai">
              <?php if (empty($pegawai_list)): ?>
                <option value="">Tidak ada pegawai</option>
              <?php else: ?>
                <?php
                // Kelompokkan data berdasarkan nm_unit_level
                $grouped_pegawai = [];
                foreach ($pegawai_list as $pegawai) {
                  $grouped_pegawai[$pegawai['nm_unit_level']][] = $pegawai;
                }
                ?>
                <?php foreach ($grouped_pegawai as $unit_level => $pegawais): ?>
                  <optgroup label="<?= htmlspecialchars($unit_level); ?>">
                    <?php foreach ($pegawais as $pegawai): ?>
                      <option
                        value="<?= $pegawai['id_pegawai']; ?>">
                        <?= $pegawai['nama'] . ' | ' . $pegawai['nm_unit_kerja']; ?>
                      </option>
                    <?php endforeach; ?>
                  </optgroup>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
          <div class="d-flex flex-column mb-8">
            <label class="required fs-6 fw-semibold mb-2">Metode Pelaksanaan</label>
            <select class="form-select form-select-solid" style="border: 1px solid red;" data-control="select2" data-hide-search="true" data-placeholder="Pilih Jenis Rapat" name="metode_pelaksanaan" form-field="metode_pelaksanaan">
              <option value="Online">Online</option>
              <option value="Offline">Offline</option>
            </select>
          </div>
          <div class="d-flex flex-column mb-8">
            <label class="required fs-6 fw-semibold mb-2">Link Rapat</label>
            <textarea class="form-control form-control-solid" rows="3" name="link_undangan" form-field="link_undangan" placeholder="Jika tidak ada, input '-'"></textarea>
          </div>
          <div class="d-flex flex-column mb-8">
            <label class="required fs-6 fw-semibold mb-2">Tempat Pelaksanaan</label>
            <textarea class="form-control form-control-solid" rows="3" name="tempat_pelaksanaan" form-field="tempat_pelaksanaan" placeholder="Tempat Pelaksanaan"></textarea>
          </div>
          <div class="d-flex flex-column mb-8">
            <label class="required fs-6 fw-semibold mb-2">Deskripsi</label>
            <textarea class="form-control form-control-solid" rows="3" name="deskripsi" form-field="deskripsi" placeholder="Deskripsi"></textarea>
          </div>
          <input type="hidden" name="is_delegasi" form-field="is_delegasi" />
          <div class="d-flex justify-content-end">
            <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3" data-bs-dismiss="modal" onclick="handleClearForm()">Cancel</button>
            <button type="submit" id="kt_modal_new_target_submit" class="btn tombol-tambah" <?= empty($pegawai_list) ? 'disabled' : '' ?>>
              <span class="indicator-label">Submit</span>
              <div class="spinner-border indicator-spinner d-none" style="width: 1rem; height: 1rem;" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </button>
          </div>

          <div id="form-error-alert"></div>
        </form>
        <!-- end form -->
      </div>
    </div>
  </div>
</div>