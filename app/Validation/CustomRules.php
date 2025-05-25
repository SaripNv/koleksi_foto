<?php

namespace App\Validation;

class CustomRules
{
    /**
     * Memastikan jumlah file upload tidak melebihi batas
     */
    public function max_count($str, string $params, array $data): bool
    {
        // Jika $str null, abaikan validasi
        if ($str === null || $str === '') {
            return true;
        }

        [$field, $limit] = explode(',', $params);
        
        if (!isset($data[$field])) {
            return true; // Tidak ada file di form
        }

        $files = $data[$field];

        // Jika bukan array (misalnya dari multiple input), jadikan array
        if (!is_array($files)) {
            $files = [$files];
        }

        // Hitung jumlah file yang valid
        $count = count(array_filter($files, function ($file) {
            return $file instanceof \CodeIgniter\HTTP\Files\UploadedFile && $file->isValid();
        }));

        return $count <= (int)$limit;
    }
}