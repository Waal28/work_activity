<div class="aside-menu flex-column-fluid">
    <div class="hover-scroll-overlay-y mx-3 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">

            <!-- Dashboard -->
            <div class="menu-item">
                <a class="menu-link <?= $content_dir == "dashboard" ? "active" : "" ?>" href="<?= base_url() . 'Dashboard' ?>">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-element-11 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </div>

            <!-- Section: Menu -->
            <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Menu</span>
                </div>
            </div>

            <!-- Pekerjaan -->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-message-text-2 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </span>
                    <span class="menu-title">Pekerjaan</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion <?= $content_dir == "pekerjaan" ? "show" : "" ?>">
                    <div class="menu-item">
                        <a class="menu-link <?= $content_dir == "pekerjaan" && $content_name == "index" ? "active" : "" ?>" href="<?= base_url() . 'Pekerjaan' ?>">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">Pekerjaan Saya</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link <?= $content_dir == "pekerjaan" && $content_name == "pemberian" ? "active" : "" ?>" href="<?= base_url() . 'Pekerjaan/pemberian' ?>">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">Pemberian Pekerjaan</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Monitoring -->
            <div class="menu-item">
                <a class="menu-link <?= $content_dir == "monitoring" ? "active" : "" ?>" href="<?= base_url() . 'Monitoring' ?>">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-calendar-8 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                        </i>
                    </span>
                    <span class="menu-title">Monitoring</span>
                </a>
            </div>

            <!-- OBJECTIVES -->
            <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Objectives</span>
                </div>
            </div>

            <div class="menu-item">
                <a class="menu-link" href="<?= base_url('HSEObjective') ?>">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-shield-tick fs-2">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">HSE Objective</span>
                </a>
            </div>

            <div class="menu-item">
                <a class="menu-link" href="<?= base_url('DevelopmentCommitment') ?>">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-briefcase fs-2">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">Development Commitment</span>
                </a>
            </div>

            <div class="menu-item">
                <a class="menu-link" href="<?= base_url('CommunityEnvelopment') ?>">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-people fs-2">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">Community Envelopment</span>
                </a>
            </div>

            <!-- ASSESSMENT -->
            <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Assessment</span>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="<?= base_url('ABS') ?>">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-check-square fs-2">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">ABS</span>
                </a>
            </div>

            <!-- ANALYTICS -->
            <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Analytics</span>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="<?= base_url('Reports') ?>">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-chart-pie-4 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </span>
                    <span class="menu-title">Reports</span>
                </a>
            </div>


        </div>
    </div>
</div>