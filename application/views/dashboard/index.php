<div class="row g-5 g-xl-8">
    <?=
        '<pre>';
        print_r($this->session->userdata());
        '</pre>';
    ?>
    <div class="col-xl-4">
        <a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
            <div class="card-body">
                <i class="ki-duotone ki-basket text-white fs-2x ms-n1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="text-white fw-bold fs-2 mb-2 mt-5">Pekerjaan Berjalan 15</div>
                <div class="fw-semibold text-white">Sedang dikerjakan tim</div>
            </div>
        </a>
    </div>
    <div class="col-xl-4">
        <a href="#" class="card bg-success hoverable card-xl-stretch mb-xl-8">
            <div class="card-body">
                <i class="ki-duotone ki-element-11 text-white fs-2x ms-n1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="text-white fw-bold fs-2 mb-2 mt-5">Pekerjaan Selesai 10</div>
                <div class="fw-semibold text-white">Selesai dikerjakan</div>
            </div>
        </a>
    </div>
    <div class="col-xl-4">
        <a href="#" class="card bg-warning hoverable card-xl-stretch mb-5 mb-xl-8">
            <div class="card-body">
                <i class="ki-duotone ki-chart-simple text-gray-100 fs-2x ms-n1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="text-gray-100 fw-bold fs-2 mb-2 mt-5">Pekerjaan Terlambat 5</div>
                <div class="fw-semibold text-gray-100">Terlambat dikerjakan</div>
            </div>
        </a>
    </div>
</div>
<div class="card mb-5 mb-xl-12">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">Pekerjaan Prioritas</span>
            <span class="text-muted mt-1 fw-semibold fs-7">Prioritas</span>
        </h3>
    </div>
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th class="ps-4 min-w-325px rounded-start">Nama Unit</th>
                        <th class="min-w-125px">Unit</th>
                        <th class="min-w-125px">Deadline</th>
                        <th class="min-w-150px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-start flex-column">
                                    <a href="" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">Audit Keuangan</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">Finance</a>
                        </td>
                        <td>
                            <a href="#" class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">10 Februari 2025</a>
                        </td>
                        <td>
                            <span class="badge badge-light-primary fs-7 fw-bold">In Progress</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-start flex-column">
                                    <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">Evaluasi IT</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">IT</a>
                        </td>
                        <td>
                            <a href="#" class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">15 Februari 2025</a>
                        </td>
                        <td>
                            <span class="badge badge-light-danger fs-7 fw-bold">Overdue</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>