// Preview sampul sebelum upload + cek ukuran di sisi klien (validasi asli tetap di server)
const inputSampul = document.getElementById('sampul');
if (inputSampul) {
    inputSampul.addEventListener('change', function () {
        const file = this.files[0];
        const preview = document.getElementById('preview');
        const info = document.getElementById('infoSampul');
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            info.textContent = 'Ukuran file lebih dari 2 MB. Pilih file lain.';
            info.className = 'form-text text-danger';
            this.value = '';
            return;
        }
        info.textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        info.className = 'form-text';
        if (preview) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        }
    });
}

// Konfirmasi sebelum hapus
document.querySelectorAll('form.form-hapus').forEach(function (f) {
    f.addEventListener('submit', function (ev) {
        if (!confirm('Hapus buku "' + f.dataset.judul + '"? Data dan file sampul akan hilang permanen.')) {
            ev.preventDefault();
        }
    });
});
