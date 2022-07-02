<?php

namespace App\Controllers;


use App\Models\MusikModel;

class Musik extends BaseController
{
    protected $musikModel;

    public function __construct()
    {
        $this->musikModel = new MusikModel();
    }

    public function index()
    {
        // $komik = $this->komikModel->findAll();

        $data = [
            'title' => 'Daftar Musik',
            'musik' => $this->musikModel->getMusik()
        ];

        return view('musik/index', $data);
    }

    public function detail($slug)
    {


        $data = [
            'title' => 'Detail Musik',
            'musik' =>  $this->musikModel->getMusik($slug)
        ];

        // jika komik tidak ada di tabel

        if (empty($data['musik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul musik ' . $slug . ' tidak ditemukan');
        }

        return view('musik/detail', $data);
    }



    public function create()
    {
        // session();
        $data = [
            'title' => 'Form Tambah Data musik',
            'validation' => \Config\Services::validation()
        ];

        return view('musik/create', $data);
    }



    public function save()
    {
        $request = service('request');

        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[musik.judul]',
                'errors' => [
                    'required' => '{field} musik harus diisi',
                    'is_unique' => '{field} musik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]

        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('/musik/create')->withInput();
        }

        // ambil gambar
        $fileSampul = $request->getFile('sampul');

        // apakah tidak ada gambar yang diupload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            // generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();

            // pindahkan file ke folder img
            $fileSampul->move('img', $namaSampul);
            // $fileSampul->move('img');
        }


        $slug = url_title($request->getVar('judul'), '-', true);

        $this->musikModel->save([
            'judul' => $request->getVar('judul'),
            'slug' => $slug,
            'penyanyi' => $request->getVar('penyanyi'),
            'tahun' => $request->getVar('tahun'),
            'link' => $request->getVar('link'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/musik');
    }



    public function delete($id)
    {
        // cari gambar berdasarkan id
        $musik = $this->musikModel->find($id);

        // cek jika file gambarnya default
        if ($musik['sampul'] != 'default.jpg') {

            // hapus gambar
            unlink('img/' . $musik['sampul']);
        }


        $this->musikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/musik');
    }




    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Musik',
            'validation' => \Config\Services::validation(),
            'musik' => $this->musikModel->getMusik($slug)
        ];

        return view('musik/edit', $data);
    }




    public function update($id)
    {
        $request = service('request');

        // cek judul
        $musikLama = $this->musikModel->getMusik($request->getVar('slug'));
        if ($musikLama['judul'] == $request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[musik.judul]';
        }

        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} musik harus diisi',
                    'is_unique' => '{field} musik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to('/musik/edit/' . $request->getVar('slug'))->withInput();
        }

        $fileSampul = $request->getFile('sampul');

        // cek gambar apakah gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $request->getVar('sampulLama');
        } else {
            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan gambar
            $fileSampul->move('img', $namaSampul);
            // hapus file lama
            unlink('img/' . $request->getVar('sampulLama'));
        }


        $slug = url_title($request->getVar('judul'), '-', true);

        $this->musikModel->save([
            'id' => $id,
            'judul' => $request->getVar('judul'),
            'slug' => $slug,
            'penyanyi' => $request->getVar('penyanyi'),
            'tahun' => $request->getVar('tahun'),
            'link' => $request->getVar('link'),
            'sampul' => $namaSampul
        ]);
        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('/musik');
    }
}
