<?php
$pekerjaan = $summary['pekerjaan'];
$community = $summary['community_envelopment'];
$lh_development = $summary['dev_commitment'];
$hsse = $summary['hse_objective'];

$pekerjaan_last_week = $summary_last_week['pekerjaan'];
$community_last_week = $summary_last_week['community_envelopment'];
$lh_development_last_week = $summary_last_week['dev_commitment'];
$hsse_last_week = $summary_last_week['hse_objective'];

$deg_blue = ($metrik['penyelesaian_tugas'] / 100) * 360;
$deg_purple = ($metrik['tepat_waktu'] / 100) * 360;
$deg_small_blue = ($metrik['rata_skor'] / 100) * 360;
$deg_small_gray = ($metrik['rata_progress'] / 100) * 360;

?>
<?=
'<pre>';
print_r($this->session->userdata());
'</pre>';
?>
<style>
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: none;
        height: 100%;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 10px 0;
    }

    .stats-subtitle {
        color: #666;
        font-size: 0.9rem;
        margin: 0;
    }

    .icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .icon-purple {
        background: #8b5cf6;
    }

    .icon-green {
        background: #10b981;
    }

    .icon-orange {
        background: #f59e0b;
    }

    .icon-blue {
        background: #3b82f6;
    }

    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .progress-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
        margin: 0 auto 15px;
    }

    .circle-blue {
        background: conic-gradient(rgba(59, 130, 246, 0.3) 0deg, rgba(59, 130, 246, 0.3) <?= $deg_blue ?>deg, #e5e7eb <?= $deg_blue ?>deg);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .circle-purple {
        background: conic-gradient(rgba(139, 92, 246, 0.3) 0deg, rgba(139, 92, 246, 0.3) <?= $deg_purple ?>deg, #e5e7eb <?= $deg_purple ?>deg);
        color: #8b5cf6;
        border: 1px solid rgba(139, 92, 246, 0.3);
    }

    .circle-small {
        width: 60px;
        height: 60px;
        font-size: 0.9rem;
    }

    .circle-small-blue {
        background: conic-gradient(rgba(59, 130, 246, 0.3) 0deg, rgba(59, 130, 246, 0.3) <?= $deg_small_blue ?>deg, #e5e7eb <?= $deg_small_blue ?>deg);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .circle-small-gray {
        background: conic-gradient(rgba(107, 114, 128, 0.3) 0deg, rgba(107, 114, 128, 0.3) <?= $deg_small_gray ?>deg, #e5e7eb <?= $deg_small_gray ?>deg);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }

    .metric-title {
        font-size: 0.9rem;
        color: #666;
        text-align: center;
        margin-bottom: 5px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 8px;
        color: #6b7280;
    }

    body {
        background-color: #f8fafc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
</style>

<div class="container-fluid px-4 py-4">
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="stats-subtitle">Total Pekerjaan</h6>
                        <div class="stats-number" style="color: #8b5cf6"><?= $pekerjaan['total_pekerjaan'] ?></div>
                        <p class="stats-subtitle mb-0"><?= $pekerjaan['pekerjaan_selesai'] ?> Selesai</p>
                    </div>
                    <div class="icon-wrapper icon-purple">
                        <i class="fas fa-briefcase"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="stats-subtitle">Poin Community</h6>
                        <div class="stats-number text-success"><?= $community['total_point'] ?></div>
                        <p class="stats-subtitle mb-0"><?= $community['aktivitas'] ?> Aktivitas</p>
                    </div>
                    <div class="icon-wrapper icon-green">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="stats-subtitle">LH Development</h6>
                        <div class="stats-number text-warning"><?= $lh_development['total_lh'] ?></div>
                        <p class="stats-subtitle mb-0"><?= $lh_development['aktivitas'] ?> Aktivitas</p>
                    </div>
                    <div class="icon-wrapper icon-orange">
                        <i class="fas fa-code"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="stats-subtitle">Poin HSSE</h6>
                        <div class="stats-number text-primary"><?= $hsse['total_point'] ?></div>
                        <p class="stats-subtitle mb-0"><?= $hsse['aktivitas'] ?> Aktivitas</p>
                    </div>
                    <div class="icon-wrapper icon-blue">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Chart Section -->
        <div class="col-lg-8">
            <div class="chart-container">
                <h6 class="section-title">
                    <i class="fas fa-chart-bar"></i>
                    Tren Aktivitas Bulanan
                </h6>
                <div class="d-flex gap-3 mb-3">
                    <small><span class="badge bg-primary me-2"></span>Pekerjaan</small>
                    <small><span class="badge bg-success me-2"></span>Community</small>
                    <small><span class="badge bg-warning me-2"></span>Development</small>
                    <small><span class="badge bg-info me-2"></span>HSSE</small>
                </div>
                <canvas id="tessssChart" width="400" height="200" style="height: 300px;"></canvas>
            </div>
        </div>

        <!-- Metrics Section -->
        <div class="col-lg-4">
            <div class="chart-container">
                <h6 class="section-title">
                    <i class="fas fa-target"></i>
                    Metrik Kinerja
                </h6>

                <div class="row g-3">
                    <div class="col-6">
                        <div class="progress-circle circle-blue"><?= $metrik['penyelesaian_tugas'] ?>%</div>
                        <div class="metric-title">Penyelesaian Tugas</div>
                    </div>
                    <div class="col-6">
                        <div class="progress-circle circle-purple"><?= $metrik['tepat_waktu'] ?>%</div>
                        <div class="metric-title">Tingkat Tepat Waktu</div>
                    </div>
                    <div class="col-6">
                        <div class="progress-circle circle-small circle-small-blue"><?= $metrik['rata_skor'] ?></div>
                        <div class="metric-title">Rata-rata Skor</div>
                    </div>
                    <div class="col-6">
                        <div class="progress-circle circle-small circle-small-gray"><?= $metrik['rata_progress'] ?>%</div>
                        <div class="metric-title">Rata-rata Progress</div>
                    </div>
                </div>
            </div>

            <!-- Summary Section -->
            <div class="chart-container mt-3">
                <h6 class="section-title">
                    <i class="fas fa-calendar-week"></i>
                    Ringkasan Mingguan
                </h6>
                <div class="text-center">
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted">Tugas Selesai</span>
                        <span class="fw-bold"><?= $pekerjaan_last_week['pekerjaan_selesai'] ?>/<?= $pekerjaan_last_week['total_pekerjaan'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted">Aktivitas</span>
                        <span class="fw-bold text-success"><?= $community_last_week['aktivitas'] + $lh_development_last_week['aktivitas'] + $hsse_last_week['aktivitas'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted">Total Poin</span>
                        <span class="fw-bold text-primary"><?= $community_last_week['total_point'] + $lh_development_last_week['total_lh'] + $hsse_last_week['total_point'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const labels = <?= json_encode($chart_data['labels'] ?? []) ?>;
    const dataPekerjaan = <?= json_encode($chart_data['pekerjaan'] ?? []) ?>;
    const dataCommunity = <?= json_encode($chart_data['community'] ?? []) ?>;
    const dataDevelopment = <?= json_encode($chart_data['development'] ?? []) ?>;
    const dataHsse = <?= json_encode($chart_data['hsse'] ?? []) ?>;
    // Monthly Activity Chart
    const ctx = document.getElementById('tessssChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                    label: 'Pekerjaan',
                    data: dataPekerjaan,
                    backgroundColor: '#8b5cf6',
                    borderRadius: 8,
                },
                {
                    label: 'Community',
                    data: dataCommunity,
                    backgroundColor: '#10b981',
                    borderRadius: 8,
                },
                {
                    label: 'Development',
                    data: dataDevelopment,
                    backgroundColor: '#f59e0b',
                    borderRadius: 8,
                },
                {
                    label: 'HSSE',
                    data: dataHsse,
                    backgroundColor: '#3b82f6',
                    borderRadius: 8,
                }
            ]
        },
        options: {
            responsive: true,
            // maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 3,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        color: '#f1f5f9'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                bar: {
                    borderSkipped: false,
                }
            }
        }
    });
</script>