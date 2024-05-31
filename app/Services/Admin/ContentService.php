<?php

namespace App\Services\Admin;

use App\Models\Content;
use App\Traits\FileTrait;

class ContentService
{
    use FileTrait;
    public function one(int $id)
    {
        return Content::findOrFail($id);
    }

    public function create(array $data): bool
    {
        $photoName = '';
        if (!empty($data['photo'])) {
            $photoName = $this->fileUpload($data['photo']);
        }

        $videoName = '';
        if (!empty($data['video'])) {
            $videoName = $this->fileUpload($data['photo'],'video');
        }

        Content::create([
            'plan_id' => $data['plan_id'],
            'text' => $data['text'] ?? "",
            'video' => $videoName,
            'photo' => $photoName,
            'url' => $data['url'] ?? "",
        ]);

        return true;
    }

    public function update(array $data, int $id): int
    {
        $user = Content::findOrfail($id);

        if (!empty($data['video']))
            $user->fill(['video' => $data['video']]);

        if (!empty($data['photo']))
            $user->fill(['photo' => $data['photo']]);

        if (!empty($data['url']))
            $user->fill(['url' => $data['url']]);

        if (!empty($data['text']))
            $user->fill(['text' => $data['text']]);

        $user->save();
        return $id;
    }

    public function delete(int $id)
    {
        return Content::destroy($id);
    }


}
