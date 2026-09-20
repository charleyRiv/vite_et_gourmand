<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class CloudinaryService
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
                    'api_key'    => $_ENV['CLOUDINARY_API_KEY'],
                    'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
                ],
                'url' => [
                    'secure' => true
                ]
            ])
        );
    }

    public function upload(string $filePath, string $folder = 'vite-et-gourmand'): ?string
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload($filePath, [
                'folder' => $folder
            ]);
            return $result['secure_url'];
        } catch (\Exception $e) {
            error_log('Cloudinary upload error: ' . $e->getMessage());
            return null;
        }
    }

    public function delete(string $publicId): bool
    {
        try {
            $this->cloudinary->uploadApi()->destroy($publicId);
            return true;
        } catch (\Exception $e) {
            error_log('Cloudinary delete error: ' . $e->getMessage());
            return false;
        }
    }
}