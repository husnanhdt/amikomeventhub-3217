{{-- Tampilkan data mahasiswa --}}
<div class="mb-4 p-4 bg-[#fff2f2] dark:bg-[#1D0002] rounded-sm border border-[#e3e3e0] dark:border-[#3E3E3A]">
    <p class="text-sm"><strong>Nama :</strong> {{ $mahasiswa['nama'] }}</p>
    <p class="text-sm"><strong>NIM  :</strong> {{ $mahasiswa['nim'] }}</p>
    <p class="text-sm"><strong>Kelas :</strong> {{ $mahasiswa['kelas'] }}</p>
</div>