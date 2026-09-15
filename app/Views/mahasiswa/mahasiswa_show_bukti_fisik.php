<!-- FOTO BUKTI FISIK MULTI FOTO -->
<section class="side-card physical-proof-card">
    <div class="side-heading">
        <div>
            <h2>Foto Bukti Pengumpulan</h2>
            <p>Bukti penyerahan berkas fisik ke admin jurusan.</p>
        </div>
        <i class="fa-regular fa-images"></i>
    </div>

    <?php
    // Dukungan data baru: buktiFisik[] dari tabel bukti_fisik_permohonan.
    // Fallback data lama: satu file di permohonan.bukti_fisik.
    $buktiFisik = $buktiFisik ?? [];
    if (empty($buktiFisik) && ! empty($permohonan['bukti_fisik'])) {
        $buktiFisik = [
            ['nama_file' => $permohonan['bukti_fisik']],
        ];
    }
    ?>

    <?php if (! empty($buktiFisik)) : ?>
        <div class="physical-proof-gallery">
            <?php foreach ($buktiFisik as $index => $foto) : ?>
                <?php $fotoUrl = base_url('uploads/bukti_fisik/' . $foto['nama_file']); ?>
                <a
                    href="<?= esc($fotoUrl) ?>"
                    target="_blank"
                    class="physical-proof-item"
                    title="Buka foto bukti <?= $index + 1 ?>"
                >
                    <img
                        src="<?= esc($fotoUrl) ?>"
                        alt="Foto bukti <?= $index + 1 ?>"
                        loading="lazy"
                    >
                    <span>Bukti <?= $index + 1 ?></span>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="physical-proof-count">
            <?= count($buktiFisik) ?> foto bukti diunggah
        </div>
    <?php else : ?>
        <div class="evidence-empty">
            <div><i class="fa-regular fa-image"></i></div>
            <strong>Foto belum tersedia</strong>
            <span>Mahasiswa belum mengunggah foto bukti pengumpulan.</span>
        </div>
    <?php endif; ?>
</section>

<style>
.physical-proof-gallery {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
    margin-top: 16px;
}
.physical-proof-item {
    position: relative;
    display: block;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #f8fafc;
    text-decoration: none;
}
.physical-proof-item img {
    display: block;
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
}
.physical-proof-item span {
    display: block;
    padding: 7px 9px;
    font-size: 11px;
    font-weight: 700;
    color: #334155;
    background: #fff;
}
.physical-proof-item:hover img {
    opacity: .88;
}
.physical-proof-count {
    margin-top: 10px;
    font-size: 12px;
    color: #64748b;
}
@media (max-width: 480px) {
    .physical-proof-gallery { grid-template-columns: 1fr; }
}
</style>
