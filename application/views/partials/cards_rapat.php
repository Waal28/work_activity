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

  input.progress-slider:disabled {
    cursor: not-allowed;
    opacity: 0.5;
  }
</style>

<div class="container">
  <div class="row mb-5">
    <?php if (!empty($rows)): ?>
      <?php foreach ($rows as $index => $row): ?>
        <div class="col-lg-4" style="padding: 10px;">
          <?php
          $status = strtolower($row['status']);
          $color_status = match ($status) {
            'terjadwal' => '#6f42c1',
            'selesai' => '#00c851',
            default => '#ff4444',
          };
          ?>
          <div class="card rounded-3" style="border: 2px solid #dcdcdc; border-top: 4px solid  <?= $color_status ?>;">
            <div class="card-body">
              <div class="row mb-5">
                <div class="col-9">
                  <h5 class="card-title mb-3 fw-bold fs-4"><?= htmlspecialchars($row['nama_rapat']) ?></h5>
                </div>
                <div class="col-3 text-end">
                  <span class="badge badge-status text-light" style="background-color: <?= $color_status ?>">
                    <?= htmlspecialchars($row['status']) ?>
                  </span>
                </div>
              </div>
              <div class="mb-2">
                <strong class="me-3">
                  <img src="https://api.iconify.design/uil:calender.svg?color=%23000" alt="...">
                  Tanggal:
                </strong>
                <span class="">
                  <?= !empty($row['tanggal_rapat']) ? formatTanggalIndo($row['tanggal_rapat']) : '-' ?>
                </span>
              </div>
              <div class="mb-2">
                <strong class="me-3">
                  <img src="https://api.iconify.design/icon-park-solid:stopwatch-start.svg?color=%23000" alt="...">
                  Mulai:
                </strong>
                <?php if (!empty($row['waktu_mulai'])) : ?>
                  <span class=""><?= date('H:i', strtotime($row['waktu_mulai'])) . ' WIB' ?></span>
                <?php else : ?>
                  <span>-</span>
                <?php endif; ?>
              </div>
              <div class="mb-2">
                <strong class="me-3">
                  <img src="https://api.iconify.design/icon-park-solid:stopwatch.svg?color=%23000" alt="...">
                  Selesai:
                </strong>
                <?php if (!empty($row['waktu_selesai'])) : ?>
                  <span class=""><?= date('H:i', strtotime($row['waktu_selesai'])) . ' WIB' ?></span>
                <?php else : ?>
                  <span>-</span>
                <?php endif; ?>
              </div>
              <div class="mb-2">
                <strong class="me-3">
                  <img src="https://api.iconify.design/lineicons:google-meet.svg?color=%23000" alt="...">
                  Link Rapat:
                </strong>
                <?php if (!empty($row['link_undangan']) && $row['link_undangan'] !== '-') : ?>
                  <a href="<?= $row['link_undangan'] ?>" target="_blank">Klik disini</a>
                <?php else : ?>
                  <span>-</span>
                <?php endif; ?>
              </div>
              <div class="mb-2">
                <strong class="me-3">
                  <img src="https://api.iconify.design/material-symbols:home-rounded.svg?color=%23000" alt="...">
                  Tempat:
                </strong>
                <?php if (!empty($row['tempat_pelaksanaan'])) : ?>
                  <span class=""><?= htmlspecialchars($row['tempat_pelaksanaan']) ?></span>
                <?php else : ?>
                  <span>-</span>
                <?php endif; ?>
              </div>
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
                <?= htmlspecialchars($row['pemberi_rapat']) ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="d-flex flex-column align-items-center">
        <img src="https://api.iconify.design/line-md:coffee-half-empty-filled-loop.svg?color=%23000" alt="..." style="width: 100px; height: 100px">
        <h3 class="mt-3">Belum ada rapat</h3>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDetailPekerjaan" tabindex="-1" aria-labelledby="modalDetailPekerjaanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <form class="modal-content" id="formDetailPekerjaan" method="post">
      <div class="modal-header">
        <h4 class="modal-title pb-4" style="border-bottom: 3px solid #007BFF" id="modalDetailPekerjaanLabel">Detail Rapat</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="pekerjaan_id" id="pekerjaan_id">

        <!-- Job Details -->
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Judul Rapat</span></div>
          <div class="col-8">: <span id="detail_nama_rapat"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Deskripsi</span></div>
          <div class="col-8">: <span id="detail_deskripsi"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Tanggal Rapat</span></div>
          <div class="col-8">: <span id="detail_tanggal_rapat" class="fw-bold"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Waktu Mulai</span></div>
          <div class="col-8">: <span id="detail_waktu_mulai" class="fw-bold"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Waktu Selesai</span></div>
          <div class="col-8">: <span id="detail_waktu_selesai" class="fw-bold"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Pemberi Rapat</span></div>
          <div class="col-8">: <span id="detail_pemberi_rapat"></span></div>
        </div>
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Status</span></div>
          <div class="col-8">
            : <span class="badge badge-status text-light" id="detail_status"></span>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Link Rapat</span></div>
          <div class="col-8">: <span id="detail_link_undangan"></span></div>
        </div>
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Tempat Pelaksanaan</span></div>
          <div class="col-8">: <span id="detail_tempat_pelaksanaan"></span></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm tombol-tambah" data-bs-dismiss="modal">Tutup</button>
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

  // Main Function to Show Job Detail
  const showJobDetail = (data) => {
    if (!data || typeof data !== 'object') {
      console.error('Invalid job data');
      return;
    }

    // Populate form fields
    const fields = {
      'rapat_id': data.id || '',
      'detail_nama_rapat': data.nama_rapat || '-',
      'detail_deskripsi': data.deskripsi || '-',
      'detail_tanggal_rapat': formatTanggalIndo(data.tanggal_rapat),
      'detail_waktu_mulai': data.waktu_mulai || '-',
      'detail_waktu_selesai': data.waktu_selesai || '-',
      'detail_pemberi_rapat': data.pemberi_rapat || '-',
      'detail_status': data.status || '-',
      'detail_link_undangan': data.link_undangan || '-',
      'detail_tempat_pelaksanaan': data.tempat_pelaksanaan || '-'
    };

    // Set basic fields
    Object.entries(fields).forEach(([id, value]) => {
      const element = document.getElementById(id);
      if (element) {
        if (id === 'detail_waktu_mulai' || id === 'detail_waktu_selesai') {
          const [hours, minutes] = value.split(':');
          element.textContent = `${hours}.${minutes} WIB`;;
        } else if (id === 'detail_status') {
          const status = value.toLowerCase();
          const colorStatus = {
            terjadwal: '#6f42c1',
            selesai: '#00c851',
            dibatalkan: '#ff4444',
          };
          element.style.backgroundColor = colorStatus[status];
          element.textContent = value;
        } else if (id === 'detail_link_undangan') {
          element.innerHTML = value !== '-' ? `<a href="${value}" target="_blank">${value}</a>` : '-';
        } else {
          element.textContent = value;
        }
      }
    });
  };
</script>