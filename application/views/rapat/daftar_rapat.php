<div class="card mb-5 mb-xl-12">
  <div class="card-body py-3">
    <ul class="nav nav-tabs mb-10" id="myTab" role="tablist" style="border-bottom: 1px solid #dcdcdc">
      <?php
      $tabs = [
        [
          'id' => 'Terjadwal',
          'title' => 'Rapat Terjadwal',
          'icon' => 'https://api.iconify.design/material-symbols:meeting-room-outline.svg?color=%23',
          'url' => site_url('rapat/daftarrapat?status=Terjadwal')
        ],
        [
          'id' => 'Selesai',
          'title' => 'Rapat Selesai',
          'icon' => 'https://api.iconify.design/material-symbols:auto-meeting-room-outline.svg?color=%23',
          'url' => site_url('rapat/daftarrapat?status=Selesai')
        ],
        [
          'id' => 'Dibatalkan',
          'title' => 'Rapat Dibatalkan',
          'icon' => 'https://api.iconify.design/material-symbols:no-meeting-room-outline.svg?color=%23',
          'url' => site_url('rapat/daftarrapat?status=Dibatalkan')
        ]
      ]
      ?>
      <?php foreach ($tabs as $tab): ?>
        <?php
        $borderStyle = $tab_active == $tab['id'] ? '3px solid #0d6efd' : 'none';
        $textColor = $tab_active == $tab['id'] ? '#0d6efd' : '#000';
        $iconColor = $tab_active == $tab['id'] ? '0d6efd' : '000';
        ?>
        <li class="nav-item">
          <a
            class="nav-link fw-bold"
            data-toggle="tab"
            href=<?= $tab['url'] ?>
            role="tab"
            style="border-bottom: <?= $borderStyle ?>; color: <?= $textColor ?>">
            <img src="<?= $tab['icon'] ?><?= $iconColor ?>" alt="...">
            <?= $tab['title'] ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php $this->load->view('partials/cards_rapat.php', ['rows' => $rows]); ?>
  </div>
</div>