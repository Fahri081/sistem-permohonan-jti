<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
Laporan & Statistik - JTI Signature
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<link
    rel="stylesheet"
    href="<?= base_url('assets/css/admin/laporan.css') ?>"
>


<div class="report-page">


    <!-- ==============================================
         HEADER
    =============================================== -->

    <div class="report-header">

        <div>

            <span class="report-eyebrow">
                ANALYTICS & REPORT
            </span>

            <h1>
                Laporan & Statistik
            </h1>

            <p>
                Pantau perkembangan permohonan berdasarkan
                periode dan status.
            </p>

        </div>

    </div>


    <!-- ==============================================
         FILTER
    =============================================== -->

    <form
        method="get"
        action="<?= site_url('admin/laporan') ?>"
        class="report-filter"
    >

        <div class="date-control">

            <i class="fa-regular fa-calendar"></i>

            <div>

                <label>
                    Mulai
                </label>

                <input
                    type="date"
                    name="mulai"
                    value="<?= esc($tanggalMulai) ?>"
                >

            </div>

        </div>


        <div class="date-separator">
            →
        </div>


        <div class="date-control">

            <i class="fa-regular fa-calendar"></i>

            <div>

                <label>
                    Sampai
                </label>

                <input
                    type="date"
                    name="akhir"
                    value="<?= esc($tanggalAkhir) ?>"
                >

            </div>

        </div>


        <button
            type="submit"
            class="report-filter-button"
        >

            <i class="fa-solid fa-filter"></i>

            Terapkan

        </button>


        <a
            href="<?= site_url('admin/laporan') ?>"
            class="report-reset"
        >
            Reset
        </a>

    </form>



    <!-- ==============================================
         SUMMARY
    =============================================== -->

    <div class="report-summary">

        <div class="summary-card">

            <div class="summary-icon blue">

                <i class="fa-regular fa-file-lines"></i>

            </div>

            <div>

                <span>
                    Total Permohonan
                </span>

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon orange">

                <i class="fa-regular fa-clock"></i>

            </div>

            <div>

                <span>
                    Sedang Diproses
                </span>

                <strong>
                    <?= number_format(
                        $status['diproses']
                    ) ?>
                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon green">

                <i class="fa-regular fa-circle-check"></i>

            </div>

            <div>

                <span>
                    Selesai
                </span>

                <strong>
                    <?= number_format(
                        $status['selesai']
                    ) ?>
                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon purple">

                <i class="fa-solid fa-box-archive"></i>

            </div>

            <div>

                <span>
                    Diambil
                </span>

                <strong>
                    <?= number_format(
                        $status['diambil']
                    ) ?>
                </strong>

            </div>

        </div>

    </div>



    <!-- ==============================================
         CHART ROW
    =============================================== -->

    <div class="report-chart-grid">


        <!-- TREND -->

        <section class="report-card trend-card">

            <div class="report-card-header">

                <div>

                    <h2>
                        Tren Permohonan
                    </h2>

                    <p>
                        Jumlah permohonan berdasarkan minggu.
                    </p>

                </div>

                <span class="chart-menu">
                    <i class="fa-solid fa-ellipsis"></i>
                </span>

            </div>


            <div class="trend-chart">

                <?php

                $maxTrend = 1;

                foreach ($tren as $item) {

                    if (
                        (int) $item['total']
                        > $maxTrend
                    ) {

                        $maxTrend =
                            (int) $item['total'];

                    }

                }

                ?>


                <?php if (! empty($tren)) : ?>

                    <div class="bars">

                        <?php foreach ($tren as $item) : ?>

                            <?php

                            $height =
                                ((int) $item['total']
                                / $maxTrend) * 100;

                            ?>

                            <div class="bar-group">

                                <div class="bar-value">

                                    <?= number_format(
                                        $item['total']
                                    ) ?>

                                </div>


                                <div class="bar-track">

                                    <div
                                        class="bar"
                                        style="
                                            height:
                                            <?= max(
                                                5,
                                                $height
                                            ) ?>%;
                                        "
                                    ></div>

                                </div>


                                <span class="bar-label">

                                    <?= esc(
                                        $item['label']
                                    ) ?>

                                </span>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php else : ?>

                    <div class="chart-empty">
                        Belum ada data tren.
                    </div>

                <?php endif; ?>

            </div>

        </section>



        <!-- DISTRIBUSI STATUS -->

        <section class="report-card status-chart-card">

            <div class="report-card-header">

                <div>

                    <h2>
                        Distribusi Status
                    </h2>

                    <p>
                        Komposisi status permohonan.
                    </p>

                </div>

            </div>


            <?php

            $totalStatus =
                array_sum(
                    $status
                );

            $totalStatus =
                max(
                    1,
                    $totalStatus
                );


            $selesaiPercent =
                ($status['selesai']
                / $totalStatus) * 100;

            $diprosesPercent =
                ($status['diproses']
                / $totalStatus) * 100;

            $diajukanPercent =
                ($status['diajukan']
                / $totalStatus) * 100;

            $ditolakPercent =
                ($status['ditolak']
                / $totalStatus) * 100;

            ?>


            <div class="donut-wrapper">

                <div
                    class="donut"
                    style="
                        --p1: <?= $selesaiPercent ?>%;
                        --p2: <?= $selesaiPercent + $diprosesPercent ?>%;
                        --p3: <?= $selesaiPercent + $diprosesPercent + $diajukanPercent ?>%;
                        --p4: <?= $selesaiPercent + $diprosesPercent + $diajukanPercent + $ditolakPercent ?>%;
                    "
                >

                    <div class="donut-center">

                        <strong>
                            <?= number_format(
                                $totalStatus
                            ) ?>
                        </strong>

                        <span>
                            Total
                        </span>

                    </div>

                </div>


                <div class="legend">

                    <div>

                        <span class="legend-dot green"></span>

                        <span>
                            Selesai
                        </span>

                        <strong>
                            <?= round(
                                $selesaiPercent
                            ) ?>%
                        </strong>

                    </div>


                    <div>

                        <span class="legend-dot orange"></span>

                        <span>
                            Diproses
                        </span>

                        <strong>
                            <?= round(
                                $diprosesPercent
                            ) ?>%
                        </strong>

                    </div>


                    <div>

                        <span class="legend-dot blue"></span>

                        <span>
                            Diajukan
                        </span>

                        <strong>
                            <?= round(
                                $diajukanPercent
                            ) ?>%
                        </strong>

                    </div>


                    <div>

                        <span class="legend-dot red"></span>

                        <span>
                            Ditolak
                        </span>

                        <strong>
                            <?= round(
                                $ditolakPercent
                            ) ?>%
                        </strong>

                    </div>

                </div>

            </div>

        </section>

    </div>



    <!-- ==============================================
         BOTTOM GRID
    =============================================== -->

    <div class="report-bottom-grid">


        <!-- VOLUME -->

        <section class="report-card volume-card">

            <div class="report-card-header">

                <div>

                    <h2>
                        Volume per Tujuan
                    </h2>

                    <p>
                        Jumlah permohonan berdasarkan tujuan.
                    </p>

                </div>

            </div>


            <div class="volume-list">

                <?php if (! empty($tujuan)) : ?>

                    <?php

                    $maxTujuan =
                        max(
                            array_column(
                                $tujuan,
                                'total'
                            )
                        );

                    $maxTujuan =
                        max(
                            1,
                            $maxTujuan
                        );

                    ?>


                    <?php foreach ($tujuan as $item) : ?>

                        <?php

                        $width =
                            ((int) $item['total']
                            / $maxTujuan)
                            * 100;

                        ?>

                        <div class="volume-item">

                            <div class="volume-top">

                                <span>
                                    <?= esc(
                                        $item['nama_tujuan']
                                    ) ?>
                                </span>

                                <strong>
                                    <?= number_format(
                                        $item['total']
                                    ) ?>
                                </strong>

                            </div>


                            <div class="volume-track">

                                <div
                                    class="volume-progress"
                                    style="
                                        width:
                                        <?= $width ?>%;
                                    "
                                ></div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else : ?>

                    <div class="chart-empty">
                        Belum ada data tujuan.
                    </div>

                <?php endif; ?>

            </div>

        </section>



        <!-- MONTHLY -->

        <section class="report-card monthly-card">

            <div class="report-card-header">

                <div>

                    <h2>
                        Laporan Bulanan
                    </h2>

                    <p>
                        Ringkasan jumlah permohonan per bulan.
                    </p>

                </div>

                <a
                    href="#"
                    class="see-all"
                >
                    Lihat Semua
                </a>

            </div>


            <?php if (! empty($bulanan)) : ?>

                <div class="monthly-table-wrapper">

                    <table class="monthly-table">

                        <thead>

                            <tr>

                                <th>
                                    Bulan
                                </th>

                                <th>
                                    Total
                                </th>

                                <th>
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php foreach ($bulanan as $item) : ?>

                            <tr>

                                <td>
                                    <?= esc(
                                        $item['bulan']
                                    ) ?>
                                </td>

                                <td>
                                    <?= number_format(
                                        $item['total']
                                    ) ?>
                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="download-row"
                                        title="Ekspor"
                                    >

                                        <i class="fa-solid fa-download"></i>

                                    </button>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else : ?>

                <div class="monthly-empty">

                    <i class="fa-regular fa-calendar-xmark"></i>

                    <p>
                        Belum ada laporan bulanan.
                    </p>

                </div>

            <?php endif; ?>

        </section>

    </div>

</div>

<?= $this->endSection() ?>