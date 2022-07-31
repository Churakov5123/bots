<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Image\Services;

use App\Bot\Dating\Data\Entity\Image;
use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Image\Repository\ImageRepository;
use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageHandler
{
    private const IMG_BASE_FORMAT = 'png';
    private const IMG_BASE_PATH = 'png';

    public function __construct(private ImageRepository $imageRepository
    ) {
    }

    public function execute(Profile $profile, CreateProfileDto $dto, UploadedFile $image)
    {
        // validation image тут будет какоего ограничение на максимальный размер! подумать- если ок то пускаем далее
        $newImage = $this->makeImage($dto, $profile);

        // логика по обрезке и декодированию и сохранению в стору исходя из пути
        $prepareImage = $this->prepareImage($image);

        // тут перемещене файла в стор его загрузка
        $this->uploadImage($prepareImage, $newImage);
    }

    private function makeImage(CreateProfileDto $dto, Profile $profile)
    {
        $image = new Image(
            sprintf('%s_%s.jpg', $dto->getLogin(), uniqid()),
            self::IMG_BASE_PATH.$dto->getLogin().'/'.sprintf('%s_%s.%s', $dto->getLogin(), uniqid(), self::IMG_BASE_FORMAT),
            $profile
        );

        $this->imageRepository->save($image);

        return $image;
    }

    private function prepareImage(UploadedFile $image): UploadedFile
    {
        return $image;
    }

    private function uploadImage(UploadedFile $prepareImage, Image $image): void
    {
        $prepareImage->move($image->getPath(), $image->getName());
    }
}
