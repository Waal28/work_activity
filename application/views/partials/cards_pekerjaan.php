
<style>
  .badge-status {
    font-size: 0.75rem;
    padding: 0.4em 0.6em;
  }
  .progress-bar-custom {
    height: 5px;
    background-color: #dcdcdc;
  }
  .card-title {
    font-weight: 600;
    font-size: 1rem;
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
                  <img src="https://api.iconify.design/uil:calender.svg?color=%23000" alt="..." >
                  Deadline:
                </strong>
                <span class="">
                  <?= !empty($row['deadline']) ? formatTanggalIndo($row['deadline']) : '-' ?>
                </span>
              </div>

              <div class="mb-2">
                <strong>
                  <img src="https://api.iconify.design/mdi:progress-clock.svg?color=%23000" alt="..." >
                  Progress:
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
              <?php
                $halaman_tim = ["Pekerjaan Tim", "Pekerjaan Selesai"];
              ?>
              <?php if (in_array($page_title, $halaman_tim)): ?>
                <div class="mb-2">
                  <strong class="me-3">
                    <img src="https://api.iconify.design/uil:calender.svg?color=%23000" alt="..." >
                    Tim:
                  </strong>
                  <span class="">
                    <?= !empty($row['deadline']) ? implode(', ', $row['nama_pegawai']) : '-' ?>
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
                onclick='handleClickDetailPekerjaan(<?= json_encode($row) ?>)'
              >
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
    <form class="modal-content" id="formDetailPekerjaan" method="post" action=<?= base_url($path[$page_title] . '/updateStatus') ?>>
      <div class="modal-header">
        <h4 class="modal-title pb-4" style="border-bottom: 3px solid #007BFF" id="modalDetailPekerjaanLabel">Detail Pekerjaan</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="pekerjaan_id" style="display: none">
        <div class="row mb-5">
          <div class="col-4">
            <span class="fs-6 fw-semibold">Nama Pekerjaan</span>
          </div>
           <div class="col-8">
            : <span name="judul"></span>
           </div>
        </div>
        <div class="row mb-5">
          <div class="col-4">
            <span class="fs-6 fw-semibold">Deskripsi</span>
          </div>
           <div class="col-8">
            : <span name="deskripsi"></span>
           </div>
        </div>
        <div class="row mb-5">
          <div class="col-4">
            <span class="fs-6 fw-semibold">Prioritas</span>
          </div>
           <div class="col-8">
            : <span name="prioritas" class="fw-bold"></span>
           </div>
        </div>
        <div class="row mb-5">
          <div class="col-4">
            <span class="fs-6 fw-semibold">Jenis Pekerjaan</span>
          </div>
           <div class="col-8">
            : <span name="jenis_pekerjaan"></span>
           </div>
        </div>
        <div class="row mb-5">
          <div class="col-4">
            <span class="fs-6 fw-semibold">Deadline</span>
          </div>
           <div class="col-8">
            : <span name="deadline"></span>
           </div>
        </div>
        <div class="row mb-5">
          <div class="col-4">
            <span class="fs-6 fw-semibold">Pemberi Pekerjaan</span>
          </div>
           <div class="col-8">
            : <span name="pemberi"></span>
           </div>
        </div>
        <div class="row mb-5">
          <div class="col-4 d-flex align-items-center">
            <span class="fs-6 fw-semibold">Status</span>
          </div>
           <div class="col-8 d-flex align-items-center">
            <div>:</div>
            <div name="status-container" style="margin-left: 5px; border-radius: 5px; width: max-content">
              <select
                class="form-select form-select-solid form-select-sm"
                data-control="select2"
                data-hide-search="true"
                data-placeholder="Pilih Status"
                name="status"
              >
                <option value="To Do">To Do</option>
                <option value="In Progress">In Progress</option>
                <option value="Pending">Pending</option>
                <option value="Done">Done</option>
              </select>
            </div>
           </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  function formatTanggalIndo(tanggalString) {
    if (!tanggalString) return "";

    const bulanIndo = [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus",
      "September",
      "Oktober",
      "November",
      "Desember",
    ];

    const tanggal = new Date(tanggalString);
    if (isNaN(tanggal)) return tanggalString; // fallback jika gagal parsing

    const hari = tanggal.getDate();
    const bulan = bulanIndo[tanggal.getMonth()];
    const tahun = tanggal.getFullYear();

    return `${hari} ${bulan} ${tahun}`;
  }

  function handleClickDetailPekerjaan(data) {
    // 1. Validasi input
    if (!data || typeof data !== 'object') {
      console.error('Invalid data provided');
      return;
    }

    // 2. Ambil elemen form
    const form = document.getElementById("formDetailPekerjaan");
    if (!form) {
      console.error('Form not found');
      return;
    }

    // 3. Daftar nama field yang akan diproses
    const fieldNames = [
      "judul", "deskripsi", "jenis_pekerjaan",
      "deadline", "prioritas", "status", "pemberi", "pekerjaan_id"
    ];

    // 4. Fungsi bantu untuk update field
    const updateField = (element, key, value) => {
      const tag = element.tagName;

      if (tag === 'INPUT' || tag === 'SELECT') {
        element.value = value;

        // Select2 handling
        if (element.classList.contains('select2-hidden-accessible')) {
          $(element).val(value).trigger('change');
        }
      } else {
        element.textContent = value;
      }

      // 5. Styling khusus untuk field tertentu
      switch (key) {
        case 'status': {
          const statusColorMap = {
            'In Progress': '#007BFF',
            'Pending': '#FFC107',
            'Done': '#28A745'
          };
          const color = statusColorMap[value] || '#000';
          const container = form.querySelector('[name="status-container"]');

          if (container) {
            container.style.border = `2px solid ${color}`;
          }

          element.style.color = color;
          break;
        }

        case 'prioritas': {
          const colorPrioritasMap = {
            Low: '#4CAF50',
            Medium: '#FF9800',
            High: '#F44336',
          };
          const color = colorPrioritasMap[value] || '#000';
          element.style.color = color;
          break;
        }

        case 'deadline': {
          element.textContent = formatTanggalIndo(value);
          break;
        }
      }
    };

    // 6. Iterasi dan update setiap field
    fieldNames.forEach((key) => {
      const element = form.querySelector(`[name="${key}"]`);
      if (!element) {
        console.warn(`Element for field "${key}" not found`);
        return;
      }

      const value = data[key] ?? '';
      updateField(element, key, value);
    });
  }
</script>