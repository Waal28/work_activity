<style>
  .badge-status {
    font-size: 0.75rem;
    padding: 0.4em 0.6em;
  }

  .card-title {
    font-weight: 600;
    font-size: 1rem;
  }

  .progress-slider {
    width: 100%;
    height: 8px;
    border-radius: 5px;
    background: #dee2e6;
    outline: none;
    appearance: none;
  }

  .progress-slider::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d6efd;
    cursor: pointer;
  }

  .progress-slider::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d6efd;
    cursor: pointer;
    border: none;
  }
</style>

<div class="container">
  <div class="row mb-5">
    <?php if (!empty($rows)): ?>
      <?php foreach ($rows as $index => $row): ?>
        <div class="col-lg-4" style="padding: 10px;">
          <?php
          $jenis = $row['jenis_pekerjaan'];
          $colorJenis = match ($jenis) {
            'KPI' => '#6f42c1',
            'Non KPI' => '#fd7e14',
            default => '#fd7e14',
          };
          ?>
          <div class="card rounded-3" style="border: 2px solid #dcdcdc; border-top: 4px solid  <?= $colorJenis ?>;">
            <div class="card-body">
              <div class="row mb-5">
                <div class="col-9">
                  <h5 class="card-title mb-3"><?= htmlspecialchars($row['judul']) ?></h5>
                </div>
                <div class="col-3 text-end">
                  <span class="badge badge-status text-light" style="background-color: <?= $colorJenis ?>">
                    <?= htmlspecialchars($row['jenis_pekerjaan']) ?>
                  </span>
                </div>
              </div>
              <div class="mb-2">
                <strong class="me-3">
                  <img src="https://api.iconify.design/ic:baseline-priority-high.svg?color=%23000" alt="...">
                  Prioritas:
                </strong>
                <?php
                $prioritas = strtolower($row['prioritas']);
                $colorPrioritas = match ($prioritas) {
                  'low' => '#4CAF50',
                  'medium' => '#FF9800',
                  'high' => '#F44336',
                  default => '#000',
                };
                ?>
                <span class="badge bg-light" style="color: <?= $colorPrioritas ?>; border: 1px solid <?= $colorPrioritas ?>;">
                  <?= htmlspecialchars($row['prioritas']) ?>
                </span>
              </div>

              <div class="mb-2">
                <strong class="me-3">
                  <img src="https://api.iconify.design/uil:calender.svg?color=%23000" alt="...">
                  Deadline:
                </strong>
                <span class="">
                  <?= !empty($row['deadline']) ? formatTanggalIndo($row['deadline']) : '-' ?>
                </span>
              </div>

              <div class="mb-2">
                <strong>
                  <img src="https://api.iconify.design/mdi:progress-clock.svg?color=%23000" alt="...">
                  Status:
                </strong>
                <?php
                $status = strtolower($row['status']);
                $classStatus = match ($status) {
                  'in progress' => 'badge-light-primary',
                  'done' => 'badge-light-success',
                  'pending' => 'badge-light-warning',
                  default => 'badge-light-secondary',
                };
                ?>
                <span class="badge <?= $classStatus ?> fs-7 fw-bold">
                  <?= htmlspecialchars($row['status']) ?>
                </span>
              </div>

              <div class="mb-2">
                <strong class="me-3">
                  <img src="https://api.iconify.design/uil:calender.svg?color=%23000" alt="...">
                  Progress:
                </strong>
                <?php if (!empty($row['progress'])) : ?>
                  <span class="fw-bold text-primary"><?= $row['progress'] ?></span>%
                <?php else : ?>
                  <span>-</span>
                <?php endif; ?>
              </div>

              <?php if (isset($row['nama_pegawai']) && is_array($row['nama_pegawai']) && count($row['nama_pegawai']) > 1): ?>
                <div class="mb-2">
                  <strong class="me-3">
                    <img src="https://api.iconify.design/uil:calender.svg?color=%23000" alt="...">
                    Tim:
                  </strong>
                  <span class="">
                    <?= !empty($row['nama_pegawai']) ? implode(', ', $row['nama_pegawai']) : '-' ?>
                  </span>
                </div>
              <?php endif; ?>
            </div>

            <div class="card-footer bg-white d-flex justify-content-between align-items-center border-top">
              <button
                type="button"
                class="btn btn-secondary btn-sm rounded-pill"
                style="background-color: #dcdcdc"
                data-bs-toggle="modal"
                data-bs-target="#modalDetailPekerjaan"
                onclick='showJobDetail(<?= json_encode($row) ?>)'>
                Detail
              </button>
              <div class="d-flex align-items-center fw-bold" style="color: #6b7280">
                <img src="https://api.iconify.design/material-symbols:person-rounded.svg?color=%236b7280" alt="..." style="margin-right: 5px">
                <?= htmlspecialchars($row['pemberi']) ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="d-flex flex-column align-items-center">
        <img src="https://api.iconify.design/line-md:coffee-half-empty-filled-loop.svg?color=%23000" alt="..." style="width: 100px; height: 100px">
        <h3 class="mt-3">Belum ada pekerjaan</h3>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDetailPekerjaan" tabindex="-1" aria-labelledby="modalDetailPekerjaanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <?php
    $path = [
      'Pekerjaan Saya'    => 'pekerjaansaya',
      'Pekerjaan Tim'     => 'pekerjaantim',
      'Pekerjaan Selesai' => 'pekerjaanselesai',
    ]
    ?>
    <form class="modal-content" id="formDetailPekerjaan" method="post" action="<?= base_url($path[$page_title] . '/updateStatus') ?>">
      <div class="modal-header">
        <h4 class="modal-title pb-4" style="border-bottom: 3px solid #007BFF" id="modalDetailPekerjaanLabel">Detail Pekerjaan</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="pekerjaan_id" id="pekerjaan_id">

        <!-- Job Details -->
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Nama Pekerjaan</span></div>
          <div class="col-8">: <span id="detail_judul"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Deskripsi</span></div>
          <div class="col-8">: <span id="detail_deskripsi"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Prioritas</span></div>
          <div class="col-8">: <span id="detail_prioritas" class="fw-bold"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Jenis Pekerjaan</span></div>
          <div class="col-8">: <span id="detail_jenis_pekerjaan"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Deadline</span></div>
          <div class="col-8">: <span id="detail_deadline"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Pemberi Pekerjaan</span></div>
          <div class="col-8">: <span id="detail_pemberi"></span></div>
        </div>

        <!-- Status Select -->
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Status</span></div>
          <div class="col-8">
            : <select class="form-select form-select-sm" name="status" id="status_select" style="width: max-content; display: inline-block;">
              <option value="To Do">To Do</option>
              <option value="In Progress">In Progress</option>
              <option value="Pending">Pending</option>
              <option value="Done">Done</option>
            </select>
          </div>
        </div>

        <!-- Progress Slider -->
        <div class="text-center mt-4">
          <div class="mb-3">
            <span class="fs-6 fw-semibold">Progress: </span>
            <span id="progress_label" class="fw-bold text-primary">0</span>%
          </div>
          <input
            type="range"
            class="progress-slider"
            min="0"
            max="100"
            value="0"
            id="progress_slider"
            name="progress">
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Utility Functions
  const formatTanggalIndo = (tanggalString) => {
    if (!tanggalString) return "-";

    const bulanIndo = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const tanggal = new Date(tanggalString);
    if (isNaN(tanggal)) return tanggalString;

    const hari = tanggal.getDate();
    const bulan = bulanIndo[tanggal.getMonth()];
    const tahun = tanggal.getFullYear();

    return `${hari} ${bulan} ${tahun}`;
  };

  const getPriorityColor = (priority) => {
    const colors = {
      'Low': '#4CAF50',
      'Medium': '#FF9800',
      'High': '#F44336'
    };
    return colors[priority] || '#000';
  };

  const getStatusColor = (status) => {
    const colors = {
      'To Do': '#6c757d',
      'In Progress': '#007BFF',
      'Pending': '#FFC107',
      'Done': '#28A745'
    };
    return colors[status] || '#000';
  };

  const updateProgressSlider = (slider) => {
    const percent = ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
    slider.style.background = `linear-gradient(to right, #0d6efd ${percent}%, #dee2e6 ${percent}%)`;
  };

  // Main Function to Show Job Detail
  const showJobDetail = (data) => {
    if (!data || typeof data !== 'object') {
      console.error('Invalid job data');
      return;
    }

    // Populate form fields
    const fields = {
      'pekerjaan_id': data.pekerjaan_id || '',
      'detail_judul': data.judul || '-',
      'detail_deskripsi': data.deskripsi || '-',
      'detail_jenis_pekerjaan': data.jenis_pekerjaan || '-',
      'detail_deadline': formatTanggalIndo(data.deadline),
      'detail_pemberi': data.pemberi || '-'
    };

    // Set basic fields
    Object.entries(fields).forEach(([id, value]) => {
      const element = document.getElementById(id);
      if (element) {
        if (element.tagName === 'INPUT') {
          element.value = value;
        } else {
          element.textContent = value;
        }
      }
    });

    // Set priority with color
    const prioritasElement = document.getElementById('detail_prioritas');
    if (prioritasElement && data.prioritas) {
      prioritasElement.textContent = data.prioritas;
      prioritasElement.style.color = getPriorityColor(data.prioritas);
    }

    // Set status
    const statusSelect = document.getElementById('status_select');
    if (statusSelect && data.status) {
      statusSelect.value = data.status;
      statusSelect.style.color = getStatusColor(data.status);
    }

    // Set progress - FIXED: Ensure progress value is properly handled
    const progressSlider = document.getElementById('progress_slider');
    const progressLabel = document.getElementById('progress_label');

    if (progressSlider && progressLabel) {
      // Convert progress to number and handle potential undefined/null values
      const progressValue = data.progress ? parseInt(data.progress) : 0;

      progressSlider.value = progressValue;
      progressLabel.textContent = progressValue;
      updateProgressSlider(progressSlider);
    }
  };

  // Event Listeners
  document.addEventListener('DOMContentLoaded', function() {
    const progressSlider = document.getElementById('progress_slider');
    const progressLabel = document.getElementById('progress_label');
    const statusSelect = document.getElementById('status_select');

    // Progress slider event
    if (progressSlider && progressLabel) {
      progressSlider.addEventListener('input', function() {
        progressLabel.textContent = this.value;
        updateProgressSlider(this);
      });

      // Initial update
      updateProgressSlider(progressSlider);
    }

    // Status select color change
    if (statusSelect) {
      statusSelect.addEventListener('change', function() {
        this.style.color = getStatusColor(this.value);
      });
    }
  });
</script>