<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use League\OAuth2\Client\Provider\Google;

class Auth extends Controller
{
    protected UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
    }

    /**
     * =========================
     * HALAMAN LOGIN
     * =========================
     */
    public function login()
    {
        if (session('logged_in')) {
            if (
                in_array(
                    session('role'),
                    ['admin', 'super_admin'],
                    true
                )
            ) {
                return redirect()->to('/admin');
            }

            return redirect()->to('/mahasiswa');
        }

        return view('auth/login');
    }

    /**
     * =========================
     * HALAMAN REGISTER LOKAL
     * =========================
     */
    public function register()
    {
        if (session('logged_in')) {
            if (
                in_array(
                    session('role'),
                    ['admin', 'super_admin'],
                    true
                )
            ) {
                return redirect()->to('/admin');
            }

            return redirect()->to('/mahasiswa');
        }

        return view('auth/register');
    }

    /**
     * =========================
     * PROSES REGISTER LOKAL
     * =========================
     */
    public function processRegister()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'nim' => 'required|max_length[20]',
            'email' => 'required|valid_email|max_length[100]',
            'no_hp' => 'permit_empty|max_length[15]',
            'password' => 'required|min_length[6]',
            'konfirmasi_password' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $namaLengkap = trim(
            (string) $this->request->getPost('nama_lengkap')
        );

        $nim = trim(
            (string) $this->request->getPost('nim')
        );

        $email = strtolower(
            trim((string) $this->request->getPost('email'))
        );

        $noHp = trim(
            (string) $this->request->getPost('no_hp')
        );

        $password = (string) $this->request->getPost('password');

        // Cek email
        $emailExists = $this->users
            ->where('email', $email)
            ->first();

        if ($emailExists) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Email tersebut sudah digunakan.'
                );
        }

        // Cek NIM
        $nimExists = $this->users
            ->where('nim', $nim)
            ->first();

        if ($nimExists) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'NIM tersebut sudah terdaftar.'
                );
        }

        $userData = [
            'nama_lengkap' => $namaLengkap,
            'email' => $email,
            'no_hp' => $noHp !== '' ? $noHp : null,
            'password' => password_hash(
                $password,
                PASSWORD_DEFAULT
            ),
            'role' => 'mahasiswa',
            'nim' => $nim,
            'foto_profil' => null,
            'id_status_akun' => 1,
            'google_id' => null,
        ];

        $inserted = $this->users->insert($userData);

        if (! $inserted) {
            log_message(
                'error',
                'Register gagal untuk email: {email}',
                [
                    'email' => $email,
                ]
            );

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Pendaftaran akun gagal. Silakan coba lagi.'
                );
        }

        return redirect()
            ->to('/login')
            ->with(
                'success',
                'Akun berhasil dibuat. Silakan login menggunakan email dan password.'
            );
    }

    /**
     * =========================
     * LOGIN / REGISTER GOOGLE
     * =========================
     */
    public function google()
    {
        $provider = new Google([
            'clientId' => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri' => env('GOOGLE_REDIRECT_URI'),
        ]);

        $authorizationUrl = $provider->getAuthorizationUrl();

        session()->set([
            'oauth2state' => $provider->getState(),
        ]);

        return redirect()->to($authorizationUrl);
    }

    /**
     * =========================
     * GOOGLE CALLBACK
     * =========================
     */
    public function googleCallback()
    {
        $provider = new Google([
            'clientId' => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri' => env('GOOGLE_REDIRECT_URI'),
        ]);

        // Google mengembalikan error
        if ($this->request->getGet('error')) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Login dengan akun Polinema dibatalkan.'
                );
        }

        $state = (string) $this->request->getGet('state');
        $savedState = (string) session('oauth2state');

        // Validasi state
        if (
            $state === '' ||
            $savedState === '' ||
            ! hash_equals($savedState, $state)
        ) {
            session()->remove('oauth2state');

            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Sesi login tidak valid. Silakan coba lagi.'
                );
        }

        session()->remove('oauth2state');

        $code = (string) $this->request->getGet('code');

        if ($code === '') {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Kode login dari Google tidak ditemukan.'
                );
        }

        try {
            // Tukarkan authorization code menjadi access token
            $token = $provider->getAccessToken(
                'authorization_code',
                [
                    'code' => $code,
                ]
            );

            $googleUser = $provider->getResourceOwner($token);

            /** @var \League\OAuth2\Client\Provider\GoogleUser $googleUser */
            $googleId = trim(
                (string) $googleUser->getId()
            );

            $email = strtolower(
                trim(
                    (string) $googleUser->getEmail()
                )
            );

            $nama = trim(
                (string) $googleUser->getName()
            );

            // Pastikan data utama tersedia
            if (
                $googleId === '' ||
                $email === ''
            ) {
                return redirect()
                    ->to('/login')
                    ->with(
                        'error',
                        'Data akun Google tidak lengkap.'
                    );
            }

            /*
             * =====================================================
             * CEK EMAIL POLINEMA
             * =====================================================
             *
             * Pengecekan domain sengaja belum diaktifkan untuk
             * pengujian akun OAuth. Setelah akun Polinema resmi
             * digunakan, blok berikut dapat diaktifkan.
             */

            $emailParts = explode('@', $email);

            $domain = isset($emailParts[1])
                ? strtolower(trim($emailParts[1]))
                : '';

            /*
             * Hanya email Polinema yang diperbolehkan.
             */
            if ($domain !== 'polinema.ac.id') {
                return redirect()
                    ->to('/login')
                    ->with(
                        'error',
                        'Silakan gunakan akun email Polinema.'
                    );
            }

            /*
             * =====================================================
             * 1. CARI BERDASARKAN GOOGLE ID
             * =====================================================
             *
             * Untuk login berikutnya.
             */
            $user = $this->users
                ->where('google_id', $googleId)
                ->first();

            if ($user) {
                return $this->loginUser(
                    $user,
                    $nama
                );
            }

            /*
             * =====================================================
             * 2. CARI BERDASARKAN EMAIL
             * =====================================================
             *
             * Untuk akun lokal yang baru pertama kali
             * dihubungkan dengan Google.
             */
            $user = $this->users
                ->where('email', $email)
                ->first();

            if ($user) {

                // Akun tidak aktif
                if (
                    (int) ($user['id_status_akun'] ?? 1) !== 1
                ) {
                    return redirect()
                        ->to('/login')
                        ->with(
                            'error',
                            'Akun kamu sudah tidak aktif. Silakan hubungi administrator.'
                        );
                }

                /*
                 * Akun sudah terhubung ke Google lain.
                 * Jangan menimpa google_id.
                 */
                if (! empty($user['google_id'])) {
                    return redirect()
                        ->to('/login')
                        ->with(
                            'error',
                            'Akun Google tidak sesuai dengan akun yang terdaftar.'
                        );
                }

                /*
                 * Hubungkan Google ID.
                 */
                $updated = $this->users->update(
                    $user['id_user'],
                    [
                        'google_id' => $googleId,
                    ]
                );

                if (! $updated) {
                    return redirect()
                        ->to('/login')
                        ->with(
                            'error',
                            'Akun Google gagal dihubungkan dengan akun sistem.'
                        );
                }

                $user = $this->users
                    ->where('id_user', $user['id_user'])
                    ->first();

                return $this->loginUser(
                    $user,
                    $nama
                );
            }

            /*
             * =====================================================
             * 3. AKUN GOOGLE BELUM ADA DI DATABASE
             * =====================================================
             *
             * Simpan data Google sementara di session.
             * User akan melengkapi NIM dan No. HP.
             */
            session()->set([
                'google_registration' => [
                    'google_id' => $googleId,
                    'email' => $email,
                    'nama' => $nama,
                ],
            ]);

            return redirect()
                ->to('/register/google');

        } catch (\Throwable $e) {
            log_message(
                'error',
                'Google SSO Error: {message}',
                [
                    'message' => $e->getMessage(),
                ]
            );

            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Login dengan akun Polinema gagal. Silakan coba lagi.'
                );
        }
    }

    /**
     * =========================
     * FORM LENGKAPI REGISTER GOOGLE
     * =========================
     */
    public function googleRegister()
    {
        $googleRegistration = session(
            'google_registration'
        );

        if (! is_array($googleRegistration)) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Sesi pendaftaran Google tidak ditemukan. Silakan coba lagi.'
                );
        }

        return view(
            'auth/register_google',
            [
                'googleRegistration' => $googleRegistration,
            ]
        );
    }

    /**
     * =========================
     * PROSES REGISTER GOOGLE
     * =========================
     */
    public function processGoogleRegister()
    {
        $googleRegistration = session(
            'google_registration'
        );

        if (! is_array($googleRegistration)) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Sesi pendaftaran Google tidak ditemukan. Silakan coba lagi.'
                );
        }

        $rules = [
            'nim' => 'required|max_length[20]',
            'no_hp' => 'permit_empty|max_length[15]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $googleId = trim(
            (string) ($googleRegistration['google_id'] ?? '')
        );

        $email = strtolower(
            trim(
                (string) ($googleRegistration['email'] ?? '')
            )
        );

        $nama = trim(
            (string) ($googleRegistration['nama'] ?? '')
        );

        $nim = trim(
            (string) $this->request->getPost('nim')
        );

        $noHp = trim(
            (string) $this->request->getPost('no_hp')
        );

        if (
            $googleId === '' ||
            $email === ''
        ) {
            session()->remove(
                'google_registration'
            );

            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Data Google tidak lengkap. Silakan coba lagi.'
                );
        }

        /*
         * Cegah akun ganda jika email ternyata sudah
         * digunakan sebelum form disubmit.
         */
        $emailExists = $this->users
            ->where('email', $email)
            ->first();

        if ($emailExists) {
            session()->remove(
                'google_registration'
            );

            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Email tersebut sudah terdaftar. Silakan login.'
                );
        }

        /*
         * Cek NIM.
         */
        $nimExists = $this->users
            ->where('nim', $nim)
            ->first();

        if ($nimExists) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'NIM tersebut sudah terdaftar.'
                );
        }

        /*
         * Untuk akun Google, password lokal tidak digunakan.
         * Tetap simpan hash acak karena kolom password aplikasi
         * digunakan oleh akun lokal.
         */
        $randomPassword = password_hash(
            bin2hex(random_bytes(32)),
            PASSWORD_DEFAULT
        );

        $userData = [
            'nama_lengkap' => $nama,
            'email' => $email,
            'no_hp' => $noHp !== '' ? $noHp : null,
            'password' => $randomPassword,
            'role' => 'mahasiswa',
            'nim' => $nim,
            'foto_profil' => null,
            'id_status_akun' => 1,
            'google_id' => $googleId,
        ];

        $inserted = $this->users->insert(
            $userData
        );

        if (! $inserted) {
            log_message(
                'error',
                'Google register gagal untuk email: {email}',
                [
                    'email' => $email,
                ]
            );

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Pendaftaran akun Polinema gagal. Silakan coba lagi.'
                );
        }

        $user = $this->users
            ->where('google_id', $googleId)
            ->first();

        session()->remove(
            'google_registration'
        );

        return $this->loginUser(
            $user,
            $nama
        );
    }

    /**
     * =========================
     * LOGIN USER KE SESSION
     * =========================
     */
    private function loginUser(
        array $user,
        string $fallbackName = ''
    ) {
        if (
            (int) ($user['id_status_akun'] ?? 1) !== 1
        ) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Akun kamu sudah tidak aktif. Silakan hubungi administrator.'
                );
        }

        session()->regenerate();

        session()->set([
            'logged_in' => true,
            'id_user' => $user['id_user'],
            'nama_lengkap' => $user['nama_lengkap']
                ?: $fallbackName,
            'role' => $user['role'],
            'nim' => $user['nim'],
            'foto_profil' => $user['foto_profil'] ?? '',
        ]);

        if (
            in_array(
                $user['role'],
                ['admin', 'super_admin'],
                true
            )
        ) {
            return redirect()->to('/admin');
        }

        return redirect()->to('/mahasiswa');
    }

    /**
     * =========================
     * PROSES LOGIN LOKAL
     * =========================
     */
    public function attempt()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $email = trim(
            (string) $this->request->getPost('email')
        );

        $password = (string) $this->request->getPost('password');

        $user = $this->users
            ->where('email', $email)
            ->first();

        if (
            ! $user ||
            ! password_verify(
                $password,
                $user['password']
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Email atau password salah.'
                );
        }

        if (
            (int) ($user['id_status_akun'] ?? 1) !== 1
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Akun kamu sudah tidak aktif. Silakan hubungi administrator.'
                );
        }

        session()->regenerate();

        session()->set([
            'logged_in' => true,
            'id_user' => $user['id_user'],
            'nama_lengkap' => $user['nama_lengkap'],
            'role' => $user['role'],
            'nim' => $user['nim'],
            'foto_profil' => $user['foto_profil'] ?? '',
        ]);

        if (
            in_array(
                $user['role'],
                ['admin', 'super_admin'],
                true
            )
        ) {
            return redirect()->to('/admin');
        }

        return redirect()->to('/mahasiswa');
    }

    /**
     * =========================
     * LOGOUT
     * =========================
     */
    public function logout()
    {
        session()->destroy();

        return redirect()
            ->to('/login')
            ->with(
                'success',
                'Berhasil logout.'
            );
    }
}
