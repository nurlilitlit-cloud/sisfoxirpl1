<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SisfoTest extends TestCase
{
    use RefreshDatabase;

    private function kelas(): Kelas
    {
        return Kelas::create([
            'nama_kelas' => 'XI RPL 1', 'tingkat' => 'XI',
            'jurusan' => 'Rekayasa Perangkat Lunak', 'tahun_ajaran' => '2025/2026',
        ]);
    }

    private function siswa(Kelas $kelas, string $nis = '1001'): Siswa
    {
        return Siswa::create([
            'nis' => $nis, 'nama' => 'Budi', 'jenis_kelamin' => 'L', 'kelas_id' => $kelas->id,
        ]);
    }

    private function mapel(int $kkm = 75): Mapel
    {
        return Mapel::create(['kode_mapel' => 'MP-'.$kkm, 'nama_mapel' => 'Basis Data', 'kkm' => $kkm]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
        $this->get('/siswa')->assertRedirect('/login');
    }

    public function test_login_and_logout(): void
    {
        $user = User::factory()->create(['password' => 'password']);

        $this->get('/login')->assertOk()->assertSee('Selamat Datang');
        $this->post('/login', ['email' => $user->email, 'password' => 'password'])->assertRedirect('/');
        $this->assertAuthenticated();
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_all_pages_render(): void
    {
        $this->actingAs(User::factory()->create());
        $kelas = $this->kelas();
        $siswa = $this->siswa($kelas);
        $mapel = $this->mapel();
        $guru = Guru::create(['nip' => '1', 'nama' => 'Ibu Guru', 'jenis_kelamin' => 'P']);
        $nilai = Nilai::create(['siswa_id' => $siswa->id, 'mapel_id' => $mapel->id, 'nilai_akhir' => 80, 'keterangan' => 'Lulus']);

        foreach ([
            '/', '/home',
            '/kelas', '/kelas/create', "/kelas/{$kelas->id}/edit",
            '/siswa', '/siswa/create', "/siswa/{$siswa->id}", "/siswa/{$siswa->id}/edit",
            '/guru', '/guru/create', "/guru/{$guru->id}/edit",
            '/mapel', '/mapel/create', "/mapel/{$mapel->id}/edit",
            '/nilai', '/nilai/create', "/nilai/{$nilai->id}/edit",
        ] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_kelas_crud_and_delete_protection(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/kelas', ['nama_kelas' => 'X TKJ', 'tingkat' => 'X', 'jurusan' => 'TKJ', 'tahun_ajaran' => '2025/2026'])
            ->assertRedirect('/kelas');
        $kelas = Kelas::firstWhere('nama_kelas', 'X TKJ');
        $this->assertNotNull($kelas);

        $this->put("/kelas/{$kelas->id}", ['nama_kelas' => 'X TKJ 2', 'tingkat' => 'X', 'jurusan' => 'TKJ', 'tahun_ajaran' => '2025/2026'])
            ->assertRedirect('/kelas');
        $this->assertSame('X TKJ 2', $kelas->fresh()->nama_kelas);

        $this->siswa($kelas);
        $this->delete("/kelas/{$kelas->id}")->assertSessionHas('error');
        $this->assertDatabaseHas('kelas', ['id' => $kelas->id]);

        $empty = $this->kelas();
        $this->delete("/kelas/{$empty->id}")->assertSessionHas('success');
        $this->assertDatabaseMissing('kelas', ['id' => $empty->id]);
    }

    public function test_siswa_crud_validation(): void
    {
        $this->actingAs(User::factory()->create());
        $kelas = $this->kelas();

        $this->post('/siswa', [])->assertSessionHasErrors(['nis', 'nama', 'jenis_kelamin', 'kelas_id']);

        $this->post('/siswa', ['nis' => '2001', 'nama' => 'Ani', 'jenis_kelamin' => 'P', 'kelas_id' => $kelas->id, 'no_hp' => '0812', 'alamat' => 'Bandung'])
            ->assertRedirect('/siswa');
        $siswa = Siswa::firstWhere('nis', '2001');

        $this->post('/siswa', ['nis' => '2001', 'nama' => 'Dup', 'jenis_kelamin' => 'P', 'kelas_id' => $kelas->id])
            ->assertSessionHasErrors('nis');

        // update dengan NIS sendiri tidak dianggap duplikat
        $this->put("/siswa/{$siswa->id}", ['nis' => '2001', 'nama' => 'Ani Baru', 'jenis_kelamin' => 'P', 'kelas_id' => $kelas->id])
            ->assertRedirect('/siswa');
        $this->assertSame('Ani Baru', $siswa->fresh()->nama);

        $this->delete("/siswa/{$siswa->id}")->assertRedirect('/siswa');
        $this->assertDatabaseMissing('siswas', ['id' => $siswa->id]);
    }

    public function test_guru_and_mapel_crud(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/guru', ['nip' => '99', 'nama' => 'Pak Guru', 'jenis_kelamin' => 'L', 'email' => 'bukan-email'])
            ->assertSessionHasErrors('email');
        $this->post('/guru', ['nip' => '99', 'nama' => 'Pak Guru', 'jenis_kelamin' => 'L', 'email' => 'guru@sekolah.id'])
            ->assertRedirect('/guru');
        $guru = Guru::firstWhere('nip', '99');
        $this->put("/guru/{$guru->id}", ['nip' => '99', 'nama' => 'Pak Guru 2', 'jenis_kelamin' => 'L'])->assertRedirect('/guru');
        $this->assertSame('Pak Guru 2', $guru->fresh()->nama);
        $this->delete("/guru/{$guru->id}")->assertRedirect('/guru');
        $this->assertDatabaseCount('gurus', 0);

        $this->post('/mapel', ['kode_mapel' => 'MP-X', 'nama_mapel' => 'Mapel X', 'kkm' => 101])->assertSessionHasErrors('kkm');
        $this->post('/mapel', ['kode_mapel' => 'MP-X', 'nama_mapel' => 'Mapel X', 'kkm' => 80])->assertRedirect('/mapel');
        $mapel = Mapel::firstWhere('kode_mapel', 'MP-X');
        $this->delete("/mapel/{$mapel->id}")->assertSessionHas('success');
    }

    public function test_nilai_calculation_and_rules(): void
    {
        $this->actingAs(User::factory()->create());
        $siswa = $this->siswa($this->kelas());
        $mapel = $this->mapel(75);

        $this->post('/nilai', ['siswa_id' => $siswa->id, 'mapel_id' => $mapel->id, 'nilai_tugas' => 85, 'nilai_uts' => 80, 'nilai_uas' => 90])
            ->assertRedirect('/nilai');
        $nilai = Nilai::first();
        $this->assertEquals(85.5, $nilai->nilai_akhir);
        $this->assertSame('Lulus', $nilai->keterangan);

        // kombinasi siswa + mapel harus unik
        $this->post('/nilai', ['siswa_id' => $siswa->id, 'mapel_id' => $mapel->id, 'nilai_tugas' => 1, 'nilai_uts' => 1, 'nilai_uas' => 1])
            ->assertSessionHasErrors('siswa_id');
        $this->post('/nilai', ['siswa_id' => $siswa->id, 'mapel_id' => $mapel->id, 'nilai_tugas' => 101, 'nilai_uts' => 1, 'nilai_uas' => 1])
            ->assertSessionHasErrors('nilai_tugas');

        // update -> hitung ulang
        $this->put("/nilai/{$nilai->id}", ['siswa_id' => $siswa->id, 'mapel_id' => $mapel->id, 'nilai_tugas' => 70, 'nilai_uts' => 65, 'nilai_uas' => 70])
            ->assertRedirect('/nilai');
        $nilai->refresh();
        $this->assertEquals(68.5, $nilai->nilai_akhir);
        $this->assertSame('Tidak Lulus', $nilai->keterangan);

        // mengubah KKM memperbarui keterangan
        $this->put("/mapel/{$mapel->id}", ['kode_mapel' => $mapel->kode_mapel, 'nama_mapel' => $mapel->nama_mapel, 'kkm' => 60]);
        $this->assertSame('Lulus', $nilai->fresh()->keterangan);

        // mapel yang sudah punya nilai tidak dapat dihapus
        $this->delete("/mapel/{$mapel->id}")->assertSessionHas('error');

        $this->delete("/nilai/{$nilai->id}")->assertRedirect('/nilai');
        $this->assertDatabaseCount('nilais', 0);
    }
}
