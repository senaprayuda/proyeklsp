<?php

namespace App\Models;

use CodeIgniter\Model;

class MusikModel extends Model
{
    protected $table = 'musik';
    protected $useTimestamps = true;
    protected $allowedFields = ['judul', 'slug', 'penyanyi', 'sampul', 'tahun', 'link'];

    public function getMusik($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
