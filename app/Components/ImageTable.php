<?php


namespace App\Components;


use App\Models\Image;
use Illuminate\Support\Str;

class ImageTable
{
    public static function save(object $image, int $id, string $type): string
    {
        $image_name = Str::slug($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $image_path = '/images/';

        switch ($type) {
            case 'product':
                $image_path .= 'products/';
                break;
            case 'slider':
                $image_path .= 'sliders/';
                break;
            case 'category':
                $image_path .= 'categories/';
                break;
        }

        $image_row = Image::where('title', 'LIKE', "%$image_name")->first();

        if (!is_null($image_row)) {
            $image_name = Str::random(12) .'.'.$image->getClientOriginalExtension();
        }

        $image->move(public_path() . $image_path, $image_name);

        Image::create(['title' => $image_path . $image_name, $type . '_id' => $id]);

        /*if ($type === 'slider' || $type === 'category') {
            Image::where($type.'_id', $id)->delete();
        }

        if (is_null($image_row)) {

            $new_image_row = new Image(['title' => $image_path . $image_name, $type . '_id' => $id]);
            $new_image_row->save();

        } else {

            $image_row->update([$type . '_id' => $id]);

        }*/

        return $image_path . $image_name;

    }
}
