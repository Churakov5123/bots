<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Image\Services;

use App\Bot\Dating\Data\Entity\Image;
use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Image\Repository\ImageRepository;
use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;

class ImageHandler
{
    private const IMG_BASE_PATH = 'storage/photo';
    private const IMG_BASE_FORMAT = '.jpeg';

    public function __construct(private ImageRepository $imageRepository
    ) {
    }

    public function execute(Profile $profile, CreateProfileDto $dto, string $base64Content): void
    {
        // validation image тут будет какоего ограничение на максимальный размер! подумать- если ок то пускаем далее
        $newImage = $this->makeImage($dto, $profile);
        $profile->addImage($newImage);
        //  логика по обрезке и декодированию и сохранению в стору исходя из пути
        $this->uploadImage($base64Content, $newImage);
    }

    private function makeImage(CreateProfileDto $dto, Profile $profile): Image
    {
        $name = uniqid();
        $path = sprintf('%s/%s/', self::IMG_BASE_PATH, $dto->getLogin());

        if (!file_exists($path)) {
            try {
                mkdir($path, 0777, true);
            } catch (\Exception $e) {
            }
        }

        $image = new Image(
            $name,
            $path,
            $profile
        );

        $this->imageRepository->save($image);

        return $image;
    }

    public function deleteImages(Profile $profile): void
    {
        $result = $this->imageRepository->getImagesByProfile($profile);

        if (empty($result)) {
            return;
        }

        foreach ($result as $image) {
            $this->imageRepository->delete($image);
        }
    }

    private function uploadImage(string $base64Content, Image $image): void
    {
        file_put_contents(sprintf('%s%s%s', $image->getPath(), $image->getName(), self::IMG_BASE_FORMAT), file_get_contents($base64Content));
    }
}
